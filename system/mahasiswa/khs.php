<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['nim'])) {
    header("Location: login_mahasiswa.php");
    exit();
}

$nim = $_SESSION['nim'];

$sql = "SELECT p.id, krs.nama_matakuliah, p.nilai
        FROM penilaian p
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
    <title>KHS - Kartu Hasil Studi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6ff;
    margin: 0;
    padding: 0;
    color: #10375C;
  }
        .container {
    max-width: 900px;
    margin: 30px auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 14px 40px rgba(16, 55, 92, 0.15);
  }
        .container h1 {
            text-align: center;
            color: #333;
        }

        h1 {
    text-align: center;
    font-weight: 700;
    color: #10375C;
    margin-bottom: 30px;
    letter-spacing: 1.3px;
    text-transform: uppercase;
  }

.menu {
    text-align: center;
    margin-bottom: 25px;
  }

  .menu a {
    background-color: #10375C;
    color: white;
    text-decoration: none;
    display: inline-block;
    padding: 12px 28px;
    margin: 0 10px;
    border-radius: 30px;
    font-weight: 600;
    transition: background-color 0.3s ease;
    box-shadow: 0 8px 25px rgba(16, 55, 92, 0.5);
    user-select: none;
  }

  .menu a:hover {
    background-color: #2A5298;
  }

        table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(16, 55, 92, 0.1);
  }

        th, td {
    padding: 15px 20px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 15px;
  }

    .print-btn {
        background: linear-gradient(135deg, #00ffbb, #00cc88);
        color: #10375C;
        display: inline-block;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .print-btn:hover {
        background: linear-gradient(135deg, #00cc88, #00ffbb);
    }

    .menu-print {
        margin-bottom: 15px;
    }

  th {
    background-color: #2A5298;
    color: #fff;
    font-weight: 400;
  }

  tr:nth-child(even) {
    background-color: #f9fbff;
  }

  tr:hover {
    background-color: #dfeeff;
    transition: background-color 0.3s ease;
  }

        .content {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Kartu Hasil Studi</h1>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Matakuliah</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_matakuliah']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nilai']) . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>Tidak ada data KHS yang tersedia.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="menu menu-print">
                <button onclick="printKHS()" class="print-btn">
                    <i class="fa-solid fa-print"></i> Print KHS
                </button>
            </div>

            <div class="menu">
                <a href="dashboard.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
    <script>
    function printKHS() {
        const printContent = document.querySelector("table").outerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <h2 style="text-align:center;">Kartu Hasil Studi (KHS)</h2>
            ${printContent}
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // Reload halaman agar kembali normal
    }
    </script>
</body>

</html>

<?php
$conn->close();
?>