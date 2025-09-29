<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }
    .logo span {
      color: #fbbf24;
    }

    /* Section menu */
    .menu-section {
      padding: 80px 20px;
    }

    /* Judul section */
    .section-title {
      color: #fff;
      font-weight: 700;
      text-align: center;
      margin-bottom: 50px;
    }
    .section-title span {
      color: #fbbf24; /* kata pertama kuning */
    }

    /* Card menu */
    .card {
      background: #111;
      border: none;
      border-radius: 20px;
      overflow: hidden;
      text-align: center;
      color: #fff;
      transition: transform .3s;
    }
    .card:hover {
      transform: scale(1.05);
    }
    .card img {
      border-bottom: 2px solid #fbbf24;
    }
    .card-title {
      font-weight: 600;
      margin-top: 15px;
    }
    .card-text {
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <section class="menu-section container">
    <h2 class="section-title"><span>Menu</span> Kami</h2>
    <div class="row g-4">
      <!-- Item 1 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/ayam.png" class="card-img-top" alt="Cireng Isi Ayam">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Ayam</h5>
            <p class="card-text">Cireng renyah dengan isian ayam suwir pedas yang gurih dan nikmat.</p>
          </div>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/kornet.png" class="card-img-top" alt="Cireng Isi Kornet">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Kornet</h5>
            <p class="card-text">Cireng crispy dengan isian kornet sapi lezat, cocok untuk camilan hangat.</p>
          </div>
        </div>
      </div>
      <!-- Item 3 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/keju.png" class="card-img-top" alt="Cireng Isi Keju">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Keju</h5>
            <p class="card-text">Cireng garing dengan lelehan keju creamy di dalamnya, rasa gurih dan lumer.</p>
          </div>
        </div>
      </div>
      <!-- Item 4 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/sosis.png" class="card-img-top" alt="Cireng Isi Sosis">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Sosis</h5>
            <p class="card-text">Cireng kenyal dengan isian sosis pilihan, pas banget untuk semua usia.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }
    .logo span {
      color: #fbbf24;
    }

    /* Section menu */
    .menu-section {
      padding: 80px 20px;
    }

    /* Judul section */
    .section-title {
      color: #fff;
      font-weight: 700;
      text-align: center;
      margin-bottom: 50px;
    }
    .section-title span {
      color: #fbbf24; /* kata pertama kuning */
    }

    /* Card menu */
    .card {
      background: #111;
      border: none;
      border-radius: 20px;
      overflow: hidden;
      text-align: center;
      color: #fff;
      transition: transform .3s;
    }
    .card:hover {
      transform: scale(1.05);
    }
    .card img {
      border-bottom: 2px solid #fbbf24;
    }
    .card-title {
      font-weight: 600;
      margin-top: 15px;
    }
    .card-text {
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <section class="menu-section container">
    <h2 class="section-title"><span>Menu</span> Kami</h2>
    <div class="row g-4">
      <!-- Item 1 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/ayam.png" class="card-img-top" alt="Cireng Isi Ayam">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Ayam</h5>
            <p class="card-text">Cireng renyah dengan isian ayam suwir pedas yang gurih dan nikmat.</p>
          </div>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/kornet.png" class="card-img-top" alt="Cireng Isi Kornet">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Kornet</h5>
            <p class="card-text">Cireng crispy dengan isian kornet sapi lezat, cocok untuk camilan hangat.</p>
          </div>
        </div>
      </div>
      <!-- Item 3 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/keju.png" class="card-img-top" alt="Cireng Isi Keju">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Keju</h5>
            <p class="card-text">Cireng garing dengan lelehan keju creamy di dalamnya, rasa gurih dan lumer.</p>
          </div>
        </div>
      </div>
      <!-- Item 4 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/sosis.png" class="card-img-top" alt="Cireng Isi Sosis">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Sosis</h5>
            <p class="card-text">Cireng kenyal dengan isian sosis pilihan, pas banget untuk semua usia.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }
    .logo span {
      color: #fbbf24;
    }

    /* Section menu */
    .menu-section {
      padding: 80px 20px;
    }

    /* Judul section */
    .section-title {
      color: #fff;
      font-weight: 700;
      text-align: center;
      margin-bottom: 50px;
    }
    .section-title span {
      color: #fbbf24; /* kata pertama kuning */
    }

    /* Card menu */
    .card {
      background: #111;
      border: none;
      border-radius: 20px;
      overflow: hidden;
      text-align: center;
      color: #fff;
      transition: transform .3s;
    }
    .card:hover {
      transform: scale(1.05);
    }
    .card img {
      border-bottom: 2px solid #fbbf24;
    }
    .card-title {
      font-weight: 600;
      margin-top: 15px;
    }
    .card-text {
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <section class="menu-section container">
    <h2 class="section-title"><span>Menu</span> Kami</h2>
    <div class="row g-4">
      <!-- Item 1 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/ayam.png" class="card-img-top" alt="Cireng Isi Ayam">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Ayam</h5>
            <p class="card-text">Cireng renyah dengan isian ayam suwir pedas yang gurih dan nikmat.</p>
          </div>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/kornet.png" class="card-img-top" alt="Cireng Isi Kornet">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Kornet</h5>
            <p class="card-text">Cireng crispy dengan isian kornet sapi lezat, cocok untuk camilan hangat.</p>
          </div>
        </div>
      </div>
      <!-- Item 3 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/keju.png" class="card-img-top" alt="Cireng Isi Keju">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Keju</h5>
            <p class="card-text">Cireng garing dengan lelehan keju creamy di dalamnya, rasa gurih dan lumer.</p>
          </div>
        </div>
      </div>
      <!-- Item 4 -->
      <div class="col-md-3 col-sm-6">
        <div class="card">
          <img src="../assets/images/sosis.png" class="card-img-top" alt="Cireng Isi Sosis">
          <div class="card-body">
            <h5 class="card-title">Cireng Isi Sosis</h5>
            <p class="card-text">Cireng kenyal dengan isian sosis pilihan, pas banget untuk semua usia.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
