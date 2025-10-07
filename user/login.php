<?php
session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    $password   = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE username='$identifier' OR email='$identifier' OR phone='$identifier' 
            LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['logged_in'] = true;

            // arahkan sesuai role
            if ($user['role'] === 'admin') {
                echo "<script>alert('Login berhasil, selamat datang Admin'); window.location='../admin/index.php';</script>";
            } else {
                echo "<script>alert('Login berhasil, selamat datang {$user['username']}'); window.location='../dasbord/home.php';</script>";
            }
            exit;
        } else {
            echo "<script>alert('Password salah'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan'); window.location='login.php';</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - CIRAKU</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
  }

  .bg {
    background: url(../assets/images/bg1.webp) no-repeat center center/cover;
    height: 100%;
    display: flex;
    align-items: center;
    position: relative; /* penting buat overlay */
  }

  /* Overlay Gelap */
  .bg::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* atur opacity sesuai selera */
    z-index: 1;
  }

  .container {
    position: relative;
    z-index: 2; /* biar konten di atas overlay */
  }

  .logo-box {
    text-align: center;
    color: white;
  }

  .logo-box img {
    width: 300px;
    margin-bottom: 20px;
  }

  .login-box {
    background: rgba(91, 84, 84, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 70px;
    width: 100%;
    max-width: 400px;
    color: white;
  }

  .form-control {
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 1rem;
  }

  .btn-warning {
    border-radius: 10px;
    padding: 12px;
    font-size: 1rem;
    font-weight: 600;
  }

  .btn-warning:hover {
    background-color: #f59e0b;
    color: #000;
  }

  .social-login {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 15px 0;
  }

  .social-login a {
    font-size: 22px;
    color: white;
    text-decoration: none;
    transition: 0.3s;
  }

  .social-login a:hover {
    color: #fbbf24;
  }
</style>

</head>
<body>
  <div class="bg">
    <div class="overlay container">
      <div class="row align-items-center w-100">
        
        <!-- Kolom kiri (Logo) -->
        <div class="col-lg-6 d-flex justify-content-center mb-5 mb-lg-0">
          <div class="logo-box">
            <!-- ganti logo sesuai file lu -->
            <img src="../assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
          </div>
        </div>

        <!-- Kolom kanan (Form Login) -->
        <div class="col-lg-6 d-flex justify-content-center">
          <div class="login-box shadow-lg">
            <h4 class="text-center mb-4">Login</h4>
            <!-- di login.php -->
              <form method="POST" action="">
                <div class="mb-3">
                  <input type="text" name="identifier" class="form-control form-control-lg" placeholder="Email • No.HP • Username">
                </div>
                <div class="mb-3">
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-warning w-100 py-2">Log in</button>
              </form>
            <div class="text-center mt-3">——— atau ———</div>

            
<div class="social-login text-center mt-2">
  <a href="#" class="mx-2"><i class="bi bi-twitter" style="font-size: 1.5rem; color:#1DA1F2;"></i></a>
  <a href="#" class="mx-2"><i class="bi bi-tiktok" style="font-size: 1.5rem; color:#000;"></i></a>
  <a href="#" class="mx-2"><i class="bi bi-google" style="font-size: 1.5rem; color:#DB4437;"></i></a>
</div>

            
            <div class="text-center mt-2">
              Baru di CIRAKU? <a href="register.php" class="text-warning fw-bold">Daftar</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS & Icons -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
