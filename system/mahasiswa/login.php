<?php
session_start();
$registered_nim = isset($_SESSION['registered_nim']) ? $_SESSION['registered_nim'] : '';
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['registered_nim']);
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Mahasiswa</title>
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
      padding: 35px;
      border-radius: 15px;
      background: #10375C;
      color: #fff;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 26px;
      color: #fff;
      letter-spacing: 1px;
    }

    .form-group {
      margin-bottom: 18px;
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
      transform: scale(1.02);
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
      margin-top: 5px;
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

    p a:hover {
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

    <form action="process_login.php" method="POST">
      <div class="form-group">
        <label for="nim">NIM</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-user"></i>
          <input type="text" id="nim" name="nim" value="<?php echo $registered_nim; ?>" placeholder="Masukkan NIM" required>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
        </div>
      </div>

      <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
  </div>
</body>
</html>
