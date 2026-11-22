-- Migration 0014: Migrate all image references to ImgBB hosted URLs

ALTER TABLE `admin_login` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `members` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `students` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `activities` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `areas` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `slider` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `photos` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `instruments` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `services` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";
ALTER TABLE `products` MODIFY COLUMN `image` VARCHAR(500) NOT NULL DEFAULT "";

UPDATE `members` SET `image` = "https://i.ibb.co/0VsQC0n1/M-M-Rashid.jpg" WHERE `image` = "M_M_Rashid.JPG" OR `image` = "images/member/members/M_M_Rashid.JPG";
UPDATE `members` SET `image` = "https://i.ibb.co/XfNCkdTX/M-S-Alam.jpg" WHERE `image` = "M_S_Alam.JPG" OR `image` = "images/member/members/M_S_Alam.JPG";
UPDATE `members` SET `image` = "https://i.ibb.co/XkK15y7f/M-R-Talukder.jpg" WHERE `image` = "M_R_Talukder.JPG" OR `image` = "images/member/members/M_R_Talukder.JPG";
UPDATE `members` SET `image` = "https://i.ibb.co/G4XJmBd0/IMG-0325.jpg" WHERE `image` = "IMG_0325.jpg" OR `image` = "images/member/members/IMG_0325.jpg";
UPDATE `members` SET `image` = "https://i.ibb.co/9kdXpT3G/1526723737.jpg" WHERE `image` = "1526723737.jpg" OR `image` = "images/member/members/1526723737.jpg";
UPDATE `members` SET `image` = "https://i.ibb.co/0yrVtZVN/M-G-Hafez.jpg" WHERE `image` = "M_G_Hafez.JPG" OR `image` = "images/member/members/M_G_Hafez.JPG";
UPDATE `members` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/member/members/demo_image.png";

UPDATE `students` SET `image` = "https://i.ibb.co/gZ3ghnh9/1526727399.jpg" WHERE `image` = "1526727399.jpg" OR `image` = "images/member/students/1526727399.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/r2KpGb5c/1526723927.jpg" WHERE `image` = "1526723927.jpg" OR `image` = "images/member/students/1526723927.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/gZgghV6m/1526723853.jpg" WHERE `image` = "1526723853.jpg" OR `image` = "images/member/students/1526723853.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/V5xDcv7/1526723884.jpg" WHERE `image` = "1526723884.jpg" OR `image` = "images/member/students/1526723884.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/Tq1M2Gkv/1526727434.jpg" WHERE `image` = "1526727434.jpg" OR `image` = "images/member/students/1526727434.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/z9Mxwy3/1526727424.jpg" WHERE `image` = "1526727424.jpg" OR `image` = "images/member/students/1526727424.jpg";
UPDATE `students` SET `image` = "https://i.ibb.co/dwZjwmMz/A-K-Azad.jpg" WHERE `image` = "A_K_Azad.JPG" OR `image` = "images/member/students/A_K_Azad.JPG";
UPDATE `students` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/member/students/demo_image.png";

UPDATE `slider` SET `image` = "https://i.ibb.co/GfpsCyG8/1525857564.jpg" WHERE `image` = "1525857564.jpg" OR `image` = "images/slider/1525857564.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/DgVDZCy5/1525857843.jpg" WHERE `image` = "1525857638.jpg" OR `image` = "images/slider/1525857638.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/0RZSMWCL/1526729574.jpg" WHERE `image` = "1525857723.jpg" OR `image` = "images/slider/1525857723.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/VpQmjz1M/Group-photo.jpg" WHERE `image` = "1526475478.jpg" OR `image` = "images/slider/1526475478.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/0RRQmxw2/1526475948.jpg" WHERE `image` = "1526475948.jpg" OR `image` = "images/slider/1526475948.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/yFDgtCDL/1526476067.jpg" WHERE `image` = "1526476067.jpg" OR `image` = "images/slider/1526476067.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/Sw5xP5Wr/1526478304.png" WHERE `image` = "1526476469.jpg" OR `image` = "images/slider/1526476469.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/1GYB9cnP/1526477654.jpg" WHERE `image` = "1526477654.jpg" OR `image` = "images/slider/1526477654.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/B2YVw7TF/1526478552.jpg" WHERE `image` = "1526477931.jpg" OR `image` = "images/slider/1526477931.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/LDk3LXx6/1526478075.jpg" WHERE `image` = "1526478075.jpg" OR `image` = "images/slider/1526478075.jpg";
UPDATE `slider` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/slider/demo_image.png";

UPDATE `activities` SET `image` = "https://i.ibb.co/JWYX77bH/1525827811.jpg" WHERE `image` = "1525827811.jpg" OR `image` = "images/activities/1525827811.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/DgVDZCy5/1525857843.jpg" WHERE `image` = "1525857843.jpg" OR `image` = "images/activities/1525857843.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/DTchqSr/1525857898.jpg" WHERE `image` = "1525857898.jpg" OR `image` = "images/activities/1525857898.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/Sw5xP5Wr/1526478304.png" WHERE `image` = "1526478304.jpg" OR `image` = "images/activities/1526478304.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/B2YVw7TF/1526478552.jpg" WHERE `image` = "1526478552.jpg" OR `image` = "images/activities/1526478552.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/4qCsXJ9/1532398192.png" WHERE `image` = "1532398192.jpg" OR `image` = "images/activities/1532398192.jpg";
UPDATE `activities` SET `image` = "https://i.ibb.co/jvGs6D61/Consulting.jpg" WHERE `image` = "Consulting.png" OR `image` = "images/activities/Consulting.png";
UPDATE `activities` SET `image` = "https://i.ibb.co/7JGJWdh0/Industrial-Light-Source-Spectral-Characterization-Service.jpg" WHERE `image` = "Industrial Light Source Spectral Characterization Service.jpeg" OR `image` = "images/activities/Industrial Light Source Spectral Characterization Service.jpeg";
UPDATE `activities` SET `image` = "https://i.ibb.co/Kp15yzCn/Lab-training.jpg" WHERE `image` = "Lab training.jpeg" OR `image` = "images/activities/Lab training.jpeg";
UPDATE `activities` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/activities/demo_image.png";

UPDATE `areas` SET `image` = "https://i.ibb.co/DgVDZCy5/1525857843.jpg" WHERE `image` = "1525859259.jpg" OR `image` = "images/areas/1525859259.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/DTchqSr/1525857898.jpg" WHERE `image` = "1525859372.jpg" OR `image` = "images/areas/1525859372.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/rGdH5q13/1525859533.jpg" WHERE `image` = "1525859533.jpg" OR `image` = "images/areas/1525859533.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/Sw5xP5Wr/1526478304.png" WHERE `image` = "1526729527.jpg" OR `image` = "images/areas/1526729527.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/0RZSMWCL/1526729574.jpg" WHERE `image` = "1526729574.jpg" OR `image` = "images/areas/1526729574.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/210Nkwhy/aa.jpg" WHERE `image` = "1527029587.jpg" OR `image` = "images/areas/1527029587.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/jxFqJfn/1532398637.png" WHERE `image` = "1532398637.jpg" OR `image` = "images/areas/1532398637.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/SX85nrJn/1783381676.png" WHERE `image` = "1783381676.jpg" OR `image` = "images/areas/1783381676.jpg";
UPDATE `areas` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/areas/demo_image.png";

UPDATE `photos` SET `image` = "https://i.ibb.co/PvFpWSBF/1526478916.jpg" WHERE `image` = "1526478916.jpg" OR `image` = "images/gallary/photos/1526478916.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/fz6qY5v1/1526480243.jpg" WHERE `image` = "1526480243.jpg" OR `image` = "images/gallary/photos/1526480243.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/s9nFLCJy/1526480338.jpg" WHERE `image` = "1526480338.jpg" OR `image` = "images/gallary/photos/1526480338.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/JjkN7t2f/1526727496.jpg" WHERE `image` = "1526727496.jpg" OR `image` = "images/gallary/photos/1526727496.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/7xV8vCxB/1526727503.jpg" WHERE `image` = "1526727503.jpg" OR `image` = "images/gallary/photos/1526727503.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/ZzNzn7Wq/GAD-Blast-fungus-treatment.jpg" WHERE `image` = "GAD_Blast_fungus_treatment.JPG" OR `image` = "images/gallary/photos/GAD_Blast_fungus_treatment.JPG";
UPDATE `photos` SET `image` = "https://i.ibb.co/JjkN7t2f/1526727496.jpg" WHERE `image` = "GAD_Blast_fungus_treatment2.jpg" OR `image` = "images/gallary/photos/GAD_Blast_fungus_treatment2.jpg";
UPDATE `photos` SET `image` = "https://i.ibb.co/7xV8vCxB/1526727503.jpg" WHERE `image` = "Gliding_arc_discharge.JPG" OR `image` = "images/gallary/photos/Gliding_arc_discharge.JPG";
UPDATE `photos` SET `image` = "https://i.ibb.co/VpQmjz1M/Group-photo.jpg" WHERE `image` = "Group_photo.JPG" OR `image` = "images/gallary/photos/Group_photo.JPG";
UPDATE `photos` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png" OR `image` = "images/gallary/photos/demo_image.png";

UPDATE `instruments` SET `image` = "https://i.ibb.co/WWr3F58t/Whats-App-Image-2026-11-12-at-10-34-23-AM.jpg" WHERE `image` = "Film Deposition Using Plasma.png";
UPDATE `instruments` SET `image` = "https://i.ibb.co/WWr3F58t/Whats-App-Image-2026-11-12-at-10-34-23-AM.jpg" WHERE `image` = "images/instruments/Film Deposition Using Plasma.png";
UPDATE `instruments` SET `image` = "https://i.ibb.co/DgVDZCy5/1525857843.jpg" WHERE `image` = "images/activities/1525857843.jpg";
UPDATE `instruments` SET `image` = "https://i.ibb.co/DTchqSr/1525857898.jpg" WHERE `image` = "images/activities/1525857898.jpg";
UPDATE `instruments` SET `image` = "https://i.ibb.co/Sw5xP5Wr/1526478304.png" WHERE `image` = "images/activities/1526478304.jpg";
UPDATE `instruments` SET `image` = "https://i.ibb.co/7tskC0HV/demo-image.png" WHERE `image` = "demo_image.png";

UPDATE `services` SET `image` = "https://i.ibb.co/jvGs6D61/Consulting.jpg" WHERE `image` = "images/activities/Consulting.png";
UPDATE `services` SET `image` = "https://i.ibb.co/Kp15yzCn/Lab-training.jpg" WHERE `image` = "images/activities/Lab training.jpeg";
UPDATE `services` SET `image` = "https://i.ibb.co/WWr3F58t/Whats-App-Image-2026-11-12-at-10-34-23-AM.jpg" WHERE `image` = "images/instruments/Film Deposition Using Plasma.png";
UPDATE `services` SET `image` = "https://i.ibb.co/7JGJWdh0/Industrial-Light-Source-Spectral-Characterization-Service.jpg" WHERE `image` = "images/activities/Industrial Light Source Spectral Characterization Service.jpeg";

UPDATE `products` SET `image` = "https://i.ibb.co/WWr3F58t/Whats-App-Image-2026-11-12-at-10-34-23-AM.jpg" WHERE `image` = "images/instruments/Film Deposition Using Plasma.png";

UPDATE `admin_login` SET `image` = "https://i.ibb.co/xKg8qq2P/1782146626.png" WHERE `image` = "1782146626.jpg" OR `image` = "assets/images/admin/1782146626.jpg";
