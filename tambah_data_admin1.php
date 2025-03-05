<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    
    // Cek apakah tanggal sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM jumat_beramal WHERE tanggal='$tanggal'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Data untuk tanggal ini sudah ada!";
    } else {
        $_SESSION['tanggal'] = $tanggal;
        header("Location: tambah_data_admin2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Jumat Beramal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center">Tambah Data - Pilih Tanggal</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success w-100">Lanjut</button>
        </form>
    </div>
</body>
</html>
