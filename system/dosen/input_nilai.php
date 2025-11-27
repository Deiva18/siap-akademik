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

    // Nilai yang diperbolehkan
    $allowed_grades = ['A','A-','B+','B','B-','C','D','E'];

    if (isset($_POST['nilai']) && is_array($_POST['nilai'])) {

        $errors = [];

        foreach ($_POST['nilai'] as $id_mahasiswa => $nilai) {

            $nilai = trim($nilai);

            // Cek kosong
            if ($nilai === '') {
                $errors[] = "Nilai untuk mahasiswa dengan ID $id_mahasiswa tidak boleh kosong.";
                continue;
            }

            // Cek apakah nilai valid
            if (!in_array($nilai, $allowed_grades)) {
                $errors[] = "Nilai '$nilai' untuk mahasiswa ID $id_mahasiswa tidak valid. 
                             Nilai harus: A, A-, B+, B, B-, C, D, atau E.";
                continue;
            }

            // Jika lolos validasi → insert/update
            $sql_insert = "INSERT INTO penilaian (id_mahasiswa, id_matakuliah, nilai) 
                           VALUES (?, ?, ?) 
                           ON DUPLICATE KEY UPDATE nilai = ?";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $id_mahasiswa, $id_matakuliah, $nilai, $nilai);

            if (!$stmt_insert->execute()) {
                $errors[] = "Gagal menyimpan nilai mahasiswa ID $id_mahasiswa: " . 
                            htmlspecialchars($stmt_insert->error);
            }

            $stmt_insert->close();
        }

        if (empty($errors)) {
            $messages['success'] = "Nilai berhasil disimpan.";
        } else {
            $messages['errors'] = $errors;
        }

    } else {
        $messages['errors'] = ["Form nilai tidak valid atau kosong."];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Input Nilai Mahasiswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6ff;
            margin: 0;
            padding: 30px 20px;
            color: #10375C;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 14px 40px rgba(16, 55, 92, 0.15);
            padding: 30px 40px;
            user-select: none;
        }

        .header-text {
            text-align: center;
            background-color: #10375C;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 1.7em;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(42, 82, 152, 0.5);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(42, 82, 152, 0.1);
            margin-bottom: 25px;
        }

        th,
        td {
            padding: 15px 22px;
            border-bottom: 1px solid #ddd;
            font-size: 1rem;
            text-align: left;
        }

        th {
            background-color: #10375C;
            color: white;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        tbody tr:nth-child(even) td {
            background-color: #f9fbff;
        }

        tbody tr:hover td {
            background-color: #dce6ff;
            transition: background-color 0.3s ease;
        }

        input.status-input {
            width: 100%;
            padding: 10px 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        input.status-input:focus {
            border-color: #637AB9;
            outline: none;
            box-shadow: 0 0 8px rgba(99, 122, 185, 0.7);
        }

        .submit-btn {
            background-color: #2A5298;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 15px 40px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(42, 82, 152, 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            display: block;
            margin: 0 auto 30px auto;
            user-select: none;
        }

        .submit-btn:hover,
        .submit-btn:focus {
            background-color: #10375C;
            box-shadow: 0 12px 40px rgba(16, 55, 92, 0.8);
            outline: none;
        }

        .menu {
            text-align: center;
        }

        .menu a {
            display: inline-block;
            background-color: #2A5298;
            color: white;
            text-decoration: none;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(42, 82, 152, 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }

        .menu a:hover,
        .menu a:focus {
            background-color: #10375C;
            box-shadow: 0 14px 50px rgba(16, 55, 92, 0.7);
            outline: none;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 18px 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 15px rgba(60, 118, 61, 0.3);
            user-select: text;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 18px 25px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(169, 68, 66, 0.3);
            user-select: text;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px 15px;
            }

            .header-text {
                font-size: 1.4rem;
                padding: 15px;
            }

            th,
            td {
                padding: 12px 15px;
                font-size: 0.95rem;
            }

            input.status-input {
                padding: 8px 10px;
                font-size: 0.95rem;
            }

            .submit-btn {
                padding: 12px 30px;
                font-size: 1rem;
            }

            .menu a {
                padding: 10px 25px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-text">
            Input Nilai Mahasiswa untuk Matakuliah ID: <?= htmlspecialchars($id_matakuliah); ?>
        </div>

        <?php if (!empty($messages['success'])): ?>
            <div class="success-message"><?= htmlspecialchars($messages['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($messages['errors'])): ?>
            <?php foreach ($messages['errors'] as $error): ?>
                <div class="error-message"><?= htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td>
                                    <input type="text" name="nilai[<?= htmlspecialchars($row['id']); ?>]" class="status-input" placeholder="Masukkan nilai" required />
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

            <input type="submit" value="Simpan Nilai" class="submit-btn" />
        </form>

        <div class="menu">
            <a href="dashboard_dosen.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
