<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nid = $_POST['nid'];
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE dosen SET nama=?, fakultas=?, prodi=?, jenis_kelamin=?, tanggal_lahir=?, alamat=? WHERE nid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nama, $fakultas, $prodi, $jenis_kelamin, $tanggal_lahir, $alamat, $nid);

    if ($stmt->execute()) {
        echo "Profil berhasil diubah.";
        header("Location: dashboard_dosen.php");
        exit();
    } else {
        echo "Gagal mengubah profil: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
