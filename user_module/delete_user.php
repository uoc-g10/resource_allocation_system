<?php
require '../includes/conn.php';

if (isset($_POST["id"])) {
    $status = 0;
    $query = "DELETE FROM users WHERE id = '" . $_POST["id"] . "'";
    if (mysqli_query($conn, $query)) {
        $status = 1;
    }
    echo $status;
}
