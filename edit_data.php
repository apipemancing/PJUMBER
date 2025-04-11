<?php
include 'config.php';

if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];

    // Ambil data berdasarkan tanggal
    $query = "SELECT * FROM jumat_beramal WHERE tanggal = '$tanggal'";
    $result = mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Container -->
    <div class="container mx-auto mt-6 p-4 bg-white shadow-lg rounded-lg">
        <h4 class="text-center text-xl font-semibold text-gray-700">Edit Data Jumat Beramal - <?php echo $tanggal; ?></h4>

        <form action="update_data.php" method="POST" class="mt-4">
            <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">

<!-- Tabel -->
<div class="overflow-x-auto">
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-blue-200 text-gray-800">
            <tr>
                <th class="border border-gray-300 p-2">Kelas</th>
                <th class="border border-gray-300 p-2">Jumlah Sumbangan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="bg-white">
                    <td class="border border-gray-300 p-2"><?php echo $row['kelas']; ?></td>
                    <td class="border border-gray-300 p-2 flex items-center gap-2">
                        <span class="text-gray-700">Rp</span>
                        <input type="text" 
                               name="sumbangan[<?php echo $row['kelas']; ?>]" 
                               value="<?php echo number_format($row['jumlah'], 0, ',', '.'); ?>" 
                               class="rupiah-input w-full px-2 py-1 border border-gray-300 rounded-md text-right">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Tombol Simpan & Kembali -->
<div class="flex justify-between gap-2 mt-4">
    <a href="dashboard.php" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md flex items-center gap-1">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md w-full flex justify-center items-center gap-1">
        Simpan Perubahan <i data-lucide="save" class="w-4 h-4"></i>
    </button>
</div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('menu').classList.toggle('hidden');
        });
    </script>
    <!-- Lucide Icon Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
