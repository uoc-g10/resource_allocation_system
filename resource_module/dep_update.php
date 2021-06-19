<?php
require '../includes/conn.php';

if (isset($_POST["id"])) {

    $status = 1;
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $faculty = mysqli_real_escape_string($conn, $_POST["faculty"]);

    $sql = "UPDATE departments SET name = '$name', faculty = '$faculty', status = 1 WHERE id = $id";

    if ($conn->query($sql) == FALSE) {
        $status = 0;
        echo "Error" . $sql . $conn->error;
    }

    $conn->close();

    echo $status;
}
