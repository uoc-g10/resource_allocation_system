<?php include '../common/header.php'; ?>
<style>
    .chart {
        height: auto !important;
    }
</style>
<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">

        <section class="content-header">
            <h1> My Reservations </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">
                    Dashboard
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="chart" style="height: 300px;">
                                <br>
                                <div id='myReservations'>
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
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialDate: new Date(),
                // validRange: {
                //     start: new Date()
                // },
                editable: false,
                height: '600',
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