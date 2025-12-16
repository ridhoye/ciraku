<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - Ciraku</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #000;
      color: #fff;
    }

    .navbar {
      border-bottom: 3px solid #fbbf24;
    }

    .section-title {
      margin-top: 25px;
      font-weight: 700;
      color: #fff;
    }

    .section-title span {
      color: #fbbf24;
    }

    /* Tentang Kami Image */
    .tentang-img {
      border-radius: 16px;
      max-width: 100%;
      box-shadow: 0 8px 20px rgba(0,0,0,0.6);
      transition: transform 0.3s ease;
    }

    .tentang-img:hover {
      transform: scale(1.05);
    }

    /* ===== TEAM SECTION ===== */
    .team-card {
      background: #111;
      border-radius: 20px;
      padding: 30px 20px;
      text-align: center;
      transition: all 0.3s ease;
      height: 100%;
    }

    .team-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 30px rgba(251,191,36,0.3);
    }

    .team-img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 25%;
      margin-bottom: 15px;
    }

    .team-name {
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 5px;
    }

    .team-role {
      font-size: 0.9rem;
      color: #fbbf24;
    }

    @media (min-width: 992px) {
      .tentang-img {
        max-width: 70%;
      }
    }
  </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<!-- ===== TENTANG KAMI ===== -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title mb-5 text-center" data-aos="fade-up">
      <span>Tentang</span> Kami
    </h2>

    <div class="row align-items-center">
      <div class="col-md-6 text-center mb-4" data-aos="fade-right">
        <img src="../assets/images/produk.png" alt="Tentang Ciraku" class="tentang-img">
      </div>

      <div class="col-md-6" data-aos="fade-left">
        <h4 class="mb-3">Kenapa memilih cireng kami?</h4>
        <p>

Cireng kami dibuat dengan bahan berkualitas, dipadukan dengan bumbu spesial yang kaya rasa. Teksturnya renyah di luar, kenyal di dalam, serta tersedia dalam berbagai varian rasa kekinian yang bikin nagih.
Cireng kami renyah, kenyal, berbumbu spesial, dan tersedia dalam berbagai varian rasa kekinian yang lezat, gurih, serta bikin nagih.
        </p>
        <p>
          Cocok untuk semua kalangan, gurih, lezat, dan bikin nagih!
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== TIM KAMI ===== -->
<section class="py-5 bg-black">
  <div class="container">
    <h2 class="section-title text-center mb-5" data-aos="fade-up">
      <span>Tim</span> Kami
    </h2>

    <div class="row g-4 justify-content-center">

      <!-- Anggota 1 -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="team-card">
          <img src="../assets/images/wisnu.jpg" alt="Anggota 1" class="team-img">
          <h5 class="team-name">Wisnu Septa</h5>
          <p class="team-role">Fullstack Developer</p>
        </div>
      </div>

      <!-- Anggota 2 -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="team-card">
          <img src="../assets/images/rido.jpg" alt="Anggota 2" class="team-img">
          <h5 class="team-name">Ridhoi Wahyu</h5>
          <p class="team-role">Backend Developer</p>
        </div>
      </div>

      <!-- Anggota 3 -->
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="team-card">
          <img src="../assets/images/nopal.jpg" alt="Anggota 3" class="team-img">
          <h5 class="team-name">Nawfal Krisna</h5>
          <p class="team-role">Frontend Developer</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

</body>
</html>
