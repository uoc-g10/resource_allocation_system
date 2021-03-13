<?php include '../common/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../includes/navbar.php'; ?>
        <?php include '../includes/menubar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1> Manage Users </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </section>

            <section class="content">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <br>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <a href="#addnew" data-toggle="modal" data-target="#addUser" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> New User</a>
                                            </div>
                                        </div>

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="search" class="form-control">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-flat" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true">
                                                            </span> Search!</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Id</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Role</th>
                                        <th>User Last Login</th>
                                        <th class="text-right">Actions</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001</td>
                                            <td> Dr. Rohan Samarasinghe </td>
                                            <td> rohansamarasinghe@gmail.com </td>
                                            <td> Lecturer </td>
                                            <td> - </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat'><i class='fa fa-ban'></i> Block</button>
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editUser"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td> Mr. Navod Thilakarathna </td>
                                            <td> navodtk@gmail.com </td>
                                            <td> Lecturer </td>
                                            <td> 2020-03-10 11:05PM </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat'><i class='fa fa-ban'></i> Block</button>
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editUser"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td> Miss. Hasini Nethma </td>
                                            <td> hasininth@gmail.com </td>
                                            <td> Manage User </td>
                                            <td> 2020-03-12 10:31AM </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat'><i class='fa fa-ban'></i> Block</button>
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editUser"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr style="color: #9a9a9a;">
                                            <td>004</td>
                                            <td> Mr. Eshana Rathnaweera </td>
                                            <td> eshsnaath@gmail.com </td>
                                            <td> Manage User </td>
                                            <td> 2020-03-12 10:31AM </td>
                                            <td class="text-right">
                                                <button class='btn btn-success btn-sm btn-flat'><i class='fa fa-ban'></i> Unblock</button>
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editUser"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Add User -->
        <div class="modal fade" id="addUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Add new User</b></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">Title</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title" value="User Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="col-sm-3 control-label">First Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="First Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="secondname" class="col-sm-3 control-label">Second Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="secondname" name="secondname" value="Second Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-sm-3 control-label">Mobile Number</label>

                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="mobile" name="mobile" value="User Mobile Number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="col-sm-3 control-label">Department</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="department" name="department" value="Department">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Email Address</label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="sample@mail.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" value="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Repeat Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" value="password">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User -->
        <div class="modal fade" id="editUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Edit User</b></h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label">Title</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title" value="User Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="col-sm-3 control-label">First Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="First Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="secondname" class="col-sm-3 control-label">Second Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="secondname" name="secondname" value="Second Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-sm-3 control-label">Mobile Number</label>

                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" id="mobile" name="mobile" value="User Mobile Number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="col-sm-3 control-label">Department</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="department" name="department" value="Department">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Email Address</label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="sample@mail.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" value="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Repeat Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" value="password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete -->
        <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Deleting...</b></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="">
                            <input type="hidden" id="del_timeid" name="id">
                            <div class="text-center">
                                <p>DELETE USER</p>
                                <h2 id="del_schedule" class="bold"></h2>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../includes/scripts.php'; ?>
        <?php include '../includes/footer.php'; ?>
    </div>

</body>

</html>