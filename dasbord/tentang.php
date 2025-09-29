
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - Ciraku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
            body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #000;
    }

    .navbar {
      border-bottom: 3px solid #fbbf24;
    }
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }

    
    .section-title {
      color: #f9a825;
      font-weight: bold;
    }
    .tentang-img {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      max-width: 100%;
      height: auto;
    }
    footer {
      margin-top: 50px;
      padding: 20px 0;
      background: #111;
      color: #aaa;
      text-align: center;
    }
  </style>
</head>
<body>
  
<?php include 'navbar.php'; ?>

<!-- Tentang Kami Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title mb-4 text-center">Tentang Kami</h2>
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0 text-center">
        <img src="../assets/images/tentang-kami.jpg" alt="Tentang Ciraku" class="tentang-img">
      </div>
      <div class="col-md-6">
        <h4 class="mb-3">Kenapa memilih cireng kami?</h4>
        <p>
          Cireng kami dibuat dengan bahan berkualitas, dipadukan dengan bumbu spesial yang kaya rasa.
          Teksturnya renyah di luar, kenyal di dalam, serta tersedia dalam berbagai varian rasa kekinian
          yang bikin nagih.
        </p>
        <p>
          Cireng kami renyah, kenyal, berbumbu spesial, dan tersedia dalam berbagai varian rasa kekinian
          yang lezat, gurih, serta bikin nagih.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container">
    <small>© 2025 Ciraku. All rights reserved.</small>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
