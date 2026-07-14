-- Migration: Create core application tables
--
-- The committed baseline (Database/plasma_lab_ru.sql) was a dump from an
-- unrelated project and did NOT contain this application's tables, so the site
-- failed to boot. This migration creates every table the code expects, using
-- CREATE TABLE IF NOT EXISTS so it is safe to re-run and safe to run after the
-- baseline import (it becomes a no-op for already-existing tables).
--
-- Ordering note: this is named 0006 so it runs AFTER the baseline import and
-- after migrations 0001-0005 / add_youtube_url_to_videos, which only ALTER the
-- members / students / videos tables created here.

-- ── website (site settings: name, email credentials, dept, university, founder)
CREATE TABLE IF NOT EXISTS `website` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `sitename`    varchar(255) NOT NULL DEFAULT '',
  `short_name`  varchar(255) NOT NULL DEFAULT '',
  `siteemail`   varchar(255) NOT NULL DEFAULT '',
  `sitepassword` varchar(255) NOT NULL DEFAULT '',
  `department`  varchar(255) NOT NULL DEFAULT '',
  `university`  varchar(255) NOT NULL DEFAULT '',
  `founder`     varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `website` (`id`, `sitename`, `short_name`, `siteemail`, `sitepassword`, `department`, `university`, `founder`)
VALUES (1, 'Plasma Engineering Laboratory', 'PEL', '', '', 'Department of Physics', 'University of Rajshahi', '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── members (lab members / faculty)
CREATE TABLE IF NOT EXISTS `members` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `name`        varchar(255) NOT NULL DEFAULT '',
  `designation` varchar(255) NOT NULL DEFAULT '',
  `image`       varchar(255) NOT NULL DEFAULT 'demo_image.png',
  `phone`       varchar(50)  NOT NULL DEFAULT '',
  `email`       varchar(255) NOT NULL DEFAULT '',
  `info`        text,
  `link`        varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── students (current / alumni)
CREATE TABLE IF NOT EXISTS `students` (
  `id`       int(11)      NOT NULL AUTO_INCREMENT,
  `image`    varchar(255) NOT NULL DEFAULT '',
  `name`     varchar(255) NOT NULL DEFAULT '',
  `session`  varchar(100) NOT NULL DEFAULT '',
  `email`    varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── videos (homepage featured videos; youtube_url added by add_youtube_url_to_videos.sql)
CREATE TABLE IF NOT EXISTS `videos` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  `image` varchar(255) NOT NULL DEFAULT 'demo_image.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── activities (homepage research activities cards)
CREATE TABLE IF NOT EXISTS `activities` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── areas (research areas page)
CREATE TABLE IF NOT EXISTS `areas` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── vission (homepage vision block)
CREATE TABLE IF NOT EXISTS `vission` (
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `title`       varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vission` (`id`, `title`, `description`)
VALUES (1, 'Our Vision', '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── about (welcome / about text on the slider)
CREATE TABLE IF NOT EXISTS `about` (
  `id`    int(11) NOT NULL AUTO_INCREMENT,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about` (`id`, `about`)
VALUES (1, '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── slider (welcome slider images)
CREATE TABLE IF NOT EXISTS `slider` (
  `id`        int(11)      NOT NULL AUTO_INCREMENT,
  `image`     varchar(255) NOT NULL DEFAULT '',
  `title`     varchar(255) NOT NULL DEFAULT '',
  `sub_title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── message (public contact-form submissions / inbox)
CREATE TABLE IF NOT EXISTS `message` (
  `id`      int(11)      NOT NULL AUTO_INCREMENT,
  `name`    varchar(255) NOT NULL DEFAULT '',
  `email`   varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `msg`     text,
  `time`    varchar(50)  NOT NULL DEFAULT '',
  `date`    varchar(50)  NOT NULL DEFAULT '',
  `flag`    tinyint(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── sent_msg (admin sent messages / drafts; success: 1=sent, 0=draft)
CREATE TABLE IF NOT EXISTS `sent_msg` (
  `id`      int(11)      NOT NULL AUTO_INCREMENT,
  `name`    varchar(255) NOT NULL DEFAULT '',
  `email`   varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `msg`     text,
  `time`    varchar(50)  NOT NULL DEFAULT '',
  `date`    varchar(50)  NOT NULL DEFAULT '',
  `success` tinyint(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── notice (news / notices)
CREATE TABLE IF NOT EXISTS `notice` (
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `title`       varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── journal (publications - journals)
CREATE TABLE IF NOT EXISTS `journal` (
  `id`      int(11) NOT NULL AUTO_INCREMENT,
  `journal` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── conference (publications - conferences)
CREATE TABLE IF NOT EXISTS `conference` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `conference` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── photos (gallery images)
CREATE TABLE IF NOT EXISTS `photos` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
