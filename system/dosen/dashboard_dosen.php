<?php
session_start();

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

require 'koneksi.php';

$nid = $_SESSION['nid'];
$sql = "SELECT * FROM dosen WHERE nid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Dosen - Sistem Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f8ff;
            color: #333;
            display: flex;
            height: 100vh;
        }

        /* Sidebar kiri */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1E3C72, #2A5298);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.15);
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link {
            width: 85%;
            padding: 12px 16px;
            margin: 8px 0;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background 0.3s, transform 0.2s;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 18px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
        }

        /* Konten utama */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .container {
            max-width: 800px;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #1E3C72;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: white;
            border-bottom: 2px solid #2A5298;
            padding-bottom: 6px;
            margin-bottom: 20px;
        }

        /* ===================== FORM STYLING ===================== */
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 25px;
            margin-top: 15px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #2A5298;
            font-size: 18px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border-radius: 10px;
            border: 1px solid #cbd5ff;
            background: #f8faff;
            font-size: 15px;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }

        input:hover,
        select:hover,
        textarea:hover {
            transform: scale(1.01);
            border-color: #a4b5ff;
            background-color: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #2A5298;
            box-shadow: 0 0 10px rgba(42, 82, 152, 0.2);
            outline: none;
            background: #fff;
        }

        textarea {
            resize: none;
            min-height: 90px;
            grid-column: 1 / 3;
        }

        .full-width {
            grid-column: 1 / 3;
        }

        .button-container {
            grid-column: 1 / 3;
            text-align: right;
            margin-top: 15px;
        }

        button {
            background: linear-gradient(90deg, #2A5298, #1E3C72);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(42, 82, 152, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(30, 60, 114, 0.4);
        }

        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;
            }

            .button-container {
                text-align: center;
            }
        }

        /* ===================== TABEL PROFIL ===================== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 12px 16px;
            border-bottom: 1px solid #e0e7ff;
            text-align: left;
        }

        th {
            background: #2A5298;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        tr:hover td {
            background: #f1f5ff;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>DOSEN</h2>
        <a href="#" class="nav-link active" onclick="showSection('profile'); return false;">
            <i class="bi bi-person-circle"></i> Profil
        </a>
        <a href="#" class="nav-link" onclick="showSection('editProfileForm'); return false;">
            <i class="bi bi-pencil-square"></i> Edit Profil
        </a>
        <a href="jadwal.php" class="nav-link">
            <i class="bi bi-calendar-week"></i> Jadwal
        </a>
        <a href="daftar_matakuliah.php" class="nav-link">
            <i class="bi bi-journal-text"></i> Nilai
        </a>
        <a href="logout.php" class="nav-link">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <!-- Profil -->
        <div id="profile" class="container content-section">
            <h1>Dashboard Sistem Akademik</h1>
            <h2>Profil Dosen</h2>
            <table>
                <tr>
                    <th>Nama</th>
                    <td><?= htmlspecialchars($user['nama']); ?></td>
                </tr>
                <tr>
                    <th>NID</th>
                    <td><?= htmlspecialchars($user['nid']); ?></td>
                </tr>
                <!-- <tr>
                    <th>Fakultas</th>
                    <td><?= htmlspecialchars($user['fakultas']); ?></td>
                </tr> -->
                <tr>
                    <th>Program Studi</th>
                    <td><?= htmlspecialchars($user['prodi']); ?></td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td><?= htmlspecialchars($user['jenis_kelamin']); ?></td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td><?= htmlspecialchars($user['tanggal_lahir']); ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= htmlspecialchars($user['alamat']); ?></td>
                </tr>
            </table>
        </div>

        <!-- Edit Profil -->
        <div id="editProfileForm" class="container content-section" style="display:none;">
            <h2>Edit Profil</h2>
            <form action="edit_dosen_profile.php" method="post">
                <div class="input-wrapper">
                    <i class="bi bi-person"></i>
                    <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
                </div>
                <div class="input-wrapper">
                    <i class="bi bi-upc-scan"></i>
                    <input type="text" name="nid" value="<?= htmlspecialchars($user['nid']); ?>" readonly>
                </div>
                <!-- <div class="input-wrapper">
                    <i class="bi bi-bank"></i>
                    <input type="text" name="fakultas" value="<?= htmlspecialchars($user['fakultas']); ?>" required>
                </div> -->
                <div class="input-wrapper">
                    <i class="bi bi-mortarboard"></i>
                    <input type="text" name="prodi" value="<?= htmlspecialchars($user['prodi']); ?>" readonly>
                </div>
                <div class="input-wrapper">
                    <i class="bi bi-gender-ambiguous"></i>
                    <select name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?= $user['jenis_kelamin'] === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= $user['jenis_kelamin'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="input-wrapper">
                    <i class="bi bi-calendar3"></i>
                    <input type="date" name="tanggal_lahir" value="<?= $user['tanggal_lahir']; ?>" required>
                </div>
                <div class="input-wrapper full-width">
                    <i class="bi bi-geo-alt"></i>
                    <textarea name="alamat" rows="4" required><?= htmlspecialchars($user['alamat']); ?></textarea>
                </div>
                <div class="button-container">
                    <button type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';

            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            const activeLink = [...document.querySelectorAll('.nav-link')]
                .find(a => a.onclick && a.onclick.toString().includes(sectionId));
            if (activeLink) activeLink.classList.add('active');
        }
    </script>
</body>

</html>
