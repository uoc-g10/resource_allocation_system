<?php
require '../includes/conn.php';

$query2 = "SELECT d.id, d.name, f.id as fid FROM departments as d INNER JOIN faculties as f ON d.faculty=f.id";
$result_1 = mysqli_query($conn, $query2);
$departments = [];
while ($department = mysqli_fetch_array($result_1)) {
    $departments[$department['fid']][] =  array('id' => $department['id'], 'name' => $department['name']);
}

$query = "SELECT id,name FROM faculties ";
$result_2 = mysqli_query($conn, $query);
$faculties = [];
while ($faculty = mysqli_fetch_array($result_2)) {
    $faculties[] = array('id' => $faculty['id'], 'name' => $faculty['name']);
}

?>

<?php include '../common/header.php'; ?>
<style>
    .box {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 25px;
        box-sizing: border-box;
    }
</style>

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="table-responsive">
                                <br />
                                <div id="alert_message"></div>
                                <table id="user_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="50px" class="text-center">Id</th>
                                            <th>Resource Name</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                            <th>Faculty</th>
                                            <th>Department</th>
                                            <th>Category</th>
                                            <th></th>
                                        </tr>
                                    </thead>
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
                    <form class="form-horizontal" method="POST" id="resourceFrm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Resource Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" Placeholder="Resource Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="col-sm-3 control-label">Location</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="location" name="location" Placeholder="Location">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-3 control-label">Type</label>

                                <div class="col-sm-9">
                                    <select class="form-control" name="type">
                                        <option value="Main"> Main </option>
                                        <option value="Sub"> Sub </option>
                                        <option value="others"> etc :) </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="faculty" class="col-sm-3 control-label">Faculty</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="faculty" name="faculty">
                                        <?php foreach ($faculties as $faculty) {
                                            echo "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . " </option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="department" class="col-sm-3 control-label">Department</label>

                                <div class="col-sm-9">
                                    <select class="form-control" id="department" name="department">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="catogory" class="col-sm-3 control-label">Catogory</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="catogory" name="catogory">
                                        <option value="Lecture Hall"> Lecture Hall </option>
                                        <option value="Auditorium"> Auditorium </option>
                                        <option value="Laboratory"> Laboratory </option>
                                        <option value="Playground"> Playground </option>
                                        <option value="Others"> Other </option>
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

                var array = <?php echo json_encode($departments); ?>

                console.log(array);

                var dataTable = $('#user_data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "res_fetch.php",
                        type: "POST"
                    }
                });

                // Create Form
                $("#resourceFrm").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'resource_create.php',
                        data: $('#resourceFrm').serialize(),
                        success: function(response) {
                            document.getElementById('resourceFrm').reset();
                            $("#addResource").modal('hide');
                            dataTable.ajax.reload();
                            showMessage('success', 'New Faculty has been created successfully')
                        }
                    });
                });

                $("#faculty").on('change', function() {
                    var fid = $(this).val();
                    updateFaculties(fid);
                });

                updateFaculties($("#faculty").val());

                function updateFaculties(fid) {
                    $('#department option').remove();
                    for (i = 0; i < array[fid].length; i++) {
                        var id = array[fid][i]['id'];
                        var name = array[fid][i]['name'];

                        var option = $('<option>');
                        option.attr('value', id);
                        option.append(name);
                        $('#department').append(option);
                    }
                }

                function showMessage(type, description) {
                    Swal.fire({
                        icon: type,
                        title: description,
                        showConfirmButton: false,
                        timer: 1200
                    })
                }


                function update_data(id, column_name, value) {
                    $.ajax({
                        url: "res_update.php",
                        method: "POST",
                        data: {
                            id: id,
                            column_name: column_name,
                            value: value
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


                $(document).on('click', '.delete', function() {
                    var id = $(this).attr("id");
                    if (confirm("Are you sure you want to remove this?")) {
                        $.ajax({
                            url: "res_delete.php",
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
    </div>
</body>

</html>