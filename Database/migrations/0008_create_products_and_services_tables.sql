-- Migration: Create services and products tables for dynamic Products & Services management

CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT(11)       NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(255)  NOT NULL,
  `description` TEXT          NOT NULL,
  `tags`        VARCHAR(255)  NOT NULL DEFAULT '',
  `icon`        VARCHAR(100)  NOT NULL DEFAULT 'fa-cogs',
  `status`      ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `products` (
  `id`             INT(11)       NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(255)  NOT NULL,
  `badge`          VARCHAR(100)  NOT NULL DEFAULT 'Plasma System',
  `badge_theme`    VARCHAR(50)   NOT NULL DEFAULT 'teal',
  `icon_emoji`     VARCHAR(50)   NOT NULL DEFAULT '⚡',
  `description`    TEXT          NOT NULL,
  `specifications` TEXT          NOT NULL DEFAULT '',
  `status`         ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`     TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default services if table is empty
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

-- Seed default products if table is empty
INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 1, 'Atmospheric Pressure Plasma Jet (APPJ)', 'Plasma System', 'teal', '⚡', 'Compact, bench-top plasma jet systems for surface treatment, biomedical, and environmental applications. Operates at room temperature — safe for heat-sensitive substrates.', 'Frequency: 1–100 kHz operation\nWorking gases: He, Ar, N₂, air mixtures\nPlasma temperature: Near room temperature\nCustom nozzle configurations available', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 1);

INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 2, 'Dielectric Barrier Discharge (DBD) Reactor', 'Discharge System', 'plum', '🔬', 'High-efficiency DBD reactors for ozone generation, pollutant decomposition, and large-area surface activation. Scalable electrode configurations for lab and pilot scale.', 'Voltage: Up to 30 kV peak\nTreatment area: 5 × 5 cm to 30 × 30 cm\nPower: 10W–2kW configurations\nAir and nitrogen compatible', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 2);

INSERT INTO `products` (`id`, `name`, `badge`, `badge_theme`, `icon_emoji`, `description`, `specifications`, `status`)
SELECT 3, 'Plasma Synthesis Accessories & Probes', 'Accessories', 'coral', '🧪', 'Langmuir probes, high-voltage power supplies, impedance matching networks, and diagnostic accessories for plasma parameter measurement and system optimization.', 'Single & double Langmuir probes\nHigh-voltage measurement dividers\nImpedance matching (13.56 MHz, 2.45 GHz)\nCustom-designed on request', 'active'
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `id` = 3);
