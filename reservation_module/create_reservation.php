<?php
require '../includes/conn.php';

$query = "SELECT id, name, category FROM resources";
$result = mysqli_query($conn, $query);
$resources = [];
while ($resource = mysqli_fetch_array($result)) {
    $resources[$resource['category']][] = array('id' => $resource['id'], 'name' =>  $resource['name']);
}

array_reverse($resources);

$RESOURCE = "2";
$RESOURCE_CATEGORY = "Lecture Hall";

if (isset($_COOKIE['schedule_table_resource']) and $_COOKIE['schedule_table_resource']) {
    $RESOURCE = $_COOKIE['schedule_table_resource'];
}

if (isset($_COOKIE['schedule_table_resource_category']) and $_COOKIE['schedule_table_resource_category']) {
    $RESOURCE_CATEGORY = $_COOKIE['schedule_table_resource_category'];
}

include '../common/header.php';
?>

<style>
    .reservation-titles {
        font-size: 15px;
    }

    .dcalendarpicker .dudp__wrapper {
        bottom: 24%;
    }

    /* .modal.in .modal-dialog {
        -webkit-transform: translate(0, calc(50vh - 50%));
        -ms-transform: translate(0, 50vh) translate(0, -50%);
        -o-transform: translate(0, calc(50vh - 50%));
        transform: translate(0, 50vh) translate(0, -50%);
    } */
</style>



<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">

        <section class="content-header">
            <h1> Make A Reservation </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">
                    Make a Reservation
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="chart">
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <label class="reservation-titles" id="test123"> Date Range </label>
                                            <!-- <input type="date" name="dates" class="form-control"> -->
                                            <input type="text" id="datepicker123" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <label class="reservation-titles"> Resource Category </label>
                                            <select class="form-control" id="catogory" name="catogory">
                                                <?php foreach ($resources as $key => $res) {
                                                    if ($RESOURCE_CATEGORY == $key) {
                                                        echo "<option value='{$key}' selected > {$key} </option>";
                                                    } else {
                                                        echo "<option value='{$key}' > {$key} </option>";
                                                    }
                                                }
                                                ?>

                                                <!-- <option value="Lecture Hall" <?php echo $RESOURCE_CATEGORY == 'Lecture Hall' ? 'selected' : ''; ?>> Lecture Hall </option>
                                                <option value="Auditorium" <?php echo $RESOURCE_CATEGORY == 'Auditorium' ? 'selected' : ''; ?>> Auditorium </option>
                                                <option value="Laboratory" <?php echo $RESOURCE_CATEGORY == 'Laboratory' ? 'selected' : ''; ?>> Laboratory </option>
                                                <option value="Playground" <?php echo $RESOURCE_CATEGORY == 'Playground' ? 'selected' : ''; ?>> Playground </option>
                                                <option value="Others" <?php echo $RESOURCE_CATEGORY == 'Others' ? 'selected' : ''; ?>> Other </option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <label class="reservation-titles"> Resource </label>
                                            <select class="form-control" id="resources">
                                                <?php foreach ($resources as $key => $res) {
                                                    if ($RESOURCE == $key) {
                                                        echo "<option value='{$key}' selected > {$res}{$key} </option>";
                                                    } else {
                                                        echo "<option value='{$key}' > {$res}{$key} </option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2 id="selectedResource" class="text-center"></h2>
                            <div class="schedule-calender">
                                <div id="schedule"></div>
                                <!-- <div id="loading" class="text-center">
                                    <img src="../public/images/loading.svg">
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="createReservation" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="reservationModalTitle"><b>Create Reservation</b></h4>
                </div>
                <div id="reservaionModalBody">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReservation" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="reservationEditModalTitle"><b>Edit Reservation</b></h4>
                </div>
                <div id="reservaionEditModalBody">

                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" id="reloadTableData" style="display: none;">Basic</button>
    <?php
    include '../includes/scripts.php';
    include '../includes/footer.php';
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var selectedResource = '<?php echo $RESOURCE; ?>';

        duDatepicker('#datepicker1', {
            format: 'mmmm d, yyyy',
            range: true,
            minDate: 'today',
            clearBtn: true,
            //setValue: 'June 20-30, 2021',
            // disabledDays: ['Sat', 'Sun'],
            events: {
                dateChanged: function(data) {
                    //log('From: ' + data.dateFrom + '\nTo: ' + data.dateTo)
                },
                onRangeFormat: function(from, to) {
                    var fromFormat = 'mmmm d, yyyy',
                        toFormat = 'mmmm d, yyyy';

                    if (from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear()) {
                        fromFormat = 'mmmm d'
                        toFormat = 'd, yyyy'
                    } else if (from.getFullYear() === to.getFullYear()) {
                        fromFormat = 'mmmm d'
                        toFormat = 'mmmm d, yyyy'
                    }

                    return from.getTime() === to.getTime() ?
                        this.formatDate(from, 'mmmm d, yyyy') : [this.formatDate(from, fromFormat), this.formatDate(to, toFormat)].join('-');
                }
            }
        })

        $('#reloadTableData').click(function() {
            loadScheduleData();
        });

        $('#resources, #catogory').on('change', function() {
            //$('.schedule-calender').hide();
            setTimeout(function() {
                $('#selectedResource').html($("#resources option:selected").text());
                setCookie('schedule_table_resource', $("#resources").val(), 30);
                setCookie('schedule_table_resource_category', $("#catogory").val(), 30);
                loadScheduleData();
                //$('.schedule-calender').show();
            }, 300);
        });

        var selectedStart = '';
        var selectedEnd = '';

        var picker = new Lightpick({
            field: document.getElementById('datepicker123'),
            singleDate: false,
            selectForward: true,
            repick: true,
            footer: true,
            minDate: moment().endOf('day'),
            onSelect: function(start, end) {
                selectedStart = start.format('D-M-YYYY');
                selectedEnd = end.format('D-M-YYYY');
            },
            onClose: function() {
                $.post('reservation_functions.php', {
                    dateRengeSessonSet: 1,
                    selectedStart: selectedStart,
                    selectedEnd: selectedEnd
                }, function(res) {
                    if (res == 1) {
                        loadScheduleData();
                    }
                });
            }
        });

        var isDraggable = false;
        var isResizable = false;

        var $sc = $("#schedule").timeSchedule({
            startTime: "06:00", // schedule start time(HH:ii)
            endTime: "18:00", // schedule end time(HH:ii)
            widthTime: 60 * 10, // cell timestamp example 10 minutes
            timeLineY: 100, // height(px)
            verticalScrollbar: 1, // scrollbar (px)
            timeLineBorder: 2, // border(top and bottom)
            bundleMoveWidth: 10, // width to move all schedules to the right of the clicked time line cell
            draggable: isDraggable,
            resizable: isResizable,
            resizableLeft: false,
            rows: [],
            onChange: function(node, data) {

            },
            onInitRow: function(node, data) {

            },
            onClick: function(node, data) {
                //console.log($(node).addClass('pck-opts'));

                var popId = node.attr('data-pop-id');
                console.log(popId);
                $(node).popModal({
                    placement: 'bottomLeft',
                    html: $(popId)
                });

            },
            onAppendRow: function(node, data) {

            },
            onAppendSchedule: function(node, data) {
                if (data.data.class) {
                    node.addClass(data.data.class);
                }
                if (data.data.color) {
                    node.addClass(data.data.color);
                }
                if (data.data.image) {
                    var $img = $('<div class="photo"><img></div>');
                    $img.find('img').attr('src', data.data.image);
                    node.prepend($img);
                    node.addClass('sc_bar_photo');
                }
                if (data.data.image) {
                    node.append("<div class='lecturer-name'>" + data.data.lecturer + '</div>');
                    node.addClass('');
                }

                var ramdom_id = Math.floor(Math.random() * 10000);
                node.attr('data-pop-id', '#popid_' + ramdom_id);
                var actionButtons = '';
                //console.log(data.data);
                if (data.data.actions) {
                    actionButtons = "<div class='info-buttons' data-headding='" + data.data.headding + "' data-date='" + data.data.date + "' data-id='" + data.data.id + "'> <button class='btn btn-default edit-schedule-event'> <i class='fa fa-edit'></i> </button> <button class='btn btn-danger remove-schedule-event'> <i class='fa fa-trash'></i> </button> </div>";
                }

                node.prepend("<div style='display:none;'><div id='popid_" + ramdom_id + "'> <div class='info-headding'> " + data.data.headding + " </div> <div class='info-description'> " + data.data.description + " </div> <div class='info-time'> " + data.data.dateRange + " </div>  " + actionButtons + " </div> </div>");
            },
            // onScheduleClick: function(node, time, timeline) {
            //     var start = time;
            //     var end = $(this).timeSchedule('formatTime', $(this).timeSchedule('calcStringTime', time) + 3600);
            //     $(this).timeSchedule('addSchedule', timeline, {
            //         start: start,
            //         end: end,
            //         text: 'Insert Schedule',
            //         data: {
            //             class: 'sc_bar_insert'
            //         }
            //     });
            //     //addLog('onScheduleClick', time + ' ' + timeline);
            // },
        });

        $(document).on('click', '.edit-schedule-event', function() {
            var scheduleId = $(this).parent().attr('data-id');
            var scheduleHeadding = $(this).parent().attr('data-headding');
            var resDay = $(this).parent().attr('data-date');
            $(this).parent().parent().parent().prev('button').trigger('click');

            $.post('reservation_functions.php', {
                editReservationModal: 1,
                scheduleId: scheduleId,
                resDay: resDay
            }, function(data) {
                $("#editReservation #reservationEditModalTitle").html('<strong> ' + scheduleHeadding + '</strong> <small>( ' + resDay + ')</small>');
                $("#editReservation #reservaionEditModalBody").html(data);
                $('#editReservation').modal('show');
            });
        });

        $(document).on('click', '.remove-schedule-event', function() {
            var scheduleId = $(this).parent().attr('data-id');
            var scheduleHeadding = $(this).parent().attr('data-headding');
            $(this).parent().parent().parent().prev('button').trigger('click');

            Swal.fire({
                title: 'Remove "' + scheduleHeadding + '" ?',
                text: "Are you sure you want to delete this reservation?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "reservation_functions.php",
                        method: "POST",
                        data: {
                            scheduleId: scheduleId,
                            removeSchedule: 1
                        },
                        success: function(data) {
                            if (data == 1) {
                                showMessage('success', '<small>' + scheduleHeadding + ' has been removed successfully</small>')
                                loadScheduleData();
                            }
                        }
                    });
                }
            });
        });

        setInterval(function() {
            if (!$('html').hasClass('popModalOpen')) {
                loadScheduleData();
            }
        }, 60000);

        loadScheduleData();

        function loadScheduleData() {
            $.ajax({
                type: 'POST',
                url: 'reservation_functions.php',
                data: {
                    'loadSchedule': 1
                },
            }).done((data) => {
                var scheduleData = JSON.parse(data);
                var startDayRaw = scheduleData['start'];
                var endDayRaw = scheduleData['end'];
                delete scheduleData['remove'];
                delete scheduleData['start'];
                delete scheduleData['end'];


                $sc.timeSchedule('setRows', scheduleData);

                var a = moment(startDayRaw, 'D/M/YYYY');
                var b = moment(endDayRaw, 'D/M/YYYY');

                picker.setDateRange(
                    a, b
                );
            });
        }


        // Update Resource when updating Category
        var array = <?php echo json_encode($resources); ?>;
        updateResources($('#catogory').val());

        $("#catogory").on('change', function() {
            updateResources($(this).val());
        });

        function updateResources(cat) {
            $('#resources option').remove();
            for (i = 0; i < array[cat].length; i++) {
                var id = array[cat][i]['id'];
                var name = array[cat][i]['name'];

                var option = $('<option>');
                option.attr('value', id);
                option.append(name);

                if (selectedResource == id) {
                    option.attr('selected', 'selected');
                    $('#selectedResource').html(name);
                }

                $('#resources').append(option);
            }
        }

        $(document).on('click', '.add-reservation', function() {
            var resources = $("#resources option:selected").text();
            var resource_id = $("#resources").val();
            var resDay = $(this).parent().find('.raw_date').val();

            $.post('reservation_functions.php', {
                addReservationModal: 1,
                resource_id: resource_id,
                resDay: resDay
            }, function(data) {
                $("#createReservation #reservationModalTitle").html('<strong> Reserve - ' + resources + '</strong> <small>( ' + resDay + ')</small>');
                $("#createReservation #reservaionModalBody").html(data);
                $("#createReservation").modal('show');
            });
        });

        // Show any message
        function showMessage(type, description) {
            Swal.fire({
                icon: type,
                title: description,
                showConfirmButton: false,
                timer: 1200
            })
        }
    });
</script>

</body>

</html>