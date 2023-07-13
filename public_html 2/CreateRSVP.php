<?php

include "./DbConnect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$lookup_result = mysqli_query($conn, "SELECT name FROM RSVP WHERE phone_number = '".mysqli_real_escape_string($conn, $_POST['phone_number'])."'");
	
	$query = '';
	if (mysqli_num_rows($lookup_result) !== 0) {
		$query = "UPDATE RSVP SET 
			name='".mysqli_real_escape_string($conn, $_POST['name'])."',
			email='".mysqli_real_escape_string($conn, $_POST['email'])."',
			pithi_guests=".mysqli_real_escape_string($conn, $_POST['pithi_guests']).",
			ganesh_sthapana_guests=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guests']).",
			garba_guests=".mysqli_real_escape_string($conn, $_POST['garba_guests']).",
			wedding_guests=".mysqli_real_escape_string($conn, $_POST['wedding_guests']).",
			reception_guests=".mysqli_real_escape_string($conn, $_POST['reception_guests']).",
			message='".mysqli_real_escape_string($conn, $_POST['message'])."'
			WHERE phone_number = '".mysqli_real_escape_string($conn, $_POST['phone_number'])."'";
	} else {
		$query = "INSERT INTO RSVP SET 
			name='".mysqli_real_escape_string($conn, $_POST['name'])."',
			email='".mysqli_real_escape_string($conn, $_POST['email'])."',
			phone_number='".mysqli_real_escape_string($conn, $_POST['phone_number'])."',
			pithi_guests=".mysqli_real_escape_string($conn, $_POST['pithi_guests']).",
			ganesh_sthapana_guests=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guests']).",
			garba_guests=".mysqli_real_escape_string($conn, $_POST['garba_guests']).",
			wedding_guests=".mysqli_real_escape_string($conn, $_POST['wedding_guests']).",
			reception_guests=".mysqli_real_escape_string($conn, $_POST['reception_guests']).",
			message='".mysqli_real_escape_string($conn, $_POST['message'])."'";
	}
	mysqli_query($conn, $query);

	sendConfirmationEmail($_POST['email'], $_POST['name'], $_POST['pithi_guests'], $_POST['ganesh_sthapana_guests'],
		$_POST['garba_guests'], $_POST['wedding_guests'], $_POST['reception_guests']);

	echo "OK";
}

function sendConfirmationEmail($to_email, $name, $pithi_guests, $ganesh_sthapana_guests, $garba_guests, $wedding_guests, $reception_guests) {
	try {
		$phpMailer = new PHPMailer(true);
		$phpMailer->isSMTP();
		$phpMailer->Host = "smtp.zoho.com";
		$phpMailer->SMTPAuth = true;
		$phpMailer->Username = "questions@dna-2022.com";
		$phpMailer->Password = "DnA9194!!";
		$phpMailer->SMTPSecure = "tls"; // or PHPMailer::ENCRYPTION_STARTTLS
		$phpMailer->Port = 587;
		$phpMailer->isHTML(true);
		$phpMailer->CharSet = "UTF-8";
		$phpMailer->setFrom("questions@dna-2022.com", "Ami & Jay");

		$phpMailer->addAddress($to_email);
		$phpMailer->Subject = "Thanks for responding to Ami & Jay's Wedding Invitation";

		$body = "
			<p>Thanks for the response, $name!</p>
			<p>Keep this email for reference. It will let you update your response on Ami & Jay's <a href='https://dna-2022.com'>website.</a></p>";

		if ($pithi_guests > 0 || $ganesh_sthapana_guests >0 || $garba_guests > 0 || $wedding_guests > 0 || $reception_guests > 0) {
			$body .= "<p>Below are the number of guests you RSVP'd for:</p>
						<ul>";

			if ($pithi_guests > 0) {
				$body .= "<li>Ganesh sthapana guests: $pithi_guests<br>"; 
				$body .= "Date: 14th July 2024<br>";
				$body .= "Time: 7:30 AM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095</li>";
			}
			if ($ganesh_sthapana_guests > 0) {
				$body .= "<li>Ganesh sthapana guests: $ganesh_sthapana_guests<br>";
				$body .= "Date: 14th July 2024<br>";
				$body .= "Time: 7:30 AM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095</li>";
			}
			
			if ($wedding_guests > 0) {
				$body .= "<li>Wedding guests: $wedding_guests<br>";
				$body .= "Date: 14th July 2024<br>";
				$body .= "Time: 4:30 PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095</li>";
			}
			
			$body .= "</ul>";
		} else {
			$body .= "<p>We are sorry that you cannot make it to any of the events.</p>";
		}


		$body .= "We can't wait to celebrate our special day with you!";

		$body .= "<br/>
				  <p>Thank you,</p>
				  <p>Ami & Jay</p>";

		$phpMailer->Body = $body;
		$phpMailer->IsHTML(true);
		$phpMailer->send();
	} catch (phpmailerException $e) {
  		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  	echo $e->getMessage(); //Boring error messages from anything else!
	}
}