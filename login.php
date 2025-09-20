<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ciraku</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #fff;
      color: #333;
    }

    /* Navbar */
    header {
      background: #000;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 3px solid #fbbf24;
    }

    header .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }

    header .logo span {
      color: #fbbf24;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav ul li a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      padding: 6px 12px;
      border-radius: 15px;
      transition: 0.3s;
    }

    nav ul li a.active {
      background: #fbbf24;
      color: #000;
    }

    nav ul li a:hover {
      background: #fbbf24;
      color: #000;
    }

    .icons {
      display: flex;
      align-items: center;
      gap: 15px;
      color: white;
      font-size: 18px;
      cursor: pointer;
    }

    /* Hero Section */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 50px 80px;
      background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.6)), url('https://source.unsplash.com/600x400/?snack,food') no-repeat center/cover;
      color: white;
      min-height: 85vh;
    }

    .hero-text {
      max-width: 50%;
    }

    .hero-text h1 {
      font-size: 48px;
      line-height: 1.3;
      font-weight: bold;
    }

    .hero-text h1 span {
      color: #fbbf24;
    }

    .hero-text p {
      margin: 20px 0;
      font-size: 18px;
      line-height: 1.6;
    }

    .hero-text .btn {
      background: #fbbf24;
      color: #000;
      padding: 12px 25px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s;
    }

    .hero-text .btn:hover {
      background: #f59e0b;
    }

    .hero-img img {
      width: 400px;
      border-radius: 12px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header>
    <div class="logo">cira<span>ku</span></div>
    <nav>
      <ul>
        <li><a href="#" class="active">Home</a></li>
        <li><a href="#">Tentang Kami</a></li>
        <li><a href="#">Menu</a></li>
        <li><a href="#">Kontak</a></li>
      </ul>
    </nav>
    <div class="icons">
      <span>👤</span>
      <span>🔍</span>
      <span>🛒</span>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-text">
      <h1>Mari Rasakan<br>Rasanya CIRA<span>KU</span></h1>
      <p>Kreasi cireng dengan rasa kekinian dan perpaduan bumbu spesial yang bikin nagih CIRAKU (cireng rasa kusuka).</p>
      <a href="#" class="btn">Beli Sekarang</a>
    </div>
    <div class="hero-img">
      <img src="https://source.unsplash.com/400x400/?fried-snack" alt="Cireng">
    </div>
  </section>
</body>
</html>
