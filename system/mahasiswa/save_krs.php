<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';
$nim = $_SESSION['nim'];

if (isset($_SESSION['krs_temp'])) {
    $krs_temp = $_SESSION['krs_temp'];
} else {
    echo "KRS sementara tidak ditemukan.";
    exit();
}

$sql = "INSERT INTO krs (nim, kode_matakuliah, nama_matakuliah, dosen_pengampu, sks, hari, jam, ruangan) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error dalam persiapan statement SQL: " . $conn->error;
    exit();
}

$stmt->bind_param("ssssisss", $nim, $kode_matakuliah, $nama_matakuliah, $dosen_pengampu, $sks, $hari, $jam, $ruangan);

foreach ($krs_temp as $course) {
    $kode_matakuliah = $course['kode_matakuliah'];
    $nama_matakuliah = $course['nama_matakuliah'];
    $sks = $course['sks'];
    $dosen_pengampu = $course['dosen_pengampu'];
    $hari = $course['hari'];
    $jam = $course['jam'];
    $ruangan = $course['ruangan'];

    $stmt->execute();

    if ($stmt->errno) {
        echo "Error dalam eksekusi statement SQL: " . $stmt->error;
        exit();
    }
}

$stmt->close();
$conn->close();

unset($_SESSION['krs_temp']);
$_SESSION['success_message'] = "KRS berhasil disimpan.";

header("Location: krs.php");
exit();
