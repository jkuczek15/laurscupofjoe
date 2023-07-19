<?php

include "./DbConnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$lookup_result = mysqli_query($conn, "SELECT name FROM guest_limits WHERE phone_number = '".mysqli_real_escape_string($conn, $_POST['phone_number'])."'");

	$query = '';
	if (mysqli_num_rows($lookup_result) !== 0) {
		$query = "UPDATE guest_limits SET 
		name='".mysqli_real_escape_string($conn, $_POST['name'])."',
		garba_guest_limit=".mysqli_real_escape_string($conn, $_POST['garba_guest_limit']).",
		wedding_guest_limit=".mysqli_real_escape_string($conn, $_POST['wedding_guest_limit']).",
		pithi_guest_limit=".mysqli_real_escape_string($conn, $_POST['pithi_guest_limit']).",
		ganesh_sthapana_guest_limit=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guest_limit']).",
		guest_side = ". ($_POST['ganesh_sthapana_guest_limit'] > 0 ? '1' : '0') ."
		WHERE phone_number = '".mysqli_real_escape_string($conn, str_replace('-', '', $_POST['phone_number']))."'";
	} else {
		$query = "INSERT INTO guest_limits SET 
		name='".mysqli_real_escape_string($conn, $_POST['name'])."',
		phone_number='".mysqli_real_escape_string($conn, str_replace('-', '', $_POST['phone_number']))."',
		garba_guest_limit=".mysqli_real_escape_string($conn, $_POST['garba_guest_limit']).",
		wedding_guest_limit=".mysqli_real_escape_string($conn, $_POST['wedding_guest_limit']).",
		ganesh_sthapana_guest_limit=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guest_limit']).",
		pithi_guest_limit=".mysqli_real_escape_string($conn, $_POST['pithi_guest_limit']).",
		guest_side = ". ($_POST['ganesh_sthapana_guest_limit'] > 0 ? '1' : '0') ;
	}

	mysqli_query($conn, $query);
}

$page_password = "JnA9698";
$entered_password = isset($_GET['password']) ? $_GET['password'] : null;

if (isset($_POST['password']) && $_POST['password'] != null) {
	$entered_password = $_POST['password'];
} 

if ($entered_password !== $page_password) {
	?>
		<form action="CreateGuestLimit.php" method="GET">
			<label for="password">Enter Password:</label>
			<input type="text" name="password" id="password" />
			<input type="submit" value="Submit" />
		</form>
	<?php
} else {

	?>
		<form action="CreateGuestLimit.php" method="POST">
			<input type="hidden" name="password" value="<?= $entered_password ?>" />
			<table>
				<tr>
					<td>Enter name:</td>
					<td><input type="text" name="name" required pattern=".*\S+.*" />
				</tr>
				<tr>
					<td>Enter phone number:</td>
					<td><input type='tel' pattern="[0-9\-]+" name="phone_number" required minlength="10"/>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>Enter Mehndi Guest Limit:</td>
					<td><input type="number" name="garba_guest_limit" min="0" max="10" required />
				</tr>
				<tr>
					<td>Enter Jay's Ganesh Sthapana/Pithi Guest Limit:</td>
					<td><input type="number" name="pithi_guest_limit" min="0" max="10" required />
				</tr>
				<tr>
					<td>Enter Ami's Ganesh Sthapana/Pithi Guest Limit:</td>
					<td><input type="number" name="ganesh_sthapana_guest_limit" min="0" max="10" required />
				</tr>
				<tr>
					<td>Enter Wedding Guest Limit:</td>
					<td><input type="number" name="wedding_guest_limit" min="0" max="10" required/>
				</tr>
			</table>
			<hr/>
			<input type="submit" value="Submit" />
		</form>
	<?php
			if (isset($_POST['name']) && $_POST['name'] != null) {
			?>
				<p><?= $_POST['name'] ?>'s and Family information has been saved.</p>
			<?php
		}
}