<?php
require '../includes/conn.php';
$login_user = $_SESSION['id'];
$status = 0;

if (isset($_POST['user_id'])) {

    $user_id = $_POST['user_id'];

    if ($login_user == $user_id) {
        $status =  "You can remove yourself";
    } else {

        $sql = "DELETE FROM users WHERE id= $user_id";

        if ($conn->query($sql) == TRUE) {
            $status = 1;
        } else {
            echo "Error" . $sql . $conn->error;
        }
    }
    $conn->close();
}

echo $status;
exit();
