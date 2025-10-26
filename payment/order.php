<?php
session_start();
include "../config/db.php";

// 🔒 Cek login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: 'Akses Ditolak!',
          text: 'Kamu harus login dulu sebelum order 😅',
          icon: 'warning',
          confirmButtonText: 'Daftar Sekarang',
          confirmButtonColor: '#fbbf24',
        }).then(() => { window.location.href = '../user/register.php'; });
      });
    </script>";
    exit();
}

// Ambil produk
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id ASC");

// Proses checkout
if (isset($_POST['checkout'])) {
    $_SESSION['cart'] = [];
    foreach ($_POST['items'] as $item) {
        if ($item['jumlah'] > 0) $_SESSION['cart'][] = $item;
    }
    header("Location: checkout.php");
    exit();
}

// Tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    foreach ($_POST['items'] as $item) {
        if ($item['jumlah'] > 0) $_SESSION['cart'][] = $item;
    }
    header("Location: order.php");
    exit();
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Cireng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #000, #111);
      color: #fff; min-height: 100vh;
    }
    h1 span { color: #fbbf24; }

    /* 🔸 Posisi ikon keranjang di kanan atas */
    .cart-icon {
      position: fixed;
      top: 20px;
      right: 30px;
      z-index: 1000;
      cursor: pointer;
      font-size: 26px;
      color: #fbbf24;
    }
    .cart-icon:hover { transform: scale(1.1); color: #f59e0b; transition: .2s; }

    .cart-badge {
      position: absolute;
      top: -8px;
      right: -10px;
      background: red;
      color: #fff;
      font-size: 12px;
      border-radius: 50%;
      padding: 2px 6px;
    }

    .fly-img {
      position: absolute;
      z-index: 999;
      transition: all 1s ease-in-out;
      pointer-events: none;
      border-radius: 10px;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .card {
      border-radius: 16px; overflow: hidden;
      background: linear-gradient(180deg, #fff8e1, #fff);
      color: #000; border: 3px solid #fbbf24;
      box-shadow: 0 6px 14px rgba(251,191,36,0.25);
      transition: all 0.25s ease;
      animation: fadeInUp 0.8s ease forwards; opacity: 0;
      padding: 15px;
    }
    .card:hover { transform: translateY(-8px); box-shadow: 0 10px 22px rgba(251,191,36,0.4); }
    .card img {
      width: 85%; margin: 10px auto; display: block;
      border-radius: 12px; box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }
    .card h5 { font-size: 1.1rem; margin-top: 6px; font-weight: 600; }
    .price { font-weight: bold; color: #f59e0b; font-size: 1rem; }

    .qty-wrapper { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 8px; }
    .qty-input {
      width: 44px; text-align: center; font-weight: bold;
      border: 2px solid #fbbf24; border-radius: 8px; background-color: #fff; color: #000;
    }
    .btn-qty {
      width: 30px; height: 30px; font-size: 18px; border-radius: 8px;
      color: #fff; background-color: #fbbf24; border: none; font-weight: bold;
    }
    .btn-qty:hover { background-color: #f59e0b; transform: scale(1.1); }

    .btn-warning {
      background: linear-gradient(90deg, #fbbf24, #f59e0b);
      border: none; font-weight: bold; color: #fff;
      box-shadow: 0 3px 8px rgba(251,191,36,0.4);
    }
    .btn-warning:hover { background: linear-gradient(90deg, #f59e0b, #d97706); transform: scale(1.03); }
    .btn-success { background: linear-gradient(90deg, #22c55e, #16a34a); font-weight: bold; color: #fff; }
    .btn-secondary { background-color: #374151; color: #fff; font-weight: 600; }
    .btn-secondary:hover { background-color: #4b5563; }
  </style>
</head>
<body>

<!-- 🛒 Hanya ikon keranjang -->
<div class="cart-icon" onclick="window.location.href='http://localhost/ciraku/dasbord/shop.php?from=order'">
  <i class="bi bi-cart3"></i>
  <?php if ($cartCount > 0): ?>
  <span class="cart-badge" id="cartCount"><?= $cartCount ?></span>
  <?php endif; ?>
</div>

<div class="container py-5">
  <h1 class="text-center fw-bold mb-4">🍴 Pilih <span>Cireng</span> Favoritmu</h1>
  <form method="POST">
    <div class="row g-4">

      <?php 
      $index = 0;
      while ($p = mysqli_fetch_assoc($produk)) { ?>
        <div class="col-md-3 col-sm-6">
          <div class="card text-center p-3">
            <img src="../assets/images/<?= $p['gambar']; ?>" class="card-img-top mb-2 product-img" alt="<?= $p['nama_produk']; ?>">
            <h5 class="card-title"><?= $p['nama_produk']; ?></h5>
            <p class="price">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>

            <input type="hidden" name="items[<?= $index ?>][gambar]" value="<?= $p['gambar']; ?>">
            <input type="hidden" name="items[<?= $index ?>][nama]" value="<?= $p['nama_produk']; ?>">
            <input type="hidden" name="items[<?= $index ?>][harga]" value="<?= $p['harga']; ?>">

            <div class="qty-wrapper">
              <button type="button" class="btn-qty" onclick="decreaseQty(this)">−</button>
              <input type="text" name="items[<?= $index ?>][jumlah]" class="qty-input" value="0" readonly>
              <button type="button" class="btn-qty" onclick="increaseQty(this)">+</button>
            </div>
          </div>
        </div>
      <?php $index++; } ?>

    </div>

    <div class="text-center mt-5">
      <button type="button" class="btn btn-warning btn-lg me-3" id="addToCartBtn">🛒 Tambah ke Keranjang</button>
      <button type="submit" name="checkout" class="btn btn-success btn-lg me-3">💳 Pesan Sekarang</button>
      <a href="../dasbord/home.php" class="btn btn-secondary btn-lg">⬅️ Kembali</a>
    </div>
  </form>
</div>

<script>
function increaseQty(btn) {
  let input = btn.parentElement.querySelector('.qty-input');
  input.value = parseInt(input.value) + 1;
}
function decreaseQty(btn) {
  let input = btn.parentElement.querySelector('.qty-input');
  if (parseInt(input.value) > 0) input.value = parseInt(input.value) - 1;
}
function hasItems() {
  return Array.from(document.querySelectorAll('.qty-input')).some(i => parseInt(i.value) > 0);
}

// ✨ Animasi tambah ke keranjang
function animateToCart(imgEl) {
  const cart = document.querySelector('.bi-cart3'); // ambil ikon cart dari pojok kanan
  const clone = imgEl.cloneNode(true);
  const rect = imgEl.getBoundingClientRect();
  clone.classList.add('fly-img');
  clone.style.left = rect.left + 'px';
  clone.style.top = rect.top + 'px';
  clone.style.width = rect.width + 'px';
  clone.style.height = rect.height + 'px';
  document.body.appendChild(clone);

  const cartRect = cart.getBoundingClientRect();
  requestAnimationFrame(() => {
    clone.style.left = cartRect.left + 'px';
    clone.style.top = cartRect.top + 'px';
    clone.style.width = '30px';
    clone.style.height = '30px';
    clone.style.opacity = '0.2';
  });

  setTimeout(() => clone.remove(), 1000);
}

document.getElementById('addToCartBtn').addEventListener('click', () => {
  if (!hasItems()) {
    Swal.fire({ title: 'Ups!', text: 'Kamu belum memilih jumlah cireng', icon: 'warning', confirmButtonColor: '#fbbf24' });
    return;
  }

  document.querySelectorAll('.qty-input').forEach((input) => {
    if (parseInt(input.value) > 0) {
      const img = input.closest('.card').querySelector('.product-img');
      animateToCart(img);
    }
  });

  Swal.fire({
    title: 'Berhasil!', text: 'Barang ditambahkan ke keranjang!',
    icon: 'success', showConfirmButton: false, timer: 1200, timerProgressBar: true
  });

  setTimeout(() => {
    const input = document.createElement("input");
    input.type = "hidden"; input.name = "add_to_cart"; input.value = "1";
    document.querySelector("form").appendChild(input);
    document.querySelector("form").submit();
  }, 1300);
});
</script>
</body>
</html>
