<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

require 'koneksi.php';

$kode_matakuliah = $_POST['kode_matakuliah'];
$nama_matakuliah = $_POST['nama_matakuliah'];
$sks = $_POST['sks'];
$fakultas = $_POST['fakultas'];
$prodi = $_POST['prodi'];
$ruangan = $_POST['ruangan'];
$semester = $_POST['semester'];
$nid_dosen = $_POST['nid_dosen'];
$dosen_pengampu = $_POST['dosen_pengampu'];
$hari = $_POST['hari'];
$jam = $_POST['jam'];

$check_sql = "SELECT COUNT(*) FROM matakuliah WHERE nama_matakuliah = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $nama_matakuliah);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    header("Location: input_matkul.php?error_message=Matakuliah dengan nama tersebut sudah ada");
    exit();
}

$sql = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, sks, fakultas, prodi, ruangan, semester, nid_dosen, dosen_pengampu, hari, jam) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header("Location: input_matkul.php?error_message=Gagal menyiapkan statement: " . $conn->error);
    exit();
}

$stmt->bind_param("ssissssssss", $kode_matakuliah, $nama_matakuliah, $sks, $fakultas, $prodi, $ruangan, $semester, $nid_dosen, $dosen_pengampu, $hari, $jam);
if ($stmt->execute()) {
    header("Location: input_matkul.php?success_message=Data Berhasil ditambahkan");
} else {
    header("Location: input_matkul.php?error_message=Gagal menambahkan data mata kuliah: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
