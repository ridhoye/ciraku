<?php
session_start();
include "../config/db.php";

// Cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}

// Hapus user
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM users WHERE id = $id");
  header("Location: data_users.php");
  exit;
}

// Ubah role
if (isset($_GET['role']) && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $role = $_GET['role'] === 'admin' ? 'user' : 'admin';
  mysqli_query($conn, "UPDATE users SET role='$role' WHERE id=$id");
  header("Location: data_users.php");
  exit;
}

// Pagination setup
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fitur pencarian
$search = "";
$queryCondition = "WHERE role = 'user'";
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $queryCondition .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}

// Hitung total data
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users $queryCondition");
$totalData = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data user
$users = mysqli_query($conn, "SELECT * FROM users $queryCondition ORDER BY id DESC LIMIT $limit OFFSET $offset");

$pageTitle = "Data Users - Ciraku";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Users - Ciraku</title>
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
    .search-box {
      margin-bottom: 15px;
    }
    .search-box input {
      background: #1e1e1e;
      color: #fff;
      border: 1px solid #444;
    }
    .search-box input:focus {
      background: #262626;
      color: #fff;
    }
    .search-box button {
      background: #fbbf24;
      border: none;
      color: #000;
      font-weight: bold;
    }
    .pagination .page-link {
      background: #1a1a1a;
      color: #fff;
      border: 1px solid #444;
    }
    .pagination .page-link:hover {
      background: #fbbf24;
      color: #000;
    }
    .pagination .active .page-link {
      background: #fbbf24;
      color: #000;
      border: none;
    }
  </style>
</head>
<body>
<?php include "includes/sidebar.php"; ?>

  <!-- Konten -->
  <div class="content">
    <h2 class="mb-4">Data Users</h2>

    <div class="card p-4">
      <div class="search-box">
        <form method="GET" action="">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari username atau email..." value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="btn">Cari</button>
          </div>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Tanggal Daftar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = $offset + 1;
              if (mysqli_num_rows($users) > 0) {
                while ($u = mysqli_fetch_assoc($users)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td>{$u['username']}</td>
                          <td>{$u['email']}</td>
                          <td><span class='badge bg-".($u['role']=='admin'?'warning text-dark':'secondary')."'>{$u['role']}</span></td>
                          <td>{$u['created_at']}</td>
                          <td>
                            <a href='?role={$u['role']}&id={$u['id']}' class='btn btn-sm btn-outline-warning btn-action' title='Ubah Role'><i class='bi bi-arrow-repeat'></i></a>
                            <a href='?hapus={$u['id']}' onclick='return confirm(\"Yakin ingin menghapus user ini?\")' class='btn btn-sm btn-outline-danger btn-action' title='Hapus User'><i class='bi bi-trash'></i></a>
                          </td>
                        </tr>";
                  $no++;
                }
              } else {
                echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada user ditemukan.</td></tr>";
                echo "<script>
                  document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'warning',
                      title: 'User tidak ditemukan',
                      text: 'Pastikan nama atau email yang dicari sudah benar.',
                      confirmButtonColor: '#fbbf24',
                      background: '#1a1a1a',
                      color: '#fff'
                    });
                  });
                </script>";
              }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <nav>
        <ul class="pagination justify-content-center mt-3">
          <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Sebelumnya</a></li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Berikutnya</a></li>
          <?php endif; ?>
        </ul>
      </nav>

    </div>
  </div>

</body>
</html>
