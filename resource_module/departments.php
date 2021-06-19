<?php
require '../includes/conn.php';
$query = "SELECT id,name FROM faculties ";
$result = mysqli_query($conn, $query);
$faculties = [];
while ($faculty = mysqli_fetch_array($result)) {
    $faculties[] = array('id' => $faculty['id'], 'name' => $faculty['name']);
}
?>

<?php include '../common/header.php'; ?>
<style>
    .box {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        /* border-radius: 5px; */
        margin-top: 25px;
        box-sizing: border-box;
    }

    .swal2-actions button {
        border-radius: 0 !important;
    }
</style>

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
                                        <th>Department Name</th>
                                        <th>Faculty</th>
                                        <th width="100px"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
            <form class="form-horizontal" id="departmentFrm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Department Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Department Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Faculty</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="faculty">
                                <?php foreach ($faculties as $faculty) {
                                    echo "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . " </option>";
                                } ?>
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

<!-- Edit Department -->
<div class="modal fade" id="editDepartment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Department</b></h4>
            </div>
            <form class="form-horizontal" id="departmentEditFrm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Department Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="editName" name="name" placeholder="Department Name" required>
                            <input type="hidden" class="form-control" id="editId" name="id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Faculty</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="faculty" id="editFaculty">
                                <?php foreach ($faculties as $faculty) {
                                    echo "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . " </option>";
                                } ?>
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

<?php include '../includes/scripts.php'; ?>
<script>
    $(document).ready(function() {


        // Initiate DataTable
        var dataTable = $('#user_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetch.php?s=departments",
                type: "POST"
            }
        });


        // Create Department
        $("#departmentFrm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'department_create.php',
                data: $('#departmentFrm').serialize(),
                success: function(response) {
                    $("#addDepartment").modal('hide');
                    dataTable.ajax.reload();
                    var form = document.getElementById('departmentFrm').reset();
                    showMessage('success', 'New Department has been created successfully')
                }
            });
        });


        // Edit Department
        $(document).on('click', '.data-edit', function() {
            var id = $(this).attr("id");
            var name = $(this).attr('data-name');
            var facultyId = $(this).attr('data-fid');

            $("#editId").val(id);
            $("#editName").val(name);
            $('#editFaculty option').removeAttr('selected');
            $('#editFaculty option[value="' + facultyId + '"]').attr('selected', true);
            $("#editDepartment").modal('show');
        });


        // Save Edit Details
        $("#departmentEditFrm").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'dep_update.php',
                data: $('#departmentEditFrm').serialize(),
                success: function(response) {
                    $("#editDepartment").modal('hide');
                    dataTable.ajax.reload();
                    var form = document.getElementById('departmentEditFrm').reset();
                    showMessage('success', 'New Department has been created successfully')
                }
            });
        });

        // Remove Department Record
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
                        url: "dep_delete.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data == '1') {
                                showMessage('success', 'Department has been removed successfully')
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
                timer: 1500
            })
        }

        function update_data(id, column_name, value) {
            $.ajax({
                url: "dep_update.php",
                method: "POST",
                data: {
                    id: id,
                    column_name: column_name,
                    value: value
                },
                success: function(data) {
                    $('#alert_message').html('<div class="alert alert-success">' + data + ' < /div>');
                    $('#user_data').DataTable().destroy();
                    fetch_data();
                }
            });
            setInterval(function() {
                $('#alert_message').html('');
            }, 5000);
        }

        $(document).on('blur', '.update', function() {
            var id = $(this).data("id");
            var column_name = $(this).data("column");
            var value = $(this).text();
            update_data(id, column_name, value);
        });

        $('#add').click(function() {
            var html = '<tr>';
            html += '<td contenteditable id="data1"></td>';
            html += '<td contenteditable id="data2"></td>';
            html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
            html += '</tr>';
            $('#user_data tbody').prepend(html);
        });


        $(document).on('click', '.deletes', function() {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?")) {
                $.ajax({
                    url: "dep_delete.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                        $('#user_data').DataTable().destroy();
                        fetch_data();
                    }
                });
                setInterval(function() {
                    $('#alert_message').html('');
                }, 5000);
            }
        });
    });
</script>
<?php include '../includes/footer.php'; ?>


</html>