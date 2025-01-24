
<div class="form-group">
    <label class="col-md-2 control-label"><b>Select all</b></label>
    <div class="col-md-8">
        <input type="checkbox" name="all_slot" onclick="all_slot_check(this);" id="all_slot" value="1" class="form-control"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><b>Schedule</b></label>
    <div class="col-md-8">
        <p class="doctor_schedule_list">Doctor Appointment Schedule</p>
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Appointment Schedule</th>
            </tr>
            <?php foreach($get_day as $day_id => $data) {

                 if(isset($schedule[$day_id])) { ?>
            <tr>
                <td><?php echo $data['date']; ?></td>
                <td><?php echo $data['day']; ?></td>
                <td>

                    <table class="table">

                        <?php $i=1; foreach($schedule[$day_id] as $value) { ?>
                            <tr>
                                <td><input type="checkbox" name="day_id[]" onclick="single_check();" class="single_slot" value="<?php echo $value->id; ?>"/> </td>
                                <td>Slot-<?php echo $i; ?> <i class="fa fa-hand-o-right"></i></td>
                                <td><?php echo date("h:i:A",strtotime($value->start_time)); ?></td>
                                <td><i class="fa fa-arrow-circle-o-right"></i></td>
                                <td><?php echo date("h:i:A",strtotime($value->end_time)); ?></td>
                                <td><?php echo $value->maximum_visitor; ?></td>
                            </tr>
                        <?php $i++; } ?>
                    </table>


                </td>
            </tr>
            <?php } } ?>
        </table>
    </div>
</div>