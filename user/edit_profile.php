<?php
session_start();

// Data dummy sementara
$user = [
    "name" => "Yanto Renhan",
    "email" => "yantorenhan20@gmail.com",
    "photo" => "https://randomuser.me/api/portraits/men/32.jpg"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil - Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Comic Neue', sans-serif;
    }
    .edit-container {
        max-width: 500px;
        margin: 50px auto;
        background: #1c1c1c;
        border-radius: 15px;
        padding: 30px;
    }
    .form-control {
        background: #333;
        border: none;
        color: #fff;
    }
    .form-control:focus {
        background: #444;
        color: #fff;
        border: 1px solid #ffae00;
        box-shadow: none;
    }
    .btn-save {
        background: #ffae00;
        color: black;
        font-weight: bold;
        border: none;
    }
    .btn-save:hover {
        background: #d99500;
    }
    .btn-cancel {
        border: 2px solid #ffae00;
        color: #ffae00;
        font-weight: bold;
    }
    .btn-cancel:hover {
        background: #ffae00;
        color: black;
    }
    .profile-pic {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid #ffae00;
        margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="container edit-container text-center">
    <h3 class="mb-3">Edit Profil</h3>
    <!-- Foto Profil -->
    <img src="<?= $user['photo'] ?>" alt="Foto Profil" class="profile-pic">
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3 text-start">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>">
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Foto Profil</label>
            <input type="file" class="form-control" name="photo">
        </div>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="profile.php" class="btn btn-cancel px-4">Batal</a>
            <button type="submit" class="btn btn-save px-4">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
