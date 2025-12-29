<?php
session_start();
include "../config/db.php";

require_once __DIR__ . '/../vendor/autoload.php';

use Midtrans\Config;
use Midtrans\Snap;

// ================= MIDTRANS CONFIG =================
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

Config::$serverKey    = $_ENV['MIDTRANS_SERVER_KEY'];
Config::$isProduction = ($_ENV['MIDTRANS_IS_PRODUCTION'] === 'true');
Config::$isSanitized  = true;
Config::$is3ds        = true;
// ==================================================


// ================= CEK LOGIN =================
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'")
);


// ==================================================
// 🔥 FUNGSI UTAMA: SEMUA ORDER MASUK SINI (COD & MIDTRANS)
// ==================================================
function buatOrder($conn, $order_id, $user_id, $items, $total, $payment_method, $status)
{
    mysqli_query($conn, "
        INSERT INTO orders 
        (order_id, user_id, total, payment_method, status, created_at)
        VALUES
        ('$order_id', '$user_id', '$total', '$payment_method', '$status', NOW())
    ");

    foreach ($items as $item) {
        mysqli_query($conn, "
            INSERT INTO order_items
            (order_id, produk_id, nama_produk, jumlah, harga, total)
            VALUES (
                '$order_id',
                '{$item['produk_id']}',
                '{$item['nama']}',
                '{$item['jumlah']}',
                '{$item['harga']}',
                '{$item['total']}'
            )
        ");
    }
}


// ================= CEK SUMBER ITEM =================
$items = [];
$total_all = 0;

// Direct checkout
if (isset($_SESSION['direct_checkout']) && isset($_SESSION['direct_products'])) {
    foreach ($_SESSION['direct_products'] as $p) {
        $subtotal = $p['harga'] * $p['jumlah'];
        $items[] = [
            'produk_id' => $p['id'],
            'nama'      => $p['nama_produk'],
            'harga'     => $p['harga'],
            'jumlah'    => $p['jumlah'],
            'total'     => $subtotal,
            'gambar'    => $p['gambar']
        ];
        $total_all += $subtotal;
    }
}

// Dari cart
elseif (isset($_SESSION['checkout_items'])) {
    foreach ($_SESSION['checkout_items'] as $p) {
        $subtotal = $p['harga'] * $p['quantity'];
        $items[] = [
            'produk_id' => $p['id'],
            'nama'      => $p['nama_produk'],
            'harga'     => $p['harga'],
            'jumlah'    => $p['quantity'],
            'total'     => $subtotal,
            'gambar'    => $p['gambar']
        ];
        $total_all += $subtotal;
    }
}

else {
    echo "<script>alert('Tidak ada item!');location='../dasbord/shop.php'</script>";
    exit;
}


// ================= KONFIRMASI PEMBAYARAN =================
if (isset($_POST['konfirmasi'])) {

    $payment_method = $_POST['payment_method'];
    $order_id = "CIRAKU-" . time() . rand(100,999);

    // ================= COD =================
    if ($payment_method === "cod") {

        buatOrder(
            $conn,
            $order_id,
            $user_id,
            $items,
            $total_all,
            'cod',
            'cod_pending'
        );

        // hapus cart
        if (!isset($_SESSION['direct_checkout'])) {
            foreach ($items as $item) {
                mysqli_query($conn, "
                    DELETE FROM cart 
                    WHERE user_id='$user_id' 
                    AND produk_id='{$item['produk_id']}'
                ");
            }
        }

        unset($_SESSION['direct_checkout'], $_SESSION['direct_products']);

        header("Location: ../user/pesanan.php");
        exit;
    }


    // ================= MIDTRANS =================
    if ($payment_method === "midtrans") {

        // INSERT ORDER DULU (STATUS PENDING)
        buatOrder(
            $conn,
            $order_id,
            $user_id,
            $items,
            $total_all,
            'midtrans',
            'pending'
        );
        // hapus cart
        if (!isset($_SESSION['direct_checkout'])) {
            foreach ($items as $item) {
                mysqli_query($conn, "
                    DELETE FROM cart 
                    WHERE user_id='$user_id' 
                    AND produk_id='{$item['produk_id']}'
                ");
            }
        }
        // item details untuk midtrans
        $items_for_midtrans = [];
        foreach ($items as $it) {
            $items_for_midtrans[] = [
                'id'       => $it['produk_id'],
                'price'    => (int)$it['harga'],
                'quantity' => (int)$it['jumlah'],
                'name'     => $it['nama']
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => (int)$total_all
            ],
            'item_details' => $items_for_midtrans,
            'customer_details' => [
                'first_name' => $user['full_name'],
                'email'      => $user['email'],
                'phone'      => $user['phone']
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        echo "<script>var snapToken = '$snapToken';</script>";
    }
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


    /* ================= MOBILE ULTRA PREMIUM MODE ================= */
@media (max-width: 768px){

  body{
    padding: 0;
    background: #0a0a0a;
  }

  .container-checkout{
    grid-template-columns: 1fr !important;
    padding: 0;
    gap: 0;
  }

  .page-title{
    padding: 16px;
    font-size: 22px;
    margin: 0;
    background: #0f0f0f;
    border-bottom: 1px solid rgba(255,255,255,0.05);
  }

  /* Card UI full width fullscreen style */
  .card-ui{
    border-radius: 0;
    padding: 16px 18px;
    background: #111;
    margin-bottom: 10px;
    border: none;
    box-shadow: none;
  }

  /* Address section */
  .address .title-row{
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }

  .address-meta{
    font-size: 14px;
    line-height: 1.45;
  }

  .change-btn{
    padding: 4px 10px!important;
    font-size: 12px!important;
  }

  /* Product row */
  .product-row{
    padding: 12px;
    border-radius: 12px;
    background: #161616;
    margin-bottom: 12px;
  }

  .product-thumb{
    width: 65px;
    height: 65px;
    border-radius: 10px;
  }

  .product-info .name{
    font-size: 14px;
    margin-bottom: 4px;
  }

  .product-info .meta{
    font-size: 12px;
  }

  .product-right{
    min-width: auto;
  }

  .product-right .subtotal{
    font-size: 15px;
  }

  /* Shipping box */
  .shipping-box{
    padding: 10px;
    border-radius: 12px;
    background: #161616;
  }

  /* Payment card */
  .payment-card{
    position: sticky;
    bottom: 0;
    background: #0c0c0c;
    border-top: 1px solid rgba(255,255,255,0.05);
    padding: 16px;
  }

  .pay-option{
    padding: 12px;
    border-radius: 12px;
    background: #161616;
  }

  /* Summary row */
  .summary-row{
    font-size: 14px;
    padding: 6px 0;
  }

  /* Action buttons */
  .actions{
    margin-top: 16px;
    display: flex;
    gap: 10px;
  }

  .btn-primary{
    padding: 12px;
    font-size: 15px;
    border-radius: 12px;
  }

  .btn-secondary{
    font-size: 15px;
    padding: 12px;
    border-radius: 12px;
  }

  @media (max-width: 768px) {

  /* Hilangin gap antara store dan metode pembayaran */
  .left-col,
  .right-section,
  .container-checkout {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }

  /* khusus bagian store biar nempel ke bawah */
  .store-item:last-child {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
  }

  /* hapus gap atas di metode pembayaran */
  .payment-method,
  .payment-section {
    margin-top: 0 !important;
  }
}

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
    <button class="change-btn" type="button" id="editAddressBtn">Ganti</button>
  </div>

  <!-- Mode Tampilan -->
  <div id="addressDisplay">
    <div class="address-meta">
      <div style="margin-bottom:8px;">
        <strong><?= htmlspecialchars($user['full_name'] ?? 'Pelanggan'); ?></strong> • Rumah
      </div>
      <div><?= htmlspecialchars($user['address'] ?? 'Alamat belum diisi'); ?></div>
      <div style="margin-top:8px;color:var(--muted)"><?= htmlspecialchars($user['phone'] ?? '08xxxxxxxxxx'); ?></div>
      <div style="color:var(--muted)">Kode Pos: <?= htmlspecialchars($user['postal_code'] ?? '-'); ?></div>
    </div>
  </div>

  <!-- Mode Edit -->
<form method="POST" id="addressEditForm" style="display:none;margin-top:10px;">
  <div class="address-meta">
    <label>Nama Lengkap</label>
    <input type="text" name="full_name" class="form-control mb-2" 
      value="<?= htmlspecialchars($user['full_name'] ?? ''); ?>" required>

    <label>Nomor Telepon</label>
    <input type="text" name="phone" class="form-control mb-2" 
      value="<?= htmlspecialchars($user['phone'] ?? ''); ?>" required>

    <label>Alamat Lengkap</label>
    <textarea name="address" rows="3" class="form-control mb-2" required><?= htmlspecialchars($user['address'] ?? ''); ?></textarea>

    <label>Kode Pos</label>
    <input type="text" name="postal_code" class="form-control mb-3" 
      value="<?= htmlspecialchars($user['postal_code'] ?? ''); ?>" required>

    <button type="submit" name="save_address" class="btn btn-primary w-100" 
      style="background:var(--gold-1);border:none;color:#000;font-weight:600;">
      <i class="fas fa-save"></i> Simpan Perubahan
    </button>

    <button type="button" id="cancelEditBtn" class="btn mt-2 w-100" 
      style="background:#ccc;border:none;color:#000;font-weight:600;">
      <i class="fas fa-times"></i> Batal
    </button>
  </div>
</form>
</div>

      <!-- Card 2: Daftar Produk (paket per toko mirip Tokopedia) -->
      <div class="card-ui">
        <div class="store-header">
          <!-- icon toko (bisa diganti) -->
          <img class="logo" src="../assets/images/Maskot-Bulat.png" alt="store">
          <div>Ciraku Store</div>
        </div>

        <div class="product-list">
          <?php foreach ($items as $it): ?>
            <div class="product-row">
              <!-- jika lu punya gambar produk, ganti src di bawah -->
<img src="../assets/images/<?= htmlspecialchars($it['gambar']); ?>" 
     alt="<?= htmlspecialchars($it['nama']); ?>" 
     class="product-thumb">
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
            <div style="font-size:14px; color:var(--muted)">Ekonomi - Estimasi tiba 2-4 hari</div>
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
        </div>


      
<!-- Form tetap pakai nama tombol sama supaya logic PHP ga berubah -->
   <form method="POST" style="margin-top:16px">

          <!-- METODE PEMBAYARAN -->
<div class="payment-methods" id="paymentList">
  <!-- Midtrans -->
  <label class="pay-option">
    <div style="display:flex; align-items:center; gap:10px;">
      <span style="font-size:22px;">💳</span>
      <div>
        <div style="font-weight:600">Midtrans (Online Payment)</div>
        <small class="muted">Bayar dengan transfer bank, e-wallet, atau kartu via Midtrans</small>
      </div>
    </div>
    <div>
      <input type="radio" name="payment_method" value="midtrans" checked>
    </div>
  </label>

  <!-- COD -->
  <label class="pay-option">
    <div style="display:flex; align-items:center; gap:10px;">
      <span style="font-size:22px;">🚚</span>
      <div>
        <div style="font-weight:600">Cash on Delivery (COD)</div>
        <small class="muted">Bayar langsung ke kurir saat barang diterima</small>
      </div>
    </div>
    <div>
      <input type="radio" name="payment_method" value="cod">
    </div>
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
        

          <div class="actions">
            <button type="submit" name="cancel_checkout" class="btn-secondary">Batal</button>
<button type="button" id="btnPay" class="btn-primary">Lanjut ke Pembayaran</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- SweetAlert2 confirmation for cancel (tetap sama logic JS) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= $_ENV['MIDTRANS_CLIENT_KEY']; ?>">
</script>

<script>
  // Jika snapToken dikirim dari PHP
  if (typeof snapToken !== "undefined" && snapToken !== "") {
    snap.pay(snapToken, {
        onSuccess: function(result){
            window.location.href = "../user/pesanan.php";
        },
        onPending: function(result){
            window.location.href = "../user/pesanan.php";
        },
        onError: function(result){
            Swal.fire("Pembayaran gagal", "Silakan coba lagi", "error");
        },
    });

  }
</script>


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
          iconColor: '#fbbf24',
          showCancelButton: true,
          confirmButtonColor: '#fbbf24',
          cancelButtonColor: '#ccc',
          confirmButtonText: 'Ya, batalkan',
          cancelButtonText: 'Tidak',
          background: '#fff',
          color: '#333'
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

<script>
  const editBtn = document.getElementById('editAddressBtn');
  const displayDiv = document.getElementById('addressDisplay');
  const editForm = document.getElementById('addressEditForm');
  const cancelBtn = document.getElementById('cancelEditBtn');

  editBtn.addEventListener('click', () => {
    displayDiv.style.display = 'none';
    editForm.style.display = 'block';
  });

  cancelBtn.addEventListener('click', () => {
    editForm.style.display = 'none';
    displayDiv.style.display = 'block';
  });
</script>

<script>
document.getElementById('addressEditForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  formData.append('save_address', '1'); 

  const res = await fetch(window.location.href, { method: 'POST', body: formData });
  const text = await res.text();
  console.log("Response dari server:", text); 

  if (text.trim() === 'success') {
    Swal.fire({
      title: 'Berhasil!',
      text: 'Alamat berhasil diperbarui 🎉',
      icon: 'success',
      background: '#fff',
      color: '#333',
      confirmButtonColor: '#fbbf24',
    }).then(() => location.reload());
  } 
  else if (text.trim() === 'nochange') {
    Swal.fire({
      title: 'Tidak ada perubahan!',
      text: 'Data alamat tidak berubah 😅',
      icon: 'info',
      background: '#fff',
      color: '#333',
      confirmButtonColor: '#60a5fa',
      iconColor: '#60a5fa',
    });
  } 
  else {
    Swal.fire({
      title: 'Gagal!',
      text: 'Gagal memperbarui alamat 😢',
      icon: 'error',
      background: '#fff',
      color: '#333',
      confirmButtonColor: '#f87171',
      iconColor: '#f87171',
    });
  }
});
</script>

<script>
document.getElementById("btnPay").addEventListener("click", function () {

    let method = document.querySelector('input[name="payment_method"]:checked');

    if (!method) {
        Swal.fire("Pilih metode pembayaran dulu ya!", "", "warning");
        return;
    }

    // ========================
    // 1. JIKA METODE = MIDTRANS
    // ========================
    if (method.value === "midtrans") {

        let form = document.querySelector("form[method='POST']");

        // kirim konfirmasi
        let inputKonfirmasi = document.createElement("input");
        inputKonfirmasi.type = "hidden";
        inputKonfirmasi.name = "konfirmasi";
        inputKonfirmasi.value = "1";
        form.appendChild(inputKonfirmasi);

        // kirim payment_method
        let inputPayment = document.createElement("input");
        inputPayment.type = "hidden";
        inputPayment.name = "payment_method";
        inputPayment.value = "midtrans";
        form.appendChild(inputPayment);

        // langsung submit (tidak ada alert)
        form.submit();
        return;
    }


    // ========================
    // 2. JIKA METODE = COD → tampilkan SweetAlert
    // ========================
    Swal.fire({
        title: "Pesanan Anda Sudah Dibuat",
        text: "Apakah Anda ingin ke halaman pesanan?",
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Ya, lihat pesanan",
        cancelButtonText: "Tidak, kembali ke home"
    }).then((result) => {

        if (result.isConfirmed) {

            let form = document.querySelector("form[method='POST']");

            let inputKonfirmasi = document.createElement("input");
            inputKonfirmasi.type = "hidden";
            inputKonfirmasi.name = "konfirmasi";
            inputKonfirmasi.value = "1";
            form.appendChild(inputKonfirmasi);

            let inputPayment = document.createElement("input");
            inputPayment.type = "hidden";
            inputPayment.name = "payment_method";
            inputPayment.value = "cod";
            form.appendChild(inputPayment);

            form.submit();

        } else {
            window.location.href = "../dasbord/home.php";
        }

    });

});
</script>

</body>
</html>
