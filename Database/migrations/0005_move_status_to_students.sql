-- Migration: Remove status from members, add status to students

-- Step 1: Remove status from members (revert migration 0004)
ALTER TABLE `members` DROP COLUMN `status`;

-- Step 2: Add status to students
ALTER TABLE `students`
    ADD COLUMN `status` ENUM('current', 'alumni') NOT NULL DEFAULT 'current'
    AFTER `email`;
