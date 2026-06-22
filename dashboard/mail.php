<?php

//Fetch Email data
$for_page = mysqli_query($db, "SELECT * FROM website WHERE id = 1");
$record_site = mysqli_fetch_array($for_page);
$website_name = $record_site['sitename'];
$website_email = $record_site['siteemail'];
$website_password = $record_site['sitepassword'];

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(false);                              // Passing `false` disables exceptions

//Server settings

$mail->SMTPDebug = 0;                                 // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               			// Enable SMTP authentication
$mail->Username = $website_email;                 // SMTP username
$mail->Password = $website_password;                        				 // SMTP password
$mail->SMTPSecure = 'ssl';                           				 // Enable TLS encryption, `ssl` also accepted
$mail->Port = '465';    //or 587                               				 // TCP port to connect to

//Recipients
$mail->setFrom($website_email, $website_name);	 			 //my email 
$mail->addAddress($receiver_email, $receiver_name);     					// Add a recipient


//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->AltBody = $altbody;


?>