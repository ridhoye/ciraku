<?php
session_start();
include "../config/db.php";

// Cek login dan role admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../user/login.php");
  exit;
}

// Hapus pesan
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM kontak_pesan WHERE id = $id");
  header("Location: kontak_pesan.php");
  exit;
}

// Pencarian (termasuk phone)
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
$query = "SELECT * FROM kontak_pesan WHERE 
          nama LIKE '%$cari%' OR email LIKE '%$cari%' OR subjek LIKE '%$cari%' OR phone LIKE '%$cari%' 
          ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

$pageTitle = "Data Users - Ciraku";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesan Masuk - Admin Ciraku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background:#0f0f0f; color:#fff; font-family:'Poppins',sans-serif; }
    .content { margin-left:260px; padding:30px; }
    .card { background:#1e1e1e; border:none; border-radius:15px; }
    .table { color:#fff; }
    .table thead { background:#fbbf24; color:#000; }
    .btn-action { border-radius:8px; padding:4px 10px; }
    .btn-wa { background-color:#25D366; color:#fff; border:none; }
    .btn-wa:hover { background-color:#1ebe57; color:#fff; }
  </style>
</head>
<body>
<?php include "includes/sidebar.php"; ?>

<!-- Konten -->
<div class="content">
  <h2 class="mb-4">Pesan Masuk</h2>

  <!-- Form Pencarian -->
  <form method="GET" class="mb-3 d-flex">
    <input type="text" name="cari" class="form-control me-2" placeholder="Cari nama, email, subjek, atau no HP..." value="<?= htmlspecialchars($cari) ?>">
    <button type="submit" class="btn btn-warning"><i class="bi bi-search"></i></button>
  </form>

  <div class="card p-4">
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Subjek</th>
            <th>Pesan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                // pastikan phone selalu string sebelum diproses -> mencegah preg_replace null deprecation
                $phone_raw = isset($row['phone']) ? (string)$row['phone'] : '';
                // hapus semua karakter selain digit
                $nohp = preg_replace('/[^0-9]/', '', $phone_raw);

                // normalisasi ke format internasional untuk wa.me
                $wa_num = '';
                if ($nohp !== '') {
                  if (substr($nohp, 0, 2) === '62') {
                    $wa_num = $nohp;
                  } elseif (substr($nohp, 0, 1) === '0') {
                    $wa_num = '62' . substr($nohp, 1);
                  } else {
                    // jika sudah tanpa leading 0 tapi bukan diawali 62, coba pakai langsung
                    $wa_num = $nohp;
                  }
                }

                // link WA hanya jika ada nomor valid
                $wa_link = $wa_num ? "https://wa.me/{$wa_num}" : '#';

                // safe output
                $nama = htmlspecialchars($row['nama']);
                $email = htmlspecialchars($row['email']);
                $phone_out = htmlspecialchars($row['phone']);
                $subjek = htmlspecialchars($row['subjek']);
                $pesan = nl2br(htmlspecialchars($row['pesan']));
                $tanggal = htmlspecialchars($row['tanggal']);

                echo "<tr>
                        <td>{$no}</td>
                        <td>{$nama}</td>
                        <td>{$email}</td>
                        <td>{$phone_out}</td>
                        <td>{$subjek}</td>
                        <td>".nl2br(htmlspecialchars($row['pesan'] ?? ''))."</td>
                        <td>{$tanggal}</td>
                        <td class='d-flex gap-1'>";
                // tombol WA (aktif jika nomor valid)
                if ($wa_num) {
                  echo "<a href='{$wa_link}' target='_blank' class='btn btn-sm btn-wa btn-action' title='Chat via WhatsApp'><i class='bi bi-whatsapp'></i></a>";
                } else {
                  echo "<button class='btn btn-sm btn-secondary btn-action' disabled title='No HP tidak tersedia'><i class='bi bi-whatsapp'></i></button>";
                }

                echo "  <a href='?hapus={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")' class='btn btn-sm btn-outline-danger btn-action'><i class='bi bi-trash'></i></a>
                        </td>
                      </tr>";
                $no++;
              }
            } else {
              echo "<tr><td colspan='8' class='text-center text-muted'>Pesan tidak ditemukan.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
