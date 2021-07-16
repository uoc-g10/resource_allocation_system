<?php

//fetch.php

require '../includes/conn.php';
require '../includes/sendEmails.php';


//Load Table Data By AJAX

if (isset($_POST['load_table']) and $_POST['load_table']) {

    $lecturer = '';
    $startDate = '';
    $endDate = '';
    $days = [];
    $resource = '';
    $resStatus = 0;

    if (isset($_COOKIE['lecturer_report_lecturer'])) {
        $lecturer = $_COOKIE['lecturer_report_lecturer'];
    }

    if (isset($_COOKIE['lecturer_report_resource'])) {
        $resource = $_COOKIE['lecturer_report_resource'];
    }

    if (isset($_COOKIE['lecturer_report_reservation_status'])) {
        $resStatus = $_COOKIE['lecturer_report_reservation_status'];
    }

    if (isset($_COOKIE['lecturer_report_start']) and isset($_COOKIE['lecturer_report_end'])) {
        $startDate = date("Y-m-d", strtotime($_COOKIE['lecturer_report_start']));
        $endDate = date("Y-m-d", strtotime($_COOKIE['lecturer_report_end']));

        $days = createDateRangeArray($startDate, $endDate);
    }

    $columns = array('id', 'title', 'firstName', 'resource_id', 'start_time', 'end_time');
    $query = "SELECT usm.*,resources.name as r_name, users.title as u_title, users.firstName, users.secondName FROM user_resource_map as usm INNER JOIN users ON users.id = usm.user_id INNER JOIN resources ON resources.id = usm.resource_id WHERE users.role = 'ROLE_LECTURER' ";

    if ($lecturer) {
        $query .= " AND (usm.user_id=$lecturer) ";
    }

    if ($resource) {
        $query .= " AND (usm.resource_id=$resource) ";
    }

    if ($days) {
        $query .= " AND (";
    }

    foreach ($days as $key => $d) {
        if ($key != 0) {
            $query .= " OR ";
        }
        $query .= " usm.start_time LIKE '%$d%'";
    }

    if ($days) {
        $query .= ")";
    }

    // print_r($query);
    // exit();

    // if ($startDate) {
    //     $query .= " AND start_time=$startDate ";
    // }

    // if (isset($_POST["search"]["value"])) {
    //     $query .= ' AND (users.id LIKE "%' . $_POST["search"]["value"] . '%" OR users.firstname LIKE "%' . $_POST["search"]["value"] . '%" OR users.secondname LIKE "%' . $_POST["search"]["value"] . '%") ';
    // }

    if (isset($_POST["order"])) {

        if ($columns[$_POST['order']['0']['column']] == 'title') {
            $query .= 'ORDER BY users.firstName '  . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY usm.' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        }
    } else {
        $query .= 'ORDER BY usm.id DESC ';
    }

    $query1 = '';

    if ($_POST["length"] != -1) {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));
    $result = mysqli_query($conn, $query . $query1);

    // print_r($query);
    // exit();

    $data = [];
    $loopIndex = 1;
    while ($row = mysqli_fetch_array($result)) {

        $last_login = '-';
        if ($row["last_login"]) {
            $last_login = date('Y-m-d h:i:s A', strtotime($row["last_login"]));
        }

        $sub_array = array();
        $sub_array[] = '<div class=" text-center" data-column="id">' . $loopIndex . '</div>';
        $sub_array[] = '<div class=" text-left" data-column="firstName">' . $row["u_title"] . ' ' . $row['firstName'] . ' ' . $row['secondName'] . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="resource_id">' . $row["r_name"] . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="start_time">' . date('Y-m-d', strtotime($row["start_time"])) . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="start_time">' . date('h:i A', strtotime($row["start_time"])) . ' - ' . date('h:i A', strtotime($row["end_time"])) . '</div>';
        $sub_array[] = '<div class=" text-center" data-column="start_time">' . get_date_diff(date('Y-m-d h:i A', strtotime($row["start_time"])), date('Y-m-d h:i A', strtotime($row["end_time"]))) . '</div>';

        $sub_array[] = "<div class='text-center' data-column='start_time'> " . reservationStatusCheck(date('Y-m-d', strtotime($row["start_time"]))) . "</div>";

        if ($resStatus) {
            if (reservationStatusCheck(date('Y-m-d', strtotime($row["start_time"])), 1) == $resStatus) {
                $data[] = $sub_array;
            }
        } else {
            $data[] = $sub_array;
        }

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
        //"query"    => $query . $query1,
    );

    echo json_encode($output);
    exit();
}

function reservationStatusCheck($date, $type = 0)
{
    $date_now = date("Y-m-d");
    $text = '';

    if ($date_now > $date) {
        $text = $type ? 1 : 'Past';
    } else {
        $text =  $type ? 2 : 'Upcomming';
    }

    return $text;
}

function get_date_diff($time1, $time2, $precision = 2)
{
    // If not numeric then convert timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }

    // If time1 > time2 then swap the 2 values
    if ($time1 > $time2) {
        list($time1, $time2) = array($time2, $time1);
    }

    // Set up intervals and diffs arrays
    $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
    $diffs = array();

    foreach ($intervals as $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }

        $time1 = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$interval] = $looped;
    }

    $count = 0;
    $times = array();
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval if value is bigger than 0
        if ($value > 0) {
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }

    // Return string with times
    return implode(", ", $times);
}


// Get dates in Date Range

function createDateRangeArray($strDateFrom, $strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = [];

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }

    return $aryRange;
}
