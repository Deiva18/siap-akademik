<?php
session_start();

require 'koneksi.php';

if (!isset($_SESSION['nid'])) {
    header("Location: login_dosen.php");
    exit();
}

$nid_dosen = $_SESSION['nid'];

$sql = "SELECT * FROM matakuliah WHERE nid_dosen = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nid_dosen);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Matakuliah</title>
    <style>
        /* Body & base font */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #10375C;
            margin: 0;
            padding: 30px 20px;
            color: white;
            user-select: none;
        }

        /* Container style */
        .container {
            max-width: 960px;
            margin: 0 auto;
            background-color: #f4f6ff;
            border-radius: 15px;
            box-shadow: 0 14px 40px rgba(16, 55, 92, 0.25);
            padding: 30px 40px;
        }

        /* Header */
        .header-text {
            text-align: center;
            font-weight: 700;
            font-size: 2rem;
            color: #10375C;
            margin-bottom: 40px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(42, 82, 152, 0.5);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(42, 82, 152, 0.15);
            background-color: white;
            color: #10375C;
        }

        th,
        td {
            padding: 16px 22px;
            font-size: 1rem;
            text-align: left;
        }

        th {
            background-color: #10375C;
            color : white;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        tbody tr:nth-child(even) td {
            background-color: #e9efff;
        }

        /* Button */
        .btn-nilai {
            padding: 10px 22px;
            background-color: #2A5298;
            color: white;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(42, 82, 152, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
            user-select: none;
        }

        .btn-nilai:hover,
        .btn-nilai:focus {
            background-color: #10375C;
            box-shadow: 0 12px 40px rgba(16, 55, 92, 0.7);
            outline: none;
        }

        /* Navigation menu */
        .menu {
            text-align: center;
            margin-top: 40px;
        }

        .menu a {
            display: inline-block;
            padding: 14px 36px;
            background-color: #2A5298;
            color: white;
            font-weight: 700;
            text-decoration: none;
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

        /* Responsive */
        @media (max-width: 720px) {
            .container {
                padding: 20px 15px;
            }

            .header-text {
                font-size: 1.5rem;
                margin-bottom: 30px;
            }

            th,
            td {
                padding: 14px 18px;
                font-size: 0.95rem;
            }

            .btn-nilai {
                padding: 8px 18px;
                font-size: 0.9rem;
            }

            .menu a {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-text">
            Daftar Matakuliah untuk Dosen dengan NID: <?= htmlspecialchars($nid_dosen); ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Matakuliah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_matakuliah']); ?></td>
                            <td>
                                <a class="btn-nilai" href="input_nilai.php?id=<?= urlencode($row['id']); ?>">Nilai Mahasiswa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" style="text-align:center; font-style: italic; color: #555;">
                            Tidak ada matakuliah yang tersedia untuk dosen dengan NID: <?= htmlspecialchars($nid_dosen); ?>
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

<?php
$stmt->close();
$conn->close();
?>
