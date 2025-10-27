<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - Ciraku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- AOS (Animate On Scroll) -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #000;
      color: #fff;
    }

    .navbar {
      border-bottom: 3px solid #fbbf24;
    }

    /* Title Section Default Putih */
    .section-title {
      color: #fff;
      font-weight: bold;
    }

    /* Span di dalam section-title jadi kuning */
    .section-title span {
      color: #fbbf24;
    }

    .tentang-img {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      max-width: 80%;
      height: auto;
      transition: transform 0.3s ease;
    }

    .tentang-img:hover {
      transform: scale(1.05);
    }

    /* responsif img */
    @media (min-width: 992px) {
      .tentang-img {
        max-width: 70%;
      }
    }
  </style>
</head>
<body>
  
  <?php include 'navbar.php'; ?>

  <!-- Tentang Kami Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title mb-4 text-center" data-aos="fade-up" data-aos-duration="1000">
        <span class="text-warning">Tentang</span> Kami
      </h2>

      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0 text-center" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
          <img src="../assets/images/tentang-kami.jpg" alt="Tentang Ciraku" class="tentang-img">
        </div>
        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <h4 class="mb-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">Kenapa memilih cireng kami?</h4>
          <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            Cireng kami dibuat dengan bahan berkualitas, dipadukan dengan bumbu spesial yang kaya rasa.
            Teksturnya renyah di luar, kenyal di dalam, serta tersedia dalam berbagai varian rasa kekinian
            yang bikin nagih.
          </p>
          <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            Cireng kami renyah, kenyal, berbumbu spesial, dan tersedia dalam berbagai varian rasa kekinian
            yang lezat, gurih, serta bikin nagih.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'footer.php'?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS JS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Inisialisasi AOS
    AOS.init({
      duration: 1000,
      easing: 'ease-out-cubic',
      once: true
    });
  </script>
</body>
</html>