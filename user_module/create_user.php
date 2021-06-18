<?php
require '../includes/conn.php';

$status = 0;

if (isset($_POST['title'])) {

    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];

    $email = $_POST['email'];
    $password_raw = $_POST['password'];
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    $role = $_POST['role'];

    $department = 'null';
    $faculty = 'null';

    if ($role == "ROLE_LECTURER") {
        $department = $_POST['department'];
        $faculty = $_POST['faculty'];
    }

    $send_mail = $_POST['send_mail'];
    $sql = "INSERT INTO users (title,firstname,secondname,email,password,mobile,role,department,last_login,status) 
    VALUES('$title', '$firstname','$secondname','$email','$password','$mobile','$role',$department,null,1)";

    if ($conn->query($sql) == TRUE) {
        $status = 1;
    } else {
        echo "Error" . $sql . $conn->error;
    }

    $conn->close();
}

echo $status;
exit();
