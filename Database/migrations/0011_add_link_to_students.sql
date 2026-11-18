-- Migration: Add link column to students table for external profiles (LinkedIn, ResearchGate, Website)

SET @exist_link := (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'students' 
    AND COLUMN_NAME = 'link');
SET @sqlstmt_link := IF(@exist_link = 0, 'ALTER TABLE `students` ADD COLUMN `link` VARCHAR(255) NOT NULL DEFAULT \'\' AFTER `email`', 'SELECT 1');
PREPARE stmt_link FROM @sqlstmt_link;
EXECUTE stmt_link;
DEALLOCATE PREPARE stmt_link;

-- Update Member 1 (Sir M R Talukder) link to active RU RFID profile
UPDATE `members` 
SET `link` = 'http://rurfid.ru.ac.bd/ru_profile/public/teacher/25400481/profile' 
WHERE `id` = 1 OR `email` = 'mrtalukder@ru.ac.bd';
