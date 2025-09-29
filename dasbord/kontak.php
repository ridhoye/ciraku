<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #000;
    }

    .navbar {
      border-bottom: 3px solid #fbbf24;
    }
    body { font-family:'Poppins',sans-serif; background:#000; color:#fff; }
    .kontak { padding:80px 20px; }
    .kontak h2 { text-align:center; color:#fbbf24; font-weight:700; margin-bottom:10px; }
    .kontak p { text-align:center; margin-bottom:40px; color:#ccc; }
    
    .map {
      width:100%;
      height:350px;
      border:0;
      border-radius:15px;
    }

    .form-box {
      background:#1a1a1a;
      padding:25px;
      border-radius:15px;
    }
    .form-control {
      background:#222;
      border:1px solid #555;
      color:#fff;
      border-radius:10px;
    }
    .form-control:focus {
      background:#222;
      color:#fff;
      border-color:#fbbf24;
      box-shadow:none;
    }
    .form-control::placeholder { color:#bbb; }
    .invalid-feedback { color:#f87171; } /* merah untuk error */
    .btn-warning {
      background:#fbbf24;
      border:none;
      font-weight:600;
      padding:10px 20px;
      border-radius:8px;
    }
    .btn-warning:hover { background:#f59e0b; }

    footer {
      background:#222;
      padding:20px;
      text-align:center;
      color:#aaa;
      margin-top:50px;
    }
    footer a { color:#fbbf24; margin:0 8px; text-decoration:none; }
    footer a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <section class="kontak container">
    <h2>Kontak Kami</h2>
    <p>Hubungi kami untuk pemesanan atau informasi lebih lanjut.</p>
    <div class="row g-4">
      <!-- Maps -->
      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63459.94767089463!2d106.70797462167967!3d-6.2311695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1afbbd6c13d%3A0xf89baba4be66a245!2sCireng%20Isi%204%20Sekawan!5e0!3m2!1sen!2sid!4v1751094561584!5m2!1sen!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
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
