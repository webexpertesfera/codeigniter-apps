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
.row.d-flex.update-dr {
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
         Doctor Update
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
               <?php
                  $name = '';
                  $email = '';
                  $mobile = '';
                  $country_code = '41';
                  $ic_no = '';
                  $gender = '';
                  $dob = '';
                  $r_address = '';
                  $p_address = '';
                  $cntry = '';
                  $rno = '';
                  $edu = '';
                  $cwp = '';
                  $about = '';
                  $ci = '';
                  $is_online = 0;
                  $is_home = 0;
                  $is_clinic = 0;
                  $hospital_department_id = 0;
                  $lat = '';
                  $long = '';
                  $rcc_no = '';
                  $ic_pic = base_url('assets/img/avatars/male.png');
                 
                  if (!empty($doc)) {

                    $name = !empty($doc[0]->first_name) ? (string) (AesCipher::decrypt($doc[0]->first_name) ?: 'N/A') : 'N/A';
                     $id = !empty($doc[0]->doctor_id) ? $doc[0]->doctor_id : 'N/A';
                     $email = !empty($doc[0]->email) ? (string) (AesCipher::decrypt($doc[0]->email) ?: 'N/A') : 'N/A';
                     $mobile = !empty($doc[0]->mobile_no) ? (string) (AesCipher::decrypt($doc[0]->mobile_no) ?: 'N/A') : 'N/A';
                     $country_code = !empty($doc[0]->country_code) ? (string) (AesCipher::decrypt($doc[0]->country_code) ?: 'N/A') : 'N/A';
                     $gender = !empty($doc[0]->gender) ? $doc[0]->gender : 'N/A';
                     $dob = !empty($doc[0]->birth_date) ? $doc[0]->birth_date : 'N/A';
                     $r_address = !empty($doc[0]->present_address) ? (string) (AesCipher::decrypt($doc[0]->present_address) ?: 'N/A') : 'N/A';
                     $p_address = !empty($doc[0]->permanent_address) ? (string) (AesCipher::decrypt($doc[0]->permanent_address) ?: 'N/A') : 'N/A';
                     $lat = !empty($doc[0]->latitude) ? $doc[0]->latitude : 'N/A';
                     $long = !empty($doc[0]->longitude) ? $doc[0]->longitude : 'N/A';
                     $cntry = !empty($doc[0]->country) ? $doc[0]->country : 'N/A';
                     $rno = !empty($doc[0]->registeration_no) ? (string) (AesCipher::decrypt($doc[0]->registeration_no) ?: 'N/A') : 'N/A';
                     $edu = !empty($doc[0]->education_qualification) ? (string) (AesCipher::decrypt($doc[0]->education_qualification) ?: 'N/A') : 'N/A';
                     $cwp = !empty($doc[0]->current_wokplace) ? (string) (AesCipher::decrypt($doc[0]->current_wokplace) ?: 'N/A') : 'N/A';
                     $about = !empty($doc[0]->about) ? (string) (AesCipher::decrypt($doc[0]->about) ?: 'N/A') : 'N/A';
                     $rcc_no = !empty($doc[0]->rcc_no) ? AesCipher::decrypt($doc[0]->rcc_no) : 'N/A';
                     $appointment_description = !empty($doc[0]->appointment_description) ? (string) (AesCipher::decrypt($doc[0]->appointment_description) ?: 'N/A') : 'N/A';
                     $hospital_department_id = !empty($doc[0]->hospital_department_id) ? $doc[0]->hospital_department_id : 'N/A';
                     $ci = !empty($doc[0]->clicnic_intrest) ? (string) (AesCipher::decrypt($doc[0]->clicnic_intrest) ?: 'N/A') : 'N/A';


                      $is_online = $doc[0]->is_online;
                      $is_home = $doc[0]->is_home;
                      $is_clinic = $doc[0]->is_clinic;
                      $is_video = $doc[0]->is_video;
                      $is_chat = $doc[0]->is_chat;

                      $bank_name = !empty($doc[0]->bank_name) ? (string) (AesCipher::decrypt($doc[0]->bank_name) ?: 'N/A') : 'N/A';
                      $bank_account_name = !empty($doc[0]->bank_account_name) ? (string) (AesCipher::decrypt($doc[0]->bank_account_name) ?: 'N/A') : 'N/A';
                      $account_number = !empty($doc[0]->account_number) ? (string) (AesCipher::decrypt($doc[0]->account_number) ?: 'N/A') : 'N/A';
                      $ifsc_code = !empty($doc[0]->ifsc_code) ? (string) (AesCipher::decrypt($doc[0]->ifsc_code) ?: 'N/A') : 'N/A';
                     $bank_id = $doc[0]->id;

                  }


                  $profile_pic = '';
                  $p_img = '';
                  $ic_pic = '';
                  $i_pc = '';
                  $education_pic = '';
                  $e_pic = '';
                  //pr($doctor);
                  if (!empty($doc)) {
                      if (!empty($doc[0]->profile_pic)) {
                          $profile_pic = base_url('upload/doctor/' . $doc[0]->profile_pic);//base_url('upload/doctor/'.$doctor[0]->profile_pic);
                          $p_img = '1';
                  
                      } else {
                          $profile_pic = 'http://cliquecities.com/assets/noimage.png';
                          $p_img = '';
                      }
                  
                      if (!empty($doc[0]->ic_pic)) {
                          $ic_pic = base_url('upload/doctor/' . $doc[0]->ic_pic);
                          $i_pc = '1';
                      } else {
                          $ic_pic = base_url('assets/img/avatars/male.png');
                          $i_pc = '';
                      }

                  
                      if (!empty($doc[0]->education)) {
                          $education_pic = base_url('upload/doctor/' . $doc[0]->education);
                          $e_pic = '1';
                      } else {
                          $education_pic = 'http://cliquecities.com/noimage.png';
                          $e_pic = '';
                      }
                      if (!empty($doc[0]->medical_license)) {
                          $medical_license = base_url('upload/doctor/' . $doc[0]->medical_license);
                          $e_pic = '1';
                      } else {
                          $medical_license = 'http://cliquecities.com/noimage.png';
                          $e_pic = '';
                      }
                  }
                  
                  ?>
               <?php
               //print_r($doc[0]);
                   ?>
               <!-- widget content -->
               <div class="widget-body">
                  <form id="update_doctor" method="post" class="form-horizontal"
                     action="<?php echo base_url('doctor/doctors/update'); ?>" enctype="multipart/form-data">
                     <div class="row d-flex update-dr">

                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="control-label">Full Name <span
                                 class="require">*</span></label>
                              <input type="text" class="form-control" placeholder="Full Name" required
                                 value="<?php echo $name; ?>" name="first_name" id="employee_full_name"
                                 maxlength="200" minlength="4" />
                                 <input type="hidden" class="form-control" placeholder="Full Name" required
                                 value="<?php echo $id; ?>" name="id" id="employee_full_name"
                                 maxlength="200" minlength="4" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="control-label">Email <span class="require">*</span></label>
                              <input type="email" class="form-control" placeholder="Email" required
                                 value="<?php echo $email; ?>" name="email" disabled/>
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
                                 <?php if (!empty($doc[0]->country_code)) {
                                    $country_codes = AesCipher::decrypt($doc[0]->country_code);
                                    } else {
                                    $country_codes = '';
                                    }
                                    //print_r($doc[0]->country_code);
                                    ?>
                                 <select class="form-control select2bs4" name="country_code"
                                    id="country_code" required>
                                    <option value="">Select</option>
                                    <?php $cnty = country_code();
                                       if (!empty($cnty)) {
                                           foreach ($cnty as $key => $value) {
                                       
                                               ?>
                                    <option value="<?php echo $key; ?>" <?php echo $country_codes == $key ? 'selected' : ''; ?>><?php echo '+' . $key; ?>
                                    </option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-md-9" style="padding-left: 0px;padding-right: 0px;">
                                 <input type="text" name="phone_no" class="form-control"
                                    placeholder="Enter You Phone Number" required="required"
                                    maxlength="15" minlength="10" onkeypress="return isNumber(event)"
                                    value="<?php echo $mobile; ?>" >
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class=" control-label">Gender <span class="require">*</span></label>
                              <select class="form-control" name="gender" required>
                                 <option value="">Select</option>
                                 <option value="1" <?php echo $gender == "1" ? 'selected' : ''; ?>>Male
                                 </option>
                                 <option value="2" <?php echo $gender == "2" ? 'selected' : ''; ?>>Female
                                 </option>
                                 <option value="3" <?php echo $gender == "3" ? 'selected' : ''; ?>>Other
                                 </option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-12">
                           <div class="form-field2 form-group">
                               <label class=" control-label">Category</label>
                              <select class="form-control" name="category" id="category"
                                 required="required">
                                 <option value=""> <?php echo $this->lang->line('Select Category'); ?>
                                 </option>
                                 <?php if (!empty($categories)) {
                                    foreach ($categories as $key) {
                                        if ($key->id == $doc[0]->hospital_department_id) {
                                            ?>
                                 <option value="<?php echo $key->id; ?>" selected="selected">
                                    <?php echo $key->name; ?>
                                 </option>
                                 <?php
                                    } else {
                                        ?>
                                 <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?>
                                 </option>
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
                              <label class="control-label">Speciality <span
                                 class="require">*</span></label>
                              <select class="form-control" name="speciality[]" id="speciality" required
                                 multiple="multiple">
                                 <?php if (!empty($Designation)) {
                                    foreach ($Designation as $key) {
                                        if (in_array($key->id, $speciality)) {
                                            ?>
                                 <option value="<?php echo $key->id; ?>" selected="selected">
                                    <?php echo $key->name; ?>
                                 </option>
                                 <?php
                                    } else {
                                        ?>
                                 <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?>
                                 </option>
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
                                 required placeholder="Date of Birth" value="<?php echo $dob; ?>"
                                 name="birth_date" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="control-label">Residential Address <span
                              class="require">*</span></label>
                           <div class="form-group">
                              <input type="text" placeholder="Residential Address" name="present_address"
                                 id="address-input" value="<?php echo $p_address; ?>"
                                 class="form-control map-input" autocomplete="off" required />
                              <input type="hidden" name="address_latitude" id="address-latitude"
                                 value="<?php echo $lat; ?>" />
                              <input type="hidden" name="address_longitude" id="address-longitude"
                                 value="<?php echo $long; ?>" />
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
                                 required class="form-control"><?php echo $r_address; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-6 country-field">
                           <label class="control-label">Country <span class="require">*</span></label>
                           <input type="text" placeholder="Country" name="country" id="country"
                              class="form-control" value="<?php echo $cntry; ?>" readonly required />
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="control-label">Doctor Registration No <span
                                 class="require">*</span></label>
                              <input type="text" class="form-control" placeholder="Doctor Registration No"
                                 required value="<?php echo $rno; ?>" name="registration_no" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="control-label">Education <span class="require">*</span></label>
                           <div class="form-group">
                              <textarea name="education" placeholder="Education" required
                                 class="form-control"><?php echo $edu; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="control-label">Current WorkPlace <span
                              class="require">*</span></label>
                           <div class="form-group">
                              <textarea name="current_workplace" placeholder="Current WorkPlace" required
                                 class="form-control"><?php echo $cwp; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class=" control-label">About Dr: <span
                              class="text-danger">*</span></label>
                           <div class="form-group">
                              <textarea name="aboutus" placeholder="About Dr" required
                                 class="form-control"><?php echo $about; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class=" control-label">Medical Certificate Number: </label>
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Medical Certificate Number"
                                 name="rcc_no" value="<?php echo $rcc_no; ?>" />
                           </div>
                        </div>
                     <div class="col-md-6">
                           <label class=" control-label">Appointment Description:</label>
                           <div class="form-field2 form-group">
                              <textarea placeholder="Appointment Description"
                                 name="appointment_description" id="appointment_description"
                                 class="form-control" required><?php if (!$doc[0]->appointment_description) {
                                 echo '';
                                 } else {
                                 echo (string) AesCipher::decrypt($doc[0]->appointment_description);
                                 }
                                 ; ?></textarea>
                           </div>
                        </div> 

                        <div class="col-md-6">
                           <label class=" control-label">Clinic Interest:</label>
                           <div class="form-group">
                              <textarea name="clinic_intrest" placeholder="Clinic Interest"
                                 class="form-control"><?php echo $ci; ?></textarea>
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
                                 $selectedTimezone = !empty($doc[0]->timezone) ? $doc[0]->timezone : $defaultTimezone;

                                 foreach ($timezones as $timezone) {
                                     // Check if the current timezone is the selected timezone
                                     $selected = ($timezone == $selectedTimezone) ? 'selected' : '';
                                     echo "<option value=\"$timezone\" $selected>$timezone</option>";
                                 }
                                 ?>

                           </select>
                        </div>

                     <div class="col-md-6">
                                        <label class="control-label">Profile Photo<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input type="file" class="form-control" id="imgInp" value="<?php echo $profile_pic; ?>" 
                                                accept="image/*" name="profile_image" />
                                            <br>
                                           <img id='img-upload' src="<?php echo $profile_pic; ?>" alt="your image" />
                                        </div>
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
                                             style="background: url(<?php echo $ic_pic; ?>);width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
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
                                             style="background: url(<?php echo $education_pic; ?>); width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
                                             <button class="remove-image btn" type="button"><img
                                                src="<?= base_url('frontend/images/letter-x.png') ?>"></button>
                                          </div>
                                          <label class="btn btn-primary">
                                          <span style="width: 100%;display: block;white-space: break-spaces;font-size: 11px;text-size: revert;">Education Certificate of Speciality/Highest Medical Certificate</span>
                                          <input type="file" class="uploadFile img"
                                             name="education_pic" id="education"
                                             value="Upload Photo"
                                             style="width: 100%;"
                                             accept="image/x-png,image/gif,image/jpeg">
                                          </label>
                                       </div>
                                    </div>
                                    <div class="col-sm-4 imgUp form-group">
                                       <div class="" style="background-color: #04145f;">
                                          <div class="imagePreview"
                                             style="background:  url(<?php echo $medical_license; ?>); width: 100%;height: 220px;background-position: center center;background-color:#fff;  background-size: cover;background-repeat:no-repeat;display: inline-block;    ">
                                             <button class="remove-image btn" type="button"><img
                                                src="<?= base_url('frontend/images/letter-x.png') ?>"></button>
                                          </div>
                                          <label class="btn btn-primary">
                                          <?php echo "Medical License)"; ?>
                                          <input type="file" class="uploadFile img"
                                             name="medical_license" id="medical_license"
                                             value="Upload Photo"
                                             style="width: 100%;"
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
                                      <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo isset($bank_name) ? $bank_name : ''; ?>" placeholder="Enter bank name">
                                      <input type="hidden" class="form-control" id="bank_name" name="bank_id" value="<?php echo isset($bank_id) ? $bank_id : ''; ?>" placeholder="Enter bank name">

                                      <label for="bank_account_name">Account Name:</label>
                                      <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" value="<?php echo isset($bank_account_name) ? $bank_account_name : ''; ?>" placeholder="Enter account name">

                                      <label for="account_number">Account Number:</label>
                                      <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo isset($account_number) ? $account_number : ''; ?>" placeholder="Enter account number">

                                      <label for="ifsc_code">IFSC Code:</label>
                                      <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="<?php echo isset($ifsc_code) ? $ifsc_code : ''; ?>" placeholder="Enter IFSC code">
                                  </div>
                              </div>
                         
                           </div>  
                    </div>
                           <div class="col-md-12">
                              <label class="control-label">Select Services:</label>
                              <div class="form-group one-row">
                                 <div class="g-1">
                                    <input type="checkbox" id="chat_service_checkbox" name="service[]" value="chat_service" <?php echo $is_chat == 1 ? 'checked' : ''; ?>> Chat Service
                                 </div>
                                 <div class="g-1">
                                    <input type="checkbox" id="video_service_checkbox" name="service[]" value="video_service" <?php echo $is_video == 1 ? 'checked' : ''; ?>> Video Service
                                 </div>
                                 <div class="g-1">
                                    <input type="checkbox" id="clinic_service_checkbox" name="service[]" value="clinic_service" <?php echo $is_clinic == 1 ? 'checked' : ''; ?>> Clinic Service
                                 </div>
                                 <!-- <div class="g-1">
                                    <input type="checkbox" id="home_service_checkbox" name="service[]" value="home_service" <?php echo $is_home == 1 ? 'checked' : ''; ?>> Home Service
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
    <div id="chat_service_card" class="col-md-6 card-section" style="<?php echo $is_chat == 1 ? 'display: block;' : 'display: none;'; ?>">
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
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->chat_first_time) && $specialities[0]->chat_first_time >= 1) ? $specialities[0]->chat_first_time : '' ?>"
                        required />
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('Follow Up'); ?></label>
                    <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                        name="chatFU" min="10" max="100000"
                        class="form-control"
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->chat_follow_up) && $specialities[0]->chat_follow_up >= 1) ? $specialities[0]->chat_follow_up : '' ?>"
                        required />
                </div>
            </div>
        </div>
    </div>

    <div id="video_service_card" class="col-md-6 card-section" style="<?php echo $is_video == 1 ? 'display: block;' : 'display: none;'; ?>">
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
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->video_first_time) && $specialities[0]->video_first_time >= 1) ? $specialities[0]->video_first_time : '' ?>"
                        required />
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('Follow Up'); ?></label>
                    <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                        name="videoFU" min="10" max="100000"
                        class="form-control"
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->video_follow_up) && $specialities[0]->video_follow_up >= 1) ? $specialities[0]->video_follow_up : '' ?>"
                        required />
                </div>
            </div>
        </div>
    </div>

    <div id="home_service_card" class="col-md-6 card-section" style="<?php echo $is_home == 1 ? 'display: block;' : 'display: none;'; ?>">
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
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->home_first_time) && $specialities[0]->home_first_time >= 1) ? $specialities[0]->home_first_time : '' ?>"
                        required />
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('Follow Up'); ?></label>
                    <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                        name="homeFU" min="10" max="100000"
                        class="form-control"
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->home_follow_up) && $specialities[0]->home_follow_up >= 1) ? $specialities[0]->home_follow_up : '' ?>"
                        required />
                </div>
            </div>
        </div>
    </div>

    <div id="clinic_service_card" class="col-md-6 card-section" style="<?php echo $is_clinic == 1 ? 'display: block;' : 'display: none;'; ?>">
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
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->clinic_first_time) && $specialities[0]->clinic_first_time >= 1) ? $specialities[0]->clinic_first_time : '' ?>"
                        required />
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('Follow Up'); ?></label>
                    <input type="number" placeholder="<?= CURRENCY_SYMBOLE ?>"
                        name="clinicFU" min="10" max="100000"
                        class="form-control"
                        value="<?= (isset($specialities[0]) && is_object($specialities[0]) && isset($specialities[0]->clinic_follow_up) && $specialities[0]->clinic_follow_up >= 1) ? $specialities[0]->clinic_follow_up : '' ?>"
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
                              </article>
                           </div>
                              </article>
                           </div>
                           <script>
                              document.addEventListener('DOMContentLoaded', function() {
                                  function toggleCard(serviceCheckbox, cardId) {
                                      const checkbox = document.getElementById(serviceCheckbox);
                                      const card = document.getElementById(cardId);
                              
                                      if (checkbox && card) {
                                          card.style.display = checkbox.checked ? 'block' : 'none';
                              
                                          checkbox.addEventListener('change', function() {
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
                        
                        <input type="hidden" name="doctor_id" id="doctor_id"
                           value="<?php echo $this->uri->segment(4); ?>">
                        <div class="form-actions">
                           <div class="row">
                              <div class="col-md-12">
                                 <button class="btn-md btn btn-primary" value ="submit" name="submit" type="submit">Submit
                                 </button>
                                 <button class="btn-md btn  btn-primary btn-danger" name="reset"
                                    type="reset">
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