-- Migration: Create admin_login table and insert default admin user
-- This table was missing from the baseline SQL dump.
--
-- Default credentials:
--   Username: admin
--   Password: admin  (stored as MD5 hash)
--
-- IMPORTANT: Change the password immediately after your first login!

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id`        int(11)       NOT NULL AUTO_INCREMENT,
  `username`  varchar(255)  NOT NULL DEFAULT 'admin',
  `password`  varchar(255)  NOT NULL,
  `email`     varchar(255)  NOT NULL DEFAULT '',
  `firstname` varchar(255)  NOT NULL DEFAULT 'Admin',
  `lastname`  varchar(255)  NOT NULL DEFAULT 'User',
  `phone`     varchar(20)   NOT NULL DEFAULT '',
  `image`     varchar(255)  NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert the default admin row only if the table is empty.
-- Password is MD5('admin') = 21232f297a57a5a743894a0e4a801fc3
INSERT INTO `admin_login` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `image`)
SELECT 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'Admin', 'User', '', ''
WHERE NOT EXISTS (SELECT 1 FROM `admin_login`);
