<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pendaftaran Mahasiswa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #e6ecf5;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background-color: #0a2a5e;
      color: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    h1 {
      text-align: center;
      color: #fff;
      margin-bottom: 25px;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 20px;
    }

    .form-group {
      flex: 1 1 calc(50% - 20px);
    }

    .form-group.full {
      flex: 1 1 100%;
    }

    label {
      font-weight: 600;
      margin-bottom: 6px;
      color: #fff;
      display: block;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper i {
      position: absolute;
      left: 12px;
      color: #0a2a5e;
      font-size: 16px;
    }

    .input-wrapper input,
    .input-wrapper select,
    .input-wrapper textarea {
      width: 100%;
      padding: 10px 12px 10px 38px;
      border-radius: 8px;
      border: none;
      font-size: 15px;
      box-sizing: border-box;
      background: #fff;
      color: #333;
      transition: all 0.3s;
    }

    .input-wrapper input:focus,
    .input-wrapper select:focus,
    .input-wrapper textarea:focus {
      border: 1px solid #ffd700;
      box-shadow: 0 0 6px rgba(255, 215, 0, 0.7);
      outline: none;
    }

    .input-wrapper input:focus+i,
    .input-wrapper select:focus+i,
    .input-wrapper textarea:focus+i {
      color: #ffd700;
    }

    textarea {
      resize: vertical;
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: #ffd700;
      color: #000;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background-color: #e6c200;
    }

    p {
      text-align: center;
      margin-top: 15px;
    }

    a {
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      color: #e6c200;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Form Pendaftaran Mahasiswa</h1>
    <form action="process_register.php" method="POST">

      <div class="form-group">
        <label for="nama">Nama:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-user"></i>
          <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama">
        </div>
      </div>

      <!-- <div class="form-group">
        <label for="fakultas">Jurusan:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-building-columns"></i>
          <select id="fakultas" name="fakultas" required onchange="updateProdi()">
            <option value="">Pilih Jurusan</option>
            <option value="FAKULTAS TEKNOLOGI INFORMASI">Jurusan Teknik Informatika</option>
            <option value="FAKULTAS TEKNIK">Fakultas Teknik</option> -->
            <!-- <option value="FAKULTAS HUKUM">Fakultas Hukum</option> -->
          <!-- </select> -->
        <!-- </div> -->
      <!-- </div> -->

      <input type="hidden" id="fakultas" name="fakultas" value="FAKULTAS TEKNOLOGI INFORMASI">

      <div class="form-group">
        <label for="prodi">Prodi:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-graduation-cap"></i>
          <select id="prodi" name="prodi" required>
            <option value="">Pilih Prodi</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-venus-mars"></i>
          <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-calendar"></i>
          <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-lock"></i>
          <input type="password" id="password" name="password" required placeholder="Masukkan Password">
        </div>
      </div>

      <div class="form-group full">
        <label for="alamat">Alamat:</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-location-dot"></i>
          <textarea id="alamat" name="alamat" rows="4" required placeholder="Masukkan Alamat"></textarea>
        </div>
      </div>

      <div class="form-group full">
        <button type="submit">Daftar Sekarang</button>
      </div>

      <p>Sudah punya akun? <a href="login.php">Kembali ke login</a></p>
    </form>
  </div>

  <script>
    function updateProdi() {
      const fakultas = document.getElementById('fakultas').value;
      const prodi = document.getElementById('prodi');
      prodi.innerHTML = '';

      const optionAwal = document.createElement('option');
      optionAwal.value = '';
      optionAwal.text = 'Pilih Prodi';
      prodi.add(optionAwal);

      if (fakultas === 'FAKULTAS TEKNOLOGI INFORMASI') {
        ['Informatika', 'Sistem Informasi', 'Pendidikan Teknologi Informasi'].forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.text = p;
          prodi.add(opt);
        });
      }
    }

    // Automatically select FTI and populate its Prodi on page load
    window.addEventListener('DOMContentLoaded', () => {
      const fakultasSelect = document.getElementById('fakultas');
      fakultasSelect.value = 'FAKULTAS TEKNOLOGI INFORMASI';
      updateProdi();
    });

  </script>
</body>
</html>
