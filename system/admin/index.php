<?php
session_start();
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      margin: 0;
      background-color: #f3f5fc;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: #0a2a5e;
      padding: 40px 30px;
      border-radius: 15px;
      width: 360px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      text-align: center;
      animation: fadeIn 0.8s ease-in-out;
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
      color: #ffffff;
      margin-bottom: 25px;
      font-size: 28px;
      letter-spacing: 1px;
    }

    .error-message {
      background-color: rgba(255, 0, 0, 0.15);
      color: #ffb3b3;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 14px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-group i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
      font-size: 15px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 12px 12px 38px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      background-color: #ffffff;
      transition: all 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      transform: scale(1.03);
      box-shadow: 0 0 6px rgba(255, 215, 0, 0.6);
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #FFD700, #F3C623);
      border: none;
      color: #0a2a5e;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: bold;
    }

    button:hover {
      background: linear-gradient(135deg, #F3C623, #FFD700);
      transform: scale(1.05);
    }

    p {
      margin-top: 15px;
      color: #ffffff;
      font-size: 14px;
    }

    p a {
      color: #FFD700;
      text-decoration: none;
      font-weight: 500;
    }

    p a:hover {
      text-decoration: underline;
    }

    @media (max-width: 400px) {
      .container {
        width: 90%;
        padding: 30px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Login</h1>

    <?php if ($login_error) : ?>
      <div class="error-message"><?php echo $login_error; ?></div>
    <?php endif; ?>

    <form action="process_login_admin.php" method="POST">
      <div class="form-group">
        <i class="fa-solid fa-user"></i>
        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Admin" required>
      </div>
      <div class="form-group">
        <i class="fa-solid fa-lock"></i>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
      </div>
      <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register_admin.php">Daftar disini</a></p>
  </div>
</body>

</html>
