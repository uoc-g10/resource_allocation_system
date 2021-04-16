<?php
require '../includes/conn.php';

$status = 1;
if (isset($_POST['name'])) {

  $name = $_POST['name'];
  $location = $_POST['location'];
  $type = $_POST['type'];
  $faculty = $_POST['faculty'];
  $department = $_POST['department'];
  $cat = $_POST['catogory'];

  $sql = "INSERT INTO resources (name,location,type,department,faculty,category, status) VALUES('$name','$location','$type',$department, $faculty, '$cat',1)";

  if ($conn->query($sql) == FALSE) {
    echo "Error" . $sql . $conn->error;
    $status = 0;
  }

  $conn->close();
}


echo $status;
exit();
