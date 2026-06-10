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
	$message .= "<tr style='background: #eee;'><td><strong>From: </strong> </td><td>" .$name. "</td></tr>";
	$message .= "<tr><td><strong>Email: </strong> </td><td>" .$email. "</td></tr>";
	$message .= "<tr><td><strong>Subject: </strong> </td><td>" .$subject. "</td></tr>";
	$message .= "<tr><td><strong>Message: </strong> </td><td>" .$msg. "</td></tr>";
	$message .= "</table>";
	$message .= "</body></html>";





	$message = '<html><body>';
	$message .= '<img src="//css-tricks.com/examples/WebsiteChangeRequestForm/images/wcrf-header.png" alt="Website Change Request" />';
	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['req-name']) . "</td></tr>";
	$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['req-email']) . "</td></tr>";
	$message .= "<tr><td><strong>Type of Change:</strong> </td><td>" . strip_tags($_POST['typeOfChange']) . "</td></tr>";
	$message .= "<tr><td><strong>Urgency:</strong> </td><td>" . strip_tags($_POST['urgency']) . "</td></tr>";
	$message .= "<tr><td><strong>URL To Change (main):</strong> </td><td>" . $_POST['URL-main'] . "</td></tr>";



	$body = $message;
	$altbody = 'Message From'.$name.'<'.$email.'><br> Message: '.$msg;
	//time to send email
	include ('mail.php');

	//after maile sent condition

	

	$query = "INSERT INTO message (name, email, subject, msg, time, date, flag) VALUES ('$name', '$email', '$subject', '$msg','$time','$date', '0')";

	if ($db->query($query) === TRUE) {

		if($mail->send()) {

			echo "<span style='color:green;'>Your Message has sent successfully.</span>";

		}else{

			echo "<span style='color:red;'>Sorry !! Message not sent. Time out...</span>";

		}

	} else {

		echo "<span style='color:red;'>Sorry !! Something Went Wrong.Try again..</span>";

	}




?>
