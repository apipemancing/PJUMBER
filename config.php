<?php
$host = "localhost"; // Ganti sesuai dengan konfigurasi server
$user = "root"; // Username database
$pass = ""; // Password database
$dbname = "jumat_beramal"; // Nama database

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
