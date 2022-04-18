<?php
session_start();
date_default_timezone_set('Asia/Colombo');

$servername = "localhost";
$username = "root";
$password = "pawelb2020";
$dbname = "allocationsystem";

// $servername = "localhost";
// $username = "u221855502_root";
// $password = "wpAD?L]0";
// $dbname = "u221855502_allocation";

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

