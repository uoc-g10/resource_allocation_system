<?php include '../common/header.php'; ?>
<?php
session_start();
if (isset($_SESSION["loggedin"])) {
    header("location: ../user_dashboard_module/user_dashboard.php");
}
$u_email = '';
$u_error = '';

if (isset($_SESSION["u_email"])) {
    $u_email = $_SESSION["u_email"];
    $u_error = $_SESSION["u_error"];
}
?>

<style>
    .alert {
        text-align: center;
        /* width: auto; */
        /* height: 50px; */
        /* display: flex; */
        justify-content: left;
        align-items: center;
        /* border-radius: 0; */
        /* padding-left: 10px; */
        /* padding-right: 40px; */
        font-size: 18px;
        /* margin-bottom: 10px; */
        /* margin-top: 10px; */
        /* box-shadow: rgb(0 0 0 / 6%) 0px 0px 10px; */
        border: 1px solid #ff000033;
        color: red;
    }

    .close-alert {
        color: #000000;
        font-size: 25px;
        display: flex;
        align-items: center;
        position: absolute;
        right: 15px;
        cursor: pointer;
    }

    .close-alert:hover {
        color: #000000;
        background: #f1f1f1;
        border-radius: 50%;
    }

    .error.alert {
        border-left: 6px solid #ff0000;
        background: white;
    }

    /* .error.alert:before {
        content: "\eeb0";
        color: #ff0000;
        font-size: 25px;
        font-family: "boxicons" !important;
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        display: inline-block;
        text-transform: none;
        speak: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding-right: 10px;
    } */
</style>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-box-body">
            <div class="text-center">
                <img src="../images/logo-public.png" width="100px">
                <br>
            </div>

            <h3 class="login-box-msg"> Online Resource Allocation System </h3>
            <?php if ($u_error) {
            ?>
                <div class="alert error" role="alert">
                    <p>
                        <i class="fa fa-user-times" aria-hidden="true" style="margin-right: 5px;"></i>
                        <?php echo $u_error; ?>
                    </p>
                </div>
            <?php
            }
            ?>
            <hr>

            <div class="login-logo">
                <h3> <b> Login </b> </h3>
            </div>

            <form action="user_login.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="username" placeholder="Username" value="<?php echo $u_email ?? $u_email ?>" autofocus required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</body>