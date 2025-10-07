<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data dari form
$full_name   = $_POST['full_name'];
$email       = $_POST['email'];
$phone       = $_POST['phone'];
$address     = $_POST['address'];
$postal_code = $_POST['postal_code'];

// Upload foto kalau ada
$profile_pic = null;
if (!empty($_FILES['photo']['name'])) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_name = time() . "_" . basename($_FILES['photo']['name']);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        // Simpan ke DB hanya nama file (tanpa "uploads/")
        $profile_pic = $file_name;
    }
}

// Query update
if ($profile_pic) {
    $sql = "UPDATE users 
            SET full_name=?, email=?, phone=?, address=?, postal_code=?, profile_pic=? 
            WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $full_name, $email, $phone, $address, $postal_code, $profile_pic, $user_id);
} else {
    $sql = "UPDATE users 
            SET full_name=?, email=?, phone=?, address=?, postal_code=? 
            WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $phone, $address, $postal_code, $user_id);
}

if (mysqli_stmt_execute($stmt)) {
    // Bersihin data lama di DB kalau masih ada "uploads/"
    $fix_sql = "UPDATE users 
                SET profile_pic = REPLACE(profile_pic, 'uploads/', '') 
                WHERE id = ?";
    $fix_stmt = mysqli_prepare($conn, $fix_sql);
    mysqli_stmt_bind_param($fix_stmt, "i", $user_id);
    mysqli_stmt_execute($fix_stmt);

    header("Location: profile.php?success=1");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
