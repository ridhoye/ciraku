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
    header("Location: ../payment/order.php");


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

if (isset($_SESSION['cart']) && isset($_SESSION['checkout_items'])) {
    foreach ($_SESSION['checkout_items'] as $checkoutItem) {
        foreach ($_SESSION['cart'] as $index => $cartItem) {
            if ($cartItem['nama'] == $checkoutItem['nama']) { // bisa pakai id juga
                unset($_SESSION['cart'][$index]);
            }
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // tetap jaga index
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout Ciraku</title>

  <!-- Bootstrap CSS (optional, for utility) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ===== Theme colors (Ciraku dark + gold) ===== */
    :root{
      --bg: #0b0b0b;
      --panel: rgba(18,18,18,0.95);
      --muted: #cfcfcf;
      --gold-1: #fbbf24;
      --gold-2: #f59e0b;
      --card-border: rgba(251,191,36,0.12);
      --card-shadow: 0 6px 30px rgba(251,191,36,0.06);
      --radius: 14px;
    }

    *{box-sizing: border-box}
    body{
      margin:0;
      font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: radial-gradient(circle at top, #111 0%, #000 60%), var(--bg);
      color: #fff;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      min-height:100vh;
      padding:40px 24px;
    }

    /* Container centered, with max width */
    .container-checkout{
      max-width:1200px;
      margin:0 auto;
      display:grid;
      grid-template-columns: 1fr 380px; /* left 2fr vs right fixed */
      gap:28px;
      align-items:start;
      margin-top: 0;
    }

        /* Biar kolom kanan naik sejajar sama kiri (karena kiri ada judul Checkout) */
    .right-section {
      align-self: start;
      margin-top: 72px !important; /* atur tinggi naik-turun sesuai tampilan */
    }

    /* (Opsional) kalau mau super presisi sejajar atas banget */
    @media (min-width: 981px) {
      .page-title {
        margin-bottom: 24px; /* stabilin jarak bawah judul biar kiri & kanan rata */
      }
    }
    /* Left column stacks two cards */
    .left-col{ display:flex; flex-direction:column; gap:20px; }

    /* Generic card used for the three borders */
    .card-ui{
      background: linear-gradient(180deg, rgba(22,22,22,0.9), rgba(12,12,12,0.85));
      border-radius: var(--radius);
      padding:20px;
      border: 1px solid var(--card-border);
      box-shadow: var(--card-shadow);
    }

    /* Big title like Tokopedia style */
    .page-title{
      font-size:28px;
      margin-bottom:12px;
      color: var(--gold-1);
      text-shadow: 0 0 10px rgba(251,191,36,0.12);
      font-weight:700;
    }

    /* ===== Address card ===== */
    .address .title-row{
      display:flex; align-items:center; justify-content:space-between;
      gap:10px;
    }
    .address .address-meta{
      color:var(--muted);
      margin-top:10px;
      line-height:1.45;
    }
    .address .change-btn{
      background:transparent;
      border:1px solid rgba(255,255,255,0.06);
      color:var(--muted);
      padding:6px 10px;
      border-radius:10px;
      font-size:13px;
    }

    /* ===== Product card (store block) ===== */
    .store-block{
      display:flex;
      gap:14px;
      align-items:flex-start;
    }
    .store-header{
      display:flex; align-items:center; gap:10px; margin-bottom:10px;
      font-weight:600; color:var(--gold-1);
    }
    .store-header img.logo{
      width:28px; height:28px; border-radius:6px; object-fit:cover;
    }
    .product-list{ margin-top:8px; }

    .product-row{
      display:flex;
      gap:12px;
      padding:14px;
      border-radius:10px;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      align-items:center;
      margin-bottom:12px;
      border:1px solid rgba(255,255,255,0.02);
    }
    .product-thumb{
      width:72px; height:72px; border-radius:8px; object-fit:cover; background:#222;
      flex-shrink:0;
    }
    .product-info{ flex:1; }
    .product-info .name{ font-weight:600; color:#fff; margin-bottom:6px; }
    .product-info .meta{ color:#bfbfbf; font-size:13px; }
    .product-right{ text-align:right; min-width:130px; color:var(--muted); }
    .product-right .subtotal{ font-weight:700; color:var(--gold-1); }

    .shipping-box{
      margin-top:12px;
      border-radius:10px;
      background: rgba(255,255,255,0.02);
      padding:12px;
      border:1px dashed rgba(255,255,255,0.03);
      color:var(--muted);
      font-size:14px;
    }

    /* ===== Right column: payment summary ===== */
    .payment-card .title-row{
      display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;
    }
    .payment-methods{ max-height:260px; overflow:auto; padding-right:6px; }
    .pay-option{
      display:flex; align-items:center; justify-content:space-between;
      padding:12px; border-radius:10px; margin-bottom:10px;
      background:rgba(255,255,255,0.015); border:1px solid rgba(255,255,255,0.02);
      cursor:pointer;
    }
    .pay-option:hover{ border-color: rgba(251,191,36,0.12); }

    .pay-option small{ color:var(--muted); display:block; margin-top:6px; }

    .summary-row{ display:flex; justify-content:space-between; align-items:center; margin-top:14px; color:var(--muted); }
    .summary-row strong{ color:var(--gold-1); font-size:18px; }

    .actions{ margin-top:18px; display:flex; gap:12px; }
    .btn-primary{
      flex:1; padding:12px 14px; border-radius:10px; border:none; background:var(--gold-1);
      color:#000; font-weight:700; cursor:pointer; box-shadow:0 6px 18px rgba(251,191,36,0.12);
    }
    .btn-secondary{
      padding:12px 14px; border-radius:10px; border:1px solid rgba(255,255,255,0.06);
      background:transparent; color:var(--muted); cursor:pointer;
    }

    /* small screen: single column */
    @media (max-width: 980px){
      .container-checkout{ grid-template-columns: 1fr; padding:0 12px; }
      .right-section{ order: 3; }
    }

  </style>
</head>
<body>

  <div class="container-checkout">
    <div class="left-col">
      <div class="page-title">Checkout</div>

      <!-- Card 1: Alamat Pengiriman -->
      <div class="card-ui address">
        <div class="title-row">
          <div style="font-weight:700;color:var(--gold-1)">ALAMAT PENGIRIMAN</div>
          <button class="change-btn" type="button">Ganti</button>
        </div>
        <!-- Dummy: lu bisa ganti pake data dinamis user -->
        <div class="address-meta">
          <div style="margin-bottom:8px;"><strong><?= htmlspecialchars($_SESSION['username'] ?? 'Pelanggan'); ?></strong> • Rumah</div>
          <div>Jl. Contoh Alamat No. 12, RT 01 RW 02, Kecamatan Contoh, Kota — Provinsi</div>
          <div style="margin-top:8px;color:var(--muted)"><?= htmlspecialchars($_SESSION['phone'] ?? '08xxxxxxxxxx'); ?></div>
        </div>
      </div>

      <!-- Card 2: Daftar Produk (paket per toko mirip Tokopedia) -->
      <div class="card-ui">
        <div class="store-header">
          <!-- icon toko (bisa diganti) -->
          <img class="logo" src="../img/store-default.png" alt="store">
          <div>Ciraku Store</div>
        </div>

        <div class="product-list">
          <?php foreach ($items as $it): ?>
            <div class="product-row">
              <!-- jika lu punya gambar produk, ganti src di bawah -->
              <img src="../img/produk/default.png" alt="thumb" class="product-thumb">
              <div class="product-info">
                <div class="name"><?= htmlspecialchars($it['nama']); ?></div>
                <div class="meta"><?= $it['jumlah']; ?> x Rp <?= number_format($it['harga'],0,',','.'); ?></div>
              </div>

              <div class="product-right">
                <div class="subtotal">Rp <?= number_format($it['total'],0,',','.'); ?></div>
                <div style="font-size:12px;color:var(--muted);margin-top:6px">Subtotal</div>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="shipping-box">
            <div style="font-weight:600; color:#fff; margin-bottom:6px">Pengiriman</div>
            <div style="font-size:14px; color:var(--muted)">Ekonomi - Estimasi tiba 2-4 hari • Biaya: Rp 7.500</div>
            <div style="margin-top:8px; font-size:13px; color:var(--muted)">Gunakan asuransi pengiriman (opsional)</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right column: metode pembayaran + ringkasan -->
    <div class="right-section">
      <div class="card-ui payment-card">
        <div class="title-row">
          <div style="font-weight:700;color:var(--gold-1)">Metode Pembayaran</div>
          <a href="#" style="color:var(--gold-1); font-weight:600; font-size:13px; text-decoration:none">Lihat Semua</a>
        </div>

        <div class="payment-methods" id="paymentList">
          <label class="pay-option">
            <div>
              <div style="font-weight:600">Alfamart / Alfamidi / Lawson</div>
              <small class="muted">Bayar di minimarket terdekat</small>
            </div>
            <div>
              <input type="radio" name="payment_method" value="minimarket" checked>
            </div>
          </label>

          <label class="pay-option">
            <div>
              <div style="font-weight:600">BCA Virtual Account</div>
              <small class="muted">Transfer melalui VA BCA</small>
            </div>
            <div><input type="radio" name="payment_method" value="bca"></div>
          </label>

          <label class="pay-option">
            <div>
              <div style="font-weight:600">Mandiri Virtual Account</div>
              <small class="muted">Transfer via Mandiri VA</small>
            </div>
            <div><input type="radio" name="payment_method" value="mandiri"></div>
          </label>

          <label class="pay-option">
            <div>
              <div style="font-weight:600">E-Wallet (Dana/OVO/Gopay)</div>
              <small class="muted">Pembayaran cepat lewat e-wallet</small>
            </div>
            <div><input type="radio" name="payment_method" value="ewallet"></div>
          </label>
        </div>

        <div class="summary-row" style="margin-top:14px">
          <div style="color:var(--muted)">Total Produk</div>
          <div style="font-weight:700; color:#fff"><?= count($items); ?> item</div>
        </div>

        <div class="summary-row" style="margin-top:8px">
          <div style="color:var(--muted)">Total Semua</div>
          <strong>Rp <?= number_format($total_all,0,',','.'); ?></strong>
        </div>

        <!-- Form tetap pakai nama tombol sama supaya logic PHP ga berubah -->
        <form method="POST" style="margin-top:16px">
          <div class="actions">
            <button type="submit" name="cancel_checkout" class="btn-secondary">Batal</button>
            <button type="submit" name="konfirmasi" class="btn-primary">Lanjut ke Pembayaran</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- SweetAlert2 confirmation for cancel (tetap sama logic JS) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Hijack tombol cancel untuk konfirmasi user sebelum submit
    document.addEventListener('click', function(e){
      const target = e.target;
      if(target && target.matches('button[name="cancel_checkout"], button[name="cancel_checkout"] *')){
        // temukan tombol cancel paling dekat
        const btn = target.closest('button[name="cancel_checkout"]') || target;
        if(!btn) return;
        e.preventDefault();
        Swal.fire({
          title: 'Batalkan Pesanan?',
          text: 'Apakah kamu yakin ingin membatalkan pesanan ini?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#fbbf24',
          cancelButtonColor: '#777',
          confirmButtonText: 'Ya, batalkan',
          cancelButtonText: 'Tidak',
          background: '#0f0f0f',
          color: '#fff'
        }).then((res)=>{
          if(res.isConfirmed){
            // buat form sementara untuk submit cancel
            const f = document.createElement('form');
            f.method = 'POST';
            f.style.display = 'none';
            const inp = document.createElement('input');
            inp.name = 'cancel_checkout';
            inp.value = '1';
            f.appendChild(inp);
            document.body.appendChild(f);
            f.submit();
          }
        });
      }
    });
  </script>

</body>
</html>
