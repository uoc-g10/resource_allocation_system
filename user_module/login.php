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
    body {
        background-color: #631011;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg stroke='%23f2272a' stroke-width='66.7' stroke-opacity='0.05' %3E%3Ccircle fill='%23631011' cx='0' cy='0' r='1800'/%3E%3Ccircle fill='%236c1112' cx='0' cy='0' r='1700'/%3E%3Ccircle fill='%23741113' cx='0' cy='0' r='1600'/%3E%3Ccircle fill='%237d1214' cx='0' cy='0' r='1500'/%3E%3Ccircle fill='%23861316' cx='0' cy='0' r='1400'/%3E%3Ccircle fill='%238f1316' cx='0' cy='0' r='1300'/%3E%3Ccircle fill='%23981417' cx='0' cy='0' r='1200'/%3E%3Ccircle fill='%23a11418' cx='0' cy='0' r='1100'/%3E%3Ccircle fill='%23aa1519' cx='0' cy='0' r='1000'/%3E%3Ccircle fill='%23b3161a' cx='0' cy='0' r='900'/%3E%3Ccircle fill='%23bc161a' cx='0' cy='0' r='800'/%3E%3Ccircle fill='%23c6171b' cx='0' cy='0' r='700'/%3E%3Ccircle fill='%23cf181b' cx='0' cy='0' r='600'/%3E%3Ccircle fill='%23d9181c' cx='0' cy='0' r='500'/%3E%3Ccircle fill='%23e2191c' cx='0' cy='0' r='400'/%3E%3Ccircle fill='%23ec1a1c' cx='0' cy='0' r='300'/%3E%3Ccircle fill='%23f51b1c' cx='0' cy='0' r='200'/%3E%3Ccircle fill='%23ff1c1c' cx='0' cy='0' r='100'/%3E%3C/g%3E%3C/svg%3E");
        background-attachment: fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box-body,
    .register-box-body {
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #7f1416;
        border-color: #7f1416;
        padding: 11px;
        border-radius: 4px !important;
    }

    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary.hover,
    .btn-primary.focus,
    .btn-primary:focus,
    .btn-primary:active:focus,
    .btn-primary:active:hover {
        background-color: #b52c1f;
        border-color: #7f1416;
    }

    .form-control:focus {
        border-color: #9d1518;
        box-shadow: none;
    }

    .form-control {
        height: 40px;
        border-radius: 4px !important;
    }

    .form-control-feedback {
        width: 38px;
        height: 45px;
        line-height: 41px;
    }

    .login-box-body {
        padding: 25px;
    }

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
        font-size: 14px;
        /* margin-bottom: 10px; */
        /* margin-top: 10px; */
        /* box-shadow: rgb(0 0 0 / 6%) 0px 0px 10px; */
        border: 1px solid #ff000033;
        color: #e2393c;
        padding: 6px;
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
    .login-box-1 {
        width: 350px;
    }

    .login-box-msg {
        padding: 0;
        padding-top: 16px;
    }
</style>

<body class="hold-transition login-page">
    <div class="login-box-1">

        <div class="login-box-body">
            <div class="text-center">
                <img src="../images/logo-colored.png" width="230px">
                <br>
            </div>
            <!-- <h3 class="login-box-msg">Resource Allocation System </h3> -->
            <hr>
            <div class="login-logo">
                <h3> <b> Login </b> </h3>
            </div>
            <?php if ($u_error) { ?>
                <div class="alert error" role="alert">
                    <p>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="margin-right: 5px;"></i>
                        <?php echo $u_error; ?>
                    </p>
                </div>
            <?php } ?>

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
                <div class="text-center">
                    <a href="password-reset.php" class="text-muted">
                        <i class="fa fa-refresh"></i> Forgot my passowrd
                    </a>
                </div>

            </form>
        </div>
    </div>
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script>
        var loginError = "<?php echo $u_error; ?>";
        if (loginError) {
            setTimeout(function() {
                //$('.error').hide();
            }, 5000);
        }

        $("[name='username'], [name='password']").on('input', function() {
            $('.error').hide();
        });

        $('[name="login"]').click(function() {
            var email = $("[name='username']").val();
            var password = $("[name='password']").val();

            if (email && password) {
                $(this).html('<i class="fa fa-spin fa-spinner"></i>');
            }
        });
    </script>
</body>