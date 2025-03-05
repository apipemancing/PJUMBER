<?php
session_start();
include 'config.php';

// Ambil data pengeluaran dari database
$query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran - Jumat Beramal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Daftar Pengeluaran Jumat Beramal</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                        <td>Rp<?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="dashboard_guest.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
