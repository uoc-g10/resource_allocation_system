<?php include '../common/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../includes/navbar.php'; ?>
        <?php include '../includes/menubar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1> Manage Departments </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href=""><i class="fa fa-dashboard"></i> Home</a>
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
                                                <a href="#addnew" data-toggle="modal" data-target="#addDepartment" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> New Department</a>
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
                                        <th>Department Name</th>
                                        <th class="text-right">Actions</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001</td>
                                            <td> ICT Department </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editDepartment"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td> Engneering Technology Department </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editDepartment"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td> Environment Department </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editDepartment"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>004</td>
                                            <td> Agriculture Department </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editDepartment"><i class='fa fa-edit'></i> Edit</button>
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

        <!-- Add Department -->
        <div class="modal fade" id="addDepartment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Add new Department</b></h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Depaerment Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="Depaerment Name">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Department -->
        <div class="modal fade" id="editDepartment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Edit Department Details</b></h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Depaerment Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="Depaerment Name">
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
                            <p>DELETE DEPARTMENT</p>
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