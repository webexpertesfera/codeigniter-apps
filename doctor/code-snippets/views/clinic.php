<!-- RIBBON -->

<link href="<?php echo base_url('frontend/css/custom.css');?>" rel="stylesheet">

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

                      <form id="new_doctor_clinic" method="post" class="form-horizontal" action="<?php echo base_url('doctor/doctors/createclinic');?>">
                      <div class="clinic-head">
                          <?php if(!empty($clinic)){ ?>
                             <SPAN style="color: red;"><strong>Warning!</strong> Your Previous Clinic Data Will Erase When You Update.</SPAN>
                            <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Warning!</strong> Your Previous Clinic Data Will Erase When You Update.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div> -->
                          <?php } ?>
                       <h3> ADD CLINIC  <a id="add_row_edit" class="btn btn-info btn-sm pull-right" style="background: #bfe0f5;border: none;padding: 4px 15px;color: #0c82c9;box-shadow: unset;display: flex;
                       align-items: center;
                       justify-content: center;">+</a></h3>
                     </div>
                     <div id="grdnewedit">

                      <div class="clinic-box_1 clinicbtn">
                        <div class="modal fade modal-size2 bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                         <div class="modal-dialog" role="document" style="max-width: 900px;">
                          <div class="modal-content">
                           <div class="custom-modal1">
                            <div class="modal-head text-center">
                             <h3> Add Schedule </h3>
                             <button type="button" class="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                           </div>
                           <div class="modal-data1">
                             <div class="schedule-days">
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="monday" id="monday_1" value="monday"> Monday </h5>
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="tuesday" id="tuesday_1" value="tuesday"> Tuesday </h5>
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="wednesday" id="wednesday_1" value="wednesday"> Wednesday </h5>
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="thursday" id="thursday_1" value="thursday"> Thursday </h5>
                              <h5> <input  class="messageCheckbox_1" type="checkbox" name="friday" id="friday_1" value="friday"> Friday </h5>
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="saturday" id="saturday_1" value="saturday"> Saturday </h5>
                              <h5> <input class="messageCheckbox_1" type="checkbox" name="sunday" id="sunday_1" value="sunday"> Sunday </h5>
                            </div>
                            <div class="schedule-slots">
                              <div class="slots-head">
                               <h4> Morning Slots </h4>
                             </div>
                             <div class="slots-data">
                               <div class="row">
                                <div>
                                 <input type="time" name="monday_morning_from" id="monday_morning_from_1" placeholder="From" />
                               </div>
                               <div>
                                 <input type="time" name="monday_morning_to" id="monday_morning_to_1" placeholder="To"  />
                               </div>
                             </div>
                             <div class="row">
                              <div>
                               <input type="time" name="tuesday_morning_from" id="tuesday_morning_from_1" placeholder="From"  />
                             </div>
                             <div>
                               <input type="time" name="tuesday_morning_to" id="tuesday_morning_to_1" placeholder="To"  />
                             </div>
                           </div>
                           <div class="row">
                            <div>
                             <input type="time" name="wednesday_morning_from" id="wednesday_morning_from_1" placeholder="From" />
                           </div>
                           <div>
                             <input type="time" name="wednesday_morning_to" id="wednesday_morning_to_1" placeholder="To" />
                           </div>
                         </div>
                         <div class="row">
                          <div>
                           <input type="time" name="thursday_morning_from" id="thursday_morning_from_1" placeholder="From" />
                         </div>
                         <div>
                           <input type="time" name="thursday_morning_to" id="thursday_morning_to_1" placeholder="To"  />
                         </div>
                       </div>
                       <div class="row">
                        <div>
                         <input type="time" name="friday_morning_from"  id="friday_morning_from_1" placeholder="From"  />
                       </div>
                       <div>
                         <input type="time" name="friday_morning_to" id="friday_morning_to_1" placeholder="To"  />
                       </div>
                     </div>
                     <div class="row">
                      <div>
                       <input type="time" name="saturday_morning_from" id="saturday_morning_from_1" placeholder="From"  />
                     </div>
                     <div>
                       <input type="time" name="saturday_morning_to" id="saturday_morning_to_1" placeholder="To"  />
                     </div>
                   </div>
                   <div class="row">
                    <div>
                     <input type="time" name="sunday_morning_from" id="sunday_morning_from_1" placeholder="From"/>
                   </div>
                   <div>
                     <input type="time" name="sunday_morning_to" id="sunday_morning_to_1" placeholder="To" />
                   </div>
                 </div>
               </div>
             </div>
             <div class="schedule-slots">
              <div class="slots-head">
               <h4> Evening Slots </h4>
             </div>
             <div class="slots-data">
               <div class="row">
                <div>
                 <input type="time" name="monday_evening_from" id="monday_evening_from_1" placeholder="From" />
               </div>
               <div>
                 <input type="time" name="monday_evening_to" id="monday_evening_to_1" placeholder="To"  />
               </div>
             </div>
             <div class="row">
              <div>
               <input type="time" name="tueday_evening_from" id="tuesday_evening_from_1" placeholder="From"  />
             </div>
             <div>
               <input type="time" name="tueday_evening_to" id="tuesday_evening_to_1" placeholder="To"  />
             </div>
           </div>
           <div class="row">
            <div>
             <input type="time" name="wednesday_evening_from" id="wednesday_evening_from_1" placeholder="From" />
           </div>
           <div>
             <input type="time" name="wednesday_evening_to" id="wednesday_evening_to_1" placeholder="To" />
           </div>
         </div>
         <div class="row">
          <div>
           <input type="time" name="thursday_evening_from" id="thursday_evening_from_1" placeholder="From" />
         </div>
         <div>
           <input type="time" name="thursday_evening_to" id="thursday_evening_to_1" placeholder="To"  />
         </div>
       </div>
       <div class="row">
        <div>
         <input type="time" name="friday_evening_from"  id="friday_evening_from_1" placeholder="From"  />
       </div>
       <div>
         <input type="time" name="friday_evening_to" id="friday_evening_to_1" placeholder="To"  />
       </div>
     </div>
     <div class="row">
      <div>
       <input type="time" name="saturday_evening_from" id="saturday_evening_from_1" placeholder="From"  />
     </div>
     <div>
       <input type="time" name="saturday_evening_to" id="saturday_evening_to_1" placeholder="To"  />
     </div>
   </div>
   <div class="row">
    <div>
     <input type="time" name="sunday_evening_from" id="sunday_evening_from_1" placeholder="From"/>
   </div>
   <div>
     <input type="time" name="sunday_evening_to" id="sunday_evening_to_1" placeholder="To" />
   </div>
 </div>
</div>
</div>
<div class="schedule-button">
  <button type="button" value="1" onclick="getslotdata(1)" data-dismiss="modal"> SUBMIT </button>
</div>
</div>
</div>
</div>
</div>
</div>
<h4 style="color: #afaeae;margin-bottom: 10px;"> Clinic 1 </h4>
<div class="row">
  <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
   <div class="form-field2 form-group">
    <input type="text" placeholder="Clinic Name" name="clinic_name[]" id="clinic_name_1" class="form-control" required="required" />
  </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
  <div class="form-field2 form-group">
    <input type="text" placeholder="Clinic Address" name="clinic_address[]" id="clinic_address_1" class="form-control" required="required"/>
  </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
  <div class="form-field2 form-group">
    <select class="form-control multi" name="time_slot[]" id="time_slot_1" multiple="multiple" onchange="getval(1)" required="required">
    </select>
    <input type="hidden" name="select_time[]" id="select_time_1" value="">
  </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
  <div class="form-field2 form-group" style="display: inline-block; width: auto;">
   <input type="hidden" id="btnid_1" value="1">
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" value="1">Click this to create Time Slot</button>
 </div>
</div>
<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
</div>
</div>
</div>
<div class="form-actions">
  <div class="row">
    <div class="col-md-4">

    </div>
    <div class="col-md-3">
      <?php if(!empty($clinic)){ ?>
      <input type="hidden" name="exit_doctor" value="1">
    <?php } else{ ?>
      <input type="hidden" name="exit_doctor" value="0">
    <?php } ?>

      <button class="btn-md btn btn-primary" name="submit" type="submit">Next
      </button>
      <a href="<?php echo base_url('doctor/doctors/create/'.$this->uri->segment(4));?>" type="button" class="btn-md btn btn-danger">Back</a>
           <!--  <button class="btn-md btn btn-danger" name="reset" type="reset">
                Reset
              </button> -->

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