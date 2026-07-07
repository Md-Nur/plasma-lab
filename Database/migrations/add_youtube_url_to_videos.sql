-- Migration: Replace video file storage with YouTube URL
-- Run this once against your plasma_lab_ru database
-- Date: 2026-07-07

-- Step 1: Add youtube_url column
ALTER TABLE `videos`
    ADD COLUMN `youtube_url` VARCHAR(255) NOT NULL DEFAULT '' AFTER `info`;

-- Step 2: Drop old file-based columns (video file path & thumbnail image)
--         Only run after confirming youtube_url has been populated for all rows.
-- ALTER TABLE `videos` DROP COLUMN `video`;
-- ALTER TABLE `videos` DROP COLUMN `image`;

-- Populate existing rows with a placeholder so the NOT NULL constraint is satisfied
-- UPDATE `videos` SET `youtube_url` = 'https://www.youtube.com/watch?v=PLACEHOLDER' WHERE `youtube_url` = '';
