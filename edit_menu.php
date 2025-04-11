<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Menampilkan semua menu
$menu_query = mysqli_query($conn, "SELECT * FROM menu");

// Menyimpan perubahan data menu
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_menu = $_POST['nama_menu'];
    $porsi = $_POST['porsi'];

    mysqli_query($conn, "UPDATE menu SET nama_menu='$nama_menu', porsi='$porsi' WHERE id='$id'");
    header("Location: edit_menu.php");
    exit();
}

// Menghapus menu
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM menu WHERE id='$id'");
    header("Location: edit_menu.php");
    exit();
}

// Menambahkan menu baru
if (isset($_POST['tambah'])) {
    $nama_menu = $_POST['nama_menu'];
    $porsi = $_POST['porsi'];

    mysqli_query($conn, "INSERT INTO menu (nama_menu, porsi) VALUES ('$nama_menu', '$porsi')");
    header("Location: edit_menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50">
        <div class="container mx-auto p-6">
        <h3 class="text-center text-xl font-bold text-blue-900 mb-4">Edit Menu</h3>
        
<!-- Tambahkan di <head> jika belum -->
<script src="https://unpkg.com/lucide@latest"></script>

<!-- Tabel -->
<div class="overflow-x-auto">
    <table class="w-full border rounded-lg shadow-md bg-white">
        <thead class="bg-blue-300 text-blue-900">
            <tr>
                <th class="p-2">Nama Menu</th>
                <th class="p-2">Porsi</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php while ($row = mysqli_fetch_assoc($menu_query)) { ?>
            <tr class="border-t">
                <form action="" method="POST">
                    <td class="p-2">
                        <input type="text" name="nama_menu" class="border p-1 rounded w-full" value="<?php echo $row['nama_menu']; ?>" required>
                    </td>
                    <td class="p-2">
                        <input type="number" name="porsi" class="border p-1 rounded w-full" value="<?php echo $row['porsi']; ?>" required>
                    </td>
                    <td class="p-2 flex gap-2 justify-center">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="hapus" class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" onclick="return confirm('Hapus menu ini?')">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                        </button>
                    </td>
                </form>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Form Tambah Menu Baru -->
<h4 class="mt-6 text-lg font-semibold text-blue-900">
    <i data-lucide="plus-circle" class="inline w-5 h-5 me-1"></i> Tambah Menu Baru
</h4>
<form action="" method="POST" class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
    <input type="text" name="nama_menu" class="border p-2 rounded" placeholder="Nama Menu" required>
    <input type="number" name="porsi" class="border p-2 rounded" placeholder="Porsi" required>
    <button type="submit" name="tambah" class="flex items-center justify-center gap-1 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambahkan
    </button>
</form>

<!-- Tombol Kembali -->
<a href="dashboard.php" class="mt-6 inline-flex items-center justify-center gap-2 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-700">
    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
</a>

<!-- Aktifkan icon lucide -->
<script>
    lucide.createIcons();
</script>
</body>
</html>
