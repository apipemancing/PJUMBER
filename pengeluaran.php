<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Ambil saldo saat ini
$saldo_result = mysqli_query($conn, "SELECT saldo FROM saldo_total WHERE id=1");
$saldo = mysqli_fetch_assoc($saldo_result)['saldo'];

// Menyimpan pengeluaran baru
if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    if (!empty($tanggal) && !empty($keterangan) && $jumlah > 0) {
        // Insert data pengeluaran
        mysqli_query($conn, "INSERT INTO pengeluaran (tanggal, keterangan, jumlah) VALUES ('$tanggal', '$keterangan', '$jumlah')");

        // Update saldo total
        mysqli_query($conn, "UPDATE saldo_total SET saldo = saldo - $jumlah WHERE id=1");

        header("Location: pengeluaran.php");
        exit();
    }
}
//kurangi saldo saat ada pengeluaran
if (isset($_POST['simpan'])) {
    $jumlah_pengeluaran = (int)$_POST['jumlah'];

    // Insert pengeluaran ke tabel pengeluaran
    $query = "INSERT INTO pengeluaran (tanggal, jumlah) VALUES ('$tanggal', '$jumlah_pengeluaran')";
    mysqli_query($conn, $query);

    // Kurangi saldo total
    $queryUpdateSaldo = "UPDATE saldo_total SET saldo = saldo - $jumlah_pengeluaran WHERE id = 1";
    mysqli_query($conn, $queryUpdateSaldo);
}

// Mengambil daftar pengeluaran
$pengeluaran = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h3>Catat Pengeluaran</h3>

        <p><strong>Saldo Total: Rp<?php echo number_format($saldo, 0, ',', '.'); ?></strong></p>

        <form action="" method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="jumlah" class="form-control" placeholder="Jumlah (Rp)" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>

        <h4>Riwayat Pengeluaran</h4>
        <table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['tanggal']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td>Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                <td>
                    <a href="hapus_pengeluaran.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


        <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
