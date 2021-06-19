<?php
// Database Connection
require '../includes/conn.php';

// Create new Faculty
if (isset($_GET['s']) and $_GET['s'] == 'create') {

    $status = 0;

    if (isset($_POST["name"])) {
        $name = $_POST['name'];
        $sql = "INSERT INTO faculties (name, status) VALUES ('$name', 1)";

        if ($conn->query($sql) == FALSE) {
            echo "Error" . $sql . $conn->error;
        }

        $status = 1;
    }

    echo $status;
}

// Remove Faculty
if (isset($_GET['s']) and $_GET['s'] == 'remove') {

    $status = 0;
    if (isset($_POST["id"])) {

        $id = $_POST["id"];
        $query = "DELETE FROM faculties WHERE id = '" . $_POST["id"] . "'";
        if (mysqli_query($conn, $query)) {
            $status = 1;
        }
    }

    echo $status;
}

// Update Faculty
if (isset($_GET['s']) and $_GET['s'] == 'update') {

    $status = 0;

    if (isset($_POST["id"])) {

        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $query = "UPDATE faculties SET name ='" . $name . "' WHERE id = '" . $_POST["id"] . "'";
        if (mysqli_query($conn, $query)) {
            $status = 1;
        }
    }

    echo $status;
}

$conn->close();
