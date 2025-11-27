<?php
require 'koneksi.php';

session_start();

$nim = $_POST['nim'];
$password = $_POST['password'];

$sql = "SELECT * FROM data_mahasiswa WHERE nim = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nim, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['nim'] = $nim;
    header("Location: dashboard.php");
    exit();
} else {
    $_SESSION['login_error'] = "NIM atau password salah.";
    header("Location: login.php");
    exit();
}
