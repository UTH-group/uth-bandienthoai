-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:4422
-- Thời gian đã tạo: Th10 19, 2024 lúc 02:18 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `toydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--
--
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(100) NOT NULL,
  `ward` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `nation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `address`
--

INSERT INTO `address` (`id`, `user_id`, `street`, `ward`, `district`, `city`, `nation`) VALUES
(1, 6, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 1, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 5, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 7, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 8, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 9, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 10, '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam'),
(2, 11 , '111 ABC', 'Phường 25', 'Bình Thạnh', 'Hồ Chí Minh', 'Việt Nam');

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(5, 1, 8, 1, '2024-08-15 13:27:54'),
(6, 1, 2, 2, '2024-08-15 13:27:58'),
(7, 1, 1, 5, '2024-08-15 15:01:58'),
(48, 9, 30, 1, '2024-11-13 09:09:06'),
(49, 9, 24, 1, '2024-11-13 09:16:00'),
(51, 7, 30, 1, '2024-11-13 12:09:28'),
(52, 11, 28, 1, '2024-11-18 01:52:51'),
(59, 6, 25, 1, '2024-11-18 04:23:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(3, 'Iphone', 'category for iphone'),
(4, 'Oppo', 'category for oppo'),
(6, 'SAMSUNG', 'samsung'),
(7, 'XIAOMI', 'xiaomi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `created_at`) VALUES
(44, 6, 4687000.00, 'delivered', '2024-09-01 09:48:50'),
(45, 6, 4687000.00, 'pending', '2024-09-01 09:59:46'),
(46, 6, 2316000.00, 'pending', '2024-09-09 18:19:27'),
(48, 6, 862000.00, 'pending', '2024-09-09 18:23:04'),
(49, 6, 1420000.00, 'pending', '2024-09-11 04:01:30'),
(50, 6, 336000.00, 'pending', '2024-09-11 04:03:48'),
(51, 6, 870000.00, 'pending', '2024-09-11 04:08:55'),
(52, 6, 870000.00, 'pending', '2024-09-11 04:17:37'),
(53, 6, 72000.00, 'pending', '2024-09-11 04:19:48'),
(54, 6, 119000.00, 'pending', '2024-09-11 04:25:03'),
(55, 6, 72000.00, 'pending', '2024-09-11 04:26:30'),
(56, 6, 915000.00, 'pending', '2024-09-11 04:32:01'),
(57, 6, 1220000.00, 'pending', '2024-09-11 09:48:28'),
(58, 6, 1220000.00, 'pending', '2024-09-11 09:49:59'),
(59, 6, 1220000.00, 'pending', '2024-09-11 09:51:38'),
(60, 6, 1220000.00, 'pending', '2024-09-11 09:53:29'),
(61, 6, 1223000.00, 'delivered', '2024-09-11 09:59:28'),
(62, 6, 1290000.00, 'pending', '2024-09-12 06:23:48'),
(63, 6, 690000.00, 'delivered', '2024-09-13 00:34:57'),
(64, 6, 970000.00, 'pending', '2024-09-13 00:51:19'),
(65, 6, 445000.00, 'pending', '2024-09-13 01:14:38'),
(66, 6, 1570000.00, 'pending', '2024-11-18 02:17:40'),
(67, 6, 1570000.00, 'pending', '2024-11-18 02:17:46'),
(68, 6, 1820000.00, 'pending', '2024-11-18 02:31:22'),
(69, 6, 1820000.00, 'pending', '2024-11-18 02:37:30'),
(70, 6, 1820000.00, 'pending', '2024-11-18 02:39:57'),
(71, 6, 495000.00, 'pending', '2024-11-18 02:42:47'),
(72, 6, 495000.00, 'pending', '2024-11-18 02:44:45'),
(73, 6, 170000.00, 'pending', '2024-11-18 09:24:11'),
(74, 6, 170000.00, 'pending', '2024-11-18 09:24:23'),
(75, 6, 170000.00, 'pending', '2024-11-18 09:25:02'),
(76, 6, 170000.00, 'pending', '2024-11-18 09:26:06'),
(77, 6, 170000.00, 'pending', '2024-11-18 09:28:54'),
(78, 6, 170000.00, 'pending', '2024-11-18 09:29:56'),
(79, 6, 170000.00, 'pending', '2024-11-18 09:32:30'),
(80, 6, 170000.00, 'pending', '2024-11-18 09:35:11'),
(81, 6, 170000.00, 'pending', '2024-11-18 09:35:25'),
(82, 6, 170000.00, 'pending', '2024-11-18 09:37:13'),
(83, 6, 170000.00, 'pending', '2024-11-18 09:37:24'),
(84, 6, 170000.00, 'pending', '2024-11-18 09:37:41'),
(85, 6, 170000.00, 'pending', '2024-11-18 10:00:28'),
(86, 6, 170000.00, 'pending', '2024-11-18 10:02:38'),
(87, 6, 170000.00, 'pending', '2024-11-18 10:04:35'),
(88, 6, 170000.00, '', '2024-11-18 10:08:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productorders`
--

CREATE TABLE `productorders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productorders`
--

INSERT INTO `productorders` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(44, 1, 5, 600000.00),
(44, 2, 1, 350000.00),
(44, 4, 1, 320000.00),
(44, 6, 1, 425000.00),
(44, 11, 11, 52000.00),
(45, 1, 5, 600000.00),
(45, 2, 1, 350000.00),
(45, 4, 1, 320000.00),
(45, 6, 1, 425000.00),
(45, 11, 11, 52000.00),
(46, 8, 2, 895000.00),
(46, 11, 3, 52000.00),
(46, 12, 1, 350000.00),
(48, 10, 10, 79000.00),
(48, 11, 1, 52000.00),
(49, 12, 4, 350000.00),
(50, 10, 4, 79000.00),
(51, 6, 2, 425000.00),
(52, 6, 2, 425000.00),
(53, 11, 1, 52000.00),
(54, 9, 1, 99000.00),
(55, 11, 1, 52000.00),
(56, 8, 1, 895000.00),
(57, 1, 1, 600000.00),
(57, 25, 4, 150000.00),
(58, 1, 1, 600000.00),
(58, 25, 4, 150000.00),
(59, 1, 1, 600000.00),
(59, 25, 4, 150000.00),
(60, 1, 1, 600000.00),
(60, 25, 4, 150000.00),
(61, 20, 6, 109000.00),
(61, 23, 1, 549000.00),
(62, 1, 1, 600000.00),
(62, 2, 1, 350000.00),
(62, 4, 1, 320000.00),
(63, 2, 1, 350000.00),
(63, 4, 1, 320000.00),
(64, 1, 1, 600000.00),
(64, 2, 1, 350000.00),
(65, 6, 1, 425000.00),
(66, 28, 1, 1550000.00),
(67, 28, 1, 1550000.00),
(68, 29, 1, 1800000.00),
(69, 29, 1, 1800000.00),
(70, 29, 1, 1800000.00),
(71, 30, 1, 475000.00),
(72, 30, 1, 475000.00),
(73, 25, 1, 150000.00),
(74, 25, 1, 150000.00),
(75, 25, 1, 150000.00),
(76, 25, 1, 150000.00),
(77, 25, 1, 150000.00),
(78, 25, 1, 150000.00),
(79, 25, 1, 150000.00),
(80, 25, 1, 150000.00),
(81, 25, 1, 150000.00),
(82, 25, 1, 150000.00),
(83, 25, 1, 150000.00),
(84, 25, 1, 150000.00),
(85, 25, 1, 150000.00),
(86, 25, 1, 150000.00),
(87, 25, 1, 150000.00),
(88, 25, 1, 150000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock`, `category_id`, `image_url`, `discount`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại iPhone 16 Pro Max 512GB', 'Cấu hình & Bộ nhớ Hệ điều hành: iOS 18 Chip xử lý (CPU): Apple A18 Pro 6 nhân Tốc độ CPU: Hãng không công bố Chip đồ họa (GPU): Apple GPU 6 nhân RAM: 8 GB Dung lượng lưu trữ: 512 GB Dung lượng còn lại (khả dụng) khoảng: 497 GB Danh bạ: Không giới hạn', 40990000.00, 4, 3, '../images/iphone-16-pro-max-tu-nhien-thumb-600x600.jpg', 15, '2024-08-04 05:51:38', '2024-11-13 12:52:28'),
(2, 'Điện thoại iPhone 15 128GB', 'Cấu hình & Bộ nhớ Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A16 Bionic Tốc độ CPU: 3.46 GHz Chip đồ họa (GPU): Apple GPU 5 nhân RAM: 6 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 22990000.00, 9, 3, '../images/iphone-15-hong-thumb-1-600x600.jpg', 15, '2024-08-04 05:54:38', '2024-11-13 12:53:53'),
(4, 'Điện thoại iPhone 14 128GB', 'Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A15 Bionic Tốc độ CPU: 3.22 GHz Chip đồ họa (GPU): Apple GPU 5 nhân RAM: 6 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 17390000.00, 5, 3, '../images/iPhone-14-thumb-tim-1-600x600.jpg', 12, '2024-08-04 05:55:57', '2024-11-13 12:55:06'),
(6, 'Điện thoại iPhone 13 128GB', 'Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A15 Bionic Tốc độ CPU: 3.22 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 17790000.00, 4, 3, '../images/iphone-13-starlight-1-600x600.jpg', 22, '2024-08-04 06:00:10', '2024-11-13 12:56:04'),
(8, 'Điện thoại iPhone 12 256GB', 'Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A14 Bionic Tốc độ CPU: 2 nhân 3.1 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: 241 GB Danh bạ: Không giới hạn', 16790000.00, 11, 3, '../images/iphone-12-white-600x600.jpg', 10, '2024-08-04 06:03:33', '2024-11-13 12:57:05'),
(9, 'Điện thoại iPhone 11 128GB (Hộp cũ)', 'Hệ điều hành: iOS 14 Chip xử lý (CPU): Apple A13 Bionic Tốc độ CPU: 2 nhân 2.65 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: Khoảng 123 GB Danh bạ: Không giới hạn', 12790000.00, 1, 4, '../images/iphone-11-128gb-hop-moi-292520-102500-600x600.jpg', 8, '2024-08-05 08:14:00', '2024-11-13 12:58:21'),
(10, 'Điện thoại iPhone X 256GB Silver', 'Hệ điều hành: iOS 12 Chip xử lý (CPU): Apple A11 Bionic Tốc độ CPU: 2.39 GHz Chip đồ họa (GPU): Apple GPU 3 nhân RAM: 3 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: Khoảng 249 GB Danh bạ: Không giới hạn', 9790000.00, 4, 4, '../images/iphone-x-256gb-silver-600x600-ud-600x600.jpg', 2, '2024-08-05 08:18:43', '2024-11-13 12:59:47'),
(11, 'Điện thoại Samsung Galaxy S24 Ultra 5G 256GB', 'Hệ điều hành: Android 14 Chip xử lý (CPU): Snapdragon 8 Gen 3 for Galaxy Tốc độ CPU: 3.39 GHz Chip đồ họa (GPU): Adreno 750 RAM: 12 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: 229 GB Danh bạ: Không giới hạn', 33990000.00, 4, 4, '../images/samsung-galaxy-s24-ultra-grey-thumbnew-600x600.jpg', 11, '2024-08-05 08:26:54', '2024-11-13 13:01:23'),
(12, 'Điện thoại Samsung Galaxy S23 FE 5G 8GB/128GB Tím', 'Hệ điều hành: Android 13 Chip xử lý (CPU): Exynos 2200 8 nhân Tốc độ CPU: 1 nhân 2.8 GHz, 3 nhân 2.5 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Xclipse 920 RAM: 8 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 14890000.00, 3, 4, '../images/samsung-galaxy-s23-fe-tim-thumbnew-600x600.jpg', 30, '2024-08-05 08:28:04', '2024-11-13 13:02:51'),
(13, 'Điện thoại Samsung Galaxy S22 Ultra 5G 128GB', 'Hệ điều hành: Android 12 Chip xử lý (CPU): Snapdragon 8 Gen 1 Tốc độ CPU: 1 nhân 3 GHz, 3 nhân 2.5 GHz & 4 nhân 1.79 GHz Chip đồ họa (GPU): Adreno 730 RAM: 8 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 100 GB Danh bạ: Không giới hạn', 12890000.00, 2, 4, '../images/Galaxy-S22-Ultra-Burgundy-600x600.jpg', 20, '2024-08-05 08:56:50', '2024-11-13 13:03:38'),
(20, 'Điện thoại Samsung Galaxy S21 Ultra 5G 128GB', 'Hệ điều hành: Android 11 Chip xử lý (CPU): Exynos 2100 Tốc độ CPU: 1 nhân 2.9 GHz, 3 nhân 2.8 GHz & 4 nhân 2.2 GHz Chip đồ họa (GPU): Mali-G78 MP14 RAM: 12 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 115 GB Danh bạ: Không giới hạn', 8890000.00, 7, 4, '../images/samsung-galaxy-s21-ultra-bac-600x600-1-600x600.jpg', 10, '2024-09-11 02:50:14', '2024-11-13 13:04:23'),
(21, 'Falcon Supernova iPhone 6 Pink Diamond', 'Mở đầu danh sách hôm nay là chiếc điện thoại đắt nhất thế giới hiện nay với giá lên tới 48,5 triệu USD. Giá trị của máy còn cao hơn GDP của 100 nước trên thế giới.  Chiếc iPhone 6 này được làm bằng vàng 24 carat và được nạm một viên Kim cương hồng nguyên khối rất lớn ở mặt sau. Đó là vật sở hữu quý giá của Nita Ambani, vợ của doanh nhân Ấn Độ Mukesh Ambani, người giàu nhất châu Á.  Chiếc iPhone mắc tiền nhất thế giới này cũng đi kèm với một lớp phủ bạch kim và bảo vệ chống hack. Đối với những người không đủ tiền mua iPhone 6 Pink Diamond, FALCON – công ty sản xuất đã thiết kế một những phiên bản rút gọn sử dụng kim cương cam và kim cương xanh với giá cả “phải chăng” hơn là 42,5 triệu USD (~967,1 tỉ đồng) và 32,5 triệu USD (~739,5 tỉ đồng).', 99999999.99, 1, 6, '../images/falcon-supernova-iphone-6-pink-diamond-48500000-981289.jpg', 12, '2024-09-11 08:14:46', '2024-11-13 13:06:18'),
(22, 'Điện thoại XIAOMI BLACK SHARK 4', 'Đồ chơi siêu xe ô tô điều khiển từ xa 3699-AR11 mô phỏng hình ảnh một chiếc ô tô đáng thể thao vô cùng đẹp mắt cùng lối thiết kế y như thật là món đồ chơi mà hầu hết các bé trai đều ao ước được sở hữu ít nhất một chiếc. Với tông màu đỏ nổi bật, chiếc xe ô tô điều khiển 3699-AR11 này mang lại cảm giác hào hứng cho trẻ khi được tự mình điều khiển chiếc xe của riêng mình dạo quanh nhà hay công viên.', 12990000.00, 7, 6, '../images/xiaomi-black-shark-4-600x600-600x600.jpg', 15, '2024-09-11 08:17:54', '2024-11-13 13:08:06'),
(23, 'Điện thoại Xiaomi 14T Pro 5G 12GB/256GB', '✪ Thương hiệu: BBT Global  ✪ Kích thước: 32*31*30cm , có điều khiển từ xa và cap sạc USB  ✪ Đồ chơi chất lượng cao được sản xuất theo Tiêu chuẩn Châu Âu,có chứng nhận của Tổng cục TCĐL Chất lượng, NK và PP bởi cty BBT Việt Nam, số 1 về đồ chơi trẻ em, đồ chơi cho bé an toàn, thiết bị giáo dục và thiết bị khu vui chơi giải trí', 16990000.00, 2, 6, '../images/xiaomi-14t-pro-blue-thumb-600x600.jpg', 20, '2024-09-11 08:20:03', '2024-11-13 13:09:18'),
(24, 'Điện thoại Xiaomi 14T Pro 5G 12GB/256GB', 'Hệ điều hành: Android 13 Chip xử lý (CPU): MediaTek Dimensity 9200+ 5G 8 nhân Tốc độ CPU: 1 nhân 3.35 GHz, 3 nhân 3 GHz & 4 nhân 2 GHz Chip đồ họa (GPU): Immortalis-G715 RAM: 12 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: 245 GB Danh bạ: Không giới hạn', 12890000.00, 0, 6, '../images/xiaomi-13t-pro-xanh-1-750x500.jpg', 4, '2024-09-11 08:23:02', '2024-11-13 13:10:04'),
(25, 'Điện thoại iPhone 13 128GB', 'Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A15 Bionic Tốc độ CPU: 3.22 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 17790000.00, 4, 3, '../images/iphone-13-starlight-1-600x600.jpg', 22, '2024-08-04 06:00:10', '2024-11-13 12:56:04'),
(26, 'Điện thoại iPhone 12 256GB', 'Hệ điều hành: iOS 17 Chip xử lý (CPU): Apple A14 Bionic Tốc độ CPU: 2 nhân 3.1 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: 241 GB Danh bạ: Không giới hạn', 16790000.00, 11, 3, '../images/iphone-12-white-600x600.jpg', 10, '2024-08-04 06:03:33', '2024-11-13 12:57:05'),
(27, 'Điện thoại iPhone 11 128GB (Hộp cũ)', 'Hệ điều hành: iOS 14 Chip xử lý (CPU): Apple A13 Bionic Tốc độ CPU: 2 nhân 2.65 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Apple GPU 4 nhân RAM: 4 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: Khoảng 123 GB Danh bạ: Không giới hạn', 12790000.00, 1, 4, '../images/iphone-11-128gb-hop-moi-292520-102500-600x600.jpg', 8, '2024-08-05 08:14:00', '2024-11-13 12:58:21'),
(28, 'Điện thoại iPhone X 256GB Silver', 'Hệ điều hành: iOS 12 Chip xử lý (CPU): Apple A11 Bionic Tốc độ CPU: 2.39 GHz Chip đồ họa (GPU): Apple GPU 3 nhân RAM: 3 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: Khoảng 249 GB Danh bạ: Không giới hạn', 9790000.00, 4, 4, '../images/iphone-x-256gb-silver-600x600-ud-600x600.jpg', 2, '2024-08-05 08:18:43', '2024-11-13 12:59:47'),
(29, 'Điện thoại Samsung Galaxy S24 Ultra 5G 256GB', 'Hệ điều hành: Android 14 Chip xử lý (CPU): Snapdragon 8 Gen 3 for Galaxy Tốc độ CPU: 3.39 GHz Chip đồ họa (GPU): Adreno 750 RAM: 12 GB Dung lượng lưu trữ: 256 GB Dung lượng còn lại (khả dụng) khoảng: 229 GB Danh bạ: Không giới hạn', 33990000.00, 4, 4, '../images/samsung-galaxy-s24-ultra-grey-thumbnew-600x600.jpg', 11, '2024-08-05 08:26:54', '2024-11-13 13:01:23'),
(30, 'Điện thoại Samsung Galaxy S23 FE 5G 8GB/128GB Tím', 'Hệ điều hành: Android 13 Chip xử lý (CPU): Exynos 2200 8 nhân Tốc độ CPU: 1 nhân 2.8 GHz, 3 nhân 2.5 GHz & 4 nhân 1.8 GHz Chip đồ họa (GPU): Xclipse 920 RAM: 8 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 113 GB Danh bạ: Không giới hạn', 14890000.00, 3, 4, '../images/samsung-galaxy-s23-fe-tim-thumbnew-600x600.jpg', 30, '2024-08-05 08:28:04', '2024-11-13 13:02:51'),
(31, 'Điện thoại Samsung Galaxy S22 Ultra 5G 128GB', 'Hệ điều hành: Android 12 Chip xử lý (CPU): Snapdragon 8 Gen 1 Tốc độ CPU: 1 nhân 3 GHz, 3 nhân 2.5 GHz & 4 nhân 1.79 GHz Chip đồ họa (GPU): Adreno 730 RAM: 8 GB Dung lượng lưu trữ: 128 GB Dung lượng còn lại (khả dụng) khoảng: 100 GB Danh bạ: Không giới hạn', 12890000.00, 2, 4, '../images/Galaxy-S22-Ultra-Burgundy-600x600.jpg', 20, '2024-08-05 08:56:50', '2024-11-13 13:03:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(3, 1, 6, 1, 'xấu quá', '2024-09-10 17:43:06'),
(4, 2, 6, 5, 've ri gụt', '2024-09-11 09:19:30'),
(5, 20, 6, 5, 'ờ mây dìn gút chóp =)))', '2024-09-11 10:01:57'),
(6, 4, 6, 2, 'xau quac', '2024-09-13 00:36:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `gender` enum('Nam','Nữ') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `pob` int(11) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `gender`, `birthday`, `pob`, `role`, `created_at`) VALUES
(1, 'user1', 'user1@gmail.com', 'user1', 'user', 'user', '', NULL, NULL, NULL, 'customer', '2024-08-04 07:56:25'),
(5, 'admin', 'admin@gmail.com', '$2y$10$vEz36OGErLyATKQaA0vuQeGv.E6CyhtVOyJGczHbj2NrAParEN.3q', 'Nguyễn Văn', 'C', '0123456789', 'Nữ', '2000-07-20', 1, 'admin', '2024-08-16 11:20:54'),
(6, 'user2', 'user2@gmail.com', '$2y$10$vEbLAij/I8NvoxJCx6B/S.y2lyTE2xV4LTXmtWqNdEAG04fWKz7Aa', 'Nguyễn Văn', 'B', '0112233444', 'Nam', '2000-02-04', 4, 'customer', '2024-08-16 11:22:59'),
(7, 'user3', 'user3@gmail.com', '$2y$10$75j7a3n23fqLEY2NX8gm8OvP6QRjx2iLKiPFgydtcrKpXn37nRDbi', 'user3', 'user3', '', NULL, NULL, NULL, 'customer', '2024-09-13 00:30:47'),
(8, 'test', 'test@gmail.com', '$2y$10$hPqmY8sceKFE.5gL0DZDF.DOiJm8DDNfayo.EUhHqcsuXf1gH4ZFO', 'abc', 'def', '', NULL, NULL, NULL, 'customer', '2024-11-13 07:47:19'),
(9, 'abc', 'abc@gmail.com', '$2y$10$Wc5tpKe1/PjIWyiNGRc9Qu.ZZAdiPJ7JvcyY6rmOEMAn5.5An2XxS', 'ab', 'abc', '', NULL, NULL, NULL, 'customer', '2024-11-13 09:08:41'),
(10, 'qwe', 'qwe@gmail.com', '$2y$10$pkV6tsrpSng2sQQ59uE9UOVsUdKiiikD7R7NEn..CyMDw2Q3QVDQW', 'qwe', 'qwe', '', NULL, NULL, NULL, 'customer', '2024-11-13 09:41:24'),
(11, 'user10', 'user10@gmail.com', '$2y$10$aqVrKhrizDNkw0HIdSEPGuQ6A5aH/YyhPIpwnxPPlVnnx5uoAvlBq', 'user10', '10', '', NULL, NULL, NULL, 'customer', '2024-11-18 01:51:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `productorders`
--
ALTER TABLE `productorders`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `productorders`
--
ALTER TABLE `productorders`
  ADD CONSTRAINT `productorders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `productorders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
