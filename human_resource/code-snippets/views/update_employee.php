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
                    <h1 class="page-title txt-color-blueDark  dashboard-title">
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
           <section id="widget-grid" class="reset-change update">

            <!-- row -->
            <div class="row">

                <!-- NEW COL START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget  cstm-appcnt update-emp" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                     echo form_open_multipart('human_resource/hr_employee/update', $attributes);
                     ?>
                     <div class="row">
                        <div class="col-md-6">
                           <label class="control-label">Full Name<span class="require">*</span></label> 
                           <div class="form-group">
                               <input type="text" class="form-control" placeholder="Full Name" required value="<?php echo AesCipher::decrypt($data->first_name); ?>" name="first_name" id="employee_full_name" maxlength="200" minlength="4" />
                            </div>
                        </div>                        

                    <div class="col-md-6">
                        <div class="form-group">
                      <label class="control-label phone-label">Phone Number <span class="require">*</span></label> 
                            <div class="col-md-3" style="padding-left: 0px;">
                                <select class="form-control select2bs4" name="country_code" id="country_code" required>
                                    <option value="">Select</option>

                                    <?php $cnty = country_code();
                                    if(!empty($cnty))
                                    {
                                        foreach($cnty as $key =>$value)
                                        {

                                            ?>
                                            <option value="<?php echo $key;?>" <?php echo AesCipher::decrypt($data->country_code) == $key?'selected':''; ?>><?php echo '+'.$key;?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                            
                            <div class="col-md-9" style="padding-left: 0px;padding-right: 0px;">
                                <input type="text" name="mobile_no" class="form-control" placeholder="Enter You Phone Number" required="required" maxlength="15" minlength="10" onkeypress="return isNumber(event)" value="<?php echo AesCipher::decrypt($data->mobile_no); ?>">
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <label class="control-label">Gender<span class="require">*</span></label> 
                        <div class="form-group">
                            <select class="form-control" name="gender" required>
                             <option value="">Select</option>
                             <option <?php echo $data->gender==1?'selected':false; ?> <?php echo set_select('gender', 1, False); ?> value="1">Male</option>
                             <option <?php echo $data->gender==2?'selected':false; ?> <?php echo set_select('gender', 2, False); ?> value="2">Female</option>
                             <option <?php echo $data->gender==3?'selected':false; ?> <?php echo set_select('gender', 3, False); ?> value="3">Other</option>
                         </select>
                     </div>
                 </div>

                 <div class="col-md-6">
                    <label class="control-label">Date of Birth<span class="require">*</span></label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="birth_date" autocomplete="off" required placeholder="Birth Date" value="<?php echo $data->birth_date; ?>" name="birth_date" readonly/>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="control-label">Address<span class="require">*</span></label>
                    <div class="form-group  update-address">
                        <!-- <textarea name="present_address" placeholder="Present Address" id="present_address" required class="form-control" onKeyUp="copyaddress(this)"><?php echo AesCipher::decrypt($data->present_address); ?></textarea> -->

                        <input type="text" placeholder="Present Address" name="present_address" id="address-input" value="<?php echo AesCipher::decrypt($data->present_address); ?>" class="form-control map-input" autocomplete="off" required/>

                                  <input type="hidden" name="address_latitude" id="address-latitude" value="<?php  if($data->latitude == ''){ echo '';}else{ echo $data->latitude;};?>" />
                           <input type="hidden" name="address_longitude" id="address-longitude" value="<?php  if($data->longitude == ''){ echo '';}else{ echo $data->longitude;};?>" />
                           
                           <br>
                           <div id="address-map-container" style="display: none;">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                    </div>
                </div>
               <!--  <div class="col-md-6">
                     <label class="control-label">Country<span class="require">*</span></label>
                   <div class="form-group">
                    <select class="form-control" name="country" id="country" required>
                        <option value="">Select Country</option>
                          <option value="all" <?php echo $data->country == 'all'?'selected':''; ?>>All</option>
                        <?php $cnty = country();
                        if(!empty($cnty))
                        {
                            foreach($cnty as $key)
                            {
                                ?>
                                <option value="<?php echo $key;?>" <?php echo $data->country == $key?'selected':''; ?>><?php echo $key;?></option>

                            <?php }
                        }
                        ?>
                    </select>
                </div>
            </div>
 -->

            <div class="col-md-6">
             <label class=" control-label">Email<span class="require">*</span></label>
               <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required value="<?php echo AesCipher::decrypt($data->email); ?>" name="email"/>
            </div>
        </div> 
        <div class="col-md-6">
          <label class="control-label">Status<span class="require">*</span></label>
           <div class="form-group">
             <select class="form-control" name="status" required>
                <option value="">Select</option>
                <option <?php echo $data->is_active==1?'selected':''; ?> value="1">Active</option>
                <option <?php echo $data->is_active==2?'selected':''; ?> value="2">Inactive</option>
            </select>
        </div>
    </div> 

   <input type="hidden" name="id" value="<?php echo $data->id ?>"/>
                                        <input type="hidden" name="user_id" value="<?php echo $data->user_id ?>"/>

    <div class="col-md-6">
        <label class="control-label">Profile Picture</label> 
        <div class="form-group">
            <input type="file" class="form-control" id="imgInp" accept="image/*" name="picture"/>
            <br>
            <img src="<?php echo base_url('upload/employee/'.$data->image);?>" id='img-upload' style="width: 140px; height: 140px;" />
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