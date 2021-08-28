-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2021 at 06:24 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `cName` varchar(100) NOT NULL,
  `cAdd` text NOT NULL,
  `mobile` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `cName`, `cAdd`, `mobile`) VALUES
(1, 'ram', 'asdfkjhu', 123),
(2, 'Bue', 'urd ej', 0),
(3, 'Bue', 'urd ej', 0),
(4, '', '', 0),
(5, '', '', 0),
(6, '', '', 1234),
(7, '', '', 12345),
(8, 'hhgh', 'r5556rtfhgn g kjhgug ', 987654321),
(9, '', '', 123456),
(10, 'knd', 'ad1', 1234567),
(11, 'knd', 'ad1', 12345678),
(12, '1iasdnm', 'iuhja6 askdh aiud', 123456789),
(13, 'anant', 'askjakd als d', 222);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `nid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_item`
--

INSERT INTO `invoice_item` (`nid`, `order_id`, `pid`, `Qty`) VALUES
(17, 1, 1, 2),
(19, 1, 2, 2),
(20, 1, 1, 1),
(24, 2, 1, 10),
(25, 21, 1, 0),
(26, 21, 1, 0),
(27, 21, 1, 1),
(28, 22, 2, 1),
(29, 22, 1, 2),
(30, 22, 2, 2),
(37, 23, 4, 5),
(39, 28, 4, 10),
(40, 28, 2, 1),
(41, 29, 3, 10),
(42, 29, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_invoice`
--

CREATE TABLE `order_invoice` (
  `oid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `gstType` varchar(50) NOT NULL,
  `itemTotal` int(11) NOT NULL,
  `GST` int(11) NOT NULL,
  `InvoiceTotal` int(11) NOT NULL,
  `orderDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_invoice`
--

INSERT INTO `order_invoice` (`oid`, `cid`, `gstType`, `itemTotal`, `GST`, `InvoiceTotal`, `orderDate`) VALUES
(1, 0, '', 0, 0, 0, NULL),
(2, 1, '', 0, 0, 0, NULL),
(3, 1, '', 0, 0, 0, NULL),
(4, 8, '', 0, 0, 0, NULL),
(5, 1, '', 0, 0, 0, NULL),
(6, 6, '', 0, 0, 0, NULL),
(7, 7, '', 0, 0, 0, NULL),
(8, 7, '', 0, 0, 0, NULL),
(9, 9, '', 0, 0, 0, NULL),
(10, 9, '', 0, 0, 0, NULL),
(11, 9, '', 0, 0, 0, NULL),
(12, 10, '', 0, 0, 0, NULL),
(13, 11, '', 0, 0, 0, NULL),
(14, 12, '', 0, 0, 0, NULL),
(15, 1, '', 0, 0, 0, NULL),
(16, 1, '', 0, 0, 0, NULL),
(17, 1, '', 0, 0, 0, NULL),
(18, 1, '', 0, 0, 0, NULL),
(19, 1, '', 0, 0, 0, NULL),
(20, 1, '', 0, 0, 0, NULL),
(21, 1, '', 1000, 0, 1000, NULL),
(22, 1, '1', 2030, 81, 2111, '2021-08-04'),
(23, 1, '1', 17995, 720, 18715, '2021-08-04'),
(24, 1, '', 0, 0, 0, NULL),
(25, 1, '', 0, 0, 0, NULL),
(26, 13, '', 0, 0, 0, NULL),
(27, 13, '', 0, 0, 0, NULL),
(28, 13, '2', 36000, 6480, 42480, '2021-08-05'),
(29, 1, '', 0, 0, 0, NULL),
(30, 1, '', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `name`, `price`, `qty`) VALUES
(1, 'j7', 1000, 5),
(2, 'nokia', 10, 10),
(3, 'I7 11435G', 9999, 10),
(4, 'DDR4 3200mhz', 1000, 20),
(5, 'Redmi note 7', 10000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `order_invoice`
--
ALTER TABLE `order_invoice`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `order_invoice`
--
ALTER TABLE `order_invoice`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
