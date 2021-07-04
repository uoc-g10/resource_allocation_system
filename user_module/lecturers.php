<?php
require '../includes/conn.php';

$query = "SELECT id,name FROM faculties ";
$result_2 = mysqli_query($conn, $query);
$faculties = [];
while ($faculty = mysqli_fetch_array($result_2)) {
    $faculties[] = array('id' => $faculty['id'], 'name' => $faculty['name']);
}

$query2 = "SELECT d.id, d.name, f.id as fid FROM departments as d INNER JOIN faculties as f ON d.faculty=f.id";
$result_1 = mysqli_query($conn, $query2);
$departments = [];
while ($department = mysqli_fetch_array($result_1)) {
    $departments[$department['fid']][] =  array('id' => $department['id'], 'name' => $department['name']);
}

$query3 = "SELECT id,title,firstname,secondname,email,password,mobile,role,department,last_login,status FROM users";
$result_3 = mysqli_query($conn, $query3);
?>
<?php include '../common/header.php'; ?>

<style>
    table tr th {
        text-align: center;
    }
</style>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="col-xs-12">
                <h1> Lecturers </h1>

                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </div>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <div class="box">

                            <div class="box-header with-border">
                                <div class="col-xs-12">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <a href="#addnew" data-toggle="modal" data-target="#addUser" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> Add New Lecturer</a>
                                                </div>
                                            </div>

                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input type="search" class="form-control" id="customSearch">
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
                                <div class="col-md-12">
                                    <br>
                                </div>
                                <div class="box-body">
                                    <table id="user_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Lecturer Name</th>
                                                <th>Login Email Address</th>
                                                <th>Department</th>
                                                <th>User Last Login</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
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

                <form class="form-horizontal" method="POST" id="lecturerCreateFrm" enctype="multipart/form-data">
                    <input type="hidden" name="create_lecturer" value="1">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <select name="title" class="form-control" id="title" required>
                                    <option value="Mr."> Mr. </option>
                                    <option value="Mr."> Mrs. </option>
                                    <option value="Mr."> Miss. </option>
                                    <option value="Mr."> Dr. </option>
                                    <option value="Mr."> Rev. </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="secondname" class="col-sm-3 control-label">Second Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="secondname" name="secondname" placeholder="Second Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-sm-3 control-label">Mobile Number</label>

                            <div class="col-sm-9">
                                <input type="tel" class="form-control" maxlength="10" id="mobile" name="mobile" placeholder="Lecturer Mobile Number (Optional)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department" class="col-sm-3 control-label">Faculty</label>

                            <div class="col-sm-9">
                                <select class="form-control" id="faculty" name="faculty" required>
                                    <?php foreach ($faculties as $faculty) {
                                        echo "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . " </option>";
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department" class="col-sm-3 control-label">Department</label>

                            <div class="col-sm-9">
                                <select class="form-control" id="department" name="department" required>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email Address</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">

                            </label>
                            <div class="col-sm-9">
                                <div class="d-flex">
                                    <i class="fa fa-info-circle mail-to-i"></i>
                                    The system username and password details will be sent by e-mail to this e-mail address.
                                </div>
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

    <!-- Edit User -->
    <div class="modal fade" id="editUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Edit User Details</b></h4>
                </div>
                <form class="form-horizontal" method="POST" id="editUserFrm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <select name="title" class="form-control" id="title_edit" required>
                                    <option value="Mr."> Mr. </option>
                                    <option value="Mr."> Mrs. </option>
                                    <option value="Mr."> Miss. </option>
                                    <option value="Mr."> Dr. </option>
                                    <option value="Mr."> Rev. </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstname_edit" class="col-sm-3 control-label">First Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstname_edit" name="firstname" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="secondname_edit" class="col-sm-3 control-label">Second Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="secondname_edit" name="secondname" placeholder="Second Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile_edit" class="col-sm-3 control-label">Mobile Number</label>

                            <div class="col-sm-9">
                                <input type="tel" class="form-control" maxlength="10" id="mobile_edit" name="mobile" placeholder="Lecturer Mobile Number (Optional)" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="faculty_edit" class="col-sm-3 control-label">Faculty</label>

                            <div class="col-sm-9">
                                <select class="form-control" id="faculty_edit" name="faculty" required>
                                    <?php foreach ($faculties as $faculty) {
                                        echo "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . " </option>";
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department_edit" class="col-sm-3 control-label">Department</label>

                            <div class="col-sm-9">
                                <select class="form-control" id="department_edit" name="department" required>
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
<script>
    // json array of faculties and departments
    var array = <?php echo json_encode($departments); ?>

    console.log(array);

    // Init Users Datatable
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "dom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "lecturers_fetch.php",
            type: "POST",
            data: {
                "load_table": 1
            }
        },
        oLanguage: {
            sLengthMenu: "_MENU_",
        }
    });

    // Search DataTable on Custom Input Field
    $('#customSearch').keyup(function() {
        dataTable.search($(this).val()).draw();
    })

    // Edit User Details
    $(document).on('click', '.edit-user', function() {
        var uid = $(this).attr('user-id');
        $.post('users_fetch.php', {
            user_edit: 1,
            user_id: uid
        }, function(data) {
            var userData = JSON.parse(data);
            console.log(userData.firstname);
            $('#title_edit').val(userData.title);
            $('#firstname_edit').val(userData.firstname);
            $('#secondname_edit').val(userData.secondname);
            $('#mobile_edit').val(userData.mobile);
            $('#role_edit').val(userData.role);
            $('#department_edit').val(userData.department);
            $('#email_edit').val(userData.email);
            $("#editUserModal").modal('show');
            updateFaculties(fid);
        });
    });

    // $(document).on('click', '.edit-user', function() {
    //     var uid = $(this).attr('user-id');
    //     $.post('users_fetch.php', {
    //         user_edit: 1,
    //         user_id: uid
    //     }, function(data) {

    //     });
    // });

    // Change departments when faculty change
    $("#faculty, #faculty_edit").on('change', function() {
        var fid = $(this).val();
        updateFaculties(fid);
    });

    // On first Time update departments
    updateFaculties($("#faculty").val());

    // Change departments Function
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

    $("#lecturerCreateFrm").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'lecturers_fetch.php',
            data: $('#lecturerCreateFrm').serialize(),
            success: function(response) {
                if (response == 1) {
                    document.getElementById('lecturerCreateFrm').reset();
                    $("#addUser").modal('hide');
                    //dataTable.ajax.reload();
                    // showMessage('success', 'New User has been created successfully')
                } else {
                    var responseArray = JSON.parse(response);
                    console.log(responseArray);
                    $('#' + responseArray[0]['id']).addClass('border-red');
                    $('#' + responseArray[0]['id']).parent().append("<span class='color-red'>" + responseArray[0]['msg'] + '</span>');
                }
                // document.getElementById('lecturerCreateFrm').reset();
                // $("#addUser").modal('hide');
                // dataTable.ajax.reload();
                // showMessage('success', 'New User has been created successfully')
            }
        });
    });

    // Remove error classes when updating fields
    $('input').on('input', function() {
        $(this).removeClass('border-red');
        $(this).parent().find('span').remove();
    });

    // Show any message
    function showMessage(type, description) {
        Swal.fire({
            icon: type,
            title: description,
            showConfirmButton: false,
            timer: 1200
        })
    }
</script>

</html>