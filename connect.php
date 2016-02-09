<?php
$servername = "localhost";
$dbname = "contacts";
$username = "--------";
$password = "xxxxxxxxxxxxx";
 
 
$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
        }
?>
