<?php

include("DbConnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : null;
	$name = isset($_GET['name']) ? $_GET['name'] : null;

	$lookup_query = "SELECT 
	CASE WHEN r.pithi_guests IS NULL
		THEN gl.pithi_guest_limit
		ELSE r.pithi_guests
    END AS pithi_guests,
    CASE WHEN r.ganesh_sthapana_guests IS NULL
		THEN gl.ganesh_sthapana_guest_limit
		ELSE r.ganesh_sthapana_guests
    END AS ganesh_sthapana_guests,
	CASE WHEN r.garba_guests IS NULL
		THEN gl.garba_guest_limit
		ELSE r.garba_guests
    END AS garba_guests,
	CASE WHEN r.wedding_guests IS NULL
		THEN gl.wedding_guest_limit
		ELSE r.wedding_guests
    END AS wedding_guests,
	CASE WHEN r.reception_guests IS NULL
		THEN gl.reception_guest_limit
		ELSE r.reception_guests
    END AS reception_guests
	FROM guest_limits gl
	LEFT JOIN RSVP r ON gl.phone_number = r.phone_number AND gl.name = r.name 
	WHERE gl.phone_number = '".mysqli_real_escape_string($conn, $phone_number)."'
	AND gl.name = '".mysqli_real_escape_string($conn, $name)."'";

	$result = mysqli_query($conn, $lookup_query);

	if (mysqli_num_rows($result) === 0) {
		echo "Combination of your Name and Phone number don't match, please try again with another family member's phone number. If that doesn't work, please contact Hansa Patel or Swati Shah to have your phone number added to the RSVP list.";
	} else {
		$guest_limits = mysqli_fetch_assoc($result);
		echo json_encode($guest_limits);
	}
}