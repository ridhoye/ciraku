<?php
session_start();
include "../config/db.php";

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Jika user klik tombol "Pesanan Selesai"
if (isset($_POST['update_status'])) {
  $id_pesanan = intval($_POST['id_pesanan']);
  // Update status jadi "Selesai"
  $update = mysqli_query($conn, "UPDATE pesanan SET status = 'Selesai' WHERE id = $id_pesanan AND user_id = $user_id");
}

// Ambil data pesanan user
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE user_id = $user_id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan Saya - CIRAKU</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #0d0d0d;
      color: #fff;
      min-height: 100vh;
      padding: 50px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h2 {
      color: #fbbf24;
      text-align: center;
      margin-bottom: 40px;
      font-weight: 600;
      font-size: 2rem;
      letter-spacing: 0.5px;
    }

    .order-container {
      width: 100%;
      max-width: 900px;
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .order-card {
      display: flex;
      align-items: center;
      gap: 20px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 20px;
      padding: 20px;
      transition: 0.3s ease;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    .order-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 0 30px rgba(251, 191, 36, 0.15);
    }

    .product-image {
      width: 90px;
      height: 90px;
      border-radius: 15px;
      object-fit: cover;
      border: 1px solid rgba(255,255,255,0.1);
    }

    .order-info {
      flex: 1;
    }

    .product-name {
      font-weight: 600;
      color: #fbbf24;
      font-size: 1.1rem;
      margin-bottom: 8px;
    }

    .order-detail {
      font-size: 0.95rem;
      color: #ddd;
      line-height: 1.4;
    }

    .order-meta {
      text-align: right;
    }

    .order-date {
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.9rem;
      margin-bottom: 8px;
    }

    .status {
      padding: 6px 12px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      display: inline-block;
    }

    .status.Pending {
      background: rgba(251, 191, 36, 0.15);
      color: #fbbf24;
      border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .status.Diproses {
      background: rgba(59, 130, 246, 0.15);
      color: #3b82f6;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .status.Dikirim {
      background: rgba(34, 197, 94, 0.15);
      color: #22c55e;
      border: 1px solid rgba(34, 197, 94, 0.3);
    }
    .status.Selesai {
      background: rgba(199, 233, 248, 0.15);
      color: #fff;
      border: 1px solid rgba(56, 189, 248, 0.3);
    }

    /*next fitur*/
    .status.Dibatalkan {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .no-orders {
      text-align: center;
      color: rgba(255, 255, 255, 0.6);
      font-size: 1rem;
      margin-top: 20px;
    }

    .btn-kembali {
      margin-top: 40px;
      background: #fbbf24;
      color: #000;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-kembali:hover {
      background: #d97706;
      color: #fff;
    }

    .btn-selesai {
      background: #22c55e;
      border: none;
      color: #fff;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 5px;
    }

    .btn-selesai:hover {
      background: #16a34a;
    }
  </style>
</head>
<body>

  <h2>Pesanan Saya</h2>

  <div class="order-container">
    <?php if (mysqli_num_rows($query) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <?php
          // Tentukan gambar produk
          $nama = strtolower($row['nama_produk']);
          if (str_contains($nama, 'ayam')) $gambar = 'ayam.png';
          elseif (str_contains($nama, 'keju')) $gambar = 'keju.png';
          elseif (str_contains($nama, 'kornet')) $gambar = 'kornet.png';
          elseif (str_contains($nama, 'sosis')) $gambar = 'sosis.png';
          else $gambar = 'default.png';
        ?>
        <div class="order-card">
          <img src="../assets/images/<?= $gambar ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>" class="product-image">

        <div class="order-info">
          <div class="product-name"><?= htmlspecialchars($row['nama_produk']) ?></div>
          <div class="order-detail">
            <span class="qty">x<?= $row['jumlah'] ?></span><br>
            <span class="harga">Rp<?= number_format($row['harga'], 0, ',', '.') ?></span><br>
            <b>Total:</b> Rp<?= number_format($row['total_harga'], 0, ',', '.') ?>
          </div>
        </div>

          <div class="order-meta">
            <div class="order-date"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
            <div class="status <?= htmlspecialchars($row['status']) ?>">
              <?= htmlspecialchars($row['status']) ?>
            </div>

            <?php if ($row['status'] === 'Dikirim'): ?>
              <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="id_pesanan" value="<?= $row['id'] ?>">
                <button type="submit" name="update_status" class="btn-selesai">Pesanan Selesai</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-orders">Belum ada pesanan 😎</div>
    <?php endif; ?>
  </div>

  <a href="http://localhost/ciraku/user/profile.php" class="btn-kembali">⬅️ Kembali ke Profil</a>

</body>
</html>
