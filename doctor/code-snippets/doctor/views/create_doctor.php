<!--RIBBON -->
<!--RIBBON -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('frontend/css/jquery.signature.css'); ?>">
<style type="text/css">
    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .form-country select {
        transform: translate(1px, 55%) !important;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-flex;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #03d6fb;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgb(0 0 0 / 12%);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .avatar-upload .avatar-edit input+label:after {
        font-family: 'fontawesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .imagePreview {
        width: 100%;
        height: 180px;
        background-position: center center;
        background-color: #fff;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
    }

    .del {
        position: absolute;
        top: 0px;
        right: 15px;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        background-color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    .imgAdd {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #4bd7ef;
        color: #fff;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
        text-align: center;
        line-height: 30px;
        margin-top: 0px;
        cursor: pointer;
        font-size: 15px;
    }

    button.remove-image {
        position: absolute;
        right: 0;
        z-index: 1;
        top: -15px;
        width: 30px;
        height: 30px;
        background: #007cc6;
        border-radius: 100%;
        padding: 0px;
        display: none;
    }

    button.remove-image img {
        width: 10px;
        filter: brightness(40.5);
    }

    .control-btn10 .form-field2.form-group button.btn {
        border-radius: 30px;
        width: 120px;
        height: 45px;
    }

    .fee-config .accordion-content {
        padding: 30px 45px;
        background: #c5ecfb;
    }

    .fee-config .accordion-content .form-group.one-row {
        display: block;
        width: 100%;
    }

    .cstm-appcnt.update-emp form .row {
        display: block;
        width: 100%;
        margin: 0;
    }

    .card-header h4 {
        font-weight: 600;
        margin-bottom: 20PX;
    }

    input.uploadFile.img {
        background: transparent;
        border: none;
    }


    .imagePreview {
        width: 100%;
        height: 180px;
        background-position: center center;
        background-color: #fff;
        background-size: cover;
        background-repeat: no-repeat;
        display: inline-block;
        box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
    }


    .del {
        position: absolute;
        top: 0px;
        right: 15px;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        background-color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    button.remove-image {
        position: absolute;
        right: 0;
        z-index: 1;
        top: -15px;
        width: 30px;
        height: 30px;
        background: #007cc6;
        border-radius: 100%;
        padding: 0px;
        display: none;
    }

    button.remove-image img {
        width: 10px;
        filter: brightness(40.5);
    }

    p.f-13 {
        font-size: 13px;
    }

    .doctor-row {
        display: flex !important;
    }
</style>

<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip"
            data-placement="bottom"
            data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
            data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctor</li>
        <li><a href="doctor/doctors">Doctors</a></li>
        <li>Create</li>
    </ol>

</div>
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-user-md"></i>
                Doctor Create
            </h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="doctor/doctors"><button class="btn btn-md btn-success"><i class="fa fa-list"></i> Doctors
                    List</button></a>
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
                <div class="jarviswidget cstm-appcnt update-emp" id="wid-id-5" data-widget-colorbutton="false"
                    data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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

                    <div class="appcontent-inner">
                        

                        <!-- widget content -->
                        <div class="widget-body">


                            <form id="new_doctor" method="post" class="form-horizontal"
                                action="<?php echo base_url('doctor/doctors/create'); ?>" enctype="multipart/form-data">
                                <div class="row d-flex doctor-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Full Name <span
                                                    class="require">*</span></label>
                                            <input type="text" class="form-control" placeholder="Full Name" required
                                                value="<?php  ?>" name="first_name" id="employee_full_name"
                                                maxlength="200" minlength="4" />
                                                
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email <span class="require">*</span></label>
                                            <input type="email" class="form-control" placeholder="Email" required
                                                value="<?php ?>" name="email" />
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">ID/ Passport Number <span class="require">*</span></label> 
                                    <input type="text" class="form-control" placeholder="ID/ Passport Number" required value="<?php echo $ic_no; ?>" name="ic_no"/>
                                </div>
                            </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label phone-label">Phone Number <span
                                                    class="require">*</span></label>

                                            <div class="col-md-3" style="padding-left: 0px;">
                                                <select name="country_code" id="countryCode">
                                                    <?php if (!empty($countries)):
                                                        $current_iso = '';
                                                        ?>
                                                        <?php foreach ($countries as $country):
                                                            if ((strtolower($country->nicename) == strtolower(DEFAULT_COUNTRY))) {
                                                                $current_iso = $country->iso;
                                                            }
                                                            ?>
                                                            <option value="<?= $country->phonecode ?>"
                                                                data-country="<?= $country->nicename ?>"
                                                                data-iso="<?= $country->iso ?>"
                                                                <?= (strtolower($country->nicename) == strtolower(DEFAULT_COUNTRY)) ? 'selected' : '' ?>>
                                                                +<?= $country->phonecode . ' (' . $country->iso . ')' ?></option>
                                                        <?php endforeach; ?>
                                                        <input type="hidden" id="current_country_iso"
                                                            value="<?= $current_iso ?>">
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-9" style="padding-left: 0px;padding-right: 0px;">
                                                <input type="text" name="phone_no" class="form-control"
                                                    placeholder="Enter You Phone Number" required="required"
                                                    maxlength="15" minlength="10" onkeypress="return isNumber(event)"
                                                    value="<?php ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" control-label">Gender <span class="require">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="1">Male
                                                </option>
                                                <option value="2" >Female
                                                </option>
                                                <option value="3" >Other
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Category <span class="require">*</span></label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option value="">Select Category</option>
                                                <?php if (!empty($Department)) {
                                                    foreach ($Department as $key) {
                                                        ?>
                                                        <option value="<?php echo $key->id; ?>" selected="selected">
                                                            <?php echo $key->name; ?></option>
                                                    <?php



                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('category').addEventListener('change', function () {
                                            var selectedOption = this.options[this.selectedIndex];
                                            var selectedOptionId = selectedOption.value;
                                            // Do something with the selected option ID
                                            console.log('Selected option ID:', selectedOptionId);
                                        });
                                    </script>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Speciality <span
                                                    class="require">*</span></label>
                                            <select class="form-control" name="speciality[]" id="speciality" required
                                                multiple="multiple">
                                                <?php if (!empty($Designation)) {
                                                    foreach ($Designation as $key) {
                                                        if (in_array($key->id, $speciality)) {
                                                            ?>
                                                            <option value="<?php echo $key->id; ?>" selected="selected">
                                                                <?php echo $key->name; ?></option>
                                                        <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?></option>
                                                            <?php
                                                        }

                                                    }
                                                }
                                                ?>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Date of Birth<span
                                                    class="require">*</span></label>
                                            <input type="text" class="form-control" id="birth_date" autocomplete="off"
                                                required placeholder="Date of Birth" value="<?php  ?>"
                                                name="birth_date" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="control-label">Residential Address <span
                                                class="require">*</span></label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Residential Address" name="present_address"
                                                id="address-input" value="<?php  ?>"
                                                class="form-control map-input" autocomplete="off" required />

                                            <input type="hidden" name="address_latitude" id="address-latitude"
                                                value="<?php ?>" />
                                            <input type="hidden" name="address_longitude" id="address-longitude"
                                                value="<?php ?>" />

                                            <br>
                                            <div id="address-map-container"
                                                style="width:100%;height:270px; display: none;">
                                                <div style="width: 100%; height: 100%" id="address-map"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Correspondence Address <span
                                                    class="require">*</span></label>
                                            <textarea name="permanent_address" placeholder="Correspondence Address"
                                                required class="form-control"><?php  ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6 country-field">
                                        <label class="control-label">Country <span class="require">*</span></label>
                                        <input type="text" placeholder="Country" name="country" id="country"
                                            class="form-control" value="<?= DEFAULT_COUNTRY ?>"  required />
                                    </div>

                                    <div class="col-md-6" style="display : none">
                                        <div class="form-group">
                                            <label class="control-label">Doctor Registration No. <span
                                                    class="require">*</span></label>
                                            <input type="hidden" class="form-control" placeholder="Doctor Registration No"
                                                 value="" name="registration_no" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="control-label">Education <span class="require">*</span></label>
                                        <div class="form-group">
                                            <textarea name="education" placeholder="Education" required
                                                class="form-control"><?php  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Current WorkPlace <span
                                                class="require">*</span></label>
                                        <div class="form-group">
                                            <textarea name="current_workplace" placeholder="Current WorkPlace" required
                                                class="form-control"><?php  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class=" control-label">About Dr: <span
                                                class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <textarea name="aboutus" placeholder="About Dr" required
                                                class="form-control"><?php  ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class=" control-label">Medical Certificate Number: </label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Medical Certificate Number"
                                                name="rcc_no" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class=" control-label">Clinic Interest:</label>
                                        <div class="form-group">
                                            <textarea name="clinic_intrest" placeholder="Clinic Interest"
                                                class="form-control"><?php  ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class=" control-label">Appointment Description:</label>
                                        <div class="form-group">
                                            <textarea name="appointment_description"
                                                placeholder="Appointment Description" class="form-control"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Profile Photo<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input type="file" class="form-control" id="imgInp" required=""
                                                accept="image/*" name="profile_image" />
                                            <br>
                                            <img id='img-upload' />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="control-label">Timezone<span class="text-danger">*</span></label>
                                        <select class="form-control form-field1" name="timezone" id="timezone"
                                            required="required">
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
                                <div class="row w-100 m-auto">
                                    <div class="myacc-inner doc-20 col-12">
                                        <article class="content-entry">
                                            <h2 class="article-title bold"><?php echo "Documents"; ?> <i></i></h2>
                                            <div class="accordion-content">
                                                <div class="row">
                                                    <div class="col-sm-4 imgUp form-group">
                                                        <div class="" style="background-color: #04145f;">
                                                            <div class="imagePreview"
                                                                style="background: url(<?php ?>);width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
                                                                <button class="remove-image btn" type="button"><img
                                                                        src="<?= base_url('frontend/images/letter-x.png') ?>"></button>
                                                            </div>
                                                            <label class="btn btn-primary">
                                                                <?php echo $this->lang->line('ID/ passport Picture'); ?>
                                                                <input type="file" class="uploadFile img" name="ic_pic"
                                                                    id="ic_pic" value="Upload Photo"
                                                                    style="width: 100%;"
                                                                    accept="image/x-png,image/gif,image/jpeg">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 imgUp form-group">
                                                        <div class="" style="background-color: #04145f;">
                                                            <div class="imagePreview"
                                                                style="background: url(<?php ?>); width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
                                                                <button class="remove-image btn" type="button"><img
                                                                        src="<?= base_url('frontend/images/letter-x.png') ?>"></button>
                                                            </div>
                                                            <label class="btn btn-primary">
                                                               <span style="width: 100%;display: block;white-space: break-spaces;font-size: 11px;text-size: revert;">Education Certificate of Speciality/Highest Medical Certificate</span>
                                                                <input type="file" class="uploadFile img"
                                                                    name="education" id="education"
                                                                    value="Upload Photo" style="width: 100%;"
                                                                    accept="image/x-png,image/gif,image/jpeg">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 imgUp form-group">
                                                        <div class="" style="background-color: #04145f;">
                                                            <div class="imagePreview"
                                                                style="background:  url(<?php ?>); width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
                                                                <button class="remove-image btn" type="button"><img
                                                                        src="<?= base_url('frontend/images/letter-x.png') ?>"></button>
                                                            </div>
                                                            <label class="btn btn-primary">
                                                                <?php echo "Medical License"; ?>
                                                                <input type="file" class="uploadFile img"
                                                                    name="medical_license" id="medical_license"
                                                                    value="Upload Photo" style="width: 100%;"
                                                                    accept="image/x-png,image/gif,image/jpeg">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span
                                                    style="color: red;font-size: 11px;"><?php echo $this->lang->line('Image should have jpg, jpeg, png extention and 2MB size.'); ?></span>
                                        </article>
                                    </div>
                                    <div class="card-body">
                              
                                
                                 <div class="col-md-8">
                                  <label class="control-label">Bank Account Details:</label>
                                  <div class="form-group">
                                      <label for="bank_name">Bank Name:</label>
                                      <input type="text" class="form-control" id="bank_name" name="bank_name"  placeholder="Enter bank name">
                                     

                                      <label for="bank_account_name">Account Name:</label>
                                      <input type="text" class="form-control" id="bank_account_name" name="bank_account_name"  placeholder="Enter account name">

                                      <label for="account_number">Account Number:</label>
                                      <input type="text" class="form-control" id="account_number" name="account_number"  placeholder="Enter account number">

                                      <label for="ifsc_code">IFSC Code:</label>
                                      <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"  placeholder="Enter IFSC code">
                                  </div>
                              </div>
                         
                           </div>  
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label">Select Services:</label>
                                    <div class="form-group one-row">
                                        <div class="g-1">
                                            <input type="checkbox" id="chat_service_checkbox" name="service[]"
                                                value="is_chat"> Chat Service
                                        </div>
                                        <div class="g-1">
                                            <input type="checkbox" id="video_service_checkbox" name="service[]"
                                                value="is_video"> Video Service
                                        </div>
                                        <div class="g-1">
                                            <input type="checkbox" id="clinic_service_checkbox" name="service[]"
                                                value="is_clinic"> Clinic Service
                                        </div>
                                      <!--   <div class="g-1">
                                            <input type="checkbox" id="home_service_checkbox" name="service[]"
                                                value="is_home"> Home Service
                                        </div> -->
                                    </div>
                                </div>

                                <script>
                                    // Array to hold the selected services
                                    let selectedServices = [];

                                    // Function to update the selectedServices array
                                    function updateSelectedServices() {
                                        // Clear the array
                                        selectedServices = [];

                                        // Get all checkboxes
                                        const checkboxes = document.querySelectorAll('input[name="service[]"]');

                                        // Loop through checkboxes and add checked ones to the array
                                        checkboxes.forEach((checkbox) => {
                                            if (checkbox.checked) {
                                                selectedServices.push(checkbox.value);
                                            }
                                        });

                                        // Log the array to the console (for debugging purposes)
                                        console.log(selectedServices);
                                    }

                                    // Add event listeners to the checkboxes
                                    document.querySelectorAll('input[name="service[]"]').forEach((checkbox) => {
                                        checkbox.addEventListener('change', updateSelectedServices);
                                    });

                                    // Initialize the array on page load
                                    updateSelectedServices();
                                </script>


                             <div class="myacc-inner doc-20 fee-config">
                              <article class="content-entry">
                                 <h2 class="article-title">
                                    <?php echo $this->lang->line('Fees Configuration'); ?>
                                 </h2>
                                 <div class="accordion-content">
                                    <div class="row w-100">
                                       <div class="col-12 w-100">
                                          <div class="form-group one-row w-100">
                                             <div class="service-slct-inner w-100">
                                                <div class="row consultPriceOuter">
                                                   
                                                   <div id="chat_service_card" class="col-md-6 card-section" style="display: none;">
                                                      <div class="card bg-light">
                                                         <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Chat'); ?></h4>
                                                         </div>
                                                         <div class="card-body">
                                                            <div class="form-group one-row">
                                                               <label><?php echo $this->lang->line('First Time'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="chatFT" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('Follow Up'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="chatFU" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                  
                                                   <div id="video_service_card" class="col-md-6 card-section" style="display: none;">
                                                      <div class="card bg-light">
                                                         <div class="card-header">
                                                            <h4><?php echo "Video"; ?></h4>
                                                         </div>
                                                         <div class="card-body">
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('First Time'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="videoFT" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('Follow Up'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="videoFU" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                  
                                                   <div id="home_service_card" class="col-md-6 card-section" style="display: none;">
                                                      <div class="card bg-light">
                                                         <div class="card-header">
                                                            <h4><?php echo "Home"; ?></h4>
                                                         </div>
                                                         <div class="card-body">
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('First Time'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="homeFT" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('Follow Up'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="homeFU" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   
                                                   <div id="clinic_service_card" class="col-md-6 card-section" style="display: none;">
                                                      <div class="card bg-light">
                                                         <div class="card-header">
                                                            <h4><?php echo "Clinic"; ?></h4>
                                                         </div>
                                                         <div class="card-body">
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('First Time'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="clinicFT" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                            <div class="form-group">
                                                               <label><?php echo $this->lang->line('Follow Up'); ?></label>
                                                               <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                                                                  name="clinicFU" min="10" max="100000"
                                                                  class="form-control"
                                                                  value=""
                                                                  required />
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                  
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                    </div>
                                 </div>
                              </article>
                           </div> 
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        function toggleCard(serviceCheckbox, cardId) {
                                            const checkbox = document.getElementById(serviceCheckbox);
                                            const card = document.getElementById(cardId);

                                            if (checkbox && card) {
                                                card.style.display = checkbox.checked ? 'block' : 'none';

                                                checkbox.addEventListener('change', function () {
                                                    card.style.display = checkbox.checked ? 'block' : 'none';
                                                });
                                            }
                                        }

                                        toggleCard('chat_service_checkbox', 'chat_service_card');
                                        toggleCard('video_service_checkbox', 'video_service_card');
                                        toggleCard('home_service_checkbox', 'home_service_card');
                                        toggleCard('clinic_service_checkbox', 'clinic_service_card');
                                    });
                                </script>


                        </div>



                        <!--   <div class="form-group">
                                <label class="col-md-2 control-label">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="Last Name" required value="<?php //echo set_value('last_name'); ?>" name="last_name"/>
                                </div>
                            </div>  -->
                        <input type="hidden" name="doctor_id" id="doctor_id"
                            value="<?php echo $this->uri->segment(4); ?>">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">

                                    <button class="btn-md btn btn-primary" name="submit" type="submit">Submit
                                    </button>

                                    <button class="btn-md btn  btn-primary btn-danger" name="reset" type="reset">
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