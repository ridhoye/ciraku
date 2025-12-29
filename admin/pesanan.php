<?php
session_start();
include "../config/db.php";

// 🔒 cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}

// 🟡 update status pesanan (STATUS ASLI SAJA)
if (isset($_POST['update_status'])) {
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];

  mysqli_query($conn, "UPDATE orders SET status='$status' WHERE order_id='$order_id'");
  header("Location: pesanan.php");
  exit;
}

// 🔴 hapus pesanan
if (isset($_GET['hapus'])) {
  $order_id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM orders WHERE order_id='$order_id'");
  mysqli_query($conn, "DELETE FROM order_items WHERE order_id='$order_id'");
  header("Location: pesanan.php");
  exit;
}

// ✅ ambil semua pesanan
$sql = "SELECT 
          o.order_id,
          o.user_id,
          o.total,
          o.status,
          o.payment_method,
          o.created_at,
          u.username,
          u.address,
          u.postal_code,
          oi.nama_produk,
          oi.jumlah,
          oi.harga,
          oi.total AS item_total
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        JOIN order_items oi ON o.order_id = oi.order_id
        ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan - CIRAKU Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background:#0f0f0f; color:#fff; font-family:Poppins,sans-serif; }
    .content { margin-left:260px; padding:30px; }
    .card { background:#1e1e1e; border-radius:15px; }
    .table thead { background:#fbbf24; color:#000; }
    .badge { font-size:.8rem; }
  </style>
</head>
<body>

<?php include "includes/sidebar.php"; ?>

<div class="content">
  <h2 class="mb-4">Daftar Pesanan</h2>

  <div class="card p-4">
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Alamat</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total Item</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <?php
              $method = strtolower($row['payment_method'] ?? 'cod');
              $status = strtolower($row['status']);

              if (str_contains($status, $method)) {
                $displayStatus = $status;
              } else {
                $displayStatus = $method . '_' . $status;
              }
            ?>

            <tr>
              <td><?= $row['order_id'] ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['address']) ?></td>
              <td><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td><?= $row['jumlah'] ?></td>
              <td>Rp<?= number_format($row['harga'],0,',','.') ?></td>
              <td>Rp<?= number_format($row['item_total'],0,',','.') ?></td>

              <td>
                <span class="badge bg-secondary">
                  <?= strtoupper($method) ?>
                </span>
              </td>

              <td>
                <span class="badge bg-warning text-dark">
                  <?= strtoupper($displayStatus) ?>
                </span>
              </td>

              <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>

              <td>
                <form method="POST" class="d-flex gap-1 mb-1">
                  <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                  <select name="status" class="form-select form-select-sm bg-dark text-white">
                    <option value="pending" <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                    <option value="diproses" <?= $row['status']=='diproses'?'selected':'' ?>>Diproses</option>
                    <option value="dikirim" <?= $row['status']=='dikirim'?'selected':'' ?>>Dikirim</option>
                    <option value="selesai" <?= $row['status']=='selesai'?'selected':'' ?>>Selesai</option>
                  </select>
                  <button name="update_status" class="btn btn-sm btn-warning">✔</button>
                </form>

                <a href="?hapus=<?= $row['order_id'] ?>" 
                   onclick="return confirm('Hapus pesanan ini?')" 
                   class="btn btn-sm btn-danger w-100">Hapus</a>
              </td>
            </tr>

          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="11" class="text-center text-secondary">Belum ada pesanan.</td>
          </tr>
        <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
