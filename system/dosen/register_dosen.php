<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Dosen</title>
  <!-- Google Fonts & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f3f5fc;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #0a2a5e;
      padding: 30px;
      border-radius: 12px;
      width: 750px;
      color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    h1 {
      text-align: center;
      margin-bottom: 5px;
      font-weight: 600;
    }

    /* Grid 2 kolom */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px 25px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .input-container {
      display: flex;
      align-items: center;
      background-color: #fff;
      border-radius: 6px;
      padding: 8px 10px;
    }

    .input-container i {
      color: #333;
      margin-right: 8px;
      font-size: 14px;
    }

    .input-container input,
    .input-container select,
    .input-container textarea {
      border: none;
      outline: none;
      width: 100%;
      font-size: 14px;
      background: none;
      color: #333;
      font-family: 'Poppins', sans-serif;
    }

    textarea {
      resize: none;
    }

    label {
      font-size: 14px;
      margin-bottom: 5px;
      display: block;
      font-weight: 500;
    }

    /* Tombol penuh 1 baris */
    .form-footer {
      grid-column: span 2;
      text-align: center;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #ffd700;
      color: #000;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      font-size: 15px;
      margin-top: 10px;
    }

    button:hover {
      background-color: #f4c700;
    }

    p {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    a {
      color: #ffd700;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>

  <script>
    function updateProdi() {
      const fakultas = document.getElementById('fakultas').value;
      const prodiSelect = document.getElementById('prodi');
      prodiSelect.innerHTML = '';

      const defaultOption = document.createElement('option');
      defaultOption.value = '';
      defaultOption.text = 'Pilih Prodi';
      prodiSelect.add(defaultOption);

      if (fakultas === 'FAKULTAS TEKNOLOGI INFORMASI') {
        ['Informatika', 'Sistem Informasi', 'Pendidikan Teknologi Informasi'].forEach(p => {
          const option = document.createElement('option');
          option.value = p;
          option.text = p;
          prodiSelect.add(option);
        });
      }

      updateKodeDosen();
    }

    function updateKodeDosen() {
      const fakultas = document.getElementById('fakultas').value;
      const prodiSelect = document.getElementById('prodi');
      const kodeDosenField = document.getElementById('kode_dosen');

      let kodeFakultas = '';
      let kodeProdi = '';

      switch (fakultas) {
        case 'FAKULTAS TEKNOLOGI INFORMASI':
          kodeFakultas = 'FT';
          switch (prodiSelect.value) {
            case 'Informatika': kodeProdi = '111'; break;
            case 'Sistem Informasi': kodeProdi = '222'; break;
            case 'Pendidikan Teknologi Informasi': kodeProdi = '333'; break;
          }
          break;
        }

      const kodeDosen = `${kodeFakultas}-${kodeProdi}`;
      kodeDosenField.value = kodeDosen;
    }

    // Automatically select FTI and populate its Prodi on page load
    window.addEventListener('DOMContentLoaded', () => {
      const fakultasSelect = document.getElementById('fakultas');
      fakultasSelect.value = 'FAKULTAS TEKNOLOGI INFORMASI';
      updateProdi();
    });

  </script>
</head>

<body>
  <div class="container">
    <h1>Form Pendaftaran Dosen</h1>
    <form id="registerForm" action="process_register_dosen.php" method="POST">
      <div class="form-grid">
        <div class="form-group">
          <label for="nama">Nama</label>
          <div class="input-container">
            <i class="fa-solid fa-user"></i>
            <input type="text" id="nama" name="nama" placeholder="Masukkan Nama" required>
          </div>
        </div>

        <!-- <div class="form-group">
          <label for="fakultas">Jurusan</label>
          <div class="input-container">
            <i class="fa-solid fa-building-columns"></i>
            <select id="fakultas" name="fakultas" required onchange="updateProdi()">
              <option value="">Pilih Jurusan</option>
              <option value="FAKULTAS TEKNOLOGI INFORMASI">Jurusan Teknik Informatika</option>
              <option value="FAKULTAS TEKNIK">Fakultas Teknik</option>
              <option value="FAKULTAS HUKUM">Fakultas Hukum</option> -->
            <!-- </select> -->
          <!-- </div> -->
        <!-- </div> -->

        <!-- <div class="form-group">
        <label>Jurusan</label>
        <div class="input-container">
          <input type="text" value="Jurusan Teknik Informatika" disabled>
        </div>
        </div> -->

        <input type="hidden" id="fakultas" name="fakultas" value="FAKULTAS TEKNOLOGI INFORMASI">

        <div class="form-group">
          <label for="prodi">Prodi</label>
          <div class="input-container">
            <i class="fa-solid fa-graduation-cap"></i>
            <select id="prodi" name="prodi" required onchange="updateKodeDosen()">
              <option value="">Pilih Prodi</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <div class="input-container">
            <i class="fa-solid fa-venus-mars"></i>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
              <option value="">Pilih Jenis Kelamin</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="tanggal_lahir">Tanggal Lahir</label>
          <div class="input-container">
            <i class="fa-solid fa-calendar-days"></i>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
          </div>
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <div class="input-container">
            <i class="fa-solid fa-map-marker-alt"></i>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-container">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
          </div>
        </div>

        <div class="form-group">
          <label for="kode_dosen">Kode Dosen</label>
          <div class="input-container">
            <i class="fa-solid fa-id-badge"></i>
            <input type="text" id="kode_dosen" name="kode_dosen" placeholder="Otomatis terisi" readonly required>
          </div>
        </div>

        <div class="form-footer">
          <button type="submit">Daftar</button>
          <p>Sudah punya akun? <a href="login_dosen.php">Kembali ke login</a></p>
        </div>
      </div>
    </form>
  </div>
</body>

</html>
