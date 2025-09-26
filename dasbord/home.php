<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ciraku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #000;
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

    /* Hero Section */
    .hero {
      height: 100vh;
      display: flex;
      align-items: center;
      color: white;
      padding: 20px;
      background: url("../assets/images/dasbord-bg.jpg") no-repeat center center;
      background-size: cover;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.55);
      z-index: 1;
    }

  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 700px;
    padding-left: 1.5rem; /* geser ke kanan */
  }

    .hero h1 {
      font-weight: 700;
      font-size: 2rem; /* mobile */
    }
    .hero h1 span {
      color: #fbbf24;
    }

    .hero p {
      margin-top: 1rem;
      font-size: 1rem;
    }

    /* Desktop lebih besar */
    @media (min-width: 992px) {
      .hero h1 {
        font-size: 3.5rem; /* lebih besar di desktop */
        line-height: 1.2;
      }
      .hero p {
        font-size: 1.4rem;
        max-width: 600px;
      }
    }

    .btn-warning {
      background-color: #fbbf24;
      border: none;
      color: #000;
      font-weight: bold;
      padding: 12px 30px;
      border-radius: 50px;
      font-size: 1.1rem;
      margin-top: 1.5rem;
      box-shadow: 0 4px 15px rgba(251,191,36,0.5);
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      transform: scale(1.05);
      box-shadow: 0 6px 20px rgba(251,191,36,0.7);
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
    <div class="hero-content">
      <h1 class="fw-bold">Mari Rasakan<br>Rasanya CIRA<span>KU</span></h1>
      <p>Kreasi cireng dengan rasa kekinian dan perpaduan bumbu spesial yang bikin nagih CIRAKU (cireng rasa kusuka).</p>
      <a href="../login.php" class="btn btn-warning">Beli Sekarang</a>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
