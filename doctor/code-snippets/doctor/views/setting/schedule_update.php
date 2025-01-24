<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctor</li><li><a href="doctor/schedule">Doctors Schedule</a></li><li>Schedule</li>
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
                Appointment Schedule Update
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <a href="doctor/schedule"><button class="btn btn-md btn-success"><i class="fa fa-hand-o-left"></i> Schedule List</button></a>
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
                        <h2>Update Schedule</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">

                            <?php
                            $attributes = ['id' => 'doctor_schedule','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('doctor/schedule/update', $attributes);
                            ?>

                            <?php
                            // admin create doctor schedule

                            if($this->session->userdata('is_admin')==1) { ?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Doctor</label>
                                    <div class="col-md-8">
                                        <select class="select2" required name="doctor">
                                            <option value="">Select Doctor</option>
                                            <?php foreach($doctor as $value) { ?>
                                                <option <?php echo  $value->doctor_id==$doctor_id?'Selected':''; ?>  value="<?php echo $value->doctor_id; ?>"><?php echo $value->full_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Day</label>
                                <div class="col-md-8">
                                    <select class="form-control" required name="day">
                                        <option value="">Select Day</option>
                                        <option <?php echo $day_id==1?'selected':''; ?> <?php echo set_select('day', 1, False); ?> value="1">Saturday</option>
                                        <option <?php echo $day_id==2?'selected':''; ?> <?php echo set_select('day', 2, False); ?> value="2">Sunday</option>
                                        <option <?php echo $day_id==3?'selected':''; ?> <?php echo set_select('day', 3, False); ?> value="3">Monday</option>
                                        <option <?php echo $day_id==4?'selected':''; ?> <?php echo set_select('day', 4, False); ?> value="4">Tuesday</option>
                                        <option <?php echo $day_id==5?'selected':''; ?> <?php echo set_select('day', 5, False); ?> value="5">Wednesday</option>
                                        <option <?php echo $day_id==6?'selected':''; ?> <?php echo set_select('day', 6, False); ?> value="6">Thursday</option>
                                        <option <?php echo $day_id==7?'selected':''; ?> <?php echo set_select('day', 7, False); ?> value="7">Friday</option>
                                    </select>
                                </div>
                            </div>

                            <div id="first_schedule">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Schedule</label>
                                    <div class="col-md-2">
                                        <button type="button" id="first_btn" onclick="addScheduleSlot()" class="btn btn-info"><i class="fa fa-plus"></i> Add Schedule</button>
                                    </div>
                                </div>
                                <?php foreach($data as $value) { ?>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-2">
                                            <input type="text" placeholder="Start Time" required class="form-control timepicker" name="start_time[]" value="<?php echo date("h:i:A",strtotime($value->start_time)); ?>"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" placeholder="End Time" required class="form-control timepicker" name="end_time[]" value="<?php echo date("h:i:A",strtotime($value->end_time)); ?>"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" placeholder="Visitor" required class="form-control" name="visitor[]" value="<?php echo $value->maximum_visitor; ?>"/>
                                            <input type="hidden" class="form-control" name="id[]" value="<?php echo $value->id; ?>"/>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" onclick="slot_remove_with_dependency(<?php echo $value->id; ?>,this)" class="btn btn-danger remove_schedule"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="hidden" name="day_id" value="<?php echo $day_id; ?>"/>
                                        <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>"/>
                                        <input type="hidden" name="remove_ids" id="remove_ids" value=""/>
                                    </div>
                                    <div class="col-md-3">

                                        <button class="btn-md btn btn-primary" name="submit" type="submit">Update
                                        </button>

                                        <a href="doctor/schedule">
                                            <button class="btn-md btn btn-danger" name="back" type="button">
                                                Back
                                            </button>
                                        </a>

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