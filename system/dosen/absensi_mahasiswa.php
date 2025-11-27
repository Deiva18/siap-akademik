<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

$nid_dosen = $_SESSION['nid'];
$id_matakuliah = $_GET['id'];

$sql = "SELECT m.id, m.nama 
        FROM krs k 
        JOIN data_mahasiswa m ON k.nim = m.nim 
        WHERE k.kode_matakuliah = (SELECT kode_matakuliah FROM matakuliah WHERE id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_matakuliah);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['kehadiran']) && is_array($_POST['kehadiran'])) {
        $errors = [];
        foreach ($_POST['kehadiran'] as $id_mahasiswa => $kehadiran) {
            if (!empty(trim($kehadiran))) {
                $sql_insert = "INSERT INTO absensi (id_mahasiswa, id_matakuliah, kehadiran) 
                               VALUES (?, ?, ?) 
                               ON DUPLICATE KEY UPDATE kehadiran = ?";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ssss", $id_mahasiswa, $id_matakuliah, $kehadiran, $kehadiran);
                if (!$stmt_insert->execute()) {
                    $errors[] = "Gagal menyimpan kehadiran untuk mahasiswa ID $id_mahasiswa: " . htmlspecialchars($stmt_insert->error);
                }
                $stmt_insert->close();
            } else {
                $errors[] = "Kehadiran untuk mahasiswa dengan ID $id_mahasiswa tidak boleh kosong.";
            }
        }
        if (empty($errors)) {
            $messages['success'] = "Kehadiran berhasil disimpan.";
        } else {
            $messages['errors'] = $errors;
        }
    } else {
        $messages['errors'] = ["Form kehadiran tidak valid atau kosong."];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Absensi Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6ff;
            margin: 0;
            padding: 20px;
        }

        .header-text {
            text-align: center;
            color: white;
            background-color: #10375C;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 1.5em;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #10375C;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e8f0fe;
            transition: background-color 0.3s;
        }

        input.status-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input.status-input:focus {
            border-color: #637AB9;
            outline: none;
            box-shadow: 0 0 5px #637AB9;
        }

        .submit-btn {
            background-color: #2A5298;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
            display: block;
            margin: 10px auto 0 auto;
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.5);
        }

        .submit-btn:hover {
            background-color: #10375C;
        }

        .menu {
            text-align: center;
            margin-top: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #2A5298;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.5);
        }

        .menu a:hover {
            background-color: #10375C;
        }

        .message-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .message-error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header-text">
        Absensi Mahasiswa untuk Matakuliah ID: <?= htmlspecialchars($id_matakuliah); ?>
    </div>

    <?php if (!empty($messages['success'])): ?>
        <div class="message-success"><?= htmlspecialchars($messages['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($messages['errors'])): ?>
        <?php foreach ($messages['errors'] as $error): ?>
            <div class="message-error"><?= htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td>
                                <input type="text" name="kehadiran[<?= htmlspecialchars($row['id']); ?>]" class="status-input" placeholder="Masukkan status kehadiran" required />
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" style="text-align:center; font-style: italic; color: #666;">
                            Tidak ada mahasiswa yang terdaftar dalam matakuliah ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <input type="submit" value="Simpan Absensi" class="submit-btn" />
    </form>

    <div class="menu">
        <a href="dashboard_dosen.php">Kembali ke Dashboard</a>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
