<?php
session_start();
include '../config/db.php'; // pastikan path sesuai

// Ambil input dari form
$identifier = $_POST['identifier'];
$password = $_POST['password'];

// Cek apakah user ada di database
$query = "SELECT * FROM users WHERE username='$identifier' OR email='$identifier' OR phone='$identifier'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Cek password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../dasbord/home.php");
        exit();
    } else {
        echo "Password salah!";
    }
} else {
    echo "Akun tidak ditemukan";
}
?>
