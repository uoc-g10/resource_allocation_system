<?php
require '../includes/conn.php';

if (isset($_POST["id"])) {
    $value = mysqli_real_escape_string($conn, $_POST["value"]);
    $query = "UPDATE users SET " . $_POST["column_name"] . "='" . $value . "' WHERE id = '" . $_POST["id"] . "'";
    if (mysqli_query($conn, $query)) {
        echo 'Data Updated';
    }
}
