<?php
require '../includes/conn.php';

if (isset($_GET['logout'])) {
    // Initialize the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();
    header('location:login.php');
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }


    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, email,firstname, secondname,role,status, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $firstname, $secondname, $role, $status, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {

                            if ($status) {
                                // Password is correct, so start a new session
                                session_start();

                                // Update Last Login Time
                                $query = "UPDATE users SET last_login=NOW() WHERE id =$id";
                                mysqli_query($conn, $query);

                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["email"] = $username;
                                $_SESSION["username"] = $firstname . ' ' . $secondname;
                                $_SESSION["role"] = $role;

                                // Redirect user to welcome page
                                header("location: ../user_dashboard_module/user_dashboard.php");
                            } else {
                                $login_err = "Account Deactivated";
                            }
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Username or Password is Invalid";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Username or Password is Invalid";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);

            session_start();

            // Store data in session variables
            $_SESSION["u_email"] = $username;
            $_SESSION["u_error"] = $login_err;

            header("location: ../user_module/login.php");
        }
    }
    echo $login_err;
}
