<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li><a href="human_resource/doctors">Doctor</a></li><li>Update</li>
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
                <i class="fa fa-user "></i>
                Doctor Update
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
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Update doctor</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">

                            <?php
                            $attributes = ['id' => 'update_doctor','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('human_resource/doctors/update', $attributes);
                            ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label">First Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="First Name" required value="<?php echo $data->first_name; ?>" name="first_name"/>
                                </div>
                                <label class="col-md-2 control-label">Last Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Last Name" required value="<?php echo $data->last_name; ?>" name="last_name"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Mobile No</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Mobile No" required value="<?php echo $data->mobile_no; ?>" name="mobile_no"/>
                                </div>
                                <label class="col-md-2 control-label">Gender</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="gender" required>
                                        <option value="">Select</option>
                                        <option <?php echo $data->gender==1?'selected':false; ?> <?php echo set_select('gender', 1, False); ?> value="1">Male</option>
                                        <option <?php echo $data->gender==2?'selected':false; ?> <?php echo set_select('gender', 2, False); ?> value="2">Female</option>
                                        <option <?php echo $data->gender==3?'selected':false; ?> <?php echo set_select('gender', 3, False); ?> value="3">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Present Address</label>
                                <div class="col-md-3">
                                    <textarea name="present_address" placeholder="Present Address" required class="form-control"><?php echo $data->present_address; ?></textarea>
                                </div>
                                <label class="col-md-2 control-label">Permanent Address</label>
                                <div class="col-md-3">
                                    <textarea name="permanent_address" placeholder="Permanent Address" required class="form-control"><?php echo $data->permanent_address; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Birth Date</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="birth_date" autocomplete="off" required placeholder="Birth Date" value="<?php echo $data->birth_date; ?>" name="birth_date"/>
                                </div>
                                <label class="col-md-2 control-label">Emergency Contact</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Emergency Contact" required value="<?php echo $data->emergency_contact_number; ?>" name="emergency_contact"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Department</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="department" required>
                                        <option value="">Select</option>
                                        <?php foreach($doctor_department as $value) { ?>
                                            <option <?php echo $value->id==$data->hospital_department_id?'selected':false; ?> value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label">Designation</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="designation" required>
                                        <option value="">Select</option>
                                        <?php foreach($doctor_designation as $value) { ?>
                                            <option <?php echo $value->id==$data->doctor_designation_id?'selected':false; ?> value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Educational Qualification</label>
                                <div class="col-md-3">
                                    <textarea name="education_qualification" placeholder="Educational Qualification" class="form-control"><?php echo $data->education_qualification; ?></textarea>
                                </div>
                                <label class="col-md-2 control-label">Medical Degree</label>
                                <div class="col-md-3">
                                    <textarea name="medical_degree" placeholder="Medical Degree" class="form-control"><?php echo $data->medical_degree; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Biography</label>
                                <div class="col-md-8">
                                    <textarea  name="biography" placeholder="Biography" class="form-control"><?php echo $data->biography; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Specialist</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Specialist" required value="<?php echo $data->specialist; ?>" name="specialist"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-8">
                                    <input type="checkbox" onclick="check_doctor_prescription_allow(this)" <?php echo $data->fee_is_applicable==1?'checked':''; ?>  name="allow_prescription_fees" value="1"/> Allow prescription fees
                                </div>
                            </div>

                            <div id="doctor_prescription_setting_div">
                                <?php if($data->fee_is_applicable==1 || isset($_POST['allow_prescription_fees'])) { ?>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Prescription Fees</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="prescription_fees" value="<?php echo $data->prescription_fees; ?>"  placeholder="Prescription Fees"  name="prescription_fees"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Payment</label>
                                        <div class="col-md-5">
                                            <label class="radio radio-inline">
                                                <input type="radio"  id="with_appointment"  placeholder="Prescription Fees" <?php
                                                echo $data->fee_payment == 1 ? "checked" : "";
                                                ?> value="1" name="payment_with"/> With Appointment
                                            </label>
                                            <label class="radio radio-inline">
                                                <input type="radio"  id="with_prescription" <?php
                                                echo $data->fee_payment == 2 ? "checked" : "";
                                                ?>  placeholder="Prescription Fees" value="2" name="payment_with"/> With Prescription
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Email</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="email" value="<?php echo $data->email; ?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Status</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="status" required>
                                        <option value="">Select</option>
                                        <option <?php echo $data->is_active==1?'selected':''; ?> value="1">Active</option>
                                        <option <?php echo $data->is_active==2?'selected':''; ?> value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Picture</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" accept="image/*" name="picture"/>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="id" value="<?php echo $data->id ?>"/>
                                        <input type="hidden" name="user_id" value="<?php echo $data->user_id ?>"/>
                                        <button class="btn-md btn btn-primary" name="submit" type="submit">Update
                                        </button>
                                        <a href="human_resource/doctors">
                                            <button class="btn-md btn btn-danger" name="back" type="button">Back
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

