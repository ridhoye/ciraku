<?php
$servername = "localhost";
$username = "root";
$password = ""; // kalau pakai XAMPP/Laragon biasanya kosong
$database = "ciraku_db"; // nanti kamu buat database ini di phpMyAdmin

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
