<?php
session_start();
include 'config.php';

// Ambil data menu
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
</head>
<body>
    <div class="container mt-4">
        <h3>Lihat Menu</h3>
        <a href="dashboard_guest.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Porsi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['nama_menu']; ?></td>
                        <td><?php echo number_format($row['porsi'], 0, ',', '.'); ?> Porsi</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
