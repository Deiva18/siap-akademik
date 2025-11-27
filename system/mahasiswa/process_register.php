<?php
require 'koneksi.php';

session_start();

$nama = $_POST['nama'];
$fakultas = $_POST['fakultas'];
$prodi = $_POST['prodi'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$password = $_POST['password'];

if (empty($nama) || empty($fakultas) || empty($prodi) || empty($jenis_kelamin) || empty($tanggal_lahir) || empty($alamat) || empty($password)) {
    die("Error: Semua bidang harus diisi.");
}

$update_sql = "UPDATE fakultas_increment SET increment_id = increment_id + 1 WHERE fakultas = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("s", $fakultas);
$update_stmt->execute();
$update_stmt->close();

$select_sql = "SELECT increment_id FROM fakultas_increment WHERE fakultas = ?";
$select_stmt = $conn->prepare($select_sql);
$select_stmt->bind_param("s", $fakultas);
$select_stmt->execute();
$result = $select_stmt->get_result();
$row = $result->fetch_assoc();
$select_stmt->close();
if (!$row) {
    die("Error: increment_id not found for fakultas: $fakultas");
}

$increment_id = $row['increment_id'];

switch ($fakultas) {
    case 'FAKULTAS TEKNOLOGI INFORMASI':
        $prefix = '111';
        break;
    case 'FAKULTAS HUKUM':
        $prefix = '333';
        break;
    case 'FAKULTAS TEKNIK':
        $prefix = '222';
        break;
    default:
        die("Error: Fakultas tidak dikenali.");
}

$nim = $prefix . sprintf('%04d', $increment_id);

$insert_sql = "INSERT INTO data_mahasiswa (nama, fakultas, prodi, nim, jenis_kelamin, tanggal_lahir, alamat, password)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("ssssssss", $nama, $fakultas, $prodi, $nim, $jenis_kelamin, $tanggal_lahir, $alamat, $password);

if ($insert_stmt->execute()) {
    $_SESSION['registered_nim'] = $nim;
    header("Location: login.php");
    exit();
} else {
    echo "Error: " . $insert_stmt->error;
}

$insert_stmt->close();
$conn->close();
