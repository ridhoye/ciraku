<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #000;
      color: #fff;
    }
    .navbar { border-bottom: 3px solid #fbbf24; }
    .kontak { padding:80px 20px; }
    .kontak h2 { text-align:center; color:#fbbf24; font-weight:700; margin-bottom:10px; }
    .kontak p { text-align:center; margin-bottom:40px; color:#ccc; }
    .map { width:100%; height:350px; border:0; border-radius:15px; }
    .form-box { background:#1a1a1a; padding:25px; border-radius:15px; }
    .form-control, .form-select {
      background:#222; border:1px solid #555; color:#fff; border-radius:10px;
    }
    .form-control:focus, .form-select:focus {
      background:#222; color:#fff; border-color:#fbbf24; box-shadow:none;
    }
    .form-control::placeholder { color:#bbb; }
    .invalid-feedback { color:#f87171; }
    .btn-warning {
      background:#fbbf24; border:none; font-weight:600;
      padding:10px 20px; border-radius:8px;
    }
    .btn-warning:hover { background:#f59e0b; }
    .info-box {
      background:#1a1a1a;
      padding:20px;
      border-radius:15px;
      margin-top:20px;
    }
    .info-box i { color:#fbbf24; margin-right:8px; }
    .info-box a { color:#fbbf24; margin-right:10px; font-size:1.2rem; }
    .info-box a:hover { color:#f59e0b; }
    footer {
      background:#222; padding:20px; text-align:center;
      color:#aaa; margin-top:50px;
    }
    footer a { color:#fbbf24; margin:0 8px; text-decoration:none; }
    footer a:hover { text-decoration:underline; }

     .info-box p {
    margin-bottom: 4px; /* default biasanya 16px, kita kecilin */
    font-size: 15px;    /* biar lebih compact */
    line-height: 1.4;   /* biar teks rapet */
  }

  .info-box h5 {
    margin-bottom: 8px; /* judul agak deket ke bawah */
  }

  .info-box .mt-2 a {
    font-size: 18px; 
    margin-right: 10px; /* jarak antar ikon */
  }
/* icons sosmed */
  .sosmed {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  color: #fff;
  font-size: 18px;
  transition: 0.3s;
  text-decoration: none;
}

.sosmed:hover {
  transform: scale(1.1);
  opacity: 0.9;
}

/* warna khas */
.sosmed.wa { background-color: #25D366; } /* WhatsApp hijau */
.sosmed.ig { 
  background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
} /* IG gradasi */
.sosmed.tiktok { 
  background: linear-gradient(135deg, #000 50%, #ff0050 75%, #00f2ea 100%);
} /* TikTok hitam + merah-biru */
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <section class="kontak container">
    <h2>Kontak Kami</h2>
    <p>Hubungi kami untuk pemesanan atau informasi lebih lanjut.</p>
    <div class="row g-4">
      
      <!-- Maps + Info -->
      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3966.2771839272245!2d106.69842507475062!3d-6.227138893760954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTMnMzcuNyJTIDEwNsKwNDInMDMuNiJF!5e0!3m2!1sen!2sid!4v1759155163104!5m2!1sen!2sid" 
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        
       <div class="info-box mt-4">
  <h5 class="text-warning">Informasi Kontak</h5>
  <p><i class="bi bi-geo-alt"></i> Komplek Griya Kencana 1, Jalan Bodong Gang Bodong City RT 01/RW 12,Pedurenan,Karang Tengah,KOTA TANGERANG</p>
  <p><i class="bi bi-telephone"></i> 085784740736</p>
  <p><i class="bi bi-envelope"></i> support@ciraku.com</p>
  <p><i class="bi bi-clock"></i> Buka: 08.00 - 21.00 WIB</p>
  <div class="mt-3 d-flex gap-2">
  <a href="https://wa.me/6281234567890" class="sosmed wa"><i class="bi bi-whatsapp"></i></a>
  <a href="https://instagram.com/ciraku" class="sosmed ig"><i class="bi bi-instagram"></i></a>
  <a href="https://tiktok.com/@ciraku" class="sosmed tiktok"><i class="bi bi-tiktok"></i></a>
</div>

</div>
        </div>

      <!-- Form -->
      <div class="col-md-6">
        <div class="form-box">
          <form class="needs-validation" novalidate>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Nama" required>
              <div class="invalid-feedback">Nama wajib diisi.</div>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" required>
              <div class="invalid-feedback">Masukkan email yang valid.</div>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="No HP" pattern="^[0-9]{10,15}$" required>
              <div class="invalid-feedback">Masukkan nomor HP yang benar (10–15 digit).</div>
            </div>
            <div class="mb-3">
              <select class="form-select" required>
                <option value="" disabled selected>Pilih Subjek</option>
                <option value="pemesanan">Pemesanan</option>
                <option value="produk">Tanya Produk</option>
                <option value="saran">Saran / Kritik</option>
                <option value="kerjasama">Kerjasama</option>
                <option value="lainnya">Lainnya</option>
              </select>
              <div class="invalid-feedback">Pilih salah satu subjek.</div>
            </div>
            <div class="mb-3">
              <textarea class="form-control" rows="4" placeholder="Pesan" required></textarea>
              <div class="invalid-feedback">Pesan wajib diisi.</div>
            </div>
            <button type="submit" class="btn btn-warning w-100">Kirim</button>
          </form>
        </div>
      </div>

    </div>
  </section>

  <?php include 'footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Script validasi Bootstrap
    (function () {
      'use strict'
      const forms = document.querySelectorAll('.needs-validation')
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>
</html>
