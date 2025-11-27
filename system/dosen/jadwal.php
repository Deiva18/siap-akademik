<?php
session_start();

require 'koneksi.php';

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

$nid_dosen = $_SESSION['nid'];

$sql = "SELECT * FROM matakuliah WHERE nid_dosen = '$nid_dosen'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Jadwal Matakuliah</title>
    <style>
        /* Reset dan font */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #10375C 0%, #2A5298 100%);
            margin: 0;
            padding: 30px 15px;
            color: #333;
            min-height: 100vh;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #f4f6ff;
            border-radius: 15px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            padding: 30px 40px;
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
        }

        /* Header */
        .header-text {
            text-align: center;
            font-weight: 700;
            font-size: 2rem;
            color: #10375C;
            margin-bottom: 30px;
            letter-spacing: 1.2px;
            user-select: none;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(42, 82, 152, 0.5);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 4px 15px rgba(16, 55, 92, 0.2);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            font-size: 1rem;
        }

        th {
            background: #10375C;
            color: #ffffff;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        tbody tr:nth-child(even) td {
            background: #e9efff;
        }

        /* Action button */
        .btn-absen {
            background: #637AB9;
            padding: 8px 18px;
            color: white;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 5px 15px rgba(99, 122, 185, 0.4);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
        }

        .btn-absen:hover {
            background: #4a5f9e;
            box-shadow: 0 8px 25px rgba(74, 95, 158, 0.7);
        }

        /* Navigation menu */
        .menu {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .menu a {
            display: inline-block;
            padding: 12px 28px;
            background: #10375C;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 30px;
            box-shadow: 0 6px 20px rgba(16, 55, 92, 0.5);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }

        .menu a:hover {
            background: #637AB9;
            box-shadow: 0 8px 30px rgba(99, 122, 185, 0.7);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            th, td {
                padding: 12px 10px;
                font-size: 0.95rem;
            }

            .header-text {
                font-size: 1.5rem;
            }

            .btn-absen {
                padding: 6px 14px;
                font-size: 0.85rem;
            }

            .menu a {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-text">
            Jadwal Matakuliah untuk Dosen dengan NID: <?= htmlspecialchars($nid_dosen); ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Matakuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_matakuliah']); ?></td>
                            <td><?= htmlspecialchars($row['hari']); ?></td>
                            <td><?= htmlspecialchars($row['jam']); ?></td>
                            <td><?= htmlspecialchars($row['ruangan']); ?></td>
                            <td>
                                <a class="btn-absen" href="absensi_mahasiswa.php?id=<?= urlencode($row['id']); ?>">
                                    Absen Mahasiswa
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 20px; font-style: italic; color: #555;">
                            Tidak ada jadwal matakuliah yang tersedia.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="menu">
            <a href="dashboard_dosen.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
