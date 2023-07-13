<?php

$user_password = "DnA9194";
$entered_password = isset($_GET['password']) ? $_GET['password'] : null; 

if ($entered_password !== $user_password) {
	?>
		<form action="viewGuestLimits.php" method="GET">
			<label for="password">Enter Password:</label>
			<input type="text" name="password" id="password" />
			<input type="submit" value="Submit" />
		</form>
	<?php
} else {
	include "./DbConnect.php";
	$events_selected = isset($_GET['events']) ? $_GET['events'] : null;
	$side = isset($_GET['side']) ? $_GET['side'] : null;
	$rsvp_status = isset($_GET['rsvp_status']) ? $_GET['rsvp_status'] : null;
	$query = "SELECT r.*, gl.*
				FROM guest_limits gl
				LEFT JOIN RSVP r ON r.phone_number = gl.phone_number AND gl.name = r.name				
				WHERE 1=1";

	if ($rsvp_status != '' && $rsvp_status != null) {
		$query = "SELECT gl.name, r.email, gl.phone_number,
					CASE WHEN r.wedding_guests IS NOT NULL
						THEN r.wedding_guests
						ELSE gl.wedding_guest_limit
			        END AS wedding_guest_limit,
			        CASE WHEN r.pithi_guests IS NOT NULL
						THEN r.pithi_guests
						ELSE gl.pithi_guest_limit
			        END AS pithi_guest_limit,
					CASE WHEN r.garba_guests IS NOT NULL
						THEN r.garba_guests
						ELSE gl.garba_guest_limit
			        END AS garba_guest_limit,
					CASE WHEN r.ganesh_sthapana_guests IS NOT NULL
						THEN r.ganesh_sthapana_guests
						ELSE gl.ganesh_sthapana_guest_limit
			        END AS ganesh_sthapana_guest_limit,
					CASE WHEN r.reception_guests IS NOT NULL
						THEN r.reception_guests
						ELSE gl.reception_guest_limit
			        END AS reception_guest_limit
					FROM guest_limits gl 
					LEFT JOIN RSVP r ON r.phone_number = gl.phone_number AND gl.name = r.name";

		if ($rsvp_status === "rsvp") {
			$query .= " WHERE r.phone_number IS NOT NULL";
		} else {
			$query .= " WHERE r.phone_number IS NULL";
		}
	}

	if ($events_selected != null && count($events_selected) > 0) {
		$query .= " AND wedding_guest_limit ".get_operator("wedding", $events_selected)." 0 AND 
			pithi_guest_limit ".get_operator("pithi", $events_selected)." 0 AND
			garba_guest_limit ".get_operator("garba", $events_selected)." 0 AND
			ganesh_sthapana_guest_limit ".get_operator("ganesh", $events_selected)." 0 AND
			reception_guest_limit ".get_operator("reception", $events_selected)." 0";
	}

	if ($side != '' && $side != null) {
		if ($side === "Jay") {
			$query .= " AND guest_side = 0";
		} else {
			$query .= " AND guest_side = 1";
		}
	}

	$query .= " ORDER BY gl.name";

	$rsvp_result = mysqli_query($conn, $query);
	$guest_count = mysqli_num_rows($rsvp_result);
?>
	<html>
		<head>
	    	<link href="css/bootstrap.min.css?ver=1.1.0" rel="stylesheet">
    		<link href="css/font-awesome/css/all.min.css?ver=1.1.0" rel="stylesheet">
    	</head>
	    <body>
	    	<div class="row">
	    		<div class="col-md-2">
	    			<button type="button" class="btn btn-success" id="csv-export">Export to CSV</button>
	    		</div>
	    		<form method="GET" action="viewGuestLimits.php">
	    			<div class="col-md-2 form-inline">
		    			<span><?= $guest_count ?> guests</span>
		    		</div>
		    		<div class="col-md-3 form-inline">
	    				<div class="row">
	    					<div class="col-md-6">
	    						<label for="events" style="margin-top: 7px; width: 200px">Select side:</label>
	    					</div> 					
	    					<div class="col-md-6">
	    						<select name="side" class="form-control" id="side">
	    						  <option value="">Show all</option>
								  <option value="Jay" <?= is_selected("Jay", $side)?>>Jay's side</option>
								  <option value="Ami" <?= is_selected("Ami", $side)?>>Ami's side</option>
								</select>
	    					</div>	    					
	    				</div>
		    		</div>
		    		<div class="col-md-3 form-inline">
	    				<div class="row">
	    					<div class="col-md-6">
	    						<label for="rsvp_status" style="margin-top: 7px; width: 200px">Select RSVP status:</label>
	    					</div> 					
	    					<div class="col-md-6">
	    						<select name="rsvp_status" class="form-control" id="side">
	    						  <option value="">Show all</option>
								  <option value="rsvp" <?= is_selected("rsvp", $rsvp_status)?>>RSVP'd</option>
								  <option value="no_rsvp" <?= is_selected("no_rsvp", $rsvp_status)?>>No RSVP</option>
								</select>
	    					</div>	    					
	    				</div>
		    		</div>
		    		<div class="col-md-4 form-inline">
	    				<div class="row">
	    					<div class="col-md-4">
	    						<label for="events" style="margin-top: 7px; width: 200px">Select events:</label>
	    					</div> 					
	    					<div class="col-md-6">
	    						<select name="events[]" class="form-control" id="events" multiple>
								  <option value="wedding" <?= is_selected("wedding", $events_selected)?>>Wedding</option>
								  <option value="pithi" <?= is_selected("pithi", $events_selected)?>>Jay's Ganesh Sthapana</option>
								  <option value="ganesh" <?= is_selected("ganesh", $events_selected)?>>Ami's Ganesh Sthapana</option>
								</select>
	    					</div>	    					
	    					<div class="col-md-2">
	    						<input type="submit" style="margin-top: 7px" value="Search" />
	    					</div>
	    				</div>
	    				<input type="hidden" name="password" value="<?= $user_password ?>" />
		    		</div>
	    		</form>
	    	</div>
			<table class="table" id="guest-limits-table">
			  <thead>
			    <tr>
			      <th scope="col">Name</th>
				  <th scope="col">Email</th>
			      <th scope="col">Phone Number</th>
			      <th scope="col">Guests for Jay's Ganesh Sthapana</th>
			      <th scope="col">Guests for Ami's Ganesh Sthapana</th>
			      <th scope="col">Guests for Wedding</th>
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
			      <td><?= $rsvp['pithi_guest_limit'] ?></td>
			      <td><?= $rsvp['ganesh_sthapana_guest_limit'] ?></td>
			      <td><?= $rsvp['wedding_guest_limit'] ?></td>
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
    	<script>
    		$(document).ready(() => {
    			$('select').selectpicker();
    			$('#csv-export').click(() => {
    				$('#guest-limits-table').tableExport({fileName: 'viewGuestLimits', type:'csv'});
    			});
    		});
    	</script>
    	<style>
    		.caret {
    			display: none;
    		}
    	</style>
    </html>
	<?php
}

function is_selected($key, $arr) {
	if($arr == null)
		return "";

	if (is_string($arr))
		return $key === $arr ? "selected" : "";

	return in_array($key, $arr) ? "selected" : '';
}

function get_operator($event, $events_selected) {
	return is_selected($event, $events_selected) ? ">" : "=";
}