<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li><a href="human_resource/hr_employee">Employee</a></li>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-list-alt"></i>
                Employee List
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>

    <!--- update notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="human_resource/hr_employee/create"><button class="btn btn-success"><i class="fa fa-user"></i> New Employee</button></a>
        </article>
    </div>

    </br>


    <style>

    </style>


    <!-- widget grid -->
    <section id="widget-grid" class="reset-change">
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
                        <h2>Employee List</h2>

                    </header>

                    <!-- widget div-->
                    <div class="employee-list">

                        <!-- widget content -->
                        <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone">ID</th>
                                    <th data-class="expand">Employee Id</th>
                                    <th data-class="expand">Name</th>
                                    <th data-hide="phone">Mobile</th>
                                    <th data-hide="phone">Email</th> 
                                   <!--  <th data-hide="phone">Country</th> -->
                                    <th data-hide="phone,tablet">Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <?php $sl=1; foreach($data as $value){
                                        $cr =getcreated_by($value->created_by);
                                     ?>
                                        <tr>

                                            <td><?php echo $sl++; ?></td>
                                            <td><?php echo $value->employee_id; ?></td>
                                            <td><?php echo AesCipher::decrypt($value->full_name); ?></td>
                                            <td><?php echo AesCipher::decrypt($value->mobile_no); ?></td>
                                            <td><?php echo AesCipher::decrypt($value->email); ?></td>
                                             <!-- <td><?php echo $value->country; ?></td> -->
                                           
                                            <td><?php echo $value->is_active==1?'Active':'Inactive'; ?></td>
                                            <td>
                                                <a href="human_resource/hr_employee/update/<?php echo $value->id; ?>"><button class="btn btn-info"><i class="fa fa-edit"></i></button></a>
                                               <!--  <a target="_blank" href="welcome/employee_details/<?php echo $value->employee_id; ?>"><button class="btn btn-success"><i class="fa fa-list-alt"></i></button></a> -->
                                               <button value="<?= $value->id; ?>" class="btn btn-info deleteEmployee"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
       $('body').addClass("side-t");
 
       
});

//$("deleteCategory") deleteCategory(id){
$('.deleteEmployee').click(function(e){
     e.preventDefault();
     if (confirm('Are you sure You want to delete?')) {
        var id=$(this).val();
        $.ajax({
            type: "POST",
            url: 'human_resource/hr_employee/deleteEmployee',
            data:{ id: id},
            success: function(response) {
                var data = JSON.parse(response);
                if(data.status="success"){
                    toastr.success(data.message);
                    setInterval(function() {
                        location.reload();
                    }, 2000);
                }else{
                    toastr.error(data.message);
                }
              

            }
      });
    }
});
</script>
<!-- END MAIN CONTENT -->