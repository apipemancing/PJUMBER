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
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
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
            <h3 class="text-center">Lihat Menu Jumat Beramal</h3>
            <div class="text-center">
                <a href="dashboard_guest.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
            </div>

            <input type="text" id="search" class="form-control mb-3" placeholder="Cari menu...">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama Menu</th>
                            <th>Porsi</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['nama_menu']; ?></td>
                                <td class="text-end"><?php echo number_format($row['porsi'], 0, ',', '.'); ?> Porsi</td>
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
                let menu = row.cells[0].textContent.toLowerCase();
                row.style.display = menu.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
