-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2020 at 08:11 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Appetizer'),
(2, 'Main Course'),
(3, 'Dessert'),
(4, 'Beverages'),
(5, 'Promo'),
(6, 'Dine In Only'),
(7, 'Test Category');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` int(11) NOT NULL,
  `menu_discount` int(11) NOT NULL,
  `menu_final_price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `menu_picture` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_price`, `menu_discount`, `menu_final_price`, `category_id`, `menu_picture`, `status`) VALUES
(26, 'Krabby Patty', 25000, 0, 25000, 2, 'Krabby_Patty1.jpg', 1),
(27, 'Kelp Shake', 10000, 0, 10000, 4, 'Kelp_Shake.png', 1),
(29, 'Chum Stick', 20000, 25, 15000, 1, 'Chum1.jpg', 1),
(30, 'Krusty Dogs', 10000, 0, 10000, 1, 'Krusty_Dogs.png', 0),
(31, 'Kiddy Meals', 45000, 50, 22500, 2, 'faf9e89cf335697486505a6b6afe2fb7.png', 1),
(35, 'Krabby Pizza', 60000, 15, 51000, 2, '082b6d38648ea7d32adb01acf1e8e19a.png', 1),
(36, 'Kelp Nougat Crunch', 10000, 0, 10000, 3, '80a09b275c8efd6caff0f76b738ad308.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_notes` varchar(255) DEFAULT NULL,
  `order_subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `transaction_id`, `menu_id`, `order_quantity`, `order_notes`, `order_subtotal`) VALUES
(3, 12313123, 30, 1, '', 10000),
(4, 12313123, 27, 1, '', 10000),
(5, 12313123, 36, 1, '', 10000),
(6, 12313123, 29, 1, '', 15000),
(90, 412312, 36, 2, '', 20000),
(99, 412312, 29, 3, '', 45000),
(104, 412312, 27, 1, '', 10000),
(106, 200415131021, 29, 2, '', 30000),
(107, 200415131021, 26, 1, '', 25000),
(108, 200415131021, 27, 2, '', 20000),
(113, 200415131957, 29, 1, '', 15000),
(114, 200415131957, 36, 1, '', 10000),
(115, 200415131957, 26, 1, '', 25000),
(116, 200415131021, 35, 1, '', 51000),
(117, 200416203515, 29, 2, '', 30000),
(118, 200416203515, 36, 1, '', 10000),
(119, 200416204738, 29, 1, '', 15000),
(120, 200416204738, 27, 1, '', 10000),
(121, 200416204738, 35, 2, '', 102000),
(127, 200504124438, 27, 1, NULL, 10000),
(128, 200504124438, 26, 1, NULL, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `method_id` int(11) DEFAULT NULL,
  `payment_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `transaction_id`, `method_id`, `payment_amount`) VALUES
(6, 412312, 1, 50000),
(7, 412312, 3, 16500),
(11, 200415131021, 2, 50000),
(13, 200415131957, 1, 55000),
(14, 200415131021, 1, 88600),
(15, 200416203515, 1, 40000),
(16, 200416203515, 2, 4000),
(17, 200416204738, 1, 100000),
(18, 200416204738, 2, 40000),
(26, 200504124438, 1, 30000),
(27, 200504124438, 2, 8500);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `method_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`method_id`, `method_name`, `status`) VALUES
(1, 'Cash', 1),
(2, 'Go-Pay', 1),
(3, 'Dana', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` bigint(20) NOT NULL,
  `transaction_total` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `transaction_payment` int(11) NOT NULL,
  `transaction_change` int(11) NOT NULL,
  `transaction_open_bill` datetime DEFAULT current_timestamp(),
  `transaction_close_bill` datetime DEFAULT NULL,
  `transaction_receipt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `transaction_total`, `customer_name`, `customer_phone`, `customer_email`, `transaction_payment`, `transaction_change`, `transaction_open_bill`, `transaction_close_bill`, `transaction_receipt`) VALUES
(412312, 82500, 'Calvin Lazuardi', '', 'calvin.lazuardi@binus.ac.id', 66500, -5000, '2020-03-31 21:32:25', '2020-04-16 20:34:52', ''),
(12313123, 50000, 'Najib', '0811232001', NULL, 100000, 50000, '2020-03-31 21:18:47', '2020-03-31 21:18:47', ''),
(200415131021, 138600, 'Farrel', '', 'farrelnajib@gmail.com', 138600, 0, '2020-04-15 13:10:21', '2020-04-16 20:34:48', ''),
(200415131957, 55000, 'Farrel', '', 'farrelnajib@gmail.com', 55000, 0, '2020-04-15 13:19:57', '2020-04-16 20:34:37', ''),
(200416203515, 44000, 'Customer 3', '', 'customer3@binus.ac.id', 44000, 0, '2020-04-16 20:35:15', '2020-04-16 20:36:26', ''),
(200416204738, 139700, 'Customer 5', '08112233', '', 140000, 300, '2020-04-16 20:47:38', '2020-04-16 20:49:39', ''),
(200504124438, 38500, NULL, NULL, NULL, 38500, 0, '2020-05-04 12:44:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `role_id`) VALUES
(1, 'Farrel Najib Anshary', 'farrelnajib@gmail.com', '$2y$10$6BhwUy4vVNr91DrdmEaKVuKDntYBMtMv2kQdMuTYlER6CeTU/O222', 1),
(2, 'Cul', 'calvin.lazuardi@binus.ac.id', '$2y$10$LmXOM0/qFU6h.z.nw8WyQ.NVFPR95.B1YyHLMdHmLS2m.U8OhfzIy', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200504124439;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
