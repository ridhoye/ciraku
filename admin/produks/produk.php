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

// Judul halaman untuk <title>
$pageTitle = "Manajemen Produk - Ciraku";
?>
<body>
  
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $pageTitle ?? 'Admin Panel - Ciraku' ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #0f0f0f;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
    }
    .card {
      background: #1e1e1e;
      border: none;
      border-radius: 15px;
    }
    .table {
      color: #fff;
    }
    .table thead {
      background: #fbbf24;
      color: #000;
    }
    .btn-action {
      border-radius: 8px;
      padding: 4px 10px;
    }
  </style>
</head>

<?php include "../includes/sidebar.php"; ?>

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

          <?php 
            $no = 1; 
            $modal_list = "";

            while ($p = mysqli_fetch_assoc($produk)) { 
              $modal_id = "editModal" . $p['id'];
              echo "
                <tr>
                  <td>{$no}</td>
                  <td><img src='../../assets/images/{$p['gambar']}' alt='{$p['nama_produk']}' width='70' class='rounded'></td>
                  <td>{$p['nama_produk']}</td>
                  <td>{$p['deskripsi']}</td>
                  <td>Rp " . number_format($p['harga'], 0, ',', '.') . "</td>
                  <td>
                    <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#{$modal_id}'>Edit</button>
                    <button class='btn btn-sm btn-danger' onclick=\"hapusProduk({$p['id']})\">Hapus</button>
                  </td>
                </tr>
              ";

              $modal_list .= "
                <div class='modal fade' id='{$modal_id}' tabindex='-1'>
                  <div class='modal-dialog'>
                    <div class='modal-content bg-dark text-white'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Edit Produk</h5>
                        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                      </div>
                      <form method='POST' enctype='multipart/form-data'>
                        <div class='modal-body'>
                          <input type='hidden' name='id' value='{$p['id']}'>
                          <div class='mb-3'>
                            <label>Nama Produk</label>
                            <input type='text' name='nama' class='form-control' value='{$p['nama_produk']}' required>
                          </div>
                          <div class='mb-3'>
                            <label>Harga</label>
                            <input type='number' name='harga' class='form-control' value='{$p['harga']}' required>
                          </div>
                          <div class='mb-3'>
                            <label>Deskripsi</label>
                            <textarea name='deskripsi' class='form-control' rows='3'>{$p['deskripsi']}</textarea>
                          </div>
                          <div class='mb-3'>
                            <label>Gambar (kosongkan jika tidak diganti)</label>
                            <input type='file' name='gambar' class='form-control'>
                          </div>
                        </div>
                        <div class='modal-footer'>
                          <button type='submit' name='edit' class='btn btn-warning'>Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>";
              $no++;
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Tempatkan semua modal di luar tabel -->
  <?= $modal_list ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // SweetAlert konfirmasi hapus produk
  function hapusProduk(id) {
    Swal.fire({
      title: "Hapus produk ini?",
      text: "Data tidak bisa dikembalikan setelah dihapus!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "?hapus=" + id;
      }
    });
  }
</script>

</body>
</html>
