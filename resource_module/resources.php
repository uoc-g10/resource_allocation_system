<?php include '../common/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../includes/navbar.php'; ?>
        <?php include '../includes/menubar.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1> Manage Resources </h1>
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
                                                <a href="#addnew" data-toggle="modal" data-target="#addResource" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> New Resources</a>
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
                                        <th>Resource Name</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Department</th>
                                        <th>Category</th>
                                        <th class="text-right">Actions</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001</td>
                                            <td> ICT Lecture Hall </td>
                                            <td> Building 1 - First floor </td>
                                            <td> Main </td>
                                            <td> ICT Department</td>
                                            <td> Lecturer Hall </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editResource"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm btn-flat delete' data-toggle="modal" data-target="#delete"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td> Computer Lab </td>
                                            <td> Building 2 - 2 nd floor </td>
                                            <td> Main </td>
                                            <td> ICT Department</td>
                                            <td> Laboratory </td>
                                            <td class="text-right">
                                                <button class='btn btn-default btn-sm btn-flat edit' data-toggle="modal" data-target="#editResource"><i class='fa fa-edit'></i> Edit</button>
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

        <!-- Add Resource -->
        <div class="modal fade" id="addResource">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Add new Resource</b></h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Resource Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="Resource Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="col-sm-3 control-label">Location</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="location" name="location" value="Location">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-3 control-label">Type</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="type" name="type">
                                        <option> Main </option>
                                        <option> Sub </option>
                                        <option> etc :) </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="col-sm-3 control-label">Department</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="department" name="department">
                                        <option> ICT Department </option>
                                        <option> Engneering Technology Department </option>
                                        <option> Environment Department </option>
                                        <option> Agriculture Department </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="catogory" class="col-sm-3 control-label">Catogory</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="catogory" name="catogory">
                                        <option> Lecturer Hall </option>
                                        <option> Auditorium </option>
                                        <option> Laboratory </option>
                                        <option> Playground </option>
                                        <option> Other </option>
                                    </select>
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

        <!-- Edit Resource -->
        <div class="modal fade" id="editResource">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Add new Resource</b></h4>
                    </div>
                    <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Resource Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="Resource Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="col-sm-3 control-label">Location</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="location" name="location" value="Location">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-3 control-label">Type</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="type" name="type">
                                        <option> Main </option>
                                        <option> Sub </option>
                                        <option> etc :) </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="col-sm-3 control-label">Department</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="department" name="department">
                                        <option> ICT Department </option>
                                        <option> Engneering Technology Department </option>
                                        <option> Environment Department </option>
                                        <option> Agriculture Department </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="catogory" class="col-sm-3 control-label">Catogory</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="catogory" name="catogory">
                                        <option> Lecturer Hall </option>
                                        <option> Auditorium </option>
                                        <option> Laboratory </option>
                                        <option> Playground </option>
                                        <option> Other </option>
                                    </select>
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
                                <p>DELETE SCHEDULE</p>
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