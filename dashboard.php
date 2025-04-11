<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Cek apakah ada input pencarian tanggal
$search_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Modifikasi query berdasarkan pencarian
$whereClause = "WHERE anonim = 0";
if (!empty($search_tanggal)) {
    $whereClause .= " AND tanggal = '$search_tanggal'";
}

// Ambil total saldo dari tabel saldo_total
$querySaldo = "SELECT saldo FROM saldo_total WHERE id=1";
$resultSaldo = mysqli_query($conn, $querySaldo);
$rowSaldo = mysqli_fetch_assoc($resultSaldo);
$totalSaldo = $rowSaldo['saldo'] ?? 0;

// Pagination
$limit = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Mengambil data rekapan per tanggal dengan pagination
$rekapan = mysqli_query($conn, "
    SELECT tanggal, SUM(jumlah) AS total 
    FROM jumat_beramal 
    $whereClause
    GROUP BY tanggal 
    ORDER BY tanggal DESC
    LIMIT $limit OFFSET $offset
") or die(mysqli_error($conn));

// Menghitung total halaman
$totalQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT tanggal) AS total FROM jumat_beramal WHERE anonim = 0");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalPages = ceil($totalRow['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Jumat Beramal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <!-- Saldo dan Menu -->
        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold">💰 Saldo Total: Rp<?php echo number_format($totalSaldo, 0, ',', '.'); ?></h4>
            <div class="flex gap-2">
        <!-- Tombol Tambah -->
        <div class="flex flex-col md:flex-row gap-2 mb-4">
    <a href="edit_menu.php" class="flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
        <i data-lucide="menu" class="w-4 h-4"></i> Edit Menu
    </a>
    <a href="logout.php" class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
        <i data-lucide="log-out" class="w-4 h-4"></i> LogOut
    </a>
</div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Tombol Tambah -->
        <div class="flex flex-col md:flex-row gap-2 mb-4">
    <a href="tambah_data_admin1.php" class="flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Data Sumbangan
    </a>
    <a href="tambah_kelas.php" class="flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
        <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Penyumbang
    </a>
</div>

        <hr class="my-4">

<!-- Form Pencarian -->
<form method="GET" action="dashboard.php" class="mb-4 bg-white p-4 rounded-lg shadow-md flex gap-2 items-center">
    <select name="tanggal" class="border p-2 rounded flex-1">
        <option value="">->Cari Tanggal Sumbangan<-</option>
        <?php
        $query_tanggal = mysqli_query($conn, "SELECT DISTINCT tanggal FROM jumat_beramal ORDER BY tanggal DESC");
        while ($row_tanggal = mysqli_fetch_assoc($query_tanggal)) {
            $tanggal = $row_tanggal['tanggal'];
            $selected = ($tanggal == $search_tanggal) ? 'selected' : '';
            echo "<option value=\"$tanggal\" $selected>" . date('d F Y', strtotime($tanggal)) . "</option>";
        }
        ?>
    </select>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg" title="Cari">
        <i data-lucide="search" class="w-5 h-5"></i>
    </button>
    <a href="dashboard.php" class="bg-gray-400 hover:bg-gray-500 text-white p-2 rounded-lg" title="Reset">
        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
    </a>
</form>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-blue-400 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Kelas Terbanyak</th>
                        <th class="py-3 px-4 text-left">Kelas Tersedikit</th>
                        <th class="py-3 px-4 text-left">Kelas Tidak Berpartisipasi</th>
                        <th class="py-3 px-4 text-left">Total</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
    <?php while ($row = mysqli_fetch_assoc($rekapan)) {
        $tanggal = $row['tanggal'];
        $kelas_terbanyak = mysqli_query($conn, "
            SELECT kelas, SUM(jumlah) AS total_sumbangan 
            FROM jumat_beramal 
            WHERE tanggal = '$tanggal' AND anonim = 0 
            GROUP BY kelas 
            ORDER BY total_sumbangan DESC 
            LIMIT 3
        ") or die(mysqli_error($conn));
        $kelas_tersedikit = mysqli_query($conn, "
            SELECT kelas, SUM(jumlah) AS total_sumbangan 
            FROM jumat_beramal 
            WHERE tanggal = '$tanggal' AND anonim = 0 
            GROUP BY kelas 
            HAVING total_sumbangan > 0 
            ORDER BY total_sumbangan ASC 
            LIMIT 3
        ") or die(mysqli_error($conn));
        $kelas_tidak_partisipasi = mysqli_query($conn, "
            SELECT k.nama_kelas 
            FROM kelas k 
            LEFT JOIN (
                SELECT kelas, SUM(jumlah) AS total_sumbangan
                FROM jumat_beramal
                WHERE tanggal = '$tanggal' AND anonim = 0
                GROUP BY kelas
            ) AS sumbangan_kelas 
            ON k.nama_kelas = sumbangan_kelas.kelas
            WHERE sumbangan_kelas.total_sumbangan = 0
        ") or die(mysqli_error($conn));
    ?>
    <tr>
        <td class="px-4 py-2"><?php echo $row['tanggal']; ?></td>

        <!-- Kelas Terbanyak -->
        <td class="px-4 py-2">
            <ul class="list-disc list-inside space-y-1">
                <?php
                $terbanyak = mysqli_fetch_all($kelas_terbanyak, MYSQLI_ASSOC);
                if ($terbanyak) {
                    foreach ($terbanyak as $k) {
                        echo "<li>{$k['kelas']} (Rp" . number_format($k['total_sumbangan'], 0, ',', '.') . ")</li>";
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>
            </ul>
        </td>

        <!-- Kelas Tersedikit -->
        <td class="px-4 py-2">
            <ul class="list-disc list-inside space-y-1">
                <?php
                $tersedikit = mysqli_fetch_all($kelas_tersedikit, MYSQLI_ASSOC);
                if ($tersedikit) {
                    foreach ($tersedikit as $k) {
                        echo "<li>{$k['kelas']} (Rp" . number_format($k['total_sumbangan'], 0, ',', '.') . ")</li>";
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>
            </ul>
        </td>

        <!-- Kelas Tidak Berpartisipasi -->
        <td class="px-4 py-2">
            <ul class="list-disc list-inside space-y-1">
                <?php
                $tidak_partisipasi = mysqli_fetch_all($kelas_tidak_partisipasi, MYSQLI_ASSOC);
                if ($tidak_partisipasi) {
                    foreach ($tidak_partisipasi as $k) {
                        echo "<li>{$k['nama_kelas']}</li>";
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>
            </ul>
        </td>

        <!-- Total -->
        <td class="px-4 py-2">Rp<?php echo number_format($row['total'], 0, ',', '.'); ?></td>

        <!-- Aksi -->
        <td class="px-4 py-2 text-center">
        <a href="edit_data.php?tanggal=<?php echo $row['tanggal']; ?>" 
       class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-md inline-flex items-center justify-center" 
       title="Edit">
        <i data-lucide="edit-3" class="w-4 h-4"></i>
    </a>
    <a href="hapus_data.php?tanggal=<?php echo $row['tanggal']; ?>" 
       class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md inline-flex items-center justify-center" 
       title="Hapus" 
       onclick="return confirm('Hapus data ini?');">
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </a>
        </td>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="flex justify-center space-x-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li>
                            <a class="px-3 py-1 rounded-md border <?php echo ($i == $page) ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> transition"
                               href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
                <br>
            </nav>
        </div>
    </div>
<br>
    <!-- Navbar Bottom -->
    <nav class="fixed bottom-0 w-full bg-white shadow-md p-2 flex justify-around md:hidden">
    <a href="index.php" class="text-blue-700 font-semibold hover:text-blue-900">Home</a>
        <a href="dashboard.php" class="text-blue-600 font-semibold">Dashboard</a>
        <a href="pengeluaran.php" class="text-gray-600 font-semibold">Pengeluaran</a>
    </nav>
    <nav class="fixed bottom-0 left-0 w-full bg-white shadow-md">
    <div class="flex justify-around py-3">
        <a href="index.php" class="text-blue-700 font-semibold hover:text-blue-900">🏠 Home</a>
        <a href="dashboard.php" class="text-blue-700 font-semibold hover:text-blue-900">📊 Dashboard</a>
        <a href="pengeluaran.php" class="text-blue-700 font-semibold hover:text-blue-900">💰 Pengeluaran</a>
    </div>
</nav>

    <!-- Aktifkan ikon lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
