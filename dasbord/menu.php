<?php
// Koneksi ke database
include '../config/db.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Kami - Ciraku</title>
  <!-- Import CSS Bootstrap buat styling responsif -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Import library animasi AOS (Animate On Scroll) -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #000;
      color: #fff;
    }

    .navbar {
      border-bottom: 3px solid #fbbf24;  /* Garis kuning di bawah navbar */
    }

    .menu-section {
      padding: 80px 20px; /* Spasi dalam section menu */
    }

    .section-title {
      color: #fff;
      font-weight: 700;
      text-align: center;
      margin-bottom: 50px;
    }

    .section-title span {
      color: #fbbf24; /* Warna kuning pada kata “Menu” */
    }

    /* Card menu */
    .card {
      background: #111;
      border: none;
      border-radius: 20px;
      overflow: hidden;
      text-align: center;
      color: #fff;
      perspective: 1000px; /* Biar efek 3D-nya keliatan */
      transition: transform 0.2s ease, box-shadow 0.3s ease;
      transform-style: preserve-3d;
      box-shadow: 0 0 10px rgba(251, 191, 36, 0.1);
    }

    .card:hover {
      box-shadow: 0 15px 25px rgba(251, 191, 36, 0.25);
    }

    .card-img-top {
      width: 100%;
      height: 190px;
      object-fit: cover;  /* Biar gambar gak ketarik */
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

   <!-- Bagian konten utama -->
  <section class="menu-section container">
    <h2 class="section-title" data-aos="fade-up"><span>Menu</span> Kami</h2>
    <div class="row g-4">

      <?php

      // Ambil data produk dari database
      // Ambil semua data produk dari tabel 'produk' di database, urutkan dari id terbaru
      $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

       // Kalau ada data
      if (mysqli_num_rows($query) > 0) {
        // looping setiap produk
        while ($p = mysqli_fetch_assoc($query)) { ?>
          <div class="col-md-3 col-sm-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="card tilt-card">
              <img src="../assets/images/<?php echo htmlspecialchars($p['gambar']); ?>" 
                   class="card-img-top" 
                   alt="<?php echo htmlspecialchars($p['nama_produk']); ?>">
              <div class="card-body">
                <!-- htmlspecialchars() → buat amankan output biar gak bisa disisipi script (mencegah XSS). -->
                <h5 class="card-title"><?php echo htmlspecialchars($p['nama_produk']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($p['deskripsi']); ?></p>
                <!-- number_format() → ubah angka harga jadi format rupiah, misal 20000 → 20.000. -->
                <p class="text-warning fw-bold">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
              </div>
            </div>
          </div>
      <?php 

        }
      } else { 
        echo "<p class='text-center text-secondary'>Belum ada produk tersedia.</p>";
      }
      ?>
    </div>
    
  </section>

   <!-- Bootstrap & AOS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    // Inisialisasi animasi scroll (AOS)
    AOS.init({
      duration: 1000, // durasi animasi
      once: true      // animasi cuma muncul sekali
    });

    // Efek tilt card (3D hover)
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
      // Saat mouse bergerak di atas card
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left; // posisi X mouse di dalam card
        const y = e.clientY - rect.top;  // posisi Y mouse di dalam card

        // Hitung sudut rotasi berdasarkan posisi mouse
        const rotateY = ((x / rect.width) - 0.5) * 20;  
        const rotateX = ((y / rect.height) - 0.5) * -20; 

        // Terapkan transformasi 3D (miring dan zoom sedikit)
        card.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg) scale(1.05)`;
      });

      // Saat mouse keluar dari card, balikin ke posisi normal
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'rotateY(0deg) rotateX(0deg) scale(1)';
      });
    });
  </script>
</body>


</body>
  <?php include 'footer.php'; ?>
</html>
