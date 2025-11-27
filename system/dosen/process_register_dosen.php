<?php

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $kode_dosen = $_POST['kode_dosen'];

    switch ($fakultas) {
        case 'FAKULTAS TEKNOLOGI INFORMASI':
            $kodeFakultas = 'FT';
            break;
        case 'FAKULTAS TEKNIK':
            $kodeFakultas = 'TK';
            break;
        case 'FAKULTAS HUKUM':
            $kodeFakultas = 'HK';
            break;
        default:
            $kodeFakultas = 'OTH';
            break;
    }

    switch ($prodi) {
        case 'Informatika':
            $kodeProdi = 'TI';
            break;
        case 'Sistem Informasi':
            $kodeProdi = 'SI';
            break;
        case 'Pendidikan Teknologi Informasi':
            $kodeProdi = 'PTI';
            break;
        case 'Industri':
            $kodeProdi = 'IND';
            break;
        case 'Kimia':
            $kodeProdi = 'KIM';
            break;
        case 'Sipil':
            $kodeProdi = 'SIP';
            break;
        case 'Hukum':
            $kodeProdi = 'HUK';
            break;
        default:
            $kodeProdi = 'OTH';
            break;
    }

    $nid = $kodeFakultas . '-' . $kodeProdi . '-' . rand(10000, 99999);

    $stmt = $conn->prepare("INSERT INTO dosen (nama, fakultas, prodi, jenis_kelamin, tanggal_lahir, alamat, password, kode_dosen, nid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nama, $fakultas, $prodi, $jenis_kelamin, $tanggal_lahir, $alamat, $password, $kode_dosen, $nid);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'nid' => $nid]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register: ' . mysqli_error($conn)]);
    }

    $stmt->close();
    $conn->close();

    header("Location: login_dosen.php?nid=" . $nid);
    exit();
}
