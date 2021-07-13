<?php
//fetch.php
require '../includes/conn.php';

$columns = array('id', 'name', 'location', 'type', 'faculty', 'department', 'category');

$query = "SELECT * FROM resources";
$query = "SELECT r.id, r.name, r.location, r.type, r.category, f.name as fname, f.id as fid, d.name as dname, d.id as did FROM resources as r INNER JOIN faculties as f ON r.faculty=f.id INNER JOIN departments as d ON r.department=d.id ";

if (isset($_POST["search"]["value"])) {
    $query .= ' WHERE r.id LIKE "%' . $_POST["search"]["value"] . '%" OR r.name LIKE "%' . $_POST["search"]["value"] . '%" OR f.name LIKE "%' . $_POST["search"]["value"] . '%" OR d.name LIKE "%' . $_POST["search"]["value"] . '%" OR r.category LIKE "%' . $_POST["search"]["value"] . '%"';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY r.' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY r.id ASC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $sub_array = array();
    $sub_array[] = '<div class="update text-center" data-id="' . $row["id"] . '" data-column="id">' . $row["id"] . '</div>';
    $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="name">' . $row["name"] . '</div>';
    $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="location">' . $row["location"] . '</div>';
    // $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="type">' . $row["type"] . '</div>';
    $sub_array[] = '<div class="update" data-fid="' . $row["fid"] . '" data-id="' . $row["id"] . '" data-column="faculty">' . $row["fname"] . '</div>';
    $sub_array[] = '<div class="update" data-did="' . $row["did"] . '" data-id="' . $row["id"] . '" data-column="department">' . $row["dname"] . '</div>';
    $sub_array[] = '<div class="update" data-cat="' . $row["category"] . '" data-id="' . $row["id"] . '" data-column="category">' . $row["category"] . '</div>';
    $sub_array[] = '<div class="text-right"><button type="button" name="edit" class="btn btn-primary btn-xs edit-resource" id="' . $row["id"] . '">Edit</button> <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Delete</button> </div>';
    $data[] = $sub_array;
}

function get_all_data($conn)
{
    $query = "SELECT * FROM resources";
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
