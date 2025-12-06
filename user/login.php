<?php
session_start();
include "../config/db.php";
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
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    .bg {
      background: url(../assets/images/bg1.webp) no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .bg::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.55);
      z-index: 1;
    }

    .container {
      position: relative;
      z-index: 2;
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(40px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .logo-box {
      text-align: center;
      color: white;
      animation: fadeInUp 1.3s ease-out;
    }
    .logo-box img {
      width: 260px;
      max-width: 80%;
      margin-bottom: 20px;
      filter: drop-shadow(0 0 10px rgba(255,255,255,0.2));
    }

    .login-box {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      border-radius: 20px;
      padding: 45px 35px;
      width: 100%;
      max-width: 380px;
      color: white;
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      animation: fadeInUp 1.2s ease-out;
    }

    h4 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 25px;
      letter-spacing: 0.5px;
    }

    .form-control {
      border-radius: 12px;
      padding: 12px 15px;
      font-size: 1rem;
      border: none;
      outline: none;
      background: rgba(255,255,255,0.15);
      color: white;
    }
    .form-control::placeholder {
      color: rgba(255,255,255,0.7);
    }

    .form-control:focus {
      background: rgba(255,255,255,0.2);
      border: 1px solid #fbbf24;
      box-shadow: 0 0 10px rgba(251,191,36,0.4);
    }

    .btn-warning {
      border-radius: 12px;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      background-color: #fbbf24;
      border: none;
      transition: all 0.3s;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      transform: scale(1.02);
    }

    .text-divider {
      text-align: center;
      position: relative;
      margin: 25px 0;
      color: rgba(255,255,255,0.6);
    }
    .text-divider::before,
    .text-divider::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 35%;
      height: 1px;
      background: rgba(255,255,255,0.3);
    }
    .text-divider::before { left: 0; }
    .text-divider::after { right: 0; }

    .register-link a {
      color: #fbbf24;
      text-decoration: none;
      font-weight: 600;
    }
    .register-link a:hover {
      color: #f59e0b;
      text-decoration: underline;
    }
    /*MOFE MOBILE */
    @media (max-width: 768px) {
      .row {  
      margin-left: 0 !important;
      margin-right: 0 !important; 
    }
      .logo-box img { width: 200px; margin-bottom: 10px }
      .login-box { padding: 35px 25px; max-width: 90%; }
    }
  </style>
</head>
<body>
  <div class="bg">
    <div class="overlay container">
      <a href="../dasbord/home.php" class="btn btn-outline-light position-absolute top-0 start-0 m-4 px-3 py-2">
        <i class="bi bi-arrow-left"></i> 
      </a>

      <div class="row align-items-center justify-content-center w-100">
        <div class="col-lg-6 d-flex justify-content-center mb-5 mb-lg-0">
          <div class="logo-box">
            <img src="../assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
          </div>
        </div>

        <div class="col-lg-6 d-flex justify-content-center">
          <div class="login-box shadow-lg">
            <h4>Login</h4>
            <form method="POST" action="">
              <div class="mb-3">
                <input type="text" name="identifier" class="form-control form-control-lg" placeholder="Email / No. HP / Username" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-warning w-100 py-2">Log in</button>
            </form>

            <div class="register-link text-center mt-3">
              Belum punya akun? <a href="register.php">Daftar Sekarang</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
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

              if ($user['role'] === 'admin') {
                  echo "
                  <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Berhasil!',
                      text: 'Selamat datang kembali, Admin!',
                      showConfirmButton: false,
                      timer: 1800,
                      timerProgressBar: true,
                      didClose: () => {
                          window.location = '../admin/panel_admin.php';
                      }
                  });
                  </script>";
              } else {
                  echo "
                  <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Sukses!',
                      text: 'Selamat datang, {$user['username']}!',
                      showConfirmButton: false,
                      timer: 1800,
                      timerProgressBar: true,
                      didClose: () => {
                          window.location = '../dasbord/home.php';
                      }
                  });
                  </script>";
              }
          } else {
              echo "
              <script>
              Swal.fire({
                  icon: 'error',
                  title: 'Password Salah!',
                  text: 'Coba periksa kembali password kamu.',
                  showConfirmButton: true,
                  confirmButtonColor: '#fbbf24'
              });
              </script>";
          }
      } else {
          echo "
          <script>
          Swal.fire({
              icon: 'warning',
              title: 'User Tidak Ditemukan!',
              text: 'Pastikan kamu sudah terdaftar atau isi data dengan benar.',
              showConfirmButton: true,
              confirmButtonColor: '#fbbf24'
          });
          </script>";
      }
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
