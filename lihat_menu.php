<?php
session_start();
include 'config.php';

// Ambil data menu dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Menu - Jumat Beramal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<!-- Konten -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-center text-2xl font-bold text-blue-600 mb-4">📋 Lihat Menu Jumat Beramal</h3>
        
        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="search" class="w-full p-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="🔍 Cari menu...">
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 text-sm">
                <thead class="bg-blue-600 text-white text-center">
                    <tr>
                        <th class="px-4 py-3">🍽️ Nama Menu</th>
                        <th class="px-4 py-3"> Porsi</th>
                    </tr>
                </thead>
                <tbody id="dataTable" class="text-center divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-2"><?php echo $row['nama_menu']; ?></td>
                            <td class="px-4 py-2 text-right"><?php echo number_format($row['porsi'], 0, ',', '.'); ?> Porsi</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
            <!-- Tombol Kembali -->
    <a href="dashboard_guest.php" class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow-md">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali
    </a>

    </div>
</div>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#dataTable tr');

            rows.forEach(row => {
                let menu = row.cells[0].textContent.toLowerCase();
                row.style.display = menu.includes(filter) ? '' : 'none';
            });
        });
    </script>
        <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
