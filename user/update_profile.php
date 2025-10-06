<?php
session_start();

// ambil data yang dikirim dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $photo = null;

    // Cek apakah user upload foto baru
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../assets/images/";
        $fileName = basename($_FILES["photo"]["name"]);
        $targetPath = $uploadDir . $fileName;

        // Pindahkan file upload ke folder tujuan
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
            $photo = $targetPath;
        }
    }

    // Simpan ke session (sementara, nanti bisa diganti ke database)
    $_SESSION['user'] = [
        "name" => $name,
        "username" => $username,
        "email" => $email,
        "phone" => $phone,
        "photo" => $photo ?? "../assets/images/Screenshot 2025-09-25 080857.jpg",
    ];

    // Redirect balik ke profil dengan notifikasi
    $_SESSION['message'] = "Profil berhasil diperbarui!";
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Update Profil - CIRAKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Comic Neue', sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card {
        background: rgba(30, 30, 30, 0.9);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 0 25px rgba(255, 174, 0, 0.3);
        border: 1px solid rgba(255, 174, 0, 0.2);
    }
    .btn {
        background-color: #ffae00;
        color: black;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        transition: 0.3s;
    }
    .btn:hover {
        background-color: #ffc933;
        box-shadow: 0 0 15px rgba(255, 174, 0, 0.6);
    }
  </style>
</head>
<body>

<div class="card">
  <h3>⚙️ Memperbarui Profil...</h3>
  <p>Harap tunggu sebentar...</p>
</div>

<script>
  // redirect otomatis (jika header gagal)
  setTimeout(() => {
      window.location.href = "profile.php";
  }, 1500);
</script>

</body>
</html>
