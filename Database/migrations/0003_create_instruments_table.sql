-- Migration: Create instruments table for lab instruments/equipment
-- Stores details about laboratory instruments with image, name, description and specifications

CREATE TABLE IF NOT EXISTS `instruments` (
  `id`            INT(11)       NOT NULL AUTO_INCREMENT,
  `image`         VARCHAR(255)  NOT NULL DEFAULT '',
  `name`          VARCHAR(255)  NOT NULL,
  `description`   TEXT          NOT NULL,
  `specifications` TEXT         NOT NULL DEFAULT '',
  `status`        ENUM('active','maintenance','retired') NOT NULL DEFAULT 'active',
  `created_at`    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
