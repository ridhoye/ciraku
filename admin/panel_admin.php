<?php
session_start();
include "../config/db.php";

// Cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
       color: #fff; /* Tambahkan ini untuk membuat semua teks dalam card jadi putih */
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card h4 {
      color: #fbbf24;
    }
    .table {
      color: #fff;
    }
    .table thead {
      background: #fbbf24;
      color: #000;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-warning mb-4">CIRAKU Admin</h4>
    <a href="panel_admin.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="users.php"><i class="bi bi-people"></i> Data User</a>
    <a href="kontak_pesan.php"><i class="bi bi-envelope"></i> Pesan Masuk</a>
    <a href="produk.php"><i class="bi bi-box"></i> Produk</a>
    <a href="pesanan.php"><i class="bi bi-bag"></i> Pesanan</a>
    <hr class="border-secondary">
    <a href="../user/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Konten -->
  <div class="content">
    <h2 class="mb-4">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <h4><i class="bi bi-people"></i></h4>
          <p>Total User</p>
          <h5>
            <?php
              $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
              $data = mysqli_fetch_assoc($result);
              echo $data['total'];
            ?>
          </h5>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <h4><i class="bi bi-envelope"></i></h4>
          <p>Pesan Masuk</p>
          <h5>
            <?php
              $msg = mysqli_query($conn, "SHOW TABLES LIKE 'kontak_pesan'");
              if (mysqli_num_rows($msg)) {
                $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kontak_pesan"));
                echo $count['total'];
              } else {
                echo "0";
              }
            ?>
          </h5>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <h4><i class="bi bi-bag"></i></h4>
          <p>Total Pesanan</p>
          <h5>
            <?php
              $order = mysqli_query($conn, "SHOW TABLES LIKE 'pesanan'");
              if (mysqli_num_rows($order)) {
                $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan"));
                echo $count['total'];
              } else {
                echo "0";
              }
            ?>
          </h5>
        </div>
      </div>
    </div>

    <!-- Data User Terbaru -->
    <div class="card p-4">
      <h4 class="mb-3">User Terbaru</h4>
      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Tanggal Daftar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $users = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user' ORDER BY id DESC LIMIT 5");
              $no = 1;
              while ($u = mysqli_fetch_assoc($users)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$u['username']}</td>
                        <td>{$u['email']}</td>
                        <td><span class='badge bg-".($u['role']=='admin'?'warning text-dark':'secondary')."'>{$u['role']}</span></td>
                        <td>{$u['created_at']}</td>
                      </tr>";
                $no++;
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
