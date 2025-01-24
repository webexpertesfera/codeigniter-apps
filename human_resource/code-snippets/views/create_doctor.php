<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li><a href="human_resource/doctors">Doctors</a></li><li>Create</li>
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
                Doctor Create
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a href="human_resource/doctors"><button class="btn btn-md btn-success list-btn"><i class="fa fa-list"></i> Doctor List</button></a>
        </div>
    </div>


    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <!-- widget grid -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW COL START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

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
                        <h2>New Doctor</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">

                            <?php
                            $attributes = ['id' => 'new_employee','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('human_resource/doctors/create', $attributes);
                            ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label">First Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="First Name" required value="<?php echo set_value('first_name'); ?>" name="first_name"/>
                                </div>
                                <label class="col-md-2 control-label">Last Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Last Name" required value="<?php echo set_value('last_name'); ?>" name="last_name"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Mobile No</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" required placeholder="Mobile No"  value="<?php echo set_value('mobile_no'); ?>" name="mobile_no"/>
                                </div>
                                <label class="col-md-2 control-label">Gender</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="gender" required>
                                        <option value="">Select</option>
                                        <option <?php echo set_select('gender', 1, False); ?> value="1">Male</option>
                                        <option <?php echo set_select('gender', 2, False); ?> value="2">Female</option>
                                        <option <?php echo set_select('gender', 3, False); ?> value="3">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Present Address</label>
                                <div class="col-md-3">
                                    <textarea name="present_address" placeholder="Present Address" required class="form-control"><?php echo set_value('present_address'); ?></textarea>
                                </div>
                                <label class="col-md-2 control-label">Permanent Address</label>
                                <div class="col-md-3">
                                    <textarea name="permanent_address" placeholder="Permanent Address" required class="form-control"><?php echo set_value('permanent_address'); ?></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label">Birth Date</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="birth_date" autocomplete="off" required placeholder="Birth Date" value="<?php echo set_value('birth_date'); ?>" name="birth_date"/>
                                </div>
                                <label class="col-md-2 control-label">Emergency Contact</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Emergency Contact" required value="<?php echo set_value('emergency_contact'); ?>" name="emergency_contact"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label">Department</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="department" required>
                                        <option value="">Select</option>
                                        <?php foreach($hr_doctor_department as $value) { ?>
                                            <option <?php echo set_select('department', $value->id, False); ?> value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label">Designation</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="designation" required>
                                        <option value="">Select</option>
                                        <?php foreach($hr_doctor_designation as $value) { ?>
                                            <option <?php echo set_select('designation', $value->id, False); ?> value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Biography</label>
                                <div class="col-md-8">
                                    <textarea  name="biography" placeholder="Biography" class="form-control"><?php echo set_value('biography'); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Educational Qualification</label>
                                <div class="col-md-3">
                                    <textarea name="education_qualification" placeholder="Educational Qualification" class="form-control"><?php echo set_value('education_qualification'); ?></textarea>
                                </div>
                                <label class="col-md-2 control-label">Medical Degree</label>
                                <div class="col-md-3">
                                    <textarea name="medical_degree" placeholder="Medical Degree" class="form-control"><?php echo set_value('medical_degree'); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Specialist</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Specialist" required value="<?php echo set_value('specialist'); ?>" name="specialist"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-8">
                                    <input type="checkbox" onclick="check_doctor_prescription_allow(this)" <?php echo set_checkbox('allow_prescription_fees', '1'); ?>  name="allow_prescription_fees" value="1"/> Allow prescription fees
                                </div>
                            </div>
                            <div id="doctor_prescription_setting_div">
                                <?php if(isset($_POST['allow_prescription_fees'])) { ?>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Prescription Fees</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="prescription_fees" value="<?php echo set_value('prescription_fees'); ?>"  placeholder="Prescription Fees" value="" name="prescription_fees"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Payment</label>
                                        <div class="col-md-5">
                                             <label class="radio radio-inline">
                                                <input type="radio"  id="with_appointment"  placeholder="Prescription Fees" <?php
                                                echo set_value('payment_with') == 1 ? "checked" : "";
                                                ?> value="1" name="payment_with"/> Receive By Hospital With Appointment
                                             </label>
                                            <label class="radio radio-inline">
                                                <input type="radio"  id="with_prescription" <?php
                                                echo set_value('payment_with') == 2 ? "checked" : "";
                                                ?>  placeholder="Prescription Fees" value="2" name="payment_with"/> Receive By Doctor With Prescription
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Email</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Email" required value="<?php echo set_value('email'); ?>" name="email"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Password</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Password" required value="<?php echo set_value('password'); ?>" name="password"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Confirm Password</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Confirm Password" required value="<?php echo set_value('password_conf'); ?>" name="password_conf"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Picture</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" required accept="image/*" name="picture"/>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-3">

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

