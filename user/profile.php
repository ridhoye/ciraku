<?php
session_start();

// contoh data dummy, nanti kamu bisa ganti dari database
$user = [
    "name" => "Yanto Renhan",
    "email" => "yantorenhan20@gmail.com",
    "photo" => "../assets/images/Screenshot 2025-09-25 080857.jpg", // bisa diganti sesuai upload user
    "orders" => [
        [
            "status" => "Sudah di Proses",
            "item" => "cireng isi ayam",
            "qty" => "3pcs",
            "price" => "Rp16.000"
        ],
        [
            "status" => "Belum di Proses",
            "item" => "cireng isi Kornet",
            "qty" => "4pcs",
            "price" => "Rp22.000"
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Comic Neue', sans-serif;
    }
    .profile-container {
        text-align: center;
        padding: 30px 20px;
    }
    .profile-container img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #ffae00;
        margin-bottom: 15px;
    }
    .order-box {
        background: #3b3b3b;
        color: white;
        border-radius: 12px;
        padding: 15px;
        min-width: 220px;
    }
    .btn-edit {
        border: 2px solid #ffae00;
        color: #ffae00;
        font-weight: bold;
    }
    .btn-edit:hover {
        background: #ffae00;
        color: black;
    }
    .btn-logout {
        background: #ffae00;
        color: black;
        font-weight: bold;
        border: none;
    }
    .btn-logout:hover {
        background: #d99500;
    }
  </style>
</head>
<body>

<div class="container profile-container">
    <!-- Back button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="../dasbord/home.php" class="text-white"><i class="bi bi-arrow-left"></i> Kembali</a>
        <h4 class="m-0">ciraku</h4>
        <i class="bi bi-person"></i>
    </div>
    <hr style="border: 2px solid #ffae00;">

    <!-- Profile -->
    <img src="<?= $user['photo'] ?>" alt="Foto Profil">
    <h5><?= $user['name'] ?></h5>
    <p><?= $user['email'] ?></p>

    <!-- Riwayat Pesanan -->
    <h5 class="mt-4 mb-3">Riwayat Pesanan</h5>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <?php foreach($user['orders'] as $order): ?>
        <div class="order-box">
            <h6 class="fw-bold"><?= $order['status'] ?></h6>
            <p class="m-0"><?= $order['item'] ?></p>
            <p class="m-0"><?= $order['qty'] ?></p>
            <p class="fw-bold"><?= $order['price'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="edit_profile.php" class="btn btn-edit px-4">Edit Profil</a>
        <a href="login.php" class="btn btn-logout px-4">Log Out</a>
    </div>
</div>

</body>
</html>
