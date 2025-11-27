<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

$sql = "SELECT * FROM krs WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

// Tanggal otomatis
$tanggalSekarang = date("d M Y");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Jadwal Kuliah</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 40px;
            color: #333;
        }

        .header {
            text-align: center;
        }

        .logo {
            width: 95px;
            height: 95px;
            object-fit: contain;
        }

        h2 {
            margin: 5px 0 0 0;
            font-size: 26px;
            color: #10375C;
            text-transform: uppercase;
            font-weight: bold;
        }

        .sub-title {
            font-size: 14px;
            margin-top: 3px;
            color: #444;
        }

        .divider {
            width: 100%;
            height: 3px;
            background: #10375C;
            margin: 20px 0;
        }

        .info {
            text-align: left;
            margin-bottom: 15px;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        th {
            background: #10375C;
            color: white;
            padding: 10px;
            border: 1px solid #777;
        }

        td {
            border: 1px solid #777;
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f0f6ff;
        }

        /* Tanda tangan */
        .ttd {
            margin-top: 40px;
            width: 300px;
            float: right;
            text-align: center;
        }

        .ttd img {
            width: 150px;
            margin-bottom: -10px;
        }

        .footer {
            text-align: center;
            margin-top: 80px;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @media print {
            body { margin: 0; }
            .ttd { margin-top: 60px; }
        }
    </style>
</head>
<body>

<div class="header">
    <img src="logo_jurusan.jpg" class="logo" alt="Logo Jurusan">
    <h2>Jadwal Kuliah Mahasiswa</h2>
    <div class="sub-title">
        Program Studi S1 Pendidikan Teknologi Informasi<br>
        Universitas Negeri Surabaya
    </div>
</div>

<div class="divider"></div>

<div class="info">
    <strong>NIM:</strong> <?= $_SESSION['nim']; ?><br>
    <strong>Tanggal Cetak:</strong> <?= $tanggalSekarang; ?>
</div>

<table>
    <tr>
        <th>Kode MK</th>
        <th>Nama Matakuliah</th>
        <th>Hari</th>
        <th>Jam</th>
        <th>Ruangan</th>
        <th>Dosen Pengampu</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['kode_matakuliah']); ?></td>
            <td><?= htmlspecialchars($row['nama_matakuliah']); ?></td>
            <td><?= htmlspecialchars($row['hari']); ?></td>
            <td><?= htmlspecialchars($row['jam']); ?></td>
            <td><?= htmlspecialchars($row['ruangan']); ?></td>
            <td><?= htmlspecialchars($row['dosen_pengampu']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- TANDA TANGAN KAPRODI -->
<div class="ttd">
    Surabaya, <?= $tanggalSekarang; ?><br>
    <strong>Kaprodi PTI</strong><br><br>
    <img src="ttd_kaprodi.png" alt="Tanda Tangan"><br>
    <strong>Dr. Yeni Anistyasari, S.Pd., M.Kom</strong><br>
    NIP. 0027108403
</div>

<div style="clear: both;"></div>

<!-- FOOTER RESMI -->
<div class="footer">
    Sistem Akademik Universitas Negeri Surabaya • Dicetak otomatis oleh Sistem Akademik<br>
    Dokumen ini sah tanpa tanda tangan basah.
</div>

<script>
    window.print();
</script>

</body>
</html>
