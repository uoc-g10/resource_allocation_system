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
$sql = "INSERT INTO departments SET name='$name'";

if($conn->query($sql)==TRUE){
  echo "New Department has been created successfully";
} else{
  echo "Error".$sql.$conn->error;
}

$conn->close();

?>