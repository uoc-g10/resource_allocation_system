<?php
require '../includes/conn.php';
require '../includes/sendEmails.php';

$status = 0;

if (isset($_POST['title'])) {

    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];

    $email = $_POST['email'];
    $password_raw = randomPassword(8);
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    $role = $_POST['role'];

    $department = 'null';
    $faculty = 'null';

    if ($role == "ROLE_LECTURER") {
        $department = $_POST['department'];
        $faculty = $_POST['faculty'];
    }

    $checkUserEmail = "SELECT * FROM users WHERE email = '$email'";
    if ($conn->query($checkUserEmail) == TRUE) {
        $result = mysqli_query($conn, $checkUserEmail);
        if (mysqli_num_rows($result)) {
            echo 2;
            exit();
        }
    } else {
        echo "Error" . $sql . $conn->error;
    }

    $send_mail = $_POST['send_mail'];
    $sql = "INSERT INTO users (title,firstname,secondname,email,password,mobile,role,department,last_login,status) 
    VALUES('$title', '$firstname','$secondname','$email','$password','$mobile','$role',$department,null,1)";

    if ($conn->query($sql) == TRUE) {
        $status = 1;

        $systemUrl = $_SERVER['HTTP_ORIGIN'];
        $lecturerFullName = $title . ' ' . $firstname . ' ' . $secondname;
        $registerImage = $_SERVER['HTTP_ORIGIN'].'/public/images/user-registerd.png';
        $emailBody = include 'register_email.php';
        sendRegistationEmail($email, $emailBody);

    } else {
        echo "Error" . $sql . $conn->error;
    }

    $conn->close();
    echo $status;
    exit();
}


function randomPassword($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($data), 0, $chars);
}
