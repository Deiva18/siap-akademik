<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];

$mata_kuliah = $_POST['mata_kuliah'];
$nama = $_POST['nama'];
$sks = $_POST['sks'];
$dosen_pengampu = $_POST['dosen_pengampu'];
$semester = $_POST['semester'];

$sql = "INSERT INTO krs (nim, mata_kuliah, nama, sks, dosen_pengampu, semester) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisi", $nim, $mata_kuliah, $nama, $sks, $dosen_pengampu, $semester);

if ($stmt->execute()) {
    echo "KRS berhasil ditambahkan!";
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: krs.php");
exit();
