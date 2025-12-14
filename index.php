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
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body, html {
      margin: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
      background-color: #000;
    }

    /* ====== Overlay Elegan Hitam-Oranye ====== */
    .reveal {
      position: fixed;
      inset: 0;
      background-color: #000;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      animation: fadeOutWrapper 2.8s ease-in-out forwards 1.6s;
    }

    /* Lingkaran cahaya yang membesar */
    .reveal::before {
      content: "";
      position: absolute;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: radial-gradient(circle, #ff8c00 0%, #000 70%);
      filter: blur(30px);
      animation: circleExpand 1.8s cubic-bezier(0.77, 0, 0.175, 1) forwards;
    }

    /* Efek cahaya lembut di sekitar */
    /* ===== Overlay Elegan Melingkar (Versi Cepat & Smooth Sinkron) ===== */
    .reveal {
      position: fixed;
      inset: 0;
      background-color: #000;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      animation: fadeOutWrapper 2s ease-in-out forwards 1s;
    }

    /* Lingkaran utama */
    .reveal::before {
      content: "";
      position: absolute;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: radial-gradient(circle, #ff8c00 0%, #000 70%);
      filter: blur(25px);
      animation: circleExpand 1.5s cubic-bezier(0.77, 0, 0.175, 1) forwards;
    }

    /* Efek cahaya lembut */
    .reveal::after {
      content: "";
      position: absolute;
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 200, 100, 0.25), transparent 70%);
      filter: blur(40px);
      opacity: 0;
      animation: glowExpand 1.8s ease-in-out forwards;
    }

    /* ===== Animasi Lebih Singkat & Nyatu ===== */
    @keyframes circleExpand {
      0% {
        width: 0;
        height: 0;
        opacity: 1;
        transform: scale(1);
      }
      40% {
        opacity: 1;
        transform: scale(1.1);
      }
      100% {
        width: 2500px;
        height: 2500px;
        opacity: 0;
        transform: scale(1.2);
      }
    }

    @keyframes glowExpand {
      0% {
        opacity: 0.5;
        transform: scale(0.5);
      }
      60% {
        opacity: 0.8;
        transform: scale(1.1);
      }
      100% {
        opacity: 0;
        transform: scale(1.8);
      }
    }

    @keyframes fadeOutWrapper {
      to {
        opacity: 0;
        visibility: hidden;
      }
    }

    /* ====== Hero Section ====== */
    .hero {
      background: url(assets/images/bg1.webp) no-repeat center center/cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      color: white;
      text-align: center;
      opacity: 0;
      filter: blur(10px);
      animation: fadeInBg 1.5s ease forwards 0.8s;
    }

    @keyframes fadeInBg {
      0% { opacity: 0; filter: blur(10px) brightness(0.7); }
      100% { opacity: 1; filter: blur(0) brightness(1); }
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
      opacity: 0;
      transform: translateY(30px);
      animation: slideUp 1.2s ease-out forwards 1.2s;
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ====== Logo Pop In ====== */
    .hero img {
      width: 200px;
      margin-bottom: 20px;
      opacity: 0;
      transform: scale(0.3) rotate(-10deg);
      animation: popIn 1s cubic-bezier(0.68,-0.55,0.27,1.55) forwards 1.5s;
    }

    @keyframes popIn {
      to {
        opacity: 1;
        transform: scale(1) rotate(0);
      }
    }

    /* ====== Text Styling ====== */
    h1 {
      letter-spacing: 1px;
    }

    .highlight-ku {
      background: linear-gradient(90deg, #ffb347, #ffcc33, #ffb347);
      background-size: 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: shine 3s linear infinite;
    }

    @keyframes shine {
      to { background-position: 200% center; }
    }

    /* ====== Button Fun ====== */
    .btn-fun {
      background-color: #ff8c00;
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 50px;
      padding: 15px 35px;
      margin-top: 25px;
      font-size: 18px;
      transition: all 0.3s ease;
      box-shadow: 0 0 20px rgba(255,140,0,0.4);
      animation: breathing 2.8s ease-in-out infinite 2.3s;
    }

    @keyframes breathing {
      0%, 100% { transform: scale(1); box-shadow: 0 0 20px rgba(255,140,0,0.4); }
      50% { transform: scale(1.08); box-shadow: 0 0 30px rgba(255,165,0,0.7); }
    }

    .btn-fun:hover {
      background-color: #ffa500;
      transform: scale(1.1);
      box-shadow: 0 0 40px rgba(255,165,0,0.8);
    }
  </style>
</head>
<body>

  <!-- Overlay animasi hitam-oranye -->
  <div class="reveal"></div>

  <section class="hero">
    <div class="hero-content">
      <img src="assets/images/Maskot-Bulat.png" alt="Logo CIRAKU">
      <h1 class="fw-bold">Selamat Datang di CIRA<span class="highlight-ku">KU haloo wisnu ganteng kalcerr ilham</span></h1> 
      <p class="lead">Belanja cireng favoritmu, dari rasa klasik sampai inovasi terbaru, semua ada di sini.</p>
      <a href="dasbord/home.php" class="btn btn-fun">Aku Mau Cireng! 😋</a>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
