<?php
//fetch.php
require '../includes/conn.php';

//Edit users data
if (isset($_POST['user_edit']) and $_POST['user_id']) {
    $uid = $_POST['user_id'];
    $editQuery = "SELECT id,title,firstname,secondname,email,mobile,role,department,status FROM users WHERE id=$uid LIMIT 1";
    $result = mysqli_query($conn, $editQuery);
    $userData = [];
    while ($row = mysqli_fetch_array($result)) {
        echo (json_encode($row));
    }
    exit();
}

$columns = array('id', 'title', 'firstname', 'secondname', 'email', 'mobile', 'department', 'last_login', 'status');

//$query = "SELECT * FROM resources";
$query = "SELECT * FROM users WHERE (role!='ROLE_LECTURER') ";

if (isset($_POST["search"]["value"])) {
    $query .= ' AND (id LIKE "%' . $_POST["search"]["value"] . '%" OR firstname LIKE "%' . $_POST["search"]["value"] . '%" OR secondname LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY id ASC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);



$data = array();
$loopIndex = 1;
while ($row = mysqli_fetch_array($result)) {

    $sub_array = array();
    $sub_array[] = '<div class=" text-center" data-column="id">' . $loopIndex . '</div>';
    $sub_array[] = '<div class=" text-left" data-column="title">' . $row["title"] . ' ' . $row['firstname'] . ' ' . $row['secondname'] . '</div>';
    $sub_array[] = '<div class=" text-center" data-column="email">' . $row["email"] . '</div>';
    $sub_array[] = '<div class=" text-center" data-column="role">' . $row["role"] . '</div>';
    $sub_array[] = '<div class=" text-center" data-column="last_login">' . $row["last_login"] . '</div>';

    $sub_array[] = "<div class='text-right'> 
                    <button class='btn btn-default btn-sm btn-flat edit-user' user-id='" . $row["id"] . "'><i class='fa fa-edit'></i> Edit</button>
                    <button class='btn btn-danger btn-sm btn-flat delete-user' user-id='" . $row["id"] . "'><i class='fa fa-trash'></i> Delete</button></div>";

    $data[] = $sub_array;
    $loopIndex++;
}

function get_all_data($conn)
{
    $query = "SELECT * FROM users WHERE role='ROLE_ADMIN'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($conn),
    "recordsFiltered" => $number_filter_row,
    "data" => $data,
    "query" => $query . $query1,
);

echo json_encode($output);
