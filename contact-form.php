<?php 
	include ('db_connect.php');
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject= $_POST['subject'];
	$msg = $_POST['message'];

	date_default_timezone_set('Asia/Dhaka');
	$date = date("Y/m/d");
	$time = date('h:i:s A');

	$rec = mysqli_query($db, "SELECT * FROM admin_login WHERE id=1");
	$record = mysqli_fetch_array($rec);
	$receiver_email = $record['email'];
	$receiver_firstname = $record['firstname'];
	$receiver_lastname = $record['lastname'];
	$receiver_name = $receiver_firstname.' '.$receiver_lastname;


	//body table
	$message = '<html><body>';
	$message .= '<h3>Plasma Science & Technology Laboratory</h3>';
	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$message .= "<tr style='background: #eee;'><td><strong>From: </strong> </td><td>" .htmlspecialchars($name). "</td></tr>";
	$message .= "<tr><td><strong>Email: </strong> </td><td>" .htmlspecialchars($email). "</td></tr>";
	$message .= "<tr><td><strong>Subject: </strong> </td><td>" .htmlspecialchars($subject). "</td></tr>";
	$message .= "<tr><td><strong>Message: </strong> </td><td>" .nl2br(htmlspecialchars($msg)). "</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";

	$body = $message;
	$altbody = 'Message From '.$name.' <'.$email.'>' . "\r\n" . 'Message: '.$msg;

	//time to send email
	include ('mail.php');

	// Sanitizing inputs for DB safety and compatibility
	$name_db = mysqli_real_escape_string($db, $name);
	$email_db = mysqli_real_escape_string($db, $email);
	$subject_db = mysqli_real_escape_string($db, $subject);
	$msg_db = mysqli_real_escape_string($db, $msg);

	$query = "INSERT INTO message (name, email, subject, msg, time, date, flag) VALUES ('$name_db', '$email_db', '$subject_db', '$msg_db','$time','$date', '0')";

	if ($db->query($query) === TRUE) {
		// Attempt to send the email, but failure doesn't block showing a success response to the user
		if (!empty($website_email) && !empty($website_password)) {
			$mail->send();
		}
		echo "<span style='color:green;'>Your Message has sent successfully.</span>";
	} else {
		echo "<span style='color:red;'>Sorry !! Something Went Wrong.Try again..</span>";
	}

?>
