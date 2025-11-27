<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['nim'])) {
    header("Location: login_mahasiswa.php");
    exit();
}

$nim = $_SESSION['nim'];
$sql = "SELECT p.id, krs.nama_matakuliah, p.kehadiran
        FROM absensi p
        INNER JOIN krs ON p.id_mahasiswa = (SELECT id FROM data_mahasiswa WHERE nim = krs.nim)
        WHERE krs.nim = '$nim'";

$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link rel="stylesheet" href="global_css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6ff;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #333;
        }

        .menu {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #10375C;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #2A5298;
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


        .content {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Absensi</h1>
        <div class="content">
            <?php if ($result->num_rows > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Matakuliah</th>
                            <th>Absensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo htmlspecialchars($row['nama_matakuliah']); ?></td>
                                <td><?php echo htmlspecialchars($row['kehadiran']); ?></td>
                            </tr>
                            <?php $no++; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Tidak ada data absensi yang tersedia.</p>
            <?php endif; ?>
            <div class="menu">
                <a href="dashboard.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>