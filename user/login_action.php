<?php
session_start();
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['username']; // bisa email / username / no hp
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? OR username = ? OR phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $input, $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: profile.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Akun tidak ditemukan!";
    }
}
?>
