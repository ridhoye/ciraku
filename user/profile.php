<?php
session_start();
include "../config/db.php";

// Cek login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); window.location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - CIRAKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #0a0a0a;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }

    /* Navbar */
    .navbar {
      background-color: #000;
      border-bottom: 1px solid #222;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: nowrap;
    }

    .navbar img {
      height: 55px;
      transition: transform 0.3s ease;
    }

    .navbar img:hover {
      transform: scale(1.05);
    }

    .navbar .btn-group {
      display: flex;
      align-items: center;
      gap: 10px;
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
      background: transparent;
    }

    .btn-home:hover {
      background-color: #ffae00;
      color: #000;
    }

    /* Profile Section */
    .profile-container {
      text-align: center;
      padding: 40px 20px 20px;
    }

    .profile-photo {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      border: 3px solid #ffae00;
      box-shadow: 0 0 25px #ffae00;
      object-fit: cover;
      margin-bottom: 15px;
    }

    .profile-name {
      font-size: 1.5rem;
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
      padding: 20px;
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

    /* Responsif */
    @media (max-width: 768px) {
      .navbar img {
        height: 45px;
      }

      .btn-group {
        gap: 6px;
      }

      .btn-home, .btn-logout {
        font-size: 0.8rem;
        padding: 6px 10px;
      }

      .navbar {
        padding: 8px 12px;
      }
    }

    @media (max-width: 480px) {
      .navbar img {
        height: 40px;
      }
      .btn-home, .btn-logout {
        padding: 5px 8px;
        font-size: 0.75rem;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <img src="../assets/images/Maskot-bulat.png" alt="Logo CIRENG">
  <div class="btn-group">
    <a href="../dasbord/home.php" class="btn btn-home">
      <i class="bi bi-house"></i> Beranda
    </a>
    <a href="logout.php" class="btn btn-logout">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
</nav>

<!-- Profile -->
<div class="container profile-container">
  <?php
  $profile_pic_path = !empty($user['profile_pic']) 
      ? "../uploads/" . htmlspecialchars($user['profile_pic']) 
      : "../assets/images/guestdef.jpg";
  ?>
  <img src="<?= $profile_pic_path ?>" alt="Foto Profil" class="profile-photo">

  <h5 class="profile-name"><?= htmlspecialchars($user['full_name']) ?></h5>
  <p class="profile-username"><?= htmlspecialchars($user['username']) ?> | <?= htmlspecialchars($user['email']) ?></p>
  <a href="edit_profile.php" class="btn btn-edit"><i class="bi bi-pencil-square"></i> Edit Profil</a>
</div>

<!-- Informasi Akun -->
<div class="container mt-4">
  <div class="card-custom">
    <h5 class="section-title"><i class="bi bi-person-badge"></i> Informasi Akun</h5>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Nomor HP:</strong> <?= $user['phone'] ?: '-' ?></p>
    <p><strong>Alamat:</strong> <?= isset($user['address']) ? htmlspecialchars($user['address']) : '-' ?></p>
    <p><strong>Bergabung Sejak:</strong> <?= $user['created_at'] ?? '-' ?></p>
  </div>
</div>

<footer>
  © 2025 CIRAKU | Semua hak dilindungi.
</footer>

</body>
</html>
