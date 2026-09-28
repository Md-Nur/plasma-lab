-- Migration: Add status to members (current or alumni)
-- Allows individual categorization of Faculty/Lab Members into Current and Alumni

ALTER TABLE `members`
    ADD COLUMN `status` ENUM('current', 'alumni') NOT NULL DEFAULT 'current';
