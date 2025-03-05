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
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h4>Edit Data Jumat Beramal - <?php echo $tanggal; ?></h4>
        <form action="update_data.php" method="POST">
            <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
            
            <table class="table">
                <thead>
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
                                <input type="number" name="sumbangan[<?php echo $row['kelas']; ?>]" value="<?php echo $row['jumlah']; ?>" class="form-control">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
