<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_SESSION['nim'];
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    // Ambil foto lama dari database
    $result = $conn->query("SELECT foto FROM data_mahasiswa WHERE nim='$nim'");
    $row = $result->fetch_assoc();
    $foto_lama = $row['foto'];

    // Cek apakah user upload foto baru
    $foto_baru = $foto_lama;

    if (!empty($_FILES['foto']['name'])) {

        // folder upload
        $upload_dir = "uploads/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Nama file baru (menghindari bentrok)
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_file_baru = $nim . "_" . time() . "." . $ext;

        $target_file = $upload_dir . $nama_file_baru;

        // Upload file
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {

            // Hapus foto lama jika ada
            if (!empty($foto_lama) && file_exists($upload_dir . $foto_lama)) {
                unlink($upload_dir . $foto_lama);
            }

            $foto_baru = $nama_file_baru;
        }
    }

    // Update database
    $sql = "UPDATE data_mahasiswa 
            SET nama=?, fakultas=?, prodi=?, jenis_kelamin=?, tanggal_lahir=?, alamat=?, foto=? 
            WHERE nim=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", 
        $nama, $fakultas, $prodi, $jenis_kelamin, 
        $tanggal_lahir, $alamat, $foto_baru, $nim
    );

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Gagal mengubah profil: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
