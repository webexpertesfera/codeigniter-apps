<!--RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li><a href="human_resource/hr_employee">Employee</a></li><li>Create</li>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="page-title txt-color-blueDark dashboard-title">
                        <i class="fa fa-user-md"></i>
                       Employee Create
                    </h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <a href="human_resource/hr_employee"><button class="btn btn-md btn-success"><i class="fa fa-list"></i> Employee List</button></a>
                </div>
            </div>


            <!--- form submit notification---->
            <?php $this->load->view('alert'); ?>

            <!-- widget grid -->
            <section id="widget-grid" class="reset-change create">

                <!-- row -->
                <div class="row">

                    <!-- NEW COL START -->
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget cstm-appcnt" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                    <h2>New Employee</h2>
                </header>

                <!-- widget div-->

                <div class="appcontent-inner">

                    <!-- widget content -->
                    <div class="widget-body">

                       <?php
                            $attributes = ['id' => 'new_employee','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('human_resource/hr_employee/create', $attributes);
                            ?>
                        <div class="row">
                            <div class="col-md-6">
                             <label class="control-label">Full Name<span class="require">*</span></label> 
                             <div class="form-group">
                                <input type="text" class="form-control" id="employee_full_name"  placeholder="Full Name" required value="<?php echo set_value('first_name'); ?>" name="first_name"  maxlength="200" minlength="4" />
                            </div>
                        </div>                        

                        <div class="col-md-6">
                            <div class="form-group">
                             <label class="control-label  phone-label">Phone Number <span class="require">*</span></label>
                                <div class="col-md-3" style="padding-left: 0px;">
                                    <select name="country_code" id="countryCode">
                                              <?php $cnty = country_code(); // Assuming this returns an array of country codes
                                             if (!empty($cnty)) {
                                                 foreach ($cnty as $key => $value) {
                                                     // Check if the current country code is Nigeria's code (234)
                                                     // and set it as selected by default
                                                     $selected = ($key == '234') ? 'selected' : '';
                                                     ?>
                                                     <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo '+' . $key; ?></option>
                                                     <?php
                                                 }
                                             }
                                             ?>
                             </select>
                                </div>                            
                                <div class="col-md-9" style="padding-left: 0px;padding-right: 0px;">
                                    <input type="text" name="mobile_no" class="form-control" placeholder="Enter You Phone Number" required="required" maxlength="15" minlength="10" onkeypress="return isNumber(event)" value="<?php echo set_value('mobile_no'); ?>">
                                </div>
                            </div>
                        </div>

                        

                       <div class="col-md-6">
                   <label class="control-label">Gender</label>
                            <select class="form-control" name="gender" id="gender" required="required">
                                <option value="">Select</option>
                                <option <?php echo set_select('gender', 1, False); ?> value="1">Male</option>
                                <option <?php echo set_select('gender', 2, False); ?> value="2">Female</option>
                                <option <?php echo set_select('gender', 3, False); ?> value="3">Other</option>
                            </select>
                        </div>
                    

                    <div class="col-md-6">
                      <label class="control-label">Date of Birth<span class="require">*</span></label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="birth_date" autocomplete="off" required placeholder="Date of Birth" value="<?php echo set_value('birth_date'); ?>" name="birth_date"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <label class="control-label">Address<span class="require">*</span></label> 
                        <div class="form-group">
                            <input type="text" placeholder="Address" name="present_address" id="address-input" value="<?php echo set_value('present_address'); ?>" class="form-control map-input" autocomplete="off" required/>
                            <input type="hidden" name="address_latitude" id="address-latitude" value="" />
                            <input type="hidden" name="address_longitude" id="address-longitude" value="" />
                    
                           <div id="address-map-container" style="display: none;">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                        </div>
                    </div>

                   <!--  <div class="col-md-6">
                          <label class="control-label">Country<span class="require">*</span></label> 
                     <div class="form-group">
                                     <input type="text" name="country" id="current_country_iso" readonly="readonly" value="<?php echo $cntry; ?>" class="form-control">
                            </div>
                   </div>
 -->

                   <!-- <div class="clearfix"></div> -->

                <div class="col-md-6">
                  <label class="control-label">Email<span class="require">*</span></label>
                     <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" required value="<?php echo set_value('email'); ?>" name="email"/>
                    </div>
                </div> 
                <div class="col-md-6">
                    <label class=" control-label">Password<span class="require">*</span></label>
                     <div class="form-group">
                       <input type="password" class="form-control" placeholder="Password" required value="<?php echo set_value('password'); ?>" name="password"/>
                    </div>
                </div> 
                <div class="col-md-6">
                     <label class="control-label">Confirm Password<span class="require">*</span></label> 
                     <div class="form-group">
                         <input type="password" class="form-control" placeholder="Confirm Password" required value="<?php echo set_value('password_conf'); ?>" name="password_conf"/>
                    </div>
                </div> 
               

                <div class="col-md-6">
                    <label class="control-label">Profile Picture<span class="require">*</span></label>
                    <div class="form-group">
                        <input type="file" class="form-control" id="imgInp" accept="image/*" name="picture" required="required" />
                        <br>
                        <img id='img-upload' />
                    </div>

                    <label class="control-label">Is Admin?</label>
                    <div class="checkbox">
                        <label><input type="checkbox" name="is_admin">Yes</label>
                    </div>
                               
                </div>

                <div class="col-md-6">
                     <label class="control-label">Timezone<span class="require">*</span></label>
                <select class="form-control form-field1" name="timezone" id="timezone" required="required">
                            <option value="">Select Timezone</option>
                           <?php
                           $timezones = timezone_identifiers_list();
                           $defaultTimezone = 'Africa/Lagos'; // Set default timezone
                           foreach ($timezones as $timezone) {
                               // Check if the current timezone is the default timezone
                               $selected = ($timezone == $defaultTimezone) ? 'selected' : '';
                               echo "<option value=\"$timezone\" $selected>$timezone</option>";
                           }
                           ?>
                       </select>
                   </div>

            </div>

               </div>





            <div class="form-actions">
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">

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
<!-- END CONTENT