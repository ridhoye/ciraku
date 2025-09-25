<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CIRAKU - Selamat Datang</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    body, html {
      margin: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
    }

    .hero {
      background: url(assets/images/bg1.webp) no-repeat center center/cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      color: white;
      text-align: center;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 700px;
      padding: 20px;
    }

    .hero img {
      width: 200px;
      margin-bottom: 20px;
    }

    .btn-fun {
      background-color: #fbbf24;
      border: none;
      color: #000;
      font-weight: bold;
      border-radius: 50px; /* bikin tombol lebih lucu */
      padding: 15px 35px;
      margin-top: 20px;
      font-size: 18px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(251,191,36,0.5);
    }

    .btn-fun:hover {
      background-color: #f59e0b;
      transform: scale(1.08);
      box-shadow: 0 6px 20px rgba(251,191,36,0.7);
    }
  </style>
</head>
<body>

  <section class="hero">
    <div class="hero-content">
      <img src="assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
      <h1 class="fw-bold">Selamat Datang di CIRAKU</h1>
      <p class="lead">Belanja cireng favoritmu, dari rasa klasik sampai inovasi terbaru, semua ada di sini.</p>
      
      <!-- Tombol lucu -->
      <a href="dasbord/home.php" class="btn btn-fun">Aku Mau Cireng! 😋</a>
    </div>
  </section>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
