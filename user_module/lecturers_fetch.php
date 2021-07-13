<?php

//fetch.php

require '../includes/conn.php';
require '../includes/sendEmails.php';


// Create New Lecturer
if (isset($_POST['create_lecturer']) and $_POST['create_lecturer']) {
    $errors = [];
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $password_raw = randomPassword(8);
    $password = password_hash($password_raw, PASSWORD_DEFAULT);
    $role = 'ROLE_LECTURER';

    $lecturerFullName = $title . ' ' . $firstname . ' ' . $secondname;
    $systemUrl = $_SERVER['HTTP_ORIGIN'];
    $registerImage = $_SERVER['HTTP_ORIGIN'].'/public/images/user-registerd.png';

    $checkUserQuery = "SELECT count(id) as cc FROM users WHERE email='$email' LIMIT 1";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);
    $checkUser = mysqli_fetch_assoc($checkUserResult);

    if ($checkUserResult == true and $checkUser and $checkUser['cc']) {
        $errors[] = ['id' => 'email', 'msg' => 'This e-mail address is already registered!'];
        echo json_encode($errors);
        exit();
    }

    if (!$mobile) {
        $mobile = '-';
    }

    $sql = "INSERT INTO users (title,firstname,secondname,email,password,mobile,role,faculty_id,department,last_login,status) 
    VALUES('$title', '$firstname','$secondname','$email','$password','$mobile','$role',$faculty,$department,null,1)";

    if ($conn->query($sql) == TRUE) {
        $status = 1;
        $emailBody = include 'register_email.php';
        sendRegistationEmail($email, $emailBody);
    } else {
        echo "Error" . $sql . $conn->error;
    }

    $conn->close();

    echo 1;
    exit();
}

if (isset($_POST['edit_lecturer_details']) and $_POST['edit_lecturer_id']) {
    $userId = $_POST['edit_lecturer_id'];
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $mobile = $_POST['mobile'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $status = 0;

    $query = "UPDATE users SET title ='" . $title . "', firstname ='" . $firstname . "',secondname='" . $secondname . "',mobile='" . $mobile . "',faculty_id='" . $faculty . "',department='" . $department . "'  WHERE id = '" . $userId . "'";
    if (mysqli_query($conn, $query)) {
        $status = 1;
    }

    print_r($status);
    exit();
}


function randomPassword($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($data), 0, $chars);
}

//Edit users data

if (isset($_POST['user_edit']) and $_POST['user_id']) {
    $uid = $_POST['user_id'];
    $editQuery = "SELECT id,title,firstname,secondname,email,mobile,role,faculty_id,department,status FROM users WHERE id=$uid LIMIT 1";
    $result = mysqli_query($conn, $editQuery);
    $userData = [];
    while ($row = mysqli_fetch_array($result)) {
        echo (json_encode($row));
    }
    exit();
}

// Remove Lecturer

if (isset($_POST['lecturerRemove']) and $_POST['lecturerRemove']) {
    $uid = $_POST['id'];
    $query1 = "DELETE FROM user_resource_map WHERE user_id=$uid";
    if (mysqli_query($conn, $query1)) {
        $status = 1;
    }
    $query2 = "DELETE FROM users WHERE id=$uid";
    if (mysqli_query($conn, $query2)) {
        $status = 1;
    }

    echo $status;
    exit();
}

//Load Table Data By AJAX

if (isset($_POST['load_table']) and $_POST['load_table']) {

    $columns = array('id', 'title', 'firstname', 'secondname', 'email', 'mobile', 'department', 'last_login', 'status');
    $query = "SELECT u.*,d.name as did FROM users as u INNER JOIN departments as d ON d.id = u.department WHERE role='ROLE_LECTURER' ";

    if (isset($_POST["search"]["value"])) {
        $query .= ' AND (u.id LIKE "%' . $_POST["search"]["value"] . '%" OR u.firstname LIKE "%' . $_POST["search"]["value"] . '%" OR u.secondname LIKE "%' . $_POST["search"]["value"] . '%") ';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY u.' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $query .= 'ORDER BY u.id ASC ';
    }

    $query1 = '';

    if ($_POST["length"] != -1) {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));
    $result = mysqli_query($conn, $query . $query1);
   
    $data = [];
    $loopIndex = 1;
    while ($row = mysqli_fetch_array($result)) {

        $last_login = '-';
        if ($row["last_login"]) {
            $last_login = date('Y-m-d h:i:s A', strtotime($row["last_login"]));
        }

        $sub_array = array();
        $sub_array[] = '<div class=" text-center" data-column="id">' . $loopIndex . '</div>';
        $sub_array[] = '<div class=" text-left" data-column="title">' . $row["title"] . ' ' . $row['firstname'] . ' ' . $row['secondname'] . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="email">' . $row["email"] . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="department">' . $row["did"] . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="last_login">' . $last_login . '</div>';

        $sub_array[] = "<div class='text-right'> <button class='btn btn-default btn-sm btn-flat lecture-report' user-id='" . $row["id"] . "'><i class='fa fa-bar-chart'></i> Report</button>
                    <button class='btn btn-default btn-sm btn-flat edit-user' user-id='" . $row["id"] . "'><i class='fa fa-edit'></i> Edit</button>
                    <button class='btn btn-danger btn-sm btn-flat delete-user' user-id='" . $row["id"] . "'><i class='fa fa-trash'></i> Delete</button></div>";

        $data[] = $sub_array;
        $loopIndex++;
    }

    function get_all_data($conn)
    {
        $query = "SELECT * FROM users WHERE role = 'ROLE_LECTURER'";
        $result = mysqli_query($conn, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
        "draw"    => intval($_POST["draw"]),
        "recordsTotal"  =>  get_all_data($conn),
        "recordsFiltered" => $number_filter_row,
        "data"    => $data,
        "query"    => $query . $query1,
    );

    echo json_encode($output);
    exit();
}
