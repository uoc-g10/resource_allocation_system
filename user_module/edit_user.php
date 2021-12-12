<?php
require '../includes/conn.php';

$status = 0;

if (isset($_POST['title'])) {

    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $userId = $_POST['edit_id'];

    $department = 'null';
    $faculty = 'null';

    $query = "UPDATE users SET title ='" . $title . "', firstname ='" . $firstname . "',secondname='" . $secondname . "',mobile='" . $mobile . "', role='" . $role . "' WHERE id = '" . $userId . "'";
    if (mysqli_query($conn, $query)) {
        $status = 1;
    }

    $conn->close();
    echo $status;
    exit();
}
