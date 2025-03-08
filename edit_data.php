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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
        <h4 class="text-center">Edit Data Jumat Beramal - <?php echo $tanggal; ?></h4>

        <form action="update_data.php" method="POST">
            <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">

            <!-- Tabel Responsif -->
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Kelas</th>
                            <th>Jumlah Sumbangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['kelas']; ?></td>
                                <td>
                                    <input type="number" name="sumbangan[<?php echo $row['kelas']; ?>]" 
                                           value="<?php echo $row['jumlah']; ?>" 
                                           class="form-control text-center">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-success w-100 mt-3">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
