<?php

include("DbConnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : null;
	$name = isset($_GET['name']) ? $_GET['name'] : null;

	$lookup_query = "SELECT * FROM guest_limits WHERE phone_number = '".mysqli_real_escape_string($conn, $phone_number)."'
	AND name = '".mysqli_real_escape_string($conn, $name)."'";

	$result = mysqli_query($conn, $lookup_query);

	if (mysqli_num_rows($result) === 0) {
		echo "Combination of your Name and Phone number don't match, please try again with another family member's phone number. If that doesn't work, please contact Hansa Patel or Swati Shah to have your phone number added to the RSVP list.";
	} else {
		$guest_limits = mysqli_fetch_assoc($result);
		echo json_encode($guest_limits);
	}
}