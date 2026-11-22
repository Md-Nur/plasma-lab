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
  `image`     varchar(500) NOT NULL DEFAULT '',
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
  `image`       varchar(500) NOT NULL DEFAULT 'https://i.ibb.co/7tskC0HV/demo-image.png',
  `phone`       varchar(50)  NOT NULL DEFAULT '',
  `email`       varchar(255) NOT NULL DEFAULT '',
  `info`        text,
  `link`        varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── students ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `students` (
  `id`       int(11)      NOT NULL AUTO_INCREMENT,
  `image`    varchar(500) NOT NULL DEFAULT '',
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
  `image` varchar(500) NOT NULL DEFAULT 'https://i.ibb.co/7tskC0HV/demo-image.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── activities ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `activities` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(500) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `info`  text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── areas ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `areas` (
  `id`    int(11)      NOT NULL AUTO_INCREMENT,
  `image` varchar(500) NOT NULL DEFAULT '',
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
  `image`     varchar(500) NOT NULL DEFAULT '',
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
  `image` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── instruments ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `instruments` (
  `id`            int(11)      NOT NULL AUTO_INCREMENT,
  `image`         varchar(500) NOT NULL DEFAULT '',
  `name`          varchar(255) NOT NULL DEFAULT '',
  `description`   text         NOT NULL,
  `specifications` text        NOT NULL DEFAULT '',
  `status`        enum('active','maintenance','retired') NOT NULL DEFAULT 'active',
  `created_at`    timestamp    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── services ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `services` (
  `id`          int(11)       NOT NULL AUTO_INCREMENT,
  `title`       varchar(255)  NOT NULL,
  `description` text          NOT NULL,
  `tags`        varchar(255)  NOT NULL DEFAULT '',
  `icon`        varchar(100)  NOT NULL DEFAULT 'fa-cogs',
  `status`      enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`  timestamp     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── products ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `products` (
  `id`             int(11)       NOT NULL AUTO_INCREMENT,
  `name`           varchar(255)  NOT NULL,
  `badge`          varchar(100)  NOT NULL DEFAULT 'Plasma System',
  `badge_theme`    varchar(50)   NOT NULL DEFAULT 'teal',
  `icon_emoji`     varchar(50)   NOT NULL DEFAULT '⚡',
  `description`    text          NOT NULL,
  `specifications` text          NOT NULL DEFAULT '',
  `status`         enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`     timestamp     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default services
INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 1, 'Surface Modification & Treatment', 'Plasma-based surface treatment to improve wettability, adhesion, sterilization, and biocompatibility of polymers, metals, and bio-materials using DBD and atmospheric plasma jets.', 'DBD Plasma, Wettability, Adhesion, Biocompatibility', 'fa-bolt', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 1);

INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 2, 'Nanomaterial Synthesis', 'Controlled synthesis of metal nanoparticles, carbon nanostructures, and functional thin films via plasma-assisted deposition and reactive sputtering processes.', 'Nanoparticles, Thin Films, Sputtering, Carbon Nanotubes', 'fa-circle-o', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 2);

INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 3, 'Thin Film Deposition', 'Physical and chemical vapor deposition of functional coatings including anti-reflection, hard coatings, and dielectric layers for optical and electronic applications.', 'PVD, CVD, Optical Coatings, Hard Coatings', 'fa-television', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 3);

INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 4, 'Consulting & Analytical Testing', 'Material characterization using XRD, SEM, UV-Vis spectroscopy, and plasma diagnostics. Expert consultation on experimental design for industry and academic research teams.', 'XRD Analysis, SEM/TEM, UV-Vis, Consulting', 'fa-bar-chart', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 4);

INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 5, 'Plasma Agriculture & Biomedical', 'Cold plasma treatment for seed germination enhancement, food safety, wound disinfection, and cancer research applications using non-thermal atmospheric plasma systems.', 'Cold Plasma, Seed Treatment, Sterilization, Biomedical', 'fa-medkit', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 5);

INSERT INTO `services` (`id`, `title`, `description`, `tags`, `icon`, `status`)
SELECT 6, 'Lab Visit & Training Programs', 'Guided lab tours, short-course workshops, and hands-on training sessions for students and researchers on plasma physics fundamentals and equipment operation.', 'Workshop, Training, Lab Tour, Researchers', 'fa-graduation-cap', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `id` = 6);

-- Seed default products
INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 1, 'Atmospheric Pressure Plasma Jet (APPJ)', 'Plasma System', 'teal', '⚡', 'Compact, bench-top plasma jet systems for surface treatment, biomedical, and environmental applications. Operates at room temperature — safe for heat-sensitive substrates.', 'Frequency: 1–100 kHz operation\nWorking gases: He, Ar, N₂, air mixtures\nPlasma temperature: Near room temperature\nCustom nozzle configurations available', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 1);

INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 2, 'Dielectric Barrier Discharge (DBD) Reactor', 'Discharge System', 'plum', '🔬', 'High-efficiency DBD reactors for ozone generation, pollutant decomposition, and large-area surface activation. Scalable electrode configurations for lab and pilot scale.', 'Voltage: Up to 30 kV peak\nTreatment area: 5 × 5 cm to 30 × 30 cm\nPower: 10W–2kW configurations\nAir and nitrogen compatible', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 2);

INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 3, 'Plasma Synthesis Accessories & Probes', 'Accessories', 'coral', '🧪', 'Langmuir probes, high-voltage power supplies, impedance matching networks, and diagnostic accessories for plasma parameter measurement and system optimization.', 'Single & double Langmuir probes\nHigh-voltage measurement dividers\nImpedance matching (13.56 MHz, 2.45 GHz)\nCustom-designed on request', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 3);

-- Seed default areas
INSERT INTO `areas` (`id`, `image`, `title`, `info`)
SELECT 1, 'https://i.ibb.co/rGdH5q13/1525859533.jpg', 'Atmospheric Non-Thermal Plasma', 'Generation, diagnostics, and characterization of cold atmospheric pressure plasmas (DBD, APPJ) and investigation of active reactive species for industrial and biological applications.'
WHERE NOT EXISTS (SELECT 1 FROM `areas` WHERE `id` = 1);

INSERT INTO `areas` (`id`, `image`, `title`, `info`)
SELECT 2, 'https://i.ibb.co/0RZSMWCL/1526729574.jpg', 'Plasma Agriculture & Food Science', 'Enhancing crop yield, seed germination acceleration, and microbial decontamination using direct cold plasma exposure and Plasma-Activated Water (PAW).'
WHERE NOT EXISTS (SELECT 1 FROM `areas` WHERE `id` = 2);

INSERT INTO `areas` (`id`, `image`, `title`, `info`)
SELECT 3, 'https://i.ibb.co/jxFqJfn/1532398637.png', 'Thin Film Deposition & Nanomaterials', 'Plasma-assisted chemical and physical vapor deposition of functional thin films, protective coatings, and nanostructured materials for electronic and optical devices.'
WHERE NOT EXISTS (SELECT 1 FROM `areas` WHERE `id` = 3);

INSERT INTO `areas` (`id`, `image`, `title`, `info`)
SELECT 4, 'https://i.ibb.co/SX85nrJn/1783381676.png', 'Plasma Medicine & Sterilization', 'Harnessing Reactive Oxygen and Nitrogen Species (RONS) generated by cold plasma for wound healing, biomedical material surface activation, and pathogen eradication.'
WHERE NOT EXISTS (SELECT 1 FROM `areas` WHERE `id` = 4);

-- Seed default instruments
INSERT INTO `instruments` (`id`, `image`, `name`, `description`, `specifications`, `status`)
SELECT 1, 'https://i.ibb.co/WWr3F58t/Whats-App-Image-2026-11-12-at-10-34-23-AM.jpg', 'Cold Atmospheric Pressure Plasma Jet (APPJ)', 'High-voltage AC/RF driven atmospheric plasma jet system with mass flow controllers for argon, helium, and reactive gas mixtures.', 'Frequency: 10 kHz – 50 kHz\nApplied Voltage: 0 – 20 kV peak-to-peak\nWorking Gas: He, Ar, O2, N2\nOperating Temp: Room temperature (25°C - 35°C)\nApplications: Biomedical, agriculture, polymer treatment', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `instruments` WHERE `id` = 1);

INSERT INTO `instruments` (`id`, `image`, `name`, `description`, `specifications`, `status`)
SELECT 2, 'https://i.ibb.co/DgVDZCy5/1525857843.jpg', 'Dielectric Barrier Discharge (DBD) Plasma Reactor', 'Planar DBD reactor with quartz dielectric barriers for large-area uniform surface modification, ozone synthesis, and seed treatment.', 'Electrode Configuration: Parallel planar, 100 x 100 mm\nDielectric: High-purity Quartz (1.5 mm thick)\nDischarge Gap: 1 mm – 10 mm adjustable\nPower Supply: 0-30 kV, 50 Hz - 20 kHz\nGas Flow: Ambient air, O2, N2, CO2', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `instruments` WHERE `id` = 2);

INSERT INTO `instruments` (`id`, `image`, `name`, `description`, `specifications`, `status`)
SELECT 3, 'https://i.ibb.co/DTchqSr/1525857898.jpg', 'Optical Emission Spectrometer (OES)', 'High-resolution UV-Vis-NIR spectrometer configured for real-time plasma diagnostic measurements, emission spectrum analysis, and radical species identification.', 'Spectral Range: 200 nm – 900 nm\nOptical Resolution: < 0.5 nm FWHM\nDetector: 2048-pixel linear CCD array\nIntegration Time: 1 ms to 65 seconds\nFiber Optic: Solarization-resistant quartz fiber', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `instruments` WHERE `id` = 3);

INSERT INTO `instruments` (`id`, `image`, `name`, `description`, `specifications`, `status`)
SELECT 4, 'https://i.ibb.co/Sw5xP5Wr/1526478304.png', 'High-Voltage Storage Oscilloscope & Probes', '4-channel high-bandwidth digital oscilloscope coupled with calibrated 1000:1 high-voltage probes and current monitors for electrical discharge characterization.', 'Bandwidth: 200 MHz, 4 Channels\nSample Rate: 2 GSa/s\nHV Probe: 1000:1 attenuation, up to 40 kV peak\nCurrent Monitor: Rogowski coil / Pearson current monitor\nDiagnostics: Lissajous Q-V charge-voltage analysis', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `instruments` WHERE `id` = 4);


