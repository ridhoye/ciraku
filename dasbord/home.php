<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ciraku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      margin: 0;
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
      background: url("../assets/images/dasbord-bg.jpg") no-repeat center center;
      background-size: cover;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.45); /* overlay biar teks makin jelas */
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
      font-size: 2rem; /* mobile default */
    }
    .hero h1 span {
      color: #fbbf24;
    }
    .hero p {
      margin-top: 1rem;
      font-size: 1rem;
    }

    @media (min-width: 992px) {
      .hero h1 {
        font-size: 3.5rem;
        line-height: 1.2;
      }
      .hero p {
        font-size: 1.4rem;
        max-width: 750px;
      }
      .hero-content {
        padding-left: 2rem; /* desktop geser lebih */
      }
    }

    .btn-warning {
      background-color: #fbbf24;
      border: none;
      color: #000;
      font-weight: bold;
      padding: 12px 28px;
      border-radius: 12px;
      font-size: 1.1rem;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      color: #000;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <h1 class="fw-bold">Mari Rasakan<br>Rasanya CIRA<span>KU</span></h1>
        <p class="lead">Kreasi cireng dengan rasa kekinian dan perpaduan bumbu spesial yang bikin nagih CIRAKU (cireng rasa kusuka).</p>
        <a href="../payment/order.php" class="btn btn-warning btn-lg mt-3">Beli Sekarang</a>
      </div>
    </div>
  </section>


 <?php include 'footer.php'; ?>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
