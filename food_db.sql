-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 05:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_db`
--
DROP DATABASE IF EXISTS `food_db`;
CREATE DATABASE IF NOT EXISTS `food_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `food_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(3, 'Sandun', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(12, 5, 8, 'Pizza', 15, 3, 'pizza-1.png'),
(13, 5, 9, 'Sandun', 54, 1, 'dessert-3.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(3, 3, 'Maisie Keith', '258', 'tukobyc@mailinator.com', 'paytm', 'Amet ipsum aute proident consequatur reprehende, Omnis cillum fugit duis cupiditate velit, Quos sed modi sit sapiente non rem temporibus mini, Dolor doloremque ad fuga Dolor iste rerum quia, Sunt quidem voluptatum enim veritatis, Aliquip qui quia nesciunt quod, Distinctio Aut aperiam cupiditate ut quaerat - 840848', 'gsgd g (457 x 2) - ', 914, '2024-05-12', 'completed'),
(5, 5, 'Sandun', '0772152084', 'sandun@gmail.com', 'credit card', 'dss, hjg, hj, hjgjg, jgjgj, gg, uiui - 1245', 'Ice Cream (12 x 2) - ', 24, '2024-05-13', 'completed'),
(6, 5, 'Sandun', '0772152084', 'sandun@gmail.com', 'cash on delivery', 'dss, hjg, hj, hjgjg, jgjgj, gg, uiui - 1245', 'Ice Cream (12 x 4) - ', 48, '2024-05-13', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `image`) VALUES
(7, 'Ice Cream', 'Best Ice cream ever', 'desserts', 12, 'dessert-6.png'),
(8, 'Pizza', 'ghdh ys  ', 'fast food', 15, 'pizza-1.png'),
(9, 'Sandun', 'dsd', 'drinks', 54, 'dessert-3.png'),
(10, 'ad', 'adda', 'fast food', 44, 'dessert-4.png'),
(11, 'admin', 'asa', 'drinks', 44, 'drink-3.png'),
(12, 'dsds', 'sd', 'drinks', 54, 'dessert-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(2, 'Denise Higgins', 'wumykyti@mailinator.com', '832', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', ''),
(3, 'Maisie Keith', 'tukobyc@mailinator.com', '258', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Amet ipsum aute proident consequatur reprehende, Omnis cillum fugit duis cupiditate velit, Quos sed modi sit sapiente non rem temporibus mini, Dolor doloremque ad fuga Dolor iste rerum quia, Sunt quidem voluptatum enim veritatis, Aliquip qui quia nesciunt quod, Distinctio Aut aperiam cupiditate ut quaerat - 840848'),
(4, 'Tyler Swanson', 'gosebocu@mailinator.com', '813', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'Architecto incidunt et sunt perferendis ipsum quo, Dicta autem sed sed qui esse libero natus eu earu, Obcaecati libero quaerat et sit accusamus ea volu, Est aliquip blanditiis culpa hic porro ex illum e, Quibusdam ipsum perferendis sunt in qui optio ips, Eveniet quos veritatis tempore nihil veniam id, Et consequatur enim vel aperiam - 653622'),
(5, 'Sandun', 'sandun@gmail.com', '0772152084', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'dss, hjg, hj, hjgjg, jgjgj, gg, uiui - 1245'),
(6, 'Kai Hawkins', 'sisy@mailinator.com', '140', '487543ff6dfc8ff4527f76f6b61c9c9061365820', 'w, h, hjg, jk, jk, jk, jk - 47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
