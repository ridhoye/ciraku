<?php
include "../config/db.php";

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // enkripsi password

    // Cek apakah username sudah ada
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah digunakan, coba yang lain'); window.location='register.php';</script>";
        exit;
    }

    // Insert ke DB
    $sql = "INSERT INTO users (username, email, phone, password) 
            VALUES ('$username', '$email', '$phone', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registrasi berhasil! Silahkan login'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - CIRAKU</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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

/* Overlay gelap */
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

/* ✨ Animasi fade */
@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(40px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 1; }
}

/* Logo + animasi */
.logo-box {
  text-align: center;
  color: white;
  animation: fadeIn 1.3s ease-out;
}

.logo-box img {
  width: 260px;
  max-width: 80%;
  margin-bottom: 20px;
}

/* Register box */
.register-box {
  background: rgba(91, 84, 84, 0.15);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  padding: 40px 30px;
  width: 100%;
  max-width: 380px;
  color: white;
  animation: fadeInUp 1.2s ease-out;
}

h4 {
  animation: fadeIn 1s ease-in;
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
  border: none;
  background-color: #fbbf24;
  color: #000;
  transition: 0.3s;
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
  transform: scale(1.2);
}

/* Tombol kembali (optional) */
.btn-outline-light {
  border-radius: 10px;
  font-weight: 500;
  backdrop-filter: blur(5px);
  transition: 0.3s;
}

.btn-outline-light:hover {
  background-color: #fbbf24;
  color: #000;
  border-color: #fbbf24;
}

/* 🔹 RESPONSIVE FIX */
@media (max-width: 992px) {
  .row {
    flex-direction: column;
  }
  .logo-box img {
    width: 200px;
    margin-bottom: 10px;
  }
  .register-box {
    padding: 35px 25px;
    max-width: 90%;
  }
}

@media (max-width: 576px) {
  .bg {
    padding: 20px;
  }
  .register-box {
    padding: 30px 20px;
    max-width: 100%;
  }
  h4 {
    font-size: 1.2rem;
  }
  .btn-outline-light {
    font-size: 0.85rem;
    padding: 6px 10px;
  }
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
            <img src="../assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
          </div>
        </div>

        <!-- Kolom kanan (Form Register) -->
        <div class="col-lg-6 d-flex justify-content-center">
          <div class="register-box shadow-lg">
            <h4 class="text-center mb-4">Register</h4>
            <!-- di register.php -->
              <form method="POST" action="">
                <div class="mb-3">
                  <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                  <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                  <input type="text" name="phone" class="form-control" placeholder="Nomor HP (Opsional)">
                </div>
                <div class="mb-3">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Register</button>
              </form>

            
            <div class="text-center mt-3">——— atau ———</div>

            <div class="social-login text-center mt-2">
              <a href="#" class="mx-2"><i class="bi bi-twitter" style="font-size: 1.5rem; color:#1DA1F2;"></i></a>
              <a href="#" class="mx-2"><i class="bi bi-tiktok" style="font-size: 1.5rem; color:#000;"></i></a>
              <a href="#" class="mx-2"><i class="bi bi-google" style="font-size: 1.5rem; color:#DB4437;"></i></a>
            </div>

            <div class="text-center mt-2">
              Sudah Punya akun di CIRAKU? <a href="login.php" class="text-warning fw-bold">Login</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
