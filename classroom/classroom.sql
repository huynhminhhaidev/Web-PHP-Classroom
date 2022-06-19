-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 02, 2020 lúc 01:16 PM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `classroom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `birthday` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activated` bit(1) DEFAULT b'0',
  `activate_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `email`, `fullname`, `birthday`, `phone`, `password`, `activated`, `activate_token`) VALUES
('admin', 'huynhminhhai1555@gmail.com', 'Huỳnh Minh Hải', '2000-12-12', '0907412333', '$2y$10$wX/tHSrAgSXl0bs7Z20aBeWPjXa9flSwQFpC7.mEj495cRu2cceci', b'1', ''),
('minhhai', 'huynhminhhai1555555@gmail.com', 'Huynh Minh Hai', '2000-12-12', '0848551555', '$2y$10$8EF6GftYoJuvFa.5LK4tBegiJ5MAv9E/QBqhv.lUh6HF6wgWYC7/S', b'1', ''),
('taichodien', 'Tainguyen1122000@gmail.com', 'Nguyễn Tấn Tài', '2000-01-07', '0909000113', '$2y$10$kc0G9yq/wIlj/LQ7bW5Evex1MfZVTiIGGXZ3VaVAS459W2lFctwCu', b'1', 'd0501fcf054bb87d8ba53f247d0ff81b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `classcode` varchar(4) NOT NULL,
  `classname` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `classroom` varchar(255) NOT NULL,
  `teachername` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`id`, `classcode`, `classname`, `subject`, `classroom`, `teachername`, `avatar`, `username`) VALUES
(32, '6586', 'Web cơ bản', 'Web', 'P001', 'Huynh Minh Hai', 'img/1.jpg', 'minhhai'),
(33, '4675', 'Web nâng cao', 'Web', 'P002', 'Huynh Minh Hai', 'img/logo.png', 'minhhai');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`id`, `share_id`, `username`, `comment`, `time`) VALUES
(5, 32, 'minhhai', 'ok', '28-11-2020'),
(6, 45, 'minhhai', 'haha', '28-11-2020'),
(8, 32, 'taichodien', 'ok nha', '28-11-2020');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `privi`
--

CREATE TABLE `privi` (
  `id` int(11) NOT NULL,
  `privileges` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `uri_match` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `privi`
--

INSERT INTO `privi` (`id`, `privileges`, `name`, `uri_match`) VALUES
(1, 1, 'Quản lý tài khoản', 'Manager-Account\\.php$'),
(2, 2, 'Quản lý lớp học', 'Manager-Class\\.php$');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `privileges`
--

INSERT INTO `privileges` (`id`, `name`, `position`) VALUES
(1, 'Tài khoản', '1'),
(2, 'Lớp học', '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('huynhminhhai1555555@gmail.com', 'f09e355dd8789f19431349a8f52949f0', 1604136941);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `share_something`
--

CREATE TABLE `share_something` (
  `id` int(11) NOT NULL,
  `classcode` varchar(4) NOT NULL,
  `content` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `share_something`
--

INSERT INTO `share_something` (`id`, `classcode`, `content`, `file`, `time`) VALUES
(32, '6586', 'Hi All!', 'img/ariana.jpg', '26-11-2020'),
(34, '4675', 'Hello all!', 'img/main.py', '26-11-2020'),
(36, '4675', 'https://www.youtube.com/watch?v=qIHzBVb6ujI', '', '26-11-2020'),
(38, '4675', '', 'img/watch[1]', '26-11-2020'),
(45, '6586', 'It\'s oke', 'img/TIỂU-LUẬN-WEB.docx', '26-11-2020'),
(49, '6586', 'Hello all!', 'img/51800143_lab9.py', '27-11-2020');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sv_class`
--

CREATE TABLE `sv_class` (
  `id` int(11) NOT NULL,
  `classcode` varchar(4) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sv_class`
--

INSERT INTO `sv_class` (`id`, `classcode`, `username`) VALUES
(25, '6586', 'taichodien'),
(34, '4675', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_privileges`
--

CREATE TABLE `user_privileges` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `privileges` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user_privileges`
--

INSERT INTO `user_privileges` (`id`, `user`, `privileges`) VALUES
(38, 'minhhai', 2),
(44, 'admin', 1),
(45, 'admin', 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classcode` (`classcode`),
  ADD KEY `uername` (`username`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_id` (`share_id`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `privi`
--
ALTER TABLE `privi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privileges` (`privileges`);

--
-- Chỉ mục cho bảng `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `share_something`
--
ALTER TABLE `share_something`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classcode` (`classcode`);

--
-- Chỉ mục cho bảng `sv_class`
--
ALTER TABLE `sv_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classcode` (`classcode`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `privileges` (`privileges`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `privi`
--
ALTER TABLE `privi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `share_something`
--
ALTER TABLE `share_something`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `sv_class`
--
ALTER TABLE `sv_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`share_id`) REFERENCES `share_something` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `privi`
--
ALTER TABLE `privi`
  ADD CONSTRAINT `privi_ibfk_1` FOREIGN KEY (`privileges`) REFERENCES `privileges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `share_something`
--
ALTER TABLE `share_something`
  ADD CONSTRAINT `share_something_ibfk_1` FOREIGN KEY (`classcode`) REFERENCES `class` (`classcode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sv_class`
--
ALTER TABLE `sv_class`
  ADD CONSTRAINT `sv_class_ibfk_1` FOREIGN KEY (`classcode`) REFERENCES `class` (`classcode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD CONSTRAINT `user_privileges_ibfk_1` FOREIGN KEY (`privileges`) REFERENCES `privi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_privileges_ibfk_2` FOREIGN KEY (`user`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
