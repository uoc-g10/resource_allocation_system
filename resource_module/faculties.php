<?php
require '../includes/conn.php';
include '../common/header.php'; 
 ?>
<style>
    .box {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        /* border-radius: 5px; */
        margin-top: 25px;
        box-sizing: border-box;
    }

    table.dataTable {
        width: 100% !important;
    }
</style>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1> Manage Faculties </h1>
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
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <a href="#addnew" data-toggle="modal" data-target="#addFaculty" class="btn btn-success btn-sm btn-flat">
                                                    <i class="fa fa-plus"></i> New Faculty
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="row">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="table-responsive">
                            <br />
                            <div id="alert_message"></div>
                            <table id="user_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50px">Id</th>
                                        <th>Faculty Name</th>
                                        <th width="100px"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Add Department -->
<div class="modal fade" id="addFaculty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add new Faculty</b></h4>
            </div>
            <form class="form-horizontal" id="facultyFrm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Faculty Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Faculty Name" required>
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
<div class="modal fade" id="editFaculty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Faculty</b></h4>
            </div>
            <form class="form-horizontal" id="facultyUpdateFrm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Faculty Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="editName" name="name" placeholder="Faculty Name" required>
                            <input type="hidden" class="form-control" id="editId" name="id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/scripts.php'; ?>
<script>
    $(document).ready(function() {

        // Assign DataTable
        var dataTable = $('#user_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetch.php?s=faculties",
                type: "POST"
            }
        });

        // Create New Faculty
        $("#facultyFrm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'faculty_actions.php?s=create',
                data: $(this).serialize(),
                success: function(response) {
                    if (response == '1') {
                        document.getElementById('facultyFrm').reset();
                        $("#addFaculty").modal('hide');
                        dataTable.ajax.reload();
                        showMessage('success', 'New Faculty has been created successfully')
                    }
                }
            });
        });

        // Edit Faculty
        $(document).on('click', '.data-edit', function() {
            var id = $(this).attr("id");
            var name = $(this).attr('data-name');

            $("#editFaculty #editId").val(id);
            $("#editFaculty #editName").val(name);
            $("#editFaculty").modal('show');
        });

        // Save edit Details
        $("#facultyUpdateFrm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'faculty_actions.php?s=update',
                data: $(this).serialize(),
                success: function(response) {
                    if (response == '1') {
                        document.getElementById('facultyUpdateFrm').reset();
                        $("#editFaculty").modal('hide');
                        dataTable.ajax.reload();
                        showMessage('success', 'Faculty Details has been Updated successfully')
                    }
                }
            });
        });

        // Remove Faculty Details
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");

            Swal.fire({
                title: 'Are you sure you want to remove this?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "faculty_actions.php?s=remove",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data == '1') {
                                showMessage('success', 'Faculty has been removed successfully')
                                dataTable.ajax.reload();
                            }
                        }
                    });
                }
            });
        });

        function showMessage(type, description) {
            Swal.fire({
                icon: type,
                title: description,
                showConfirmButton: false,
                timer: 1200
            })
        }

    });
</script>
<?php include '../includes/footer.php'; ?>

</html>