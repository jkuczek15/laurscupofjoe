<?php

$password = "DnA9194";
$entered_password = isset($_GET['password']) ? $_GET['password'] : null; 

if ($entered_password !== $password) {
	?>
		<form action="viewGuestLimits.php" method="GET">
			<label for="password">Enter Password:</label>
			<input type="text" name="password" id="password" />
			<input type="submit" value="Submit" />
		</form>
	<?php
} else {
	include "./DbConnect.php";
	$rsvp_result = mysqli_query($conn, "SELECT gl.phone_number, gl.name from guest_limits gl Left join RSVP r on r.phone_number = gl.phone_number and gl.name = r.name where r.phone_number is null order by gl.name");
	?>
	<html>
		<head>
	    	<link href="css/bootstrap.min.css?ver=1.1.0" rel="stylesheet">
    		<link href="css/font-awesome/css/all.min.css?ver=1.1.0" rel="stylesheet">
    	</head>
	    <body>
	    	<button type="button" class="btn btn-success" id="csv-export">Export to CSV</button>
			<table class="table" id="guest-limits-table">
			  <thead>
			    <tr>
			      <th scope="col">Name</th>
			      <th scope="col">Phone Number</th>
			    </tr>
			  </thead>
			  <tbody>
			<?php
			while($rsvp = mysqli_fetch_assoc($rsvp_result)) {
			?>
			    <tr>
			      <td><?= $rsvp['name'] ?></td>
			      <td><?= $rsvp['phone_number'] ?></td>
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
    				$('#guest-limits-table').tableExport({fileName: 'viewGuestLimits', type:'csv'});
    			});
    		});
    	</script>
    </html>
	<?php
}