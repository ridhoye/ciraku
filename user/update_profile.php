<?php
session_start();

// untuk sekarang BELUMMM ade DATABASENYA, jadi kita cuma redirect balik BE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // nanti di sini proses update ke DB
    $_SESSION['message'] = "Profil berhasil diperbarui!";
    header("Location: profile.php");
    exit();
}
