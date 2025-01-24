<!--RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Clinic</li><li><a href="patient/patients">Clinic</a></li><li>Edit</li>
    </ol>
   
</div>

<!--CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-user-md"></i>
                Clinic Edit
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a href="<?php echo base_url('doctor/doctors/clinic/'.encrypt($doctor_id)); ?>"><button class="btn btn-md btn-success list-btn"><i class="fa fa-list"></i> Clinic List</button></a>
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
                   

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user-md"></i> </span>
                        <h2>New Clinic</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">
                            <?php 
                                $clinicname = '';
                                $clinicaddress = '';
                                $clinic_id = '';
                                $latitude = '';
                                $longitude = '';
                               

                                if(!empty($clinic))
                                {
                                    $clinicname = (string)AesCipher::decrypt($clinic[0]->name);
                                    $clinicaddress = (string)AesCipher::decrypt($clinic[0]->address);
                                    $latitude = $clinic[0]->latitude;
                                    $longitude = $clinic[0]->longitude;
                                    $clinic_id = $clinic[0]->id;
                                    $doctor_id = $clinic[0]->doctor_id;
                                }
                                ?>
                            <?php
                            $attributes = ['id' => 'new_clinic','method'=>'post','class'=>'form-horizontal'];
                            echo form_open_multipart('doctor/doctors/updateclinic');
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                   <!--  <label class="col-md-2 control-label">Patient Name<span class="require">*</span></label> -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Clinic Name" required value="<?php echo $clinicname;?>" name="clinic_name" onkeypress="return isText(event)" maxlength="200" minlength="4" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Address" name="address" id="address-input" value="<?php echo $clinicaddress;?>" class="form-control map-input" autocomplete="off" required/>
                                        <input type="hidden" name="address_latitude" id="address-latitude" value="<?php echo $latitude;?>" />
                                        <input type="hidden" name="address_longitude" id="address-longitude" value="<?php echo $longitude;?>" />
                                
                                       <div id="address-map-container" style="display: none;">
                                            <div style="width: 100%; height: 100%" id="address-map"></div>
                                        </div>
                                    </div>
                                </div>

                             <input type="hidden" name="clinic_id" value="<?php echo $clinic_id;?>">
                             <input type="hidden" name="doctor_id" value="<?php echo $doctor_id;?>">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" name="status" required>
                                            <option value="active" <?php echo ($clinic && $clinic[0]->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                            <option value="inactive" <?php echo ($clinic && $clinic[0]->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
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