<?php
require_once '../vendor/autoload.php';
include "../config/db.php";

use Midtrans\Config;
use Midtrans\Notification;

Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
Config::$isProduction = false;

$notif = new Notification();

$order_id = $notif->order_id;
$status   = $notif->transaction_status;
$payment  = $notif->payment_type;

// Ambil order
$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM orders WHERE order_id='$order_id'
"));

if (!$order) {
    http_response_code(404);
    exit;
}

$user_id = $order['user_id'];

// Mapping status
if ($status === 'settlement' || $status === 'capture') {

    // ✅ UPDATE ORDER
    mysqli_query($conn, "
        UPDATE orders 
        SET status='paid', payment_type='$payment'
        WHERE order_id='$order_id'
    ");

    // ✅ HAPUS CART USER
    mysqli_query($conn, "
        DELETE FROM cart WHERE user_id='$user_id'
    ");

}
elseif ($status === 'pending') {

    mysqli_query($conn, "
        UPDATE orders 
        SET status='pending', payment_type='$payment'
        WHERE order_id='$order_id'
    ");

}
elseif ($status === 'expire' || $status === 'cancel') {

    mysqli_query($conn, "
        UPDATE orders 
        SET status='failed', payment_type='$payment'
        WHERE order_id='$order_id'
    ");

}

http_response_code(200);
