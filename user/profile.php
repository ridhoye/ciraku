<?php
session_start();
include "../config/db.php";

// Cek login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user
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
      background: #000;
      border-bottom: 1px solid #1a1a1a;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 25px;
    }

    .navbar img {
      height: 55px;
      transition: transform 0.3s ease;
    }

    .navbar img:hover {
      transform: scale(1.05);
    }

    .btn-home, .btn-logout {
      border-radius: 30px;
      font-weight: 500;
      padding: 8px 16px;
      transition: all 0.3s ease;
    }

    .btn-home {
      border: 1px solid #ffae00;
      color: #ffae00;
      background: transparent;
    }

    .btn-home:hover {
      background: #ffae00;
      color: #000;
    }

    .btn-logout {
      background: #ffae00;
      color: #000;
      border: none;
      font-weight: 600;
    }

    .btn-logout:hover {
      background: #d49500;
    }

    /* Profile Section */
    .profile-section {
      text-align: center;
      padding: 50px 20px 20px;
    }

    .profile-photo {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      border: 3px solid #ffae00;
      box-shadow: 0 0 25px rgba(255, 174, 0, 0.4);
      object-fit: cover;
      margin-bottom: 15px;
    }

    .profile-name {
      font-size: 1.6rem;
      color: #ffae00;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .profile-username {
      color: #aaa;
      font-size: 0.95rem;
      margin-bottom: 12px;
    }

    .btn-edit {
      background: #ffae00;
      color: #000;
      border: none;
      border-radius: 25px;
      padding: 8px 18px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-edit:hover {
      background: #d49500;
    }

    /* Tombol tambahan */
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
    }

    .action-buttons a {
      background: #141414;
      border: 1px solid #2a2a2a;
      color: #ffae00;
      padding: 10px 18px;
      border-radius: 30px;
      font-weight: 500;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .action-buttons a:hover {
      background: #ffae00;
      color: #000;
    }

/* Informasi Akun */
.info-card {
  background: #111;
  border-radius: 14px;
  padding: 20px 25px;
  margin-top: 30px;
  box-shadow: 0 0 18px rgba(255, 174, 0, 0.05);
  max-width: 600px;   /* 🔥 batasi lebar biar center */
  margin-left: auto;
  margin-right: auto;
}

.info-header {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #ffae00;
  font-weight: 600;
  font-size: 1.1rem;
  margin-bottom: 15px;
}

.info-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #1f1f1f;
  padding: 8px 0;
  max-width: 500px; /* 🔥 batasi lebar isi */
  margin: 0 auto;   /* biar center */
}

.info-label {
  color: #bbb;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.95rem;
}

.info-value {
  color: #fff;
  font-weight: 500;
  font-size: 0.95rem;
  text-align: right;
}

.info-label i {
  color: #ffae00;
  font-size: 1rem;
}

    footer {
      text-align: center;
      color: #888;
      font-size: 0.9rem;
      padding: 20px;
      border-top: 1px solid #1a1a1a;
      margin-top: 40px;
    }

    @media (max-width: 768px) {
      .profile-photo {
        width: 110px;
        height: 110px;
      }
      .btn-home, .btn-logout {
        font-size: 0.85rem;
        padding: 6px 10px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <img src="../assets/images/Maskot-bulat.png" alt="Logo CIRENG">
    <div>
      <a href="../dasbord/home.php" class="btn btn-home"><i class="bi bi-house"></i> Beranda</a>
      <a href="logout.php" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </nav>

  <!-- Profile -->
  <div class="container profile-section">
    <?php
    $profile_pic_path = !empty($user['profile_pic']) 
        ? "../uploads/" . htmlspecialchars($user['profile_pic']) 
        : "../assets/images/guestdef.jpg";
    ?>
    <img src="<?= $profile_pic_path ?>" alt="Foto Profil" class="profile-photo">
    <h5 class="profile-name"><?= htmlspecialchars($user['full_name']) ?></h5>
    <p class="profile-username"><?= htmlspecialchars($user['username']) ?> | <?= htmlspecialchars($user['email']) ?></p>
    <a href="edit_profile.php" class="btn btn-edit"><i class="bi bi-pencil-square"></i> Edit Profil</a>

    <div class="action-buttons">
      <a href="pesanan.php"><i class="bi bi-bag"></i> Pesanan Saya</a>
      <a href="riwayat.php"><i class="bi bi-clock-history"></i> Riwayat Pembelian</a>
    </div>
  </div>

  <!-- Informasi Akun -->
  <div class="container info-card">
    <div class="info-header"><i class="bi bi-person-badge"></i> Informasi Akun</div>

    <div class="info-item">
      <div class="info-label"><i class="bi bi-envelope"></i> Email</div>
      <div class="info-value"><?= htmlspecialchars($user['email']) ?></div>
    </div>

    <div class="info-item">
      <div class="info-label"><i class="bi bi-telephone"></i> Nomor HP</div>
      <div class="info-value"><?= $user['phone'] ?: '-' ?></div>
    </div>

    <div class="info-item">
      <div class="info-label"><i class="bi bi-geo-alt"></i> Alamat</div>
      <div class="info-value"><?= isset($user['address']) ? htmlspecialchars($user['address']) : '-' ?></div>
    </div>

    <div class="info-item">
      <div class="info-label"><i class="bi bi-calendar"></i> Bergabung Sejak</div>
      <div class="info-value">
        <?php 
    if (isset($user['created_at'])) {
        $tanggal = new IntlDateFormatter(
            'id_ID',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'Asia/Jakarta',
            IntlDateFormatter::GREGORIAN,
            'd MMMM yyyy'
        );
        echo $tanggal->format(strtotime($user['created_at']));
    } else {
        echo '-';
    }
        ?>
      </div>
    </div>
  </div>

  <footer>© 2025 CIRAKU | Semua hak dilindungi.</footer>
</body>
</html>
