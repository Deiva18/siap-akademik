<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$nim = $_SESSION['nim'];

// Validasi file
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    die("Upload gagal.");
}

$file = $_FILES['foto'];
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$allowed = ['jpg','jpeg','png'];

if (!in_array(strtolower($ext), $allowed)) {
    die("Format file harus JPG, JPEG, atau PNG.");
}

if ($file['size'] > 2 * 1024 * 1024) { 
    die("Ukuran file maks 2MB.");
}

// Nama file baru (unik)
$filename = $nim . "_" . time() . "." . $ext;
$destination = "uploads/" . $filename;

// Upload
if (!move_uploaded_file($file['tmp_name'], $destination)) {
    die("Gagal menyimpan file.");
}

// Update database
$sql = "UPDATE data_mahasiswa SET foto=? WHERE nim=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $filename, $nim);

if ($stmt->execute()) {
    echo "<script>alert('Foto berhasil diperbarui!'); window.location.href='dashboard.php';</script>";
} else {
    echo "Gagal update database.";
}
?>
