<?php
session_start();
include "../config/db.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil filter status
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';

// Ambil filter bulan & tahun
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

// Pagination
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Build query
$where = "WHERE user_id=$user_id";

// Filter status
if ($filter == 'selesai') {
    $where .= " AND status='Selesai'";
} elseif ($filter == 'batal') {
    $where .= " AND status='Dibatalkan'";
}

// Filter bulan & tahun
if ($bulan != "" && $tahun != "") {
    $where .= " AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'";
}

// Hitung total data
$countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan $where");
$totalData = mysqli_fetch_assoc($countQuery)['total'];
$totalPages = ceil($totalData / $limit);

// Query utama
$query = mysqli_query($conn, "
    SELECT * FROM pesanan 
    $where 
    ORDER BY tanggal DESC 
    LIMIT $start, $limit
");
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

    .status-pending {
        background: rgba(255,174,0,0.15);
        color: #ffae00;
        border: 1px solid #ffae00;
    }

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
}
</style>
</head>

<body>

<div class="riwayat-container">

    <a href="profile.php" class="btn-kembali">Kembali</a>

    <h2 class="judul-riwayat">Riwayat Pembelian</h2>

    <div class="filter-box">

        <a href="riwayat.php?filter=semua">
            <button class="filter <?= ($filter == 'semua') ? 'active' : '' ?>">Semua</button>
        </a>

        <a href="riwayat.php?filter=selesai">
            <button class="filter <?= ($filter == 'selesai') ? 'active' : '' ?>">Selesai</button>
        </a>

        <a href="riwayat.php?filter=batal">
            <button class="filter <?= ($filter == 'batal') ? 'active' : '' ?>">Dibatalkan</button>
        </a>

        <!-- FILTER BULAN -->
        <form action="riwayat.php" method="GET" style="display:flex; gap:10px;">
            <input type="hidden" name="filter" value="<?= $filter ?>">

            <select name="bulan" class="filter" style="background:#ffae00;color:black;">
                <option value="">Bulan</option>
                <?php 
                for ($m = 1; $m <= 12; $m++) {
                    $selected = ($bulan == $m) ? "selected" : "";
                    echo "<option value='$m' $selected>".date("F", mktime(0,0,0,$m,1))."</option>";
                }
                ?>
            </select>

            <select name="tahun" class="filter" style="background:#ffae00;color:black;">
                <option value="">Tahun</option>
                <?php 
                $startYear = 2022;
                $currentYear = date("Y");
                for ($y = $currentYear; $y >= $startYear; $y--) {
                    $selected = ($tahun == $y) ? "selected" : "";
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>

            <button type="submit" class="filter" style="background:#ffae00;color:black;">Filter</button>
        </form>

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

<?php while ($row = mysqli_fetch_assoc($query)) { ?>

<div class="riwayat-card">
    <div class="riwayat-header">
        <span class="kode-order">ORDER #<?= $row['id'] ?></span>

        <span class="status 
            <?php 
                if ($row['status'] == 'Selesai') echo 'status-selesai';
                else if ($row['status'] == 'Dibatalkan') echo 'status-batal';
                else echo 'status-pending';
            ?>">
            <?= $row['status'] ?>
        </span>
    </div>

    <div class="produk-info">

        <?php
        $pname = $row['nama_produk'];
        $g = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM produk WHERE nama_produk='$pname' LIMIT 1"));
        $gambar = $g ? $g['gambar'] : "default.png";
        ?>

        <img src="../assets/images/<?= $gambar ?>" class="produk-img">

        <div class="produk-detail">
            <h3 class="nama-produk"><?= $row['nama_produk'] ?></h3>
            <p class="jumlah">Jumlah: <?= $row['jumlah'] ?> pcs</p>
            <p class="tanggal">Tanggal: <?= date('d M Y', strtotime($row['tanggal'])) ?></p>
        </div>

        <div class="harga-info">
            <p class="total-label">Total</p>
            <p class="total-harga">
                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
            </p>
        </div>
    </div>

    <div class="riwayat-footer">
        <button class="btn-detail"
            onclick="openPopup(
                '<?= $row['nama_produk'] ?>',
                '<?= $row['jumlah'] ?> pcs',
                '<?= date('d M Y', strtotime($row['tanggal'])) ?>',
                'Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>'
            )">
            Lihat Detail
        </button>
    </div>
</div>

<?php } ?>

<!-- PAGINATION -->
<div style="text-align:center; margin-top:20px;">

    <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>&filter=<?= $filter ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" 
            class="filter" style="background:#ffae00;color:black;">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&filter=<?= $filter ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" 
            class="filter <?= ($page == $i ? 'active' : '') ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>&filter=<?= $filter ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" 
            class="filter" style="background:#ffae00;color:black;">Next</a>
    <?php endif; ?>

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
