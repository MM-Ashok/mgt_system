-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 02:09 PM
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
-- Database: `library_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_book`
--

CREATE TABLE `tbl_book` (
  `id` int(11) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `isbnno` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `publisher` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  `quantity` varchar(250) NOT NULL,
  `place` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `availability` tinyint(4) NOT NULL COMMENT '1=available, 0=not available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_book`
--

INSERT INTO `tbl_book` (`id`, `book_name`, `isbnno`, `author`, `publisher`, `price`, `quantity`, `place`, `category`, `availability`, `created_at`) VALUES
(1, 'c++', '123654789', 'Santa Rosa, CA', 'Santa Rosa, CA', '10', '3', 'chandigarh', 'programming', 1, '2024-12-12 12:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, 'programming', 1, '2024-12-12 05:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_issue`
--

CREATE TABLE `tbl_issue` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `issue_date` varchar(250) NOT NULL,
  `due_date` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT '0' COMMENT '3=request sent, 1=accept, 2=reject',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_lost` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_issue`
--

INSERT INTO `tbl_issue` (`id`, `book_id`, `user_id`, `user_name`, `issue_date`, `due_date`, `status`, `created_at`, `is_lost`) VALUES
(3, 1, 5, 'monika', '2024-12-12', '2025-03-12', '1', '2024-12-12 12:39:36', 0),
(7, 1, 7, 'moni', '2024-12-12', '2025-03-12', '1', '2024-12-12 12:42:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'chandigarh', 1, '2024-12-12 05:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lost_books`
--

CREATE TABLE `tbl_lost_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `lost_date` date NOT NULL,
  `fine_amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_lost_books`
--

INSERT INTO `tbl_lost_books` (`id`, `user_id`, `book_id`, `lost_date`, `fine_amount`, `status`) VALUES
(1, 7, 1, '2024-12-12', 0.00, 1),
(2, 7, 1, '2024-12-12', 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return`
--

CREATE TABLE `tbl_return` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `return_date` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_return`
--

INSERT INTO `tbl_return` (`id`, `book_id`, `user_id`, `user_name`, `return_date`, `created_at`) VALUES
(1, 1, 2, 'monika', '2024-12-12', '2024-12-12 05:02:56'),
(2, 1, 7, 'moni', '2024-12-12', '2024-12-12 09:08:51'),
(3, 1, 7, 'moni', '2024-12-12', '2024-12-12 09:21:30'),
(4, 1, 7, 'moni', '2024-12-12', '2024-12-12 12:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `emailid` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` tinyint(4) NOT NULL COMMENT '1=admin, 2=user',
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_name`, `emailid`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin', 'admin@library.com', '6b8d5de3b53751bac499eb1bef762a2a', 1, 1, '2023-05-27 13:29:44'),
(7, 'moni', 'devcoder4822@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '2024-12-12 07:58:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_book`
--
ALTER TABLE `tbl_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_issue`
--
ALTER TABLE `tbl_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lost_books`
--
ALTER TABLE `tbl_lost_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `tbl_return`
--
ALTER TABLE `tbl_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_book`
--
ALTER TABLE `tbl_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_issue`
--
ALTER TABLE `tbl_issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_lost_books`
--
ALTER TABLE `tbl_lost_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_return`
--
ALTER TABLE `tbl_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_lost_books`
--
ALTER TABLE `tbl_lost_books`
  ADD CONSTRAINT `tbl_lost_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_lost_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `tbl_book` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
