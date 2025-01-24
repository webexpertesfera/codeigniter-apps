<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctor</li><li><a href="doctor/doctors">Doctors</a></li><li>Create</li>
    </ol>
  
        </div>
        <div id="content">

            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark">
                        <i class="fa fa-user-md"></i>
                        Doctor Create
                    </h1>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                    <a href="doctor/doctors"><button class="btn btn-md btn-success list-btn"><i class="fa fa-list"></i> Doctors List</button></a>
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
                        <div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                        $attributes = ['id' => 'new_patient','method'=>'post','class'=>'form-horizontal'];
                        echo form_open_multipart('doctor/doctors/create', $attributes);
                        ?>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Full Name <span class="require">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" placeholder="Full Name" required value="<?php echo set_value('first_name'); ?>" name="first_name" onkeypress="return isText(event)" maxlength="200" minlength="4"/>
                            </div>
                        </div>
                           <div class="form-group">
                    <label class="col-md-2 control-label">Email <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" placeholder="Email" required value="<?php echo set_value('email'); ?>" name="email"/>
                    </div>
                </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">IC No.(Identity card No.) <span class="require">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" placeholder="IC No.(Identity card No.)" required value="<?php echo set_value('ic_no'); ?>" name="ic_no"/>
                            </div>
                        </div>

                          <!--   <div class="form-group">
                                <label class="col-md-2 control-label">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Last Name" required value="<?php //echo set_value('last_name'); ?>" name="last_name"/>
                                </div>
                            </div>  -->
                            <div class="form-group">
                             <label class="col-md-2 control-label">Phone Number <span class="require">*</span></label>
                             <div class="col-md-8">
                              <div class="col-md-3">
                                <select class="form-control select2bs4" name="country_code" id="country_code" required>
                                 <option value="">Select</option>
                               
                            <?php $cnty = country_code();
                            if(!empty($cnty))
                            {
                                foreach($cnty as $key =>$value)
                                {
                                    ?>
                                    <option <?php echo set_select('country_code', $key, False); ?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                    
                                <?php
                            }
                            }
                            ?>
                             </select>
                         </div>                            
                         <div class="col-md-9">
                            <input type="text" name="phone_no" class="form-control" placeholder="Enter You Phone Number" required="required" maxlength="15" minlength="10" onkeypress="return isNumber(event)" value="<?php echo set_value('phone_no'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Gender <span class="require">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="gender" required>
                            <option value="">Select</option>
                            <option <?php echo set_select('gender', 1, False); ?> value="1">Male</option>
                            <option <?php echo set_select('gender', 2, False); ?> value="2">Female</option>
                            <option <?php echo set_select('gender', 3, False); ?> value="3">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Hospital Department <span class="require">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="hospital_department_id" required>
                            <option value="">Select</option>
                            <?php if(!empty($Department))
                            {
                                foreach($Department as $key)
                                {
                                    ?>
                                    <option <?php echo set_select('hospital_department_id', $key->id, False); ?> value="<?php echo $key->id;?>"><?php echo $key->name;?></option>
                                   
                                    <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Speciality <span class="require">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="doctor_designation_id" required>
                            <option value="">Select</option>
                            <?php if(!empty($Designation))
                            {
                                foreach($Designation as $key)
                                {
                                    ?>
                                      <option <?php echo set_select('doctor_designation_id', $key->id, False); ?> value="<?php echo $key->id;?>"><?php echo $key->name;?></option>
                                 
                                    <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Birth Date <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="birth_date" autocomplete="off" required placeholder="Birth Date" value="<?php echo set_value('birth_date'); ?>" name="birth_date" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Residential Address <span class="require">*</span></label>
                    <div class="col-md-8">
                        <textarea name="present_address" placeholder="Residential Address" required class="form-control"><?php echo set_value('present_address'); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Correspondence Address <span class="require">*</span></label>
                    <div class="col-md-8">
                        <textarea name="permanent_address" placeholder="Correspondence Address" required class="form-control"><?php echo set_value('permanent_address'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Country <span class="require">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="country" id="country" required>
                            <option value="">Select Country</option>
                            <?php $cnty = country();
                            if(!empty($cnty))
                            {
                                foreach($cnty as $key)
                                {
                                    ?>
                                     <option <?php echo set_select('country', $key, False); ?> value="<?php echo $key;?>"><?php echo $key;?></option>
                                   
                               <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Registration No. <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Registration No" required value="<?php echo set_value('registration_no'); ?>" name="registration_no"/>
                    </div>
                </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Education <span class="require">*</span></label>
                    <div class="col-md-8">
                        <textarea name="education" placeholder="Education" required class="form-control"><?php echo set_value('education'); ?></textarea>
                    </div>
                </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Current WorkPlace <span class="require">*</span></label>
                    <div class="col-md-8">
                        <textarea name="current_workplace" placeholder="Current WorkPlace" required class="form-control"><?php echo set_value('current_workplace'); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Language</label>
                    <div class="col-md-8">
                        <select class="form-control" name="language" id="language">     
                         <option <?php echo set_select('language', 'uk', False); ?> value="uk">UK</option>
                         <option <?php echo set_select('language', 'egypt', False); ?> value="egypt">Egypt</option> 
                        </select>
                    </div>
                </div>
                                        

                <div class="form-group">
                    <label class="col-md-2 control-label">Profile Picture <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="file" class="form-control" required accept="image/*"  id="imgInp" name="profile_picture"/>
                        <br />
                          <img id='img-upload' style="width: 10%;" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">IC Picture <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="file" class="form-control" required accept="image/*"  id="imgInpp" name="ic_picture"/>
                        <br />
                          <img id='img-uploadd' style="width: 10%;" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Education Certificate <span class="require">*</span></label>
                    <div class="col-md-8">
                        <input type="file" class="form-control" required accept="image/*"  id="imgInppp" name="edu_certificate"/>
                        <br />
                        <img id='img-uploaddd' style="width: 10%;" />
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-4">

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