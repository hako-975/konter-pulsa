-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Bulan Mei 2023 pada 18.46
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konter_pulsa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok_barang` int(11) NOT NULL,
  `id_jenis_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_beli`, `harga_jual`, `stok_barang`, `id_jenis_barang`) VALUES
(1, 'Headset Samsung', 10000, 13000, 2, 1),
(2, 'Kabel Data Type Micro', 12000, 15000, 2, 1),
(3, 'Kabel Data Type C', 14000, 17000, 3, 1),
(4, 'Charger Samsung Type Micro', 20000, 25000, 1, 1),
(5, 'Voucher Tri 3GB 3 Hari', 8000, 11000, 2, 2),
(6, 'Kuota Indosat 7GB 7HR ', 20000, 23000, 3, 4),
(7, 'Kuota XL Xtra Combo 5GB + 10GB YouTube', 55000, 60000, 3, 4),
(8, 'Voucher Simpati 2,5GB 5HR', 10000, 13000, 4, 2),
(9, 'Cuddle', 8000, 10000, 1, 6),
(10, 'Melon', 8000, 10000, 1, 6),
(11, 'Melati', 8000, 10000, 1, 6),
(12, '1000 Bunga', 8000, 10000, 1, 6),
(13, 'Vanilla', 11000, 13000, 1, 7),
(14, 'Pulsa Tri 5K', 5500, 7000, 9, 5),
(15, 'Pulsa Tri 10k', 11000, 12000, 9, 5),
(16, 'Pulsa Simpati 5k', 5600, 7000, 9, 5),
(17, 'Pulsa XL 5k', 5500, 7000, 9, 5),
(18, 'Voucher Tri 5k', 5500, 7000, 5, 3),
(19, 'Voucher Tri 10k', 11000, 12000, 3, 3),
(20, 'Pulsa XL 10k', 11000, 12000, 9, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_barang`, `kuantitas`, `subtotal`) VALUES
(1, 1, 12, 1, 10000),
(2, 1, 7, 1, 60000),
(3, 2, 16, 1, 7000),
(4, 3, 1, 1, 13000),
(5, 4, 3, 1, 17000),
(6, 5, 9, 1, 10000),
(7, 5, 2, 1, 15000),
(9, 7, 7, 1, 60000),
(10, 8, 3, 1, 17000),
(11, 9, 20, 1, 12000),
(12, 10, 11, 1, 10000),
(13, 10, 1, 1, 13000),
(14, 11, 2, 1, 15000),
(15, 12, 13, 1, 13000),
(16, 13, 5, 1, 11000),
(17, 14, 15, 1, 12000),
(18, 14, 12, 1, 10000),
(19, 15, 3, 1, 17000),
(20, 16, 6, 1, 23000),
(21, 17, 14, 1, 7000),
(22, 18, 13, 1, 13000),
(23, 19, 6, 1, 23000),
(24, 19, 4, 1, 25000),
(25, 20, 17, 1, 7000),
(26, 21, 19, 2, 24000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis_barang` int(11) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis_barang`, `jenis_barang`) VALUES
(1, 'Elektronik '),
(2, 'Voucher Kuota'),
(3, 'Voucher Pulsa'),
(4, 'Kuota'),
(5, 'Pulsa'),
(6, 'Parfum Roll'),
(7, 'Parfum Semprot');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan_barang`
--

CREATE TABLE `pemasukan_barang` (
  `id_pemasukan_barang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tanggal_pemasukan` datetime NOT NULL,
  `jumlah_pemasukan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemasukan_barang`
--

INSERT INTO `pemasukan_barang` (`id_pemasukan_barang`, `id_barang`, `id_supplier`, `tanggal_pemasukan`, `jumlah_pemasukan`) VALUES
(1, 12, 5, '2023-05-02 22:04:37', 3),
(2, 4, 2, '2023-05-02 22:04:48', 2),
(3, 9, 5, '2023-05-02 22:04:56', 2),
(4, 1, 2, '2023-05-02 22:05:08', 4),
(5, 3, 3, '2023-05-02 22:05:19', 6),
(6, 2, 3, '2023-05-02 22:05:26', 4),
(7, 6, 2, '2023-05-02 22:05:37', 5),
(8, 7, 2, '2023-05-02 22:05:45', 5),
(9, 11, 5, '2023-05-02 22:05:52', 2),
(10, 10, 5, '2023-05-02 22:05:58', 1),
(11, 16, 4, '2023-05-02 22:06:10', 10),
(12, 15, 4, '2023-05-02 22:06:19', 10),
(13, 14, 4, '2023-05-02 22:06:29', 10),
(14, 20, 4, '2023-05-02 22:06:42', 10),
(15, 17, 4, '2023-05-02 22:06:49', 10),
(16, 13, 5, '2023-05-02 22:06:59', 3),
(17, 8, 3, '2023-05-02 22:07:08', 4),
(18, 19, 3, '2023-05-02 22:07:17', 2),
(19, 18, 3, '2023-05-02 22:07:32', 3),
(20, 5, 3, '2023-05-02 22:08:32', 3),
(21, 18, 3, '2023-05-02 23:45:57', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat_supplier` text NOT NULL,
  `no_telp_supplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `no_telp_supplier`) VALUES
(2, 'Sinar Mentari Cell Pamulang', 'Jl. Dr. Setiabudi No.27, RW.2, Pamulang Tim., Kec. Pamulang, Kota Tangerang Selatan, Banten 15417', '081314213758'),
(3, 'C2N Cellular', 'Pasar Prumpung, No. 28 RT. 02 / 03, Jl. Raya Pahlawan, Gn. Sindur, Kec. Gn. Sindur, Kabupaten Bogor, Jawa Barat 16810', '085811207199'),
(4, 'Zega Cell', 'Babakan, Kec. Setu, Kota Tangerang Selatan, Banten 15315', '082276232702'),
(5, 'Ar Rayyan', 'Jl. Pd. Kelapa Raya No.8A, RT.4/RW.9, Pd. Klp., Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13450', '082112937878');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal_transaksi`, `total_harga`, `bayar`, `kembalian`, `id_user`) VALUES
(1, '2023-05-02 23:10:13', 70000, 100000, 30000, 1),
(2, '2023-05-02 23:10:37', 7000, 10000, 3000, 1),
(3, '2023-05-02 23:10:53', 13000, 15000, 2000, 1),
(4, '2023-05-02 23:11:13', 17000, 17000, 0, 1),
(5, '2023-05-02 23:13:17', 25000, 25000, 0, 1),
(7, '2023-05-02 23:14:58', 60000, 60000, 0, 1),
(8, '2023-05-02 23:40:42', 17000, 20000, 3000, 1),
(9, '2023-05-02 23:40:59', 12000, 12000, 0, 1),
(10, '2023-05-02 23:42:52', 23000, 25000, 2000, 1),
(11, '2023-05-02 23:43:08', 15000, 15000, 0, 1),
(12, '2023-05-02 23:43:21', 13000, 13000, 0, 1),
(13, '2023-05-02 23:43:35', 11000, 11000, 0, 1),
(14, '2023-05-02 23:43:47', 22000, 22000, 0, 1),
(15, '2023-05-02 23:44:07', 17000, 17000, 0, 1),
(16, '2023-05-02 23:44:21', 23000, 23000, 0, 1),
(17, '2023-05-02 23:44:30', 7000, 7000, 0, 1),
(18, '2023-05-02 23:44:46', 13000, 13000, 0, 1),
(19, '2023-05-02 23:44:57', 48000, 50000, 2000, 1),
(20, '2023-05-02 23:45:18', 7000, 10000, 3000, 1),
(21, '2023-05-02 23:45:30', 24000, 25000, 1000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(300) NOT NULL,
  `hak_akses` enum('administrator','operator') NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_telp_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `hak_akses`, `nama_lengkap`, `no_telp_user`) VALUES
(1, 'admin', '$2y$10$jSGC3AGHKDBQYTFfH9ZzW./W3hn5Kdnp1Ds8ibZtzA.lixwLuxi4G', 'administrator', 'Admin', '081574427863'),
(12, 'andri123', '$2y$10$q9FhF5lf44wQhPue.p4KN.DtY4qMHlSEVIl0UxOdBptDrfvCqWZPi', 'operator', 'Andri Firman Saputra', '087808675313');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_jenis_barang` (`id_jenis_barang`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis_barang`);

--
-- Indeks untuk tabel `pemasukan_barang`
--
ALTER TABLE `pemasukan_barang`
  ADD PRIMARY KEY (`id_pemasukan_barang`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id_jenis_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemasukan_barang`
--
ALTER TABLE `pemasukan_barang`
  MODIFY `id_pemasukan_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
