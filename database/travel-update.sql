-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2023 at 06:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int(11) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `tempat_wisata_id` int(11) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `tempat_wisata_id`, `last_activity`) VALUES
(2, 'Parkir', 1, '2023-12-07 12:35:30'),
(3, 'Toilet', 1, '2023-12-07 12:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `deskripsi`, `image`, `last_activity`) VALUES
(1, 'Pantai', 'Destinasi wisata pantai merupakan tempat yang menawarkan keindahan alam yang memikat dengan pasir putih, ombak yang berirama, dan langit biru yang menyegarkan. Pantai sering dihubungkan dengan ketenangan dan kebebasan, menciptakan lingkungan santai yang ideal untuk beristirahat dan menikmati keindahan alam. Pemandangan matahari terbenam di sepanjang garis pantai menjadi momen magis, memberikan pengalaman romantis yang tak terlupakan.\r\n\r\nSelain keindahan alamnya, destinasi pantai juga menyediakan berbagai aktivitas rekreasi, seperti snorkeling, selancar, atau hanya berjemur di bawah sinar matahari. Keanekaragaman ekosistem laut di sekitar pantai juga menarik bagi para penyelam dan pecinta alam bawah laut. Dengan fasilitas wisata yang berkembang di sekitar pantai, pengunjung dapat merasakan keseimbangan antara relaksasi dan petualangan. Melalui destinasi wisata pantai, seseorang dapat menggabungkan keindahan alam laut, kegiatan rekreasi, dan kebersamaan dalam satu pengalaman liburan yang serba menyenangkan.', 'pantai.jpg', '2023-12-10 15:23:01'),
(2, 'Gunung', 'Destinasi wisata gunung menawarkan pengalaman luar biasa yang menawarkan keindahan alam yang memukau dan tantangan pendakian yang menguji keterampilan fisik dan mental. Puncak gunung memberikan pemandangan spektakuler, melibatkan lembah hijau, danau menakjubkan, serta hutan yang menghijau. Pendakian gunung bukan hanya sekadar tantangan fisik, tetapi juga menghadirkan keberagaman flora dan fauna di ekosistem pegunungan. Keanekaragaman hayati ini menjadi daya tarik tersendiri, memungkinkan pengunjung untuk mengeksplorasi kehidupan liar yang unik. Selain itu, destinasi gunung juga mencakup interaksi dengan keanekaragaman budaya masyarakat lokal dan tanggung jawab untuk menjaga kelestarian alam. Dengan sumber air yang melimpah, ekosistem yang kaya, dan kehidupan budaya yang beragam, destinasi ini memberikan pengalaman holistik yang melibatkan petualangan, keindahan alam, dan kepedulian terhadap lingkungan.', 'gunung.jpeg', '2023-12-10 15:23:10'),
(3, 'Religi', 'Destinasi wisata religi adalah tempat yang mencerminkan nilai-nilai spiritual dan keagamaan, memberi pengalaman mendalam bagi para pengunjung yang mencari kedamaian dan refleksi. Tempat-tempat ini seringkali terkait dengan sejarah dan kepercayaan tertentu, menjadi pusat peribadatan atau perayaan keagamaan. Peninggalan arsitektur dan seni yang khas di destinasi ini mencerminkan keindahan dan keagungan kepercayaan agama yang dijunjung tinggi.\r\n\r\nPilgrimage atau ziarah ke destinasi religi sering dianggap sebagai perjalanan spiritual, memberikan kesempatan bagi para peziarah untuk mendalami keyakinan mereka. Selain kegiatan ibadah, destinasi wisata religi juga sering menjadi pusat kegiatan sosial dan budaya, mengakomodasi berbagai festival dan ritual keagamaan. Melalui pengunjungan ke destinasi wisata religi, seseorang dapat menggali makna mendalam dari warisan spiritual, merasakan ketenangan batin, dan memperkaya pemahaman akan keragaman kepercayaan di seluruh dunia.', 'religi.jpeg', '2023-12-10 15:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `komentar` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tempat_wisata_id` int(11) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `komentar`, `rating`, `user_id`, `tempat_wisata_id`, `last_activity`, `waktu`) VALUES
(10, 'Sebuah tempat yang sangat indah\r\n', '3.00', 38, 1, '2023-12-10 15:51:49', '2023-12-10 13:32:46'),
(11, 'Merupakan sebuah tempat wisata yang sangat menarik ', '4.00', 38, 2, '2023-12-10 23:59:57', '2023-12-10 13:33:57'),
(13, 'Saya sangat ingin sekali datang kesana lagi', '1.00', 38, 1, '2023-12-10 15:52:09', '2023-12-10 14:30:14'),
(35, 'pantainya sangat bersih sekalii', '3.00', 38, 4, '2023-12-11 00:00:55', '2023-12-11 00:00:55'),
(40, 'apakah iyaa', '2.00', 38, 4, '2023-12-11 00:02:34', '2023-12-11 00:02:34'),
(43, 'gunung terindah', '2.00', 38, 1, '2023-12-11 00:05:26', '2023-12-11 00:05:26'),
(44, 'mantapp', '2.00', 38, 1, '2023-12-11 00:08:14', '2023-12-11 00:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_wisata`
--

CREATE TABLE `tempat_wisata` (
  `id` int(11) NOT NULL,
  `nama_tempat` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `htm` int(11) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempat_wisata`
--

INSERT INTO `tempat_wisata` (`id`, `nama_tempat`, `deskripsi`, `htm`, `kategori_id`, `image`, `last_activity`) VALUES
(1, 'Jaya Wijaya', 'Gunung Jayawijaya, yang juga dikenal sebagai Puncak Jaya, di Provinsi Papua, Indonesia, sebagai puncak tertinggi di benua Oceania dengan ketinggian mencapai sekitar 4.884 meter di atas permukaan laut. Salah satu fitur paling unik dari gunung ini adalah keberadaan salju abadi di puncaknya, sebuah fenomena yang langka di wilayah tropis. Di sekitar Gunung Jayawijaya, ekosistem yang beragam mendukung kehidupan berbagai flora dan fauna endemik. Pendakian ke puncaknya merupakan tantangan besar, menuntut peralatan khusus dan keahlian teknis, sementara daerah sekitarnya memiliki nilai budaya dan sejarah yang penting bagi suku-suku asli, termasuk suku Dani. Selain itu, Gunung Jayawijaya memiliki pengakuan internasional sebagai puncak tertinggi di Oceania sejak tahun 1962. Melalui keindahannya yang alami dan keberagamannya yang ekologis serta budayanya yang kaya, Gunung Jayawijaya memainkan peran penting sebagai aset berharga bagi Papua, Indonesia, dan dunia.', 200000, 2, 'jayawijaya.jpg', '2023-12-10 15:10:42'),
(2, 'Gunung Marapi', 'Gunung Marapi, yang terletak di pulau Sumatera, Indonesia, adalah salah satu gunung berapi yang menonjol dengan pesona alamnya yang memukau. Dengan ketinggian sekitar 2.891 meter di atas permukaan laut, Gunung Marapi menyajikan pemandangan spektakuler dari puncaknya, memberikan pengalaman mendaki yang menarik bagi para pendaki dan pecinta alam. Terletak di dekat kota Bukittinggi, gunung ini menjadi destinasi populer bagi mereka yang mencari petualangan alam dan ingin menikmati keindahan panorama pegunungan Sumatera Barat. Kegiatan mendaki Gunung Marapi membuka pintu bagi para pengunjung untuk menyaksikan keelokan alam sekitar, mulai dari hutan lebat hingga lautan awan yang memukau. Selain sebagai destinasi wisata alam, Gunung Marapi juga memiliki nilai sejarah dan budaya yang kaya, dengan keberadaan situs-situs bersejarah di sekitarnya. Dengan keindahan alam dan kekayaan kulturalnya, Gunung Marapi Sumatera menyajikan pengalaman mendaki yang tak terlupakan bagi pengunjung yang menjelajah ke wilayah barat Sumatera.', 250000, 2, 'gedepangrango.jpg', '2023-12-10 15:11:33'),
(4, 'Pantai Nampu', 'Pantai Nampu, sebuah surga tropis tersembunyi di Indonesia, menawarkan pengalaman liburan yang memberikan keindahan alamnya yang luar biasa. Dikelilingi oleh pasir putih yang lembut dan air laut biru kehijauan, pantai ini memberikan kesan kedamaian dan ketenangan yang sempurna untuk pelancong yang mencari tempat untuk bersantai. Gemerlap matahari terbenam di ufuk barat pantai menjadi pemandangan magis yang tak terlupakan, menciptakan momen romantis dan damai bagi mereka yang menikmati keajaiban alam.\r\n\r\nSelain kecantikan alamnya, Pantai Nampu juga menawarkan beragam aktivitas, mulai dari snorkeling untuk mengeksplorasi kehidupan bawah laut yang berwarna-warni, hingga berjalan-jalan santai di tepi pantai yang panjang. Pesona lokalnya juga terasa melalui keberagaman warung makanan pinggir pantai yang menyajikan hidangan laut segar dan kuliner lokal. Dengan kombinasi keindahan alam yang memesona dan kegiatan rekreasi yang beragam, Pantai Nampu menjadi destinasi unggul untuk memenuhi keinginan liburan yang tak terlupakan di tepian Samudera Hindia.', 15000, 1, 'lightbox3.jpeg', '2023-12-10 15:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `last_registered` datetime DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT 'default.jpg',
  `location` varchar(255) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `last_registered`, `img`, `location`, `last_activity`) VALUES
(36, 'Vita Rahmada', '$2y$10$TYzqDzMWO2iD/yslRTbW9etUv1WjwmIVmDymbGTxbYWlnWxJwY9QK', 'admin', '2023-12-06 01:32:24', 'vita2.jpg', 'Bandung, West Java, ID', '2023-12-07 12:12:49'),
(37, 'Mahisa Aghisni Fadhli', '$2y$10$jYk9Phvy9sLCJBMR4iRlgOOEgGVJCVMben/hSLykm4wpJ40yhDxGW', 'admin', '2023-12-06 01:33:40', 'mahisa.jpeg', 'Bandung, West Java, ID', '2023-12-06 01:34:42'),
(38, 'Muhammad Fadly Gimnastiar', '$2y$10$1HWri7P1/OzAelHejZM9Iud.8TM0heYYibdzUI/yzRckJb/wBb7mm', 'admin', '2023-12-06 01:35:16', 'fadly.jpeg', 'Bandung, West Java, ID', '2023-12-06 01:36:04'),
(52, 'Ibnu Rusdianto', '$2y$10$OmVro2ywjos1yP06Wp8iU.vBNhunUAmgYjZ.9nQ0mdL1r3yFXzj0e', 'admin', '2023-12-07 12:13:42', 'ibnu.jpeg', 'Bandung, West Java, ID', '2023-12-07 12:14:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tempat_wisata_id` (`tempat_wisata_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tempat_wisata_id` (`tempat_wisata_id`);

--
-- Indexes for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD CONSTRAINT `fasilitas_ibfk_1` FOREIGN KEY (`tempat_wisata_id`) REFERENCES `tempat_wisata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`tempat_wisata_id`) REFERENCES `tempat_wisata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  ADD CONSTRAINT `tempat_wisata_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
