<?php
session_start();
include '../config/db.php'; // pastikan path benar

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Jika tidak ditemukan user (harusnya tidak terjadi)
if (!$user) {
    echo "User tidak ditemukan!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya - CIRAKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #0a0a0a;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #000;
      border-bottom: 1px solid #222;
      padding: 10px 20px;
    }
    .navbar img {
      height: 32px;
    }
    .btn-logout {
      background-color: #ffae00;
      color: #000;
      border: none;
      font-weight: bold;
    }
    .btn-logout:hover {
      background-color: #d49500;
    }
    .btn-home {
      border: 1px solid #ffae00;
      color: #ffae00;
      font-weight: 500;
    }
    .btn-home:hover {
      background-color: #ffae00;
      color: #000;
    }
    .profile-container {
      text-align: center;
      padding: 40px 20px 20px;
    }
    .profile-photo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 3px solid #ffae00;
      box-shadow: 0 0 25px #ffae00;
      object-fit: cover;
      margin-bottom: 15px;
    }
    .profile-name {
      font-size: 1.4rem;
      color: #ffae00;
      font-weight: 600;
    }
    .profile-username {
      color: #aaa;
      font-size: 0.95rem;
    }
    .btn-edit {
      background: #ffae00;
      color: #000;
      font-weight: 600;
      border: none;
      margin-top: 10px;
    }
    .btn-edit:hover {
      background: #d49500;
    }
    .card-custom {
      background-color: #111;
      border: 1px solid #2b2b2b;
      box-shadow: 0 0 15px rgba(255, 174, 0, 0.1);
      border-radius: 12px;
      margin: 10px auto;
      padding: 15px 20px;
    }
    .section-title {
      color: #ffae00;
      font-weight: 600;
      margin-bottom: 10px;
    }
    footer {
      text-align: center;
      padding: 15px;
      font-size: 0.9rem;
      color: #ccc;
      border-top: 1px solid #222;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar d-flex justify-content-between align-items-center">
  <img src="../assets/images/Maskot-bulat.png">
  <div>
    <a href="../dasbord/home.php" class="btn btn-home me-2"><i class="bi bi-house"></i> Beranda</a>
    <a href="logout.php" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>

<!-- Profile -->
<div class="container profile-container">
  <img src="<?= !empty($user['photo']) ? $user['photo'] : '../assets/images/default-profile.png' ?>" 
     alt="Foto Profil" class="profile-photo">
  <h5 class="profile-name"><?= htmlspecialchars($user['username']) ?></h5>
  <p class="profile-username"><?= htmlspecialchars($user['email']) ?></p>
  <p class="text-secondary"><?= htmlspecialchars($user['address'] ?? '-') ?></p>
  <a href="edit_profile.php" class="btn btn-edit"><i class="bi bi-pencil-square"></i> Edit Profil</a>
</div>

<!-- Informasi Akun -->
<div class="container mt-4">
  <div class="card-custom">
    <h5 class="section-title"><i class="bi bi-person-badge"></i> Informasi Akun</h5>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Nomor HP:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($user['address']) ?></p>
  </div>
</div>

<footer>
  © 2025 CIRAKU | Semua hak dilindungi.
</footer>

</body>
</html>
