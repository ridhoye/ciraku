<?php
session_start();
include "../config/db.php";

// Cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}

// Ambil data jumlah user per bulan (group by YYYY-MM supaya aman dengan ONLY_FULL_GROUP_BY)
$user_data_sql = "
  SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS total
  FROM users
  GROUP BY DATE_FORMAT(created_at, '%Y-%m')
  ORDER BY DATE_FORMAT(created_at, '%Y-%m') ASC
";
$user_data = mysqli_query($conn, $user_data_sql);

// Siapkan label dan total untuk Chart.js
$labels = [];
$totals = [];
if ($user_data && mysqli_num_rows($user_data) > 0) {
  while ($row = mysqli_fetch_assoc($user_data)) {
    // $row['ym'] seperti "2025-10"
    // Kita format ke bentuk "October 2025" (bahasa Inggris). Jika mau Indonesia, bisa mapping bulan.
    $labels[] = date('F Y', strtotime($row['ym'] . '-01'));
    $totals[] = (int)$row['total'];
  }
} else {
  // jika tidak ada data, beri placeholder supaya Chart.js tidak error
  $labels = ['No Data'];
  $totals = [0];
}

$pageTitle = "Data Users - Ciraku";
include "includes/header.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    }
    .card:hover { transform: scale(1.03); }
    .card h4 { color: #fbbf24; }
    .table { color: #fff; }
    .table thead { background: #fbbf24; color: #000; }
    #chart-container {
      background: #1e1e1e;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 30px;
    }
    canvas { width: 100% !important; height: 200px !important; }
  </style>
</head>
<body>
<?php include "includes/sidebar.php"; ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-warning mb-4">CIRAKU Admin</h4>
    <a href="panel_admin.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="data_users.php"><i class="bi bi-people"></i> Data User</a>
    <a href="kontak_pesan.php"><i class="bi bi-envelope"></i> Pesan Masuk</a>
    <a href="produks/produk.php"><i class="bi bi-box"></i> Produk</a>
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
              $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='user'");
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

    <!-- Grafik User per bulan -->
    <div id="chart-container">
      <h4 class="mb-3 text-center text-warning">Grafik Pendaftaran User per Bulan</h4>
      <canvas id="userChart"></canvas>
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
                        <td><span class='badge bg-secondary'>{$u['role']}</span></td>
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

  <!-- Chart.js config -->
  <script>
    const ctx = document.getElementById('userChart').getContext('2d');
    const labels = <?php echo json_encode($labels); ?>;
    const totals = <?php echo json_encode($totals); ?>;

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah User',
          data: totals,
          borderColor: '#fbbf24',
          backgroundColor: 'rgba(251,191,36,0.2)',
          tension: 0.3,
          fill: true,
          borderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        plugins: {
          legend: { labels: { color: '#fff' } }
        },
        scales: {
          x: { ticks: { color: '#fff' }, grid: { color: '#333' } },
          y: { ticks: { color: '#fff' }, grid: { color: '#333' }, beginAtZero: true }
        },
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>

</body>
</html>
