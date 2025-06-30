-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2025 at 08:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exjo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `notes` text,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `destination_id`, `booking_date`, `notes`, `status`) VALUES
(3, 3, 24, '2025-06-30', 'apateu apateu', 'Terima'),
(4, 3, 26, '2025-06-30', 'apateu apateu', 'Terima'),
(5, 4, 19, '2025-06-30', 'ak mw ke prambanan with u', 'Terima'),
(6, 4, 8, '2025-06-26', 'd', 'Pending'),
(7, 4, 24, '2025-07-22', 'coba', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `received_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `received_at`) VALUES
(1, '', '', '', '', '2025-06-16 14:14:16'),
(2, '', '', '', '', '2025-06-16 14:14:17'),
(3, '', '', '', '', '2025-06-16 15:22:03'),
(4, '', 'test@test.com', '', '', '2025-06-16 16:14:23'),
(5, 'ronaldo', 'test@test.com', 'testtt', 'pesanku aku mw ayam geprek sepuluh', '2025-06-16 16:15:36'),
(6, '', 'test@test.com', '', '', '2025-06-16 17:26:23'),
(7, '', '', '', '', '2025-06-17 15:24:07'),
(8, '', '', '', '', '2025-06-17 15:24:46'),
(9, '', '', '', '', '2025-06-17 15:24:53'),
(10, 'rose', 'rose@test.com', '123', 'test coba', '2025-06-17 15:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text,
  `price` int DEFAULT '0',
  `image_path` varchar(255) DEFAULT NULL,
  `package_type` enum('Regular','VIP') NOT NULL DEFAULT 'Regular',
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `location`, `description`, `price`, `image_path`, `package_type`, `link`) VALUES
(1, 'Kebun Binatang Gembira Loka', 'Yogyakarta', 'Kebun Binatang Gembira Loka adalah kebun binatang yang menawarkan berbagai wahana rekreasi, koleksi satwa, dan fasilitas yang lengkap.', 60000, 'img/assets/yk/gembiraloka/cover.jpg', 'VIP', 'https://maps.app.goo.gl/LB2NwJLciaZfkzrLA'),
(2, 'HeHa Ocean View', 'Gunung Kidul', 'HeHa Ocean adalah destinasi wisata populer di tepi pantai selatan Yogyakarta, menawarkan pemandangan laut yang memukau.', 25000, 'img/assets/gk/hehaocean/cover.jpeg', 'Regular', 'https://maps.app.goo.gl/Qeh35uCeZw1YaVtz6'),
(3, 'Museum Ullen Sentalu', 'Sleman', 'Museum Ullen Sentalu adalah museum yang menampilkan koleksi seni dan budaya Jawa, dengan arsitektur yang unik.', 50000, 'img/assets/sl/ullensentanu/cover.jpg', 'Regular', 'https://maps.app.goo.gl/MFQZd79HhgftdnsRA'),
(4, 'Pantai Glagah Indah', 'Kulon Progo', 'Pantai glagah indah adalah pantai di pesisir Samudra Hindia yang terkenal dengan ombak besar dan laguna yang luas.', 10000, 'img/assets/kp/glagah/cover.jpg', 'Regular', 'https://maps.app.goo.gl/Av5j14eqRJnn4Mqy5'),
(5, 'Lembah Oyo', 'Bantul', 'Lembah Oyo menawarkan pengalaman wisata sungai yang unik dengan berbagai aktivitas seperti susur sungai dengan kano, berenang, dan camping.', 10000, 'img/assets/ba/lembahoyo/cover.jpg', 'Regular', 'https://maps.app.goo.gl/FdvzAU3aqirRzm648'),
(6, 'Goa Cerme', 'Bantul', 'Goa Cerme adalah gua bersejarah yang juga menjadi tempat wisata religi dan petualangan.', 10000, 'img/assets/ba/goacerme/cover.jpg', 'Regular', 'https://maps.app.goo.gl/VxeW1v2LRDbuKFSu9'),
(7, 'Pantai Parangtritis', 'Bantul', 'Pantai Parangtritis adalah pantai yang dikenal dengan pasir hitamnya yang luas, ombak besar, dan pemandangan matahari terbenam yang indah.', 15000, 'img/assets/ba/parangtritis/cover.jpg', 'Regular', 'https://maps.app.goo.gl/Wq7ZEx7sYxDxdtpt9'),
(8, 'Buah Mangunan', 'Bantul', 'Buah Mangunan juga dikenal sebagai Negeri Atas Awan yang terkenal dengan pemandangan alamnya yang menakjubkan.', 40000, 'img/assets/ba/buahmangunan/cover.jpg', 'VIP', 'https://maps.app.goo.gl/asCtTbzLREpTjWJ18'),
(9, 'Puncak Sosok', 'Bantul', 'Puncak Sosok adalah destinasi wisata puncak yang menawarkan pemandangan indah, udara sejuk, dan berbagai fasilitas yang memadai.', 45000, 'img/assets/ba/puncaksosok/cover.jpg', 'VIP', 'https://maps.app.goo.gl/NwP7Dj3TSTzM7nN19'),
(10, 'Goa Pindul', 'Gunung Kidul', 'Goa Pindul memiliki panjang sekitar 350 meter dan lebar 5 meter, serta terkenal dengan keindahan stalaktit dan stalakmitnya. ', 35000, 'img/assets/gk/goapindul/cover.jpeg', 'VIP', 'https://maps.app.goo.gl/EzT6MBTcu4oNJxQ88'),
(11, 'Gunung Api Purba Nglanggeran', 'Gunung Kidul', 'Gunung ini terkenal dengan formasi batuan unik yang didominasi oleh aglomerat dan breksi gunung api, serta pemandangan alam yang indah.', 50000, 'img/assets/gk/nglanggeran/cover.jpg', 'VIP', 'https://maps.app.goo.gl/W8ixKFPZ5kDuCUoe6'),
(12, 'Pantai Drini', 'Gunung Kidul', 'Pantai ini terkenal dengan pasir putihnya yang lembut, air laut yang jernih, dan pemandangan alam yang menakjubkan.', 25000, 'img/assets/gk/pantaidrini/cover.jpg', 'Regular', 'https://maps.app.goo.gl/K8YNkYDjKXa62mUZA'),
(13, 'Bukit Paralayang', 'Gunung Kidul', 'Bukit Paralayang adalah sebuah bukit yang terkenal sebagai tempat wisata, khususnya untuk olahraga paralayang, dan juga menawarkan pemandangan alam yang indah.', 35000, 'img/assets/gk/paralayang/cover.jpg', 'Regular', 'https://maps.app.goo.gl/NArWW7BhvAEYx4vs6'),
(14, 'Waduk Sermo', 'Kulon Progo', 'Waduk Sermo selain berfungsi sebagai sumber irigasi dan pengendali banjir juga menjadi daya tarik wisata alam yang populer di Kulon Progo.', 25000, 'img/assets/kp/waduksermo/cover.jpeg', 'Regular', 'https://maps.app.goo.gl/ok8mGSVcfZHERBGH7'),
(15, 'Sungai Mudal', 'Kulon Progo', 'Sungai ini terkenal dengan mata airnya yang jernih dan mengalir sepanjang tahun, serta pemandangan alam yang asri.', 30000, 'img/assets/kp/sungaimudal/cover.jpg', 'VIP', 'https://maps.app.goo.gl/gafScYBMrhPauF4JA'),
(16, 'Mangrove Forest Wana Tirta', 'Kulon Progo', 'Hutan mangrove ini menawarkan pemandangan hijau pepohonan mangrove yang asri, serta keindahan pantai yang mempesona.', 20000, 'img/assets/kp/mangroveforest/cover.jpeg', 'Regular', 'https://maps.app.goo.gl/mMZ5cU9KAaW1ahaX7'),
(17, 'Kedung Pedut', 'Kulon Progo', 'Kedung Pedut adalah destinasi wisata alam di Kulon Progo, Yogyakarta, yang terkenal dengan airnya yang memiliki dua warna, yaitu putih dan tosca.', 35000, 'img/assets/kp/kedungpedut/cover.jpg', 'VIP', 'https://maps.app.goo.gl/AoyCQ4qqJPiv8ViZ7'),
(18, 'Heha Forest', 'Sleman', 'HeHa Forest merupakan tempat wisata yang menyuguhkan suasana yang sejuk dan asri.', 50000, 'img/assets/sl/hehaforest/cover.jpg', 'VIP', 'https://maps.app.goo.gl/QQRpMgA91xdNKR5o6'),
(19, 'Candi Prambanan', 'Sleman', 'Candi Prambanan adalah kompleks candi Hindu terbesar di Indonesia, yang dibangun pada abad ke-9 Masehi. Candi ini didedikasikan untuk Trimurti, tiga dewa utama Hindu: Brahma, Wisnu, dan Siwa.', 50000, 'img/assets/sl/prambanan/cover.jpg', 'VIP', 'https://maps.app.goo.gl/Nx7M4xFafDWfyiyTA'),
(20, 'Obelix Hills', 'Sleman', 'Tempat ini menawarkan pemandangan alam perbukitan batu dengan berbagai spot foto Instagramable dan fasilitas seperti restoran, area parkir, toilet, dan mushola. Obelix Hills juga terkenal dengan pemandangan matahari terbenamnya yang indah. ', 45000, 'img/assets/sl/obelixhills/cover.jpg', 'VIP', 'https://maps.app.goo.gl/2yTzmECZMA2hAhEB7'),
(21, 'Lava Tour Merapi', 'Sleman', 'Lava Tour Merapi adalah kegiatan wisata yang mengajak pengunjung untuk menjelajahi area sekitar Gunung Merapi, terutama bekas area yang terdampak erupsi pada tahun 2010, dengan menggunakan mobil jeep.', 450000, 'img/assets/sl/lavatour/cover.jpg', 'VIP', 'https://maps.app.goo.gl/c3WutkYGL3viodtM8'),
(22, 'Malioboro', 'Yogyakarta', 'Kawasan ini terkenal sebagai pusat budaya dan perekonomian, serta menjadi tempat favorit bagi wisatawan dan warga lokal. Malioboro membentang dari Tugu Yogyakarta hingga Titik Nol Kilometer.', 10000, 'img/assets/yk/malioboro/cover.png', 'Regular', 'https://maps.app.goo.gl/xXBeS1Dc1fVnn4G7A'),
(23, 'Taman Pintar', 'Yogyakarta', 'Taman Pintar Yogyakarta adalah taman dan museum bertema sains untuk anak-anak dan tempat untuk berekspresi, berapresiasi, berkreasi dalam suasana yang menyenangkan.', 60000, 'img/assets/yk/taman pintar/cover.jpg', 'VIP', 'https://maps.app.goo.gl/1ayNYE8ywDjx5YxP9'),
(24, 'Jogja National Museum (JNM)', 'Yogyakarta', 'Jogja National Museum (JNM) adalah museum dan galeri seni kontemporer yang berlokasi di Yogyakarta. JNM bukan museum tradisional, melainkan ruang publik yang menjadi pusat aktivitas seni dan budaya.', 30000, 'img/assets/yk/jnm/cover.jpg', 'Regular', 'https://maps.app.goo.gl/pzVb2czBAntgcY3D9'),
(25, 'Benteng Vredeburg', 'Yogyakarta', 'Benteng Vredeburg merupakan salah satu bangunan yang menjadi saksi bisu peristiwa-peristiwa bersejarah yang terjadi di Yogyakarta semenjak pemerintah kolonial Belanda masuk ke Yogyakarta.', 25000, 'img/assets/yk/vredeburg/cover.jpg', 'Regular', 'https://maps.app.goo.gl/5vdAtv6rCNk6gish8'),
(26, 'Taman Sari', 'Yogyakarta', 'Taman Sari adalah kompleks bekas taman kerajaan yang dulunya merupakan tempat peristirahatan dan rekreasi Sultan Yogyakarta, serta berfungsi sebagai tempat ibadah dan pertahanan.', 25000, 'img/assets/yk/tamansari/cover.jpg', 'Regular', 'https://maps.app.goo.gl/4BtJAFy5FhvkfTLMA');

-- --------------------------------------------------------

--
-- Table structure for table `detail_image`
--

CREATE TABLE `detail_image` (
  `id` int NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `destinations_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_image`
--

INSERT INTO `detail_image` (`id`, `path`, `destinations_id`) VALUES
(1, 'img/assets/yk/gembiraloka/1.jpg', 1),
(2, 'img/assets/yk/gembiraloka/2.jpg', 1),
(3, 'img/assets/yk/gembiraloka/3.jpg', 1),
(4, 'img/assets/yk/gembiraloka/4.jpg', 1),
(5, 'img/assets/yk/gembiraloka/5.jpg', 1),
(6, 'img/assets/yk/vredeburg/1.jpg', 25),
(7, 'img/assets/yk/vredeburg/2.jpg', 25),
(8, 'img/assets/yk/vredeburg/3.jpg', 25),
(9, 'img/assets/yk/vredeburg/4.jpg', 25),
(10, 'img/assets/yk/vredeburg/5.jpg', 25),
(11, 'img/assets/ba/buahmangunan/1.jpg', 8),
(12, 'img/assets/ba/buahmangunan/2.jpg', 8),
(13, 'img/assets/ba/buahmangunan/3.jpg', 8),
(14, 'img/assets/ba/buahmangunan/4.jpg', 8),
(15, 'img/assets/ba/buahmangunan/5.jpg', 8),
(16, 'img/assets/gk/paralayang/1.jpg', 13),
(17, 'img/assets/gk/paralayang/2.jpg', 13),
(18, 'img/assets/gk/paralayang/3.png', 13),
(19, 'img/assets/gk/paralayang/4.jpg', 13),
(20, 'img/assets/gk/paralayang/5.jpg', 13),
(21, 'img/assets/sl/prambanan/1.jpg', 19),
(22, 'img/assets/sl/prambanan/2.jpeg', 19),
(23, 'img/assets/sl/prambanan/3.jpg', 19),
(24, 'img/assets/sl/prambanan/4.jpg', 19),
(25, 'img/assets/sl/prambanan/5.jpg', 19),
(26, 'img/assets/ba/goacerme/1.jpg', 6),
(27, 'img/assets/ba/goacerme/2.jpg', 6),
(28, 'img/assets/ba/goacerme/3.jpg', 6),
(29, 'img/assets/ba/goacerme/4.jpg', 6),
(30, 'img/assets/ba/goacerme/5.jpeg', 6),
(31, 'img/assets/gk/goapindul/6.jpg', 10),
(32, 'img/assets/gk/goapindul/7.jpg', 10),
(33, 'img/assets/gk/goapindul/8.jpeg', 10),
(34, 'img/assets/gk/goapindul/9.jpeg', 10),
(35, 'img/assets/gk/goapindul/10.jpeg', 10),
(36, 'img/assets/gk/gunungapipurbanglanggeran/1.jpg', 11),
(37, 'img/assets/gk/gunungapipurbanglanggeran/2.jpg', 11),
(38, 'img/assets/gk/gunungapipurbanglanggeran/3.jpg', 11),
(39, 'img/assets/gk/gunungapipurbanglanggeran/4.jpg', 11),
(40, 'img/assets/gk/gunungapipurbanglanggeran/5.jpg', 11),
(41, 'img/assets/sl/hehaforest/6.jpg', 18),
(42, 'img/assets/sl/hehaforest/7.jpg', 18),
(43, 'img/assets/sl/hehaforest/8.jpg', 18),
(44, 'img/assets/sl/hehaforest/9.jpg', 18),
(45, 'img/assets/sl/hehaforest/10.jpg', 18),
(46, 'img/assets/gk/hehaoceanview/1.jpeg', 2),
(47, 'img/assets/gk/hehaoceanview/2.jpg', 2),
(48, 'img/assets/gk/hehaoceanview/3.jpg', 2),
(49, 'img/assets/gk/hehaoceanview/4.jpg', 2),
(50, 'img/assets/gk/hehaoceanview/5.jpg', 2),
(51, 'img/assets/yk/jogjanationalmuseum(jnm)/1.jpeg', 24),
(52, 'img/assets/yk/jogjanationalmuseum(jnm)/2.jpg', 24),
(53, 'img/assets/yk/jogjanationalmuseum(jnm)/3.jpg', 24),
(54, 'img/assets/yk/jogjanationalmuseum(jnm)/4.jpg', 24),
(55, 'img/assets/yk/jogjanationalmuseum(jnm)/5.jpg', 24),
(56, 'img/assets/kp/kedungpedut/6.jpg', 17),
(57, 'img/assets/kp/kedungpedut/7.jpg', 17),
(58, 'img/assets/kp/kedungpedut/8.jpg', 17),
(59, 'img/assets/kp/kedungpedut/9.jpg', 17),
(60, 'img/assets/kp/kedungpedut/10.jpg', 17),
(61, 'img/assets/sl/lavatourmerapi/1.jpg', 21),
(62, 'img/assets/sl/lavatourmerapi/2.jpg', 21),
(63, 'img/assets/sl/lavatourmerapi/3.jpg', 21),
(64, 'img/assets/sl/lavatourmerapi/4.jpg', 21),
(65, 'img/assets/sl/lavatourmerapi/5.jpg', 21),
(66, 'img/assets/ba/lembahoyo/6.jpg', 5),
(67, 'img/assets/ba/lembahoyo/7.jpg', 5),
(68, 'img/assets/ba/lembahoyo/8.jpg', 5),
(69, 'img/assets/ba/lembahoyo/9.jpg', 5),
(70, 'img/assets/ba/lembahoyo/10.jpg', 5),
(71, 'img/assets/yk/malioboro/6.jpg', 22),
(72, 'img/assets/yk/malioboro/7.jpg', 22),
(73, 'img/assets/yk/malioboro/8.jpg', 22),
(74, 'img/assets/yk/malioboro/9.jpg', 22),
(75, 'img/assets/yk/malioboro/10.jpg', 22),
(76, 'img/assets/kp/mangroveforest/6.jpg', 16),
(77, 'img/assets/kp/mangroveforest/7.jpg', 16),
(78, 'img/assets/kp/mangroveforest/8.jpg', 16),
(79, 'img/assets/kp/mangroveforest/9.jpg', 16),
(80, 'img/assets/kp/mangroveforest/10.jpg', 16),
(81, 'img/assets/sl/museumullensentalu/1.jpg', 3),
(82, 'img/assets/sl/museumullensentalu/2.jpg', 3),
(83, 'img/assets/sl/museumullensentalu/3.jpg', 3),
(84, 'img/assets/sl/museumullensentalu/4.jpg', 3),
(85, 'img/assets/sl/museumullensentalu/5.jpg', 3),
(86, 'img/assets/sl/obelixhills/6.jpeg', 20),
(87, 'img/assets/sl/obelixhills/7.jpg', 20),
(88, 'img/assets/sl/obelixhills/8.jpg', 20),
(89, 'img/assets/sl/obelixhills/9.jpg', 20),
(90, 'img/assets/sl/obelixhills/10.jpeg', 20),
(91, 'img/assets/gk/pantaidrini/6.jpg', 12),
(92, 'img/assets/gk/pantaidrini/7.png', 12),
(93, 'img/assets/gk/pantaidrini/8.jpg', 12),
(94, 'img/assets/gk/pantaidrini/9.jpg', 12),
(95, 'img/assets/gk/pantaidrini/10.jpg', 12),
(96, 'img/assets/kp/pantaiglagahindah/1.jpg', 4),
(97, 'img/assets/kp/pantaiglagahindah/2.jpg', 4),
(98, 'img/assets/kp/pantaiglagahindah/3.png', 4),
(99, 'img/assets/kp/pantaiglagahindah/4.jpg', 4),
(100, 'img/assets/kp/pantaiglagahindah/5.jpg', 4),
(101, 'img/assets/ba/pantaiparangtritis/1.jpg', 7),
(102, 'img/assets/ba/pantaiparangtritis/2.jpg', 7),
(103, 'img/assets/ba/pantaiparangtritis/3.jpg', 7),
(104, 'img/assets/ba/pantaiparangtritis/4.jpg', 7),
(105, 'img/assets/ba/pantaiparangtritis/5.jpg', 7),
(106, 'img/assets/ba/puncaksosok/6.jpeg', 9),
(107, 'img/assets/ba/puncaksosok/7.jpg', 9),
(108, 'img/assets/ba/puncaksosok/8.jpg', 9),
(109, 'img/assets/ba/puncaksosok/9.jpg', 9),
(110, 'img/assets/ba/puncaksosok/10.jpg', 9),
(111, 'img/assets/kp/sungaimudal/6.jpg', 15),
(112, 'img/assets/kp/sungaimudal/7.jpg', 15),
(113, 'img/assets/kp/sungaimudal/8.jpg', 15),
(114, 'img/assets/kp/sungaimudal/9.jpg', 15),
(115, 'img/assets/kp/sungaimudal/10.jpg', 15),
(116, 'img/assets/yk/tamanpintar/1.jpeg', 23),
(117, 'img/assets/yk/tamanpintar/2.jpg', 23),
(118, 'img/assets/yk/tamanpintar/3.jpg', 23),
(119, 'img/assets/yk/tamanpintar/4.jpeg', 23),
(120, 'img/assets/yk/tamanpintar/5.jpg', 23),
(121, 'img/assets/yk/tamansari/6.jpg', 26),
(122, 'img/assets/yk/tamansari/7.jpg', 26),
(123, 'img/assets/yk/tamansari/8.jpg', 26),
(124, 'img/assets/yk/tamansari/9.jpg', 26),
(125, 'img/assets/yk/tamansari/10.jpg', 26),
(126, 'img/assets/kp/waduksermo/6.jpeg', 14),
(127, 'img/assets/kp/waduksermo/7.jpg', 14),
(128, 'img/assets/kp/waduksermo/8.jpg', 14),
(129, 'img/assets/kp/waduksermo/9.jpg', 14),
(130, 'img/assets/kp/waduksermo/10.jpeg', 14);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password_hash`, `phone`, `created_at`) VALUES
(1, 'Ronaldo', 'Siu', 'test@test.com', '$2y$10$v8ouZJoE8RE.2WSnFETGl.6UL9/QrJN.rB8hxOlFx/PUPBHzsk5jS', '08123456789', '2025-06-15 14:22:10'),
(2, 'tessss', '', 'test123@gmail.com', '$2y$10$iVy57UXU1rXRxZMcR2SaxucM7NDnFE5/BLFJbElyQFdNE3bblQXGu', '081111111111', '2025-06-15 15:21:04'),
(3, 'Kak Ros', '', 'rose@test.com', '$2y$10$Gw6hAmQymVPEPX1XexSjPuAkPMKwlgQjVL9e4A6wJBEG1pCPdsswq', '0812345678', '2025-06-17 04:34:40'),
(4, 'Mimar', '', 'mimar@test.com', '$2y$10$5UGyaAFmVDQmsWbwaNHJdeY3rY5qeykxMiJUJB7WGxWl3gtYIYa4O', '0812345678', '2025-06-18 06:12:26'),
(5, 'Windi', 'Basudari', 'windi@test.com', '$2y$10$OtQSBP8QH0hMLtBRM257r.TWJEOQtdcqC6/.2ceEQ9hif9o0PHAuy', NULL, '2025-06-18 09:46:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_image`
--
ALTER TABLE `detail_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_correct_destinations_id` (`destinations_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `detail_image`
--
ALTER TABLE `detail_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detail_image`
--
ALTER TABLE `detail_image`
  ADD CONSTRAINT `detail_image_ibfk_1` FOREIGN KEY (`destinations_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_correct_destinations_id` FOREIGN KEY (`destinations_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
