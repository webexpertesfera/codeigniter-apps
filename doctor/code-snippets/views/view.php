<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    

</div>
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-user-md"></i>
                View Details
            </h1>
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
                <div class="jarviswidget cstm-appcnt doctr-view" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                    <h2>View Doctor</h2>
                </header>
                <!-- widget div-->
                <div class="appcontent-inner">
                    <!-- widget content -->
                    <div class="doctor-img-use">
                            <img src="<?=base_url('upload/doctor/'.$doc[0]->profile_pic);?>">
                        </div>

                    <div class="widget-body">
                        <div class="doctors-title"><h4><b>Basic Information</b></h4><br>
                         <?php if($doc[0]->admin_approve != 2){
                            ?>                                          
                               <a data-toggle="tooltip" data-placement="top" title="Reject" href="javascript:void(0)" onclick="showDoctorRejectModel(<?=$doc[0]->doctor_id ?>)"><button class="btn btn-danger" style="float: right;margin-top: -43px;">Reject Doctor</button></a>
                       <?php  }
                       if($doc[0]->admin_approve != 1)
                       {
                        ?>
                        <a data-toggle="tooltip" data-placement="top" title="Approve" href="doctor/doctors/status/<?php echo $doc[0]->doctor_id.'/'.'approve'; ?>"><button class="btn btn-success" style="float: right;margin-top: -43px;">Approve</button></a>
                        <?php
                       }
                       ?></div>
                       <table class="table table-bordered">
                            <tr>
                                <td><strong>Full Name</strong></td>
                                <td><?php if(!empty($doc[0]->first_name)){ echo AesCipher::decrypt($doc[0]->first_name); } else{ echo '';};?></td>
                                <td><strong>Email</strong></td>
                                <td> <?php if(!empty($doc[0]->email)){ echo AesCipher::decrypt($doc[0]->email); } else{ echo '';};?></td>
                            </tr>
                             <tr>
                                <td><strong>Mobile Number</strong></td>
                                <td><?php if(!empty($doc[0]->mobile_no)){ echo  AesCipher::decrypt($doc[0]->country_code).'-'.AesCipher::decrypt($doc[0]->mobile_no); } else{ echo '';};?></td>
                                <td><strong>Gender</strong></td>
                                <td> <?php 
                                if(!empty($doc[0]->gender))
                                {
                                    if($doc[0]->gender == 1)
                                    {
                                        echo 'Male';
                                    }
                                    elseif ($doc[0]->gender == 2) {
                                       echo 'Female';
                                    }
                                    else
                                    {
                                         echo 'Other';
                                    }                                    
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td><strong>Category</strong></td>
                                <td> <?php if(!empty($category_name)){ 
                                  echo $category_name[0]->name;
                                }
                                else
                                {
                                  echo 'N/A';  
                                }?>
                                </td>
                                <td><strong>Speciality</strong></td>
                                <td> <?php if(!empty($speciality)){ 
                                    foreach($speciality as $key)
                                    {
                                        echo $key->name.',';
                                    }
                                 } else{ echo '';};?> </td>
                            </tr>
                            <tr>
                                <td><strong>Birth Date</strong></td>
                                <td><?php if(!empty($doc[0]->birth_date)){ echo $doc[0]->birth_date; } else{ echo '';};?></td>
                                <td><strong>Residential Address</strong></td>
                                <td>  <?php if(!empty($doc[0]->present_address)){ echo AesCipher::decrypt($doc[0]->present_address); } else{ echo '';};?></td>
                            </tr>
                             <tr>
                                <td><strong>Correspondence Address</strong></td>
                                <td> <?php if(!empty($doc[0]->permanent_address)){ echo AesCipher::decrypt($doc[0]->permanent_address); } else{ echo '';};?></td>
                                <td><strong>Country</strong></td>
                                <td>   <?php if(!empty($doc[0]->country)){ echo $doc[0]->country; } else{ echo '';};?></td>
                            </tr>
                             <tr>
                                <td><strong>Doctor Registration No.</strong></td>
                                <td> <?php if(!empty($doc[0]->registeration_no)){echo AesCipher::decrypt($doc[0]->registeration_no); } else{ echo '';};?></td>
                                <td><strong>Education</strong></td>
                                <td> <?php if(!empty($doc[0]->education_qualification)){ echo AesCipher::decrypt($doc[0]->education_qualification); } else{ echo '';};?></td>
                            </tr>
                            <tr>    
                                <td><strong>Current WorkPlace</strong></td>
                                <td>  <?php if(!empty($doc[0]->current_wokplace)){ echo AesCipher::decrypt($doc[0]->current_wokplace); } else{ echo '';};?></td>
                                <td><strong>About Dr.</strong></td>
                                <td> <?php if(!empty($doc[0]->about)){ echo AesCipher::decrypt($doc[0]->about); } else{ echo '';};?></td>
                            </tr>
                             <tr>
                                <td><strong>Clinic Interest</strong></td>
                                <td> <?php if(!empty($doc[0]->clicnic_intrest)){ echo AesCipher::decrypt($doc[0]->clicnic_intrest); } else{ echo 'N/A';};?></td>

                                <td><strong>Medical Certificate Number</strong></td>
                                <td><?=empty($doc[0]->rcc_no) ? 'NA' : AesCipher::decrypt($doc[0]->rcc_no); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Services</strong></td>
                                <td colspan="<?php echo $doc[0]->is_online == 1?'':'3';?>>">
                                  <?php if(!empty($doc)){
                                   if($doc[0]->is_chat == 1)
                                   {
                                       echo "Chat Service".", ";
                                   }
                                   if($doc[0]->is_video == 1)
                                   {
                                       echo "Video Service".", ";
                                   }
                                   if ($doc[0]->is_clinic == 1)
                                   {
                                        echo "Clinic Service".",";
                                   }
                                   if ($doc[0]->is_home == 1) {
                                       echo "Home Service".", ";
                                   }
                                } else{ echo '';};?></td>
                            </tr>
                            
                        </table>
                        <br>
                        <div class="doctors-title"><h4><b>Fee Configuration</b></h4></div>
                        <div class="accordion-content">  
                          
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service</th>
                <th><?php echo $this->lang->line('First Time'); ?></th>
                <th><?php echo $this->lang->line('Follow Up'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specialities)) : ?>
                <?php if ($doc[0]->is_chat == 1) : ?>
                    
                    <tr>
                        <td>Chat</td>
                        <td><?= ($specialities[0]->chat_first_time < 1) ? '' : $specialities[0]->chat_first_time ?></td>
                        <td><?= ($specialities[0]->chat_follow_up < 1) ? '' : $specialities[0]->chat_follow_up ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($doc[0]->is_video == 1) : ?>
                    <tr>
                        <td>Video Call</td>
                        <td><?= ($specialities[0]->video_first_time < 1) ? '' : $specialities[0]->video_first_time ?></td>
                        <td><?= ($specialities[0]->video_follow_up < 1) ? '' : $specialities[0]->video_follow_up ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($doc[0]->is_home == 1) : ?>
                    <tr>
                        <td>Home Visit</td>
                        <td><?= ($specialities[0]->home_first_time < 1) ? '' : $specialities[0]->home_first_time ?></td>
                        <td><?= ($specialities[0]->home_follow_up < 1) ? '' : $specialities[0]->home_follow_up ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($doc[0]->is_clinic == 1) : ?>
                    <tr>
                        <td>Clinic Visit</td>
                        <td><?= ($specialities[0]->clinic_first_time < 1) ? '' : $specialities[0]->clinic_first_time ?></td>
                        <td><?= ($specialities[0]->clinic_follow_up < 1) ? '' : $specialities[0]->clinic_follow_up ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

                        
                        <br>
                        <div class="doctors-title"><h4><b>Admin Commission</b></h4></div>
                         <table class="table table-bordered doctor-view">
                             <tr>
                              <th>Clinic Commission</th>
                              <th>Home Commission</th>
                              <th>Online Commission</th>
                            </tr>
                            <tr>
                              <td><?php if(!empty($doc[0]->clinic_commission)){ echo $doc[0]->clinic_commission.' %'; } else{ echo '';};?></td>
                               <td><?php if(!empty($doc[0]->home_commission)){ echo $doc[0]->home_commission.' %'; } else{ echo '';};?></td>
                                <td><?php if(!empty($doc[0]->online_commission)){ echo $doc[0]->online_commission.' %'; } else{ echo '';};?></td>
                            </tr>
                          </table>

                        <br>
                        <div class="doctors-title"><h4><b>Doctor Documents</b></h4></div>
                         <div class="row">
                          <div class="col-md-12  doctor-cl-img">
                           
                           <div class="col-md-6">
                              <?php if(!empty($doc[0]->ic_pic)){?>
                                 <div class="filtr-item" data-category="1" data-sort="ID/ Passport Number">
                                <a href="<?=base_url('upload/doctor/'.$doc[0]->ic_pic);?>?text=1" data-toggle="lightbox" data-title="ID/ Passport Number">
                                  <img src="<?=base_url('upload/doctor/'.$doc[0]->ic_pic);?>?text=1" class="img-fluid mb-2" alt="ID/ Passport Number" style="width: 100px;"/>
                                </a>
                              </div>
                             
                            <?php   }?>
                            </div>
                            <div class="col-md-6">
                              <?php if(!empty($doc[0]->education)){?>
                                 <div class="filtr-item" data-category="1" data-sort="Education Certificate">
                                <a href="<?=base_url('upload/doctor/'.$doc[0]->education);?>?text=1" data-toggle="lightbox" data-title="Education Certificate">
                                  <img src="<?=base_url('upload/doctor/'.$doc[0]->education);?>?text=1" class="img-fluid mb-2" alt="Education Certificate" style="width: 100px;"/>
                                </a>
                              </div>
                              
                            <?php   }?>
                            </div>
                             <div class="col-md-6">
                              <?php if(!empty($doc[0]->medical_license)){?>
                                 <div class="filtr-item" data-category="1" data-sort="Medical Certificate">
                                <a href="<?=base_url('upload/doctor/'.$doc[0]->medical_license);?>?text=1" data-toggle="lightbox" data-title="Medical Certificate">
                                  <img src="<?=base_url('upload/doctor/'.$doc[0]->medical_license);?>?text=1" class="img-fluid mb-2" alt="Medical Certificate" style="width: 100px;"/>
                                </a>
                              </div>
                              
                            <?php   }?>
                            </div>
                          </div>
                         </div>
                        <br>
                        <br>
                        <div class="doctors-title"><h4><b>Bank Details</b></h4></div>
                         <table class="table table-bordered doctor-view">
                             <tr>
                              <th>Bank name</th>
                              <th>Account Name</th>
                              <th>Account Number</th>
                              <th>IFSC Code</th>
                            </tr>
                            <tr>
                             <td> <?php if(!empty($bank_details[0]->bank_name)){ echo AesCipher::decrypt($bank_details[0]->bank_name); } else{ echo 'N/A';};?></td>
                               <td><?php if(!empty($bank_details[0]->bank_account_name)){ echo AesCipher::decrypt($bank_details[0]->bank_account_name); } else{ echo 'N/A';};?></td>
                                <td><?php if(!empty($bank_details[0]->account_number)){ echo AesCipher::decrypt($bank_details[0]->account_number); } else{ echo 'N/A';};?></td>
                                 <td><?php if(!empty($bank_details[0]->ifsc_code)){ echo AesCipher::decrypt($bank_details[0]->ifsc_code); } else{ echo 'N/A';};?></td>
                            </tr>
                          </table>
                        <br>
                        <?php if($doc[0]->is_clinic == 1){ ?>
                          <div class="doctors-title"><h4><b>Clinic Information</b></h4></div>
                       <table class="table table-bordered">
                        <tr>
                          <th>Clinic Name</th>
                          <th>Clinic Address</th>
                          <th>Clinic Open Days </th>
                          <th>Morning Maximum Visitors </th>
                          <th>Morning Slots </th>
                          <th>Evening Maximum Visitors </th>
                          <th>Evening Slots </th>                              
                          <th>Status</th>
                         </tr>
                         <?php if(!empty($clinic)){
                            $i= 0;
                            foreach($clinic as $key =>$val)
                            {
                                foreach($val as $key1)
                                {

                                    echo '<tr>';
                                    if($i == 0)
                                      {
                                         echo '<td rowspan="'.count($val).'"style="text-align: center;">'.AesCipher::decrypt($key1->name).'</td>';
                                         echo '<td rowspan="'.count($val).'"style="text-align: center;">'.AesCipher::decrypt($key1->address).'</td>';
                                      }
                                   echo '<td style="text-align: center;">'.ucwords($key1->day).'</td>';
                                    echo '<td style="text-align: center;">'.$key1->maximum_visitor.'</td>';
                                  
                                   if($key1->start_time !=''){
                                     echo '<td style="text-align: center;">';
                                   if($key1->start_time != '00:00:00'){ echo date('h:i a',strtotime($key1->start_time)).' - '.date('h:i a',strtotime($key1->end_time)); } else { echo 'No slots available'; }
                                    echo '</td>';
                                 }
                                 else{
                                   echo '<td style="text-align: center;">';
                                  echo 'No slots available';
                                  echo '</td>';
                                 }
                                 
                                    echo '<td style="text-align: center;">'.$key1->evening_maximum_visitor.'</td>';
                                      if($key1->evening_start_time !=''){
                                     echo '<td style="text-align: center;">';
                                   if($key1->evening_start_time != '00:00:00'){ echo date('h:i a',strtotime($key1->evening_start_time)).' - '.date('h:i a',strtotime($key1->evening_end_time)); } else { echo 'No slots available'; }
                                   echo '</td>';
                                 }
                                 else
                                 {
                                    echo '<td style="text-align: center;">';
                                  echo 'No slots available';
                                  echo '</td>';
                                 }

                                    
                                     echo '<td style="text-align: center;">'.ucwords($key1->status).'</td>';
                                      echo '</tr>';                                                 
                                    $i++;
                                }
                                $i = 0;
                            }
                         }?>
                        </table>
                        <br>

                      <?php } ?>

                      <?php if($doc[0]->is_chat == 1 || $doc[0]->is_video ){ ?>
                        <div class="doctors-title"> <h4><b>Online Time Slot Information</b></h4></div>
                       <table class="table table-bordered">
                        <tr>
                          <th>Days</th>
                          <th>Time Per Patient (in minutes)</th>
                          <th>Morning Time</th>
                          <th>Evening Time</th>
                        </tr>
                        <?php if(!empty($online))
                        {
                          foreach($online as $key)
                          {
                            ?>
                            <tr>
                              <td><?php echo ucwords($key->day);?></td>
                              <td><?php echo $key->patient_time.' Minutes';?></td>
                               <td><?php if($key->start_time != '00:00:00'){ echo date('h:i a',strtotime($key->start_time)).' - '.date('h:i a',strtotime($key->end_time)); } else { echo 'No slots available'; }?></td>
                    
                                 <td><?php if($key->evening_start_time != '00:00:00'){ echo date('h:i a',strtotime($key->evening_start_time)).' - '.date('h:i a',strtotime($key->evening_end_time)); } else { echo 'No slots available'; }?></td>
                            </tr>
                            <?php 
                          }
                        }
                        ?>
                        </table>
                        <br>
                      <?php } ?>



                     <div class="doctors-title">
                            <h4><b>Profile Link</b></h4>
                        </div>
                        <table class="table table-bordered doctor-view">
                            <tr>
                                <td>
                            <?php 
                                if (!empty($doc[0]->profile_link)) {
                                    $profile_link = htmlspecialchars($doc[0]->profile_link);
                                    echo '<a href="' . $profile_link . '" target="_blank">' . $profile_link . '</a>';

                                    // Copy link button
                                    echo '<div> <div><button class="btn btn-success" onclick="copyLink(\'' . $profile_link . '\')">Copy Link</button></div></div>';

                                    // Social media share buttons
                                    /*echo '<div>
                                            <a href="https://wa.me/?text=' . urlencode($profile_link) . '" target="_blank" class="btn btn-success">Share on WhatsApp</a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($profile_link) . '" target="_blank" class="btn btn-primary">Share on Facebook</a>
                                            <a href="https://twitter.com/intent/tweet?url=' . urlencode($profile_link) . '" target="_blank" class="btn btn-info">Share on Twitter</a>
                                          </div>';*/
                                } else {
                                    echo '<a data-toggle="tooltip" data-placement="top" href="doctor/doctors/profile_link/' . htmlspecialchars($doc[0]->doctor_id) . '">
                                            <button class="btn btn-success">Create Profile Link</button>
                                          </a>';
                                }
                            ?>
                        </td>

                        <script>
                            // Function to copy the link to clipboard
                            function copyLink(link) {
                                // Create a temporary input element to copy the link
                                var tempInput = document.createElement('input');
                                tempInput.value = link;
                                document.body.appendChild(tempInput);
                                tempInput.select();
                                document.execCommand('copy');
                                document.body.removeChild(tempInput);

                                // Optionally, show a success message
                                alert('Profile link copied to clipboard!');
                            }
                        </script>


                            </tr>
                        </table>

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

<!-- Start Reject Model -->
  <div class="modal fade" id="exampleModal-reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="rejectForm" method="POST" action="<?=base_url() ?>doctor/doctors/rejectDoctor">
            <div class="custom-modal">
               <h3>Add Reason for Account rejection</h3>
               <textarea name="reject_reason" oninput="limit(this,100);" onpaste="limit(this,100);" class="form-control"  placeholder="Type You Reason Here"></textarea>
               <input type="hidden" name="doctor_id" id="rejectDoctor">
               <div class="reject-approve-btn-d">
                  <a href="javascript:$('#rejectForm').submit();" class="reject-btn">Reject</a>
                  <a href="javascript:void(0)" data-dismiss="modal" class="reapprove-btn">Cancel</a>
               </div>
            </div>
           </form>
         </div>
      </div>
   </div>
</div>



<!-- End Reject Model -->
