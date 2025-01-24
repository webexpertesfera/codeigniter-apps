<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctor</li><li><a href="doctor/schedule_block">Schedule Block</a></li><li>Update</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

</div>
<!-- END RIBBON -->

<!--CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-user-md"></i>
                Update Schedule Block
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <a href="doctor/schedule_block"><button class="btn btn-md btn-success"><i class="fa fa-hand-o-left"></i> Schedule Block List</button></a>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>
    </br>

    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <!-- widget grid -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW COL START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-9">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                    <!-- widget options:
                    usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                    data-widget-colorbutton="false"
                    data-widget-editbutton="false"
                    data-widget-togglebutton="false"
                    data-widget-deletebutton="false"
                    data-widget-fullscreenbutton="false"
                    data-widget-custombutton="false"
                    data-widget-collapsed="true"
                    data-widget-sortable="false"
                    -->

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user-md"></i> </span>
                        <h2>Update Schedule Block</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">

                            <?php
                            $attributes = ['id' => 'update_schedule_block','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('doctor/schedule_block/update', $attributes);
                            ?>

                            <?php
                            // admin create doctor schedule

                            if($this->session->userdata('is_admin')==1) { ?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Doctor</label>
                                    <div class="col-md-8">
                                        <select class="form-control" onchange="load_doctor_schedule(from_date.value,to_date.value);" required id="doctor_id" name="doctor">
                                            <option value="">Select Doctor</option>
                                            <?php foreach($doctor as $value) { ?>
                                                <option  <?php echo $data->doctor_id==$value->doctor_id?'selected':''; ?> value="<?php echo $value->doctor_id; ?>"><?php echo $value->full_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label">From Date</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control date_picker" value="<?php echo $data->from_date; ?>" onchange="load_doctor_schedule(this.value,to_date.value);" placeholder="From Date" name="from_date" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">To Date</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control date_picker" value="<?php echo $data->to_date; ?>" onchange="load_doctor_schedule(from_date.value,this.value);" placeholder="To Date" name="to_date" required/>
                                </div>
                            </div>

                            <div id="schedule_div">

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><b>Block all</b></label>
                                    <div class="col-md-8">
                                        <input type="checkbox" name="all_slot" <?php echo $data->is_all==1?'checked':''; ?> onclick="all_slot_check(this);" id="all_slot" value="1" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><b>Schedule</b></label>
                                    <div class="col-md-8">
                                        <p class="doctor_schedule_list">Doctor schedule list for selected date</p>
                                        <table class="table table-bordered table-hover table-striped">
                                            <tr>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Appointment Schedule</th>
                                            </tr>
                                            <?php foreach($get_day as $day_id => $day_data) {

                                                if(isset($schedule[$day_id])) { ?>
                                                    <tr>
                                                        <td><?php echo $day_data['date']; ?></td>
                                                        <td><?php echo $day_data['day']; ?></td>
                                                        <td>

                                                            <table class="table">

                                                                <?php $i=1; foreach($schedule[$day_id] as $value) { ?>
                                                                    <tr>
                                                                        <td><input type="checkbox" name="day_id[]" onclick="single_check();" <?php echo $data->is_all==1?'checked':in_array($value->id,$selected_schedule)?'checked':''; ?>  class="single_slot" value="<?php echo $value->id; ?>"/> </td>
                                                                        <td>Slot-<?php echo $i; ?> <i class="fa fa-hand-o-right"></i></td>
                                                                        <td><?php echo date("H:i:A",strtotime($value->start_time)); ?></td>
                                                                        <td><i class="fa fa-arrow-circle-o-right"></i></td>
                                                                        <td><?php echo date("H:i:A",strtotime($value->end_time)); ?></td>
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

                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Reason</label>
                                <div class="col-md-8">
                                    <textarea name="reason" class="form-control" placeholder="Reason"><?php echo $data->reason; ?></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="id" value="<?php echo $data->id; ?>"/>

                                        <button class="btn-md btn btn-primary" name="submit" type="submit">Save
                                        </button>

                                        <button class="btn-md btn btn-danger" name="reset" type="reset">
                                            Reset
                                        </button>

                                    </div>
                                </div>
                            </div>

                            </form>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!--- COL END ---->

        </div>
        <!-- end row -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END CONTENT -->