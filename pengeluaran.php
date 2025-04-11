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
</head>
<body>
<!-- Tambahkan di <head> jika belum -->
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.tailwindcss.com"></script>
<!-- Container -->
<div class="container mx-auto mt-6 p-4 bg-white shadow-lg rounded-lg">
    <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <i data-lucide="file-plus" class="w-5 h-5 text-blue-600"></i>
        Catat Pengeluaran
    </h3>

    <p class="text-lg font-medium text-gray-700 mb-4">
        <strong>Saldo Total:</strong> <span class="text-green-600">Rp<?php echo number_format($saldo, 0, ',', '.'); ?></span>
    </p>

    <!-- Form Tambah Pengeluaran -->
    <form action="" method="POST" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-3">
                <input type="date" name="tanggal" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="md:col-span-5">
                <input type="text" name="keterangan" placeholder="Keterangan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="md:col-span-3">
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-600 text-sm">
                        Rp
                    </span>
                    <input type="number" name="jumlah" placeholder="Jumlah" class="w-full px-3 py-2 border border-gray-300 rounded-r-md focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>
            <div class="md:col-span-1">
                <button type="submit" name="simpan" class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md flex items-center justify-center gap-1">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan
                </button>
            </div>
        </div>
    </form>

    <!-- Riwayat -->
    <h4 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <i data-lucide="history" class="w-5 h-5 text-gray-600"></i>
        Riwayat Pengeluaran
    </h4>

    <div class="overflow-x-auto mb-6">
        <table class="min-w-full border border-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Keterangan</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                $query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border"><?php echo $row['tanggal']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['keterangan']; ?></td>
                        <td class="px-4 py-2 border text-red-600">Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Tombol Kembali -->
    <a href="dashboard.php" class="inline-flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali
    </a>
</div>
<!-- Aktifkan icon lucide -->
<script>
    lucide.createIcons();
</script>
</body>
</html>
