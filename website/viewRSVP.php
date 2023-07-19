<?php

$password = "DnA9194";
$entered_password = isset($_GET['password']) ? $_GET['password'] : null; 

if ($entered_password !== $password) {
	?>
		<form action="viewRSVP.php" method="GET">
			<label for="password">Enter Password:</label>
			<input type="text" name="password" id="password" />
			<input type="submit" value="Submit" />
		</form>
	<?php
} else {
	include "./DbConnect.php";
	$rsvp_result = mysqli_query($conn, "SELECT * FROM RSVP order by name");
	?>
	<html>
		<head>
	    	<link href="css/bootstrap.min.css?ver=1.1.0" rel="stylesheet">
    		<link href="css/font-awesome/css/all.min.css?ver=1.1.0" rel="stylesheet">
    	</head>
	    <body>
	    	<button type="button" class="btn btn-success" id="csv-export">Export to CSV</button>
			<table class="table" id="rsvp-table">
			  <thead>
			    <tr>
			      <th scope="col">Name</th>
			      <th scope="col">Email</th>
			      <th scope="col">Phone Number</th>
			      <th scope="col">Guests for Dhruv's Ganesh Sthapana</th>
			      <th scope="col">Guests for Ami's Ganesh Sthapana</th>
			      <th scope="col">Guests for Garba</th>
			      <th scope="col">Guests for Wedding</th>
			      <th scope="col">Guests for Reception</th>
			      <th scope="col">Message</th>
			    </tr>
			  </thead>
			  <tbody>
			<?php
			while($rsvp = mysqli_fetch_assoc($rsvp_result)) {
			?>
			    <tr>
			      <td><?= $rsvp['name'] ?></td>
			      <td><?= $rsvp['email'] ?></td>
			      <td><?= $rsvp['phone_number'] ?></td>
			      <td><?= $rsvp['pithi_guests'] ?></td>
			      <td><?= $rsvp['ganesh_sthapana_guests'] ?></td>
			      <td><?= $rsvp['garba_guests'] ?></td>
			      <td><?= $rsvp['wedding_guests'] ?></td>
			      <td><?= $rsvp['reception_guests'] ?></td>
			      <td><?= $rsvp['message'] ?></td>
			    </tr>
			<?php
			}
			?>
			  </tbody>
			</table>
		</body>
		<script src="scripts/jquery.min.js?ver=1.1.0"></script>
    	<script src="scripts/bootstrap.bundle.min.js?ver=1.1.0"></script>
    	<script src="scripts/tableExport.min.js"></script>
    	<script>
    		$(document).ready(() => {
    			$('#csv-export').click(() => {
    				$('#rsvp-table').tableExport({fileName: 'rsvps', type:'csv'});
    			});
    		});
    	</script>
    </html>
	<?php
}