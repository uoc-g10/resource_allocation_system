<?php
require '../includes/conn.php';
require '../includes/sendEmails.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Reset Link Send Action

    if (isset($_POST['password-reset'])) {

        $resetImage = $_SERVER['HTTP_ORIGIN'] . '/public/images/passwod-reset.png';
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(50));

        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $query = "UPDATE users SET token ='$token' WHERE email='$email'";

            if (mysqli_query($conn, $query)) {
                $returnLink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?_token=$token";
                $emailBody = include 'reset_email.php';
                sendResetEmail($email, $emailBody);
                $_SESSION['reset_link_send'] = 1;
                header('location: password-reset.php');
                exit();
            }
        } else {
            $_SESSION['password_reset_no_email'] = "This Email is not Registerd in System";
            $_SESSION['password_reset_email'] = $email;
            header('location: password-reset.php');
            exit();
        }
    }

    if (isset($_POST['password-reset-getnew'])) {
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $token =  $_SESSION['reset_token'];

        if ($password1 == $password2) {

            $password = password_hash($password1, PASSWORD_DEFAULT); //encrypt password
            $query = "UPDATE users SET password='$password' WHERE token='$token'";
            if (mysqli_query($conn, $query)) {
                $_SESSION = array();

                $_SESSION['reset_password_success'] = 1;
                header('location: password-reset.php');
                exit();
            }
        } else {
            $_SESSION['reset_passwords_not_match'] = "Passwords Not Match";
            header('location: password-reset.php');
            exit();
        }
    }
}



// Gmail Link to Change Password

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['_token'])) {

        $token = $_GET['_token'];
        $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['reset_link_send'] = 0;
            $_SESSION['reset_password'] = 1;
            $_SESSION['reset_token'] = $token;
            header('location: password-reset.php');
            exit();
        } else {
            header('location: login.php');
            exit();
        }
    }
}
