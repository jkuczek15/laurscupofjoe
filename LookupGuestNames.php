<?php

include "./DbConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$search = isset($_GET['q']) && $_GET['q'] != null ? $_GET['q'] : null;

	$lookup_query = "SELECT name FROM guest_limits";
	if ($search != null) {
		$lookup_query .= " WHERE name LIKE '%$search%'";
	}
	$lookup_query .= " ORDER BY name LIMIT 5";
 
	$result = mysqli_query($conn, $lookup_query);

	$guests = [];
	while ($guest = mysqli_fetch_assoc($result)) {
		$guests[] = [
			'text' => $guest['name'] . ' and Family',
			'value' => $guest['name']
		];
	}
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($guests);
}