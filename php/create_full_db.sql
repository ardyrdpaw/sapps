-- Complete schema + seed data for the `sapps` database
-- Usage: mysql -u root -p < create_full_db.sql

CREATE DATABASE IF NOT EXISTS `sapps` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sapps`;

-- Drop existing tables if present (reverse dependency order)
DROP TABLE IF EXISTS `user_access`;
DROP TABLE IF EXISTS `menus`;
DROP TABLE IF EXISTS `inf_ti_items`;
DROP TABLE IF EXISTS `signage_items`;
DROP TABLE IF EXISTS `cat_items`;
DROP TABLE IF EXISTS `users`;

-- Users table (final schema including keterangan & preferences)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `username` VARCHAR(64) NOT NULL,
  `role` VARCHAR(32) DEFAULT 'user',
  `password` VARCHAR(255) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `preferences` TEXT DEFAULT NULL,
  UNIQUE KEY `uniq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`name`,`username`,`role`) VALUES
('Alice','alice','admin'),
('Bob','bob','user'),
('Charlie','charlie','user');

-- CAT items
CREATE TABLE `cat_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `status` VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cat_items` (`name`,`status`) VALUES
('Computer A','Active'),
('Computer B','Inactive'),
('Computer C','Active');

-- Signage items (content, playback flags, category)
CREATE TABLE `signage_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(200) NOT NULL,
  `content` TEXT,
  `type` VARCHAR(20) NOT NULL,
  `category` VARCHAR(64) DEFAULT '',
  `autoplay` TINYINT(1) DEFAULT 0,
  `loop` TINYINT(1) DEFAULT 0,
  `muted` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `signage_items` (`name`,`content`,`type`,`category`,`autoplay`,`loop`,`muted`) VALUES
('Welcome 1','Welcome to BKPSDM','Text','Text',0,0,0),
('Welcome 2','Thank You for Visiting','Text','Text',0,0,0),
('Video 1','assets/uploads/video1.mp4','Video','Video',1,1,1),
('Video 2','assets/uploads/video2.mp4','Video','Video',1,1,1),
('Galeri 1','assets/uploads/gallery1.jpg','Images','Galeri',0,0,0);

-- INF TI items (inventory) with sort_order + timestamps
CREATE TABLE `inf_ti_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sort_order` INT DEFAULT 0,
  `category` VARCHAR(32) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `detail` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `inf_ti_items` (`sort_order`,`category`,`name`,`detail`) VALUES
(1,'komputer','PC Ruang Admin','i5, 8GB, 256GB SSD'),
(1,'printer','HP LaserJet','Pro M404'),
(1,'jaringan','Switch Lantai 1','24 port Gigabit');

-- Menus (seeded list and protected flag)
CREATE TABLE `menus` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `menu_key` VARCHAR(100) NOT NULL UNIQUE,
  `label` VARCHAR(200) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `protected` TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `menus` (`menu_key`,`label`,`sort_order`,`protected`) VALUES
('dashboard','Home',1,0),
('cat','CAT',2,0),
('signage','Signage',3,0),
('user','Users',4,1),
('nomor_surat','Nomor Surat',5,0),
('pengadaan_asn','Pengadaan ASN',6,0),
('data_kepegawaian','Data Kepegawaian',7,0),
('menus','Menus',8,1);

-- User access permissions
CREATE TABLE `user_access` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `menu_key` VARCHAR(100) NOT NULL,
  `full` TINYINT(1) DEFAULT 0,
  `can_create` TINYINT(1) DEFAULT 0,
  `can_read` TINYINT(1) DEFAULT 0,
  `can_update` TINYINT(1) DEFAULT 0,
  `can_delete` TINYINT(1) DEFAULT 0,
  `visible` TINYINT(1) DEFAULT 0,
  UNIQUE KEY `ux_user_menu` (`user_id`,`menu_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Optionally seed some access (example: admin has full access to everything)
INSERT INTO `user_access` (`user_id`,`menu_key`,`full`,`can_create`,`can_read`,`can_update`,`can_delete`,`visible`)
SELECT u.id, m.menu_key, 1,1,1,1,1,1 FROM `users` u CROSS JOIN `menus` m WHERE u.username='alice';

-- End of script

-- Notes:
-- - Run this file as a user that has privileges to create databases (e.g., root).
-- - It creates a fresh `sapps` database and seeds a small set of sample data used by the app.
-- - If you prefer a migration-based approach, let me know and I can add a PHP migration that runs this file and/or preserves existing data.
