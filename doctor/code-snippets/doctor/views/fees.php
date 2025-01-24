<style>
    input {
    margin-bottom: 20px;
}
</style>
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

                <header role="heading" class="ui-sortable-handle add-fee-header">
                	<span class="widget-icon"> <i class="fa fa-user-md"></i> </span>
                	<h2>New Doctor</h2>
                </header>

                <!-- widget div-->

                <div class="employee-list appcontent-inner add-fee">

                 

                  
               
                	<div class="widget-body"> 
                         <?php if(!empty($doc)){ 
                            if($doc[0]->is_fees == 1){ ?>
                             <SPAN style="color: red;"><strong>Warning!</strong> Your Previous Fees Data Will Erase When You Update.</SPAN>
                            <?php  }
                         } ?>
                       
                         <form id="doctor_fee" method="post" class="form-horizontal" action="<?php echo base_url('doctor/doctors/savefees');?>">
                      
                        <div class="doctors-title fee"><h4><b> Fees Configuration</b></h4></div>
                        <div class="block-element row" >
                      

                        <?php if(!empty($specialities)) : ?>
                          <?php foreach($specialities as $speciality) : ?>
                          <div class="online_chat col-md-12" style="padding: 0 !important;">
                            <h4 style="margin-bottom: 10px;"><?=$speciality->speciaility_name ?></h4>
                            <!-- <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                    <label>First Time</label>
                                        <input type="number" placeholder="<?=CURRENCY_SYMBOLE ?>"  name="categoryFT<?=$speciality->spec_id ?>" min="10" max="100000" class="form-control" value="<?=($speciality->price_first_time < 1) ? '' : $speciality->price_first_time ?>" required/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                    <label>Follow Up</label>
                                        <input type="number" placeholder="<?=CURRENCY_SYMBOLE ?>"  name="categoryFU<?=$speciality->spec_id ?>" min="10" max="100000" class="form-control" value="<?=($speciality->price_follow_up < 1) ? '' : $speciality->price_follow_up ?>" required/>
                                    </div>
                                </div>
                            </div> -->
                          </div>
                          <?php endforeach; ?>
                   
                            <?php if ($doc[0]->is_chat == 1): ?>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <span class="time">Chat First Time</span>
                                        <span class="rs"><input type="number" name="chat_first_time" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="online-chat-inner-upr-content">
                                            <span class="time">Chat Follow up</span>
                                            <span class="rs"><input type="number" name="chat_follow_up" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                        </div>
                                    </div>
                                </div>
                          <?php endif; ?>

                          <?php if ($doc[0]->is_video == 1): ?>
                            <div class="row">
                                  <div class="col-12 col-md-6 mb-4">
                                      <span class="time">Video First Time</span>
                                      <span class="rs"><input type="number" name="video_first_time" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                  </div>
                                  <div class="col-12 col-md-6 mb-4">
                                    <div class="online-chat-inner-upr-content">
                                        <span class="time"> Video Follow up</span>
                                        <span class="rs"><input type="number" name="video_follow_up" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                    </div>
                                  </div>
                            </div>
                          <?php endif; ?>

                          <?php if ($doc[0]->is_home == 1): ?>
                            <div class="row">
                                  <div class="col-12 col-md-6 mb-4">
                                      <span class="time">Home First Time</span>
                                      <span class="rs"><input type="number" name="home_first_time" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                  </div>
                                  <div class="col-12 col-md-6 mb-4">
                                    <div class="online-chat-inner-upr-content">
                                        <span class="time">Home Follow up</span>
                                        <span class="rs"><input type="number" name="home_follow_up" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                    </div>
                                  </div>
                            </div>
                          <?php endif; ?>

                          <?php if ($doc[0]->is_clinic == 1): ?>
                                  <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <span class="time">Clinic First Time</span>
                                        <span class="rs"><input type="number" name="clinic_first_time" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="online-chat-inner-upr-content">
                                            <span class="time"> Clinic Follow up</span>
                                            <span class="rs"><input type="number" name="clinic_follow_up" placeholder="NGN"  min="10" max="100000" class="form-control" value="" required/></span>
                                        </div>
                                    </div>
                                  </div>
                          <?php endif; ?>
                        <?php endif; ?>

                        

                        </div>
                
                            <div class="form-actions">
                            	<div class="row">
                            		<div class="col-md-12">
                                  <input type="hidden" name="user_id" id="doctor_id" value="<?php echo $this->uri->segment(4);?>">
                            			<button class="btn-md btn btn-primary" name="submit" type="submit">Save
                            			</button>
                                    
                            			<button class="btn-md btn btn-primary" name="reset" type="reset">
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