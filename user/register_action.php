<?php
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $phone, $password);

    if ($stmt->execute()) {
        header("Location: login.php?success=1");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
}
?>
