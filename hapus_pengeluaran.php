<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil jumlah pengeluaran sebelum dihapus
    $query = "SELECT jumlah FROM pengeluaran WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $jumlah_pengeluaran = $row['jumlah'];

        // Hapus pengeluaran
        $query_delete = "DELETE FROM pengeluaran WHERE id = '$id'";
        if (mysqli_query($conn, $query_delete)) {
            // Tambahkan kembali ke saldo_total
            $query_update_saldo = "UPDATE saldo_total SET saldo = saldo + $jumlah_pengeluaran WHERE id = 1";
            mysqli_query($conn, $query_update_saldo);

            echo "<script>alert('Pengeluaran berhasil dihapus dan saldo dikembalikan!'); window.location='pengeluaran.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus pengeluaran!'); window.location='pengeluaran.php';</script>";
        }
    } else {
        echo "<script>alert('Data pengeluaran tidak ditemukan!'); window.location='pengeluaran.php';</script>";
    }
} else {
    header("Location: pengeluaran.php");
}
?>
