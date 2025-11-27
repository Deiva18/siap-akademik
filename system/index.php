<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAP</title>
</head>

<body>
    <section class="menu">
        <div class="nav">
            <div class="logo">
                <h2>Selamat Datang di Website SIAP</h2>
                <h3><i>Sistem Informasi Akademi Perseorangan</i></h3>
            </div>
            <div class="buttons">
                <input class="Dosen" type="button" value="Dosen" onclick="goToDosenPage()">
                <input class="Mahasiswa" type="button" value="Mahasiswa" onclick="goToMahasiswaPage()">
                <input class="Admin" type="button" value="Admin" onclick="goToAdminPage()">
            </div>
        </div>
    </section>

    <script>
        function goToDosenPage() {
            window.location.href = 'dosen/login_dosen.php';
        }

        function goToMahasiswaPage() {
            window.location.href = 'mahasiswa/login.php';
        }

        function goToAdminPage() {
            window.location.href = 'admin/index.php';
        }
    </script>
</body>

</html>