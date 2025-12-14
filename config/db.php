<?php
$host = "localhost";
$user = "u694533179_root";
$pass = "12345!@#$%Ti";
$dbname = "u694533179_ciraku_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
