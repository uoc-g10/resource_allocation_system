<?php
require '../includes/conn.php';

if (isset($_POST["id"])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
    $faculty = mysqli_real_escape_string($conn, $_POST["faculty"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $catogory = mysqli_real_escape_string($conn, $_POST["catogory"]);
    
    $query = "UPDATE resources SET name = '$name',location = '$location', department = $department,faculty = $faculty, category = '$catogory' WHERE id= $id";
    if (mysqli_query($conn, $query)) {
        echo 'Data Updated';
    }

    echo $conn->error;
}
