<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

require 'koneksi.php';

$sql_informatika = "SELECT * FROM dosen WHERE fakultas = 'FAKULTAS TEKNOLOGI INFORMASI'";
$result_informatika = $conn->query($sql_informatika);

if (!$result_informatika) {
    echo "Error: " . $conn->error;
    exit();
}

$dosen_informatika = $result_informatika->fetch_all(MYSQLI_ASSOC);

// function editProfessor($professors) {
//     // echo "TEST: " . $professors;
// }

function displayProfessors($professors)
{
    echo '<div class="table-container">';
    echo '<table>';
    echo '<thead>';
    echo '<tr>
        <th>NID</th>
        <th>Nama</th>
        <th>Program Studi</th>
        <th>Aksi</th>
    </tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($professors as $professor) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($professor['nid']) . '</td>';
        echo '<td>' . htmlspecialchars($professor['nama']) . '</td>';
        echo '<td>' . htmlspecialchars($professor['prodi']) . '</td>';
        // echo '<td>
        //     <a class="btn-absen" href="edit_dosen.php?nid="' . htmlspecialchars($professor['nid']) . '">
        //         Edit
        //     </a>
        // </td>';
        echo '<td> 
            <a class="btn-absen" href="edit_dosen.php?id=' . urlencode($professor['id']) . '">
                Edit
            </a>
        </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Dosen</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f3f5fc, #e9edff);
            margin: 0;
            padding: 0;
            color: #222;
            animation: fadeIn 1s ease;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 40px 0;
            color: #0a2a5e;
        }

        h3 {
            color: #0a2a5e;
            padding-left: 30px;
            margin-top: 40px;
            font-size: 1.6rem;
        }

        form {
            text-align: center;
            margin-bottom: 40px;
        }

        label {
            font-size: 1.1rem;
            font-weight: 500;
            color: #0a2a5e;
            margin-right: 10px;
        }

        select {
            padding: 12px 18px;
            border-radius: 10px;
            border: 1.8px solid #0a2a5e;
            font-size: 1rem;
            outline: none;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        select:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }

        button {
            padding: 12px 28px;
            background-color: #ffd700;
            color: #0a2a5e;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #e6c200;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        .table-container {
            width: 90%;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.7s ease;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #0a2a5e;
            color: white;
            text-transform: uppercase;
        }

        th,
        td {
            padding: 14px 20px;
            text-align: left;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #e9f0ff;
            transform: scale(1.01);
        }

        p {
            text-align: center;
            color: #555;
            font-style: italic;
        }

        .back-dashboard {
            text-align: center;
            margin: 60px 0;
        }

        .back-dashboard button {
            background-color: #0a2a5e;
            color: #ffd700;
            border: none;
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .back-dashboard button:hover {
            background-color: #113b82;
            transform: translateY(-3px);
        }

        .back-dashboard i {
            margin-right: 8px;
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 2rem;
            }

            table {
                font-size: 0.9rem;
            }

            select {
                width: 80%;
                margin-bottom: 10px;
            }

            button {
                margin: 10px 0 0 0;
                width: 80%;
            }

        }
    </style>
</head>

<body>
    <h2>Daftar Dosen</h2>

    <h3><i class="fa-solid fa-laptop-code"></i> Jurusan Teknik Informatika</h3>

    <?php
    if (!empty($dosen_informatika)) {
        displayProfessors($dosen_informatika);
    } else {
        echo '<p>Tidak ada dosen terdaftar untuk jurusan Teknik Informatika.</p>';
    }
    ?>

    <form action="dashboard_admin.php" method="get" class="back-dashboard">
        <button type="submit"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</button>
    </form>
</body>
</html>
