<?php

if (isset($_SESSION['_user'])) {
    header('location:dashboard_module/user_dashboard.php');
    die();
}

header('location:user_module/login.php');
die();
