<?php
session_start();
include "../config/db.php";

// Hapus data checkout lama hanya jika user belum klik tombol Checkout
if (!isset($_POST['selected_items']) && !isset($_GET['add'])) {
    if (isset($_SESSION['checkout_items'])) unset($_SESSION['checkout_items']);
}

// --- Tambah produk ke keranjang ---
if (isset($_GET['add'])) {
    $id_produk = intval($_GET['add']);
    $produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id_produk"));
    if ($produk) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id_produk) {
                $item['jumlah']++;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $produk['id'],
                'nama' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'gambar' => $produk['gambar'],
                'jumlah' => 1
            ];
        }
    }
    header("Location: shop.php");
    exit();
}

// --- Hapus satu item ---
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    $redirect = "shop.php";
    if (isset($_GET['from']) && $_GET['from'] === "order") {
        $redirect .= "?from=order";
    }
    header("Location: " . $redirect);
    exit();
}

// --- Proses Checkout ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_items'])) {
    $selected = $_POST['selected_items'];
    $checkout_items = [];

    foreach ($selected as $index) {
        if (isset($_SESSION['cart'][$index])) {
            $checkout_items[] = $_SESSION['cart'][$index];
        }
    }

    if (!empty($checkout_items)) {
        $_SESSION['checkout_items'] = $checkout_items;
        header("Location: ../payment/checkout.php");
        exit;
    } else {
        echo "<script>alert('Pilih dulu item yang mau di-checkout!');</script>";
    }
}

// --- Tentukan halaman sebelumnya ---
$back_page = "http://localhost/ciraku/dasbord/home.php";
if (isset($_GET['from']) && $_GET['from'] === "order") {
    $back_page = "http://localhost/ciraku/payment/order.php";
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
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <span>🛒 Keranjang Belanja</span>
      <!-- Tombol kembali otomatis -->
      <button class="back-btn" onclick="window.location.href='<?= $back_page ?>'">← Kembali</button>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
      <form method="POST" id="checkoutForm" action="shop.php">
      <?php 
      foreach ($_SESSION['cart'] as $index => $item):
        $subtotal = $item['harga'] * $item['jumlah'];
      ?>
      <div class="cart-item">
        <div class="cart-item-left">
          <input type="checkbox" class="item-checkbox" name="selected_items[]" value="<?= $index ?>" data-harga="<?= $subtotal; ?>">
          <img src="../assets/images/<?= htmlspecialchars($item['gambar']); ?>" alt="<?= htmlspecialchars($item['nama']); ?>">
          <div>
            <span class="cart-item-name"><?= htmlspecialchars($item['nama']); ?></span><br>
            <small>x<?= $item['jumlah']; ?></small>
          </div>
        </div>
        <div class="cart-item-right">
          <span class="cart-item-price">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
          <a href="?remove=<?= $index ?>" class="hapus-btn">Hapus</a>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="footer">
        <div>
          <label><input type="checkbox" id="selectAll"> Pilih Semua</label>
          <button type="button" id="hapusSemuaBtn" class="hapus-semua-btn">🗑️ Hapus Semua</button>
        </div>
        <div>
          <span class="total">Total: Rp <span id="totalValue">0</span></span>
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
        showCancelButton: true,
        confirmButtonColor: '#ff5500',
        cancelButtonColor: '#555',
        confirmButtonText: 'Ya, hapus semua!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          const urlParams = new URLSearchParams(window.location.search);
          const fromParam = urlParams.get('from') === 'order' ? '?clear=true&from=order' : '?clear=true';
          window.location.href = fromParam;
        }
      });
    });

    updateTotal();
  </script>
</body>
</html>
