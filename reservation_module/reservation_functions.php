<?php

require '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Method Not Allowed';
    exit();
}


// Load Table Data
if (isset($_POST['loadSchedule'])) {

    $Data = [];
    $days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $DateNames = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    foreach ($days as $key => $day) {
        $reservations = [];
        $date = date("M - d", strtotime($day));
        $dateRaw = date("Y-M-d", strtotime($day));
        $qDate = date("Y-m-d", strtotime($day));
        $DateName = date("l", strtotime($day));

        $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm INNER JOIN users as usr ON urm.user_id = usr.id WHERE start_time LIKE '$qDate%'";

        $result2 = mysqli_query($conn, $query2);
        while ($ress = mysqli_fetch_array($result2)) {
            $startDate = date("H:i", strtotime($ress['start_time']));
            $endDate = date("H:i", strtotime($ress['end_time']));

            $reservations[] = [
                "start" => $startDate,
                "end" => $endDate,
                "text" => $ress['title'],
                "data" => array(
                    "class" => "example2",
                    "test" => $ress['description'],
                    "image" => "../img/1.png"
                )
            ];
        }

        $Data[$key]['title'] = $date;
        $Data[$key]['subtitle'] = "<input type='hidden' class='raw_date' value='$dateRaw'> $DateName <br><br><button class='btn btn-success btn-sm add-reservation'> <i class='fa fa-edit'></i> Make Reservation</button>";
        $Data[$key]['schedule'] = $reservations;
    }

    $disabled = json_encode($disableTimes);
    $Data['remove'] = 1;
    echo json_encode($Data);
    exit();
}

// Reservation Modal Deta
if (isset($_POST['addReservationModal'])) {
    $resource_id = $_POST['resource_id'];
    $resDay = $_POST['resDay'];

    $selectedDate = date("Y-m-d", strtotime($resDay));

    $days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $TmpArray = [];
    $disableTimesTmpA = [];
    $disableTimesTmpB = [];

    foreach ($days as $key => $day) {

        $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' ORDER BY start_time";
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
    }

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


// Generate End Time 

if (isset($_POST['getEndTime'])) {
    $inputTime = $_POST['inputTime'];
    $resDay = $_POST['resDay'];

    $days = [0 => "today", 1 => "+1 day", 2 => "+2 day", 3 => "+3 day", 4 => "+4 day", 5 => "+5 day", 6 => "+6 day"];
    $selectedDate = date("Y-m-d", strtotime($resDay));
    $selectedDateH = date("H", strtotime($inputTime));
    $selectedDateI = date("i", strtotime($inputTime));
    $selectedTimeHI = date("H:i", strtotime($inputTime));
    $selectedMinites = hourMinute2Minutes($selectedTimeHI);

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


    foreach ($days as $key => $day) {

        $query2 = "SELECT urm.*, usr.firstname, usr.secondname FROM user_resource_map as urm LEFT JOIN users as usr ON usr.id = urm.user_id WHERE start_time LIKE '$selectedDate%' ORDER BY start_time";
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
    }

    $stopEndTime =  [18, 0];
    $stopTime = date("Y-m-d H:i", strtotime($selectedDate . ' ' . $selectedTimeHI));
    $query3 = "SELECT id,start_time FROM user_resource_map WHERE start_time LIKE '$selectedDate%' AND start_time > '$stopTime%' ORDER BY start_time LIMIT 1";
    $result3 = mysqli_query($conn, $query3);
    $stopTimesTmpArray = mysqli_fetch_array($result3);

    if ($stopTimesTmpArray) {
        if ($selectedDateI == 00) {

            $stopEndTime = [
                (int) date("H", strtotime($stopTimesTmpArray['start_time'])) - 1,
                30
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


// Get Disable Time Ranges
if (isset($_POST['getDisableTimes']) and isset($_POST['date'])) {
}
