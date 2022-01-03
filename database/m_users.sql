-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 03, 2022 lúc 05:55 PM
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
  `del_flag` int(11) DEFAULT 0,
  `ins_id` int(11) NOT NULL,
  `ins_datetime` datetime NOT NULL,
  `upd_datetime` datetime DEFAULT NULL,
  `upd_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `role`, `avatar`, `password`, `del_flag`, `ins_id`, `ins_datetime`, `upd_datetime`, `upd_id`) VALUES
(30, 'Phạm Hoài Nam', 'namph.paraline@gmail.com', 'Super Admin', '1639966019_5.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2021-12-29 10:17:06', 30),
(35, 'Nguyễn Văn C', 'nvc@gmail.com', 'Super Admin', '1640769685_5.jpg', '202cb962ac59075b964b07152d234b70', 1, 0, '2021-12-23 15:20:17', '2021-12-29 10:33:04', 30),
(36, 'Nguyễn Văn B', 'nvb@gmail.com', 'Admin', '1641218047_images (3).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2022-01-03 14:54:07', 49),
(37, 'Nguyễn Văn A', 'nva@gmail.com', 'Admin', '1640155773_images.png', 'd41d8cd98f00b204e9800998ecf8427e', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(38, 'Phạm Hoài Nam', 'nam@gmail.com', 'Super Admin', '1640155387_images (4).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2022-01-03 15:20:41', 49),
(39, 'Phạm Hoài Nam 1', 'nam1@gmail.com', 'Super Admin', '1639250233_images.jpg', 'd41d8cd98f00b204e9800998ecf8427e', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(40, 'Nguyễn Thị Hoa', 'hoa@gmail.com', 'Super Admin', '1641219686_images (2).jpg', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, '2021-12-23 15:20:17', '2022-01-03 15:21:26', 49),
(41, 'Nguyễn Văn D', 'nvd@gmail.com', 'Super Admin', '1639554820_imager_163772.jpg', '202cb962ac59075b964b07152d234b70', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(42, 'Nguyễn Văn Hùng', 'hung@gmail.com', 'Super Admin', '1639555209_5.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(43, 'Nguyễn Xuân Kiên', 'kien@gmail.com', 'Super Admin', '1641220995_tải xuống (1).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2022-01-03 15:43:15', 45),
(44, 'Nguyễn Bảo Thảo Lâm', 'thao@gmail.com', 'Admin', '1639555267_images (1).jpg', 'd41d8cd98f00b204e9800998ecf8427e', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(45, 'Nguyễn Nhật Minh', 'minh@gmail.com', 'Super Admin', '1639985436_4.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(46, 'Nguyễn Thanh Dũng', 'dung@gmail.com', 'Admin', '1639555599_2.jpg', '202cb962ac59075b964b07152d234b70', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(47, 'Nguyễn Thị Thảo', 'thaont@gmail.com', 'Admin', '1639970181_4.jpg', '202cb962ac59075b964b07152d234b70', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(49, 'Nguyễn Bảo Lâm', 'lam@gmail.com', 'Super Admin', '1640679729_5.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2021-12-28 09:22:09', 42),
(51, 'Trần Văn Cường', 'cuong@gmail.com', 'Admin', '1639982611_5.jpg', '202cb962ac59075b964b07152d234b70', 1, 0, '2021-12-23 15:20:17', NULL, NULL),
(52, 'Nguyễn Ngọc Mai', 'mai@gmail.com', 'Super Admin', '1640679841_4.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2021-12-28 09:24:01', 42),
(53, 'Trần Văn Đại', 'dai@gmail.com', 'Admin', '1640155350_images (3).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(54, 'Nguyễn Văn Hải', 'hai@gmail.com', 'Admin', '1640165860_tải xuống (1).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(55, 'Nguyễn Thị Hợp', 'hop@gmail.com', 'Admin', '1640233349_images (5).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(59, 'Nguyễn Thị Lâm Hoa', 'lamhoa@gmail.com', 'Super Admin', '1640679373_tải xuống.jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', '2021-12-28 09:16:13', 42),
(60, 'Nguyễn Văn Quảng', 'quang@gmail.com', 'Admin', '1640246925_images (6).jpg', '202cb962ac59075b964b07152d234b70', 0, 0, '2021-12-23 15:20:17', NULL, NULL),
(69, 'Nguyễn Quốc Việt', 'viet@gmail.com', 'Admin', '1640250594_images (4).jpg', '202cb962ac59075b964b07152d234b70', 0, 30, '2021-12-23 10:09:54', NULL, NULL),
(70, 'Nguyễn Việt Hoàng', 'hoang@gmail.com', 'Admin', '1640250923_5.jpg', '202cb962ac59075b964b07152d234b70', 0, 30, '2021-12-23 10:15:23', NULL, NULL),
(74, 'Cà Thi Vân', 'van@gmail.com', 'Admin', '1640339718_tải xuống.jpg', '202cb962ac59075b964b07152d234b70', 0, 30, '2021-12-24 10:55:18', NULL, NULL),
(76, 'Nguyễn Trường Giang', 'giang@gmail.com', 'Super Admin', '1640768423_images (3).jpg', '202cb962ac59075b964b07152d234b70', 0, 30, '2021-12-29 10:00:23', NULL, NULL),
(77, 'Phạm Ngọc Đạt', 'dat@gmail.com', 'Admin', '1640770536_images (1).png', '202cb962ac59075b964b07152d234b70', 0, 52, '2021-12-29 10:35:36', NULL, NULL),
(78, 'Nguyễn Văn Quân', 'quan@gmail.com', 'Super Admin', '1640913709_images (3).png', 'e10adc3949ba59abbe56e057f20f883e', 0, 49, '2021-12-31 02:18:50', '2021-12-31 02:43:55', 49),
(79, 'Nguyễn Văn Test', 'test@gmail.com', 'Super Admin', '1641221040_images.png', '202cb962ac59075b964b07152d234b70', 1, 45, '2022-01-03 15:44:00', NULL, NULL);

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
  `del_flag` int(11) NOT NULL DEFAULT 0,
  `ins_id` int(11) DEFAULT NULL,
  `upd_id` int(11) DEFAULT NULL,
  `ins_datetime` datetime DEFAULT NULL,
  `upd_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `avatar`, `del_flag`, `ins_id`, `upd_id`, `ins_datetime`, `upd_datetime`) VALUES
(1, 'Nguyễn Văn D', 'nvb@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'Active', '1640913958_4.jpg', 0, NULL, 30, NULL, '2022-01-01 19:48:06'),
(3, 'Nguyễn Văn C', 'nvc@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', '1640155826_images (6).jpg', 1, NULL, NULL, NULL, NULL),
(4, 'Phạm Hoài Nam', 'nam@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1641067395_images (3).png', 0, NULL, 30, NULL, '2022-01-03 14:49:07'),
(6, 'Nguyễn Văn ABC', 'nva@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1640789016_4.jpg', 1, NULL, 30, NULL, '2021-12-29 15:43:36'),
(9, 'Nguyễn Bảo Thảo', 'thao@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1641220715_images (1).jpg', 0, NULL, 36, NULL, '2022-01-03 15:38:56'),
(10, 'Nguyễn Bảo Thảo Lâm', 'baothao@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', '1641219765_images (1).png', 0, NULL, 49, NULL, '2022-01-03 15:22:45'),
(11, 'Phạm Văn Dũng', 'dung@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', 'test.jpg', 0, NULL, 30, NULL, '2021-12-26 18:21:27'),
(12, 'Nguyễn Phi Hùng', 'hung@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1640572329_images (3).jpg', 0, 30, 30, '2021-12-26 18:07:34', '2021-12-27 03:32:09'),
(15, 'Nguyễn Thị Huệ', 'hue@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1640661654_images (1).jpg', 0, 30, 30, '2021-12-28 04:20:20', '2021-12-28 04:21:35'),
(17, 'Nguyễn Bảo Thảo', 'bkevqyfbfy_1640682275@tfbnw.net', NULL, 'Banned', '102144559016764.jpg', 0, 9999, NULL, '2021-12-28 10:17:30', NULL),
(18, 'Nguyễn Thị Hoa', 'open_zdmtxqo_user@tfbnw.net', NULL, 'Banned', '103699852178570.jpg', 0, 9999, NULL, '2021-12-28 10:19:17', NULL),
(21, 'Nguyễn Bảo Lâm', 'jbnncsfiud_1639620252@tfbnw.net', NULL, 'Banned', '108478738372052.jpg', 0, 9999, NULL, '2021-12-28 10:41:27', NULL),
(29, 'Nguyễn Văn E', 'nve@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1640772633_images (1).jpg', 0, 52, NULL, '2021-12-29 11:10:33', NULL),
(30, 'Nguyễn Hồng Phong', 'phong@gmail.com', '202cb962ac59075b964b07152d234b70', 'Banned', '1640789089_images (4).jpg', 0, 30, NULL, '2021-12-29 15:44:49', NULL),
(31, 'Phạm Mai Hoa', '', NULL, 'Banned', '103306218899652.jpg', 1, 30, NULL, '2021-12-29 16:15:45', NULL),
(32, 'Phạm Nam', 'phnam0306@gmail.com', '', 'Banned', '745489819743039.jpg', 0, 30, 30, '2021-12-29 16:48:13', '2022-01-02 11:08:32'),
(33, 'Đặng Văn Quỳnh', 'quynh@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1640922720_tải xuống (1).jpg', 0, 49, 78, '2021-12-31 02:27:19', '2021-12-31 04:52:00'),
(34, 'Bảo Lâm', 'baolam12a2610@gmail.com', NULL, 'Banned', '1519451428434543.jpg', 0, 9999, NULL, '2021-12-31 04:47:52', NULL),
(35, 'Nguyễn Văn Test', 'test@gmail.com', '202cb962ac59075b964b07152d234b70', 'Active', '1641220786_images (4).jpg', 1, 36, NULL, '2022-01-03 15:39:46', NULL),
(37, 'Phạm Hoài Nam', 'phnam03062000@gmail.com', NULL, 'Banned', '969945653934717.jpg', 0, 9999, NULL, '2022-01-03 15:55:17', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
