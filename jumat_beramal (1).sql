-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Apr 2025 pada 05.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jumat_beramal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$VUfEI3fnqvm.UxmdJBMO5.fErOyYyFT7zIDuRtZQUp7My1Dv8G4Zu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jumat_beramal`
--

CREATE TABLE `jumat_beramal` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kelas_terbanyak` varchar(255) NOT NULL,
  `kelas_tersedikit` varchar(255) NOT NULL,
  `kelas_tidak_partisipasi` text NOT NULL,
  `total` int(11) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `anonim` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jumat_beramal`
--

INSERT INTO `jumat_beramal` (`id`, `tanggal`, `kelas_terbanyak`, `kelas_tersedikit`, `kelas_tidak_partisipasi`, `total`, `kelas`, `jumlah`, `anonim`) VALUES
(75, '2025-02-24', '', '', '', 0, 'Anonim', 100000, 1),
(118, '2025-02-26', '', '', '', 0, '10 Kimia', 8000, 0),
(119, '2025-02-26', '', '', '', 0, '10 Otomotif', 9000, 0),
(120, '2025-02-26', '', '', '', 0, '10 RPL', 10000, 0),
(121, '2025-02-26', '', '', '', 0, '10 TKJ', 0, 0),
(122, '2025-02-26', '', '', '', 0, '12 TKJ', 29000, 0),
(123, '2025-02-26', '', '', '', 0, '11 Otomotif', 24000, 0),
(124, '2025-02-26', '', '', '', 0, '12 RPL', 40000, 0),
(125, '2025-02-26', '', '', '', 0, 'Guru', 100000, 1),
(134, '2025-02-27', '', '', '', 0, '10 Kimia', 7000, 0),
(135, '2025-02-27', '', '', '', 0, '10 Otomotif', 0, 0),
(136, '2025-02-27', '', '', '', 0, '10 RPL', 8000, 0),
(137, '2025-02-27', '', '', '', 0, '10 TKJ', 500, 0),
(138, '2025-02-27', '', '', '', 0, '12 Otomotif', 30000, 0),
(139, '2025-02-27', '', '', '', 0, '12 RPL', 32000, 0),
(140, '2025-02-27', '', '', '', 0, '12 TKJ', 4000, 0),
(141, '2025-02-27', '', '', '', 0, 'Guru', 100000, 1),
(161, '2025-03-17', '', '', '', 0, '10 Kimia', 8000, 0),
(162, '2025-03-17', '', '', '', 0, '10 Otomotif', 7000, 0),
(163, '2025-03-17', '', '', '', 0, '10 RPL', 6000, 0),
(164, '2025-03-17', '', '', '', 0, '10 TKJ', 15000, 0),
(165, '2025-03-17', '', '', '', 0, '11 Kimia', 20000, 0),
(166, '2025-03-17', '', '', '', 0, '11 Otomotif', 25000, 0),
(167, '2025-03-17', '', '', '', 0, '11 RPL', 0, 0),
(168, '2025-03-18', '', '', '', 0, '10 Kimia', 8000, 0),
(169, '2025-03-18', '', '', '', 0, '10 Otomotif', 9000, 0),
(170, '2025-03-18', '', '', '', 0, '10 RPL', 5000, 0),
(171, '2025-03-18', '', '', '', 0, '10 TKJ', 12000, 0),
(172, '2025-03-18', '', '', '', 0, '11 Kimia', 20000, 0),
(173, '2025-03-18', '', '', '', 0, '11 RPL', 23000, 0),
(174, '2025-03-18', '', '', '', 0, '11 Otomotif', 0, 0),
(175, '2025-03-18', '', '', '', 0, 'Guru', 200000, 1),
(200, '2025-03-29', '', '', '', 0, '10 Kimia', 5000, 0),
(201, '2025-03-29', '', '', '', 0, '10 Otomotif', 5000, 0),
(202, '2025-03-29', '', '', '', 0, '11 Kimia', 6000, 0),
(203, '2025-03-29', '', '', '', 0, '10 RPL', 12000, 0),
(204, '2025-03-29', '', '', '', 0, '11 RPL', 15000, 0),
(205, '2025-03-29', '', '', '', 0, '12 RPL', 20000, 0),
(206, '2025-03-29', '', '', '', 0, 'Guru', 250000, 1),
(207, '2025-04-11', '', '', '', 0, '10 Otomotif', 5000, 0),
(208, '2025-04-11', '', '', '', 0, '10 RPL', 6000, 0),
(209, '2025-04-11', '', '', '', 0, '10 TKJ', 23000, 0),
(210, '2025-04-11', '', '', '', 0, '11 Kimia', 35000, 0),
(211, '2025-04-11', '', '', '', 0, '11 Otomotif', 25000, 0),
(212, '2025-04-11', '', '', '', 0, '10 Kimia', 6000, 0),
(214, '2025-04-18', '', '', '', 0, '10 RPL', 56000, 1),
(215, '2025-04-18', '', '', '', 0, '10 Otomotif', 6000, 0),
(216, '2025-04-18', '', '', '', 0, '10 TKJ', 10000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`) VALUES
(14, '10 Otomotif'),
(16, '10 RPL'),
(15, '10 TKJ'),
(17, '11 Kimia'),
(18, '11 Otomotif'),
(20, '11 RPL'),
(19, '11 TKJ'),
(21, '12 Kimia'),
(22, '12 Otomotif'),
(24, '12 RPL'),
(23, '12 TKJ'),
(25, 'Guru'),
(26, 'Ustadz');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `porsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `porsi`) VALUES
(3, 'AYAM GEPREK', 100),
(4, 'Nasi Bungkus mie', 50),
(5, 'mie dower', 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `tanggal`, `keterangan`, `jumlah`) VALUES
(8, '2025-03-18', 'membeli nasi bungkus dan air minum', 45000),
(12, '2025-04-18', 'membeli nasi bungkus dan air minum', 600000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo_total`
--

CREATE TABLE `saldo_total` (
  `id` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `saldo_total`
--

INSERT INTO `saldo_total` (`id`, `saldo`) VALUES
(1, 599500);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `jumat_beramal`
--
ALTER TABLE `jumat_beramal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `saldo_total`
--
ALTER TABLE `saldo_total`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jumat_beramal`
--
ALTER TABLE `jumat_beramal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
