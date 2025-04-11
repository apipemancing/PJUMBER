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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <!-- Konten -->
    <div class="container mx-auto mt-6">
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-center text-xl font-semibold text-blue-900">Daftar Pengeluaran Jumat Beramal</h3>
            <div class="overflow-x-auto mt-4">
                <table class="w-full border border-gray-300 rounded-lg">
                    <thead class="bg-blue-400 text-white">
                        <tr>
                            <th class="py-2 px-4">Tanggal</th>
                            <th class="py-2 px-4">Keterangan</th>
                            <th class="py-2 px-4">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-blue-100">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="border-b border-gray-300 text-center">
                                <td class="py-2 px-4"><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($row['keterangan']); ?></td>
                                <td class="py-2 px-4 text-right font-semibold text-red-600">Rp<?php echo number_format($row['jumlah'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
        <a href="dashboard_guest.php" class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow-md">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali
    </a>
        </div>
    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
