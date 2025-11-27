<?php
session_start();

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

$nim = $_SESSION['nim'];
$sql = "SELECT * FROM data_mahasiswa WHERE nim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Akademik Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 230px;
            height: 100vh;
            background: linear-gradient(180deg, #1E3C72, #2A5298);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar a {
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FFD700;
        }

        /* === MAIN === */
        .main-content {
            margin-left: 230px;
            padding: 25px;
        }

        .header {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            font-size: 22px;
            color: #1E3C72;
        }

        .header .user-info {
            font-weight: 600;
            color: #2A5298;
        }

        /* === PROFILE CARD === */
        .profile-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 0 auto;
        }

        .profile-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .profile-card th,
        .profile-card td {
            padding: 10px;
            text-align: left;
            font-size: 15px;
        }

        .profile-card th {
            color: #2A5298;
            width: 30%;
        }

        .btn {
            display: inline-block;
            background: #2A5298;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #1E3C72;
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.3);
        }

        /* === FORM EDIT === */
        .edit-form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            max-width: 700px;
            margin: 0 auto;
            display: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        .edit-form input,
        .edit-form select,
        .edit-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .edit-form input:focus,
        .edit-form select:focus,
        .edit-form textarea:focus {
            border-color: #2A5298;
            box-shadow: 0 0 8px rgba(42, 82, 152, 0.3);
            outline: none;
        }

        .edit-form button {
            background: #2A5298;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-form button:hover {
            background: #1E3C72;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-graduation-cap"></i> Akademik</h2>
        <a href="#" class="active" onclick="showSection('profile')"><i class="fa-solid fa-user"></i> Profil</a>
        <a href="jadwal.php"><i class="fa-solid fa-calendar-days"></i> Jadwal</a>
        <a href="absensi.php"><i class="fa-solid fa-check-circle"></i> Absensi</a>
        <a href="krs.php"><i class="fa-solid fa-book-open"></i> KRS</a>
        <a href="khs.php"><i class="fa-solid fa-chart-line"></i> KHS</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard Mahasiswa</h1>
            <div class="user-info" style="display:flex; align-items:center; gap:12px;">
    <img src="uploads/<?php echo $user['foto']; ?>" 
         style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
    <?php echo htmlspecialchars($user['nama']); ?>
</div>
        </div>

        <!-- Profil -->
        <div id="profile" class="profile-card">
            <div style="text-align:center; margin-bottom:20px;">
    <img src="uploads/<?php echo $user['foto']; ?>" 
         style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #2A5298;">
    <form action="upload_foto.php" method="post" enctype="multipart/form-data" style="margin-top:15px;">
        <input type="file" name="foto" accept="image/*" required>
        <button class="btn" type="submit"><i class="fa-solid fa-camera"></i> Simpan</button>
    </form>
</div>
            <table>
                <tr><th>Nama</th><td><?php echo htmlspecialchars($user['nama']); ?></td></tr>
                <tr><th>NIM</th><td><?php echo htmlspecialchars($user['nim']); ?></td></tr>
                <!-- <tr><th>Fakultas</th><td><?php echo htmlspecialchars($user['fakultas']); ?></td></tr> -->
                <tr><th>Program Studi</th><td><?php echo htmlspecialchars($user['prodi']); ?></td></tr>
                <tr><th>Jenis Kelamin</th><td><?php echo htmlspecialchars($user['jenis_kelamin']); ?></td></tr>
                <tr><th>Tanggal Lahir</th><td><?php echo htmlspecialchars($user['tanggal_lahir']); ?></td></tr>
                <tr><th>Alamat</th><td><?php echo htmlspecialchars($user['alamat']); ?></td></tr>
            </table>
            <button class="btn" onclick="showEditForm()">Edit Profil</button>
        </div>

        <!-- Form Edit Profil -->
        <div id="editProfileForm" class="edit-form">
            <h2>Edit Profil</h2>
            <form action="edit_profile.php" method="post">
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                <input type="text" name="nim" value="<?php echo htmlspecialchars($user['nim']); ?>" readonly>
                <!-- <input type="text" name="fakultas" value="<?php echo htmlspecialchars($user['fakultas']); ?>" required> -->
                <input type="text" name="prodi" value="<?php echo htmlspecialchars($user['prodi']); ?>" readonly>
                <select name="jenis_kelamin" required>
                    <option value="L" <?php if ($user['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                    <option value="P" <?php if ($user['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
                </select>
                <input type="date" name="tanggal_lahir" value="<?php echo $user['tanggal_lahir']; ?>" required>
                <textarea name="alamat" rows="4" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>
                <button type="submit"><i class="fa-solid fa-save"></i> Simpan</button>
            </form>
        </div>
    </div>

    <script>
        function showEditForm() {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
        }
    </script>
</body>
</html>
