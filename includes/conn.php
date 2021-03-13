<?php
	$conn = new mysqli('localhost', 'root', 'pawelb2020', 'apsystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>
