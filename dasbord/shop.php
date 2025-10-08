<?php
session_start();

// hapus item
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex biar rapih
}

// kalau checkout, ambil barang yang dicentang aja
if (isset($_POST['checkout'])) {
    $selected = $_POST['selected'] ?? [];
    $_SESSION['checkout_items'] = [];

    foreach ($selected as $index) {
        $_SESSION['checkout_items'][] = $_SESSION['cart'][$index];
    }

    header("Location: checkout.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f9fafb; font-family: 'Poppins', sans-serif; }
    .cart-table img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    .cart-footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #fff;
      border-top: 2px solid #eee;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-warning { background: #fbbf24; border: none; font-weight: bold; }
    .btn-warning:hover { background: #f59e0b; }
  </style>
</head>
<body>

<div class="container py-4">
  <h2 class="mb-4">🛒 Keranjang Belanja</h2>

  <a href="../dasbord/home.php" 
   class="btn btn-outline-dark position-fixed top-0 start-0 m-3">
   ⬅️
</a>


  <form method="POST">
    <table class="table cart-table align-middle">
      <thead>
        <tr>
          <th><input type="checkbox" id="checkAll"></th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($_SESSION['cart'])): ?>
          <?php foreach ($_SESSION['cart'] as $i => $item): ?>
            <tr>
              <td><input type="checkbox" name="selected[]" value="<?= $i ?>"></td>
              <td>
                <img src="../assets/images/<?= strtolower(str_replace(' ', '', $item['nama'])) ?>.png" alt="<?= $item['nama'] ?>">
                <?= htmlspecialchars($item['nama']) ?>
              </td>
              <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
              <td><?= $item['jumlah'] ?></td>
              <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
              <td><a href="?remove=<?= $i ?>" class="btn btn-sm btn-danger">Hapus</a></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center">Keranjang kosong</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Footer ala Shopee -->
    <div class="cart-footer">
      <div>
        <input type="checkbox" id="checkAllBottom"> Pilih Semua
      </div>
      <button type="submit" name="checkout" class="btn btn-warning btn-lg">Checkout</button>
    </div>
  </form>
</div>

<script>
// Checkbox pilih semua
document.getElementById('checkAll').addEventListener('change', function() {
  let checkboxes = document.querySelectorAll('input[name="selected[]"]');
  checkboxes.forEach(cb => cb.checked = this.checked);
  document.getElementById('checkAllBottom').checked = this.checked;
});

document.getElementById('checkAllBottom').addEventListener('change', function() {
  let checkboxes = document.querySelectorAll('input[name="selected[]"]');
  checkboxes.forEach(cb => cb.checked = this.checked);
  document.getElementById('checkAll').checked = this.checked;
});
</script>

</body>
</html>
