<?php
session_start();

// 🔒 Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: 'Akses Ditolak!',
          text: 'Kamu harus daftar atau login dulu sebelum bisa order 😅',
          icon: 'warning',
          confirmButtonText: 'Daftar Sekarang',
          confirmButtonColor: '#fbbf24',
        }).then(() => {
          window.location.href = '../user/register.php';
        });
      });
    </script>
    ";
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Cireng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #000, #111);
    color: #fff;
    min-height: 100vh;
  }

  h1 span { color: #fbbf24; }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* 🍊 Card lebih berwarna */
  .card {
    border-radius: 16px;
    overflow: hidden;
    background: linear-gradient(180deg, #fff8e1, #fff);
    color: #000;
    border: 3px solid #fbbf24;
    box-shadow: 0 6px 14px rgba(251,191,36,0.25);
    transition: all 0.25s ease;
    animation: fadeInUp 0.8s ease forwards;
    opacity: 0;
    padding: 15px;
  }

  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 22px rgba(251,191,36,0.4);
    background: linear-gradient(180deg, #fff2cc, #fffaf0);
  }

  .card img {
    width: 85%;
    margin: 10px auto;
    display: block;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
  }

  .card h5 {
    font-size: 1.1rem;
    margin-top: 6px;
    margin-bottom: 6px;
    font-weight: 600;
  }

  .price {
    font-weight: bold;
    color: #f59e0b;
    font-size: 1rem;
    margin-bottom: 6px;
  }

  .qty-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
  }

  .qty-input {
    width: 44px;
    text-align: center;
    font-weight: bold;
    border: 2px solid #fbbf24;
    border-radius: 8px;
    background-color: #fff;
    color: #000;
  }

  .btn-qty {
    width: 30px;
    height: 30px;
    font-size: 18px;
    border-radius: 8px;
    color: #fff;
    background-color: #fbbf24;
    border: none;
    font-weight: bold;
    line-height: 1;
    transition: transform 0.1s ease, background-color 0.2s ease;
  }

  .btn-qty:hover {
    background-color: #f59e0b;
    transform: scale(1.1);
  }

  .btn-warning {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    border: none;
    font-weight: bold;
    color: #fff;
    box-shadow: 0 3px 8px rgba(251,191,36,0.4);
  }

  .btn-warning:hover {
    background: linear-gradient(90deg, #f59e0b, #d97706);
    transform: scale(1.03);
  }

  .btn-success {
    background: linear-gradient(90deg, #22c55e, #16a34a);
    font-weight: bold;
    color: #fff;
  }

  .btn-success:hover {
    transform: scale(1.03);
  }

  .btn-secondary {
    background-color: #374151;
    color: #fff;
    font-weight: 600;
  }

  .btn-secondary:hover {
    background-color: #4b5563;
  }
</style>
</head>
<body>

<div class="container py-5">
  <h1 class="text-center fw-bold mb-4">🍴 Pilih <span>Cireng</span> Favoritmu</h1>
  <form method="POST">
    <div class="row g-4">

      <!-- Cireng Ayam -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/ayam.png" class="card-img-top mb-2" alt="Cireng Ayam">
          <h5 class="card-title">Cireng Ayam</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[0][gambar]" value="ayam.png">
          <input type="hidden" name="items[0][nama]" value="Cireng Ayam">
          <input type="hidden" name="items[0][harga]" value="3000">
          <div class="qty-wrapper">
            <button type="button" class="btn-qty" onclick="decreaseQty(this)">−</button>
            <input type="text" name="items[0][jumlah]" class="qty-input" value="0" readonly>
            <button type="button" class="btn-qty" onclick="increaseQty(this)">+</button>
          </div>
        </div>
      </div>

      <!-- Cireng Kornet -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/kornet.png" class="card-img-top mb-2" alt="Cireng Kornet">
          <h5 class="card-title">Cireng Kornet</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[1][gambar]" value="kornet.png">
          <input type="hidden" name="items[1][nama]" value="Cireng Kornet">
          <input type="hidden" name="items[1][harga]" value="3000">
          <div class="qty-wrapper">
            <button type="button" class="btn-qty" onclick="decreaseQty(this)">−</button>
            <input type="text" name="items[1][jumlah]" class="qty-input" value="0" readonly>
            <button type="button" class="btn-qty" onclick="increaseQty(this)">+</button>
          </div>
        </div>
      </div>

      <!-- Cireng Keju -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/keju.png" class="card-img-top mb-2" alt="Cireng Keju">
          <h5 class="card-title">Cireng Keju</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[2][gambar]" value="keju.png">
          <input type="hidden" name="items[2][nama]" value="Cireng Keju">
          <input type="hidden" name="items[2][harga]" value="3000">
          <div class="qty-wrapper">
            <button type="button" class="btn-qty" onclick="decreaseQty(this)">−</button>
            <input type="text" name="items[2][jumlah]" class="qty-input" value="0" readonly>
            <button type="button" class="btn-qty" onclick="increaseQty(this)">+</button>
          </div>
        </div>
      </div>

      <!-- Cireng Sosis -->
      <div class="col-md-3">
        <div class="card text-center p-3">
          <img src="../assets/images/sosis.png" class="card-img-top mb-2" alt="Cireng Sosis">
          <h5 class="card-title">Cireng Sosis</h5>
          <p class="price">Rp 3.000</p>
          <input type="hidden" name="items[3][gambar]" value="sosis.png">
          <input type="hidden" name="items[3][nama]" value="Cireng Sosis">
          <input type="hidden" name="items[3][harga]" value="3000">
          <div class="qty-wrapper">
            <button type="button" class="btn-qty" onclick="decreaseQty(this)">−</button>
            <input type="text" name="items[3][jumlah]" class="qty-input" value="0" readonly>
            <button type="button" class="btn-qty" onclick="increaseQty(this)">+</button>
          </div>
        </div>
      </div>

    </div>

    <!-- Tombol utama -->
    <div class="text-center mt-5">
      <button type="button" class="btn btn-warning btn-lg me-3" onclick="addToCart()">🛒 Tambah ke Keranjang</button>
      <button type="submit" name="checkout" class="btn btn-success btn-lg me-3">💳 Pesan Sekarang</button>
      <a href="../dasbord/home.php" class="btn btn-secondary btn-lg">⬅️ Kembali</a>
    </div>
  </form>
</div>

<script>
function increaseQty(btn) {
  let input = btn.parentElement.querySelector('.qty-input');
  let val = parseInt(input.value) || 0;
  input.value = val + 1;
}

function decreaseQty(btn) {
  let input = btn.parentElement.querySelector('.qty-input');
  let val = parseInt(input.value) || 0;
  if (val > 0) input.value = val - 1;
}

function hasItems() {
  let qtyInputs = document.querySelectorAll('.qty-input');
  for (let input of qtyInputs) {
    if (parseInt(input.value) > 0) return true;
  }
  return false;
}

function addToCart() {
  if (!hasItems()) {
    Swal.fire({
      title: 'Ups!',
      text: 'Kamu belum memilih jumlah cireng',
      icon: 'warning',
      confirmButtonColor: '#fbbf24',
    });
    return;
  }

  let input = document.createElement("input");
  input.type = "hidden";
  input.name = "add_to_cart";
  input.value = "1";
  document.querySelector("form").appendChild(input);

  Swal.fire({
    title: 'Berhasil!',
    text: 'Barang berhasil ditambahkan ke keranjang!',
    icon: 'success',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
  });

  setTimeout(() => {
    document.querySelector('form').submit();
  }, 1600);
}

// intercept tombol checkout
document.querySelector('button[name="checkout"]').addEventListener('click', function(e) {
  if (!hasItems()) {
    e.preventDefault();
    Swal.fire({
      title: 'Ups!',
      text: 'Kamu belum memilih jumlah cireng',
      icon: 'warning',
      confirmButtonColor: '#fbbf24',
    });
  }
});
</script>

</body>
</html>
