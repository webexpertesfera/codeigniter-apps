<!--RIBBON -->
<div id="ribbon">

	<span class="ribbon-button-alignment">
		<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
			<i class="fa fa-refresh"></i>
		</span>
	</span>

	<!-- breadcrumb -->
	<ol class="breadcrumb">
		<li>Doctor</li><li><a href="doctor/doctors">Admin</a></li><li>Commission</li>
	</ol>

</div>
<div id="content">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1 class="page-title txt-color-blueDark dashboard-title">
				<i class="fa fa-user-md"></i>
				Admin Commission Create
			</h1>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<a href="doctor/doctors"><button class="btn btn-md btn-success"><i class="fa fa-list"></i> Doctors List</button></a>
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
				<div class="jarviswidget cstm-appcnt dctr" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                	<h2>Admin Commission</h2>
                </header>

                <!-- widget div-->

                <div class="appcontent-inner">
                    <?php
                    $online_com = '';
                    $clinic_com = '';
                    $home_com = '';
                    
                    if(!empty($doctor))
                    {
                        $online_com = (int)$doctor[0]->online_commission;
                        $clinic_com = (int)$doctor[0]->clinic_commission;
                        $home_com = (int)$doctor[0]->home_commission;
                    }
                    ?>
                	<!-- widget content -->
                	<div class="widget-body">

                		<?php
                		$attributes = ['id' => 'new_patient','method'=>'post','class'=>'form-horizontal'];
                		echo form_open_multipart('doctor/doctors/savecommission', $attributes);
                		?>

                        <div class="row">
                    		<div class="col-md-6">
                                <label>Online (Chat & Video) Commission (%)</label>
                    			<div class="form-group">
                    				<input type="text" class="form-control" placeholder="Online (Chat & Video) commission(%)" required value="<?php echo $online_com; ?>" name="online_commission" onkeypress="return isNumber(event)" maxlength="2" minlength="1"/>
                    			</div>
                    		</div>

                            <div class="col-md-6">
                                 <label>Clinic Commission (%)</label>
                                <div class="form-group">
                                <input type="text" class="form-control" placeholder="Clinic commission (%)" required value="<?php echo $clinic_com; ?>" name="clinic_commission" onkeypress="return isNumber(event)" maxlength="2" minlength="1"/>
                                </div>
                            </div>

                            
                        </div>
                            <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $this->uri->segment(4);?>">
                            <div class="form-actions">
                            	<div class="row">
                            	
                            		<div class="col-md-12">

                            			<button class="btn-md btn btn-primary" name="submit" type="submit">Save
                            			</button>

                            			<button class="btn-md btn btn-primary btn-danger" name="reset" type="reset">
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