-- Migration: Add image support to services and products tables and seed updated images

-- Add image column to services if not exists
SET @exist_srv := (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'services' 
    AND COLUMN_NAME = 'image');
SET @sqlstmt_srv := IF(@exist_srv = 0, 'ALTER TABLE `services` ADD COLUMN `image` VARCHAR(255) NOT NULL DEFAULT \'\' AFTER `icon`', 'SELECT 1');
PREPARE stmt_srv FROM @sqlstmt_srv;
EXECUTE stmt_srv;
DEALLOCATE PREPARE stmt_srv;

-- Add image column to products if not exists
SET @exist_prd := (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'products' 
    AND COLUMN_NAME = 'image');
SET @sqlstmt_prd := IF(@exist_prd = 0, 'ALTER TABLE `products` ADD COLUMN `image` VARCHAR(255) NOT NULL DEFAULT \'\' AFTER `icon_emoji`', 'SELECT 1');
PREPARE stmt_prd FROM @sqlstmt_prd;
EXECUTE stmt_prd;
DEALLOCATE PREPARE stmt_prd;

-- Update existing services with uploaded images
UPDATE `services` SET `image` = 'images/activities/Consulting.png' WHERE `id` = 4 OR `title` LIKE '%Consulting%';
UPDATE `services` SET `image` = 'images/activities/Lab training.jpeg' WHERE `id` = 6 OR `title` LIKE '%Lab Visit%';
UPDATE `services` SET `image` = 'images/instruments/Film Deposition Using Plasma.png' WHERE `id` = 3 OR `title` LIKE '%Thin Film%';

-- Add or update Industrial Light Source Spectral Characterization Service
INSERT INTO `services` (`title`, `description`, `tags`, `icon`, `image`, `status`)
SELECT 'Industrial Light Source Spectral Characterization Service', 
       'High-precision spectral irradiance calibration, wavelength verification, and optical emission diagnostics for industrial lighting, plasma lamps, and UV/visible emitters.', 
       'Spectral Analysis, Irradiance, Optical Diagnostics, Calibration', 
       'fa-sun-o', 
       'images/activities/Industrial Light Source Spectral Characterization Service.jpeg', 
       'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `title` LIKE '%Industrial Light Source%');

UPDATE `services` SET `image` = 'images/activities/Industrial Light Source Spectral Characterization Service.jpeg' 
WHERE `title` LIKE '%Industrial Light Source%';

-- Update product image
UPDATE `products` SET `image` = 'images/instruments/Film Deposition Using Plasma.png' WHERE `id` = 1 OR `id` = 3;
