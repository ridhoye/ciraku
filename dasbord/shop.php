<?php
session_start();

// daftar gambar produk
$gambarProduk = [
    'Cireng Ayam'   => 'ayam.png',
    'Cireng Kornet' => 'kornet.png',
    'Cireng Keju'   => 'keju.png',
    'Cireng Sosis'  => 'sosis.png'
];

// --- simulasi penambahan produk ---
if (isset($_GET['add'])) {
    $produk = $_GET['add'];
    $harga = 3000;

    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['nama'] === $produk) {
            $item['jumlah']++;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'nama' => $produk,
            'harga' => $harga,
            'jumlah' => 1
        ];
    }

    header("Location: shop.php");
    exit();
}

// hapus item
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// hapus semua item
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: shop.php");
    exit();
}

// NOTE: removed previous logic that deleted cart items on checkout.
// We will POST selected item indices to checkout.php and let checkout/status handle deletion.
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #0d0d0d;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 80%;
      max-width: 800px;
      margin: 50px auto;
      background: #1a1a1a;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(255,136,0,0.2);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(90deg, #ff8800, #ff5500);
      padding: 20px;
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
    }

    .back-btn {
      background: transparent;
      border: 1px solid #fff;
      color: #fff;
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
    }

    .back-btn:hover {
      background-color: #fff;
      color: #ff5500;
    }

    .cart-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #1a1a1a;
      padding: 12px 20px;
      border-bottom: 1px solid #2c2c2c;
    }

    .cart-item-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cart-item-left img {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      object-fit: cover;
    }

    .cart-item-name {
      font-size: 16px;
      font-weight: 500;
      color: #fff;
    }

    .cart-item-qty {
      font-size: 13px;
      color: #ccc;
    }

    .cart-item-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cart-item-price {
      color: #ff8800;
      font-weight: bold;
    }

    .hapus-btn {
      background: transparent;
      border: 1px solid #ff5500;
      color: #ff5500;
      padding: 5px 10px;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
    }

    .hapus-btn:hover {
      background: #ff5500;
      color: #fff;
    }

    .footer {
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #111;
      border-top: 1px solid #2c2c2c;
    }

    .total {
      color: #ff8800;
      font-weight: bold;
    }

    .checkout-btn {
      background: linear-gradient(90deg, #ff8800, #ff5500);
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .checkout-btn:hover {
      transform: scale(1.05);
      background: linear-gradient(90deg, #ff5500, #ff8800);
    }

    .hapus-semua-btn {
      background: transparent;
      border: 1px solid #ff8800;
      color: #ff8800;
      padding: 7px 12px;
      border-radius: 8px;
      margin-left: 10px;
      cursor: pointer;
      transition: 0.3s;
      display: none;
    }

    .hapus-semua-btn:hover {
      background-color: #ff8800;
      color: white;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <span>🛒 Keranjang Belanja</span>
      <button class="back-btn" onclick="window.location.href='home.php'">← Kembali</button>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
      <!-- NOTE: action menuju checkout.php, kita kirim selected indices lewat POST -->
      <form method="POST" id="checkoutForm" action="http://localhost/ciraku/payment/checkout.php">
      <?php 
      $total = 0;
      foreach ($_SESSION['cart'] as $index => $item): 
        $namaFileGambar = $gambarProduk[$item['nama']] ?? 'default.png';
        $subtotal = $item['harga'] * $item['jumlah'];
        $total += $subtotal;
      ?>
      <div class="cart-item">
        <div class="cart-item-left">
          <input type="checkbox" name="pilih[]" value="<?= $index; ?>">
          <img src="../assets/images/<?= $namaFileGambar ?>" alt="<?= $item['nama'] ?>">
          <div>
            <span class="cart-item-name"><?= $item['nama'] ?></span><br>
            <span class="cart-item-qty">x<?= $item['jumlah'] ?></span>
          </div>
        </div>

        <div class="cart-item-right">
          <span class="cart-item-price">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
          <a href="?remove=<?= $index ?>" class="hapus-btn">Hapus</a>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="footer">
        <div>
          <label><input type="checkbox" id="selectAll"> Pilih Semua</label>
          <button id="hapusSemuaBtn" class="hapus-semua-btn">Hapus Semua</button>
        </div>
        <div>
          <span class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></span>
          <!-- tombol tetap type="button" agar kita kontrol submit pake JS -->
          <button type="button" id="checkoutBtn" class="checkout-btn">Checkout</button>
        </div>
      </div>
      </form>
    <?php else: ?>
      <p style="text-align:center; padding:30px; color:#aaa;">Keranjang masih kosong 😅</p>
    <?php endif; ?>
  </div>

  <script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[name="pilih[]"]');
    const hapusSemuaBtn = document.getElementById('hapusSemuaBtn');
    const checkoutBtn = document.getElementById('checkoutBtn');

    selectAll?.addEventListener('change', function() {
      checkboxes.forEach(cb => cb.checked = this.checked);
      toggleHapusSemua();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', toggleHapusSemua));

    function toggleHapusSemua() {
      const selected = [...checkboxes].filter(cb => cb.checked).length;
      hapusSemuaBtn.style.display = selected > 0 ? 'inline-block' : 'none';
    }

    hapusSemuaBtn?.addEventListener('click', () => {
      const selectedCount = [...checkboxes].filter(cb => cb.checked).length;
      Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Yakin ingin menghapus ${selectedCount} barang dari keranjang?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5500',
        cancelButtonColor: '#555',
        confirmButtonText: 'Ya, hapus semua',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '?clear=true';
        }
      });
    });

    // === Checkout: redirect ke checkout.php sambil POST selected items ===
    checkoutBtn?.addEventListener('click', () => {
      const selected = [...checkboxes].filter(cb => cb.checked);
      const selectedCount = selected.length;

      if (selectedCount === 0) {
        Swal.fire({
          icon: 'info',
          title: 'Belum ada barang yang dipilih',
          text: 'Pilih minimal 1 item untuk checkout ya 😊',
          confirmButtonColor: '#ff5500'
        });
        return;
      }

      Swal.fire({
        title: 'Lanjut ke Pembayaran?',
        text: `Kamu akan checkout ${selectedCount} item.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ff5500',
        cancelButtonColor: '#555',
        confirmButtonText: 'Ya, lanjut!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.getElementById('checkoutForm');

          // Hapus input hidden sebelumnya kalau ada (prevent duplicate)
          document.querySelectorAll('input[name="selected_items[]"]').forEach(n => n.remove());

          // Tambah hidden fields berisi indeks item yang dipilih
          selected.forEach(cb => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'selected_items[]'; // nama yang dikirim ke checkout.php
            hidden.value = cb.value;
            form.appendChild(hidden);
          });

          // submit form ke checkout.php (action di form)
          form.submit();
        }
      });
    });
  </script>
</body>
</html>
