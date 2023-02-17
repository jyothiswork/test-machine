<?php

// Replace this with your own email address
$siteOwnersEmail = 'jyothis.work@gmail.com';



require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if ($_POST) {
	$error = array();
	$fname = trim(stripslashes($_POST['contactFname']));
	$lname = trim(stripslashes($_POST['contactLname']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));

	// Check First Name
	if (strlen($fname) < 2) {
		$error['fname'] = "Please enter your first name.";
	}
	// Check Last Name
	if (strlen($lname) < 2) {
		$error['lname'] = "Please enter your last name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 1) {
		$error['message'] = "Please enter your message. It should have at least 15 characters.";
	}
	// Subject
	if ($subject == '') {
		$subject = "Contact Form Submission";
	}

	// Set Name
	$name = $fname . " " . $lname;
	$message = "";
	// Set Message
	$message .= "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

	// Set From: header
	//$from =  $name . " <" . $email . ">";

	// Email Headers
	// $headers = "From: " . $from . "\r\n";
	// $headers .= "Reply-To: ". $email . "\r\n";
	// $headers .= "MIME-Version: 1.0\r\n";
	// $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	if (!$error) {

		//   ini_set("sendmail_from", $siteOwnersEmail); // for windows server
		//   $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		// 	if ($mail) { echo "OK"; }
		//   else { echo "Something went wrong. Please try again."; }



			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host	 = 'smtp.gmail.com;';
			$mail->SMTPAuth = true;
			$mail->Username = 'jyothis.work@gmail.com';
			$mail->Password = 'ijfvtpsxerpzbfuj';
			$mail->SMTPSecure = 'tls';
			$mail->Port	 = 587;

			$mail->setFrom('jyothis.work@gmail.com', $name);
			$mail->addAddress('jyothis@qaptive.co.in', 'TEST');


			$mail->isHTML(true);
			$mail->Subject = 'TEST MAIL FROM AWS TEST';
			$mail->Body = $message;
			$mail->AltBody = 'Body in plain text for non-HTML mail clients';
	
			if($mail->send()){
				echo "OK";die;
			} else{
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";die;
			}			
	
	} # end if - no validation error

	else {

		$response = (isset($error['fname'])) ? $error['fname'] . "<br /> \n" : null;
		$response .= (isset($error['lname'])) ? $error['lname'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;

		echo $response;die;
	} # end if - there was a validation error

}
