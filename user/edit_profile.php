<?php
session_start();
require_once "../config/db.php"; // sambungkan ke koneksi database

// Ambil data user dari session (misalnya id disimpan saat login)
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    $user = mysqli_fetch_assoc($result);
} else {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil - CIRAKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Comic Neue', sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }
    .edit-card {
        background: rgba(30, 30, 30, 0.9);
        border-radius: 20px;
        padding: 30px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 0 20px rgba(255, 174, 0, 0.3);
        border: 1px solid rgba(255, 174, 0, 0.2);
    }
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #ffae00;
        object-fit: cover;
        margin-bottom: 15px;
        box-shadow: 0 0 15px rgba(255, 174, 0, 0.4);
    }
    .form-label {
        color: #ffae00;
        font-weight: bold;
    }
    .form-control {
        background: #1a1a1a;
        border: 1px solid #333;
        color: white;
    }
    .form-control:focus {
        background: #1a1a1a;
        color: white;
        border-color: #ffae00;
        box-shadow: 0 0 10px rgba(255, 174, 0, 0.5);
    }
    .btn-save {
        background-color: #ffae00;
        color: black;
        font-weight: bold;
        border: none;
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        background-color: #ffc933;
        box-shadow: 0 0 15px rgba(255, 174, 0, 0.7);
    }
    .btn-cancel {
        background: transparent;
        border: 2px solid #ffae00;
        color: #ffae00;
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-cancel:hover {
        background: #ffae00;
        color: black;
        box-shadow: 0 0 10px rgba(255, 174, 0, 0.7);
    }
    footer {
        text-align: center;
        color: #aaa;
        padding: 10px;
        border-top: 1px solid #222;
        font-size: 14px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="edit-card text-center">
    <img src="<?= !empty($user['photo']) ? $user['photo'] : '../assets/images/default-profile.png' ?>" alt="Foto Profil" class="profile-img">
    <h4 class="mb-3"><?= htmlspecialchars($user['name']) ?></h4>

    <form action="update_profile.php" method="post" enctype="multipart/form-data" class="text-start">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label for="photo" class="form-label">Foto Profil</label>
            <input type="file" id="photo" name="photo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Nomor HP</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
        </div>

        <div class="mb-4">
            <label for="address" class="form-label">Alamat</label>
            <textarea id="address" name="address" rows="3" class="form-control"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
            <a href="profile.php" class="btn-cancel text-center">Batal</a>
        </div>
    </form>
  </div>
</div>

<footer>
  © 2025 CIRAKU | Semua hak dilindungi.
</footer>

</body>
</html>
