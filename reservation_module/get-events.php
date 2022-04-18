<?php
require dirname(__FILE__) . '/utils.php';
require '../includes/conn.php';
$LoginUser = $User['id'];

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
  die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timeZone, like "2013-12-29".
// Since no timeZone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start'])->format('Y-m-d H:i:s');
$range_end = parseDateTime($_GET['end'])->format('Y-m-d H:i:s');

// Parse the timeZone parameter if it is present.
$time_zone = null;
if (isset($_GET['timeZone'])) {
  $time_zone = new DateTimeZone($_GET['timeZone']);
}

// Read and parse our events JSON file into an array of event data arrays.
// $json = file_get_contents(dirname(__FILE__) . '/../json/events.json');
// $input_arrays = json_decode($json, true);

// print_r($range_start);
// print_r($range_end);
// die();


if ($User['role'] == 'ROLE_ADMIN' or $User['role'] == 'ROLE_MANAGE_USER') {
  $eventsQuery = "SELECT urm.*,res.name as hall FROM user_resource_map as urm INNER JOIN resources as res ON urm.resource_id = res.id WHERE urm.start_time >= '%$range_start%' AND urm.start_time >= '%$range_end%' ORDER BY urm.start_time ASC";
} else {
  $eventsQuery = "SELECT urm.*,res.name as hall FROM user_resource_map as urm INNER JOIN resources as res ON urm.resource_id = res.id WHERE urm.user_id=$LoginUser AND urm.start_time >= '%$range_start%' AND urm.start_time >= '%$range_end%' ORDER BY urm.start_time ASC";
}

$eventsQueryResults = mysqli_query($conn, $eventsQuery);
$input_arrays = [];

foreach ($eventsQueryResults as $schedule) {
  $tmpArray = [];
  // $time = date('D M d Y H:i:s \G\M\TO ', strtotime($schedule['start_time'])) . '(India Standard Time)';
  // $tmpArray['time'] = $time;
  $tmpArray['title'] = $schedule['title'];
  $tmpArray['start'] = date('Y-m-d\TH:i\+05:30', strtotime($schedule['start_time']));
  $tmpArray['end'] = date('Y-m-d\TH:i\+05:30', strtotime($schedule['end_time']));
  $tmpArray['allDay'] = false;
  //$tmpArray['content'] = "<div> <div class='res-title'>" . $schedule['title'] . "</div> <div class='res-description'> " . $schedule['description'] . " </div> <div class='res-hall'> " . $schedule['hall'] . " </div> </div>";

  $input_arrays[] = $tmpArray;
}


//"2020-09-09T16:00:00-05:00"

// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {
  // Convert the input array into a useful Event object
  $event = new Event($array, $time_zone);

  // If the event is in-bounds, add it to the output
  //if ($event->isWithinDayRange($range_start, $range_end)) {
  $output_arrays[] = $event->toArray();
  //}
}

// print_r($output_arrays);
// exit();

// Send JSON to the client.
echo json_encode($output_arrays);
