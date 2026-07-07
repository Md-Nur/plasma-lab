<?php 
	include ('server.php');


	$receiver_name = $_POST['name'];
	$receiver_email = $_POST['email'];
	$subject= $_POST['subject'];
	$msg = addslashes($_POST['message']);

	date_default_timezone_set('Asia/Dhaka');
	$date = date("Y/m/d");
	$time = date('h:i:s A');
	

	//body table
	$message = '<html><body>';
	$message .= '<h3>Solar Energy Laboratory</h3>';
	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$message .= "<tr style='background: #eee;'><td><strong>From: </strong> </td><td>" .$receiver_name. "</td></tr>";
	$message .= "<tr><td><strong>Email: </strong> </td><td>" .$receiver_email. "</td></tr>";
	$message .= "<tr><td><strong>Subject: </strong> </td><td>" .$subject. "</td></tr>";
	$message .= "<tr><td><strong>Message: </strong> </td><td>" .$msg. "</td></tr>";
	$message .= "<tr><td><strong>Time: </strong> </td><td>" .$time."</td></tr>";
	$message .= "<tr><td><strong>Date: </strong> </td><td>" .$date."</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";

	$body = $message;
	$altbody = 'Message From'.$receiver_name.'<'.$receiver_email.'><br> Message: '.$msg;

	//time to send email
	include ('mail.php');

	//after mail sent condition
	$send_success = false;
	$error_msg = 'Connection timeout';

	if (empty($website_email) || empty($website_password)) {
		$error_msg = 'Website Email settings are not configured in Settings.';
	} else {
		$send_success = $mail->send();
		if (!$send_success) {
			$error_msg = $mail->ErrorInfo;
		}
	}

	if($send_success) {

		$query = "INSERT INTO sent_msg (name, email, subject, msg,time, date, success) VALUES ('$receiver_name', '$receiver_email', '$subject', '$msg','$time','$date', '1')";

		if ($db->query($query) === TRUE) {

			echo "<span style='color:green;'>Your Message has sent successfully..</span>";
			
		} else {
			echo "<span style='color:red;'>Sorry !! Something Went Wrong...</span>";
		}

	}else{
		
		$query = "INSERT INTO sent_msg (name, email, subject, msg, time, date,  success) VALUES ('$receiver_name', '$receiver_email', '$subject', '$msg', '$time','$date', '0')";
		if ($db->query($query) === TRUE) {

			echo "<span style='color:red;'>Sorry !! Message not sent and Saved to Draft. Error: " . htmlspecialchars($error_msg) . "</span>";
			
		} else {
			echo "<span style='color:red;'>Sorry !! Something Went Wrong...</span>";
		}
	}

?>
