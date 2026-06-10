-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 07:05 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thebusybusiness_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `client_data` longtext NOT NULL,
  `freelancer_data` longtext NOT NULL,
  `payment_method` longtext NOT NULL,
  `freelancer_subscribed` tinyint(4) NOT NULL,
  `account_balance` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `subid` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`fname`, `lname`, `email`, `country`, `username`, `password`, `client_data`, `freelancer_data`, `payment_method`, `freelancer_subscribed`, `account_balance`, `rating`, `views`, `id`, `subid`) VALUES
('Sanjay', 'P', 'test1@gmail.com', 'United States', 'Dynamic Dreamz', '000000a', '', '{\"services\":[\"Website Design | Development\",\"Builder - WIX\",\"Builder - Squarespace\",\"Builder - WordPress\",\"Builder - Custom\",\"Builder - Joomla\",\"Builder - Weebly\",\"Design - Mobile\",\"Design - Landing Page\",\"Design - Websites\",\"Mobile - Android\",\"Mobile - Apple\",\"Mobile - Mobile Web\",\"eCommerce - Woo Commerce\",\"eCommerce - Shopify\",\"eCommerce - Magento\",\"Product Designers | Developers\",\"Product Designers | Developers - T Shirt Design\",\"Product Designers | Developers - Logos\",\"Product Designers | Developers - Product Label\",\"Product Designers | Developers - Photoshop Editing\",\"Product Designers | Developers - 3D Models\",\"Project Managers\",\"IT Project Managers\",\"Mobile Project Managers\",\"Software Project Managers\",\"Web Project Managers\",\"Digital Marketers\",\"Digital Marketers - SEO | SEM Experts\",\"Digital Marketers - Social Media\",\"Digital Marketers - Email Marketers\",\"Digital Marketers - Marketing Strategists\",\"Digital Marketers - Lead Generators\",\"Graphic Artists | Illustrators\",\"Graphic Artists | Illustrators Logo Design\",\"Graphic Artists | Illustrators Illustration\",\"Graphic Artists | Illustrators Web & Mobile Design\",\"Graphic Artists | Illustrators Invitations\",\"Graphic Artists | Illustrators Flyers & Brochures\",\"IT & Networks\",\"IT & Networks - Database Admin\",\"IT & Networks - Information Security\",\"IT & Networks - Network & System Administration\",\"IT & Networks - CRM | ERP Software\"],\"business_name\":\"Dan\",\"skills\":\"Adobe Business Catalyst, Core, PHP, PSD to HTML, Shopify, Magento 2, WordPress\",\"experience\":\"Intermediate\",\"tagline\":\"A Web Design & Web Development company\",\"overview\":\"<p>Dynamic Dreamz is a rapidly growing web design and development company with 75+ highly skilled IT experts in PHP &amp; MySql Development, HTML\\/HTML5, CSS\\/CSS3, BootStrap, Responsive\\/Mobile-tablet friendly layout design, PSD Design, Business Catalyst, Wordpress, Shopify, Big-commerce, Magento, iPhone, Android, SEO etc.<\\/p><br><p>We are very optimistic in client project development journey and easy to work with.<\\/p><br><p>We believe \\\"Quality defines Success and Excellence work as magnet for it\\\".&nbsp;<\\/p><br><p>Why clients choose Dynamic Dreamz?&nbsp;<\\/p><br><p>\\u2022 Global operations in more than 25+ countries.&nbsp;<\\/p><p>\\u2022 Top Rated Agency on Upwork for last 10+ years.&nbsp;<\\/p><p>\\u2022 99% Job Success ratio.<\\/p><p>\\u2022 2000+ Successfully satisfied projects outcomes.<\\/p><p>\\u2022 46000+ Hours worked that created values to client-business.<\\/p><p>\\u2022 700+ clients spread across diverse business verticals.&nbsp;<\\/p><p>\\u2022 70+ highly skilled professionals.&nbsp;<\\/p><p>\\u2022 All associated staffs on Upwork wears blue badges like \\\"Top Rated\\\" and \\\"Rising Talent\\\" which shows work-excellence&nbsp;<\\/p><p>\\u2022 Flexible engagement models.&nbsp;<\\/p><p>\\u2022 Strong technology competency.&nbsp;<\\/p><p>\\u2022 Seamless communication.&nbsp;<\\/p><p>\\u2022 Pay attentions to details.&nbsp;<\\/p><p>\\u2022 Client\'s Business first approach.&nbsp;<\\/p><p>\\u2022 Value-oriented Solutions.<\\/p><p>\\u2022 State of the art IT infrastructure.&nbsp;<\\/p><p>\\u2022 Single-window communication arrangement for each project.&nbsp;<\\/p><br><p>Proven Expertise in :&nbsp;<\\/p><br><p>- Website Design and Web development&nbsp;<\\/p><p>- PSD to HTML, HTML5, Responsive HTML&nbsp;<\\/p><p>- PSD to Wordpress&nbsp;<\\/p><p>- Wordpress Development&nbsp;<\\/p><p>- Woocommerce customization<\\/p><p>- Adobe Business Catalyst Integration and customization&nbsp;<\\/p><p>- Shopify theme integration&nbsp;<\\/p><p>- PSD to Shopify integration&nbsp;<\\/p><p>- Magento Development&nbsp;<\\/p><p>- Bigcommerce theme customization&nbsp;<\\/p><p>- PSD to Bigcommerce&nbsp;<\\/p><p>- Joomla theme integration&nbsp;<\\/p><p>- Android App Development&nbsp;<\\/p><p>- IOS App development&nbsp;<\\/p><p>- Mobile App development&nbsp;<\\/p><br><br><p>Our clients shares more clear aspects about us :&nbsp;<\\/p><br><p>dynamicdreamz.com\\/testimonials\\/<\\/p><br><p>Our Infrastructure and process :&nbsp;<\\/p><br><p>dynamicdreamz.com\\/about-us\\/#our-infrastructure<\\/p><br><p>You can visit many more at our website - dynamicdreamz.com<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"test1@gmail.com\",\"Twitter\":\"https:\\/\\/www.google.com\\/search?client=firefox-b-1-d&q=amazon\",\"Facebook\":\"https:\\/\\/www.google.com\\/search?client=firefox-b-1-d&q=amazon\",\"LinkedIn\":\"https:\\/\\/www.google.com\\/search?client=firefox-b-1-d&q=amazon\",\"Google+\":\"https:\\/\\/www.google.com\\/search?client=firefox-b-1-d&q=amazon\",\"youtube_channel\":\"https:\\/\\/www.google.com\\/search?client=firefox-b-1-d&q=amazon\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"772ffec17a0a359f7d8be73f31307b66.jpg\"}', '{\"id\":\"cus_EaWqvPfYNBT5Pk\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551010116,\"currency\":null,\"default_source\":\"card_1E7LmZHDqWE2zFOpt4xmpdlx\",\"delinquent\":false,\"description\":\"Sanjay P - test1@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"C5AE83F\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E7LmZHDqWE2zFOpt4xmpdlx\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"22222\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EaWqvPfYNBT5Pk\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2024,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EaWqvPfYNBT5Pk\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EaWqvPfYNBT5Pk\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 45, 18, NULL),
('Boomland', 'Jenkins', 'boomlandjenkins+2@gmail.com', 'United States', 'BoomlandJenkins', 'BoomlandJenkins2', '{\"company_name\":\"Web Design Company\",\"tagline\":\"We build websites.\",\"company_description\":\"<p><strong>Looking for a website?<\\/strong><\\/p><p>We can help! We have been creating websites since the late 1990s and have helped thousands of businesses.<\\/p>\",\"name_of_person\":\"Boom\",\"title_of_person\":\"Web Designer\",\"website\":\"http:\\/\\/bocain.org\\/fiverr-pro\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"afec8acb6bc44fa15c1399e55bd6d9bb.png\"}', '', '{\"id\":\"cus_EctCcbDNchugMr\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551554540,\"currency\":null,\"default_source\":\"card_1E9dPcHDqWE2zFOpVp7XIumr\",\"delinquent\":false,\"description\":\"\\\"24\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"95D7C0B\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E9dPcHDqWE2zFOpVp7XIumr\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EctCcbDNchugMr\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EctCcbDNchugMr\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EctCcbDNchugMr\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 0, 0, 0, 0, 24, NULL),
('Boomer', 'Jenks', 'boomlandjenkins+3@gmail.com', 'United States', 'DJ Boom', 'boomland3', '{\"company_name\":\"DJ Boom\",\"tagline\":\"I mix the mixes you wish you mixed\",\"company_description\":\"We\'re a DJ company and make digital mixes for your upcoming events.&nbsp;\",\"name_of_person\":\"DJ Boom\",\"title_of_person\":\"DJ\",\"website\":\"https:\\/\\/www.thebusybusiness.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"d3782524817d95be21d96d180de535ff.\"}', '{\"services\":[\"Builder - WordPress\"],\"business_name\":\"Boom Web Design\",\"skills\":\"Web Design WordPress\",\"experience\":\"Intermediate\",\"tagline\":\"WordPress Web Services\",\"overview\":\"I can build your business a WordPress site.\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9LHsiaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6ZmFsc2UsInRpbWVGcm9tIjpudWxsLCJ0aW1lVGlsbCI6bnVsbH0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"https:\\/\\/www.thebusybusiness.com\",\"phone\":\"555-555-5555\",\"email\":\"boomlandjenkins+3@gmail.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"51972d9009efb485ccf03ad5db1ef667.png\"}', '{\"id\":\"cus_EcvB1pdyXxXYNq\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551561949,\"currency\":null,\"default_source\":\"card_1E9fL6HDqWE2zFOpaisYAZJb\",\"delinquent\":false,\"description\":\"Boomer Jenks - boomlandjenkins 3@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"DFDA866\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E9fL6HDqWE2zFOpaisYAZJb\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12121\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EcvB1pdyXxXYNq\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":10,\"exp_year\":2050,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EcvB1pdyXxXYNq\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EcvB1pdyXxXYNq\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 17, 25, NULL),
('Customer', 'Customer', 'Customer@Customer.com', 'United States', 'Customer', 'Customer', '', '', '', 0, 0, 0, 0, 26, NULL),
('mobile', 'Joe', 'mobile@', 'United States', 'mobile designer', 'mob19', '{\"company_name\":\"company\",\"tagline\":\"Tag\",\"company_description\":\"Description\",\"name_of_person\":\"Joe\",\"title_of_person\":\"owner\",\"website\":\"http:\\/\\/mysite.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"1af0e206ec3a4547c1b77f93035d7fc3.\"}', '', '', 0, 0, 0, 0, 27, NULL),
('Tempestt', 'Davis', 'hello@thebusybusiness.com', 'United States', 'hello@nerdpilots.com', 'nerdpilots', '', '', '', 0, 0, 0, 0, 28, NULL),
('test', 'jenkins', 'tempestt@thebusybusiness.com', 'United States', 'kill', 'brianna', '', '', '', 0, 0, 0, 0, 29, NULL),
('heather', 'graham', 'jhul@yahoo.com', 'United States', 'Jenni', 'briaqnna', '', '', '', 0, 0, 0, 0, 30, NULL),
('heather', 'loom', 'ghjk@yahoo.com', 'United States', 'aj', 'brianna', '', '{\"services\":[\"Builder - Squarespace\"],\"business_name\":\"AJ\",\"skills\":\"test\",\"experience\":\"Beginner\",\"tagline\":\"test\",\"overview\":\"testest test <br>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"ghjk@yahoo.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"e1d73b0f06d50c3f9af0bc4b0591caf2.webp\"}', '{\"id\":\"cus_EjXV4rfj76OmP5\",\"object\":\"customer\",\"account_balance\":0,\"created\":1553088325,\"currency\":null,\"default_source\":\"card_1EG4Q5HDqWE2zFOpUAMDZYvI\",\"delinquent\":false,\"description\":\"heather loom - ghjk@yahoo.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"7E05D2E\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1EG4Q5HDqWE2zFOpUAMDZYvI\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"78253\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EjXV4rfj76OmP5\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":10,\"exp_year\":2022,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EjXV4rfj76OmP5\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EjXV4rfj76OmP5\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 14, 32, NULL),
('Pankaj', 'K', 'test4@gmail.com', 'United States', 'Pankaj', '000000a', '{\"company_name\":\"Mitiz Technologies\",\"tagline\":\"An ISO 9001:2015 Certified Company\",\"company_description\":\"<p>We are an ISO 9001:2015 certified &amp; registered Private Limited Company in India with our offices at Delhi\\/NCR and Bhubaneshwar IT region in Odisha.<\\/p>\",\"name_of_person\":\"Pankaj K.\",\"title_of_person\":\"Mr\",\"website\":\"https:\\/\\/www.upwork.com\\/agencies\\/~0163abfd3111f7fb4d\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"55a8468fd9d650a20d3c35502503b90a.jpg\"}', '{\"services\":[\"Graphic Artists | Illustrators Logo Design\"],\"business_name\":\"Deanna\",\"skills\":\"Symfony, MongoDB, Laravel Framework jQuery, JQuery Mobile, CakePHP\",\"experience\":\"Expert\",\"tagline\":\"An ISO 9001:2015 Certified Company\",\"overview\":\"<p>We are an ISO 9001:2015 certified &amp; registered Private Limited Company in India with our offices at Delhi\\/NCR and Bhubaneshwar IT region in Odisha.<\\/p><br><p>Over last 8 years, we have successfully delivered a wide range of websites,mobile applications using different technologies. Our core competency lies in complete end to end management of Websites, Mobile Application Development, Digital Marketing, Maintenance and Support services. We have good expertise on the following areas: Linux, Apache, cPanel, Zend, CakePHP, Laravel, YII, Symfony, Codeigniter, Drupal, Joomla, Wordpress, JavaScript, jQuery, Angular.js, AJAX, Phonegap,Android, Ionic, GIT, SVN, Project Management Tools.<\\/p><br><p>We offer complete end to end Web and Mobile application design, development, Digital Marketing, IT consulting and maintenance of IT services. We have a pool of 30+ experienced, enthusiastic and skilled programmers, Creative Designers, QA Testers, Digital Marketers who work dedicatedly on the assigned projects in order to yield the out-of-the-box solutions.<\\/p><br><p>Every project is managed by our internal project management system and centralized mail\\/IM communication with the client. We closely monitor each and every mail of our client and prioritize their requirements on their project.<\\/p><br><p>All new project starts with the assemble of a developer, designer, QA and Team Leader. We are flexible to enough to add more resources in case of client\'s urgency or requirement for the additional workflow change.<\\/p><br><p>Our aim is to provide the simplest and qualitative programming or application development without compromising the overall performance as per the industry standard. In accordance with the quality development we also take care and follow the projected time line for delivering the product. We also provide post-project maintenance service to maintain our client\'s brand value in equilibrium with the strategical changes in market competition.<\\/p><br><p>We always listen, prioritize our client\'s input and their feedback on the top of everything and suggest them the best solution to materialize their requirement with ease. We maintain the transparency, clearness of requirements, fulfillment of expectations from both sides through mail or IM communication.<\\/p><br><p>Our Experts work in the following skillset.<\\/p><p>Programming :<\\/p><p>PHP, MySQL, AJAX, JavaScript, VBScript, C# .NET, VB .NET, ASP .NET, SQL Server, Web Services, Crystal Reports, XML, IIS, ADO, Stored procedures, Share Point<\\/p><br><p>Frameworks &amp; Content Management System (CMS) :<\\/p><p>Yii, Laravel, CakePHP, Drupal, Wordpress, Joomla, Elgg,&nbsp;<\\/p><br><p>Ecommerce :<\\/p><p>Opencart, Zencart, Prestashop and OsCommerce<\\/p><br><p>Graphic Design :<\\/p><p>Brand Logo design, Banner Design, Flash Animation, Web Page Design, Presentation<\\/p><br><p>Designing &amp; Tools :<\\/p><p>Dreamweaver, Flash\\/Flex, Photoshop, CorelDraw, Illustrator, Fireworks and Swish Max.<\\/p><br><p>Mobile Applications:<\\/p><p>Android, iOS, Hybrid\\/Cross Platform Applications, Ionic, Phonegap<\\/p><br><p>Platform :<\\/p><p>Linux, Windows, Android and Macintosh<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"test4@gmail.com\",\"Twitter\":\"test4@gmail.com\",\"Facebook\":\"test4@gmail.com\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"824a80330500c103e98c5312b3ac94c8.webp\"}', '{\"id\":\"cus_EaWwjoqbG1U49N\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551010496,\"currency\":null,\"default_source\":\"card_1E7LshHDqWE2zFOpBwoPH0SS\",\"delinquent\":false,\"description\":\"Pankaj K - test4@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"E547638\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E7LshHDqWE2zFOpBwoPH0SS\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"22222\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EaWwjoqbG1U49N\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2024,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EaWwjoqbG1U49N\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EaWwjoqbG1U49N\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 27, 21, NULL),
('George ', 'Edward', 'frinotz@outlook.com', 'United States', 'ConceptDeveloper', 'gyx49qkxh8', '', '', '', 0, 0, 0, 0, 22, NULL),
('boomland', 'jenkina', 'boomlandjenkins+1@gmail.com', 'United States', 'boomlandj1', 'boomlandj1', '{\"company_name\":\"Boomland\",\"tagline\":\"Building a better web.\",\"company_description\":\"I create and enhance experiences.<br>\",\"name_of_person\":\"John Doe\",\"title_of_person\":\"UX Tester\",\"website\":\"https:\\/\\/www.thebusybusiness.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"50cc8fd5a49d931f4f3f74ab4807904e.\"}', '{\"services\":[\"Design - Websites\",\"Mobile - Mobile Web\"],\"business_name\":\"The Better Builder\",\"skills\":\"Mobile first web design\",\"experience\":\"Expert\",\"tagline\":\"We build it better\",\"overview\":\"I build things better than the other builders. <br>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9LHsiaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9LHsiaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOmZhbHNlLCJ0aW1lRnJvbSI6bnVsbCwidGltZVRpbGwiOm51bGx9XQ==\",\"website\":\"https:\\/\\/www.thebusybusiness.com\",\"phone\":\"555-555-5555\",\"email\":\"boomlandjenkins+1@gmail.com\",\"Twitter\":\"https:\\/\\/mobile.twitter.com\\/Google\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"40af66f6b55f140cd2ae16be7bc93820.png\"}', '{\"id\":\"cus_EcZTYc62Nn8kr0\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551481189,\"currency\":null,\"default_source\":\"card_1E9KKXHDqWE2zFOpr8DcVgPc\",\"delinquent\":false,\"description\":\"boomland jenkina - boomlandjenkins 1@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"35482C9\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E9KKXHDqWE2zFOpr8DcVgPc\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12210\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EcZTYc62Nn8kr0\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":7,\"exp_year\":2025,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EcZTYc62Nn8kr0\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EcZTYc62Nn8kr0\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 16, 23, NULL),
('Yawar', 'K', 'test3@gmail.com', 'United States', 'Yawar', '000000a', '', '{\"services\":[\"Website Design | Development\",\"Builder - WIX\",\"Builder - Squarespace\",\"Builder - WordPress\",\"Builder - Custom\",\"Builder - Joomla\",\"Builder - Weebly\",\"Design - Mobile\",\"Design - Landing Page\",\"Design - Websites\",\"Mobile - Android\",\"Mobile - Apple\",\"Mobile - Mobile Web\",\"eCommerce - Woo Commerce\",\"eCommerce - Shopify\",\"eCommerce - Magento\",\"Product Designers | Developers\",\"Product Designers | Developers - T Shirt Design\",\"Product Designers | Developers - Logos\",\"Product Designers | Developers - Product Label\",\"Product Designers | Developers - Photoshop Editing\",\"Product Designers | Developers - 3D Models\",\"Project Managers\",\"IT Project Managers\",\"Mobile Project Managers\",\"Software Project Managers\",\"Web Project Managers\",\"Digital Marketers\",\"Digital Marketers - SEO | SEM Experts\",\"Digital Marketers - Social Media\",\"Digital Marketers - Email Marketers\",\"Digital Marketers - Marketing Strategists\",\"Digital Marketers - Lead Generators\",\"Graphic Artists | Illustrators\",\"Graphic Artists | Illustrators Logo Design\",\"Graphic Artists | Illustrators Illustration\",\"Graphic Artists | Illustrators Web & Mobile Design\",\"Graphic Artists | Illustrators Invitations\",\"Graphic Artists | Illustrators Flyers & Brochures\",\"IT & Networks\",\"IT & Networks - Database Admin\",\"IT & Networks - Information Security\",\"IT & Networks - Network & System Administration\",\"IT & Networks - CRM | ERP Software\"],\"business_name\":\"Indus Valley Labs (Pvt) Ltd\",\"skills\":\"AngularJS, Angular 2\\/3\\/4, Snap, SVG, Fabric.js, HTML5, Canvas, HTML\\/CSS, Bootstrap\",\"experience\":\"Intermediate\",\"tagline\":\"Angular React NodeJs Java Spring Framework ionic JavaScript PHP MySQL Mobile\",\"overview\":\"<p>We provide quality product in timely manner. Our main goal is to make the client 100% satisfied with our work. Hard work, sincerity and integrity are our values. We believe in fulfilling our promises. We love working for difficult and challenging tasks.<\\/p><br><p>Links:<\\/p><p>www.indusvalleylabs.com<\\/p><p>www.facebook.com\\/indusvalleylabs<\\/p><br><p>We have expertise in the following technologies<\\/p><br><p>Frontend<\\/p><p>AngularJS<\\/p><p>Angular 2\\/3\\/4<\\/p><p>Snap SVG<\\/p><p>Fabric.js HTML5 Canvas<\\/p><p>HTML\\/CSS<\\/p><p>Bootstrap<\\/p><p>Angular Material<\\/p><p>KendoUI<\\/p><p>ReactJs<\\/p><p>jQuery<\\/p><p>ExtJS<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"test3@gmail.com\",\"Twitter\":\"test3@gmail.com \",\"Facebook\":\"test3@gmail.com \",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"9dc7aa6c763eae14498ebd6622c8064b.jpeg\"}', '{\"id\":\"cus_EaWuFDXgSARZQP\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551010385,\"currency\":null,\"default_source\":\"card_1E7LquHDqWE2zFOpvEvhgezn\",\"delinquent\":false,\"description\":\"Yawar K - test3@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"C298FED\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E7LquHDqWE2zFOpvEvhgezn\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"22222\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EaWuFDXgSARZQP\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2024,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EaWuFDXgSARZQP\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EaWuFDXgSARZQP\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 23, 20, NULL),
('Ayaz', 'M', 'test2@gmail.com', 'United States', 'FuduGo Solutions', '000000a', '', '{\"services\":[\"Website Design | Development\",\"Builder - WIX\",\"Builder - Squarespace\",\"Builder - WordPress\",\"Builder - Custom\",\"Builder - Joomla\",\"Builder - Weebly\",\"Design - Mobile\",\"Design - Landing Page\",\"Design - Websites\",\"Mobile - Android\",\"Mobile - Apple\",\"Mobile - Mobile Web\",\"eCommerce - Woo Commerce\",\"eCommerce - Shopify\",\"eCommerce - Magento\",\"Product Designers | Developers\",\"Product Designers | Developers - T Shirt Design\",\"Product Designers | Developers - Logos\",\"Product Designers | Developers - Product Label\",\"Product Designers | Developers - Photoshop Editing\",\"Product Designers | Developers - 3D Models\",\"Project Managers\",\"IT Project Managers\",\"Mobile Project Managers\",\"Software Project Managers\",\"Web Project Managers\",\"Digital Marketers\",\"Digital Marketers - SEO | SEM Experts\",\"Digital Marketers - Social Media\",\"Digital Marketers - Email Marketers\",\"Digital Marketers - Marketing Strategists\",\"Digital Marketers - Lead Generators\",\"Graphic Artists | Illustrators\",\"Graphic Artists | Illustrators Logo Design\",\"Graphic Artists | Illustrators Illustration\",\"Graphic Artists | Illustrators Web & Mobile Design\",\"Graphic Artists | Illustrators Invitations\",\"Graphic Artists | Illustrators Flyers & Brochures\",\"IT & Networks\",\"IT & Networks - Database Admin\",\"IT & Networks - Information Security\",\"IT & Networks - Network & System Administration\",\"IT & Networks - CRM | ERP Software\"],\"business_name\":\"Franny\",\"skills\":\"CodeIgniter, HTML, Zend Framework, AngularJS, Woocommerce\",\"experience\":\"Expert\",\"tagline\":\"Website, iOS, Android, Graphic & Software Development Company\",\"overview\":\"<p>Overview<\\/p><br><p>FuduGo Solutions brings innovative ideas and cutting-edge technologies into the business of customers. We take full advantage of the web and make it work for you.<\\/p><br><p>FuduGo Solutions is a web development company delivering web development services of any complexity to clients worldwide. Being in IT business, FuduGo Solutions has a strong team of skilled and experienced IT experts. We are targeting companies of all sizes ranging from start-ups to large enterprises who realize that they need a professional IT solution to generate revenue streams, establish communication channels or streamline business operations.<\\/p><br><p>We provide full-cycle services in the areas of software development, web-based enterprise solutions, web application and portal development. Combining our solid business domain experience, technical expertise, profound knowledge of latest industry trends and quality-driven delivery model we offer progressive end-to-end web solutions.<\\/p><br><p>Services Offered<\\/p><br><p>We create brilliant websites for business.Ecommerce and CMS application development.Search engine optimization(SEO) with major search engine.Excellent desktop applications to make your work faster and easier.Highly skilled professional to provide you niche services<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"test2@gmail.com\",\"Twitter\":\"est2@gmail.com\",\"Facebook\":\"est2@gmail.com\",\"LinkedIn\":\"est2@gmail.com\",\"Google+\":\"est2@gmail.com\",\"youtube_channel\":\"est2@gmail.com\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"12221d020601bea906fb5f22a16b6d03.jpg\"}', '{\"id\":\"cus_EaWsDb0DEhBoLR\",\"object\":\"customer\",\"account_balance\":0,\"created\":1551010230,\"currency\":null,\"default_source\":\"card_1E7LoOHDqWE2zFOpEL6kOCpf\",\"delinquent\":false,\"description\":\"Ayaz M - test2@gmail.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"B53B378\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E7LoOHDqWE2zFOpEL6kOCpf\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"22222\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EaWsDb0DEhBoLR\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2024,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EaWsDb0DEhBoLR\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EaWsDb0DEhBoLR\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 0, 35, 19, NULL),
('Kevin', 'P.', 'hello@nerdpilots.com', 'United States', 'NerdPilots', 'Nerdpilots', '{\"company_name\":\"Nerdpilots\",\"tagline\":\"You grow your business. \\r\\nWe\\u2019ll do your website.\",\"company_description\":\"<p class=\\\"platform-text text-center\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; max-width: 530px; margin: 0px auto; color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><\\/p><p style=\\\"box-sizing: inherit; overflow-x: hidden; margin-right: 0px; margin-bottom: 45px; margin-left: 0px; font-size: 23px; color: rgb(74, 75, 78); line-height: 32px;\\\">Building a business is a lot of work, let us handle all of your website needs.<\\/p><p style=\\\"box-sizing: inherit; overflow-x: hidden; margin-right: 0px; margin-bottom: 45px; margin-left: 0px; font-size: 23px; color: rgb(74, 75, 78); line-height: 32px;\\\">From blogs, to online stores, and complex web platforms, NerdPilots got you covered.<\\/p><p><\\/p><p><\\/p><hr class=\\\"divider\\\" style=\\\"box-sizing: content-box; height: 3px; margin: 60px 0px 105px; border-top: 0px; background: rgb(203, 199, 199); color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><p><\\/p><p class=\\\"platform-content text-center\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><\\/p><h2 style=\\\"box-sizing: inherit; margin-right: 0px; margin-bottom: 55px; margin-left: 0px; font-weight: 700; line-height: 40px; color: rgb(47, 48, 52); font-size: 34px; clear: both; padding: 0px; overflow: hidden !important;\\\">We work with all major platforms<\\/h2><p class=\\\"platform-icon\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; max-width: 935px; width: 935px; margin: 0px auto;\\\"><img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/wordpress.png\\\" alt=\\\"wordpress\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/shopify.png\\\" alt=\\\"wordpress\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/squarespace.png\\\" alt=\\\"squarespace\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/stripe.png\\\" alt=\\\"stripe\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/wix.png\\\" alt=\\\"wix\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/mailchimp.png\\\" alt=\\\"mailchimp\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/square.png\\\" alt=\\\"square\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/launch.png\\\" alt=\\\"launch27\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\"><\\/p><p><\\/p>\",\"name_of_person\":\"Kevin\",\"title_of_person\":\"Mr.\",\"website\":\"https:\\/\\/nerdpilots.com\",\"twitter\":\"@nerdpilots\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"0bbf38c48c0e911e3906b548ffd07d23.\"}', '{\"services\":[\"Website Design | Development\"],\"business_name\":\"NerdPilots\",\"skills\":\"Web Design, Web Development, Graphic Design, Database Administration\",\"experience\":\"Expert\",\"tagline\":\"You grow your business. \\r\\nWe\\u2019ll do your website.\",\"overview\":\"<p class=\\\"platform-text text-center\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; max-width: 530px; margin: 0px auto; color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><\\/p><p style=\\\"box-sizing: inherit; overflow-x: hidden; margin-right: 0px; margin-bottom: 45px; margin-left: 0px; font-size: 23px; color: rgb(74, 75, 78); line-height: 32px;\\\">Building a business is a lot of work, let us handle all of your website needs.<\\/p><p style=\\\"box-sizing: inherit; overflow-x: hidden; margin-right: 0px; margin-bottom: 45px; margin-left: 0px; font-size: 23px; color: rgb(74, 75, 78); line-height: 32px;\\\">From blogs, to online stores, and complex web platforms, NerdPilots got you covered.<\\/p><p><\\/p><p><\\/p><hr class=\\\"divider\\\" style=\\\"box-sizing: content-box; height: 3px; margin: 60px 0px 105px; border-top: 0px; background: rgb(203, 199, 199); color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><p><\\/p><p class=\\\"platform-content text-center\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; color: rgb(26, 26, 26); font-family: HelveticaNeue, sans-serif; font-size: 16px;\\\"><\\/p><h2 style=\\\"box-sizing: inherit; margin-right: 0px; margin-bottom: 55px; margin-left: 0px; font-weight: 700; line-height: 40px; color: rgb(47, 48, 52); font-size: 34px; clear: both; padding: 0px; overflow: hidden !important;\\\">We work with all major platforms<\\/h2><p class=\\\"platform-icon\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; max-width: 935px; width: 935px; margin: 0px auto;\\\"><img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/wordpress.png\\\" alt=\\\"wordpress\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/shopify.png\\\" alt=\\\"wordpress\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/squarespace.png\\\" alt=\\\"squarespace\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/stripe.png\\\" alt=\\\"stripe\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/wix.png\\\" alt=\\\"wix\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/mailchimp.png\\\" alt=\\\"mailchimp\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/square.png\\\" alt=\\\"square\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\">&nbsp;<img src=\\\"https:\\/\\/nerdpilots.com\\/assets\\/images\\/launch.png\\\" alt=\\\"launch27\\\" style=\\\"box-sizing: inherit; overflow-x: hidden; border: 0px; margin-right: 40px; margin-bottom: 35px;\\\"><\\/p><p><\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"https:\\/\\/nerdpilots.com\",\"phone\":\"(888) 674-5687\",\"email\":\"hello@nerdpilots.com\",\"Twitter\":\"https:\\/\\/twitter.com\\/NerdPilots\",\"Facebook\":\"https:\\/\\/www.facebook.com\\/NerdPilots\\/\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"https:\\/\\/www.youtube.com\\/channel\\/UCoUgNEr4dVaIzFbSzLLK4FA\",\"youtube_video\":\"https:\\/\\/www.youtube.com\\/watch?v=nE6K33U0BDc\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"538b18c971a3845afbac23a1321a455c.jpeg\"}', '{\"id\":\"cus_EUJUREthtk7oCM\",\"object\":\"customer\",\"account_balance\":0,\"created\":1549576615,\"currency\":null,\"default_source\":\"card_1E1KrbHDqWE2zFOpqewuEqRD\",\"delinquent\":false,\"description\":\"Kevin P. - hello@nerdpilots.com\",\"discount\":null,\"email\":null,\"invoice_prefix\":\"0926FBE\",\"invoice_settings\":{\"custom_fields\":null,\"footer\":null},\"livemode\":false,\"metadata\":[],\"shipping\":null,\"sources\":{\"object\":\"list\",\"data\":[{\"id\":\"card_1E1KrbHDqWE2zFOpqewuEqRD\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"22222\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":\"cus_EUJUREthtk7oCM\",\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":4,\"exp_year\":2024,\"fingerprint\":\"pkvUDib5EKmtNDoG\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null}],\"has_more\":false,\"total_count\":1,\"url\":\"\\/v1\\/customers\\/cus_EUJUREthtk7oCM\\/sources\"},\"subscriptions\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/customers\\/cus_EUJUREthtk7oCM\\/subscriptions\"},\"tax_info\":null,\"tax_info_verification\":null}', 1, 0, 5, 100, 2, NULL),
('Tempestt', 'Davis', 'hello@thebusybusiness.com', 'United States', 'LMI', 'Brianna', '', '', '', 0, 0, 0, 0, 33, NULL),
('Tempestt', 'Davis', 'hello@thebusybusiness.com', 'United States', 'TDD', 'brianna', '', '', '', 0, 0, 0, 0, 34, NULL),
('Tempestt', 'Davis', 'hello@thebusybusiness.com', 'United States', 'FIT', 'brianna', '', '', '', 0, 0, 0, 0, 35, NULL),
('Brianna', 'Walker-Jenkins', 'tempestt@thebusybusiness.com', 'United States', 'track', 'brianna', '{\"company_name\":\"fggh\",\"tagline\":\"ffghg\",\"company_description\":\"dffgg\",\"name_of_person\":\"fcfgv\",\"title_of_person\":\"fgvgg\",\"website\":\"fgbb.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"4af50fe36c0201eb488c280338dc33aa.\"}', '', '', 0, 0, 0, 0, 36, NULL),
('Shadie', 'Dasrath', 'shadiesingh@gmail.com', 'United States', 'shadie', '000000a', '{\"company_name\":\"Shadie\",\"tagline\":\"test\",\"company_description\":\"test\",\"name_of_person\":\"Shadie\",\"title_of_person\":\"Mrs\",\"website\":\"https:\\/\\/www.upwork.com\\/agencies\\/~0163abfd3111f7fb4d\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"eb71a4cbc32e0f202bcfe5ed2040d717.PNG\"}', '', '', 0, 0, 0, 0, 37, NULL),
('dante', 'Davis', 'hovah77@gmail.com', 'United States', 'hello@nerdpilots.com', 'nerdpilots', '', '', '', 0, 0, 0, 0, 38, NULL),
('Boomland', 'Jenkins', 'boomlandjenkins@gmail.com', 'United States', 'Boomland Jenkins', 'abc123', '{\"company_name\":\"Boomland Jenkins\",\"tagline\":\"I do web design\",\"company_description\":\"I\'m a web designer in New York.<br>\",\"name_of_person\":\"Dan\",\"title_of_person\":\"Web Designer\",\"website\":\"http:\\/\\/mysite.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"7c33758fcc78a36a923dfa87e0b00533.\"}', '{\"services\":[\"Builder - WordPress\",\"Design - Landing Page\",\"Design - Websites\",\"eCommerce - Woo Commerce\"],\"business_name\":\"Boomland Jenkins\",\"skills\":\"WordPress, Design\",\"experience\":\"Expert\",\"tagline\":\"I\'ll make your business a website\",\"overview\":\"20 years of industry experience<br>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"http:\\/\\/mysite.com\",\"phone\":\"1234567890\",\"email\":\"boomlandjenkins@gmail.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"604b37ea63ea51fa5fb3d8a89ec056e6.jpg\"}', '', 0, 0, 0, 19, 41, NULL),
('Dan', 'Bocain', 'boomlandjenkins@gmail.com', 'United States', 'BoomDesigns', 'abc123', '', '{\"business_name\":\"BoomDesigns\",\"tagline\":\"Simply the best.\",\"overview\":\"<p style=\\\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\\\">Morbi quis feugiat libero, non ultrices odio. Suspendisse sed magna convallis, rhoncus erat ut, vehicula metus. Nulla lacinia et erat in consequat. Sed rutrum erat non ipsum consequat, sed egestas ipsum euismod. Aliquam erat volutpat.&nbsp;<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\\\"><strong>Aenean mollis enim quis dolor finibus, nec ultricies sapien tincidunt. Nam eu egestas orci, ac sagittis tortor. Praesent condimentum volutpat bibendum. Duis rutrum, elit a maximus tincidunt, arcu leo rhoncus ex, vitae tempus urna velit in felis. Donec sit amet quam quis elit pretium sollicitudin et vitae odio. Aenean sed neque vitae eros rhoncus mollis non quis velit.&nbsp;<\\/strong><\\/p><p style=\\\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\\\">Curabitur tellus nisl, faucibus a maximus dignissim, blandit non justo. Mauris vitae laoreet augue, at convallis odio. Quisque mattis, magna nec iaculis condimentum, massa elit malesuada nulla, vitae molestie dui eros at tellus.<\\/p><br>\",\"services\":[\"Digital Products\"],\"filename\":\"3ccbc9e13b6e88638b01589fc9dfff40.jpg\"}', '', 0, 0, 0, 18, 42, NULL);
INSERT INTO `members` (`fname`, `lname`, `email`, `country`, `username`, `password`, `client_data`, `freelancer_data`, `payment_method`, `freelancer_subscribed`, `account_balance`, `rating`, `views`, `id`, `subid`) VALUES
('Dan', 'Jenkins', 'boomlandjenkins@gmail.com', 'United States', 'boomlandjenkins@gmail.com', 'boomlandjenkins@gmail.com', '{\"company_name\":\"Boomland Designs\",\"tagline\":\"I\'ll design your stuff\",\"company_description\":\"<p style=\\\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pellentesque purus nec dui hendrerit volutpat. Praesent non neque ac odio mollis finibus. Nunc dapibus nec enim id tincidunt. Duis a dui nunc. Vestibulum dictum ante hendrerit augue fringilla porttitor. In at hendrerit sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla placerat massa justo, id euismod neque mollis eu. Vestibulum iaculis augue id tempus pharetra. Vivamus ac ipsum metus. Vestibulum sed turpis sed felis pharetra lobortis a et tortor. Duis placerat mi est, sed sagittis mauris imperdiet a. Donec id turpis lectus. Nunc nec bibendum augue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce ullamcorper eu ligula sit amet lacinia.<\\/p><p><br><\\/p>\",\"name_of_person\":\"Boomland\",\"title_of_person\":\"Head of Design\",\"website\":\"google.com\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"411d7c2c54377a6d31027a00cf299b0f.png\"}', '', '', 0, 0, 0, 0, 43, NULL),
('Boom', 'Danland', 'boomlandjenkins@gmail.com', 'United States', 'boomlandjenkins@gmail.com', 'boomlandjenkins@gmail.com', '', '{\"services\":[\"Builder - WordPress\",\"Design - Landing Page\",\"Design - Websites\",\"Mobile - Mobile Web\"],\"business_name\":\"WordPress Website Shop\",\"skills\":\"wordpress websites\",\"experience\":\"Expert\",\"tagline\":\"Donec et enim ac justo pulvinar egestas. Quisque placerat consequat sollicitudin.\",\"overview\":\"<p style=\\\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vulputate ac sapien non imperdiet. Proin vitae laoreet nibh, nec ullamcorper lorem. Donec dignissim scelerisque massa vitae sollicitudin. Phasellus ultricies eleifend elit eget finibus. Pellentesque eget ligula feugiat, dapibus neque non, commodo orci. Nunc cursus nisi eros, et facilisis lorem interdum sit amet. Suspendisse et orci a metus rhoncus tristique. Aenean in odio ac dolor sollicitudin finibus eu ut massa.&nbsp;<\\/p><br>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"\",\"phone\":\"\",\"email\":\"boomlandjenkins@gmail.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"ba2bf766931a4a187315c3fe87d77657.png\"}', '', 0, 0, 0, 12, 44, NULL),
('Tiffany', 'Butler', 'apply@thebusybusiness.com', 'United States', 'Gift', 'Brianna1!', '', '', '', 0, 0, 0, 0, 45, NULL),
('Syed Ali ', 'Hussain', 'alibha225@gmail.com', 'United States', 'alibha225@gmail.com', 'Bhadesign-23', '{\"company_name\":\"Syed ALi Hussain\",\"tagline\":\"Bha design\",\"company_description\":\"I am graphic Designer\",\"name_of_person\":\"Shahzaib\",\"title_of_person\":\"Manager\",\"website\":\"https:\\/\\/paramountanimations.com\\/\",\"twitter\":\"\",\"facebook\":\"\",\"LinkedIn\":\"\",\"video\":\"\",\"filename\":\"4c25c5b6c76b93bd9d8d5d1d65febada.\"}', '', '', 0, 0, 0, 0, 46, NULL),
('Candice', 'Lehman', 'candice@circletownmarketing.com', 'United States', 'Circletown Marketing', 'L0llip0p', '', '{\"services\":[\"Builder - WordPress\",\"Design - Websites\",\"eCommerce - Woo Commerce\",\"Product Designers | Developers - Logos\",\"Web Project Managers\",\"Digital Marketers - SEO | SEM Experts\",\"Digital Marketers - Lead Generators\"],\"business_name\":\"Circletown Marketing\",\"skills\":\"Graphic Design, Web Design, Digital Marketing, Project Managment\",\"experience\":\"Expert\",\"tagline\":\"Providing strategic marketing and web design services \",\"overview\":\"<p>With over 10 years of experience in Marketing and Web Design, I\'ve learned, and continue to learn best practices in the industry to provide my clients with the problem-solving solutions they are looking for.<\\/p><p>I am skilled in graphic design tools including Adobe Photoshop and Illustrator, as well as web development in multiple platforms, specializing in Wordpress Development. My experience provides me the unique talent of not only executing on a plan that the client presents but also presenting the client with a plan to make their end goals happen.&nbsp;<\\/p><p>I\'m passionate about helping your business grow, and have the skills, experience and creativity to make that happen!<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA1OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDU6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNTowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA1OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDU6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"https:\\/\\/circletownmarketing.com\",\"phone\":\"12542457848\",\"email\":\"candice@circletownmarketing.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"7a6840706558773e434a33cc0c59fc62.jpg\"}', '', 0, 0, 0, 4, 47, NULL),
('jeff', 'smith', 'apply@thebusybusiness.com', 'United States', 'Hop', 'Brianna1', '', '', '', 0, 0, 0, 0, 48, NULL),
('test', 'test', 'test.developer@gmail.com', 'United States', 'test', '123456', '', '{\"business_name\":\"test\",\"tagline\":\"test\",\"overview\":\"test\",\"services\":[\"Digital Products\"],\"filename\":\"a3962c0ca7ca8033daaa9fac886e90b8.gif\"}', '', 0, 0, 0, 5, 49, NULL),
('Md.', 'Islam', 'testr@gmail.com', 'United States', 'test', 'test', '', '', '', 0, 0, 0, 0, 50, NULL),
('Md.', 'Islam', 'test@gmail.com', 'United States', 'est', 'test', '', '', '', 0, 0, 0, 0, 51, NULL),
('Kevin', 'Pereira', 'kevin@innclusive.com', 'United States', 'Convert27', 'Password1', '', '', '', 0, 0, 0, 0, 52, NULL),
('work', 'work', 'work@gmail.com', 'United States', 'work', 'work', '', '{\"services\":[\"Builder - WIX\",\"Builder - Squarespace\",\"Builder - WordPress\",\"Builder - Custom\",\"Builder - Joomla\",\"Builder - Weebly\"],\"business_name\":\"test\",\"skills\":\"test\",\"experience\":\"Beginner\",\"tagline\":\"test\",\"overview\":\"<p>test<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"test\",\"phone\":\"5555\",\"email\":\"work@gmail.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"1556134953.png\"}', '', 0, 0, 0, 1, 53, NULL),
('Test', 'Test', 'taufiqul.developer@gmail.com', 'United States', 'Test', 'Test', '', '', '', 0, 0, 0, 0, 54, NULL),
('Md.', 'test', 'taufiqul.developer@gmail.com', 'United States', 'test', 'test', '', '', '', 0, 0, 0, 0, 55, NULL),
('test', 'test', 'taufiqul.developer@gmail.com', 'United States', 'test', 'test', '', '{\"filename\":\"1556138069.png\"}', '', 0, 0, 0, 1, 57, NULL),
('test', 'test', 'amsshoyon@yahoo.com', 'United States', 'test', 'test', '', '{\"services\":[\"Builder - WIX\",\"Builder - Squarespace\",\"Builder - WordPress\",\"Builder - Custom\",\"Builder - Joomla\",\"Builder - Weebly\"],\"business_name\":\"test\",\"skills\":\"test\",\"experience\":\"Beginner\",\"tagline\":\"test\",\"overview\":\"<p>test<\\/p>\",\"business_hoursOutput\":\"W3siaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjp0cnVlLCJ0aW1lRnJvbSI6IjA5OjAwIGFtIiwidGltZVRpbGwiOiIwNjowMCBwbSJ9LHsiaXNBY3RpdmUiOnRydWUsInRpbWVGcm9tIjoiMDk6MDAgYW0iLCJ0aW1lVGlsbCI6IjA2OjAwIHBtIn0seyJpc0FjdGl2ZSI6dHJ1ZSwidGltZUZyb20iOiIwOTowMCBhbSIsInRpbWVUaWxsIjoiMDY6MDAgcG0ifSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfSx7ImlzQWN0aXZlIjpmYWxzZSwidGltZUZyb20iOm51bGwsInRpbWVUaWxsIjpudWxsfV0=\",\"website\":\"test\",\"phone\":\"2345\",\"email\":\"amsshoyon@yahoo.com\",\"Twitter\":\"\",\"Facebook\":\"\",\"LinkedIn\":\"\",\"Google+\":\"\",\"youtube_channel\":\"\",\"youtube_video\":\"\",\"startTime\":\"09:00 am\",\"endTime\":\"06:00 pm\",\"filename\":\"1556138140.png\"}', '', 0, 0, 0, 1, 58, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messaging`
--

CREATE TABLE `messaging` (
  `from_member` int(11) NOT NULL,
  `to_member` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` mediumtext NOT NULL,
  `attachments` longtext NOT NULL,
  `time` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messaging`
--

INSERT INTO `messaging` (`from_member`, `to_member`, `type`, `message`, `data`, `attachments`, `time`, `job_id`, `id`) VALUES
(2, 21, 'offer', 'Hello!', '[\"2019-12-22\",\"500.00\",\"3\"]', '[]', 1551010672, 3, 1),
(2, 2, 'offer', 'Hello!', '[\"2019-12-22\",\"1500.00\",\"5\"]', '[]', 1551010844, 5, 2),
(2, 2, 'message', 'test message<br>', '', '[]', 1551115340, 0, 3),
(21, 21, 'message', 'Hello, this is a test.<br>', '', '[]', 1551480628, 0, 4),
(24, 23, 'message', 'I want to hire you, what can you do for me? Attached is a logo', '', '[\"\\/uploads\\/7720908e59db27c303d189841ab86e00.png\"]', 1551555251, 0, 5),
(2, 2, 'message', 'test\r\n', '', '[]', 1551556424, 0, 6),
(25, 23, 'offer', 'I can do this for 50000', '[\"200015-12-05\",\"1000.5\",\"6\"]', '[{\"name\":\"WordPress-logotype-wmark.png\",\"loc\":\"\\/uploads\\/6be105e472841e1b5c10c9508ccb86fe.png\"}]', 1551562796, 6, 7),
(25, 23, 'offer', 'I can do this for 50000', '[\"200015-12-05\",\"1000.5\",\"6\"]', '[{\"name\":\"WordPress-logotype-wmark.png\",\"loc\":\"\\/uploads\\/b77c312912e37404acd1739f675aae63.png\"}]', 1551562885, 6, 8),
(32, 25, 'offer', 'want to get hired<br>', '[\"2019-03-29\",\"1.02\",\"7\"]', '[]', 1553088464, 7, 9),
(2, 25, 'offer', 'gfhahu', '[\"2019-03-21\",\"3\",\"7\"]', '[]', 1553093948, 7, 10),
(2, 2, 'message', 'hi', '', '[]', 1553098617, 0, 11),
(2, 25, 'offer', 'I would love to work with you<br>', '[\"2019-03-28\",\"1.01\",\"7\"]', '[]', 1553636794, 7, 12),
(2, 25, 'offer', 'I would love to work on this project<br>', '[\"2019-03-26\",\"250.00\",\"7\"]', '[]', 1553642509, 7, 13),
(2, 25, 'offer', 'I would love to work on this project. <br>', '[\"2019-04-04\",\"500.00\",\"7\"]', '[]', 1553643080, 7, 14),
(41, 18, 'message', '<p>Hello, <strong>can I</strong> hire you?</p>', '', '[]', 1553800955, 0, 15);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `member_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`member_id`, `note`, `time`) VALUES
(25, 'This is a note!', '1551562109'),
(25, 'It IS a note!', '1551562115'),
(2, 'Meeting with Client tomorrow 27th March 2018', '1553636328'),
(2, 'Follow up with Patricia on intake form ASAP!!', '1553636353'),
(2, 'Need to go over last revisions with Timothy after meeting with Tek Global on 04/02/2019', '1553636400');

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `method` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_requests`
--

INSERT INTO `payment_requests` (`method`, `data`, `amount`, `status`, `member_id`, `date`, `id`) VALUES
('payoneer', '{\"payoneer_email\":\"\",\"method\":\"payoneer\",\"amount\":\"0\"}', 0, 'processing', 2, '1551556714', 6);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `title` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`title`, `rating`, `review`, `member_id`, `id`) VALUES
('Will use again', '4', 'Awesome', 2, 1),
('Satisfied', '5', '', 2, 5),
('test', '5', 'test', 18, 6),
('test', '3.6', 'test', 19, 7),
('test', '4.6', 'test', 20, 8),
('Exception!', '4.2', 'It was great working with you. Thanks<br>', 21, 9),
('Excellent work!', '5', 'I had no idea how meticulous testing could be. Thank you so much for your help.', 2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `shop_categories`
--

CREATE TABLE `shop_categories` (
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_categories`
--

INSERT INTO `shop_categories` (`name`, `image`, `id`) VALUES
('Website Design & Development', 'de738ca0628caefee439a0598a73da4b.webp', 14),
('Graphic Design ', '69ca2436a4822cb9ab2dfd075d165fb5.webp', 15),
('Digital Marketing ', 'b46958ac679ebb7b335b570b5483ed58.webp', 16),
('IT Systems/Network', '72da5150677588fc2429407e86a90216.webp', 13),
('Entrepreneurship', '95d6a971d3bedf00daf5d1ccaf0eec0c.jpg', 11),
('Product Design/Development', 'f1797ed58efd175863498e0f08cf66bd.webp', 17);

-- --------------------------------------------------------

--
-- Table structure for table `shop_products`
--

CREATE TABLE `shop_products` (
  `product_title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `images` longtext NOT NULL,
  `documents` text NOT NULL,
  `description` longtext NOT NULL,
  `sold_by` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_products`
--

INSERT INTO `shop_products` (`product_title`, `price`, `images`, `documents`, `description`, `sold_by`, `sales`, `rating`, `category`, `id`) VALUES
('PDF', '73.00', '[\"\\/uploads\\/9db37c66db3a00cd7bd61a9625f9472d.png\"]', '[{\"loc\":\"\\/uploads\\/50dad94ae485403407241edbd94f8615.png\",\"name\":\"Screenshot_20190328-150741.png\"}]', 'It\'ll teach you many things<br>', 41, 0, 0, 17, 1),
('Web Theme', '500.00', '[]', '[]', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Morbi tellus enim, vehicula in dignissim sit amet, fringilla fringilla felis. Mauris porta pellentesque felis in suscipit. In ut dui tristique, hendrerit mi vitae, sollicitudin ipsum. Mauris pulvinar vitae sem et sodales. Vestibulum placerat massa a mi sodales consequat. In eleifend sapien a justo pellentesque placerat. Donec nec porta purus. Nam volutpat nulla vel hendrerit fringilla. Maecenas in velit metus. Pellentesque facilisis ex ac consectetur eleifend. Aliquam erat volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas imperdiet odio eu leo pharetra finibus.</p><p><br></p>', 42, 0, 0, 14, 2),
('Test', '0.03', '[]', '[]', '', 2, 0, 0, 11, 3),
('Test', '0.03', '[]', '[]', '', 2, 0, 0, 11, 4),
('Test', '0.03', '[]', '[]', '', 2, 0, 0, 11, 5),
('testtest', '0.03', '[\"\\/uploads\\/8eceb08df50fc9f7290a0f0805a4a4f3.png\"]', '[{\"loc\":\"\\/uploads\\/46c8c66714422af4776471a303740eed.docx\",\"name\":\"New Microsoft Word Document.docx\"}]', 'test', 49, 0, 0, 17, 6);

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `member_id` int(11) NOT NULL,
  `files` longtext NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`member_id`, `files`, `time`) VALUES
(2, '[{\"name\":\"CR.docx\",\"loc\":\"\\/uploads\\/7dbb8c50f24bcfc99da83709bd7a4c57.docx\"}]', '1553636442');

-- --------------------------------------------------------

--
-- Table structure for table `work_listings`
--

CREATE TABLE `work_listings` (
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `duration` varchar(255) NOT NULL,
  `budget` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `review_to_freelancer` text NOT NULL,
  `client` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_listings`
--

INSERT INTO `work_listings` (`title`, `description`, `category`, `type`, `duration`, `budget`, `status`, `review_to_freelancer`, `client`, `time`, `id`) VALUES
('IOS IPad and iphone app developer needed for creating a help industry app focusing on teeth', '<p>Hi,</p><p>I am looking for experienced IOS developer to develop an app for IPad and iphone. The app is for health industry and will focus on teeth - features will include teeth whitening, filling and adding missing teeth. Happy to discuss in detail if you are experienced in this area.</p>', 'Website Design | Development', 'Ongoing Work (Off & On)', 'Less than 1 Week', 'Expert $$$', '0', '', 2, '1551010772', 4),
('Graphic designer needed for creating an infographic/presentation about a company and its services', '<p>Looking for someone who can Create a visually appealing&nbsp; presentation/Infographic for a leading company in Data Science and Data Visualization&nbsp;</p><p>Deliverables needed:</p><p>&nbsp; - An infographic about the company\'s services</p><p>&nbsp; - Visually appealing Presentation/Profile of the company&nbsp;</p><p>In your proposal, please provide your previous project work</p>', 'Website Design | Development', '1-time Project - Fixed Price', 'Less than 1 Week', 'Expert $$$', '0', '', 2, '1551010804', 5),
('API INTEGRATION PHP', '<p>Looking for someone to code an api integration between our platform and another platform\'s api.&nbsp; Will be an intense 3 week project for the right person or team.</p>', 'Website Design | Development', '1-time Project - Fixed Price', 'Less than 1 Week', 'Entry Level $', '0', '', 21, '1551010632', 3),
('Fix my website CSS', '<p>I have a website and need help fixing the CSS.<br></p>', 'Design - Websites', '1-Time Project - Hourly', 'Less than 1 Month', 'Entry Level $', '0', '', 23, '1551480775', 6),
('CD Album Cover Label', 'We\'ll design an outrageous and attractive cover label for your album.', 'Product Designers | Developers - Product Label', '1-time Project - Fixed Price', 'Less than 1 Week', 'Intermediate $$', '0', '', 25, '1551557163', 7),
('Logo for my business', 'I need a logo<br>', 'Product Designers | Developers - Logos', 'Contract Position', '1-3 Months', 'Expert', '0', '', 41, '1553801669', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messaging`
--
ALTER TABLE `messaging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD UNIQUE KEY `time` (`time`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_categories`
--
ALTER TABLE `shop_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_products`
--
ALTER TABLE `shop_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD UNIQUE KEY `time` (`time`);

--
-- Indexes for table `work_listings`
--
ALTER TABLE `work_listings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `messaging`
--
ALTER TABLE `messaging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shop_categories`
--
ALTER TABLE `shop_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shop_products`
--
ALTER TABLE `shop_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `work_listings`
--
ALTER TABLE `work_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
