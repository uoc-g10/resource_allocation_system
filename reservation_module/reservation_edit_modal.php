<?php

$query = "SELECT id,title,firstname,secondname FROM users WHERE role='ROLE_LECTURER' ";
$result = mysqli_query($conn, $query);

$lectureres = [];
while ($row = mysqli_fetch_array($result)) {
    $lectureres[] = $row;
}
?>

<form class="form-horizontal" method="POST" id="createReservationFrm_<?php echo $randId = rand(10000, 9999); ?>" enctype="multipart/form-data">
    <div class="modal-body">
        <input type="hidden" name="edit_reservation" value="1">
        <input type="hidden" id="form_reservation_date" name="form_reservation_date" value="<?php echo $resDay; ?>">
        <input type="hidden" id="reservation_id" name="reservation_id" value="<?php echo $scheduleId; ?>">
        <!-- <div class="form-group">
            <label for="firstname_edit" class="col-sm-3 control-label">Reservation Date</label>
            <div class="col-sm-9">

                <input type="text" class="form-control" id="form_reservation_date" name="form_reservation_date" value="<?php echo $resDay; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Resource</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="form_resource" name="form_resource" value="<?php echo $resource_id; ?>" readonly>
            </div>
        </div> -->
        <div class="form-group">
            <label for="reservation_title" class="col-sm-3 control-label">Reservation Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="reservation_title" name="reservation_title" value="<?php echo $UserSchedule['title']; ?>" placeholder="Reservation Title" required>
            </div>
        </div>
        <div class="form-group">
            <label for="reservation_description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea type="text" class="form-control" id="reservation_description" rows="5" name="reservation_description" placeholder="Reservation Title" required><?php echo $UserSchedule['description']; ?></textarea>
            </div>
        </div>
        <?php if ($User['role'] == 'ROLE_ADMIN' or $User['role'] == 'ROLE_MANAGE_USER') { ?>

            <div class="form-group">
                <label for="reservation_description" class="col-sm-3 control-label">Lecturer</label>
                <div class="col-sm-9">
                    <select class="form-control" name="reservation_lecturer" id="selectLecturer">
                        <option value="<?php echo $User['id']; ?>"> N/A </option>
                        <?php foreach ($lectureres as $lecture) {
                            if ($UserSchedule['user_id'] == $lecture['id']){
                                echo "<option value='" . $lecture['id'] . "' selected> " . $lecture['title'] . " " . $lecture['firstname'] . " " . $lecture['secondname'] . "</option>";
                            }else {
                                echo "<option value='" . $lecture['id'] . "'> " . $lecture['title'] . " " . $lecture['firstname'] . " " . $lecture['secondname'] . "</option>";
                            }
                        } ?>
                    </select>
                </div>
            </div>

        <?php } ?>
        <div class="form-group">
            <label for="mobile_edit" class="col-sm-3 control-label">Start Time</label>
            <div class="col-sm-3">
                <input id="start_time_input2" class="start_time form-control" type="time" name="start_time" required>
            </div>
            <div id="endTimeSelect2">
            </div>
        </div>
        <div class="form-group">

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" id="saveReservation" name="save"><i class="fa fa-check-square-o"></i> Save</button>
    </div>
</form>
<script>
    $('#endTimeSelect2').html('');
    var disableTimesStart_edit = <?php echo $disableTimesStart; ?>;
    var selectedStartMinites = <?php echo $selectedStartMinites; ?>;
    var scheduleId = <?php echo $scheduleId; ?>;
    var resDay = "<?php echo $resDay; ?>";

    var $start_time_picker2 = $('#start_time_input2').pickatime({
        editable: false,
        hiddenName: true,
        hiddenPrefix: 'prefix__',
        hiddenSuffix: '__suffix',
        clear: '',
        interval: 30,
        min: [6, 0],
        max: [17, 0],
        disable: disableTimesStart_edit,
        formatLabel: function(time) {
            //console.log($(this));
            //console.log(disableTimesStart);
            return "h:i A <sm!all cl!ass='tt!ime'></sm!all>"
        }
    });

    var start_time_picker2 = $start_time_picker2.pickatime('picker');
    start_time_picker2.set('select', selectedStartMinites);

    $('.picker__list-item--disabled').each(function() {
        $('.picker__list-item--disabled').find('small').html('Reserved');
    });

    $("#createReservationFrm_<?php echo $randId ?>").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'reservation_functions.php',
            data: $('#createReservationFrm_<?php echo $randId ?>').serialize(),
            success: function(response) {

                if (response == 5) {
                    $.jnoty("Please Input Start Time", {
                        header: 'Input Start Time',
                        theme: 'jnoty-danger',
                        life: 3000,
                    });
                }

                if (response == 4) {
                    $.jnoty("Please Input End Time", {
                        header: 'Input End Time',
                        theme: 'jnoty-danger',
                        life: 3000,
                    });
                }

                if (response == 1) {
                    $("#editReservation").modal('hide');
                    $.jnoty("Your Reservation Updated", {
                        header: 'Reservation Updated',
                        theme: 'jnoty-success',
                        life: 3000,
                    });
                    $("#reloadTableData").trigger('click');
                }
            }
        });
    });

    $("#start_time_input2").on('change', function() {
        var inputTime = $(this).val();
        displayEndTime(inputTime);
    });

    setTimeout(function() {
        displayEndTime($("#start_time_input2").val());
    }, 100);

    function displayEndTime(inputTime) {
        $.ajax({
            type: 'POST',
            url: 'reservation_functions.php',
            data: {
                'getEndTime': 1,
                'inputTime': inputTime,
                'resDay': resDay,
                'scheduleId': scheduleId
            },
            success: function(response) {
                $("#endTimeSelect2").html(response);
            }
        });
    }
</script>