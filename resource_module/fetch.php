<?php
//fetch.php
require '../includes/conn.php';

if (isset($_GET['s']) and $_GET['s'] == 'departments') {

    $columns = array('id', 'name', 'faculty');
    $query = "SELECT d.id, d.name, f.name as fname, f.id as fid FROM departments as d INNER JOIN faculties as f ON d.faculty=f.id ";

    if (isset($_POST["search"]["value"])) {
        $query .= 'WHERE d.id LIKE "%' . $_POST["search"]["value"] . '%" OR d.name LIKE "%' . $_POST["search"]["value"] . '%" OR f.name LIKE "%' . $_POST["search"]["value"] . '%"';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY d.' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'];
    } else {
        $query .= 'ORDER BY d.id DESC';
    }

    $query1 = '';
    if ($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));
    $result = mysqli_query($conn, $query . $query1);

    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $sub_array = array();
        $sub_array[] = '<div class="text-center" class="update" data-id="' . $row["id"] . '" data-column="id">' . $row["id"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="name">' . $row["name"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="faculty">' . $row["fname"] . '</div>';
        $sub_array[] = '<div class="text-center"><button type="button" class="btn btn-primary btn-xs data-edit" data-fid="' . $row['fid'] . '" data-name="' . $row['name'] . '" id="' . $row["id"] . '">Edit</button>
                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Delete</button> </div>';
        $data[] = $sub_array;
    }

    function get_all_data($conn)
    {
        $query = "SELECT * FROM departments";
        $result = mysqli_query($conn, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" =>  get_all_data($conn),
        "recordsFiltered" => $number_filter_row,
        "data" => $data,
        'Query' => $query . $query1
    );

    echo json_encode($output);
}

if (isset($_GET['s']) and $_GET['s'] == 'faculties') {
    $columns = array('id', 'name');
    $query = "SELECT * FROM faculties ";

    if (isset($_POST["search"]["value"])) {
        $query .= 'WHERE id LIKE "%' . $_POST["search"]["value"] . '%" OR name LIKE "%' . $_POST["search"]["value"] . '%"';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'];
    } else {
        $query .= 'ORDER BY id DESC';
    }

    $query1 = '';
    if ($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));
    $result = mysqli_query($conn, $query . $query1);

    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $sub_array = array();
        $sub_array[] = '<div class="text-center" data-id="' . $row["id"] . '" data-column="id">' . $row["id"] . '</div>';
        $sub_array[] = '<div data-id="' . $row["id"] . '" data-column="name">' . $row["name"] . '</div>';
        $sub_array[] = '<div class="text-center"><button type="button" class="btn btn-primary btn-xs data-edit" data-name="' . $row["name"] . '"  id="' . $row["id"] . '">Edit</button>
                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Delete</button> </div>';
        $data[] = $sub_array;
    }

    function get_all_data($conn)
    {
        $query = "SELECT * FROM faculties";
        $result = mysqli_query($conn, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" =>  get_all_data($conn),
        "recordsFiltered" => $number_filter_row,
        "data" => $data,
        'Query' => $query . $query1
    );

    echo json_encode($output);
}
