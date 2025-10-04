<?php
session_start();

// Proses tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    $items = $_POST['items'];
    foreach ($items as $item) {
        if ($item['jumlah'] > 0) {
            $_SESSION['cart'][] = $item;
        }
    }
    header("Location: order.php");
    exit();
}

// Proses pesan sekarang (langsung checkout)
if (isset($_POST['checkout'])) {
    $_SESSION['cart'] = []; // reset dulu biar ga dobel
    $items = $_POST['items'];
    foreach ($items as $item) {
        if ($item['jumlah'] > 0) {
            $_SESSION['cart'][] = $item;
        }
    }
    header("Location: checkout.php"); // langsung ke checkout
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Cireng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff8e1, #ffe0b2);
      min-height: 100vh;
    }
    .card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .card:hover { transform: translateY(-8px); }
    .price { font-weight: bold; color: #f59e0b; }
    .btn-warning { background-color: #fbbf24; border: none; font-weight: bold; }
    .btn-warning:hover { background-color: #f59e0b; }
    .btn-success { font-weight: bold; }
    .qty-input {
      width: 75px;
      text-align: center;
      margin: auto;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h1 class="text-center fw-bold mb-4">🍴 Pilih Cireng Favoritmu</h1>
  <form method="POST">
    <div class="row g-4">

      <!-- Cireng Ayam -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/ayam.png" class="card-img-top mb-2" alt="Cireng Ayam">
          <h5 class="card-title">Cireng Ayam</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[0][nama]" value="Cireng Ayam">
          <input type="hidden" name="items[0][harga]" value="3000">
          <input type="number" name="items[0][jumlah]" class="form-control qty-input" min="0" value="0">
        </div>
      </div>

      <!-- Cireng Kornet -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/kornet.png" class="card-img-top mb-2" alt="Cireng Kornet">
          <h5 class="card-title">Cireng Kornet</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[1][nama]" value="Cireng Kornet">
          <input type="hidden" name="items[1][harga]" value="3000">
          <input type="number" name="items[1][jumlah]" class="form-control qty-input" min="0" value="0">
        </div>
      </div>

      <!-- Cireng Keju -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/keju.png" class="card-img-top mb-2" alt="Cireng Keju">
          <h5 class="card-title">Cireng Keju</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[2][nama]" value="Cireng Keju">
          <input type="hidden" name="items[2][harga]" value="3000">
          <input type="number" name="items[2][jumlah]" class="form-control qty-input" min="0" value="0">
        </div>
      </div>

      <!-- Cireng Sosis -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/sosis.png" class="card-img-top mb-2" alt="Cireng Sosis">
          <h5 class="card-title">Cireng Sosis</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[3][nama]" value="Cireng Sosis">
          <input type="hidden" name="items[3][harga]" value="3000">
          <input type="number" name="items[3][jumlah]" class="form-control qty-input" min="0" value="0">
        </div>
      </div>

    </div>

    <!-- Tombol utama di bawah -->
    <div class="text-center mt-5">
      <button type="submit" name="add_to_cart" class="btn btn-warning btn-lg me-3">🛒 Tambah ke Keranjang</button>
      <button type="submit" name="checkout" class="btn btn-success btn-lg">💳 Pesan Sekarang</button>
    </div>
  </form>
</div>

</body>
</html>
