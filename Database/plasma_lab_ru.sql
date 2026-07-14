-- Plasma Engineering Laboratory — base database schema
--
-- This replaces the previous committed dump (which belonged to an unrelated
-- project and lacked this application's tables). It creates every table the
-- application code expects. Migrations in Database/migrations/ apply incremental
-- changes on top of this baseline (e.g. admin_login, instruments, members/
-- students status, videos youtube_url) and use IF NOT EXISTS / conditionals so
-- re-running is safe.
--
-- NOTE: columns added by later migrations are intentionally omitted here:
--   - members/students `status`  (added by 0004 / 0005)
--   - videos `youtube_url`       (added by add_youtube_url_to_videos.sql)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

-- ── website ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `website` (
  `id`           int(11)      NOT NULL AUTO_INCREMENT,
  `sitename`     varchar(255) NOT NULL DEFAULT '',
  `short_name`   varchar(255) NOT NULL DEFAULT '',
  `siteemail`    varchar(255) NOT NULL DEFAULT '',
  `sitepassword` varchar(255) NOT NULL DEFAULT '',
  `department`   varchar(255) NOT NULL DEFAULT '',
  `university`   varchar(255) NOT NULL DEFAULT '',
  `founder`      varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `website` (`id`, `sitename`, `short_name`, `siteemail`, `sitepassword`, `department`, `university`, `founder`)
VALUES (1, 'Plasma Engineering Laboratory', 'PEL', '', '', 'Department of Physics', 'University of Rajshahi', '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── admin_login ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `admin_login` (
  `id`        int(11)      NOT NULL AUTO_INCREMENT,
  `username`  varchar(255) NOT NULL DEFAULT 'admin',
  `password`  varchar(255) NOT NULL,
  `email`     varchar(255) NOT NULL DEFAULT '',
  `firstname` varchar(255) NOT NULL DEFAULT 'Admin',
  `lastname`  varchar(255) NOT NULL DEFAULT 'User',
  `phone`     varchar(20)  NOT NULL DEFAULT '',
  `image`     varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin: username "admin", password "admin" (md5). Change after first login.
INSERT INTO `admin_login` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `image`)
SELECT 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'Admin', 'User', '', ''
WHERE NOT EXISTS (SELECT 1 FROM `admin_login`);

-- ── members ──────────────────────────────────────────────
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

-- ── students ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `students` (
  `id`       int(11)      NOT NULL AUTO_INCREMENT,
  `image`    varchar(255) NOT NULL DEFAULT '',
  `name`     varchar(255) NOT NULL DEFAULT '',
  `session`  varchar(100) NOT NULL DEFAULT '',
  `email`    varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── videos ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `videos` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  `image` varchar(255) NOT NULL DEFAULT 'demo_image.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── activities ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `activities` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── areas ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `areas` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── vission ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `vission` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `title`       varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vission` (`id`, `title`, `description`)
VALUES (1, 'Our Vision', '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── about ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `about` (
  `id`    int(11) NOT NULL AUTO_INCREMENT,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about` (`id`, `about`)
VALUES (1, '')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- ── slider ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `slider` (
  `id`        int(11)      NOT NULL AUTO_INCREMENT,
  `image`     varchar(255) NOT NULL DEFAULT '',
  `title`     varchar(255) NOT NULL DEFAULT '',
  `sub_title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── message ──────────────────────────────────────────────
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

-- ── sent_msg ─────────────────────────────────────────────
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

-- ── notice ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `notice` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `title`       varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── journal ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `journal` (
  `id`      int(11) NOT NULL AUTO_INCREMENT,
  `journal` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── conference ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `conference` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `conference` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── photos ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `photos` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── instruments ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `instruments` (
  `id`            int(11)      NOT NULL AUTO_INCREMENT,
  `image`         varchar(255) NOT NULL DEFAULT '',
  `name`          varchar(255) NOT NULL DEFAULT '',
  `description`   text         NOT NULL,
  `specifications` text        NOT NULL DEFAULT '',
  `status`        enum('active','maintenance','retired') NOT NULL DEFAULT 'active',
  `created_at`    timestamp    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
