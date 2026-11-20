-- Migration: Update instruments images with actual lab photos
UPDATE `instruments` 
SET `image` = 'Film Deposition Using Plasma.png' 
WHERE `id` = 1 AND (`image` = 'demo_image.png' OR `image` = '' OR `image` IS NULL);

UPDATE `instruments` 
SET `image` = 'images/activities/1525857843.jpg' 
WHERE `id` = 2 AND (`image` = 'demo_image.png' OR `image` = '' OR `image` IS NULL);

UPDATE `instruments` 
SET `image` = 'images/activities/1525857898.jpg' 
WHERE `id` = 3 AND (`image` = 'demo_image.png' OR `image` = '' OR `image` IS NULL);

UPDATE `instruments` 
SET `image` = 'images/activities/1526478304.jpg' 
WHERE `id` = 4 AND (`image` = 'demo_image.png' OR `image` = '' OR `image` IS NULL);
