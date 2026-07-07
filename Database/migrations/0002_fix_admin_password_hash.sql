-- Migration: Fix admin password to use MD5 hash
--
-- The login.php script hashes the entered password with MD5 before comparing
-- against the database. Any plain-text password in admin_login will never match.
-- This migration ensures the admin password is stored as MD5('admin').

UPDATE `admin_login`
SET `password` = MD5('admin')
WHERE `username` = 'admin'
  AND `password` = 'admin';
