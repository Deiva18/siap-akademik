<?php
session_start();
$registered_nid = isset($_SESSION['registered_nid']) ? $_SESSION['registered_nid'] : '';
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['registered_nid']);
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Dosen</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    background: #F4F6FF;      
    margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      width: 360px;
      padding: 30px;
      border-radius: 15px;
      background: #10375C;
      backdrop-filter: blur(12px);
      color: #fff;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h1 {
      text-align: center;
      margin-bottom: 25px;
      color: #fff;
      font-size: 26px;
      letter-spacing: 1px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      font-size: 14px;
    }

    .input-wrapper {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      border-radius: 8px;
      background: #fff;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .input-wrapper:focus-within {
      border-color: #FFD700;
      box-shadow: 0 0 6px rgba(255, 215, 0, 0.6);
    }

    .input-wrapper i {
      padding: 12px;
      background: #f2f2f2;
      color: #555;
      font-size: 14px;
      min-width: 40px;
      text-align: center;
    }

    .input-wrapper input {
      border: none;
      outline: none;
      padding: 12px;
      width: 100%;
      font-size: 15px;
      background: transparent;
    }

    .toggle-password {
      cursor: pointer;
      background: #f2f2f2;
      padding: 12px;
      color: #555;
    }

    button[type="submit"] {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      background: linear-gradient(135deg, #FFD700, #F3C623);
      color: #000;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: transform 0.2s ease, background 0.3s;
    }

    button[type="submit"]:hover {
      transform: scale(1.05);
      background: linear-gradient(135deg, #F3C623, #FFD700);
    }

    p {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    p a {
      color: #ffd700;
      text-decoration: none;
      font-weight: normal;
      transition: color 0.3s;
    }

    a:hover {
      text-decoration: underline;
    }

    .error-message {
      background: rgba(255, 0, 0, 0.2);
      color: #ffcccc;
      padding: 8px;
      border-radius: 6px;
      text-align: center;
      margin-bottom: 10px;
    }

    .info-message {
      background: rgba(0, 255, 0, 0.2);
      color: #d4ffd4;
      padding: 8px;
      border-radius: 6px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Login</h1>

    <?php if ($login_error) : ?>
      <div class="error-message"><?php echo $login_error; ?></div>
    <?php endif; ?>

    <?php if ($registered_nid) : ?>
      <div class="info-message">Silakan gunakan NID yang telah didaftarkan: <?php echo $registered_nid; ?></div>
      <a href="#" id="showNIDButton" style="color:#FFD700; text-decoration:underline;">Tampilkan NID</a>
      <div id="nidDisplay" style="display: none; margin-top:10px;">
        <p>NID Anda: <strong><?php echo $registered_nid; ?></strong></p>
      </div>
    <?php endif; ?>

    <form action="process_login_dosen.php" method="POST">
      <!-- NID -->
      <div class="form-group">
        <label for="nid">NID</label>
        <div class="input-wrapper">
          <i class="fa fa-user"></i>
          <input type="text" id="nid" name="nid" value="<?php echo $registered_nid; ?>" placeholder="Masukkan NID" required>
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <i class="fa fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
        </div>
      </div>

      <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register_dosen.php">Daftar disini</a></p>
  </div>

  <script>
    // Tampilkan NID
    const showBtn = document.getElementById('showNIDButton');
    if (showBtn) {
      showBtn.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('nidDisplay').style.display = 'block';
      });
    }

    // Show/Hide Password
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", function() {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Ganti ikon mata
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>

</html>
