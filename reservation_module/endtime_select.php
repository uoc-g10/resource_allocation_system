<?php if ($invalid >= 0) { ?>
    <label for="mobile_edit" class="col-sm-2 control-label">End Time</label>
    <div class="col-sm-4">
        <input id="input_from2" class="end_time form-control" type="time" name="end_time" required>
    </div>
<?php } else { ?>
    <div class="col-sm-6">
        <div class="alert alert-danger">
            Can not Reserve this time range
        </div>
    </div>
<?php } ?>

<script>
    var endStart = <?php echo $endStart; ?>;
    var disableTimesEnd = <?php echo $disableTimesEnd; ?>;
    var selectedMinites = <?php echo $selectedMinites; ?>;
    var stopEndTimes = <?php echo $stopEndTimes; ?>;
    var selectedEndMinites = <?php echo $selectedEndMinites; ?>;

    console.log(selectedEndMinites);

    var $end_time_picker = $('.end_time').pickatime({
        editable: false,
        hiddenName: true,
        hiddenPrefix: 'prefix__',
        hiddenSuffix: '__suffix',
        clear: '',
        interval: 30,
        min: endStart,
        max: stopEndTimes,
        disable: disableTimesEnd,
        formatLabel: function(time) {
            //console.log(this.get('now').pick);
            var hours = (time.pick - selectedMinites) / 60,
                label = hours < 0 ? ' !hours' : hours > 0 ? ' !hours' : 'now'
            return 'h:i A <sm!all cl!ass="pull-r!ig!ht">' + (hours ? Math.abs(hours) : '') + label + '</sm!all>'
        }
    });

    var end_time_picker = $end_time_picker.pickatime('picker');
    if (selectedEndMinites) {
        end_time_picker.set('select', selectedEndMinites);
    }
</script>