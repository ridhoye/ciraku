<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../config/db.php"; // sesuaikan path-nya

$current_page = basename($_SERVER['PHP_SELF']);

$user = null;
if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT full_name, profile_pic FROM users WHERE id = '$user_id' LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);
}
?>

<!-- Navbar + CSS -->
<style>
 /* Navbar Global Style */
.navbar, 
.navbar a, 
.navbar .nav-link, 
.navbar .navbar-brand {
  font-family: 'Poppins', sans-serif !important;
  font-size: 16px !important;
  font-weight: 500 !important;
  color: #fff !important;
  text-decoration: none !important;
  position: relative;
}

/* Logo */
.navbar .navbar-brand {
  font-weight: 700 !important;
  font-size: 22px !important;
  color: #fff !important;
}
.navbar .navbar-brand span {
  color: #fbbf24 !important;
}

/* Efek underline animasi */
.navbar .nav-link::after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: 0;
  transform: translateX(-50%) scaleX(0);
  transform-origin: center;
  width: 100%;
  height: 3px;
  background-color: #fbbf24;
  transition: transform 0.3s ease;
  border-radius: 2px;
}

/* Hover - garis muncul */
.navbar .nav-link:hover::after {
  transform: translateX(-50%) scaleX(1);
}

/* Link aktif - underline selalu muncul */
.navbar .nav-link.active::after {
  transform: translateX(-50%) scaleX(1);
}

/* Warna aktif */
.navbar .nav-link.active {
  color: #fbbf24 !important;
}

/* Tambahan khusus buat ikon akun & keranjang */
.navbar .icon-nav {
  font-size: 26px !important; /* atur gede ikon (bisa 30px kalau mau lebih besar) */
  color: #fff !important;
  transition: 0.3s;
}

.navbar .icon-nav:hover {
  color: #fbbf24 !important; /* efek hover biar keren */
}

.icon-nav img {
  transition: 0.3s;
}
.icon-nav img:hover {
  transform: scale(1.1);
  box-shadow: 0 0 10px #fbbf24;
}

/* Badge notif keranjang - kecil tapi tetap nempel rapi */
.navbar .badge {
  font-size: 10px !important;
  padding: 2px 4px !important;
  min-width: 16px;
  height: 16px;
  line-height: 12px;
  border-radius: 50%;
  background-color: #fbbf24 !important;
  color: #000 !important;
  position: absolute;
  top: 0;
  right: 0;
  transform: translate(35%, -35%);
  box-shadow: 0 0 3px rgba(0,0,0,0.3);
}

</style>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-black px-4">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="home.php">cira<span>ku</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'home.php' ? 'active' : '' ?>" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'tentang.php' ? 'active' : '' ?>" href="tentang.php">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'menu.php' ? 'active' : '' ?>" href="menu.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'kontak.php' ? 'active' : '' ?>" href="kontak.php">Kontak</a>
        </li>
      </ul>
      
<div class="d-flex gap-3 align-items-center">
  <!-- user -->
<!-- Ikon / Foto Profil -->
<?php if ($user): ?>
  <a href="../user/profile.php" class="icon-nav" title="<?= htmlspecialchars($user['full_name']) ?>">
    <?php if (!empty($user['profile_pic'])): ?>
      <img src="../uploads/<?= htmlspecialchars($user['profile_pic']) ?>" 
           alt="Foto Profil"
           style="width:32px; height:32px; border-radius:50%; object-fit:cover; border:2px solid #fbbf24;">
    <?php else: ?>
      <i class="bi bi-person-check" style="color:#fbbf24;"></i>
    <?php endif; ?>
  </a>
<?php else: ?>
  <a href="../user/login.php" class="icon-nav" title="Login">
    <i class="bi bi-person-circle"></i>
  </a>
<?php endif; ?>


<!-- Keranjang -->
<a href="shop.php" class="icon-nav position-relative" title="Keranjang">
  <i class="bi bi-cart3"></i>

  <?php 
  // Hitung jumlah item di keranjang (kalau session keranjang ada)
  $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

  // Tampilkan badge cuma kalau jumlah > 0
  if ($cart_count > 0): ?>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
      <?= $cart_count ?>
    </span>
  <?php endif; ?>
</a>
</div>

    </div>
  </div>
</nav>

</body>
</html>