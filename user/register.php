<?php
include "../config/db.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - CIRAKU</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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

    @keyframes fadeIn {
      0% { opacity: 0; } 100% { opacity: 1; }
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

    .register-box {
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
  padding: 12px 16px;
  font-size: 15px;
  background: rgba(255, 255, 255, 0.1); /* warna abu lembut transparan */
  border: 1px solid rgba(255, 255, 255, 0.25);
  color: #e5e5e5; /* warna teks di dalam textbox */
  outline: none;
  backdrop-filter: blur(10px); /* efek kaca buram */
  -webkit-backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.form-control::placeholder {
  color: rgba(255, 255, 255, 0.7); /* abu lembut kayak di login */
  font-weight: 400;
}

.form-control:focus {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(251, 191, 36, 0.6); /* warna kuning highlight */
  box-shadow: 0 0 10px rgba(251, 191, 36, 0.3);
  color: #fff;
}

    .btn-warning {
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      background-color: #fbbf24;
      color: #000;
      transition: 0.3s;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      color: #000;
      transform: translateY(-1px);
    }

    .text-center a {
      color: #fbbf24;
      text-decoration: none;
      font-weight: 500;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    @media (max-width: 992px) {
      .row { flex-direction: column; text-align: center; }
      .register-box { margin-top: 30px; max-width: 90%; }
      .logo-box img { width: 200px; margin-bottom: 10px; }
    }

    @media (max-width: 576px) {
      .bg { padding: 20px; }
      .register-box { padding: 30px 20px; max-width: 100%; }
      h4 { font-size: 1.2rem; }
    }
  </style>
</head>
<body>
  <div class="bg">
    <div class="overlay container">
      <div class="row align-items-center w-100">
        <div class="col-lg-6 d-flex justify-content-center mb-5 mb-lg-0">
          <div class="logo-box">
            <img src="../assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
          </div>
        </div>

        <div class="col-lg-6 d-flex justify-content-center">
          <div class="register-box shadow-lg">
            <h4>Daftar Akun</h4>
            <form method="POST" action="">
              <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
              </div>
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
              <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Nomor HP (Opsional)">
              </div>
              <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-warning w-100">Daftar Sekarang</button>
            </form>

            <div class="text-center mt-3">
              Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Username sudah digunakan!',
            text: 'Coba pilih username lain ya 😉',
            confirmButtonColor: '#fbbf24'
        });
        </script>";
        exit;
    }

    $sql = "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: 'Akun kamu berhasil dibuat, silakan login sekarang 😎',
            showConfirmButton: false,
            timer: 1800
        }).then(() => { window.location = 'login.php'; });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Registrasi!',
            text: 'Terjadi kesalahan di server, coba lagi nanti.',
            confirmButtonColor: '#fbbf24'
        });
        </script>";
    }
}
?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
