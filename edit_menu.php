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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Jumat Beramal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengeluaran.php">Pengeluaran</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container mt-4">
        <h3 class="text-center">Edit Menu</h3>
        
        <!-- Tabel Responsif -->
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nama Menu</th>
                        <th>Porsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($menu_query)) { ?>
                    <tr>
                        <form action="" method="POST">
                            <td>
                                <input type="text" name="nama_menu" class="form-control" value="<?php echo $row['nama_menu']; ?>" required>
                            </td>
                            <td>
                                <input type="number" name="porsi" class="form-control" value="<?php echo $row['porsi']; ?>" required>
                            </td>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="update" class="btn btn-primary btn-sm">Simpan</button>
                                <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus menu ini?')">Hapus</button>
                            </td>
                        </form>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Form Tambah Menu Baru -->
        <h4 class="mt-4">Tambah Menu Baru</h4>
        <form action="" method="POST" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="porsi" class="form-control" placeholder="Porsi" required>
            </div>
            <div class="col-md-3">
                <button type="submit" name="tambah" class="btn btn-success w-100">Tambahkan</button>
            </div>
        </form>

        <a href="dashboard.php" class="btn btn-primary mt-4 w-100">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
