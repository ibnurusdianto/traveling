-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 01:41 PM
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
  `tempat_wisata_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `tempat_wisata_id`) VALUES
(1, 'Hotel', 1),
(2, 'Parkir', 1),
(3, 'Toilet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `deskripsi`, `image`) VALUES
(1, 'Pantai', 'Destinasi pantai merupakan tempat yang menakjubkan dengan pemandangan indah yang memukau. Dengan pasir putih yang lembut, pantai menciptakan lingkungan yang nyaman untuk bersantai atau berbagai aktivitas rekreasi. Air laut yang jernih dan berwarna biru atau hijau menambah daya tarik pantai, menciptakan suasana yang sempurna untuk berenang, snorkeling, dan aktivitas air lainnya. Selain itu, destinasi pantai juga sering menjadi tempat untuk menikmati matahari terbenam yang spektakuler. Beberapa pantai memiliki daya tarik wisata seperti mercusuar, taman nasional, atau tempat bersejarah, sementara yang lain menawarkan aktivitas budaya seperti festival atau pertunjukan musik. Fasilitas seperti restoran, kafe, toko suvenir, dan penyewaan peralatan air biasanya juga tersedia, memastikan kenyamanan dan kepuasan bagi para wisatawan yang mengunjungi destinasi ini.', 'lightbox6.jpeg'),
(2, 'Gunung', 'Destinasi gunung menawarkan berbagai pengalaman yang unik dengan macam keindahan alam yang megah beserta petualangan. Dengan puncak yang menawarkan pemandangan luar biasa, gunung menjadi daya tarik bagi para pendaki dan pencinta alam. Jalur pendakian yang beragam menghadirkan tantangan berbeda, mulai dari trek yang ramah pemula hingga pendakian ekstrem yang membutuhkan keahlian khusus. Selain itu, destinasi gunung seringkali menyuguhkan keanekaragaman flora dan fauna di berbagai ketinggian, menciptakan ekosistem yang menarik untuk dijelajahi. Pendakian gunung juga sering menjadi kesempatan untuk memahami budaya dan tradisi setempat, dengan beberapa gunung dihormati sebagai tempat-tempat sakral. Fasilitas pendukung seperti pos pendakian, tempat perkemahan, dan pusat informasi biasanya tersedia untuk mendukung perjalanan para pendaki. Dengan berbagai tingkat kesulitan dan kecantikan alam yang menakjubkan, destinasi gunung memberikan pengalaman luar biasa bagi mereka yang mencari petualangan di ketinggian.', 'gunung.jpeg'),
(3, 'Religi', 'Destinasi religi adalah tempat-tempat suci yang mengundang para pengunjung untuk merasakan nilai-nilai spiritual dan keagamaan. Ini meliputi kuil, gereja, masjid, atau situs-situs keramat, yang tidak hanya menjadi tempat ibadah, tetapi juga merangkum sejarah, seni, dan kebersamaan komunitas. Destinasi ini sering menawarkan arsitektur megah dan kisah-kisah bersejarah yang mendalam. Di sekitar tempat ibadah, fasilitas seperti pusat informasi, toko suvenir, dan area peribadatan mendukung pengalaman para pengunjung. Selain itu, destinasi religi juga mencakup situs-situs yang dianggap suci, seperti pegunungan atau sungai. Keseluruhan, destinasi religi tidak hanya memberikan pengalaman keagamaan, tetapi juga memainkan peran penting dalam melestarikan nilai-nilai budaya dan sejarah.', 'religi.jpeg\r\n'),
(5, 'Taman Kota', '\r\nDestinasi wisata Taman Kota adalah area rekreasi umum yang dirancang untuk memberikan pengalaman rekreasi, hiburan, dan kegiatan sosial di tengah kota. Taman Kota menonjolkan luas area terbuka hijau yang menyediakan ruang untuk berbagai aktivitas seperti bermain, bersantai, dan berolahraga. Fasilitas rekreasi seperti taman bermain anak-anak, kolam, serta jalur pejalan kaki atau sepeda membuatnya menjadi tempat yang ramah keluarga. Keindahan taman bunga dan desain lanskap yang menarik menciptakan atmosfer estetis, sementara beberapa Taman Kota juga berfungsi sebagai area konservasi alam. Selain itu, Taman Kota menjadi lokasi penyelenggaraan berbagai acara dan pertunjukan seperti konser musik dan festival makanan. Dengan sifatnya yang mendukung interaksi sosial, Taman Kota menjadi tempat bersosialisasi yang nyaman. Aksesibilitas yang mudah dan kebijakan gratis untuk umum membuat Taman Kota menjadi ruang publik yang terbuka untuk semua kalangan, menjadikannya integral dalam meningkatkan kesejahteraan masyarakat perkotaan.', 'taman.jpg');

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
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `komentar`, `rating`, `user_id`, `tempat_wisata_id`, `waktu`) VALUES
(1, 'Sangat menarik patut dikunjungi bersama keluarga untuk menikmati wisata alam', '5.00', 32, 2, NULL);

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
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempat_wisata`
--

INSERT INTO `tempat_wisata` (`id`, `nama_tempat`, `deskripsi`, `htm`, `kategori_id`, `image`) VALUES
(1, 'Tangkuban Perahu', 'Gunung Tangkuban Parahu adalah salah satu gunung api aktif Indonesia yang berada di Kabupaten Bandung Barat. Gunung ini memiliki bentuk puncak rata yang khas jika terlihat dari kejauhan. Bentuk ini sekilas memang akan mengingatkan pada rupa sebuah perahu yang terbalik. Gunung yang menjadi pusat cerita Legenda Sangkuriang ini ternyata menawarkan lebih dari sekadar kemegahan gunung api. Kawah-kawahnya yang berbahaya sekaligus cantik, kekayaan flora dan fauna endemik, dan panorama alam menakjubkan turut melengkapinya sebagai destinasi wisata. Ditambah dengan wisata kuliner khas, berkunjung ke Gunung Tangkuban Parahu akan selalu jadi pengalaman yang berkesan.\r\n\r\nGunung Tangkuban Parahu tercatat memiliki 13 kawah aktif. Namun, hanya ada dua di antaranya yang cukup aman untuk dikunjungi. Kedua kawah tersebut adalah Kawah Ratu dan Kawah Domas. Bagi rombongan pelajar atau mahasiswa yang berkunjung ke Tangkuban Perahu, wajib melampirkan surat dari sekolah atau kampus dengan kop surat, tanda tangan, dan stempel kepala sekolah. Jika datang tanpa surat keterangan dari sekolah, maka akan dikenakan tarif normal. ', 100000, 2, 'lightbox4.jpeg'),
(2, 'Gede Pangrango', 'Taman Nasional G. Gede Pangrango merupakan taman nasional yang terletak di Provinsi Jawa Barat. Ditetapkan pada tahun 1980, taman nasional ini salah satu yang tertua di Indonesia. TN Gunung Gede Pangrango terutama didirikan untuk melindungi dan mengkonservasi ekosistem dan flora pegunungan yang cantik di Jawa Barat. Dengan luas 24.270,80 hektare, wilayahnya terutama mencakup dua puncak gunung Gede dan Pangrango beserta tutupan hutan pegunungan di sekelilingnya. Kawasan Gunung Gede dan Gunung Pangrango sesungguhnya telah dikenal lama dalam dongeng dan legenda tanah Sunda. Salah satunya, naskah perjalanan Bujangga Manik dari sekitar abad-13 telah menyebut-nyebut tempat bernama Puncak dan Bukit Ageung (yakni, Gunung Gede) yang disebutnya sebagai \"hulu wano na Pakuan\" (tempat yang tertinggi di Pakuan). Agaknya, pada masa itu telah ada jalan kuno antara Bogor (Pakuan) dengan Cianjur, yang melintasi lereng utara G. Gede di sekitar Cipanas sekarang. Kawasan Gede-Pangrango juga dikenal sebagai salah satu tempat favorit dan tertua, bagi penelitian-penelitian tentang alam di Indonesia. Menurut catatan modern, orang pertama yang menginjakkan kaki di puncak Gede adalah Reinwardt, pendiri dan direktur pertama Kebun Raya Bogor, yang mendaki G. Gede pada April 1819. Ia meneliti dan menulis deskripsi vegetasi di bagian gunung yang lebih tinggi hingga ke puncak.', 25000, 2, 'gedepangrango.jpg');

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
  `img` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `last_registered`, `img`, `location`, `last_activity`) VALUES
(32, 'fadly', '$2y$10$e6aovg7Sv2YFuBvd0bGeK.1btZxHwaoPwycosUikc8FpLD4Wm/LO.', 'admin', '2023-12-05 09:44:12', NULL, 'Bandung, West Java, ID', '2023-12-05 09:45:47');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
