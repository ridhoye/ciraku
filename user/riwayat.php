<?php
session_start();
include "../config/db.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pembelian | CIRAKU</title>

<style>
    body {
        margin: 0;
        background: #0d0d0d;
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    .riwayat-container {
        max-width: 850px;
        margin: auto;
        padding: 40px 20px;
    }

    .judul-riwayat {
        text-align: center;
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #ffae00;
        text-shadow: 0 0 10px rgba(255,174,0,0.6);
    }

    /* FILTER */
    .filter-box {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .filter {
        padding: 10px 20px;
        border-radius: 25px;
        border: 1px solid #ffae00;
        background: transparent;
        color: #ffae00;
        cursor: pointer;
        transition: .3s;
        font-size: 15px;
    }

    .filter:hover, .filter.active {
        background: #ffae00;
        color: #000;
        box-shadow: 0 0 10px rgba(255,174,0,0.7);
    }

    /* CARD RIWAYAT */
    .riwayat-card {
        background: #141414;
        border: 1px solid rgba(255,174,0,0.2);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 0 12px rgba(255,174,0,0.15);
    }

    .riwayat-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .kode-order {
        color: #ccc;
    }

    /* STATUS */
    .status {
        padding: 5px 12px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-selesai {
        background: rgba(0,255,100,0.15);
        color: #00ff88;
        border: 1px solid #00ff88;
    }

    .status-batal {
        background: rgba(255,0,0,0.15);
        color: #ff4d4d;
        border: 1px solid #ff4d4d;
    }

    /* PRODUK LIST */
    .produk-info {
        display: flex;
        gap: 15px;
    }

    .produk-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid rgba(255,174,0,0.4);
    }

    .produk-detail {
        flex: 1;
    }

    .nama-produk {
        margin: 0 0 5px;
        font-size: 17px;
        color: #fff;
        font-weight: 600;
    }

    .jumlah, .tanggal {
        margin: 2px 0;
        font-size: 14px;
        color: #aaa;
    }

    .harga-info {
        text-align: right;
    }

    .total-label {
        font-size: 13px;
        color: #ccc;
    }

    .total-harga {
        margin: 5px 0;
        font-size: 20px;
        color: #ffae00;
        font-weight: 600;
        text-shadow: 0 0 7px rgba(255,174,0,0.7);
    }

    /* FOOTER BUTTON */
    .riwayat-footer {
        text-align: right;
        margin-top: 15px;
    }

    .btn-detail {
        padding: 10px 20px;
        background: #ffae00;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        color: #000;
        transition: .3s;
    }

    .btn-detail:hover {
        transform: scale(1.05);
        box-shadow: 0 0 12px rgba(255,174,0,0.7);
    }

.popup-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
    display: none;
    justify-content: center;
    align-items: center;
}

.popup-box {
    background: #141414;
    padding: 30px;
    border-radius: 15px;
    width: 350px;
    text-align: center;
    border: 1px solid #ffae00;
    box-shadow: 0 0 18px rgba(255,174,0,0.4);
}

.popup-box h3 {
    margin-bottom: 10px;
    color: #ffae00;
    text-shadow: 0 0 10px rgba(255,174,0,0.7);
}

.popup-total {
    font-size: 20px;
    color: #ffae00;
    margin-top: 10px;
}

.btn-close, .btn-repeat {
    margin-top: 15px;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: bold;
}

.btn-close {
    background: #ff4d4d;
    color: white;
}

.btn-repeat {
    background: #ffae00;
    color: black;
    margin-right: 8px;
}

.btn-kembali {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background: #ffae00;
    border-radius: 25px;
    color: #000;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 0 10px rgba(255,174,0,0.6);
    transition: .3s;
}

.btn-kembali:hover {
  background: #ffa200cb;
    color: #fff;
    border-color: #ffa200cb;
}

</style>
</head>

<body>

<div class="riwayat-container">

    <!-- button kembali -->
    <a href="profile.php" class="btn-kembali">Kembali</a>

    <h2 class="judul-riwayat">Riwayat Pembelian</h2>

    <!-- FILTER -->
    <div class="filter-box">
        <button class="filter active">Semua</button>
        <button class="filter">Selesai</button>
        <button class="filter">Dibatalkan</button>
    </div>

    <script>
function openPopup(nama, jumlah, tanggal, harga) {
    document.getElementById("popup-nama").innerHTML = "Produk: " + nama;
    document.getElementById("popup-jumlah").innerHTML = "Jumlah: " + jumlah;
    document.getElementById("popup-tanggal").innerHTML = "Tanggal: " + tanggal;
    document.getElementById("popup-harga").innerHTML = "Total: " + harga;

    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}
</script>

    <!-- CARD 1 (Contoh) -->
    <div class="riwayat-card">
        <div class="riwayat-header">
            <span class="kode-order">ORDER #CRK12345</span>
            <span class="status status-selesai">Selesai</span>
        </div>

        <div class="produk-info">
            <img src="../assets/produk/contoh.png" class="produk-img">

            <div class="produk-detail">
                <h3 class="nama-produk">Cireng Crispy Original</h3>
                <p class="jumlah">Jumlah: 2 pcs</p>
                <p class="tanggal">Tanggal: 11 Oktober 2025</p>
            </div>

            <div class="harga-info">
                <p class="total-label">Total</p>
                <p class="total-harga">Rp 28.000</p>
            </div>
        </div>

        <div class="riwayat-footer">
<button class="btn-detail" 
onclick="openPopup('Cireng Crispy Original', '2 pcs', '11 Oktober 2025', 'Rp 28.000')">
    Lihat Detail
</button>
        </div>
    </div>

    <!-- CARD 2 (Contoh) -->
    <div class="riwayat-card">
        <div class="riwayat-header">
            <span class="kode-order">ORDER #CRK98765</span>
            <span class="status status-batal">Dibatalkan</span>
        </div>

        <div class="produk-info">
            <img src="../assets/produk/contoh2.png" class="produk-img">

            <div class="produk-detail">
                <h3 class="nama-produk">Cireng Pedas Level 3</h3>
                <p class="jumlah">Jumlah: 1 pcs</p>
                <p class="tanggal">Tanggal: 08 Oktober 2025</p>
            </div>

            <div class="harga-info">
                <p class="total-label">Total</p>
                <p class="total-harga">Rp 15.000</p>
            </div>
        </div>

        <div class="riwayat-footer">
<button class="btn-detail" 
onclick="openPopup('Cireng Crispy Original', '2 pcs', '11 Oktober 2025', 'Rp 28.000')">
    Lihat Detail
</button>
        </div>
    </div>

    <div id="popup" class="popup-overlay">
        <div class="popup-box">
            <h3>Detail Pesanan</h3>
            <p id="popup-nama"></p>
            <p id="popup-jumlah"></p>
            <p id="popup-tanggal"></p>
            <p id="popup-harga" class="popup-total"></p>

            <button class="btn-repeat">Pesan Lagi</button>
            <button class="btn-close" onclick="closePopup()">Tutup</button>
        </div>
    </div>
</div>

</body>
</html>
