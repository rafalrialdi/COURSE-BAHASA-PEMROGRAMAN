

CREATE DATABASE IF NOT EXISTS `websiteku` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `websiteku`;

-- =====================================================
-- Tabel: users
-- =====================================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nomor` int(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `role` enum('admin','user','tutor') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabel: materi
-- =====================================================
CREATE TABLE `materi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL COMMENT 'Nama sesi/pertemuan',
  `tanggal` date DEFAULT NULL,
  `jadwal` enum('08.30 AM - 10.00 AM','11.00 AM - 12.30 PM','14.00 PM - 15.30 PM') NOT NULL,
  `materi` varchar(255) NOT NULL COMMENT 'Topik/judul materi',
  `gambar` varchar(255) DEFAULT NULL COMMENT 'Link download file materi',
  `status` varchar(50) NOT NULL COMMENT 'Status bebas, cth: Aktif, Selesai, dll',
  `kategori` enum('C++','Python','Java','JavaScript') NOT NULL COMMENT 'Kelas tujuan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabel: diskusi_post
-- =====================================================
CREATE TABLE `diskusi_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `like_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabel: diskusi_like
-- =====================================================
CREATE TABLE `diskusi_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `diskusi_like_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `diskusi_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Tabel: diskusi_komentar
-- =====================================================
CREATE TABLE `diskusi_komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `diskusi_komentar_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `diskusi_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- =====================================================
-- DATA DUMMY / CONTOH
-- =====================================================

-- -----------------------------------------------------
-- PENTING: Password di bawah ini PLACEHOLDER dan BELUM VALID.
-- Sebelum import, ikuti langkah di README bagian "Setup Akun Admin"
-- untuk generate hash password yang benar, lalu ganti nilai kolom
-- `password` pada baris admin di bawah ini.
-- -----------------------------------------------------

INSERT INTO `users` (`username`, `password`, `nomor`, `email`, `role`) VALUES
('admin', '$2y$10$4GZcu5WONvera8V/caGXT.LzkOR3vTytdzZ7uZSzLKrEuCemAlb36', 812345678, 'admin@unpam.ac', 'admin'),
('tutor1', '$2y$10$NPtnt4/k3yCqmLCBA3wy3uVSReb1Jmrz6zVDxR3euOdZtKSA108Xu', 812345679, 'tutor1@unpam.ac', 'tutor'),
('user1', '$2y$10$OIUZ1zHUKwo3UT6s3GOaTOUfCBw8gl/hbQJeKf/X6zovL/0q0H51G', 812345680, 'user1@unpam.ac', 'user');

INSERT INTO `materi` (`nama`, `tanggal`, `jadwal`, `materi`, `gambar`, `status`, `kategori`) VALUES
('Rafal Rialdi', '2026-02-10', '08.30 AM - 10.00 AM', 'Pengenalan C++ & Struktur Dasar', 'materi/c++.pdf', 'Aktif', 'C++'),
('Rezki Fajar Pratama', '2026-02-11', '11.00 AM - 12.30 PM', 'Dasar Python & Tipe Data', 'materi/python.pdf', 'Aktif', 'Python'),
('Faruqh Fatihul Ikwan', '2026-02-12', '14.00 PM - 15.30 PM', 'OOP Dasar di Java', 'materi/java.pdf', 'Aktif', 'Java'),
('Rehan Al Amin', '2026-02-13', '08.30 AM - 10.00 AM', 'Pengenalan JavaScript & DOM', 'materi/js.pdf', 'Aktif', 'JavaScript');

INSERT INTO `diskusi_post` (`username`, `isi`, `like_count`, `created_at`) VALUES
('admin', 'Selamat datang di forum diskusi! Silakan bertanya seputar materi pemrograman di sini.', 0, NOW());