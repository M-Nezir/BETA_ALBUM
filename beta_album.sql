-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Şub 2025, 21:58:28
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
(1, 'Bebek Albümleri'),
(2, 'Ekonomik Albümler'),
(3, 'Exclusive Albümler'),
(4, 'Kampanyalı Albümler'),
(5, 'Fırsat Albümleri');

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
(1, 'Mehmetcan', 'Aydın', '05554443322', '12345678912', 'mehmetc@gmail.com', '$2y$10$x9skIyoOPd0JJKr88gkloeyxha8WMRHbfjhdnBUL6ARirxq5fiUby', '[{\"urun_id\":5,\"urun_ad\":\"Camilla\",\"urun_fiyat\":200,\"adet\":3,\"urun_gorsel\":\"Camilla.jpg\"}]'),
(2, 'Mehmet', 'Aydın', '05556667788', '12345678978', 'mehmet13@gmail.com', '$2y$10$NU.GUfg9.Ku/qIqQmzRnl.wEkH6eOQ51IPiArWMP4.LOlUGzZ2oT6', '[]');

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
(1, 'image/anasayfa.jpeg');

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

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`order_id`, `user_id`, `order_details`, `total_price`, `address`, `order_date`, `status`) VALUES
(1, 1, '[{\"urun_id\":5,\"urun_ad\":\"Camilla\",\"urun_fiyat\":200,\"adet\":8,\"urun_gorsel\":\"Camilla.jpg\"},{\"urun_id\":2,\"urun_ad\":\"Lina\",\"urun_fiyat\":160,\"adet\":4,\"urun_gorsel\":\"Lina.jpg\"}]', 2240.00, 'Keçiören/Ankara', '2025-02-08 22:17:53', 'Teslim Edildi'),
(2, 1, '[{\"urun_id\":7,\"urun_ad\":\"Carla\",\"urun_fiyat\":220,\"adet\":1,\"urun_gorsel\":\"Carla.jpg\"}]', 220.00, 'Malatya', '2025-02-08 22:24:58', 'Teslim Edildi'),
(3, 2, '[{\"urun_id\":5,\"urun_ad\":\"Camilla\",\"urun_fiyat\":200,\"adet\":1,\"urun_gorsel\":\"Camilla.jpg\"},{\"urun_id\":4,\"urun_ad\":\"Mia\",\"urun_fiyat\":180,\"adet\":2,\"urun_gorsel\":\"Mia.jpg\"}]', 560.00, 'Afyonkarahisar/TÜRKİYE', '2025-02-08 22:42:41', 'Teslim Edildi'),
(4, 1, '[{\"urun_id\":5,\"urun_ad\":\"Camilla\",\"urun_fiyat\":200,\"adet\":82,\"urun_gorsel\":\"Camilla.jpg\"},{\"urun_id\":7,\"urun_ad\":\"Carla\",\"urun_fiyat\":220,\"adet\":26,\"urun_gorsel\":\"Carla.jpg\"},{\"urun_id\":1,\"urun_ad\":\"Leo\",\"urun_fiyat\":150,\"adet\":3,\"urun_gorsel\":\"Leo.jpg\"},{\"urun_id\":9,\"urun_ad\":\"Natura\",\"urun_fiyat\":240,\"adet\":2,\"urun_gorsel\":\"Natura.jpg\"},{\"urun_id\":8,\"urun_ad\":\"Dream\",\"urun_fiyat\":230,\"adet\":4,\"urun_gorsel\":\"Dream.jpg\"},{\"urun_id\":4,\"urun_ad\":\"Mia\",\"urun_fiyat\":180,\"adet\":1,\"urun_gorsel\":\"Mia.jpg\"},{\"urun_id\":3,\"urun_ad\":\"Lion\",\"urun_fiyat\":170,\"adet\":1,\"urun_gorsel\":\"Lion.jpg\"}]', 24320.00, 'selamünaleyküm', '2025-02-09 03:08:15', 'Teslim Edildi'),
(5, 1, '[{\"urun_id\":1,\"urun_ad\":\"Leo\",\"urun_fiyat\":150,\"adet\":5,\"urun_gorsel\":\"Leo.jpg\"}]', 750.00, 'ev adresim', '2025-02-09 17:20:52', 'Hazırlanıyor'),
(6, 1, '[{\"urun_id\":1,\"urun_ad\":\"Leo\",\"urun_fiyat\":150,\"adet\":4,\"urun_gorsel\":\"Leo.jpg\"},{\"urun_id\":5,\"urun_ad\":\"Camilla\",\"urun_fiyat\":200,\"adet\":3,\"urun_gorsel\":\"Camilla.jpg\"}]', 1200.00, 'selam', '2025-02-09 17:23:11', 'Hazırlanıyor'),
(7, 1, '[{\"urun_id\":1,\"urun_ad\":\"Leo\",\"urun_fiyat\":150,\"adet\":1,\"urun_gorsel\":\"Leo.jpg\"}]', 150.00, 'deneme', '2025-02-09 17:26:58', 'Hazırlanıyor'),
(8, 1, '[{\"urun_id\":1,\"urun_ad\":\"Leo\",\"urun_fiyat\":150,\"adet\":3,\"urun_gorsel\":\"Leo.jpg\"}]', 450.00, 'selam', '2025-02-09 17:29:11', 'Hazırlanıyor');

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
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`urun_id`, `urun_ad`, `kategori_id`, `urun_gorsel`, `urun_fiyat`, `urun_aciklama`) VALUES
(1, 'Leo', 1, 'Leo.jpg', 150.00, 'Klasik tasarımına, estetik dokunuşlar ile daha modern bir hal \nalan Leo, nubuk ve ipeksi görünüşte laminasyon kaplamalı kapak \nfotoğrafı alanı ile, beğenileri üstünde topluyor.'),
(2, 'Lina', 1, 'Lina.jpg', 160.00, NULL),
(3, 'Lion', 1, 'Lion.jpg', 170.00, NULL),
(4, 'Mia', 1, 'Mia.jpg', 180.00, NULL),
(5, 'Camilla', 2, 'Camilla.jpg', 200.00, NULL),
(6, 'Cara', 2, 'Cara.jpg', 210.00, NULL),
(7, 'Carla', 2, 'Carla.jpg', 220.00, NULL),
(8, 'Dream', 2, 'Dream.jpg', 230.00, NULL),
(9, 'Natura', 2, 'Natura.jpg', 240.00, NULL),
(10, 'New Dream', 2, 'New Dream.jpg', 250.00, NULL);

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
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
