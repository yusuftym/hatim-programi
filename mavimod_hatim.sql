-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 28 Tem 2025, 13:40:35
-- Sunucu sürümü: 10.6.22-MariaDB-cll-lve
-- PHP Sürümü: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mavimod_hatim`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `type` enum('cuz','hatim','zikir','login') NOT NULL,
  `requirement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `badges`
--

INSERT INTO `badges` (`id`, `name`, `description`, `icon`, `type`, `requirement`) VALUES
(1, 'Hatim Başlangıcı', 'İlk cüzünü alarak hatime katıldın.', 'fa-book-open', 'cuz', 1),
(2, 'Azimkâr Okuyucu', 'Toplam 5 cüz okudun.', 'fa-tasks', 'cuz', 5),
(3, 'Hatim Fatihi', 'Toplam 30 cüz okuyarak bir hatmi tek başına tamamlamaya eşdeğer bir katkı sağladın.', 'fa-crown', 'cuz', 30),
(4, 'Zikirmatik', 'Toplam 1,000 zikir çektin.', 'fa-pray', 'zikir', 1000),
(5, 'Zikir Ehli', 'Toplam 10,000 zikir çektin.', 'fa-star', 'zikir', 10000),
(6, 'Müdavim', 'Platforma 10 farklı günde giriş yaptın.', 'fa-calendar-check', 'login', 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cuzler`
--

CREATE TABLE `cuzler` (
  `id` int(11) NOT NULL,
  `hatim_id` int(11) NOT NULL,
  `cuz_no` int(11) NOT NULL,
  `alan_kisi_id` int(11) DEFAULT NULL,
  `alma_tarihi` datetime DEFAULT NULL,
  `okundu_mu` tinyint(1) NOT NULL DEFAULT 0,
  `okunma_tarihi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cuzler`
--

INSERT INTO `cuzler` (`id`, `hatim_id`, `cuz_no`, `alan_kisi_id`, `alma_tarihi`, `okundu_mu`, `okunma_tarihi`) VALUES
(1, 1, 1, 2, '2025-07-28 11:16:58', 1, '2025-07-28 11:17:22'),
(2, 1, 2, 2, '2025-07-28 11:32:53', 1, '2025-07-28 11:32:56'),
(3, 1, 3, NULL, NULL, 0, NULL),
(4, 1, 4, NULL, NULL, 0, NULL),
(5, 1, 5, NULL, NULL, 0, NULL),
(6, 1, 6, NULL, NULL, 0, NULL),
(7, 1, 7, NULL, NULL, 0, NULL),
(8, 1, 8, NULL, NULL, 0, NULL),
(9, 1, 9, 2, '2025-07-28 12:08:30', 1, '2025-07-28 12:08:35'),
(10, 1, 10, NULL, NULL, 0, NULL),
(11, 1, 11, NULL, NULL, 0, NULL),
(12, 1, 12, NULL, NULL, 0, NULL),
(13, 1, 13, NULL, NULL, 0, NULL),
(14, 1, 14, NULL, NULL, 0, NULL),
(15, 1, 15, NULL, NULL, 0, NULL),
(16, 1, 16, NULL, NULL, 0, NULL),
(17, 1, 17, NULL, NULL, 0, NULL),
(18, 1, 18, NULL, NULL, 0, NULL),
(19, 1, 19, NULL, NULL, 0, NULL),
(20, 1, 20, NULL, NULL, 0, NULL),
(21, 1, 21, NULL, NULL, 0, NULL),
(22, 1, 22, NULL, NULL, 0, NULL),
(23, 1, 23, NULL, NULL, 0, NULL),
(24, 1, 24, NULL, NULL, 0, NULL),
(25, 1, 25, NULL, NULL, 0, NULL),
(26, 1, 26, NULL, NULL, 0, NULL),
(27, 1, 27, NULL, NULL, 0, NULL),
(28, 1, 28, NULL, NULL, 0, NULL),
(29, 1, 29, NULL, NULL, 0, NULL),
(30, 1, 30, NULL, NULL, 0, NULL),
(31, 2, 1, NULL, NULL, 0, NULL),
(32, 2, 2, NULL, NULL, 0, NULL),
(33, 2, 3, NULL, NULL, 0, NULL),
(34, 2, 4, NULL, NULL, 0, NULL),
(35, 2, 5, NULL, NULL, 0, NULL),
(36, 2, 6, NULL, NULL, 0, NULL),
(37, 2, 7, NULL, NULL, 0, NULL),
(38, 2, 8, NULL, NULL, 0, NULL),
(39, 2, 9, NULL, NULL, 0, NULL),
(40, 2, 10, NULL, NULL, 0, NULL),
(41, 2, 11, NULL, NULL, 0, NULL),
(42, 2, 12, NULL, NULL, 0, NULL),
(43, 2, 13, NULL, NULL, 0, NULL),
(44, 2, 14, NULL, NULL, 0, NULL),
(45, 2, 15, NULL, NULL, 0, NULL),
(46, 2, 16, NULL, NULL, 0, NULL),
(47, 2, 17, NULL, NULL, 0, NULL),
(48, 2, 18, NULL, NULL, 0, NULL),
(49, 2, 19, NULL, NULL, 0, NULL),
(50, 2, 20, NULL, NULL, 0, NULL),
(51, 2, 21, NULL, NULL, 0, NULL),
(52, 2, 22, NULL, NULL, 0, NULL),
(53, 2, 23, NULL, NULL, 0, NULL),
(54, 2, 24, NULL, NULL, 0, NULL),
(55, 2, 25, NULL, NULL, 0, NULL),
(56, 2, 26, NULL, NULL, 0, NULL),
(57, 2, 27, NULL, NULL, 0, NULL),
(58, 2, 28, NULL, NULL, 0, NULL),
(59, 2, 29, NULL, NULL, 0, NULL),
(60, 2, 30, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dualar`
--

CREATE TABLE `dualar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `niyet` text NOT NULL,
  `isim_gizli` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','inactive') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dualar`
--

INSERT INTO `dualar` (`id`, `user_id`, `niyet`, `isim_gizli`, `status`, `created_at`) VALUES
(1, 2, 'Deneme', 0, 'approved', '2025-07-28 09:33:35');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dua_katilimlari`
--

CREATE TABLE `dua_katilimlari` (
  `id` int(11) NOT NULL,
  `dua_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `katilim_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dua_katilimlari`
--

INSERT INTO `dua_katilimlari` (`id`, `dua_id`, `user_id`, `katilim_tarihi`) VALUES
(1, 1, 2, '2025-07-28 10:29:24');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hatimler`
--

CREATE TABLE `hatimler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `olusturan_id` int(11) NOT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `tamamlandi_mi` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hatimler`
--

INSERT INTO `hatimler` (`id`, `baslik`, `aciklama`, `olusturan_id`, `olusturma_tarihi`, `tamamlandi_mi`, `status`) VALUES
(1, 'Deneme', 'Deneme', 2, '2025-07-28 08:16:31', 0, 'approved'),
(2, 'Deneme2', 'deneme2', 2, '2025-07-28 09:08:51', 0, 'approved');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ibadetler`
--

CREATE TABLE `ibadetler` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `hedef_sayi` bigint(20) NOT NULL,
  `olusturan_id` int(11) NOT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `aktif_mi` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ibadetler`
--

INSERT INTO `ibadetler` (`id`, `ad`, `aciklama`, `hedef_sayi`, `olusturan_id`, `olusturma_tarihi`, `aktif_mi`) VALUES
(1, 'Deneme', 'Deneme İbadet', 10000, 2, '2025-07-28 08:23:19', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ibadet_kayitlari`
--

CREATE TABLE `ibadet_kayitlari` (
  `id` int(11) NOT NULL,
  `ibadet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `okunan_sayi` int(11) NOT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ibadet_kayitlari`
--

INSERT INTO `ibadet_kayitlari` (`id`, `ibadet_id`, `user_id`, `okunan_sayi`, `kayit_tarihi`) VALUES
(1, 1, 2, 100, '2025-07-28 08:23:29');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tefsirler`
--

CREATE TABLE `tefsirler` (
  `id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `dil` varchar(10) NOT NULL DEFAULT 'tr',
  `aktif_mi` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tefsirler`
--

INSERT INTO `tefsirler` (`id`, `api_id`, `ad`, `dil`, `aktif_mi`) VALUES
(1, 171, 'Diyanet Vakfı (Kısa)', 'tr', 1),
(3, 85, 'Elmalılı Hamdi Yazır', 'tr', 1),
(4, 169, 'Ömer Nasuhi Bilmen', 'tr', 1),
(5, 170, 'Celal Yıldırım', 'tr', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','moderator','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'yusuf', 'ysf@ysf.com', '$2y$10$dLFKrkSTNKbmYZukuLzHMuFzranvhX2o2SqnEUn.DMeVM9ooYYwk6', 'admin', '2025-07-28 08:12:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_activity_log`
--

CREATE TABLE `user_activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` enum('cuz_okundu','zikir_eklendi','login') NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `activity_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_activity_log`
--

INSERT INTO `user_activity_log` (`id`, `user_id`, `activity_type`, `related_id`, `value`, `activity_date`) VALUES
(1, 2, 'login', NULL, NULL, '2025-07-28 08:12:30'),
(2, 2, 'login', NULL, NULL, '2025-07-28 08:14:31'),
(3, 2, 'cuz_okundu', 1, NULL, '2025-07-28 08:17:22'),
(4, 2, 'login', NULL, NULL, '2025-07-28 08:19:07'),
(5, 2, 'zikir_eklendi', 1, 100, '2025-07-28 08:23:29'),
(6, 2, 'cuz_okundu', 2, NULL, '2025-07-28 08:32:56'),
(7, 2, 'cuz_okundu', 9, NULL, '2025-07-28 09:08:35');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_badges`
--

CREATE TABLE `user_badges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `badge_id` int(11) NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_badges`
--

INSERT INTO `user_badges` (`id`, `user_id`, `badge_id`, `earned_at`) VALUES
(1, 2, 1, '2025-07-28 08:17:22');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cuzler`
--
ALTER TABLE `cuzler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hatim_id_cuz_no` (`hatim_id`,`cuz_no`),
  ADD KEY `alan_kisi_id` (`alan_kisi_id`);

--
-- Tablo için indeksler `dualar`
--
ALTER TABLE `dualar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `dua_katilimlari`
--
ALTER TABLE `dua_katilimlari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dua_user_unique` (`dua_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `hatimler`
--
ALTER TABLE `hatimler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olusturan_id` (`olusturan_id`);

--
-- Tablo için indeksler `ibadetler`
--
ALTER TABLE `ibadetler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olusturan_id` (`olusturan_id`);

--
-- Tablo için indeksler `ibadet_kayitlari`
--
ALTER TABLE `ibadet_kayitlari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ibadet_user` (`ibadet_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `tefsirler`
--
ALTER TABLE `tefsirler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_id` (`api_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `user_activity_log`
--
ALTER TABLE `user_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_badge_unique` (`user_id`,`badge_id`),
  ADD KEY `badge_id` (`badge_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `cuzler`
--
ALTER TABLE `cuzler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Tablo için AUTO_INCREMENT değeri `dualar`
--
ALTER TABLE `dualar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `dua_katilimlari`
--
ALTER TABLE `dua_katilimlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `hatimler`
--
ALTER TABLE `hatimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `ibadetler`
--
ALTER TABLE `ibadetler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ibadet_kayitlari`
--
ALTER TABLE `ibadet_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `tefsirler`
--
ALTER TABLE `tefsirler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `user_activity_log`
--
ALTER TABLE `user_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `cuzler`
--
ALTER TABLE `cuzler`
  ADD CONSTRAINT `cuzler_ibfk_1` FOREIGN KEY (`hatim_id`) REFERENCES `hatimler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuzler_ibfk_2` FOREIGN KEY (`alan_kisi_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `dualar`
--
ALTER TABLE `dualar`
  ADD CONSTRAINT `dualar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `dua_katilimlari`
--
ALTER TABLE `dua_katilimlari`
  ADD CONSTRAINT `dua_katilimlari_ibfk_1` FOREIGN KEY (`dua_id`) REFERENCES `dualar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dua_katilimlari_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `hatimler`
--
ALTER TABLE `hatimler`
  ADD CONSTRAINT `hatimler_ibfk_1` FOREIGN KEY (`olusturan_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `ibadetler`
--
ALTER TABLE `ibadetler`
  ADD CONSTRAINT `ibadetler_ibfk_1` FOREIGN KEY (`olusturan_id`) REFERENCES `users` (`id`);

--
-- Tablo kısıtlamaları `ibadet_kayitlari`
--
ALTER TABLE `ibadet_kayitlari`
  ADD CONSTRAINT `ibadet_kayitlari_ibfk_1` FOREIGN KEY (`ibadet_id`) REFERENCES `ibadetler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ibadet_kayitlari_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `user_activity_log`
--
ALTER TABLE `user_activity_log`
  ADD CONSTRAINT `user_activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_badges_ibfk_2` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
