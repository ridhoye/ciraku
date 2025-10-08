<?php
session_start();

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
      background: linear-gradient(135deg, #000, #000); /* background gelap */
      color: #fff;
      min-height: 100vh;
    }
    h1 span {
      color: #fbbf24; /* warna kuning untuk kata Cireng */
    }

    /* Fade-in animasi */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Card Style */
    .card {
      border-radius: 15px;
      overflow: hidden;
      background-color: #fff;
      color: #000;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 3px solid transparent;
      background-image: linear-gradient(#fff, #fff),
                        linear-gradient(135deg, #fbbf24, #f59e0b);
      background-origin: border-box;
      background-clip: content-box, border-box;
      animation: fadeInUp 0.8s ease forwards;
      opacity: 0; /* awalnya invisible */
    }
    .card:hover { 
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 8px 20px rgba(251,191,36,0.4);
    }

    /* Stagger animasi untuk tiap card */
    .card:nth-child(1) { animation-delay: 0.2s; }
    .card:nth-child(2) { animation-delay: 0.4s; }
    .card:nth-child(3) { animation-delay: 0.6s; }
    .card:nth-child(4) { animation-delay: 0.8s; }

    .price { font-weight: bold; color: #fbbf24; }

    .btn-warning { 
       background-color: #fbbf24;
       border: none; 
       font-weight: bold; }
    .btn-warning:hover { background-color: #f59e0b; }
    .btn-success { font-weight: bold; }
    .qty-input {
      width: 75px;
      text-align: center;
      margin: auto;
      font-weight: bold;
      border: 2px solid #fbbf24; /* border kuning */
      border-radius: 8px; /* biar agak halus */
    }
    .qty-input:focus {
     outline: none;
     box-shadow: 0 0 8px #fbbf24; /* efek glow kuning pas fokus */
}
  </style>
</head>
<body>

<div class="container py-5">
  <h1 class="text-center fw-bold mb-4">
    🍴 Pilih <span>Cireng</span> Favoritmu
  </h1>
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
          <input type="number" name="items[0][jumlah]" class="form-control qty-input" min="0" value="0">
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
          <input type="number" name="items[1][jumlah]" class="form-control qty-input" min="0" value="0">
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
          <input type="number" name="items[2][jumlah]" class="form-control qty-input" min="0" value="0">
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
          <input type="number" name="items[3][jumlah]" class="form-control qty-input" min="0" value="0">
        </div>
      </div>

    </div>

<!-- Tombol utama di bawah -->
<div class="text-center mt-5">
 <button type="button" class="btn btn-warning btn-lg me-3" onclick="addToCart()">
  🛒 Tambah ke Keranjang
</button>

  <button type="submit" name="checkout" class="btn btn-success btn-lg me-3">💳 Pesan Sekarang</button>
  <a href="../dasbord/home.php" class="btn btn-secondary btn-lg">⬅️ Kembali</a>
</div>
  </form>
</div>

<script>
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

  // bikin hidden input add_to_cart
  let input = document.createElement("input");
  input.type = "hidden";
  input.name = "add_to_cart";
  input.value = "1";
  document.querySelector("form").appendChild(input);

  // SweetAlert animasi sukses
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
    e.preventDefault(); // cegah submit
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
