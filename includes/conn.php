<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "pawelb2020";
$dbname = "allocationsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$User = [];
if (isset($_SESSION['loggedin'])) {
	$uid = $_SESSION['id'];
	$userQuery = "SELECT * FROM users WHERE id=$uid LIMIT 1";
	$userQueryResult = mysqli_query($conn, $userQuery);
	$User = mysqli_fetch_array($userQueryResult);
}

