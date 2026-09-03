-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_keuangan_sekolah
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gaji_gurus`
--

DROP TABLE IF EXISTS `gaji_gurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gaji_gurus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) unsigned NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nominal_gaji` bigint(20) NOT NULL,
  `potongan` bigint(20) NOT NULL DEFAULT 0,
  `total_gaji` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_dibayar` date NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL DEFAULT 'dibayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gaji_gurus_guru_id_foreign` (`guru_id`),
  CONSTRAINT `gaji_gurus_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gaji_gurus`
--

LOCK TABLES `gaji_gurus` WRITE;
/*!40000 ALTER TABLE `gaji_gurus` DISABLE KEYS */;
INSERT INTO `gaji_gurus` VALUES (1,1,8,2026,3500000,100000,3400000,'Gaji Bulan Agustus 2026','2026-08-28','dibayar','2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,2,8,2026,3200000,0,3200000,'Gaji Bulan Agustus 2026','2026-08-28','pending','2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,4,9,2026,500000,10000,490000,NULL,'2026-09-03','dibayar','2026-09-03 03:28:19','2026-09-03 03:28:19');
/*!40000 ALTER TABLE `gaji_gurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gurus`
--

DROP TABLE IF EXISTS `gurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gurus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_guru` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `gaji_bulanan` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gurus_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gurus`
--

LOCK TABLES `gurus` WRITE;
/*!40000 ALTER TABLE `gurus` DISABLE KEYS */;
INSERT INTO `gurus` VALUES (1,'Siti Maryam, S.Pd.','19850101','Tetap','Wali Kelas TK A',3500000,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,'Dewi Lestari, S.Pd.','19900315','Tetap','Wali Kelas TK B',3200000,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,'Ahmad Hidayat, S.Pd.I','19950720','Honorer','Guru Agama & Mengaji',2800000,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,'Nyobaa','1212121212','Honor','guru 1',500000,'2026-09-03 03:27:51','2026-09-03 03:28:03');
/*!40000 ALTER TABLE `gurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_tagihans`
--

DROP TABLE IF EXISTS `kategori_tagihans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_tagihans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_tagihans`
--

LOCK TABLES `kategori_tagihans` WRITE;
/*!40000 ALTER TABLE `kategori_tagihans` DISABLE KEYS */;
INSERT INTO `kategori_tagihans` VALUES (1,'SPP Bulanan','2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,'Uang Gedung & Pendaftaran','2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,'Extrakulikuler & Outing Class','2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,'Seragam Sekolah','2026-09-03 03:11:59','2026-09-03 03:11:59'),(5,'bayar ssp','2026-09-03 03:25:16','2026-09-03 03:25:16');
/*!40000 ALTER TABLE `kategori_tagihans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keuangans`
--

DROP TABLE IF EXISTS `keuangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keuangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipe` enum('masuk','keluar') NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keuangans`
--

LOCK TABLES `keuangans` WRITE;
/*!40000 ALTER TABLE `keuangans` DISABLE KEYS */;
INSERT INTO `keuangans` VALUES (1,'masuk','Penerimaan SPP',150000,'Pembayaran SPP Ahmad Fauzi (Tunai)','2026-08-24','2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,'masuk','Penerimaan SPP',150000,'Pembayaran SPP Aisyah Az-Zahra (Transfer)','2026-08-29','2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,'masuk','Bantuan Operasional',5000000,'Penerimaan Dana BOS Tahap II','2026-08-19','2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,'keluar','Perlengkapan Belajar',750000,'Pembelian Modul & Alat Mewarnai Siswa','2026-08-26','2026-09-03 03:11:59','2026-09-03 03:11:59'),(5,'keluar','Pemeliharaan Gedung',500000,'Perbaikan Sanitasi & Kebersihan Lingkungan Sekolah','2026-08-28','2026-09-03 03:11:59','2026-09-03 03:11:59'),(6,'keluar','Gaji Guru',3400000,'[Gaji Guru] ID Slip: 1 - Siti Maryam, S.Pd. (Agustus 2026)','2026-08-28','2026-09-03 03:11:59','2026-09-03 03:11:59'),(7,'masuk','infaq mingguan',100000,NULL,'2026-09-03','2026-09-03 03:27:32','2026-09-03 03:27:32'),(8,'keluar','Gaji Guru',490000,'[Gaji Guru] ID Slip: 3 - Nyobaa (September 2026)','2026-09-03','2026-09-03 03:28:19','2026-09-03 03:28:19');
/*!40000 ALTER TABLE `keuangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_04_27_204831_create_siswas_table',1),(6,'2026_04_27_204841_create_kategori_tagihans_table',1),(7,'2026_04_27_204849_create_tagihans_table',1),(8,'2026_04_27_204858_create_transaksis_table',1),(9,'2026_04_28_102203_create_keuangans_table',1),(10,'2026_07_13_162000_create_settings_table',1),(11,'2026_07_19_140000_create_gurus_table',1),(12,'2026_07_19_141000_create_gaji_gurus_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'norek_bank_name','BRI','2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,'norek_number','111 111 1112','2026-09-03 03:11:59','2026-09-03 03:28:56'),(3,'norek_owner','TK IT INSAN CENDIKIA','2026-09-03 03:11:59','2026-09-03 03:11:59');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswas`
--

DROP TABLE IF EXISTS `siswas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siswas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nis` varchar(255) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswas_nis_unique` (`nis`),
  KEY `siswas_user_id_foreign` (`user_id`),
  CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswas`
--

LOCK TABLES `siswas` WRITE;
/*!40000 ALTER TABLE `siswas` DISABLE KEYS */;
INSERT INTO `siswas` VALUES (1,4,'2026001','Ahmad Fauzi','TK A','2026-09-03 03:11:59','2026-09-03 03:25:00'),(2,5,'2026002','Aisyah Az-Zahra','TK B','2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,6,'2026003','Rizky Pratama','TK A','2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,7,'2026004','Nabila Putri','TK B','2026-09-03 03:11:59','2026-09-03 03:11:59');
/*!40000 ALTER TABLE `siswas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagihans`
--

DROP TABLE IF EXISTS `tagihans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagihans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `kategori_id` bigint(20) unsigned NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `status` enum('belum_bayar','proses_verifikasi','lunas','salah_nominal') NOT NULL DEFAULT 'belum_bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagihans_siswa_id_foreign` (`siswa_id`),
  KEY `tagihans_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `tagihans_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_tagihans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tagihans_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagihans`
--

LOCK TABLES `tagihans` WRITE;
/*!40000 ALTER TABLE `tagihans` DISABLE KEYS */;
INSERT INTO `tagihans` VALUES (1,1,1,150000.00,'lunas','2026-08-24 03:11:59','2026-09-03 03:11:59'),(2,1,2,500000.00,'proses_verifikasi','2026-09-01 03:11:59','2026-09-03 03:11:59'),(3,2,1,150000.00,'lunas','2026-08-29 03:11:59','2026-09-03 03:11:59'),(4,2,3,100000.00,'belum_bayar','2026-09-02 03:11:59','2026-09-03 03:11:59'),(5,3,1,150000.00,'salah_nominal','2026-08-31 03:11:59','2026-09-03 03:11:59'),(6,4,4,250000.00,'belum_bayar','2026-08-30 03:11:59','2026-09-03 03:11:59'),(7,4,5,100000.00,'lunas','2026-09-03 03:25:16','2026-09-03 03:27:01'),(8,4,1,75000.00,'belum_bayar','2026-09-03 03:29:24','2026-09-03 03:29:24');
/*!40000 ALTER TABLE `tagihans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksis`
--

DROP TABLE IF EXISTS `transaksis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tagihan_id` bigint(20) unsigned NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `metode` enum('online','cash') NOT NULL,
  `nominal_bayar` decimal(15,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `is_valid_kepala_sekolah` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksis_tagihan_id_foreign` (`tagihan_id`),
  CONSTRAINT `transaksis_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksis`
--

LOCK TABLES `transaksis` WRITE;
/*!40000 ALTER TABLE `transaksis` DISABLE KEYS */;
INSERT INTO `transaksis` VALUES (1,1,'Bayar Tunai di Loket','cash',150000.00,'2026-08-24',1,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,2,'bukti_bayar/sample.jpg','online',500000.00,'2026-09-01',0,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,3,'bukti_bayar/sample2.jpg','online',150000.00,'2026-08-29',1,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,7,'bukti_bayar/x6XkEFaHDd8O5HmXdZmeeeU87gZbx6xmvGjAdxWH.jpg','online',100000.00,'2026-09-03',0,'2026-09-03 03:26:27','2026-09-03 03:26:27');
/*!40000 ALTER TABLE `transaksis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','orang_tua','kepala_sekolah') NOT NULL DEFAULT 'orang_tua',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Sekolah','admin@tkit.com',NULL,'$2y$10$DzJ0KF37jQoE4kMc.eawnO6JeoFjLdLdf2aEkOjvQTz92mzNbWW5u','admin',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(2,'Administrator Utama','admin@gmail.com',NULL,'$2y$10$k73XejyRTwiTXD5JclhPousf1J21RWvkGi/ekH9NiSXi1CGBMY/jy','admin',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(3,'Hj. Aminah, M.Pd.','kepsek@tkit.com',NULL,'$2y$10$tYU566rzncYCNGfkqXpG8.m5xskIVWj8/oak7K0akhc.5x0EI1mRW','kepala_sekolah',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(4,'Budi Santoso (Wali Ahmad)','ortu@tkit.com',NULL,'$2y$10$fIURbxVr6AN9snohB.A7M.4z.MYu7u32p.6iAGQ9IaqdIWHL0l01C','orang_tua',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(5,'Bambang Pratama (Wali Aisyah)','budi@tkit.com',NULL,'$2y$10$Yns0GX1TsKVLgkKYoemFa.Fh.xl7e1hQC5weDm37.oJwdFW0rgPOC','orang_tua',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(6,'Siti Rahma (Wali Rizky)','siti@tkit.com',NULL,'$2y$10$JerCKcMa9Ac8uxafSuJ.7uiXZVs0rODsZryl.cKdRyItagJt69L0a','orang_tua',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59'),(7,'Dewi Safitri (Wali Nabila)','nabila_ortu@tkit.com',NULL,'$2y$10$ECt/ib57BoRONpZXj2k8pekwuYDtvL/aKDDh7FcxpnFf6TF2tkCIS','orang_tua',NULL,'2026-09-03 03:11:59','2026-09-03 03:11:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-03 20:04:38
