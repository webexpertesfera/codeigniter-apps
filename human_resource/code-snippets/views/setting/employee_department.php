    <!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li>Setting</li><li><a href="human_resource/employee_department">Employee Department</a></li>
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
                Employee Department
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>

    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="human_resource/employee_department/create"><button class="btn btn-success"><i class="fa fa-user"></i> New Department</button></a>
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
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Employee Department List</h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone">ID</th>
                                    <th data-class="expand">Name</th>
                                    <th>Created By</th>
                                    <th data-hide="phone,tablet">Created Time</th>
                                    <th data-hide="phone,tablet">Last Update</th>
                                    <th data-hide="phone,tablet">Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach($data as $value) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $value->name; ?></td>
                                        <td><?php echo $value->created_by; ?></td>
                                        <td><?php echo get_date_time($value->created_time,'Y-m-d h:i:A'); ?></td>
                                        <td><?php echo get_date_time($value->updated_time,'Y-m-d h:i:A'); ?></td>
                                        <td><?php echo $value->is_active==1?'Active':'Inactive'; ?></td>
                                        <td>
                                            <a href="human_resource/employee_department/update/<?php echo $value->id; ?>"><button class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button></a>
                                            <a onclick="return confirm('Are You Sure Delete?')" href="human_resource/employee_department/delete/<?php echo $value->id; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>
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