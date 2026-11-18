<?php 
	include ('db_connect.php');
	$name = trim($_POST['name'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$subject = trim($_POST['subject'] ?? '');
	$msg = trim($_POST['message'] ?? '');

	if (empty($name) || empty($email) || empty($subject) || empty($msg)) {
		echo "<span style='color:#e85d75;'><i class='fa fa-exclamation-triangle'></i> All fields are required. Please fill out the form completely.</span>";
		exit;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<span style='color:#e85d75;'><i class='fa fa-exclamation-triangle'></i> Invalid email address format. Please enter a valid Gmail / Email address.</span>";
		exit;
	}

	if (stripos($email, '@gmail.com') !== false) {
		$parts = explode('@', $email);
		$user = strtolower($parts[0]);
		if (strlen($user) < 6 || strlen($user) > 30 || !preg_match('/^[a-z0-9.]+$/', $user) || $user[0] === '.' || substr($user, -1) === '.' || strpos($user, '..') !== false) {
			echo "<span style='color:#e85d75;'><i class='fa fa-exclamation-triangle'></i> Invalid Gmail username format (must be 6-30 characters, letters, numbers, dots).</span>";
			exit;
		}
	}

	date_default_timezone_set('Asia/Dhaka');
	$date = date("Y/m/d");
	$time = date('h:i:s A');

	$rec = mysqli_query($db, "SELECT * FROM admin_login WHERE id=1");
	$record = mysqli_fetch_array($rec);
	$receiver_email = '';
	$receiver_name = '';
	if ($record) {
		$receiver_email = $record['email'];
		$receiver_firstname = $record['firstname'];
		$receiver_lastname = $record['lastname'];
		$receiver_name = $receiver_firstname.' '.$receiver_lastname;
	}


	//body table
	$message = '<html><body>';
	$message .= '<h3>Plasma Engineering Laboratory</h3>';
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
