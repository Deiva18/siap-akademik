<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

// ================================
// FUNGSI WARNA OTOMATIS PER HARI
// ================================
function warnaHari($hari)
{
    switch ($hari) {
        case "Senin": return "#d1e7dd";  // hijau muda
        case "Selasa": return "#cff4fc"; // biru muda
        case "Rabu": return "#fde2e4";   // pink
        case "Kamis": return "#fff3cd";  // kuning
        case "Jumat": return "#e2e3ff";  // ungu
        default: return "#f8f9fa";
    }
}

// ===========================================
// LOGIC FILTER & SEARCH
// ===========================================
$query = "SELECT * FROM krs WHERE nim = ?";
$params = [$nim];
$types = "s";

// Jika melakukan pencarian
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $keyword = "%" . $_GET['cari'] . "%";
    $query .= " AND (nama_matakuliah LIKE ? OR hari LIKE ? OR dosen_pengampu LIKE ?)";
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $types .= "sss";
}

// Jika melakukan filter berdasarkan hari
if (isset($_GET['hari']) && $_GET['hari'] != "") {
    $hari = $_GET['hari'];
    $query .= " AND hari = ?";
    $params[] = $hari;
    $types .= "s";
}

$stmt = $conn->prepare($query);

// binding parameter flexible
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();
$jadwal = [];
while ($row = $result->fetch_assoc()) {
    $jadwal[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
    <link rel="stylesheet" href="global_css/dashboard.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4ff;
            padding: 20px;
        }

        .container {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #10375C;
        }

        /* Form Pencarian & Filter */
        .filter-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-box input,
        .filter-box select {
            padding: 10px;
            width: 48%;
            border-radius: 10px;
            border: 1px solid #aaa;
        }

        .filter-box button {
            padding: 10px 20px;
            border: none;
            background: #10375C;
            color: white;
            border-radius: 10px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #10375C;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .menu {
            margin-top: 20px;
            text-align: center;
        }

        .menu a {
            padding: 10px 25px;
            background: #10375C;
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }

        .print-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #10375C;
    color: white !important;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 15px;
    text-decoration: none;
    transition: 0.3s;
    margin: 0 auto;
}

.print-btn:hover {
    background: #0c2640;
}

.print-wrapper {
    text-align: center;
    margin-bottom: 20px;
}

    </style>
</head>

<body>

<div class="container">

    <h1>Jadwal Kuliah</h1>

    <!-- Tombol Cetak -->
    <div class="print-wrapper">
    <a class="print-btn" href="print_jadwal.php" target="_blank">
        🖨️ <span>Cetak Jadwal</span>
    </a>
</div>

    <!-- FORM SEARCH & FILTER -->
    <form method="GET" class="filter-box">
        <input type="text" name="cari" placeholder="Cari matkul / dosen..." 
               value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">

        <select name="hari">
            <option value="">Semua Hari</option>
            <option value="Senin" <?= (isset($_GET['hari']) && $_GET['hari']=="Senin") ? "selected" : "" ?>>Senin</option>
            <option value="Selasa" <?= (isset($_GET['hari']) && $_GET['hari']=="Selasa") ? "selected" : "" ?>>Selasa</option>
            <option value="Rabu" <?= (isset($_GET['hari']) && $_GET['hari']=="Rabu") ? "selected" : "" ?>>Rabu</option>
            <option value="Kamis" <?= (isset($_GET['hari']) && $_GET['hari']=="Kamis") ? "selected" : "" ?>>Kamis</option>
            <option value="Jumat" <?= (isset($_GET['hari']) && $_GET['hari']=="Jumat") ? "selected" : "" ?>>Jumat</option>
        </select>

        <button type="submit">Terapkan</button>
    </form>

    <!-- TABEL JADWAL -->
    <?php if (!empty($jadwal)): ?>
        <table>
            <tr>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Dosen</th>
            </tr>

            <?php foreach ($jadwal as $item): ?>
                <tr style="background: <?= warnaHari($item['hari']); ?>;">
                    <td><?= htmlspecialchars($item['kode_matakuliah']); ?></td>
                    <td><?= htmlspecialchars($item['nama_matakuliah']); ?></td>
                    <td><?= htmlspecialchars($item['hari']); ?></td>
                    <td><?= htmlspecialchars($item['jam']); ?></td>
                    <td><?= htmlspecialchars($item['ruangan']); ?></td>
                    <td><?= htmlspecialchars($item['dosen_pengampu']); ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>
        <p style="text-align:center; margin-top:20px;">Tidak ada jadwal ditemukan.</p>
    <?php endif; ?>

    <div class="menu">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>

</div>

</body>
</html>
