<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $sumbangan_baru = $_POST['sumbangan']; // Array kelas => jumlah baru
    
    // Ambil total sumbangan sebelum perubahan
    $query_total_lama = "SELECT SUM(jumlah) AS total_lama FROM jumat_beramal WHERE tanggal = '$tanggal'";
    $result = mysqli_query($conn, $query_total_lama);
    $row = mysqli_fetch_assoc($result);
    $total_lama = $row['total_lama'] ?? 0;

    $total_baru = 0; // Untuk menghitung total baru setelah update

    // Loop update per kelas
    foreach ($sumbangan_baru as $kelas => $jumlah) {
        $query_update = "UPDATE jumat_beramal SET jumlah = $jumlah WHERE tanggal = '$tanggal' AND kelas = '$kelas'";
        mysqli_query($conn, $query_update);
        $total_baru += $jumlah;
    }

    // Hitung selisih perubahan
    $selisih = $total_baru - $total_lama;

    // Update saldo_total dengan selisih
    $query_update_saldo = "UPDATE saldo_total SET saldo = saldo + $selisih WHERE id = 1";
    mysqli_query($conn, $query_update_saldo);

    echo "<script>alert('Data berhasil diperbarui!'); window.location='dashboard.php';</script>";
} else {
    header("Location: dashboard.php");
}
?>
