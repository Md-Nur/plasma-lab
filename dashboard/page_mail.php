<?php




// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
$mail->Timeout = 30;                                  // SMTP connection timeout (seconds)


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