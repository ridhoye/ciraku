<?php
session_start();
include "../config/db.php";

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesan Masuk - Admin Ciraku</title>
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
      padding: 20px;
    }
    table {
      color: #fff;
    }
    table thead {
      background-color: #fbbf24;
      color: #000;
    }
    .btn-view {
      background-color: #fbbf24;
      border: none;
      color: #000;
      font-weight: 600;
      padding: 5px 10px;
      border-radius: 8px;
    }
    .btn-view:hover {
      background-color: #f59e0b;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-warning mb-4">CIRAKU Admin</h4>
    <a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="users.php"><i class="bi bi-people"></i> Data User</a>
    <a href="kontak_pesan.php" class="active"><i class="bi bi-envelope"></i> Pesan Masuk</a>
    <hr class="border-secondary">
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2 class="mb-4"><i class="bi bi-envelope"></i> Pesan Masuk</h2>

    <div class="card">
      <?php
        $check = mysqli_query($conn, "SHOW TABLES LIKE 'kontak_pesan'");
        if (!mysqli_num_rows($check)) {
          echo "<p class='text-warning'>Tabel <strong>kontak_pesan</strong> belum dibuat.</p>";
        } else {
          $result = mysqli_query($conn, "SELECT * FROM kontak_pesan ORDER BY created_at DESC");
          if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-dark table-striped align-middle'>";
            echo "<thead><tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Subjek</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                  </tr></thead><tbody>";
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>{$no}</td>
                      <td>{$row['full_name']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['phone']}</td>
                      <td>{$row['subject']}</td>
                      <td>{$row['created_at']}</td>
                      <td><a href='view_pesan.php?id={$row['id']}' class='btn-view btn-sm'>Lihat</a></td>
                    </tr>";
              $no++;
            }
            echo "</tbody></table></div>";
          } else {
            echo "<p class='text-secondary text-center'>Belum ada pesan masuk.</p>";
          }
        }
      ?>
    </div>
  </div>

</body>
</html>
