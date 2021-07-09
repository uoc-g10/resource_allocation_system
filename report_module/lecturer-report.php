<?php
require '../includes/conn.php';

$query = "SELECT u.*,d.name as did FROM users as u INNER JOIN departments as d ON d.id = u.department WHERE role='ROLE_LECTURER' ";
$result = mysqli_query($conn, $query);

$lectureres = [];
while ($row = mysqli_fetch_array($result)) {
    $lectureres[] = $row;
}

$query2 = "SELECT * FROM resources;";
$result2 = mysqli_query($conn, $query2);

$resources = [];
while ($row = mysqli_fetch_array($result2)) {
    $resources[] = ['id' => $row['id'], 'name' => $row['name']];
}

$startDate = '';
$endDate = '';
$resStatus = 0;

if (isset($_COOKIE['lecturer_report_start'])) {
    $startDate = date("d/m/Y", strtotime($_COOKIE['lecturer_report_start']));
}

if (isset($_COOKIE['lecturer_report_end'])) {
    $endDate = date("d/m/Y", strtotime($_COOKIE['lecturer_report_end']));
}

if (isset($_COOKIE['lecturer_report_reservation_status'])) {
    $resStatus = $_COOKIE['lecturer_report_reservation_status'];
}

include '../common/header.php';
?>

<style>
    table tr th {
        text-align: center;
    }
</style>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="col-xs-12">
                <h1> Overall Report </h1>

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

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <div class="box">

                            <div class="box-header with-border">
                                <div class="col-xs-12">
                                    <br>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 pl-0">
                                                <div class="">
                                                    Lecturer
                                                    <select class="form-control" id="selectLecturer">
                                                        <option value="0"> All Lecturers </option>
                                                        <?php foreach ($lectureres as $lecture) {
                                                            if (isset($_COOKIE['lecturer_report_lecturer']) and $_COOKIE['lecturer_report_lecturer'] == $lecture['id']) {
                                                                echo "<option selected value='" . $lecture['id'] . "'> " . $lecture['title'] . " " . $lecture['firstname'] . " " . $lecture['secondname'] . "</option>";
                                                            } else {
                                                                echo "<option value='" . $lecture['id'] . "'> " . $lecture['title'] . " " . $lecture['firstname'] . " " . $lecture['secondname'] . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-0">
                                                <div class="">
                                                    Resource
                                                    <select class="form-control" id="selectResource">
                                                        <option value="0"> All Resources </option>
                                                        <?php foreach ($resources as $resource) {
                                                            if (isset($_COOKIE['lecturer_report_resource']) and $_COOKIE['lecturer_report_resource'] == $resource['id']) {
                                                                echo "<option selected value='" . $resource['id'] . "'> " . $resource['name'] . "</option>";
                                                            } else {
                                                                echo "<option value='" . $resource['id'] . "'> " . $resource['name'] . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    Date Range
                                                    <input type="text" id="datepicker" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    Reservation Status
                                                    <select class="form-control" id="reservation_status">
                                                        <option value="0"> All Reservations </option>
                                                        <option value="1" <?php echo $resStatus == 1 ? 'selected' : '' ?>> Past Reservations </option>
                                                        <option value="2" <?php echo $resStatus == 2 ? 'selected' : '' ?>> Upcomming Reservations </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <!-- <div class="col-md-4">
                                                <div class="row">
                                                    <div class="input-group">
                                                        Search
                                                        <input type="search" class="form-control" id="customSearch">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default btn-flat" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                </span> Search!</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="box-body">
                                    <table id="lecturers_data" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Lecturer Name</th>
                                                <th>Resource</th>
                                                <th>Date</th>
                                                <th>Reserved Time</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>



<?php include '../includes/scripts.php'; ?>
<?php include '../includes/footer.php'; ?>
</div>
<script>
    var startDayRaw = '<?php echo $startDate; ?>';
    var endDayRaw = '<?php echo $endDate; ?>';

    // Assign DataTable
    var dataTable = $('#lecturers_data').DataTable({
        "processing": true,
        "serverSide": true,
        "dom": "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "order": [],
        "aoColumns": [{
            "bSortable": false
        }, {
            "bSortable": true
        }, {
            "bSortable": true
        }, {
            "bSortable": true
        }, {
            "bSortable": false
        }, {
            "bSortable": false
        }, {
            "bSortable": false
        }],
        "ajax": {
            url: "lecturers_report_fetch.php",
            data: {
                'load_table': 1
            },
            type: "POST"
        }
    });

    var picker = new Lightpick({
        field: document.getElementById('datepicker'),
        singleDate: false,
        selectForward: true,
        repick: true,
        footer: true,
        //minDate: moment().endOf('day'),
        onSelect: function(start, end) {
            selectedStart = start.format('YYYY-MM-DD');
            selectedEnd = end.format('YYYY-MM-DD');
            setCookie('lecturer_report_start', selectedStart, 30);
            setCookie('lecturer_report_end', selectedEnd, 30);
        },
        onClose: function() {
            dataTable.ajax.reload();
        }
    });

    var a = moment(startDayRaw, 'D/M/YYYY');
    var b = moment(endDayRaw, 'D/M/YYYY');

    picker.setDateRange(
        a, b
    );

    $("#selectLecturer").on('change', function() {
        var val = $(this).val();
        setCookie('lecturer_report_lecturer', val, 30);
        dataTable.ajax.reload();
    });

    $("#selectResource").on('change', function() {
        var val = $(this).val();
        setCookie('lecturer_report_resource', val, 30);
        dataTable.ajax.reload();
    });

    $("#reservation_status").on('change', function() {
        var val = $(this).val();
        setCookie('lecturer_report_reservation_status', val, 30);
        dataTable.ajax.reload();
    });
</script>

</html>