<!--RIBBON -->
<style type="text/css">
    input.form-control {
    height: 34px;
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
        <li>Doctors</li><li><a href="doctor/doctors/clinic">Clinic</a></li>
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

<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-list-alt"></i>
                Clinic List
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>


    <!--- update notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="doctor/doctors/create_clinic/<?php echo ($doctor_id);?>"><button class="btn btn-theme"><i class="fa fa-user-md custom"></i> New Clinic</button></a>
        </article>
    </div> 

    </br>


    <style>

    </style>


    <!-- widget grid -->
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-lightgray" data-widget-editbutton="true">
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
                        <span class="widget-icon"> <i class="fa fa-list"></i> </span>
                        <h2>Clinic List</h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone">Sr No.</th>
                                    <th data-class="expand">Clinic Name</th>
                                    <th data-class="expand">Address</th>
                                    <th data-hide="phone">Status</th>                                  
                                    <th style="width:16%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $sl=1; foreach($data as $value){ ?>
                                    <tr>
                                        <td><?php echo $sl++; ?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->name);?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->address);?></td>
                                        
                                        <td><?php echo $value->status=='active'?'Active':'Inactive'; ?></td>
                                        
                                                                                 
                                            <td class="action-buttons">                                     
                                   <a href="<?php echo base_url('doctor/doctors/edit_clinic/'.($value->id).'/'.$doctor_id);?>" data-toggle="tooltip" data-placement="top" title="Edit Clinic" class="bg-red">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo base_url('doctor/doctors/delete/'.($value->id).'/'.($value->doctor_id));?>" data-toggle="tooltip" data-placement="top" title="Delete Clinic" class="bg-red delete-btn">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?php echo base_url('doctor/doctors/add_timeslot/'.($value->id).'/'.$doctor_id);?>" data-toggle="tooltip" data-placement="top" title="Add Timeslot" class="bg-green">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>

                                 </td> 
                                       
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT