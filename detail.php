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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Jumat Beramal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard_guest.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengeluaran.php">Pengeluaran</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-5">
        <div class="card p-4">
            <h3 class="text-center">Detail Sumbangan Tanggal - <?php echo date('d M Y', strtotime($tanggal)); ?></h3>
            <div class="text-center">
                <a href="dashboard_guest.php" class="btn btn-secondary mb-3">Kembali</a>
            </div>
            
            <input type="text" id="search" class="form-control mb-3" placeholder="Cari kelas...">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Kelas</th>
                            <th>Total Sumbangan</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['kelas']; ?></td>
                                <td class="text-end">Rp<?php echo number_format($row['total_sumbangan'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#dataTable tr');
            
            rows.forEach(row => {
                let kelas = row.cells[0].textContent.toLowerCase();
                row.style.display = kelas.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
