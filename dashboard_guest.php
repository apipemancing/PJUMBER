<?php
session_start();
include 'config.php';

// Cek apakah ada input pencarian tanggal
$search_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Tentukan jumlah data per halaman
$limit = 2; // Perbesar limit agar lebih banyak data ditampilkan

// Ambil halaman saat ini dari URL (default: 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil total saldo dari tabel saldo_total
$querySaldo = "SELECT saldo FROM saldo_total WHERE id=1";
$resultSaldo = mysqli_query($conn, $querySaldo);
$rowSaldo = mysqli_fetch_assoc($resultSaldo);
$totalSaldo = $rowSaldo['saldo'] ?? 0;

// Modifikasi query berdasarkan pencarian
$whereClause = "WHERE anonim = 0";
if (!empty($search_tanggal)) {
    $whereClause .= " AND tanggal = '$search_tanggal'";
}

// Menghitung total rekapan setelah pencarian
$totalQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT tanggal) AS total FROM jumat_beramal $whereClause");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung total halaman

// Mengambil data rekapan dengan pagination
$rekapan = mysqli_query($conn, "
    SELECT tanggal, SUM(jumlah) AS total 
    FROM jumat_beramal 
    $whereClause
    GROUP BY tanggal 
    ORDER BY tanggal DESC 
    LIMIT $start, $limit
") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guest - Jumat Beramal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body { height: 100vh; overflow-y: auto; }
        .navbar a { text-decoration: none; color: black; padding: 10px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="mb-3">Saldo Total: Rp<?php echo number_format($totalSaldo, 0, ',', '.'); ?></h4>
        <a href="lihat_menu.php" class="btn btn-warning">Lihat Menu</a>
    </div>
    <hr>

    <!-- Form Pencarian -->
    <form method="GET" action="dashboard_guest.php" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control" value="<?php echo $search_tanggal; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="dashboard_guest.php" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Kelas Terbanyak</th>
                    <th>Kelas Tersedikit</th>
                    <th>Kelas Tidak Berpartisipasi</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($rekapan)) { 
                    $tanggal = $row['tanggal'];

                    // Query untuk Kelas Terbanyak
                    $kelas_terbanyak = mysqli_query($conn, "
                        SELECT kelas, SUM(jumlah) AS total_sumbangan 
                        FROM jumat_beramal 
                        WHERE tanggal = '$tanggal' AND anonim = 0 
                        GROUP BY kelas 
                        ORDER BY total_sumbangan DESC 
                        LIMIT 3
                    ");

                    // Query untuk Kelas Tersedikit
                    $kelas_tersedikit = mysqli_query($conn, "
                        SELECT kelas, SUM(jumlah) AS total_sumbangan 
                        FROM jumat_beramal 
                        WHERE tanggal = '$tanggal' AND anonim = 0 
                        GROUP BY kelas 
                        HAVING total_sumbangan > 0 
                        ORDER BY total_sumbangan ASC 
                        LIMIT 3
                    ");

                    // Query untuk Kelas Tidak Berpartisipasi
                    $kelas_tidak_partisipasi = mysqli_query($conn, "
                        SELECT k.nama_kelas 
                        FROM kelas k 
                        WHERE NOT EXISTS (
                            SELECT 1 FROM jumat_beramal 
                            WHERE tanggal = '$tanggal' 
                            AND anonim = 0 
                            AND kelas = k.nama_kelas
                        )
                    ");
                ?>
                <tr>
                <td><?php echo $tanggal; ?></td>
                <td>
                    <?php 
                    $terbanyak = [];
                    while ($t = mysqli_fetch_assoc($kelas_terbanyak)) {
                        $terbanyak[] = $t['kelas'] . " (Rp" . number_format($t['total_sumbangan'], 0, ',', '.') . ")";
                    }
                    echo !empty($terbanyak) ? implode("<br>", $terbanyak) : "-";
                    ?>
                </td>
                <td>
                    <?php 
                    $tersedikit = [];
                    while ($t = mysqli_fetch_assoc($kelas_tersedikit)) {
                        $tersedikit[] = $t['kelas'] . " (Rp" . number_format($t['total_sumbangan'], 0, ',', '.') . ")";
                    }
                    echo !empty($tersedikit) ? implode("<br>", $tersedikit) : "-";
                    ?>
                </td>
                <td>
                    <?php 
                    $tidak_partisipasi = [];
                    while ($t = mysqli_fetch_assoc($kelas_tidak_partisipasi)) {
                        $tidak_partisipasi[] = $t['nama_kelas'];
                    }
                    echo !empty($tidak_partisipasi) ? implode("<br>", $tidak_partisipasi) : "-";
                    ?>
                </td>
                <td>Rp<?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                <td>
                    <a href="detail.php?tanggal=<?php echo $tanggal; ?>" class="btn btn-info btn-sm">Lihat</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>
<br>
<br>
<br>
<nav class="navbar fixed-bottom navbar-dark bg-light">
        <div class="container-fluid d-flex justify-content-around">
            <a href="index.php">Home</a>
            <a href="dashboard_guest.php">Dashboard</a>
            <a href="pengeluaran_guest.php">Pengeluaran</a>
        </div>
    </nav>
</body>
</html>
