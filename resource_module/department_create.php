<?php

require '../includes/conn.php';

$name = $_POST['name'];
$sql = "INSERT INTO departments (name, status) VALUES ('$name', 1)";

if ($conn->query($sql) == TRUE) {
  echo "New Department has been created successfully";
} else {
  echo "Error" . $sql . $conn->error;
}

$conn->close();
