<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik Universitas</title>
    <link rel="stylesheet" href="global_css/index.css">

    <style>
        .announcement-box {
            margin-top: 30px;
            background: #ffffffdd;
            padding: 15px;
            border-radius: 10px;
            width: 80%;
            text-align: left;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }
        .announcement-box h3 {
            margin-bottom: 10px;
        }
        .announcement-item {
            margin-bottom: 10px;
            border-left: 4px solid #3366ff;
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Sistem Akademik Universitas</h1>

        <div class="action-buttons">
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-register">Register</a>
        </div>

        <!-- Fitur Pengumuman -->
        <div class="announcement-box">
            <h3>📢 Pengumuman Terbaru</h3>

            <div class="announcement-item">
                <strong>27 Nov 2025:</strong> Batas pengisian KRS sampai tanggal 5 Desember.
            </div>
            <div class="announcement-item">
                <strong>26 Nov 2025:</strong> Sistem akan maintenance hari Sabtu pukul 22:00.
            </div>
            <div class="announcement-item">
                <strong>25 Nov 2025:</strong> Wisuda periode 2025 dibuka mulai 30 November.
            </div>
        </div>

    </div>
</body>

</html>
