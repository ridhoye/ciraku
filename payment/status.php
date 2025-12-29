<?php
session_start();
include "../config/db.php";

if (!isset($_GET['order_id'])) {
    header("Location: ../dasbord/home.php");
    exit;
}

$order_id = $_GET['order_id'];

$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*, u.full_name, u.address, u.phone
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.order_id='$order_id'
"));

if (!$order) {
    echo "Order tidak ditemukan";
    exit;
}
?>
