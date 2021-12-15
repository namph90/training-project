-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 15, 2021 lúc 10:02 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `m_users`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `del_flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `role`, `avatar`, `password`, `del_flag`) VALUES
(30, 'Phạm Hoài Nam', 'namph.paraline@gmail.com', 'Super Admin', '1639032251_hinh-nen-3d-cho-may-tinh-cuc-dep-8.jpg', '202cb962ac59075b964b07152d234b70', 0),
(35, 'Nguyễn Văn C', 'nvc@gmail.com', 'Admin', '1639032272_vu-tru1.jpg', 'd41d8cd98f00b204e9800998ecf8427e', 0),
(36, 'Nguyễn Văn B', 'nvb@gmail.com', 'Admin', '1639032284_logo.jpg', 'd41d8cd98f00b204e9800998ecf8427e', 0),
(37, 'Nguyễn Văn A', 'nva@gmail.com', 'Admin', '1639032342_imager_163772.jpg', 'd41d8cd98f00b204e9800998ecf8427e', 0),
(38, 'Phạm Hoài Nam', 'nam@gmail.com', 'Admin', '1639031884_images.jpg', '202cb962ac59075b964b07152d234b70', 0),
(39, 'Phạm Hoài Nam 1', 'nam1@gmail.com', 'Super Admin', '1639250233_images.jpg', 'd41d8cd98f00b204e9800998ecf8427e', 1),
(40, 'Nguyễn Thị Hoa', 'hoa@gmail.com', 'Admin', '1639554770_91cd19b23307cc92da34e8167b947fef.jpg', '202cb962ac59075b964b07152d234b70', 0),
(41, 'Nguyễn Văn D', 'nvd@gmail.com', 'Super Admin', '1639554820_imager_163772.jpg', '202cb962ac59075b964b07152d234b70', 0),
(42, 'Nguyễn Văn Hùng', 'hung@gmail.com', 'Super Admin', '1639555209_5.jpg', '202cb962ac59075b964b07152d234b70', 0),
(43, 'Nguyễn Xuân Kiên', 'kien@gmail.com', 'Admin', '1639555241_4.jpg', '202cb962ac59075b964b07152d234b70', 0),
(44, 'Nguyễn Bảo Thảo', 'thao@gmail.com', 'Admin', '1639555267_images (1).jpg', '202cb962ac59075b964b07152d234b70', 0),
(45, 'Nguyễn Nhật Minh', 'minh@gmail.com', 'Super Admin', '1639555308_images (2).jpg', '202cb962ac59075b964b07152d234b70', 0),
(46, 'Nguyễn Thanh Dũng', 'dung@gmail.com', 'Admin', '1639555599_2.jpg', '202cb962ac59075b964b07152d234b70', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Banned',
  `avatar` text DEFAULT NULL,
  `del_flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `avatar`, `del_flag`) VALUES
(2, 'Nguyễn Văn D', 'nvb@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'Active', '1639024250_hinh-nen-galaxy-may-tinh-6.jpg', 1),
(3, 'Nguyễn Văn C', 'nvc@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', '1639044295_vu-tru1.jpg', 0),
(4, 'Phạm Nam', 'nam@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', '1639393754_imager_163772.jpg', 0),
(5, 'Phạm Nam', 'phnam0306@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '745234846435203.jpg', 0),
(6, 'Nguyễn Văn A', 'nva@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1639555735_5.jpg', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
