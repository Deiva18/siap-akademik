<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid.");
}

$id_dosen      = $_POST['id_dosen'];
$nama          = $_POST['nama'];
$nid           = $_POST['nid'];
$kode_dosen    = $_POST['kode_dosen'];
$prodi         = $_POST['prodi'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat        = $_POST['alamat'];
$password      = $_POST['password'];

// Jika password dikosongkan, jangan update password
if (!empty($password)) {

    $sql = "UPDATE dosen SET 
                nama=?, 
                nid=?, 
                kode_dosen=?, 
                prodi=?, 
                jenis_kelamin=?, 
                tanggal_lahir=?, 
                alamat=?, 
                password=? 
            WHERE id_dosen=?";

    $stmt = $conn->prepare($sql);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bind_param(
        "ssssssssi",
        $nama,
        $nid,
        $kode_dosen,
        $prodi,
        $jenis_kelamin,
        $tanggal_lahir,
        $alamat,
        $password_hash,
        $id_dosen
    );

} else {

    $sql = "UPDATE dosen SET 
                nama=?, 
                nid=?, 
                kode_dosen=?, 
                prodi=?, 
                jenis_kelamin=?, 
                tanggal_lahir=?, 
                alamat=? 
            WHERE id_dosen=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssi",
        $nama,
        $nid,
        $kode_dosen,
        $prodi,
        $jenis_kelamin,
        $tanggal_lahir,
        $alamat,
        $id_dosen
    );
}

if ($stmt->execute()) {
    header("Location: data_dosen.php?success=1");
    exit();
} else {
    echo "Gagal update data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>