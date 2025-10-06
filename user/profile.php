<?php
session_start();

// Data dummy (nanti bisa diganti ambil dari database)
$user = [
    "name" => "Yanto Renhan",
    "username" => "@yantorenhan",
    "email" => "yantorenhan20@gmail.com",
    "phone" => "081234567890",
    "address" => "Jl. Mawar No. 45, Bandung, Jawa Barat", // 🏠 Tambahan alamat
    "joined" => "12 Januari 2025",
    "photo" => "../assets/images/Screenshot 2025-09-25 080857.jpg",
    "orders" => [
        [
            "item" => "Cireng Isi Ayam Pedas",
            "date" => "02 Oktober 2025",
            "status" => "Selesai"
        ],
        [
            "item" => "Cireng Isi Sosis",
            "date" => "29 September 2025",
            "status" => "Diproses"
        ]
    ]
];
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
    .order-card {
      background-color: #1a1a1a;
      border: 1px solid #2e2e2e;
      border-radius: 12px;
      padding: 15px 20px;
      margin-bottom: 12px;
    }
    .order-status {
      font-weight: 600;
      padding: 5px 10px;
      border-radius: 6px;
      font-size: 0.85rem;
    }
    .status-done {
      background: #00b74a;
      color: white;
    }
    .status-process {
      background: #ffae00;
      color: black;
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
    <a href="login.php" class="btn btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>
<!-- Notifikasi update sukses -->
<?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
  <div class="alert alert-success text-center mb-3">
    <i class="bi bi-check-circle-fill"></i> Profil berhasil diperbarui!
  </div>
<?php endif; ?>
<!-- Profile -->
<div class="container profile-container">
  <img src="<?= $user['photo'] ?>" alt="Foto Profil" class="profile-photo">
  <h5 class="profile-name"><?= $user['name'] ?></h5>
  <p class="profile-username"><?= $user['username'] ?> | <?= $user['email'] ?></p>
  <a href="edit_profile.php" class="btn btn-edit"><i class="bi bi-pencil-square"></i> Edit Profil</a>
</div>

<!-- Informasi Akun -->
<div class="container mt-4">
  <div class="card-custom">
    <h5 class="section-title"><i class="bi bi-person-badge"></i> Informasi Akun</h5>
    <p><strong>Email:</strong> <?= $user['email'] ?></p>
    <p><strong>Nomor HP:</strong> <?= $user['phone'] ?></p>
    <p><strong>Alamat:</strong> <?= $user['address'] ?></p> <!-- 🏠 Alamat muncul di sini -->
    <p><strong>Bergabung Sejak:</strong> <?= $user['joined'] ?></p>
  </div>
</div>

<!-- Riwayat Pesanan -->
<div class="container mt-4">
  <h5 class="section-title"><i class="bi bi-bag-check"></i> Riwayat Pesanan</h5>
  <?php foreach ($user['orders'] as $order): ?>
  <div class="order-card d-flex justify-content-between align-items-center">
    <div>
      <h6 class="fw-bold"><?= $order['item'] ?></h6>
      <small class="text-secondary">Tanggal: <?= $order['date'] ?></small>
    </div>
    <div>
      <?php if ($order['status'] == "Selesai"): ?>
        <span class="order-status status-done">Selesai</span>
      <?php else: ?>
        <span class="order-status status-process">Diproses</span>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<footer>
  © 2025 CIRAKU | Semua hak dilindungi.
</footer>

</body>
</html>
