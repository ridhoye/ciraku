<?php
$current_page = basename($_SERVER['PHP_SELF']);
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

</style>


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
      <div class="d-flex gap-3 text-white">
        <span>👤</span>
        <span>🔍</span>
        <span>🛒</span>
      </div>
    </div>
  </div>
</nav>
