<?php
include 'config.php'; 

if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];
    
    // Ambil total jumlah yang akan dihapus
    $query_total = "SELECT SUM(jumlah) AS total_hapus FROM jumat_beramal WHERE tanggal = '$tanggal'";
    $result = mysqli_query($conn, $query_total);
    $row = mysqli_fetch_assoc($result);
    $total_hapus = $row['total_hapus'] ?? 0; // Jika null, set ke 0
    
    if ($total_hapus > 0) {
        // Kurangi saldo total
        $query_kurangi_saldo = "UPDATE saldo_total SET saldo = saldo - $total_hapus WHERE id = 1";
        mysqli_query($conn, $query_kurangi_saldo);
    }

    // Hapus semua data di tanggal tersebut
    $query = "DELETE FROM jumat_beramal WHERE tanggal = '$tanggal'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
}
?>
