<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['add'])) {
    die("Tidak ada data yang dikirimkan.");
}

$course_id = $_POST['add'];
$nim = $_SESSION['nim'];

require 'koneksi.php';

// Ambil data mata kuliah
$sql_course = "SELECT * FROM matakuliah WHERE id = ?";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();

if ($result_course->num_rows == 1) {

    $course = $result_course->fetch_assoc();

    // Cegah error jika session belum terbentuk
    if (!isset($_SESSION['krs_temp'])) {
        $_SESSION['krs_temp'] = [];
    }

    // Cek apakah sudah ditambahkan sebelumnya
    foreach ($_SESSION['krs_temp'] as $krs_course) {
        if ($krs_course['id'] == $course_id) {
            die("Mata kuliah sudah ada di KRS sementara.");
        }
    }

    // -----------------------------
    // FITUR CEK BENTROK JADWAL
    // -----------------------------
    $hari_baru = $course['hari'];
    $jam_baru  = $course['jam'];

    foreach ($_SESSION['krs_temp'] as $krs_course) {
        if ($krs_course['hari'] == $hari_baru && $krs_course['jam'] == $jam_baru) {
            
            // Jika bentrok, hentikan proses
            echo "<script>
                alert('Jadwal bentrok! Mata kuliah lain memiliki hari dan jam yang sama.');
                window.location.href = '{$_SERVER['HTTP_REFERER']}';
            </script>";
            exit();
        }
    }

    // Jika tidak bentrok → tambahkan ke session
    $_SESSION['krs_temp'][] = [
        'id' => $course['id'],
        'kode_matakuliah' => $course['kode_matakuliah'],
        'nama_matakuliah' => $course['nama_matakuliah'],
        'sks' => $course['sks'],
        'dosen_pengampu' => $course['dosen_pengampu'],
        'hari' => $course['hari'],
        'jam' => $course['jam'],
        'ruangan' => $course['ruangan']
    ];

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();

} else {
    die("Mata kuliah tidak ditemukan.");
}
