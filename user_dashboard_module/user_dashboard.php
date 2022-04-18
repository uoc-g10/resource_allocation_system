<?php

include '../common/header.php';
require '../includes/conn.php';

$LoginUser = $User['id'];
$Today = date("Y-m-d");


if ($User['role'] == 'ROLE_ADMIN' or $User['role'] == 'ROLE_MANAGE_USER') {
    $schedulesQuery = "SELECT urm.*,res.name as hall FROM user_resource_map as urm INNER JOIN resources as res ON urm.resource_id = res.id WHERE urm.start_time LIKE '%$Today%' ORDER BY urm.start_time ASC";
} else {
    $schedulesQuery = "SELECT urm.*,res.name as hall FROM user_resource_map as urm INNER JOIN resources as res ON urm.resource_id = res.id WHERE urm.user_id=$LoginUser AND urm.start_time LIKE '%$Today%' ORDER BY urm.start_time ASC";
}

$scheduleQueryResults = mysqli_query($conn, $schedulesQuery);
$UserSehedules = [];

foreach ($scheduleQueryResults as $schedule) {
    $tmpArray = [];
    $time = date('D M d Y H:i:s \G\M\TO ', strtotime($schedule['start_time'])) . '(India Standard Time)';
    $tmpArray['time'] = $time;
    $tmpArray['color'] = '#00ff00';
    $tmpArray['css'] = 'success';
    $tmpArray['content'] = "<div> <div class='res-title'>" . $schedule['title'] . "</div> <div class='res-description'> " . $schedule['description'] . " </div> <div class='res-time'>" . date("h:i A", strtotime($schedule['start_time'])) . " - " . date("h:i A", strtotime($schedule['end_time'])) . " </div> <div class='res-hall'> " . $schedule['hall'] . " </div> </div>";

    $UserSehedules[] = $tmpArray;
}

$UserSehedulesJson = json_encode($UserSehedules);
?>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <style>
        .clock {
            display: flex;
            font-size: 27px;
            margin-bottom: -37px;
            margin-top: -6px;
        }

        #Date {
            font-size: 13px;
            margin-bottom: -7px;
            /* background-color: #b52c1f; */
            color: #b52c1f;
            font-weight: 600;
        }

        #time_greeting {
            margin-top: 0;
        }

        .clock-ul {
            margin: 0;
            padding-left: 10px;
            font-weight: 800;
        }

        .clock-li {
            display: inline;
            text-align: center;
            color: #b52c1f;
        }

        #point {
            position: relative;
            -moz-animation: mymove 1s ease infinite;
            -webkit-animation: mymove 1s ease infinite;
        }

        /* Simple Animation */
        @-webkit-keyframes mymove {
            0% {
                opacity: 1.0;
                text-shadow: 0 0 20px #00c6ff;
            }

            50% {
                opacity: 0;
                text-shadow: none;
            }

            100% {
                opacity: 1.0;
                text-shadow: 0 0 20px #00c6ff;
            }
        }

        @-moz-keyframes mymove {
            0% {
                opacity: 1.0;
                text-shadow: 0 0 20px #00c6ff;
            }

            50% {
                opacity: 0;
                text-shadow: none;
            }

            100% {
                opacity: 1.0;
                text-shadow: 0 0 20px #00c6ff;
            }

        }

        .ml-auto {
            margin-left: auto;
        }

        .pt-0 {
            padding-top: 0;
        }

        .mt-0 {
            margin-top: 0;
        }

        .tl-wrap {
            text-align: left;
            padding-right: 12px;
        }

        .res-title {
            font-weight: bold;
            font-size: 17px;
            border-bottom: 1px solid #dee5e7;
            color: #b52c1f;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .res-description {
            border-bottom: 1px solid #dee5e7;
            padding-bottom: 10px;
            margin-bottom: 5px;
        }

        .res-time {
            padding-bottom: 5px;
            font-weight: 600;
        }

        #element,
        #upcommingEvents {
            max-height: calc(100vh - 370px);
            overflow: auto;
            margin-bottom: 24px;
        }

        .tl-wrap {
            border-color: #ca3729;
        }

        .tl-content {
            cursor: pointer;
        }

        .fc-button-primary {
            background-color: #6f0e05e6 !important;
            border-color: #8c150a !important;
        }

        .fc-button-active {
            background-color: #b52c1f !important;
        }
        .content {
    margin-top: 90px;
  }
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="col-xs-12">
                <div class="clock">
                    <div class="ml-auto text-center">
                        <div id="Date"></div>
                        <ul class="clock-ul">
                            <li id="hours" class="clock-li"></li>
                            <li id="point" class="clock-li">:</li>
                            <li id="min" class="clock-li"> </li>
                        </ul>
                    </div>
                </div>
                <h2 id="time_greeting"></h2>
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

        <!-- <section class="content-header">
            <h2> Dashboard </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">
                    Dashboard
                </li>
            </ol>
        </section> -->

        <section class="content">

            <div class="">
                <div class="col-md-5">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h3 class="">Today Reservations</h3>
                                <br>
                                <div id="element">
                                    <div>
                                        <div>
                                            <br>
                                            <br>
                                            <img src="../public/images/no-today-reservations.svg" width="250px">
                                            <br>
                                            <br>
                                            <br>
                                            <h4 class="text-muted"> No Reservations for today </h4>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h3 class="">Upcomming Reservations</h3>
                                <br>
                                <div id='upcommingEvents'>
                                    <div id="loading"></div>
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include '../includes/scripts.php'; ?>
    <?php include '../includes/footer.php'; ?>
    <script>
        var todayReservations = <?php echo $UserSehedulesJson; ?>;
        var dataJson = [];

        for (var i = 0; todayReservations.length > i; i++) {
            $("#element").html('');
            dataJson.push({
                'time': new Date(todayReservations[i]['time']),
                'color': todayReservations[i]['color'],
                'css': todayReservations[i]['css'],
                'content': todayReservations[i]['content'],
            });
        }

        $("#element").timeline({
            data: dataJson
        });

        var d = new Date();
        var time = d.getHours();
        var msg = '';
        if (time < 12) {
            msg = "Good Morning!";
        }
        if (time >= 12) {
            msg = "<b>Good Afternoon!</b>";
        }

        if (time > 15) {
            msg = "<b>Good Evening!</b>";
        }

        $("#time_greeting").html(msg);

        // Clock

        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var dayNames = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
        ];

        var newDate = new Date();

        newDate.setDate(newDate.getDate());
        //$('#Date').html(newDate.getFullYear() + " | " + monthNames[newDate.getMonth()] + " | " + newDate.getDate() + "  " + dayNames[newDate.getDay()]);
        $('#Date').html(monthNames[newDate.getMonth()] + "  " + newDate.getDate() + " - " + dayNames[newDate.getDay()]);

        setInterval(function() {
            var seconds = new Date().getSeconds();
            $("#sec").html((seconds < 10 ? "0" : "") + seconds);
        }, 1000);

        setInterval(function() {
            var minutes = new Date().getMinutes();
            var hour = new Date().getHours();
            var ampm = hour >= 12 ? 'PM' : 'AM';
            $("#min").html((minutes < 10 ? "0" : "") + minutes + " " + ampm);
        }, 1000);

        setInterval(function() {
            var hour = new Date().getHours();
            var hours = hour % 12;
            hours = hours ? hours : 12;
            $("#hours").html((hours < 10 ? "0" : "") + hours);
        }, 1000);

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialDate: new Date(),
                validRange: {
                    start: new Date()
                },
                editable: false,
                height: 'auto',
                initialView: 'dayGridMonth',
                navLinks: true, // can click day/week names to navigate views
                dayMaxEvents: true, // allow "more" link when too many events
                events: {
                    url: 'get-events.php',
                    failure: function() {
                        document.getElementById('script-warning').style.display = 'block'
                    }
                },
                loading: function(bool) {
                    document.getElementById('loading').style.display =
                        bool ? 'block' : 'none';
                }
            });

            calendar.render();
        });
    </script>
</div>

</html>