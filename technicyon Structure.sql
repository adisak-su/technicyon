-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 11:29 AM
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
-- Database: `technicyonnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL DEFAULT 'Adisak',
  `lastName` varchar(50) NOT NULL DEFAULT 'Supatanasinkasem',
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT 'adisak@gmail.com',
  `permission` varchar(50) NOT NULL,
  `image` varchar(256) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `firstName`, `lastName`, `username`, `password`, `email`, `permission`, `image`, `status`, `create_at`, `updated_at`) VALUES
(1, 'Adisak', 'Supatanasinkasem', 'Q', 'q', 'adisak@gmail.com', 'superadmin', '0-1702177770.jpg', 1, '2023-05-30 20:24:59', '2023-05-30 20:24:59'),
(2, 'Adisak', 'Supatanasinkasem', 'admin', '123', 'adisak@gmail.com', 'superadmin', '0-1702177770.jpg', 1, '2023-12-10 10:09:30', '2025-07-15 15:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `colorname`
--

CREATE TABLE `colorname` (
  `colorId` int(11) NOT NULL,
  `colorname` varchar(20) DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT '-',
  `telephone` varchar(25) NOT NULL DEFAULT '-',
  `discount` double NOT NULL DEFAULT 0,
  `type` varchar(1) NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_changes`
--

CREATE TABLE `data_changes` (
  `id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` varchar(20) NOT NULL,
  `action` enum('CREATE','UPDATE','DELETE') NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `changed_by` int(11) NOT NULL,
  `data_before` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_before`)),
  `data_after` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_after`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupname`
--

CREATE TABLE `groupname` (
  `groupId` int(11) NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoiceId` varchar(10) NOT NULL,
  `customerId` varchar(10) NOT NULL,
  `myreference` varchar(10) NOT NULL DEFAULT '-',
  `mydate` datetime NOT NULL,
  `receivedate` datetime DEFAULT NULL,
  `total` double NOT NULL DEFAULT 0,
  `mystring` varchar(120) NOT NULL DEFAULT '-',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `mycount` int(11) NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderhead`
--

CREATE TABLE `orderhead` (
  `orderId` varchar(10) NOT NULL,
  `customerId` varchar(10) NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `vatvalue` double NOT NULL DEFAULT 0,
  `mystring` varchar(256) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `orderId` varchar(10) NOT NULL,
  `productId` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_head`
--

CREATE TABLE `order_head` (
  `orderId` varchar(10) NOT NULL,
  `myreference` varchar(10) DEFAULT NULL,
  `mydate` datetime NOT NULL,
  `customerId` varchar(10) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vatvalue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `nettotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mystring` varchar(120) NOT NULL DEFAULT '-',
  `status` varchar(1) NOT NULL DEFAULT '1',
  `invoiceId` varchar(10) DEFAULT NULL,
  `typesale` varchar(1) NOT NULL DEFAULT '1',
  `details` text NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `storeMax` smallint(6) NOT NULL DEFAULT 0,
  `storeMin` smallint(6) NOT NULL DEFAULT 0,
  `storeFront` smallint(6) NOT NULL DEFAULT 0,
  `storeBack` smallint(6) NOT NULL DEFAULT 0,
  `priceInv` varchar(8) NOT NULL,
  `priceFront` double NOT NULL DEFAULT 0,
  `priceBack` double NOT NULL DEFAULT 0,
  `priceShop` double NOT NULL DEFAULT 0,
  `location` varchar(20) DEFAULT NULL,
  `typename` varchar(50) DEFAULT NULL,
  `groupname` varchar(50) DEFAULT NULL,
  `suppliername` varchar(50) DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receive_detail`
--

CREATE TABLE `receive_detail` (
  `receiveId` varchar(10) NOT NULL,
  `productId` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `qty` smallint(6) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receive_head`
--

CREATE TABLE `receive_head` (
  `receiveId` varchar(10) NOT NULL,
  `reference` varchar(10) NOT NULL DEFAULT '-',
  `mydate` datetime NOT NULL,
  `supplierId` varchar(10) NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `nettotal` double NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierId` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tablestatus`
--

CREATE TABLE `tablestatus` (
  `tableId` int(11) NOT NULL,
  `tableName` varchar(256) NOT NULL,
  `insertTime` datetime NOT NULL DEFAULT current_timestamp(),
  `updateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technical`
--

CREATE TABLE `technical` (
  `orderId` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technicalname`
--

CREATE TABLE `technicalname` (
  `technicalId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typename`
--

CREATE TABLE `typename` (
  `typeId` int(11) NOT NULL,
  `typename` varchar(50) NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usercar`
--

CREATE TABLE `usercar` (
  `carId` varchar(20) NOT NULL,
  `groupname` varchar(50) DEFAULT NULL,
  `colorname` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `mile` varchar(10) DEFAULT NULL,
  `birthday` varchar(10) DEFAULT '-',
  `year` varchar(10) DEFAULT '-',
  `vehicleId` varchar(50) DEFAULT '-',
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usercar_detail`
--

CREATE TABLE `usercar_detail` (
  `orderId` varchar(10) NOT NULL,
  `productId` varchar(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usercar_head`
--

CREATE TABLE `usercar_head` (
  `orderId` varchar(10) NOT NULL,
  `myreference` varchar(10) NOT NULL DEFAULT '0',
  `mydate` datetime NOT NULL,
  `carId` varchar(10) NOT NULL,
  `mile` varchar(10) DEFAULT NULL,
  `total` double NOT NULL DEFAULT 0,
  `vatvalue` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `nettotal` double NOT NULL DEFAULT 0,
  `mystring` varchar(120) NOT NULL DEFAULT '-',
  `status` varchar(1) NOT NULL DEFAULT '1',
  `invoiceId` varchar(10) NOT NULL,
  `typesale` varchar(1) NOT NULL DEFAULT '1',
  `technicalname` varchar(50) DEFAULT NULL,
  `details` text NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `company` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `vat` smallint(6) DEFAULT 0,
  `customerId` int(11) DEFAULT 0,
  `supplierId` int(11) DEFAULT 0,
  `orderId_front` int(11) DEFAULT 0,
  `orderId_back` int(11) DEFAULT 0,
  `orderId_shop` int(11) DEFAULT 0,
  `receiveId` int(11) DEFAULT 0,
  `invoiceId` int(11) DEFAULT 0,
  `teeno` int(11) DEFAULT 0,
  `teedate` datetime DEFAULT NULL,
  `teeno2` int(11) DEFAULT 0,
  `resetYear` varchar(4) DEFAULT NULL,
  `pw1` varchar(10) DEFAULT NULL,
  `pw2` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`company`, `address`, `telephone`, `vat`, `customerId`, `supplierId`, `orderId_front`, `orderId_back`, `orderId_shop`, `receiveId`, `invoiceId`, `teeno`, `teedate`, `teeno2`, `resetYear`, `pw1`, `pw2`) VALUES
('Adisak Supatanasinkasem', '119/259 หมู่บ้านสินธานี\r\nบางกะปิ กทม.', '12345678900', 7, 10013, 520, 94, 92674, 19289, 8, 28, 5883, '2015-03-21 00:00:00', 3360, '2025', '2468', '4979');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `colorname`
--
ALTER TABLE `colorname`
  ADD PRIMARY KEY (`colorId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `data_changes`
--
ALTER TABLE `data_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groupname`
--
ALTER TABLE `groupname`
  ADD PRIMARY KEY (`groupId`),
  ADD UNIQUE KEY `groupname` (`groupname`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoiceId`),
  ADD KEY `invoice_customer` (`customerId`);

--
-- Indexes for table `orderhead`
--
ALTER TABLE `orderhead`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`orderId`,`productId`);

--
-- Indexes for table `order_head`
--
ALTER TABLE `order_head`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `productgroupname` (`groupname`),
  ADD KEY `productname` (`name`),
  ADD KEY `producttypename` (`typename`),
  ADD KEY `supplierId` (`suppliername`);

--
-- Indexes for table `receive_detail`
--
ALTER TABLE `receive_detail`
  ADD PRIMARY KEY (`receiveId`,`productId`);

--
-- Indexes for table `receive_head`
--
ALTER TABLE `receive_head`
  ADD PRIMARY KEY (`receiveId`),
  ADD KEY `receive_head_supplier` (`supplierId`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierId`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tablestatus`
--
ALTER TABLE `tablestatus`
  ADD PRIMARY KEY (`tableId`);

--
-- Indexes for table `technical`
--
ALTER TABLE `technical`
  ADD UNIQUE KEY `idx_orderId` (`orderId`);

--
-- Indexes for table `technicalname`
--
ALTER TABLE `technicalname`
  ADD PRIMARY KEY (`technicalId`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `typename`
--
ALTER TABLE `typename`
  ADD PRIMARY KEY (`typeId`),
  ADD UNIQUE KEY `typename` (`typename`);

--
-- Indexes for table `usercar`
--
ALTER TABLE `usercar`
  ADD PRIMARY KEY (`carId`);

--
-- Indexes for table `usercar_detail`
--
ALTER TABLE `usercar_detail`
  ADD KEY `idx_orderId` (`orderId`),
  ADD KEY `idx_productId` (`productId`);

--
-- Indexes for table `usercar_head`
--
ALTER TABLE `usercar_head`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `customerId` (`carId`),
  ADD KEY `idx_invoiceId` (`invoiceId`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`company`),
  ADD KEY `idx_customerId` (`customerId`),
  ADD KEY `idx_invoiceId` (`invoiceId`),
  ADD KEY `idx_receiveId` (`receiveId`),
  ADD KEY `idx_supplierId` (`supplierId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colorname`
--
ALTER TABLE `colorname`
  MODIFY `colorId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_changes`
--
ALTER TABLE `data_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupname`
--
ALTER TABLE `groupname`
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tablestatus`
--
ALTER TABLE `tablestatus`
  MODIFY `tableId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technicalname`
--
ALTER TABLE `technicalname`
  MODIFY `technicalId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typename`
--
ALTER TABLE `typename`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_customer` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customerId`) ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_head_order_detail` FOREIGN KEY (`orderId`) REFERENCES `order_head` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receive_detail`
--
ALTER TABLE `receive_detail`
  ADD CONSTRAINT `_5eff23f0-1bf3-46d9-9f74-35bf9d0cc926_` FOREIGN KEY (`receiveId`) REFERENCES `receive_head` (`receiveId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `receive_head`
--
ALTER TABLE `receive_head`
  ADD CONSTRAINT `receive_head_supplier` FOREIGN KEY (`supplierId`) REFERENCES `supplier` (`supplierId`) ON UPDATE CASCADE;

--
-- Constraints for table `usercar_detail`
--
ALTER TABLE `usercar_detail`
  ADD CONSTRAINT `usercar_head_usercar_detail` FOREIGN KEY (`orderId`) REFERENCES `usercar_head` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
