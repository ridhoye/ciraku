<!-- Tombol Hamburger -->
<div class="hamburger" id="hamburgerBtn">
  <i class="bi bi-list"></i>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h4 class="text-warning mb-4">CIRAKU Admin</h4>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../panel_admin.php' : 'panel_admin.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'panel_admin.php' ? 'active' : '' ?>">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../data_users.php' : 'data_users.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'data_users.php' ? 'active' : '' ?>">
    <i class="bi bi-people"></i> Data User
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../kontak_pesan.php' : 'kontak_pesan.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'kontak_pesan.php' ? 'active' : '' ?>">
    <i class="bi bi-envelope"></i> Pesan Masuk
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? 'produk.php' : 'produks/produk.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'active' : '' ?>">
    <i class="bi bi-box"></i> Produk
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../pesanan.php' : 'pesanan.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'pesanan.php' ? 'active' : '' ?>">
    <i class="bi bi-bag"></i> Pesanan
  </a>

  <hr class="border-secondary">

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../../user/logout.php' : '../user/logout.php' ?>">
    <i class="bi bi-box-arrow-right"></i> Logout
  </a>
</div>

<!-- Styling Sidebar -->
<style>
  /* Sidebar */
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background-color: #1e1e2f;
    padding: 20px;
    transition: left 0.3s ease;
    overflow-y: auto;
    z-index: 1000;
  }

  .sidebar a {
    display: block;
    color: #ccc;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 8px;
    transition: 0.3s;
  }

  .sidebar a:hover {
    background-color: #ebebf3ff;
    color: #fff;
  }

  .sidebar a.active {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
  }

  .sidebar h4 {
    color: #ffc107;
    text-align: center;
  }

  /* Hamburger Button */
  .hamburger {
    position: fixed;
    top: 15px;
    left: 15px;
    background-color: #f6f6ffff;
    color: white;
    border-radius: 6px;
    padding: 8px 10px;
    cursor: pointer;
    font-size: 22px;
    z-index: 1100;
    display: none;
  }

  .hamburger:hover {
    background-color: #f4f4f4ff;
  }

  /* Responsif */
  @media (max-width: 768px) {
    .sidebar {
      left: -260px;
    }

    .sidebar.active {
      left: 0;
    }

    .hamburger {
      display: block;
    }
  }

  /* Tambahan spacing untuk konten */
  .content {
    margin-left: 270px;
    padding: 20px;
    transition: margin-left 0.3s ease;
  }

  @media (max-width: 768px) {
    .content {
      margin-left: 0;
    }

    .sidebar.active ~ .content {
      margin-left: 250px;
    }
  }
</style>

<!-- JavaScript Sidebar -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');

    hamburgerBtn.addEventListener('click', function() {
      sidebar.classList.toggle('active');
    });
  });
</script>
