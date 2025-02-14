-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Şub 2025, 05:40:11
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `beta_album`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`) VALUES
(1, 'betacolor@hotmail.com', '$2y$10$vI/ZyXpTnl01aoxp81LOWelWfyK.jxup.c1J/VXql.vX/VKACMEXG');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fotograf_fiyatlari`
--

CREATE TABLE `fotograf_fiyatlari` (
  `id` int(11) NOT NULL,
  `kategori` enum('Biyometrik','Vesikalık') NOT NULL,
  `ebat` varchar(50) NOT NULL,
  `adet` int(11) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `fotograf_fiyatlari`
--

INSERT INTO `fotograf_fiyatlari` (`id`, `kategori`, `ebat`, `adet`, `fiyat`) VALUES
(1, 'Biyometrik', '35x45mm', 4, 49.90),
(2, 'Biyometrik', '35x45mm', 8, 54.90),
(3, 'Biyometrik', '35x45mm', 12, 59.90),
(4, 'Biyometrik', '35x45mm', 24, 69.90),
(5, 'Biyometrik', '50x50mm', 4, 49.90),
(6, 'Biyometrik', '50x50mm', 8, 54.90),
(7, 'Biyometrik', '50x50mm', 12, 59.90),
(8, 'Biyometrik', '50x50mm', 24, 69.90),
(9, 'Biyometrik', '50x60mm', 4, 49.90),
(10, 'Biyometrik', '50x60mm', 8, 54.90),
(11, 'Biyometrik', '50x60mm', 12, 59.90),
(12, 'Biyometrik', '50x60mm', 24, 69.90),
(13, 'Vesikalık', '3,2x4,5 cm', 9, 39.90),
(14, 'Vesikalık', '3,2x4,5 cm', 18, 49.90),
(15, 'Vesikalık', '3,2x4,5 cm', 27, 59.90),
(16, 'Vesikalık', '3,2x4,5 cm', 36, 69.90),
(17, 'Vesikalık', '3,2x4,5 cm', 45, 79.90),
(18, 'Vesikalık', '4,5x6 cm', 4, 39.90),
(19, 'Vesikalık', '4,5x6 cm', 8, 49.90),
(20, 'Vesikalık', '4,5x6 cm', 12, 59.90),
(21, 'Vesikalık', '4,5x6 cm', 24, 69.90),
(22, 'Vesikalık', '4,5x6 cm', 36, 79.90),
(23, 'Vesikalık', '6x9 cm', 2, 39.90),
(24, 'Vesikalık', '6x9 cm', 4, 49.90),
(25, 'Vesikalık', '6x9 cm', 6, 59.90),
(26, 'Vesikalık', '6x9 cm', 8, 69.90),
(27, 'Vesikalık', '6x9 cm', 10, 79.90);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `kategori_id` int(11) NOT NULL,
  `kategori_ad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategori_id`, `kategori_ad`) VALUES
(1, 'Exclusive Albümler'),
(2, 'Kampanyalı Albümler'),
(3, 'Kategori 3'),
(4, 'Kategori 4'),
(5, 'Kategori 5'),
(6, 'Kategori 6'),
(7, 'Kategori 7'),
(8, 'Kategori 8'),
(9, 'Kategori 9'),
(10, 'Kategori 10');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_surname` varchar(255) NOT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `tcKimlik` varchar(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sepet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`user_id`, `user_name`, `user_surname`, `phoneNumber`, `tcKimlik`, `email`, `password`, `sepet`) VALUES
(4, 'Yaver', 'Batıni', '05554443322', '12345678978', 'yaverbatini@gmail.com', '$2y$10$dDwE0tSy7TLGwqK.XCjLV.bIi5bFh/dtbyFXkhv8aspLS0oOuYx7a', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `main_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `main_image`) VALUES
(1, 'image/mainpage.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`order_details`)),
  `total_price` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Hazırlanıyor','Kargoda','Teslim Edildi') DEFAULT 'Hazırlanıyor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_ad` varchar(255) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `urun_gorsel` varchar(255) DEFAULT NULL,
  `urun_fiyat` decimal(10,2) DEFAULT NULL,
  `urun_aciklama` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Tablo için indeksler `fotograf_fiyatlari`
--
ALTER TABLE `fotograf_fiyatlari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tcKimlik` (`tcKimlik`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `fotograf_fiyatlari`
--
ALTER TABLE `fotograf_fiyatlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `siparisler`
--
ALTER TABLE `siparisler`
  ADD CONSTRAINT `siparisler_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`user_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `urunler`
--
ALTER TABLE `urunler`
  ADD CONSTRAINT `urunler_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategoriler` (`kategori_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
