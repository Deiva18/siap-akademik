<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin</title>
    <!-- Link ke Font Awesome CDN untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #1E3C72, #2A5298);
        color: #333;
        margin: 0;
        padding: 0;
    }
        .container {
            max-width: 850px;
            margin: 60px auto;
            padding: 40px 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            color: #34495e;
        }

        .menu {
        text-align: center;
        margin-bottom: 0px;
    }

    .menu a {
        display: inline-block;
        padding: 14px 28px;
        margin: 0 12px;
        background: #2A5298;
        color: white;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        letter-spacing: 0.01em;
        box-shadow: 0 0px 15px rgba(42, 82, 152, 0.4);
        transition: background 0.3s, box-shadow 0.3s;
    }

    .menu a:hover, .menu a:focus {
        background: #1E3C72;
        box-shadow: 0 8px 25px rgba(30, 60, 114, 0.7);
        outline: none;
    }

        /* Responsive */
        @media (max-width: 600px) {
            .menu {
                flex-direction: column;
                gap: 15px;
            }

            .container {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin!</p>

        <div class="menu">
            <a href="daftar_dosen.php"><i class="fas fa-chalkboard-teacher"></i> Daftar Dosen</a>
            <a href="input_matkul.php"><i class="fas fa-book-open"></i> Input Mata Kuliah</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</body>

</html>
