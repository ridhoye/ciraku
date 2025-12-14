<?php
session_start();
include "../config/db.php";

// 🔒 cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}

// 🟡 update status pesanan
if (isset($_POST['update_status'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];
  mysqli_query($conn, "UPDATE pesanan SET status='$status' WHERE id=$id");
  header("Location: pesanan.php");
  exit;
}

// 🔴 hapus pesanan
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM pesanan WHERE id=$id");
  header("Location: pesanan.php");
  exit;
}

// ✅ ambil semua pesanan + join ke tabel users
$sql = "SELECT p.*, u.username, u.address, u.postal_code 
        FROM pesanan p
        LEFT JOIN users u ON p.user_id = u.id
        ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $sql);

$pageTitle = "Data Users - Ciraku";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan - CIRAKU Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #0f0f0f; color: #fff; font-family: 'Poppins', sans-serif; }
    .content { margin-left: 260px; padding: 30px; }
    .card { background: #1e1e1e; border: none; border-radius: 15px; color: #fff; }
    .table { color: #fff; }
    .table thead { background-color: #fbbf24; color: #000; }
    select { border-radius: 6px; padding: 3px 8px; }
  </style>
</head>
<body>

<?php include "includes/sidebar.php"; ?>
  <!-- Konten -->
  <div class="content">
    <h2 class="mb-4">Daftar Pesanan</h2>

    <div class="card p-4">
      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Alamat</th>
              <th>Kode Pos</th>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['username'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($row['address'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($row['postal_code'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                  <td><?= $row['jumlah'] ?></td>
                  <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                  <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                  <td><?= $row['tanggal'] ?></td>
                  <td>
                    <form method="POST" class="d-flex align-items-center gap-2">
                      <input type="hidden" name="id" value="<?= $row['id'] ?>">
                      <select name="status" class="form-select form-select-sm bg-dark text-white border-warning" style="width:120px;">
                        <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Diproses" <?= $row['status']=='Diproses'?'selected':'' ?>>Diproses</option>
                        <option value="Dikirim" <?= $row['status']=='Dikirim'?'selected':'' ?>>Dikirim</option>
                        <option value="Selesai" <?= $row['status']=='Selesai'?'selected':'' ?>>Selesai</option>
                      </select>
                      <button type="submit" name="update_status" class="btn btn-sm btn-warning">Update</button>
                    </form>
                  </td>
                  <td>
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus pesanan ini?')" class="btn btn-sm btn-danger">Hapus</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="11" class="text-center text-secondary">Belum ada pesanan masuk.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</body>
</html>
