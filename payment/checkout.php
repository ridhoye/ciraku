<?php
session_start();

// cek apakah ada data keranjang
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: order.php"); 
    exit;
}
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Cireng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #000, #000);
      font-family: 'Poppins', sans-serif;
    }
    .checkout-container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      font-weight: bold;
      color: #fbbf24;
    }
    .btn-primary {
      background-color: #28a745;
      border: none;
    }
    .btn-primary:hover {
      background-color: #218838;
    }
    /* Modal styling biar lebih clean */
    .modal-content {
      border-radius: 15px;
      padding: 20px;
    }
    .modal-header {
      border-bottom: none;
    }
    .modal-footer {
      border-top: none;
    }
    .form-control {
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="checkout-container">
    <h2 class="mb-4">🛒 Checkout Pesananmu</h2>
    <table class="table table-bordered">
      <thead class="table-warning">
        <tr>
          <th>Menu</th>
          <th>Jumlah</th>
          <th>Harga Satuan</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($cart as $item) {
            $nama = $item['nama'];
            $jumlah = $item['jumlah'];
            $harga = $item['harga'];
            $subtotal = $jumlah * $harga;
            $total += $subtotal;
            echo "
            <tr>
              <td>$nama</td>
              <td>$jumlah</td>
              <td>Rp " . number_format($harga, 0, ',', '.') . "</td>
              <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
            </tr>";
        }
        ?>
      </tbody>
      <tfoot>
        <tr class="table-secondary">
          <td colspan="3" class="text-end fw-bold">Total</td>
          <td class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tfoot>
    </table>

    <div class="d-flex justify-content-between mt-4">
      <a href="order.php" class="btn btn-warning">⬅ Kembali Belanja</a>
      <!-- Tombol trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
        💳 Lanjut ke Pembayaran
      </button>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="paymentModalLabel">💳 Detail Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <form action="status.php" method="POST"> <!-- arahkan ke status.php -->
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" required>
          </div>

<!-- Metode Pembayaran -->
<div class="mb-3">
  <label class="form-label fw-bold">Metode Pembayaran</label>
  <div class="border rounded p-3">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="metode" value="Transfer Bank" id="transfer" required>
      <label class="form-check-label" for="transfer">🏦 Transfer Bank</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="metode" value="COD" id="cod">
      <label class="form-check-label" for="cod">🚚 Bayar di Tempat (COD)</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="metode" value="E-Wallet" id="ewallet">
      <label class="form-check-label" for="ewallet">📱 E-Wallet (Dana, OVO, GoPay)</label>
    </div>
  </div>
</div>

<!-- Instruksi Pembayaran (akan muncul dinamis) -->
<div id="payment-instructions" class="alert alert-info d-none mt-3"></div>

<script>
document.querySelectorAll('input[name="metode"]').forEach((radio) => {
  radio.addEventListener('change', function() {
    let instructions = document.getElementById("payment-instructions");
    instructions.classList.remove("d-none");

    if (this.value === "Transfer Bank") {
      instructions.innerHTML = `
        <h6>🏦 Instruksi Transfer Bank</h6>
        <p>Silakan transfer ke rekening berikut:</p>
        <p><b>BCA - 123456789 a.n. Temen Lu</b></p>
      `;
    } else if (this.value === "E-Wallet") {
      instructions.innerHTML = `
        <h6>📱 Instruksi E-Wallet</h6>
        <p>Silakan transfer ke salah satu E-Wallet berikut:</p>
        <ul>
          <li>DANA: 0812-XXXX-XXXX</li>
          <li>OVO: 0812-YYYY-YYYY</li>
          <li>GoPay: 0812-ZZZZ-ZZZZ</li>
        </ul>
      `;
    } else if (this.value === "COD") {
      instructions.innerHTML = `
        <h6>🚚 Bayar di Tempat</h6>
        <p>Silakan siapkan uang pas saat pesanan diantar.</p>
      `;
    }
  });
});
</script>

          <hr>
          <h6 class="fw-bold">🧾 Rincian Belanja</h6>
          <p class="mb-1">Total Belanja: <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span></p>
          <p class="mb-1">Ongkir: <span class="fw-bold">Rp 5.000</span></p>
          <p class="mb-0 text-success">Total Bayar: 
            <span class="fw-bold">Rp <?= number_format($total + 5000, 0, ',', '.') ?></span>
          </p>

          <!-- kirim juga total belanja ke status.php -->
          <input type="hidden" name="total_belanja" value="<?= $total ?>">
          <input type="hidden" name="ongkir" value="5000">
          <input type="hidden" name="total_bayar" value="<?= $total + 5000 ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">✅ Bayar Sekarang</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
