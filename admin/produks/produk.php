<?php
session_start();
include "../../config/db.php";

// Cek login dan role
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../../user/login.php");
  exit;
}

// === TAMBAH PRODUK ===
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $harga = $_POST['harga'];

  $gambar = null;
  if (!empty($_FILES['gambar']['name'])) {
    $target_dir = "../../assets/images/";
    $gambar = time() . "_" . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $gambar);
  }

  $sql = "INSERT INTO produk (nama_produk, deskripsi, harga, gambar)
          VALUES ('$nama', '$deskripsi', '$harga', '$gambar')";
  mysqli_query($conn, $sql);
  header("Location: produk.php");
  exit;
}

// === EDIT PRODUK ===
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $harga = $_POST['harga'];

  $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM produk WHERE id=$id"));
  $gambar = $old['gambar'];

  if (!empty($_FILES['gambar']['name'])) {
    $target_dir = "../../assets/images/";
    $gambar = time() . "_" . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $gambar);
  }

  $sql = "UPDATE produk SET nama_produk='$nama', deskripsi='$deskripsi', harga='$harga', gambar='$gambar' WHERE id=$id";
  mysqli_query($conn, $sql);
  header("Location: produk.php");
  exit;
}

// === HAPUS PRODUK ===
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM produk WHERE id=$id");
  header("Location: produk.php");
  exit;
}

// Ambil semua produk
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Produk - CIRAKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #0f0f0f;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .sidebar {
      width: 240px;
      height: 100vh;
      background: #1a1a1a;
      position: fixed;
      left: 0;
      top: 0;
      padding: 20px;
    }
    .sidebar a {
      display: block;
      color: #bbb;
      text-decoration: none;
      padding: 10px 15px;
      margin: 5px 0;
      border-radius: 8px;
      transition: 0.3s;
    }
    .sidebar a.active, .sidebar a:hover {
      background-color: #fbbf24;
      color: #000;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
    }
    .card {
      background: #1e1e1e;
      border: none;
      border-radius: 15px;
      transition: transform 0.2s ease-in-out;
      color: #fff;
      font-size: 14px;
    }
    .card:hover { transform: scale(1.02); }
    .card h4 { color: #fbbf24; font-weight: 600; }
    .btn-warning { color: #000; font-weight: 600; }
    table { font-size: 14px; }
    table img { width: 70px; border-radius: 8px; }
    h2 { font-weight: 600; font-size: 22px; }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-warning mb-4">CIRAKU Admin</h4>
    <a href="../panel_admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="../data_users.php"><i class="bi bi-people"></i> Data User</a>
    <a href="../kontak_pesan.php"><i class="bi bi-envelope"></i> Pesan Masuk</a>
    <a href="produk.php" class="active"><i class="bi bi-box"></i> Produk</a>
    <a href="../pesanan.php"><i class="bi bi-bag"></i> Pesanan</a>
    <hr class="border-secondary">
    <a href="../../user/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Konten -->
  <div class="content">
    <h2 class="mb-4">Manajemen Produk</h2>

    <!-- Tambah Produk -->
    <div class="card p-4 mb-4">
      <h4>Tambah Produk</h4>
      <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required>
          </div>
          <div class="col-md-4">
            <input type="number" name="harga" class="form-control" placeholder="Harga (Rp)" required>
          </div>
          <div class="col-md-4">
            <input type="file" name="gambar" class="form-control">
          </div>
          <div class="col-12">
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi produk..." required></textarea>
          </div>
          <div class="col-12 text-end">
            <button type="submit" name="tambah" class="btn btn-warning px-4">Tambah Produk</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Daftar Produk -->
    <div class="card p-4">
      <h4>Daftar Produk</h4>
      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while ($p = mysqli_fetch_assoc($produk)) { ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><img src="../../assets/images/<?= $p['gambar']; ?>" alt="<?= $p['nama_produk']; ?>"></td>
                <td><?= $p['nama_produk']; ?></td>
                <td><?= $p['deskripsi']; ?></td>
                <td>Rp <?= number_format($p['harga'], 0, ',', '.'); ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id']; ?>">Edit</button>
                  <a href="?hapus=<?= $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                </td>
              </tr>

              <!-- Modal Edit -->
              <div class="modal fade" id="editModal<?= $p['id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Produk</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $p['id']; ?>">
                        <div class="mb-3">
                          <label>Nama Produk</label>
                          <input type="text" name="nama" class="form-control" value="<?= $p['nama_produk']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label>Harga</label>
                          <input type="number" name="harga" class="form-control" value="<?= $p['harga']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label>Deskripsi</label>
                          <textarea name="deskripsi" class="form-control" rows="3"><?= $p['deskripsi']; ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label>Gambar (kosongkan jika tidak diganti)</label>
                          <input type="file" name="gambar" class="form-control">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="edit" class="btn btn-warning">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
