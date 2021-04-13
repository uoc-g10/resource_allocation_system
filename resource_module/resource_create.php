<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "allocationsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$location = $_POST['location'];
$type = $_POST['type'];
$department = $_POST['department'];
$cat = $_POST['catogory'];

$sql = "INSERT INTO resources (name,location,type,department,category) VALUES('$name','$location','$type','$department','$cat')";


if($conn->query($sql)==TRUE){
  echo "New Department has been created successfully";
} else{
  echo "Error".$sql.$conn->error;
}

$conn->close();
?>