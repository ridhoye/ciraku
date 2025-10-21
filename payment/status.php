<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Status Pesanan</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      width: 450px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    .success {
      font-size: 22px;
      font-weight: bold;
      color: #2ecc71;
      margin-bottom: 10px;
    }

    .steps {
      display: flex;
      justify-content: space-between;
      margin: 30px 0 10px;
      position: relative;
    }

    .steps::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 10%;
      right: 10%;
      height: 4px;
      background: #ddd;
      z-index: 0;
      border-radius: 2px;
    }

    /* progress bar hijau */
    .steps::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 10%;
      height: 4px;
      background: #2ecc71;
      z-index: 0;
      border-radius: 2px;
      width: calc((var(--active-step, 1) - 1) * 40%);
      transition: width 0.4s ease;
    }

    .step {
      background: #ddd;
      color: #fff;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      z-index: 1;
      position: relative;
    }

    .step.active {
      background: #2ecc71;
    }

    .step-text {
      font-size: 13px;
      margin-top: 8px;
    }

    .rincian {
      text-align: left;
      margin-top: 20px;
      font-size: 14px;
    }

    .rincian p {
      margin: 5px 0;
    }

    .buttons {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      color: #fff;
      transition: 0.3s ease;
    }

    .btn-belanja {
      background: #3498db;
    }
    .btn-belanja:hover {
      background: #2980b9;
    }

    .btn-home {
      background: #28a745;
    }
    .btn-home:hover {
      background: #1e7e34;
    }
  </style>
</head>
<body>
  <div class="card" style="--active-step:2;"> <!-- ubah angka sesuai step aktif (1,2,3) -->
    <div class="success">✅ Pesanan Berhasil!</div>
    <p>Terima kasih <b>TES</b>, pesananmu sedang diproses.</p>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step active">1</div>
      <div class="step active">2</div>
      <div class="step">3</div>
    </div>
    <div style="display: flex; justify-content: space-between; font-size: 13px;">
      <div>Diproses</div>
      <div>Dikirim</div>
      <div>Sampai</div>
    </div>

    <!-- Rincian -->
    <div class="rincian">
      <p><b>Rincian Pembayaran:</b></p>
      <p>Total Belanja: Rp 69.000</p>
      <p>Ongkir: Rp 5.000</p>
      <p><b>Total Bayar: Rp 74.000</b></p>
      <p><b>Metode Bayar:</b> Transfer Bank BCA</p>
      <hr>
      <p><b>Alamat Pengiriman:</b> tes</p>
      <p><b>No. HP:</b> 0812112121</p>
    </div>

    <!-- Tombol -->
    <div class="buttons">
      <a href="order.php" class="btn btn-belanja">⬅️ Kembali Belanja</a>
      <a href="../dasbord/home.php" class="btn btn-home">🏠 Ke Homepage</a>
    </div>
  </div>
</body>
</html>
