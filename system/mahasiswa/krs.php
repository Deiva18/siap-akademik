<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

$sql = "SELECT * FROM data_mahasiswa WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $prodi = $user['prodi'];
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

$stmt->close();

if (!isset($_SESSION['krs_temp'])) {
    $_SESSION['krs_temp'] = [];
}

if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    unset($_SESSION['krs_temp'][$index]);
    $_SESSION['krs_temp'] = array_values($_SESSION['krs_temp']);
}

$sql_krs = "SELECT * FROM krs WHERE nim = ?";
$stmt_krs = $conn->prepare($sql_krs);
$stmt_krs->bind_param("s", $nim);
$stmt_krs->execute();
$result_krs = $stmt_krs->get_result();

$krs_exists = false;
$krs_data = [];

if ($result_krs->num_rows > 0) {
    $krs_exists = true;
    while ($row = $result_krs->fetch_assoc()) {
        $krs_data[] = $row;
    }
}

$stmt_krs->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi (KRS)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F4F6FF;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #10375C;
            color: #fff;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #FFD700;
            letter-spacing: 1px;
        }

        p {
            text-align: center;
            font-size: 15px;
            color: #eaeaea;
        }

        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
            background: #fff;
            color: #333;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background: #F3C623;
            color: #10375C;
        }

        table tr:hover {
            background: #f9f9f9;
        }

        .menu {
            text-align: center;
            margin-top: 25px;
        }

        .menu a {
            display: inline-block;
            background: linear-gradient(135deg, #FFD700, #F3C623);
            color: #10375C;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .menu a:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #F3C623, #FFD700);
        }

        .form-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
            margin-top: 20px;
        }

        select, button {
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
        }

        select {
            flex: 1;
            max-width: 200px;
        }

        button {
            background: linear-gradient(135deg, #FFD700, #F3C623);
            color: #10375C;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        button:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #F3C623, #FFD700);
        }
        
        .print-btn {
            background: linear-gradient(135deg, #00ffbb, #00cc88);
            color: #10375C;
            display: inline-block;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .print-btn:hover {
            background: linear-gradient(135deg, #00cc88, #00ffbb);
        }

        .menu-print {
            margin-bottom: 15px;
        }

        h3 {
            color: #FFD700;
            margin-top: 30px;
            text-align: center;
        }

        .total-sks {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
            color: #FFD700;
        }

        @media (max-width: 768px) {
            .container { padding: 20px; }
            table th, table td { font-size: 13px; padding: 8px; }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Kartu Rencana Studi (KRS)</h1>
        <div class="content">
            <?php if ($krs_exists) : ?>
                <p>Anda telah mengambil KRS dengan detail sebagai berikut:</p>
                <table>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Dosen Pengampu</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                    </tr>
                    <?php foreach ($krs_data as $krs) : ?>
                        <tr>
                            <td><?= htmlspecialchars($krs['kode_matakuliah']); ?></td>
                            <td><?= htmlspecialchars($krs['nama_matakuliah']); ?></td>
                            <td><?= htmlspecialchars($krs['sks']); ?></td>
                            <td><?= htmlspecialchars($krs['dosen_pengampu']); ?></td>
                            <td><?= htmlspecialchars($krs['hari']); ?></td>
                            <td><?= htmlspecialchars($krs['jam']); ?></td>
                            <td><?= htmlspecialchars($krs['ruangan']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <div class="menu menu-print">
                    <button onclick="printKRS()" class="print-btn">
                        <i class="fa-solid fa-print"></i> Print KRS
                    </button>
                </div>

                <div class="menu">
                    <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
                </div>

            <?php else : ?>
                <p>Anda belum mengambil KRS.</p>
                <form action="krs.php" method="POST">
                    <div class="form-group">
                        <select id="semester" name="semester" required>
                            <option value="" disabled selected>Pilih Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-eye"></i> Lihat Mata Kuliah</button>
                    </div>
                </form>

                <?php if (isset($_POST['semester'])) : ?>
                    <?php
                    require 'koneksi.php';
                    $semester = $_POST['semester'];

                    $sql_courses = "SELECT * FROM matakuliah WHERE semester = ? AND prodi = ?";
                    $stmt_courses = $conn->prepare($sql_courses);
                    $stmt_courses->bind_param("is", $semester, $prodi);
                    $stmt_courses->execute();
                    $result_courses = $stmt_courses->get_result();
                    $courses = [];

                    while ($row = $result_courses->fetch_assoc()) {
                        $courses[] = $row;
                    }

                    $stmt_courses->close();
                    $conn->close();
                    ?>
                    <?php if (!empty($courses)) : ?>
                        <form action="add_temp_krs.php" method="POST">
                            <table>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php foreach ($courses as $course) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($course['kode_matakuliah']); ?></td>
                                        <td><?= htmlspecialchars($course['nama_matakuliah']); ?></td>
                                        <td><?= htmlspecialchars($course['sks']); ?></td>
                                        <td><?= htmlspecialchars($course['hari']); ?></td>
                                        <td><?= htmlspecialchars($course['jam']); ?></td>
                                        <td>
                                            <button type="submit" name="add" value="<?= $course['id']; ?>">
                                                <i class="fa-solid fa-plus"></i> Tambah
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <input type="hidden" name="semester" value="<?= htmlspecialchars($semester); ?>">
                        </form>
                    <?php else : ?>
                        <p>Tidak ada mata kuliah untuk semester ini.</p>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['krs_temp'])) : ?>
                    <h3>Mata Kuliah yang Dipilih:</h3>
                    <table>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Dosen Pengampu</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $total_sks = 0;
                        foreach ($_SESSION['krs_temp'] as $index => $course) :
                            $total_sks += $course['sks'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($course['kode_matakuliah']); ?></td>
                                <td><?= htmlspecialchars($course['nama_matakuliah']); ?></td>
                                <td><?= htmlspecialchars($course['sks']); ?></td>
                                <td><?= htmlspecialchars($course['hari']); ?></td>
                                <td><?= htmlspecialchars($course['jam']); ?></td>
                                <td><?= htmlspecialchars($course['dosen_pengampu']); ?></td>
                                <td><?= isset($course['ruangan']) ? htmlspecialchars($course['ruangan']) : 'Belum ditentukan'; ?></td>
                                <td>
                                    <form action="krs.php" method="POST">
                                        <input type="hidden" name="index" value="<?= $index; ?>">
                                        <button type="submit" name="delete" style="background:#dc3545;color:#fff;">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <p class="total-sks">Total SKS: <?= $total_sks; ?></p>
                    <div class="menu">
                        <form action="save_krs.php" method="POST">
                            <button type="submit"><i class="fa-solid fa-save"></i> Simpan KRS</button>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function printKRS() {
            const printContent = document.querySelector("table").outerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <h2 style="text-align:center;">Kartu Rencana Studi (KRS)</h2>
                ${printContent}
            `;

            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // Reload halaman agar kembali normal
        }
    </script>
</body>
</html>
