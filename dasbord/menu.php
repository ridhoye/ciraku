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
      color: #fbbf24;
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
    .card-img-top {
      width: 100%;
      height: 190px; /* Sesuaikan tinggi gambar */
      object-fit: cover; /* Potong gambar agar proporsional */
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
      <?php
      // Ambil data produk dari database
      $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

      if (mysqli_num_rows($query) > 0) {
        while ($p = mysqli_fetch_assoc($query)) { ?>
          <div class="col-md-3 col-sm-6">
            <div class="card">
              <img src="../assets/images/<?php echo htmlspecialchars($p['gambar']); ?>" 
                   class="card-img-top" 
                   alt="<?php echo htmlspecialchars($p['nama_produk']); ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($p['nama_produk']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($p['deskripsi']); ?></p>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
