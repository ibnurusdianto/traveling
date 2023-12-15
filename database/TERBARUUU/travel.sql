-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 03:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
(6, 'Religi / Budaya', 'Agama adalah sistem yang mengatur kepercayaan serta peribadatan kepada Tuhan serta tata kaidah yang berhubungan dengan adat istiadat, dan pandangan dunia yang menghubungkan manusia dengan tatanan kehidupan, pelaksanaan agama bisa dipengaruhi oleh adat istiadat daerah setempat.', 'pexels-ihsan-adityawarman-2464145.jpg', '2023-12-13 23:55:33'),
(7, 'Gunung', 'Gunung adalah bagian kerak bumi yang lebih tinggi dari area di sekitarnya. Gunung biasanya memiliki sisi curam yang secara signifikan menyingkap batuan dasarnya.', 'pexels-paweł-stolarski-19344454.jpg', '2023-12-13 23:59:02'),
(8, 'Pantai', 'Pantai adalah istilah yang sudah tak asing lagi bagi masyarakat. Keberadaan pantai menjadi sebuah tempat wisata dan juga sebagai tempat untuk mencari nafkah bagi sebagian orang. Meski kata pantai cukup populer, namun masih ada orang yang belum mengerti apa itu pantai.\r\n\r\nBerdasarkan Kamus Besar Bahasa Indonesia atau KBBI, pantai adalah tepi laut: pesisir. Secara umum, pantai adalah bagian daratan yang langsung berbatasan dengan laut. Pantai juga sering disebut dengan pesisir.\r\n\r\nMeski banyak orang yang menyebut pantai adalah pesisir, namun kawasan pantai berbeda dengan pesisir walaupun antara keduanya saling berkaitan. Untuk itu, anda perlu mengenali ciri-ciri pantai agar dapat membedakannya dengan pesisir.', 'pexels-clem-onojeghuo-127673.jpg', '2023-12-14 00:02:40'),
(9, 'Pertanian', 'Agrowisata merupakan perpaduan antara pariwisata dan pertanian atau perkebunan dikombinasikan menjadi tempat destinasi yang menarik bagi masyarakat untuk beraktivitas di lingkungan perkebunan. Orang-orang dapat belajar tentang perkebunan, menikmati buah segar hasil petikan langsung dari pohonnya, atau sekedar jalan-jalan menghirup aroma segar yang jarang mereka jumpai di perkotaan.\r\n\r\nAgrowisata adalah cara baru bagi petani untuk mendapatkan uang selain dari menjual hasil tani. Diharapkan cara ini dapat meningkatkan kesejahteraan petani dan menjadi daya tarik tersendiri bagi masyarakat perkotaan untuk mempelajari tentang pertanian dan perkebunan. Harapan kedepannya pertanian dan perkebunan di Indonesia menjadi bidang yang potensial dan menjanjikan bagi bangsa ini.', 'pexels-quang-nguyen-vinh-2131784.jpg', '2023-12-14 00:04:38'),
(10, 'Konvensi', 'Wisata konvensi merupakan suatu kegiatan kepariwisataan yang aktifitasnya merupakan perpaduan antara leisure dan business, biasanya melibatkan sekelompok orang secara bersama-sama, rangkaian kegiatannya dalam bentuk meetings, incentive travels, Page 3 GARIS-Jurnal Mahasiswa Jurusan Arsitektur (E-ISSN : 1456212297) ...', 'pexels-asia-culture-center-4940642.jpg', '2023-12-14 00:08:46'),
(11, 'Maritim atau Bahari', 'Wisata bahari merupakan salah satu wisata unggulan yang dimiliki Indonesia. Menurut data Kementerian Kelautan dan Perikanan, Indonesia memiliki 20,87Juta Ha kawasan konservasi perairan, pesisir, dan pulau-pulau kecil. Garis pantai Indonesia membentang 99.093 km dengan luas laut 3,257Juta km².\r\n\r\nKekayaan maritim ini membuat wisata bahari di Indonesia tak diragukan lagi keindahan dan keunikannya. Wisata bahari Indonesia tersebar dari Sabang sampai Merauke. Ada banyak yang bisa dieksplor dalam wisata bahari Indonesia.\r\n\r\nDi wisata bahari ini terdapat 590 jenis karang, 2.057 ikan karang, 12 jenis lamun, 34 jenis mangrove, 1.512 jenis crustacean, 6 jenis penyu, 850 jenis sponge, 24 jenis mamalia Laut, dan 463titik Kapal Tenggelam.', 'tumblr_f14c6b1bc893768877348c3c0febac6f_61baf99a_1280.jpg', '2023-12-14 15:17:26');

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
(49, 'Mantapppppp josss', 5.00, 52, 7, '2023-12-14 03:34:35', '2023-12-14 03:34:35'),
(50, 'gg pokoke', 5.00, 52, 7, '2023-12-14 03:35:29', '2023-12-14 03:35:29');

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
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempat_wisata`
--

INSERT INTO `tempat_wisata` (`id`, `nama_tempat`, `deskripsi`, `htm`, `kategori_id`, `image`, `last_activity`, `seen`) VALUES
(6, 'Sunan Gunung Jati', 'Sunan Gunung Jati, lahir dengan nama Hidayatullah atau lebih di kenal sebagai Sayyid Al-Kamil adalah salah seorang dari Walisongo, ia dilahirkan Tahun 1448 Masehi dari pasangan Syarif Abdullah Umdatuddin bin Ali Nurul Alam dan Nyai Rara Santang, Putri Sri Baduga Maharaja Prabu Siliwangi dari Kerajaan Padjajaran (yang setelah masuk Islam berganti nama menjadi Syarifah Mudaim).\r\n\r\nSyarif Hidayatullah sampai di Cirebon pada tahun 1470 Masehi, yang kemudian dengan dukungan Kesultanan Demak dan Pangeran Walangsungsang atau Pangeran Cakrabuana (Tumenggung Cirebon pertama sekaligus uwak Syarif Hidayatullah dari pihak ibu), ia dinobatkan menjadi Tumenggung Cirebon ke-2 pada tahun 1479 dengan gelar Maulana Jati.\r\n\r\nNama Syarif Hidayatullah kemudian diabadikan menjadi nama Universitas Islam Negeri Syarif Hidayatullah Jakarta di daerah Tangerang Selatan, Banten. Sedangkan nama Sunan Gunung Jati diabadikan menjadi nama Universitas Islam negeri di Bandung, yaitu Universitas Islam Negeri Sunan Gunung Djati[1], dan Korem 063/Sunan Gunung Jati di Cirebon.', 0, 6, '409183854_1059529235359106_8764309666296410985_n.jpg', '2023-12-14 19:13:47', 18),
(7, 'Majak', 'Istilah ini populer dan trend di berbagai platform media sosial, mulai dari Instagram hingga TikTok, seperti contoh berikut ini. Dengan kata lain, rujak dalam bahasa gaul sama artinya dengan perundungan. Sedangkan kata ngerujak dan dirujak, sama saja dengan dirundung atau merundung.', 0, 6, '217629464_4259653277459863_7794889223103232344_n.jpg', '2023-12-14 18:54:57', 13),
(8, 'Putri Ong Tien', 'Dia adalah Putri Ong Tien, pernah meninggalkan sebuah kisah indah yang romantis sebagai seorang istri dari ulama tinggi penyebar agama islam di Tanah Jawa, Syeikh Syarif Hidayatullah atau lebih di kenal dengan Sunan Gunung Jati, yang menjadikannya Ratu atau Putri Laras Sumanding yaitu sebutan Nyi Ong Tien di Keraton Kasepuhan Kesultanan Pakungwati Cirebon sekitar 600 tahun yang silam.', 0, 6, 'kisah-cinta-putri-ong-tien-dengan-sunan-gunung-jati-hwf.jpg', '2023-12-14 00:48:57', 3),
(9, 'Tasyakuran Desa Cigugur', 'Acara Tasyakuran 3 tahun Pemerintah Desa Cigugur dibawah Kepemimpinan Bpk. H. Carnaka \r\nYang dihadiri semua Elemen Masyarakat dari BPD, LPMD, Tokoh Agama maupun Tokoh Masyarakat  serta Pendamping Desa dan PPL Desa Cigugur 🙏🏻🙏🏻 Alhamdulillah Semoga Berkah Selalu 🤲🏻🤲🏻 Aamiin', 0, 6, '270764799_284347133727510_222812236342577672_n.jpg', '2023-12-14 01:10:22', 2),
(10, 'Hajat Bumi Desa Cigugur ', 'Hajat Bumi di Persawahan Blok Pundong, Bedahan dan Lodong Desa Cigugur\r\nHajat Bumi di Persawahan Blok Pundong, Bedahan dan Lodong Desa Cigugur\r\n\r\n', 0, 6, '408276280_739014774927408_1769564927658551512_n.jpg', '2023-12-14 01:10:12', 1),
(11, 'Keraton Kasepuhan Cirebon', 'Keraton Kasepuhan adalah keraton yang terletak di kelurahan Kesepuhan, Lemahwungkuk, Cirebon. Makna di setiap sudut arsitektur keraton ini pun terkenal paling bersejarah. Halaman depan keraton ini dikelilingi tembok bata merah dan terdapat pendopo di dalamnya.', 0, 6, '399712000_3202509383383449_8377381261788960880_n.jpg', '2023-12-14 00:41:52', 3),
(16, 'Gunung Rinjani', 'Gunung Rinjani adalah gunung yang berlokasi di Pulau Lombok, Nusa Tenggara Barat. Gunung yang merupakan gunung berapi kedua tertinggi di Indonesia', 20000, 7, 'Rinjani.jpg', '2023-12-14 04:00:06', 1),
(17, 'Gunung Merapi', 'Gunung Merapi adalah gunung berapi di bagian tengah Pulau Jawa dan merupakan salah satu gunung api teraktif di Indonesia.', 20000, 7, 'Merapi_mountain.jpg', '2023-12-14 04:00:02', 1),
(18, 'Gunung Merbabu', 'Pendakian dimulai dari basecamp hingga ke puncak dengan jarak sekitar 6,45 km dan waktu tempuh kurang lebih 11 jam. Sepanjang perjalanan, pendaki akan melewati beberapa pos, seperti pos 1, pos 2, pos 3, sabana 1, sabana 2, sabana 3, puncak Suwanting, puncak triangulasi, dan puncak Kenteng Songo.', 200000, 7, '6459a41e556f2262682226.jpg', '2023-12-14 03:58:48', 0),
(19, 'Happiness after World War II.', 'World War II (WWII or WW2) or the Second World War was a global conflict that lasted from 1939 to 1945. The vast majority of the worlds countries, including all the great powers, fought as part of two opposing military alliances: the Allies and the Axis. Many participating countries invested all available economic, industrial, and scientific capabilities into this total war, blurring the distinction between civilian and military resources. Aircraft played a major role, enabling the strategic bombing of population centres and delivery of the only two nuclear weapons ever used in war. It was by far the deadliest conflict in history, resulting in 70–85 million fatalities.', 1000, 11, '05585651-809x1024.jpg', '2023-12-14 18:49:47', 4);

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
(52, 'Ibnu Rusdianto', '$2y$10$OmVro2ywjos1yP06Wp8iU.vBNhunUAmgYjZ.9nQ0mdL1r3yFXzj0e', 'admin', '2023-12-07 12:13:42', 'ibnu.jpeg', 'Bandung, West Java, ID', '2023-12-07 12:14:28'),
(53, 'testku123', '$2y$10$2snZa0Q5/8lsgjhDISzXJuT7iqTKRI.H9a1iW94LnL.4IXthXpv3u', 'user', '2023-12-13 21:45:18', 'default.jpg', 'Bandung, West Java, ID', '2023-12-13 23:01:09'),
(54, 'sdfds', '$2y$10$YMMNlu7B8xVjkQKNFuu3V.x70HVca77FxsoHFM.wJNRviRLkeXUAm', 'user', '2023-12-14 02:12:40', 'default.jpg', NULL, '2023-12-14 02:12:40'),
(55, 'sdfdss', '$2y$10$yt0/PzBLOOEAKyi85wKG7.tT8e4RdhiymsH5ecUvMcKd7nrE0G4GS', 'user', '2023-12-14 02:22:48', 'default.jpg', NULL, '2023-12-14 02:22:48'),
(56, 'sdfdsss', '$2y$10$8KIqQGhkKNlcM.BtHT6QleAoCbSw1eReONfnS20wjqK1f/VCKhthO', 'user', '2023-12-14 03:06:58', 'default.jpg', NULL, '2023-12-14 03:06:58'),
(57, 'sdfdsdd', '$2y$10$1T0HapBVeK6J99lB9FGLau7DYzcre9GiA/qzftTUe63GApZFpJ5la', 'user', '2023-12-14 04:04:51', 'default.jpg', NULL, '2023-12-14 04:04:51'),
(58, 'testakun23434', '$2y$10$Lam/6xxzGwD2kZRAHGb7R.cZIVcgV5J0tyCE0RY5u4nDmqVplC7e.', 'user', '2023-12-14 20:51:37', 'default.jpg', 'Unknown, Unknown, Unknown', '2023-12-14 20:53:36');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
