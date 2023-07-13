<?php

$servername = "localhost";
$username = "id19544989_admin";
$password = "U7e/TmW*)cXT}u2F";
$db_name = "id19544989_amicaughtajay";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $db_name);