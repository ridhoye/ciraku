<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - CIRAKU</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    .bg {
      background: url('https://source.unsplash.com/1600x900/?fried-snack,food') no-repeat center center/cover;
      height: 100%;
      display: flex;
      align-items: center;
    }

    .overlay {
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4); /* biar teks lebih jelas */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .logo-box {
      text-align: center;
      color: white;
    }

    .logo-box img {
      width: 100px;
      margin-bottom: 15px;
    }

    .logo-box h1 {
      font-size: 40px;
      font-weight: bold;
    }

    .logo-box h1 span {
      color: #fbbf24;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 30px;
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
            <!-- ganti logo sesuai file lu -->
            <img src="https://cdn-icons-png.flaticon.com/512/706/706830.png" alt="Logo CIRAKU">
            <h1>CIRA<span>KU</span></h1>
          </div>
        </div>

        <!-- Kolom kanan (Form Login) -->
        <div class="col-lg-6 d-flex justify-content-center">
          <div class="login-box shadow-lg">
            <h4 class="text-center mb-4">Login</h4>
            <form>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="email • No.HP • username">
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-warning w-100">Log in</button>
            </form>
            
            <div class="text-center mt-3">——— atau ———</div>
            
            <div class="social-login">
              <a href="#"><i class="bi bi-twitter"></i></a>
              <a href="#"><i class="bi bi-tiktok"></i></a>
              <a href="#"><i class="bi bi-google"></i></a>
            </div>
            
            <div class="text-center mt-2">
              Baru di CIRAKU? <a href="#" class="text-warning fw-bold">Daftar</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS & Icons -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
