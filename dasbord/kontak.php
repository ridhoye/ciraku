<?php
// Mulai session, wajib biar bisa pakai $_SESSION untuk nyimpen data login user
session_start();

// Hubungkan ke file konfigurasi database (supaya $conn bisa dipakai)
include "../config/db.php";

// Variabel untuk nyimpen pesan alert SweetAlert (kalau nanti mau ditampilkan di halaman)
$swal = null;

// --- CEK APAKAH USER SUDAH LOGIN --- //
$user = null; // Variabel buat nyimpen data user
if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) {
  // Ambil ID user yang disimpan di session
  $user_id = $_SESSION['user_id'];
  // Ambil data user dari database berdasarkan ID-nya
  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));
}

// --- PROSES SAAT FORM DIKIRIM (METHOD POST) --- //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Kalau user belum login
  if (!isset($_SESSION['logged_in']) || !$user) {
    // Bikin alert warning supaya user disuruh login dulu
    $swal = [
      'icon' => 'warning',
      'title' => 'Ups!',
      'text'  => 'Silakan login atau daftar terlebih dahulu untuk mengirim pesan.'
    ];
  } else {
    // --- Kalau user udah login, ambil datanya dan form input --- //

    // Lindungi dari serangan SQL Injection pakai mysqli_real_escape_string
    $nama   = mysqli_real_escape_string($conn, $user['full_name']);
    $email  = mysqli_real_escape_string($conn, $user['email']);
    $phone  = mysqli_real_escape_string($conn, $user['phone']);
    $subjek = mysqli_real_escape_string($conn, $_POST['subjek']);
    $pesan  = mysqli_real_escape_string($conn, $_POST['pesan']);

    // Query untuk simpan pesan ke tabel kontak_pesan
    $query = "INSERT INTO kontak_pesan (user_id, nama, email, phone, subjek, pesan)
              VALUES ('$user_id', '$nama', '$email', '$phone', '$subjek', '$pesan')";

    // Jalankan query, lalu cek berhasil atau enggak
    if (mysqli_query($conn, $query)) {
      // Kalau berhasil, tampilkan pesan sukses
      $swal = [
        'icon' => 'success',
        'title' => 'Berhasil!',
        'text'  => 'Pesan kamu sudah dikirim. Terima kasih telah menghubungi kami!'
      ];
    } else {
      // Kalau gagal, tampilkan pesan error
      $swal = [
        'icon' => 'error',
        'title' => 'Gagal!',
        'text'  => 'Terjadi kesalahan saat mengirim pesan. Coba lagi ya!'
      ];
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak Kami - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #000;
    color: #fff;
  }
  .navbar { border-bottom: 3px solid #fbbf24; }
  .kontak { padding:80px 20px; }
  .section-title { text-align:center; font-weight:700; margin-bottom:10px; color:#fff; }
  .section-title span { color:#fbbf24; }
  .kontak p { text-align:center; margin-bottom:40px; color:#ccc; }
  .map { width:100%; height:350px; border:0; border-radius:15px; }

  .form-box {
    background:#1a1a1a;
    padding:25px;
    border-radius:15px;
    transition:transform 0.4s ease, box-shadow 0.4s ease;
  }
  .form-box:hover {
    transform:translateY(-5px);
    box-shadow:0 0 20px rgba(251, 191, 36, 0.2);
  }

  .form-control, .form-select, textarea {
    background:#222 !important;
    border:1px solid #555;
    color:#fff !important;
    border-radius:10px;
  }
  .form-control:focus, .form-select:focus, textarea:focus {
    border-color:#fbbf24;
    box-shadow: 0 0 5px #fbbf24;
  }
  .form-control::placeholder, textarea::placeholder { color:#bbb !important; opacity:1; }
  select.form-select option { background-color:#1a1a1a; color:#fff; }

  .btn-warning {
    background:#fbbf24;
    border:none;
    font-weight:600;
    padding:10px 20px;
    border-radius:8px;
    color:#000;
  }
  .btn-warning:hover { background:#f59e0b; color:#000; }

  .info-box {
    background:#1a1a1a;
    padding:20px;
    border-radius:15px;
    margin-top:20px;
    transition:transform 0.4s ease, box-shadow 0.4s ease;
  }
  .info-box:hover {
    transform:translateY(-5px);
    box-shadow:0 0 20px rgba(251, 191, 36, 0.2);
  }

  .info-box i { color:#fbbf24; margin-right:8px; }
  .info-box p { margin-bottom: 4px; font-size: 15px; line-height: 1.4; }

  .sosmed {
    display:flex; align-items:center; justify-content:center;
    width:40px; height:40px; border-radius:50%;
    color:#fff; font-size:18px; transition:0.3s; text-decoration:none;
  }
  .sosmed:hover { transform:scale(1.1); opacity:0.9; }
  .sosmed.wa { background-color:#25D366; }
  .sosmed.ig {
    background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
  }
  .sosmed.tiktok {
    background: linear-gradient(135deg, #000 50%, #ff0050 75%, #00f2ea 100%);
  }
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="kontak container">
  <h2 class="section-title" data-aos="fade-up"><span>Kontak</span> Kami</h2>
  <p data-aos="fade-up" data-aos-delay="150">Hubungi kami untuk pemesanan atau informasi lebih lanjut.</p>
  <div class="row g-4">

    <!-- Maps dan Info -->
    <div class="col-md-6" data-aos="fade-right" data-aos-delay="300">
      <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3966.2771839272245!2d106.69842507475062!3d-6.227138893760954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTMnMzcuNyJTIDEwNsKwNDInMDMuNiJF!5e0!3m2!1sen!2sid!4v1759155163104!5m2!1sen!2sid"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>

      <div class="info-box mt-4" data-aos="zoom-in" data-aos-delay="500">
        <h5 class="text-warning">Informasi Kontak</h5>
        <p><i class="bi bi-geo-alt"></i> Komplek Griya Kencana 1, Pedurenan, Karang Tengah, Tangerang</p>
        <p><i class="bi bi-telephone"></i> 085784740736</p>
        <p><i class="bi bi-envelope"></i> support@ciraku.com</p>
        <p><i class="bi bi-clock"></i> Buka: 08.00 - 21.00 WIB</p>
        <div class="mt-3 d-flex gap-2">
          <a href="https://wa.me/085784740736" class="sosmed wa" data-aos="fade-up" data-aos-delay="700"><i class="bi bi-whatsapp"></i></a>
          <a href="https://instagram.com/ghacode.id" class="sosmed ig" data-aos="fade-up" data-aos-delay="800"><i class="bi bi-instagram"></i></a>
          <a href="https://tiktok.com/@ghacode.id" class="sosmed tiktok" data-aos="fade-up" data-aos-delay="900"><i class="bi bi-tiktok"></i></a>        
        </div>
      </div>
    </div>

    <!-- Form -->
    <div class="col-md-6" data-aos="fade-left" data-aos-delay="300">
      <div class="form-box" data-aos="flip-up" data-aos-delay="500">
        <form class="needs-validation" method="POST" novalidate>
          <input type="hidden" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
          <input type="hidden" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
          <input type="hidden" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

          <div class="mb-3">
            <select name="subjek" class="form-select" required>
              <option value="" disabled selected>Pilih Subjek</option>
              <option value="pemesanan">Pemesanan</option>
              <option value="produk">Tanya Produk</option>
              <option value="saran">Saran / Kritik</option>
              <option value="kerjasama">Kerjasama</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>

          <div class="mb-3">
            <textarea name="pesan" class="form-control" rows="4" placeholder="Pesan" required></textarea>
          </div>

          <button type="submit" class="btn btn-warning w-100" data-aos="zoom-in" data-aos-delay="700">Kirim</button>
        </form>
      </div>
    </div>

  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
  duration: 1000,
  once: true
});

(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();

// Notifikasi SweetAlert dari PHP
<?php if ($swal): ?>
Swal.fire({
  icon: '<?= $swal['icon'] ?>',
  title: '<?= $swal['title'] ?>',
  text: '<?= $swal['text'] ?>',
  confirmButtonColor: '#fbbf24',
  background: '#1a1a1a',
  color: '#fff'
}).then(() => {
  <?php if ($swal['icon'] === 'success'): ?>
    window.location = 'kontak.php';
  <?php elseif ($swal['icon'] === 'warning'): ?>
    window.location = '../user/register.php';
  <?php endif; ?>
});
<?php endif; ?>
</script>
</body>
</html>
