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
  }

  .bg {
    background: url(../assets/images/bg1.webp) no-repeat center center/cover;
    height: 100%;
    display: flex;
    align-items: center;
    position: relative;
  }

  /* Overlay Gelap */
  .bg::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .container {
    position: relative;
    z-index: 2;
  }

  .logo-box {
    text-align: center;
    color: white;
  }

  .logo-box img {
    width: 300px;
    margin-bottom: 20px;
  }

  .register-box {
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
  }

  .btn-warning {
    background-color: #fbbf24;
    border: none;
    color: #000;
    font-weight: bold;
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
            <img src="../assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
          </div>
        </div>

        <!-- Kolom kanan (Form Register) -->
        <div class="col-lg-6 d-flex justify-content-center">
          <div class="register-box shadow-lg">
            <h4 class="text-center mb-4">Register</h4>
            <!-- di register.php -->
<form method="POST" action="register_action.php">

            <form>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="username">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="email • No.HP">
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password">
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
