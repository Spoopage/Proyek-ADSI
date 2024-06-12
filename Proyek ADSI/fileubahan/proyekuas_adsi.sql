-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 04:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyekuas_adsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `status_aktif` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `nama_admin`, `status_aktif`) VALUES
(1, 'admin', '$2y$10$Oqxxb2JhT2aEwBYgwC5VM.ANSM4Ocm0/O/lLSk1bQuOEl6Hnab6uG', 'admin1', 1),
(2, 'admin2', '$2y$10$.610TvDwlQ3dYS/lgNQ0XOiIBe2v5UHZfRWJ7kzT2T9DfnRN0CeO.', 'adminC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `harga` int(255) NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `jumlah` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `nama_product`, `harga`, `img_src`, `jumlah`) VALUES
(41, 3, 'baju merah', 200000, 'resources/placeholder.png', 1),
(42, 5, 'baju hitam', 200000, 'resources/placeholder.png', 1),
(43, 4, 'baju kuning', 200000, 'resources/placeholder.png', 1),
(44, 2, 'baju biru', 200000, 'resources/placeholder.png\r\n', 1),
(45, 7, 'Baju Hijau', 200000, 'resources/placeholder.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lacak`
--

CREATE TABLE `lacak` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lacak`
--

INSERT INTO `lacak` (`id`, `gambar`, `keterangan`) VALUES
(1, 'resources/pelacak.png', 'Orderan anda saat ini berada di Jl. Jemur Andayani');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `order_id`, `jumlah`, `harga`) VALUES
(1, 'C-125', 3, 150000),
(2, 'C-126', 7, 785000),
(3, 'C-127', 11, 1350000),
(4, 'G-561', 5, 490000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(32) NOT NULL,
  `nama_pelanggan` varchar(128) NOT NULL,
  `noTelp_pelanggan` int(16) NOT NULL,
  `alamat_pelanggan` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `noTelp_pelanggan`, `alamat_pelanggan`, `password`) VALUES
(1, 'Adrian', 123456789, 'Jl. Siwalankerto 8', '$2y$10$/dcc4HgbHxqgLYhCFYCB3uTusDzSbicq6vCmtk6IS5/eSDGWUqfPW'),
(2, 'Timoen', 123456789, 'Jl Siwalankerto 22', '$2y$10$Vg4cQVNPMj8f2m4O3ySZDeE7YuKzpvl2A1YsNs6PbbAxI1Ld/yHMm');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `deskripsi_product` varchar(255) NOT NULL,
  `harga` int(255) NOT NULL,
  `img_src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_product`, `deskripsi_product`, `harga`, `img_src`) VALUES
(2, 'baju biru', 'baju biru', 200000, 'resources/placeholder.png\r\n'),
(3, 'baju merah', 'baju merah', 200000, 'resources/placeholder.png'),
(4, 'baju kuning', 'baju kuning', 200000, 'resources/placeholder.png'),
(5, 'baju hitam', 'baju hitam', 200000, 'resources/placeholder.png'),
(6, 'Baju pink', 'baju pink', 200000, 'resources/placeholder.png'),
(7, 'Baju Hijau', 'baju hijau', 200000, 'resources/placeholder.png');

-- --------------------------------------------------------

--
-- Table structure for table `sample_bank_db`
--

CREATE TABLE `sample_bank_db` (
  `id_nasabah` int(128) NOT NULL,
  `nama_nasabah` varchar(128) NOT NULL,
  `pin` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `total` int(255) NOT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `customer_id`, `customer_name`, `total`, `transaction_date`) VALUES
(22, 1, 'Adrian', 200000, '0000-00-00 00:00:00'),
(3436, 1, 'adrian', 0, '2024-06-11 18:02:36'),
(7121, 1, 'adrian', 0, '2024-06-11 18:04:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `lacak`
--
ALTER TABLE `lacak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`) USING BTREE;

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sample_bank_db`
--
ALTER TABLE `sample_bank_db`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `lacak`
--
ALTER TABLE `lacak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sample_bank_db`
--
ALTER TABLE `sample_bank_db`
  MODIFY `id_nasabah` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9401;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
