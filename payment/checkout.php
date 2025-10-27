<?php
session_start();
include "../config/db.php";

// 🔒 Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kalau user belum pilih item tapi masih ada sisa data lama, hapus dulu
if (!isset($_SESSION['checkout_items']) && isset($_SESSION['last_cancelled_items'])) {
    unset($_SESSION['last_cancelled_items']);
}

// 🔙 Jika user batal
if (isset($_POST['cancel_checkout'])) {
    // Simpan dulu item yang dibatalkan (kalau mau ditampilkan)
    $_SESSION['last_cancelled_items'] = $_SESSION['checkout_items'] ?? [];

    // Hapus data checkout
    unset($_SESSION['checkout_items']);

    // Langsung kembali ke halaman keranjang di home 
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

    // 🧹 Hapus data keranjang sesuai item yang dibayar
    if (isset($_SESSION['cart']) && isset($_SESSION['checkout_items'])) {
        foreach ($_SESSION['checkout_items'] as $checkoutItem) {
            foreach ($_SESSION['cart'] as $index => $cartItem) {
                if ($cartItem['id'] == $checkoutItem['id']) {
                    unset($_SESSION['cart'][$index]);
                }
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reset index
    }

    // 🧹 Bersihkan checkout session
    unset($_SESSION['checkout_items']);

    echo "<script>
            alert('Pesanan berhasil dikirim! Silakan lanjut ke pembayaran.');
            window.location.href='../payment/payment.php';
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
      background-color: #0b0b0b;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      background: radial-gradient(circle at top, #1a1a1a 0%, #000 100%);
      min-height: 100vh;
    }

    .checkout-wrapper {
      display: flex;
      justify-content: center;
      padding-top: 80px; /* posisi di atas */
      padding-bottom: 60px;
    }

    .checkout-card {
      background: rgba(20, 20, 20, 0.9);
      border: 1px solid rgba(251, 191, 36, 0.15);
      box-shadow: 0 0 25px rgba(251, 191, 36, 0.15);
      border-radius: 20px;
      padding: 35px 40px;
      width: 700px;
      backdrop-filter: blur(8px);
      transition: all 0.3s ease;
    }

    .checkout-card:hover {
      box-shadow: 0 0 30px rgba(251, 191, 36, 0.25);
      transform: scale(1.01);
    }

    h2 {
      color: #fbbf24;
      font-weight: 700;
      text-align: center;
      text-shadow: 0 0 10px rgba(251,191,36,0.5);
      margin-bottom: 25px;
    }

    table {
      color: #fff;
      border-radius: 10px;
      overflow: hidden;
    }

    table thead {
      background: linear-gradient(to right, #fbbf24, #f59e0b);
      color: #000;
      font-weight: 600;
    }

    table tbody tr:hover {
      background-color: rgba(251, 191, 36, 0.1);
      transition: 0.2s;
    }

    .total-text {
      text-align: right;
      margin-top: 20px;
      font-size: 1.25rem;
    }

    .total-text span {
      color: #fbbf24;
      font-weight: 700;
    }

    .btn-warning {
      background-color: #fbbf24;
      color: #000;
      font-weight: 600;
      border: none;
      padding: 10px 40px;
      border-radius: 10px;
      transition: 0.2s;
    }

    .btn-warning:hover {
      background-color: #f59e0b;
      box-shadow: 0 0 15px rgba(251,191,36,0.3);
    }

    .btn-secondary {
      background-color: #555;
      color: #fff;
      padding: 10px 35px;
      border-radius: 10px;
      font-weight: 500;
      transition: 0.2s;
    }

    .btn-secondary:hover {
      background-color: #777;
      box-shadow: 0 0 10px rgba(255,255,255,0.15);
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <div class="checkout-wrapper">
    <div class="checkout-card">
      <h2>🧾 Konfirmasi Pesanan Anda</h2>

      <table class="table table-dark table-striped mb-3">
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

      <div class="total-text">
        Total Semua: <span>Rp <?= number_format($total_all, 0, ',', '.'); ?></span>
      </div>

      <form method="POST">
        <div class="button-group">
          <button type="submit" name="konfirmasi" class="btn btn-warning">Lanjut ke Pembayaran</button>
          <button type="submit" name="cancel_checkout" class="btn btn-secondary">Batal</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cancelBtn = document.querySelector('button[name="cancel_checkout"]');
  const form = document.querySelector('form'); // form utama checkout

  if (cancelBtn && form) {
    cancelBtn.addEventListener('click', function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Batalkan Pesanan?',
        text: 'Apakah kamu yakin ingin membatalkan pesanan ini?',
        icon: 'warning',
        background: '#fff',
        color: '#333',
        iconColor: '#fbbf24',
        backdrop: 'rgba(0, 0, 0, 0.6)',
        showCancelButton: true,
        confirmButtonColor: '#fbbf24',
        cancelButtonColor: '#ccc',
        confirmButtonText: 'Ya, batalkan',
        cancelButtonText: 'Tidak',
        customClass: {
          popup: 'swal2-border-radius',
          title: 'swal2-title-custom',
          htmlContainer: 'swal2-text-custom'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          // Tambahkan input hidden agar PHP mendeteksi tombol ini
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'cancel_checkout';
          hiddenInput.value = '1';
          form.appendChild(hiddenInput);

          form.submit(); // kirim form
        }
      });
    });
  }
});
</script>

<style>
.swal2-border-radius {
  border-radius: 15px !important;
}
.swal2-title-custom {
  font-weight: 700;
  color: #333;
}
.swal2-text-custom {
  font-size: 15px;
  color: #555;
}
</style>

</body>
</html>
