-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2020 at 08:34 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payment_gateways`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `transaction_amount` float NOT NULL DEFAULT '0',
  `currency` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `transaction_type`, `transaction_amount`, `currency`, `created_date`) VALUES
(1, 'PAYID-LY4XABI9L056668B81719641', 'paypal', 50, 'USD', '2020-02-04 18:22:35'),
(2, 'PAYID-LY4XGUQ30M72649AJ069992D', 'paypal', 48, 'USD', '2020-02-04 18:37:12'),
(3, 'PAYID-LY4YHGA71347118C2617963P', 'paypal', 46, 'USD', '2020-02-04 19:46:35'),
(5, 'txn_1G8TeoG7NX29bIhTuwVGqV1c', 'stripe', 60, 'USD', '2020-02-04 20:49:50'),
(6, 'txn_1G8TpBG7NX29bIhT92Jmb5wm', 'stripe', 18, 'USD', '2020-02-04 21:00:33'),
(7, 'txn_1G8X4cG7NX29bIhTOJCsnL4J', 'stripe', 45, 'USD', '2020-02-05 00:28:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
