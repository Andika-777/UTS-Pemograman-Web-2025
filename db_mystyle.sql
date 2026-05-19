-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 03:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mystyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`, `keterangan`) VALUES
(1, 'Kaos', 'Kaos yang nyaman dipakai untuk kegiatan sehari-hari. Bahannya ringan, tidak panas, dan mudah dipadukan dengan berbagai gaya sehingga cocok untuk santai maupun aktivitas luar ruangan.'),
(2, 'Jaket', 'Jaket yang tidak hanya menjaga tubuh tetap hangat, tetapi juga menambah gaya. Tersedia dalam berbagai model yang cocok untuk dipakai jalan, bekerja, atau sekadar menikmati udara sore.'),
(3, 'Jeans', 'Jeans dengan bahan yang kuat namun tetap nyaman dipakai. Cocok untuk dipakai ke kampus, bekerja, atau hangout. Semakin sering dipakai biasanya justru semakin pas dengan bentuk tubuh.'),
(4, 'Tas', 'Tas serbaguna yang muat banyak barang penting. Desainnya cocok untuk dibawa bepergian, sekolah, atau dipakai bekerja. Ringan namun tetap kuat untuk menemani aktivitas harian.'),
(5, 'Sepatu', 'Sepatu yang nyaman dipakai seharian. Cocok untuk berjalan jauh maupun sekadar santai. Pilihannya beragam sehingga bisa disesuaikan dengan gaya dan kebutuhan pemakaian.'),
(6, 'Aksesoris', 'Aksesoris pendukung penampilan seperti gelang, topi, ikat pinggang, dan lainnya. Tambahan kecil yang bisa membuat tampilan jadi lebih hidup dan berkarakter.');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `pembeli_id` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`pembeli_id`, `nama_pembeli`, `email`, `no_hp`, `alamat`) VALUES
(1, 'Alya Rahma', 'alya@gmail.com', '081234567890', 'Jl. Melati No.10, Jakarta'),
(2, 'Dimas Putra', 'dimasp@gmail.com', '082198765432', 'Jl. Mawar No.8, Bandung'),
(3, 'Nina Lestari', 'ninalestari@yahoo.com', '085612345678', 'Jl. Kenanga No.5, Surabaya'),
(4, 'Rizal Hidayat', 'rizal_hidayat@gmail.com', '081277889900', 'Jl. Anggrek No.15, Yogyakarta'),
(5, 'Vina Oktaviani', 'vinaokta@gmail.com', '082333445566', 'Jl. Dahlia No.20, Medan'),
(11, 'sdas', 'sda@gmail.com', NULL, 'sdasd'),
(12, 'sdas', 'sda@gmail.com', NULL, 'sdasd'),
(13, 'sdas', 'sda@gmail.com', NULL, 'sdasd'),
(14, 'sdas', 'sda@gmail.com', NULL, 'sdasd');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `penjualan_id` int(11) NOT NULL,
  `pembeli_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`penjualan_id`, `pembeli_id`, `produk_id`, `tanggal`, `jumlah`, `total_harga`) VALUES
(1, 1, 3, '2025-11-01', 1, 200000.00),
(2, 2, 1, '2025-11-02', 2, 240000.00),
(3, 3, 5, '2025-11-03', 1, 300000.00),
(4, 4, 2, '2025-11-05', 1, 250000.00),
(5, 5, 4, '2025-11-06', 1, 180000.00),
(6, 1, 6, '2025-11-07', 2, 160000.00),
(7, 2, 7, '2025-11-08', 1, 100000.00),
(8, 3, 1, '2025-11-09', 3, 360000.00);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `nama_produk`, `harga`, `stok`, `foto`, `kategori_id`) VALUES
(1, 'Kaos Oversize Streetwear', 120000.00, 30, '1763122374_3865.png', 1),
(2, 'Jaket Hoodie Premium', 250000.00, 15, '1763122384_8745.jpg', 2),
(3, 'Celana Jeans Slimfit', 200000.00, 20, '1763122394_6624.jpg', 3),
(4, 'Tas Selempang Kulit', 180000.00, 10, '1763122406_5557.jpg', 4),
(5, 'Sepatu Sneakers Retro', 300000.00, 25, '1763122413_3530.jpg', 5),
(6, 'Topi Bucket Hat', 80000.00, 40, '1763122431_6130.jpg', 6),
(7, 'Kacamata Fashion', 100000.00, 35, '1763122438_7097.png', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `nama`, `password`) VALUES
(1, 'admin', 'andika', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`pembeli_id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD KEY `pembeli_id` (`pembeli_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `pembeli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `penjualan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`pembeli_id`) REFERENCES `pembeli` (`pembeli_id`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
