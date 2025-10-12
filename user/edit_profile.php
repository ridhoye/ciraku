<?php
session_start();
include "../config/db.php"; // koneksi DB

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari DB
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Kalau user gak ketemu
if (!$user) {
    echo "User tidak ditemukan.";
    exit();
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
    <!-- foto profil -->
    <img id="previewImage" 
     src="<?= !empty($user['profile_pic']) ? '../uploads/' . htmlspecialchars($user['profile_pic']) : '../assets/images/default.png' ?>" 
     alt="Foto Profil" class="profile-img">

    <h4 class="mb-3"><?= htmlspecialchars($user['full_name'] ?? 'Belum diisi') ?></h4>

    <form action="update_profile.php" method="post" enctype="multipart/form-data" class="text-start">

        <div class="mb-3 text-center">
  <label for="photo" class="form-label d-block">Foto Profil</label>

  <!-- Label berfungsi sebagai tombol upload -->
  <label for="photo" class="btn btn-warning fw-bold px-4 py-2 rounded-3" style="cursor:pointer;">
    📸 Tambahkan Foto
  </label>

  <!-- Nama file yang dipilih -->
  <span id="fileName" class="d-block mt-2 text-secondary" style="font-size: 14px;">Belum ada foto dipilih</span>

  <!-- Input aslinya disembunyikan -->
  <input type="file" id="photo" name="photo" class="form-control" style="display:none;">
</div>

        <div class="mb-3">
            <label for="full_name" class="form-label">Nama Lengkap</label>
            <input type="text" id="full_name" name="full_name" class="form-control" 
                   value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Nomor HP</label>
            <input type="text" id="phone" name="phone" class="form-control" 
                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea id="address" name="address" class="form-control"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="postal_code" class="form-label">Kode Pos</label>
            <input type="text" id="postal_code" name="postal_code" class="form-control" 
                   value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>">
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

<script>
  document.getElementById('photo').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('previewImage').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

//   biar nama file muncul setelah dipilih
   document.getElementById('photo').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const fileNameSpan = document.getElementById('fileName');
    if (file) {
      fileNameSpan.textContent = file.name;
    } else {
      fileNameSpan.textContent = "Belum ada foto dipilih";
    }

    // Preview foto baru (sekalian dari sebelumnya)
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('previewImage').src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
</script>

</body>
</html>
