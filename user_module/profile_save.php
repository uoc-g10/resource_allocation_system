<?php
require '../includes/conn.php';

//Edit users data
if (isset($_POST['user_edit']) and $_POST['user_id']) {

    // echo '<pre>';
    // print_r($_POST);
    // exit();

    $user_id = $_POST['user_id'];
    $color = $_POST['color'];
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];

    $uid = $_POST['user_id'];

    $sql = "UPDATE users SET title = '$title', firstname = '$firstname', secondname='$secondname', mobile = '$mobile', color='$color', status = 1 WHERE id = $user_id";

    if ($conn->query($sql) == FALSE) {
        $status = 0;
        echo "Error" . $sql . $conn->error;
        exit();
    }
}

if (isset($_POST['lid']) and isset($_FILES['avatar'])) {

    $file_name = $_FILES['avatar']['name'];
    $file_size = $_FILES['avatar']['size'];
    $file_tmp = $_FILES['avatar']['tmp_name'];
    $file_type = $_FILES['avatar']['type'];
    $error = $_FILES['avatar']['error'];
    $uid = $_POST['lid'];
    $status = 0;

    $path = "public/images/lecturers/" . $file_name;
    if (move_uploaded_file($file_tmp, __DIR__ . '/../' . $path)) {
        $sql = "UPDATE users SET image_path = '$path' WHERE id ='$uid'";

        if ($conn->query($sql) == FALSE) {
            echo "Error" . $sql . $conn->error;
            exit();
        }

        $status = 1;
    }

    echo $status;
    exit();
}

header('Location: profile.php');
exit();
