<?php
session_start();

// Pastikan folder upload ada
$upload_dir = "../uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Ambil data lama (dummy)
$user = [
    "name" => "Yanto Renhan",
    "email" => "yantorenhan20@gmail.com",
    "address" => "Jl. Mawar No. 25, Tangerang, Banten",
    "photo" => "../assets/images/Screenshot 2025-09-25 080857.jpg"
];

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? $user['name'];
    $email = $_POST['email'] ?? $user['email'];
    $address = $_POST['address'] ?? $user['address'];
    $photo = $user['photo'];

    // Proses upload foto baru (jika ada)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $filename = time() . "_" . basename($_FILES['photo']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($tmp_name, $target_path)) {
            $photo = $target_path;
        }
    }

    // Simpan ke session (sementara, nanti bisa diganti DB)
    $_SESSION['user'] = [
        "name" => $name,
        "email" => $email,
        "address" => $address,
        "photo" => $photo
    ];

    // Redirect ke halaman profil
    header("Location: profile.php?update=success");
    exit;
} else {
    // Jika bukan dari form
    header("Location: edit_profile.php");
    exit;
}
?>
