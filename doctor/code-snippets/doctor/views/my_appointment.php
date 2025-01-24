<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctor</li><li><a href="appointment">Doctor Appointment</a></li>
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
                My Appointment
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>

    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
        </article>
        <article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <form class="form-inline" method="post" action="doctor/appointment">
                <div class="form-group">
                    <label for="pwd">Date:</label>
                    <input type="text" class="form-control date_picker" value="<?php echo isset($_POST['date'])?$_POST['date']:date("Y-m-d"); ?>" placeholder="Y-m-d" name="date">
                </div>
                <button type="submit" name="search" class="btn btn-info"><i class="fa fa-search"></i></button>
            </form>
        </article>
    </div>

    </br>

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
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>My Appointment List</h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone">ID</th>
                                    <th data-hide="phone">Appointment ID</th>
                                    <th data-class="expand">Patient Id</th>
                                    <th data-class="expand">Patient Name</th>
                                    <th data-class="expand">date</th>
                                    <th data-class="expand">Slot</th>
                                    <th data-class="expand">Serial</th>
                                    <th data-class="expand">Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach($data as $value){ ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $value->appointment_id; ?></td>
                                        <td><a target="_blank" href="welcome/patient_details/<?php echo $value->patient_id;  ?>"><?php echo $value->patient_id; ?></a></td>
                                        <td><?php echo $value->patient_name; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                        <td><?php echo $value->slot; ?></td>
                                        <td><?php echo $value->serial_no; ?></td>
                                        <td><?php echo $value->is_prescribe==1?'<span class="prescribe">Prescribe</span>>':'<span class="not_prescribe">Not Prescribed</span>'; ?></td>
                                        <td>
                                            <?php
                                            if($value->is_prescribe==0) {
                                            ?>
                                                <a href="prescription/create?app_id=<?php echo $value->appointment_id; ?>">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-file"></i></button>
                                                </a>
                                            <?php } ?>
                                            <a  href="prescription?patient_id=<?php echo $value->patient_id; ?>">
                                                <button type="button" class="btn btn-warning"><i class="fa fa-list"></i></button>
                                            </a>
                                            <a  href="patient/case_history?patient_id=<?php echo $value->patient_id; ?>">
                                                <button type="button" class="btn btn-primary"><i class="fa fa-bookmark"></i></button>
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
<!-- END MAIN CONTENT -->