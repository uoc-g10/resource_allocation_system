<?php include '../common/header.php'; ?>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-box-body">
            <div class="text-center">
                <img src="../images/logo-public.png" width="100px">
                <br>
            </div>
            <h3 class="login-box-msg"> Online Resource Allocation System </h3>
            <hr>

            <div class="login-logo">
                <h3> <b> Login</b> </h3>
            </div>
            <form action="/user_dashboard_module/user_dashboard.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
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