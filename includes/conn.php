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
