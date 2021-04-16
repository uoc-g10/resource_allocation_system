<?php

require '../includes/conn.php';

$status = 1;
if (isset($_POST['name']) and isset($_POST['faculty'])) {

  $name = $_POST['name'];
  $faculty = $_POST['faculty'];

  $sql = "INSERT INTO departments (name,faculty, status) VALUES ('$name','$faculty', 1)";

  if ($conn->query($sql) == FALSE) {
    $status = 0;
    echo "Error" . $sql . $conn->error;
  }

  $conn->close();
}

echo $status;
