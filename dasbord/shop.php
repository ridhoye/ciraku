<?php
session_start();
include "../config/db.php";

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- Tentukan halaman sebelumnya ---
$from = $_GET['from'] ?? 'home';
$back_page = ($from === "order") ? "../payment/order.php" : "../dasbord/home.php";

// ✅ Simpan asal halaman (dari order atau home)
$_SESSION['from_page'] = ($from === 'order') ? 'order' : 'home';

// --- Tambah produk ke keranjang ---
if (isset($_GET['add'])) {
    $id_produk = intval($_GET['add']);
    $cek = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND produk_id=$id_produk");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND produk_id=$id_produk");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, produk_id, quantity) VALUES ($user_id, $id_produk, 1)");
    }

    $redirect = "shop.php" . ($from === 'order' ? "?from=order" : "");
    header("Location: $redirect");
    exit;
}

// --- Hapus satu item ---
if (isset($_GET['remove'])) {
    $produk_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id AND produk_id=$produk_id");
    header("Location: shop.php" . ($from === 'order' ? "?from=order" : ""));
    exit;
}

// --- Hapus semua item ---
if (isset($_GET['clear'])) {
    mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
    header("Location: shop.php" . ($from === 'order' ? "?from=order" : ""));
    exit;
}

// --- Ambil isi keranjang user ---
$query = "
SELECT c.produk_id, c.quantity, p.nama_produk, p.harga, p.gambar
FROM cart c
JOIN produk p ON c.produk_id = p.id
WHERE c.user_id = $user_id
ORDER BY c.tanggal_ditambahkan DESC
";
$cart_items = mysqli_query($conn, $query);

// --- Proses Checkout ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_items'])) {
    $selected = $_POST['selected_items'];
    $checkout_items = [];

    foreach ($selected as $pid) {
        $p = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT p.id, p.nama_produk, p.harga, p.gambar, c.quantity 
            FROM cart c JOIN produk p ON c.produk_id=p.id
            WHERE c.user_id=$user_id AND c.produk_id=$pid
        "));
        if ($p) $checkout_items[] = $p;
    }

    if (!empty($checkout_items)) {
        $_SESSION['checkout_items'] = $checkout_items;
        $_SESSION['checkout_origin'] = $from;
        header("Location: ../payment/checkout.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { background-color: #0d0d0d; color: #fff; font-family: 'Poppins', sans-serif; }
    .container {
      width: 80%; max-width: 800px; margin: 50px auto;
      background: #1a1a1a; border-radius: 15px; box-shadow: 0 0 20px rgba(255,136,0,0.2);
      overflow: hidden;
    }
    .header {
      background: linear-gradient(90deg, #ff8800, #ff5500);
      padding: 20px; font-size: 24px; font-weight: bold;
      display: flex; align-items: center; justify-content: space-between; color: white;
    }
    .back-btn { background: transparent; border: 1px solid #fff; color: #fff; padding: 5px 10px;
      border-radius: 8px; font-size: 14px; cursor: pointer; transition: 0.3s; }
    .back-btn:hover { background-color: #fff; color: #ff5500; }
    .cart-item {
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 20px; border-bottom: 1px solid #2c2c2c;
    }
    .cart-item-left { display: flex; align-items: center; gap: 10px; }
    .cart-item-left img {
      width: 60px; height: 60px; border-radius: 10px; object-fit: cover;
    }
    .cart-item-name { font-size: 16px; font-weight: 500; }
    .cart-item-price { color: #ff8800; font-weight: bold; }
    .hapus-btn {
      background: transparent; border: 1px solid #ff5500;
      color: #ff5500; padding: 5px 10px; border-radius: 8px;
      text-decoration: none; transition: 0.3s;
    }
    .hapus-btn:hover { background: #ff5500; color: #fff; }
    .footer {
      padding: 20px; display: flex; justify-content: space-between; align-items: center;
      background-color: #111; border-top: 1px solid #2c2c2c;
    }
    .total { color: #ff8800; font-weight: bold; font-size: 18px; }
    .checkout-btn {
      background: linear-gradient(90deg, #ff8800, #ff5500);
      border: none; padding: 10px 20px; border-radius: 10px;
      color: #fff; font-weight: bold; cursor: pointer; transition: 0.3s;
    }
    .checkout-btn:hover { transform: scale(1.05); background: linear-gradient(90deg, #ff5500, #ff8800); }
    .hapus-semua-btn {
      background: transparent; border: 1px solid #ff8800; color: #ff8800;
      padding: 8px 12px; border-radius: 8px; margin-left: 15px;
      cursor: pointer; transition: 0.3s; display: none;
    }
    .hapus-semua-btn:hover { background-color: #ff8800; color: #fff; }

    /* === PERBAIKAN TAMPILAN HP === */
@media (max-width: 600px) {

  .cart-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .cart-item-right {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    margin-top: 5px;
  }

  .cart-item-price {
    font-size: 15px;
    margin-right: 10px;
  }

  .hapus-btn {
    padding: 6px 12px;
    font-size: 13px;
  }

  /* Footer dibuat lebih lega */
  .footer {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .footer > div:last-child {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }

  .checkout-btn {
    padding: 12px 20px;
    font-size: 16px;
  }

  .total {
    font-size: 17px;
  }
}

  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <span>🛒 Keranjang Belanja</span>
    <button class="back-btn" onclick="window.location.href='<?= $back_page ?>'">⬅️ Kembali</button>
  </div>

  <?php if (mysqli_num_rows($cart_items) > 0): ?>
  <form method="POST" id="checkoutForm" action="shop.php<?= ($from === 'order') ? '?from=order' : '' ?>">
  <?php 
  $total = 0;
  while ($item = mysqli_fetch_assoc($cart_items)):
    $subtotal = $item['harga'] * $item['quantity'];
    $total += $subtotal;
  ?>
    <div class="cart-item">
      <div class="cart-item-left">
        <input type="checkbox" class="item-checkbox" name="selected_items[]" value="<?= $item['produk_id'] ?>" data-harga="<?= $subtotal; ?>">
        <img src="../assets/images/<?= htmlspecialchars($item['gambar']); ?>" alt="<?= htmlspecialchars($item['nama_produk']); ?>">
        <div>
          <span class="cart-item-name"><?= htmlspecialchars($item['nama_produk']); ?></span><br>
          <small>x<?= $item['quantity']; ?></small>
        </div>
      </div>
      <div class="cart-item-right">
        <span class="cart-item-price">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
        <a href="?remove=<?= $item['produk_id'] ?><?= ($from === 'order') ? '&from=order' : '' ?>" class="hapus-btn">Hapus</a>
      </div>
    </div>
  <?php endwhile; ?>

  <div class="footer">
    <div>
      <label><input type="checkbox" id="selectAll"> Pilih Semua</label>
      <button type="button" id="hapusSemuaBtn" class="hapus-semua-btn">🗑️ Hapus Semua</button>
    </div>
    <div>
      <span class="total">Total: Rp <span id="totalValue"><?= number_format($total, 0, ',', '.'); ?></span></span>
      <button type="submit" class="checkout-btn">Checkout</button>
    </div>
  </div>
  </form>
  <?php else: ?>
    <p style="text-align:center; padding:30px; color:#aaa;">Keranjang masih kosong 😅</p>
  <?php endif; ?>
</div>

<script>
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.item-checkbox');
  const totalValue = document.getElementById('totalValue');
  const hapusSemuaBtn = document.getElementById('hapusSemuaBtn');
  const checkoutForm = document.getElementById('checkoutForm');

  function updateTotal() {
    let total = 0;
    checkboxes.forEach(cb => {
      if (cb.checked) total += parseInt(cb.dataset.harga);
    });
    totalValue.textContent = total.toLocaleString('id-ID');
  }

  selectAll?.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateTotal();
    hapusSemuaBtn.style.display = this.checked ? 'inline-block' : 'none';
  });

  checkboxes.forEach(cb => cb.addEventListener('change', () => {
    const allChecked = [...checkboxes].every(c => c.checked);
    selectAll.checked = allChecked;
    updateTotal();
    hapusSemuaBtn.style.display = allChecked ? 'inline-block' : 'none';
  }));

  hapusSemuaBtn?.addEventListener('click', () => {
    Swal.fire({
      title: 'Hapus semua produk?',
      text: 'Semua item di keranjang akan dihapus!',
      icon: 'warning',
      background: '#fff',
      color: '#333',
      iconColor: '#fbbf24',
      backdrop: 'rgba(0, 0, 0, 0.6)',
      showCancelButton: true,
      confirmButtonColor: '#fbbf24',
      cancelButtonColor: '#ccc',
      confirmButtonText: 'Ya, hapus semua!',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?clear=true<?= ($from === "order") ? "&from=order" : "" ?>';
      }
    });
  });

  checkoutForm?.addEventListener('submit', function(e) {
    const selected = document.querySelectorAll('.item-checkbox:checked');
    if (selected.length === 0) {
      e.preventDefault();
      Swal.fire({
        title: 'Ups!',
        text: 'Kamu belum memilih item untuk di-checkout 😅',
        icon: 'warning',
        background: '#fff',
        color: '#333',
        confirmButtonColor: '#fbbf24',
        confirmButtonText: 'OK',
        iconColor: '#fbbf24',
        backdrop: 'rgba(0, 0, 0, 0.6)',
      });
    }
  });
</script>

</body>
</html>
