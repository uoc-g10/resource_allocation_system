<?php
require '../includes/conn.php';

$query = "SELECT id, name, category FROM resources";
$result = mysqli_query($conn, $query);
$resources = [];
while ($resource = mysqli_fetch_array($result)) {
    $resources[$resource['category']][] = array('id' => $resource['id'], 'name' =>  $resource['name']);
}
include '../common/header.php';
?>

<style>
    .reservation-titles {
        font-size: 15px;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">
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
                        Dashboard
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
                                                <label class="reservation-titles"> Lecturer </label>
                                                <select class="form-control">
                                                    <option> Dr.Rohan Samarasinghe </option>
                                                    <option> Mrs.Nethmini Weerasinghe </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12">
                                                <label class="reservation-titles"> Resource Category </label>
                                                <select class="form-control" id="catogory" name="catogory">
                                                    <option value="Lecture Hall"> Lecture Hall </option>
                                                    <option value="Auditorium"> Auditorium </option>
                                                    <option value="Laboratory"> Laboratory </option>
                                                    <option value="Playground"> Playground </option>
                                                    <option value="Others"> Other </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12">
                                                <label class="reservation-titles"> Resource </label>
                                                <select class="form-control" id="resources">
                                                    <?php foreach ($resources as $key => $res) {
                                                        echo "<option value='{$key}'> {$res} </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="schedule-calender">
                                <input type="text" class="action-create">
                                    <div id="schedule"></div>
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
                        <h4 class="modal-title"><b>Create Reservation</b></h4>
                    </div>
                    <div id="reservaionModalBody">

                    </div>
                </div>
            </div>
        </div>

        <?php include '../includes/scripts.php'; ?>
        <?php include '../includes/footer.php'; ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

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
                    console.log($(node).addClass('pck-opts'));

                },
                onAppendRow: function(node, data) {

                },
                onAppendSchedule: function(node, data) {
                    if (data.data.class) {
                        node.addClass(data.data.class);
                    }
                    if (data.data.image) {
                        var $img = $('<div class="photo"><img></div>');
                        $img.find('img').attr('src', data.data.image);
                        node.prepend($img);
                        node.addClass('sc_bar_photo');
                    }
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
                    delete scheduleData['remove'];

                    $sc.timeSchedule('setRows', scheduleData);
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
                    $('#resources').append(option);
                }
            }


            $(document).on('click', '.add-reservation', function() {
                // start_time_picker.set('disable', []);
                // var resources = $("#resources option:selected").text();
                var resource_id = $("#resources").val();
                var resDay = $(this).parent().find('.raw_date').val();

                $.post('reservation_functions.php', {
                    addReservationModal: 1,
                    resource_id: resource_id,
                    resDay: resDay
                }, function(data) {
                    $("#createReservation #reservaionModalBody").html(data);
                    $("#createReservation").modal('show');
                });
            });

            $('.action-create').on('click', function() {
                $('.pck-auto:not(.picker-element)').picker();
                $('.pck-opts:not(.picker-element)').picker({
                    title: 'With custom options',
                    selectableItems: ['github', 'heart', 'html5', 'css3'],
                    selectedCustomClass: 'label label-success',
                    mustAccept: true,
                    placement: 'bottomRight',
                    showFooter: true,
                    // note that this is ignored cause we have an accept button:
                    hideOnSelect: true,
                    templates: {
                        popoverFooter: '<div class="popover-footer">' +
                            '<div style="text-align:left; font-size:12px;">Placements: \n\
                    <a href="#" class=" action-placement">topLeftCorner</a>\n\
                    <a href="#" class=" action-placement">topLeft</a>\n\
                    <a href="#" class=" action-placement">top</a>\n\
                    <a href="#" class=" action-placement">topRight</a>\n\
                    <a href="#" class=" action-placement">topRightCorner</a>\n\
                    <a href="#" class=" action-placement">rightTop</a>\n\
                    <a href="#" class=" action-placement">right</a>\n\
                    <a href="#" class=" action-placement">rightBottom</a>\n\
                    <a href="#" class=" action-placement">bottomRightCorner</a>\n\
                    <a href="#" class=" active action-placement">bottomRight</a>\n\
                    <a href="#" class=" action-placement">bottom</a>\n\
                    <a href="#" class=" action-placement">bottomLeft</a>\n\
                    <a href="#" class=" action-placement">bottomLeftCorner</a>\n\
                    <a href="#" class=" action-placement">leftBottom</a>\n\
                    <a href="#" class=" action-placement">left</a>\n\
                    <a href="#" class=" action-placement">leftTop</a>\n\
                    </div><hr>' +
                            '<button class="picker-btn picker-btn-cancel btn btn-default btn-sm">Cancel</button>' +
                            '<button class="picker-btn picker-btn-accept btn btn-primary btn-sm">Accept</button></div>'
                    }
                }).data('picker').show();
            }).trigger('click');
        });
    </script>
</body>

</html>