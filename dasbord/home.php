<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ciraku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      border-bottom: 3px solid #fbbf24;
    }
    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }
    .logo span {
      color: #fbbf24;
    }
    .hero {
  min-height: 85vh;
  display: flex;
  align-items: center;
  color: white;
  padding: 60px 20px;

  /* Animasi gradien background */
  background: linear-gradient(-45deg, #ffcc00, #ff6f00, #333333, #000000);
  background-size: 400% 400%;
  animation: gradientMove 13s ease infinite;
}

@keyframes gradientMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

    .hero h1 span {
      color: #fbbf24;
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
    .hero img {
  border-radius: 12px;
  max-width: 100%;
  animation: zoomIn 1.5s ease forwards, float 4s ease-in-out infinite;
}

@keyframes zoomIn {
  from { opacity: 0; transform: scale(0.8); }
  to   { opacity: 1; transform: scale(1); }
}

@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0px); }
}

  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">
    <div class="container-fluid">
      <a class="navbar-brand logo" href="#">cira<span>ku</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active bg-warning text-dark rounded px-3" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Kontak</a>
          </li>
        </ul>
        <div class="d-flex gap-3 text-white">
          <span>👤</span>
          <span>🔍</span>
          <span>🛒</span>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <!-- Teks -->
        <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
          <h1 class="fw-bold display-5">Mari Rasakan<br>Rasanya CIRA<span>KU</span></h1>
          <p class="lead mt-3">Kreasi cireng dengan rasa kekinian dan perpaduan bumbu spesial yang bikin nagih CIRAKU (cireng rasa kusuka).</p>
          <a href="../login.php" class="btn btn-warning btn-lg mt-3">Beli Sekarang</a>
        </div>
        <!-- Gambar -->
        <div class="col-lg-6 col-md-12 text-center">
          <img src="../assets/images/dasbord-bg.jpg" alt="Cireng" class="img-fluid shadow-lg">
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





