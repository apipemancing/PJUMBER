<?php
include 'config.php';

// Pastikan parameter tanggal tersedia
if (!isset($_GET['tanggal'])) {
    echo "<script>alert('Tanggal tidak valid!'); window.location='dashboard_guest.php';</script>";
    exit();
}

$tanggal = $_GET['tanggal'];

// Ambil data sumbangan berdasarkan tanggal tertentu
$query = "SELECT kelas, SUM(jumlah) AS total_sumbangan 
          FROM jumat_beramal 
          WHERE tanggal = ?
          GROUP BY kelas 
          ORDER BY total_sumbangan DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $tanggal);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sumbangan - <?php echo $tanggal; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">


    <!-- Konten -->
    <div class="container mx-auto mt-6 p-4 bg-white shadow-lg rounded-lg">
        <h3 class="text-center text-xl font-semibold text-gray-700">Detail Sumbangan - <?php echo date('d M Y', strtotime($tanggal)); ?></h3>
    
        <input type="text" id="search" class="w-full mt-4 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Cari kelas...">

        <!-- Tabel -->
        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-blue-200 text-gray-800">
                    <tr>
                        <th class="border border-gray-300 p-2">Kelas</th>
                        <th class="border border-gray-300 p-2">Total Sumbangan</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="bg-white">
                            <td class="border border-gray-300 p-2"><?php echo $row['kelas']; ?></td>
                            <td class="border border-gray-300 p-2 text-right">Rp<?php echo number_format($row['total_sumbangan'], 0, ',', '.'); ?></td>
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

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('menu').classList.toggle('hidden');
        });

        document.getElementById('search').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#dataTable tr');

            rows.forEach(row => {
                let kelas = row.cells[0].textContent.toLowerCase();
                row.style.display = kelas.includes(filter) ? '' : 'none';
            });
        });
    </script>
            <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
