<?php
session_start();
include "../config/db.php";

// 🔒 Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 🔙 Jika user batal
if (isset($_GET['cancel'])) {
    unset($_SESSION['checkout_items']);
    header("Location: ../dasbord/shop.php");
    exit;
}

// 🔎 Ambil item checkout dari session
if (!isset($_SESSION['checkout_items']) || empty($_SESSION['checkout_items'])) {
    echo "<script>alert('Tidak ada item yang dipilih!'); window.location.href='../dasbord/shop.php';</script>";
    exit;
}

$checkout_items = $_SESSION['checkout_items'];
$total_all = 0;
$items = [];

// Hitung total per produk
foreach ($checkout_items as $item) {
    $nama = $item['nama'];
    $harga = (int)$item['harga'];
    $jumlah = (int)$item['jumlah'];
    $total = $harga * $jumlah;

    $items[] = [
        'nama' => $nama,
        'harga' => $harga,
        'jumlah' => $jumlah,
        'total' => $total
    ];

    $total_all += $total;
}

// 💾 Simpan ke tabel pesanan
if (isset($_POST['konfirmasi'])) {
    foreach ($items as $item) {
        $nama = mysqli_real_escape_string($conn, $item['nama']);
        $harga = $item['harga'];
        $jumlah = $item['jumlah'];
        $total = $item['total'];
        mysqli_query($conn, "INSERT INTO pesanan (user_id, nama_produk, jumlah, harga, total_harga, status)
                             VALUES ('$user_id', '$nama', '$jumlah', '$harga', '$total', 'Pending')");
    }

    unset($_SESSION['checkout_items']); // bersihkan data sementara

    echo "<script>
            alert('Pesanan berhasil dikirim!');
            window.location.href='../dasbord/home.php';
          </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0d0d0d;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      max-width: 700px;
      margin-top: 50px;
      background: #1a1a1a;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 20px rgba(251,191,36,0.2);
    }
    h2 {
      color: #fbbf24;
      font-weight: 600;
    }
    .btn-warning {
      background-color: #fbbf24;
      color: #000;
      font-weight: bold;
      border: none;
    }
    .btn-warning:hover { background-color: #f59e0b; }
    table { color: #fff; }
    table thead { background-color: #fbbf24; color: #000; }
  </style>
</head>
<body>

<div class="container">
  <h2 class="mb-4 text-center">Konfirmasi Checkout</h2>

  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $it): ?>
      <tr>
        <td><?= htmlspecialchars($it['nama']); ?></td>
        <td><?= $it['jumlah']; ?></td>
        <td>Rp <?= number_format($it['harga'], 0, ',', '.'); ?></td>
        <td>Rp <?= number_format($it['total'], 0, ',', '.'); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h4 class="text-end mt-3">Total Semua: <span class="text-warning">Rp <?= number_format($total_all, 0, ',', '.'); ?></span></h4>

  <form method="POST">
    <div class="text-center mt-4">
      <button type="submit" name="konfirmasi" class="btn btn-warning px-5">Konfirmasi Pesanan</button>
      <a href="order.php?cancel=1" class="btn btn-secondary px-4">Batal</a>
    </div>
  </form>
</div>

</body>
</html>
