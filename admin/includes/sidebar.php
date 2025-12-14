<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h4 class="text-warning mb-0">CIRAKU Admin</h4>
    <div class="hamburger" id="hamburgerBtn">
      <i class="bi bi-list"></i>
    </div>
  </div>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../panel_admin.php' : 'panel_admin.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'panel_admin.php' ? 'active' : '' ?>">
    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../data_users.php' : 'data_users.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'data_users.php' ? 'active' : '' ?>">
    <i class="bi bi-people"></i> <span>Data User</span>
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../kontak_pesan.php' : 'kontak_pesan.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'kontak_pesan.php' ? 'active' : '' ?>">
    <i class="bi bi-envelope"></i> <span>Pesan Masuk</span>
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? 'produk.php' : 'produks/produk.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'active' : '' ?>">
    <i class="bi bi-box"></i> <span>Produk</span>
  </a>

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../pesanan.php' : 'pesanan.php' ?>" 
     class="<?= basename($_SERVER['PHP_SELF']) == 'pesanan.php' ? 'active' : '' ?>">
    <i class="bi bi-bag"></i> <span>Pesanan</span>
  </a>

  <hr class="border-secondary">

  <a href="<?= (basename(dirname($_SERVER['PHP_SELF'])) == 'produks') ? '../../user/logout.php' : '../user/logout.php' ?>">
    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
  </a>
</div>

<!-- Styling Sidebar -->
<style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background-color: #1e1e2f;
    padding: 20px 15px;
    transition: width 0.3s ease;
    overflow: hidden;
    z-index: 1000;
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
  }

  .sidebar h4 {
    color: #ffc107;
    margin: 0;
    font-size: 1.2rem;
  }

  .hamburger {
    font-size: 22px;
    color: #ffc107;
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .hamburger:hover {
    transform: scale(1.1);
  }

  .sidebar a {
    display: flex;
    align-items: center;
    color: #ccc;
    text-decoration: none;
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    transition: background 0.3s, color 0.3s;
  }

  .sidebar a i {
    font-size: 18px;
    min-width: 35px;
    text-align: center;
  }

  .sidebar a:hover {
    background-color: #34344a;
    color: #fff;
  }

  .sidebar a.active {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
  }

  /* Mode tertutup */
  .sidebar.closed {
    width: 80px;
  }

  .sidebar.closed h4 {
    display: none;
  }

  .sidebar.closed a span {
    display: none;
  }

  .sidebar.closed .hamburger {
    margin: 0 auto;
  }

  /* Konten utama */
  .content {
    margin-left: 260px;
    padding: 20px;
    transition: margin-left 0.3s ease;
  }

  .sidebar.closed ~ .content {
    margin-left: 90px;
  }
</style>

<!-- JavaScript Sidebar -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const hamburgerBtn = document.getElementById("hamburgerBtn");

    // ✅ Baca status sidebar dari localStorage
    if (localStorage.getItem("sidebarClosed") === "true") {
      sidebar.classList.add("closed");
    }

    hamburgerBtn.addEventListener("click", function() {
      sidebar.classList.toggle("closed");

      // ✅ Simpan status ke localStorage (biar gak balik kebuka pas pindah halaman)
      localStorage.setItem("sidebarClosed", sidebar.classList.contains("closed"));
    });
  });
</script>
