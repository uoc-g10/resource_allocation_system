<?php

require '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Method Not Allowed';
    exit();
}

$RESOURCE = 0;
$RESOURCE_CATEGORY = 0;

if (isset($_COOKIE['schedule_table_resource']) and $_COOKIE['schedule_table_resource']) {
    $RESOURCE = $_COOKIE['schedule_table_resource'];
}

if (isset($_COOKIE['schedule_table_resource_category']) and $_COOKIE['schedule_table_resource_category']) {
    $RESOURCE_CATEGORY = $_COOKIE['schedule_table_resource_category'];
}

// Load Table Data
if (isset($_POST['loadSchedule'])) {

    $Data = [];
    //$days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $DateNames = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    $START_DATE = date("Y-m-d", strtotime('today'));
    $END_DATE = date("Y-m-d", strtotime("+7 day", strtotime($START_DATE)));

    if (isset($_SESSION['selectedStart']) and $_SESSION['selectedEnd']) {
        $START_DATE = date("Y-m-d", strtotime($_SESSION['selectedStart']));
        $END_DATE = date("Y-m-d", strtotime($_SESSION['selectedEnd']));
    }

    $days = createDateRangeArray($START_DATE, $END_DATE);

    foreach ($days as $key => $day) {
        $reservations = [];
        $date = date("M - d", strtotime($day));
        $dateRaw = date("Y-M-d", strtotime($day));
        $qDate = date("Y-m-d", strtotime($day));
        $DateName = date("l", strtotime($day));

        $query2 = "SELECT urm.*, usr.id as user_id, usr.firstname, usr.title as utitle, usr.secondname, usr.image_path, usr.color FROM user_resource_map as urm INNER JOIN users as usr ON urm.user_id = usr.id WHERE start_time LIKE '$qDate%' ";

        if ($RESOURCE) {
            $query2 = $query2 . " AND urm.resource_id= $RESOURCE";
        }

        $result2 = mysqli_query($conn, $query2);
        while ($ress = mysqli_fetch_array($result2)) {
            $startDate = date("H:i", strtotime($ress['start_time']));
            $endDate = date("H:i", strtotime($ress['end_time']));

            $lecturerImage = '../images/profile.jpg';
            if ($ress['image_path']) {
                $lecturerImage = '../' . $ress['image_path'];
            }

            $act = 0;
            if ($ress['user_id'] == $User['id'] or $User['role'] == 'ROLE_ADMIN' or $User['role'] == 'ROLE_MANAGE_USER') {
                $act = 1;
            }

            $reservations[] = [
                "start" => $startDate,
                "end" => $endDate,
                "text" => $ress['title'],
                "data" => array(
                    "id" => $ress['id'],
                    "actions" => $act,
                    "class" => "example2",
                    "color" => str_replace('#', '_', $ress['color']),
                    "description" => $ress['description'],
                    "headding" => $ress['title'],
                    "lecturer" => $ress['utitle'] . ' ' . $ress['firstname'] . ' ' . $ress['secondname'],
                    "image" => $lecturerImage,
                    "dateRange" =>  date("h:i A", strtotime($ress['start_time'])) . ' - ' .  date("h:i A", strtotime($ress['end_time'])),
                    "date" =>  date("Y-m-d", strtotime($day)),
                )
            ];
        }

        $Data[$key]['title'] = $date;
        $Data[$key]['subtitle'] = "<input type='hidden' class='raw_date' value='$dateRaw'> $DateName <br><button class='btn btn-success btn-sm add-reservation'> <i class='fa fa-edit'></i> Make Reservation</button>";
        $Data[$key]['schedule'] = $reservations;
    }

    $disabled = json_encode($disableTimes);
    $Data['remove'] = 1;
    $Data['start'] = date("d/m/Y", strtotime($START_DATE));
    $Data['end'] = date("d/m/Y", strtotime($END_DATE));
    echo json_encode($Data);
    exit();
}

// Set time range SESSION
if (isset($_POST['dateRengeSessonSet'])) {
    if (isset($_POST['selectedStart']) and $_POST['selectedEnd']) {
        $_SESSION['selectedStart'] = $_POST['selectedStart'];
        $_SESSION['selectedEnd'] = $_POST['selectedEnd'];
    }

    echo 1;
    exit();
}

// Reservation Modal Deta
if (isset($_POST['addReservationModal'])) {
    $resource_id = $_POST['resource_id'];
    $resDay = $_POST['resDay'];

    $selectedDate = date("Y-m-d", strtotime($resDay));

    //$days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $TmpArray = [];
    $disableTimesTmpA = [];
    $disableTimesTmpB = [];

    //foreach ($days as $key => $day) {

    $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' ";

    if ($RESOURCE) {
        $query2 = $query2 . " AND urm.resource_id= $RESOURCE ";
    }

    $query2 = $query2 . " ORDER BY start_time";

    $result2 = mysqli_query($conn, $query2);
    $loop = 1;
    while ($ress = mysqli_fetch_array($result2)) {
        $startDate = date("H:i", strtotime($ress['start_time']));
        $endDate = date("H:i", strtotime($ress['end_time']));

        $TmpArray[$loop] = [
            "from" => [
                (int) date("H", strtotime($ress['start_time'])),
                (int) date("i", strtotime($ress['start_time'])),
            ],
            "to" => [
                (int) date("H", strtotime($ress['end_time'])),
                (int) date("i", strtotime($ress['end_time'])),
            ]
        ];
        $loop++;
    }
    //}

    foreach ($TmpArray as $time) {
        $disableTimesTmpA[] = $time;
    }

    if ($TmpArray) {
        $TmpArray[] = [
            "from" => [$TmpArray[1]['from'][0], 3],
            "to" => $TmpArray[1]['from']
        ];
    }

    foreach ($TmpArray as $time) {
        $disableTimesTmpB[] = $time;
    }

    $disableTimesStart = json_encode($disableTimesTmpB);
    include 'reservation_modal.php';
    exit();
}


// Reservation Edit Modal Data
if (isset($_POST['editReservationModal'])) {
    $scheduleId = $_POST['scheduleId'];
    $resDay = $_POST['resDay'];

    $scheduleQuery = "SELECT * FROM user_resource_map WHERE id=$scheduleId LIMIT 1";
    $scheduleQueryResult = mysqli_query($conn, $scheduleQuery);
    $UserSchedule = mysqli_fetch_array($scheduleQueryResult);

    $selectedDate = date("Y-m-d", strtotime($resDay));
    $selectedStartMinites = hourMinute2Minutes(date("H:i", strtotime($UserSchedule['start_time'])));

    //$days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $TmpArray = [];
    $disableTimesTmpA = [];
    $disableTimesTmpB = [];

    //foreach ($days as $key => $day) {

    $query2 = "SELECT urm.*, usr.firstname, usr.secondname, urm.user_id FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' AND urm.id != $scheduleId ";

    if ($RESOURCE) {
        $query2 = $query2 . " AND urm.resource_id= $RESOURCE ";
    }

    $query2 = $query2 . " ORDER BY start_time";

    $result2 = mysqli_query($conn, $query2);
    $loop = 1;
    while ($ress = mysqli_fetch_array($result2)) {
        $startDate = date("H:i", strtotime($ress['start_time']));
        $endDate = date("H:i", strtotime($ress['end_time']));

        $TmpArray[$loop] = [
            "from" => [
                (int) date("H", strtotime($ress['start_time'])),
                (int) date("i", strtotime($ress['start_time'])),
            ],
            "to" => [
                (int) date("H", strtotime($ress['end_time'])),
                (int) date("i", strtotime($ress['end_time'])),
            ]
        ];
        $loop++;
    }
    //}

    foreach ($TmpArray as $time) {
        $disableTimesTmpA[] = $time;
    }

    if ($TmpArray) {
        $TmpArray[] = [
            "from" => [$TmpArray[1]['from'][0], 3],
            "to" => $TmpArray[1]['from']
        ];
    }

    foreach ($TmpArray as $time) {
        $disableTimesTmpB[] = $time;
    }

    $disableTimesStart = json_encode($disableTimesTmpB);
    include 'reservation_edit_modal.php';
    exit();
}

// Edit Reservation 

if (isset($_POST['edit_reservation'])) {
}

// Generate End Time 
if (isset($_POST['getEndTime'])) {
    $inputTime = $_POST['inputTime'];
    $resDay = $_POST['resDay'];
    $scheduleId = 0;
    $UserSchedule = 0;
    $selectedEndMinites = 0;

    if (isset($_POST['scheduleId'])) {
        $scheduleId = $_POST['scheduleId'];
        $scheduleQuery = "SELECT * FROM user_resource_map WHERE id=$scheduleId LIMIT 1";
        $scheduleQueryResult = mysqli_query($conn, $scheduleQuery);
        $UserSchedule = mysqli_fetch_array($scheduleQueryResult);
    }

    //$days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $selectedDate = date("Y-m-d", strtotime($resDay));
    $selectedDateH = date("H", strtotime($inputTime));
    $selectedDateI = date("i", strtotime($inputTime));
    $selectedTimeHI = date("H:i", strtotime($inputTime));
    $selectedMinites = hourMinute2Minutes($selectedTimeHI);

    if ($scheduleId) {
        $selectedEndMinites = hourMinute2Minutes(date("H:i", strtotime($UserSchedule['end_time'])));
    }

    $disableTimesTmpA = [];

    if ($selectedDateI == 00) {
        $startArray = [
            (int)$selectedDateH,
            30
        ];
    } else {
        $startArray = [
            (int)$selectedDateH + 1,
            (int)$selectedDateI - 30
        ];
    }

    //foreach ($days as $key => $day) {

    $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' ";
    if ($scheduleId) {
        $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' AND urm.id!=$scheduleId ";
    }

    if ($RESOURCE) {
        $query2 = $query2 . " AND urm.resource_id= $RESOURCE ";
    }

    $query2 = $query2 . " ORDER BY start_time";

    $result2 = mysqli_query($conn, $query2);
    $loop = 1;
    while ($ress = mysqli_fetch_array($result2)) {
        $startDate = date("H:i", strtotime($ress['start_time']));
        $endDate = date("H:i", strtotime($ress['end_time']));

        $TmpArray[$loop] = [
            "from" => [
                (int) date("H", strtotime($ress['start_time'])),
                (int) date("i", strtotime($ress['start_time'])),
            ],
            "to" => [
                (int) date("H", strtotime($ress['end_time'])),
                (int) date("i", strtotime($ress['end_time'])),
            ]
        ];
        $loop++;
    }
    //}

    $stopEndTime =  [18, 0];
    $stopTime = date("Y-m-d H:i", strtotime($selectedDate . ' ' . $selectedTimeHI));
    $query3 = "SELECT id,start_time FROM user_resource_map WHERE start_time LIKE '$selectedDate%' AND start_time > '$stopTime%' ";

    if ($scheduleId) {
        $query3 = "SELECT id,start_time FROM user_resource_map WHERE start_time LIKE '$selectedDate%' AND start_time > '$stopTime%' AND id!=$scheduleId ";
    }

    if ($RESOURCE) {
        $query3 = $query3 . " AND resource_id= $RESOURCE ";
    }

    $query3 = $query3 . " ORDER BY start_time LIMIT 1";

    $result3 = mysqli_query($conn, $query3);
    $stopTimesTmpArray = mysqli_fetch_array($result3);

    if ($stopTimesTmpArray) {
        if ($selectedDateI == 00) {
            $stopEndTime = [
                (int) date("H", strtotime($stopTimesTmpArray['start_time'])) - 1,
                (int) date("i", strtotime($stopTimesTmpArray['start_time'])) + 30,
            ];
        } else {
            $stopEndTime = [
                (int) date("H", strtotime($stopTimesTmpArray['start_time'])) - 1,
                (int) date("i", strtotime($stopTimesTmpArray['start_time'])) + 30,
            ];
        }
    }

    foreach ($TmpArray as $time) {
        $disableTimesTmpA[] = $time;
    }

    $invalid = 1;
    if ($stopEndTime and $stopEndTime[0] and $startArray and $startArray[0]) {
        $invalid = $stopEndTime[0] - $startArray[0];
    }

    $disableTimesEnd = json_encode($disableTimesTmpA);
    $stopEndTimes = json_encode($stopEndTime);
    $endStart = json_encode($startArray);
    include 'endtime_select.php';
    exit();
}

function hourMinute2Minutes($strHourMinute)
{
    $from = date('Y-m-d 00:00:00');
    $to = date('Y-m-d ' . $strHourMinute . ':00');
    $diff = strtotime($to) - strtotime($from);
    $minutes = $diff / 60;
    return (int) $minutes;
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


// Make Reservation

if (isset($_POST['make_reservation'])) {
    $user_id = $_SESSION['id'];
    $resource_id = $_POST['resource_id'];
    $form_resource = $_POST['form_resource'];
    $reservation_title = $_POST['reservation_title'];
    $reservation_description = $_POST['reservation_description'];
    $form_reservation_date = $_POST['form_reservation_date'];
    $start_time = date("Y-m-d H:i:s", strtotime($form_reservation_date . ' ' . $_POST['start_time']));
    $end_time = date("Y-m-d H:i:s", strtotime($form_reservation_date . ' ' . $_POST['end_time']));

    if (isset($_POST['reservation_lecturer']) and $_POST['reservation_lecturer']) {
        $user_id = $_POST['reservation_lecturer'];
    }

    if (!isset($_POST['start_time']) or !$_POST['start_time']) {
        echo 5;
        exit();
    }

    if (!isset($_POST['end_time']) or !$_POST['end_time']) {
        echo 4;
        exit();
    }

    $sql = "INSERT INTO user_resource_map (user_id, resource_id, title, description, start_time, end_time, status) 
    VALUES($user_id, $resource_id, '$reservation_title', '$reservation_description', '$start_time','$end_time',1)";

    if ($conn->query($sql) == TRUE) {
        $status = 1;
    } else {
        echo "Error" . $sql . $conn->error;
    }
    echo $status;
    exit();
}


// Edit Reservation

if (isset($_POST['edit_reservation'])) {
    $user_id = $_SESSION['id'];
    $reservation_id = $_POST['reservation_id'];
    $form_resource = $_POST['form_resource'];
    $reservation_title = $_POST['reservation_title'];
    $reservation_description = $_POST['reservation_description'];
    $form_reservation_date = $_POST['form_reservation_date'];
    $start_time = date("Y-m-d H:i:s", strtotime($form_reservation_date . ' ' . $_POST['start_time']));
    $end_time = date("Y-m-d H:i:s", strtotime($form_reservation_date . ' ' . $_POST['end_time']));

    if (isset($_POST['reservation_lecturer']) and $_POST['reservation_lecturer']) {
        $user_id = $_POST['reservation_lecturer'];
    }

    if (!isset($_POST['start_time']) or !$_POST['start_time']) {
        echo 5;
        exit();
    }

    if (!isset($_POST['end_time']) or !$_POST['end_time']) {
        echo 4;
        exit();
    }

    // $sql = "INSERT INTO user_resource_map (user_id, resource_id, title, description, start_time, end_time, status) 
    // VALUES($user_id, $resource_id, '$reservation_title', '$reservation_description', '$start_time','$end_time',1)";

    $sql = "UPDATE user_resource_map SET title = '$reservation_title', description = '$reservation_description', start_time = '$start_time', end_time = '$end_time', user_id=$user_id WHERE id =$reservation_id";

    if ($conn->query($sql) == TRUE) {
        $status = 1;
    } else {
        echo "Error" . $sql . $conn->error;
    }

    echo $status;
    exit();
}


// Remove Reservation

if (isset($_POST['removeSchedule']) and isset($_POST['scheduleId'])) {
    $status = 0;
    $scheduleId = $_POST["scheduleId"];
    $query = "DELETE FROM user_resource_map WHERE id=$scheduleId";
    if (mysqli_query($conn, $query)) {
        $status = 1;
    }
    echo $status;
    exit();
}
