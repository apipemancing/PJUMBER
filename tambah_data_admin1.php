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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
body {
            background-color:rgb(52, 153, 255);
        }    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center">Tambah Data - Pilih Tanggal</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="" method="POST">
            <!-- Tanggal hanya Jumat -->
<div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" id="tanggal" name="tanggal" class="form-control" required>
    <div id="tanggalError" class="text-danger mt-1" style="display: none;">Tanggal harus hari Jumat!</div>
</div>

<script>
    const tanggalInput = document.getElementById('tanggal');
    const tanggalError = document.getElementById('tanggalError');

    tanggalInput.addEventListener('change', function () {
        const selectedDate = new Date(this.value);
        const day = selectedDate.getDay(); // 5 = Jumat

        if (day !== 5) {
            tanggalError.style.display = 'block';
            this.value = ''; // Reset input
        } else {
            tanggalError.style.display = 'none';
        }
    });
</script>

            <div class="flex justify-between items-center mt-6 gap-2">
    <!-- Tombol Kembali -->
    <a href="dashboard.php" class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow-md">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali
    </a>

    <!-- Tombol Lanjut -->
    <button type="submit" name="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow-md">
        Lanjut
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
    </button>
</div>

        </form>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

    </div>
</body>
</html>
