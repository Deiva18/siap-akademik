<?php
require 'koneksi.php';

session_start();

$nid = $_POST['nid'];
$password = $_POST['password'];

$sql = "SELECT * FROM dosen WHERE nid = ? AND password = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("ss", $nid, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['nid'] = $nid;
    header("Location: dashboard_dosen.php");
    exit();
} else {
    $_SESSION['login_error'] = "NID atau password salah.";
    header("Location: login_dosen.php");
    exit();
}
