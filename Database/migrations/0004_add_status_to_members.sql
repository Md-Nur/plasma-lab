-- Migration: Add status column to members table
-- status: 'current' (default) or 'alumni'

ALTER TABLE `members`
    ADD COLUMN `status` ENUM('current', 'alumni') NOT NULL DEFAULT 'current'
    AFTER `link`;
