<?php
require '../includes/conn.php';

if (isset($_POST["id"])) {
    $query = "DELETE FROM resources WHERE id = '" . $_POST["id"] . "'";
    if (mysqli_query($conn, $query)) {
        echo '1';
    }
}
