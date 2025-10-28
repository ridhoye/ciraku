<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Update Profil</title>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
// Ambil data dari form
$username    = trim($_POST['username']);
$full_name   = trim($_POST['full_name']);
$email       = trim($_POST['email']);
$phone       = trim($_POST['phone']);
$address     = trim($_POST['address']);
$postal_code = trim($_POST['postal_code']);

// --- Validasi: Username tidak boleh kosong
if (empty($username)) {
    echo "
    <script>
    Swal.fire({
        icon: 'warning',
        title: 'Username Kosong!',
        text: 'Silakan isi username terlebih dahulu.',
        confirmButtonColor: '#fbbf24'
    }).then(() => {
        history.back();
    });
    </script>";
    exit();
}

// --- Cek apakah username sudah digunakan user lain
$check_sql = "SELECT id FROM users WHERE username = ? AND id != ?";
$check_stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($check_stmt, "si", $username, $user_id);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Username Sudah Digunakan!',
        text: 'Silakan pilih username lain yang belum terpakai.',
        confirmButtonColor: '#fbbf24'
    }).then(() => {
        history.back();
    });
    </script>";
    exit();
}

// --- Upload foto jika ada
$profile_pic = null;
if (!empty($_FILES['photo']['name'])) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES['photo']['name']);
    $target_file = $target_dir . $file_name;

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!in_array($_FILES['photo']['type'], $allowed_types)) {
        echo "
        <script>
        Swal.fire({
            icon: 'warning',
            title: 'Format Tidak Valid!',
            text: 'Gunakan format gambar JPG, PNG, atau WEBP.',
            confirmButtonColor: '#fbbf24'
        }).then(() => {
            history.back();
        });
        </script>";
        exit();
    }

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $profile_pic = $file_name;
    }
}

// --- Query update
if ($profile_pic) {
    $sql = "UPDATE users 
            SET username=?, full_name=?, email=?, phone=?, address=?, postal_code=?, profile_pic=? 
            WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $username, $full_name, $email, $phone, $address, $postal_code, $profile_pic, $user_id);
} else {
    $sql = "UPDATE users 
            SET username=?, full_name=?, email=?, phone=?, address=?, postal_code=? 
            WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $username, $full_name, $email, $phone, $address, $postal_code, $user_id);
}

if (mysqli_stmt_execute($stmt)) {
    // Hapus path lama jika ada
    $fix_sql = "UPDATE users SET profile_pic = REPLACE(profile_pic, 'uploads/', '') WHERE id = ?";
    $fix_stmt = mysqli_prepare($conn, $fix_sql);
    mysqli_stmt_bind_param($fix_stmt, "i", $user_id);
    mysqli_stmt_execute($fix_stmt);

    // ✅ Pop-up sukses
    echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Profil Diperbarui!',
        text: 'Perubahan profil kamu berhasil disimpan.',
        showConfirmButton: false,
        timer: 1800,
        timerProgressBar: true,
        didClose: () => {
            window.location = 'profile.php';
        }
    });
    </script>";
} else {
    echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Update!',
        text: 'Terjadi kesalahan saat memperbarui profil. Coba lagi nanti.',
        confirmButtonColor: '#fbbf24'
    }).then(() => {
        history.back();
    });
    </script>";
}
?>

</body>
</html>
