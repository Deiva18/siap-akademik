<?php
session_start();

$registered_nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($registered_nama === 'admin' && $password === 'admin') {
    $_SESSION['admin_logged_in'] = true;

    header("Location: dashboard_admin.php");
    exit();
} else {
    $_SESSION['login_error'] = "Nama atau password salah.";
    header("Location: index.php");
    exit();
}
