<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

$success_message = isset($_GET['success_message']) ? $_GET['success_message'] : '';
$error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Mata Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f3f5fc;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
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

        .container {
            background-color: #0a2a5e;
            color: white;
            border-radius: 16px;
            padding: 40px 50px;
            width: 100%;
            max-width: 820px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.8s ease;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
            color: #ffd700;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px 28px;
        }

        .form-group {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }

        input,
        select {
            width: 100%;
            padding: 12px 14px 12px 38px; /* extra left padding for icon */
            border: none;
            border-radius: 10px;
            background-color: #f3f5fc;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-icon {
            position: absolute;
            top: 40px;
            left: 12px;
            color: #999;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.3s;
        }

        input:hover,
        select:hover {
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(255, 215, 0, 0.4);
        }

        input:focus,
        select:focus {
            background-color: #fff;
            box-shadow: 0 0 10px #ffd700;
            outline: none;
        }

        input:focus + .input-icon,
        select:focus + .input-icon {
            color: #ffd700;
        }

        .btn-submit {
            grid-column: span 2;
            display: inline-block;
            width: 100%;
            margin-top: 10px;
            padding: 14px 0;
            background-color: #ffd700;
            color: #0a2a5e;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #e6c200;
            transform: scale(1.03);
        }

        .success-message {
            color: #00ff80;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .error-message {
            color: #ff7070;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .back-btn {
            text-align: center;
            margin-top: 25px;
        }

        .back-btn button {
            background-color: #fff;
            color: #0a2a5e;
            font-weight: 600;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .back-btn button:hover {
            background-color: #ffd700;
            color: #0a2a5e;
        }

        @media (max-width: 750px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 25px;
            }

            .btn-submit {
                grid-column: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Input Mata Kuliah</h1>

        <?php if (!empty($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="process_input.php" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Kode Mata Kuliah</label>
                    <input type="text" id="kode_matakuliah" name="kode_matakuliah" required>
                    <i class="fa-solid fa-code input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Nama Mata Kuliah</label>
                    <input type="text" id="nama_matakuliah" name="nama_matakuliah" required>
                    <i class="fa-solid fa-book input-icon"></i>
                </div>

                <div class="form-group">
                    <label>SKS</label>
                    <input type="number" id="sks" name="sks" min="2" max="4" required>
                    <i class="fa-solid fa-graduation-cap input-icon"></i>
                </div>
                
                <input type="hidden" id="fakultas" name="fakultas" value="FAKULTAS TEKNOLOGI INFORMASI">

                <div class="form-group">
                    <label>Program Studi</label>
                    <select id="prodi" name="prodi" required>
                        <option value="">Pilih Program Studi</option>
                    </select>
                    <i class="fa-solid fa-user-graduate input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Ruangan</label>
                    <input type="text" id="ruangan" name="ruangan" required>
                    <i class="fa-solid fa-door-open input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <input type="number" id="semester" name="semester" min="1" max="8" required>
                    <i class="fa-solid fa-layer-group input-icon"></i>
                </div>

                <div class="form-group">
                    <label>NID Dosen</label>
                    <input type="text" id="nid_dosen" name="nid_dosen" required>
                    <i class="fa-solid fa-id-card input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Dosen Pengampu</label>
                    <input type="text" id="dosen_pengampu" name="dosen_pengampu" required>
                    <i class="fa-solid fa-chalkboard-user input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Hari</label>
                    <input type="text" id="hari" name="hari" required>
                    <i class="fa-solid fa-calendar-days input-icon"></i>
                </div>

                <div class="form-group">
                    <label>Jam</label>
                    <input type="text" id="jam" name="jam" required>
                    <i class="fa-solid fa-clock input-icon"></i>
                </div>

                <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Data</button>
            </div>
        </form>

        <div class="back-btn">
            <form action="dashboard_admin.php" method="post">
                <button type="submit"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</button>
            </form>
        </div>
    </div>

    <script>
        function getProdi() {
            const prodiSelect = document.getElementById("prodi");
            prodiSelect.innerHTML = "";

            const options = [
                "Pilih Program Studi",
                "Informatika",
                "Sistem Informasi",
                "Pendidikan Teknologi Informasi"
            ];

            options.forEach(opt => {
                const optionElem = document.createElement("option");
                optionElem.value = opt;
                optionElem.textContent = opt;
                prodiSelect.appendChild(optionElem);
            });
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            getProdi();
        });

    </script>
</body>

</html>
