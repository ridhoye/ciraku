<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ciraku</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- AOS (Animate On Scroll) -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #000;
      color: #fff;
      overflow-x: hidden;
      transition: background 1s ease;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(8px);
      border-bottom: 2px solid #fbbf24;
      transition: all 0.6s ease;
      animation: slideDown 1s ease-out;
    }

    .navbar.scrolled {
      background: rgba(0, 0, 0, 0.9);
      box-shadow: 0 3px 12px rgba(0,0,0,0.3);
    }

    @keyframes slideDown {
      from { transform: translateY(-60px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .logo {
      font-size: 22px;
      font-weight: bold;
      color: #fff;
    }

    .logo span {
      color: #fbbf24;
    }

    /* ===== HERO SECTION ===== */
    .hero {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: left;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)),
                  url("../assets/images/dasbord-bg.jpg") no-repeat center center;
      background-size: cover;
      position: relative;
      animation: fadeInBg 1.5s ease-out;
    }

    @keyframes fadeInBg {
      from { opacity: 0; transform: scale(1.05); }
      to { opacity: 1; transform: scale(1); }
    }

    .hero-content {
      max-width: 700px;
      padding: 0 1.5rem;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      line-height: 1.2;
      color: #fff;
    }

    .hero h1 span {
      color: #fbbf24;
    }

    .hero p {
      margin-top: 1rem;
      font-size: 1.2rem;
      color: #ddd;
    }

    .btn-warning {
      background-color: #fbbf24;
      border: none;
      color: #000;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 12px;
      font-size: 1.1rem;
      box-shadow: 0 4px 20px rgba(251,191,36,0.4);
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      transform: translateY(-3px);
      box-shadow: 0 6px 25px rgba(251,191,36,0.6);
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      .hero p {
        font-size: 1rem;
      }
    }

    .swal2-border-radius {
      border-radius: 15px !important;
    }
    .swal2-title-custom {
      font-weight: 700;
      color: #333;
    }
    .swal2-text-custom {
      font-size: 15px;
      color: #555;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="container">
      <div class="hero-content" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
        <h1>Mari Rasakan<br>Rasanya CIRA<span>KU</span></h1>
        <p data-aos="fade-up" data-aos-delay="300">
          Kreasi cireng dengan rasa kekinian dan perpaduan bumbu spesial yang bikin nagih CIRAKU (cireng rasa kusuka).
        </p>
        <a href="../payment/order.php" class="btn btn-warning mt-4" data-aos="zoom-in" data-aos-delay="600">
          Beli Sekarang
        </a>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Inisialisasi AOS
    AOS.init({
      duration: 1000,
      easing: 'ease-out-cubic',
      once: true
    });

    // Navbar blur effect saat scroll
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>

    <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Inisialisasi AOS
    AOS.init({
      duration: 1000,
      easing: 'ease-out-cubic',
      once: true
    });

    // Navbar blur effect saat scroll
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // 🔒 Cek login sebelum order
    document.addEventListener('DOMContentLoaded', function() {
      const orderBtn = document.querySelector('.btn-warning');

      orderBtn.addEventListener('click', function(event) {
        <?php if (!isset($_SESSION['user_id'])): ?>
          event.preventDefault();
          Swal.fire({
            title: 'Akses Ditolak!',
            text: 'Kamu harus login dulu sebelum order 🥲',
            icon: 'warning',
            background: '#fff', // Putih
            color: '#333', // Teks abu tua
            confirmButtonColor: '#fbbf24', // Oren kekuningan
            confirmButtonText: 'Daftar Sekarang',
            iconColor: '#fbbf24', // Warna ikon oranye
            backdrop: 'rgba(0, 0, 0, 0.6)', // Abu-abu transparan di belakang
            customClass: {
              popup: 'swal2-border-radius',
              title: 'swal2-title-custom',
              htmlContainer: 'swal2-text-custom'
            }
          }).then(() => {
            window.location.href = '../user/login.php';
          });
        <?php endif; ?>
      });
    });
  </script>

</body>
</html>
