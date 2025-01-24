
<div id="ribbon">

   <span class="ribbon-button-alignment">
      <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
         <i class="fa fa-refresh"></i>
      </span>
   </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Admin Notification</li>
      <li><a href="notification/notification">Admin Notification</a></li>
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
                Admin Notification List </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>
 
    <!--- update notification---->
    <?php $this->load->view('alert'); ?>

     <!-- <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="patient/patients/create"><button class="btn btn-success"><i class="fa fa-user-md custom"></i> New Patient</button></a>
        </article>
    </div>  -->

    </br>



    <!-- widget grid -->
    <section id="widget-grid" class="reset-change ">
        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-lightgray  notifyyy"  data-widget-editbutton="true">
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
                        <span class="widget-icon"><i class="fa fa-bell"></i> </span>
                        <h2> Admin Notification </h2>
                    </header>
                   

                    <!-- widget div-->
                    <div class="employee-list notification-list">

                        <!-- widget content -->
                        <div class="widget-body no-padding">
                          <div class="table-responsive">
                          <button style="margin: 10px; float: right;" class="btn btn-primary delete_all" data-url="/itemDelete">Delete Checked Row</button>

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                           <tr role="row">
                            <th>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="checkAll"> Check All
                            </label></th>
                              <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Title" style="width: 70px;">
                                 Sr No.
                              </th>
                               <th class="sorting" tabindex="0" aria-controls="listofnotifications" rowspan="1" colspan="1" 
                        aria-label="Description: activate to sort column ascending" style="">Title</th>
                              <th class="sorting" tabindex="0" aria-controls="listofnotifications" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="">Description</th>                             
                              <th class="sorting" tabindex="0" aria-controls="listofnotifications" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 208px;"> Date </th>
                              <th class="sorting" tabindex="0" aria-controls="listofnotifications" 
                              rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="">
                               Action </th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if($notification)
                           {
                            $i = 1;
                              foreach($notification as $key)
                              {
                                 
                                 ?>
                           <tr class="odd">
                           <!-- <td><input type="checkbox" data-id="<?php// echo $key->id; ?>"></td> -->
                           <td><input type="checkbox" class="single_slot" value="<?php echo $key->id; ?>"/></td>
                              <td><?php echo $i;?></td>
                               <td><?php echo $key->title;?></td>
                              <td><?php echo $key->descripttion;?></td>
                             <td><?php echo date( 'jS M Y', strtotime($key->create_date));?></td>
                             <td><a href="<?php echo base_url('notification/notification/delete/'.encrypt($key->id));?>"><button class="btn btn-info"><i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button></td>
                           </tr>
                          <?php 
                              $i++;}
                           }
                           ?>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    $('#checkAll').on('click', function() {
        $('input[type="checkbox"].single_slot').prop('checked', $(this).prop('checked'));
        updateCheckedRows();
    });

    $('input[type="checkbox"].single_slot').on('click', function() {
        updateCheckedRows();
    });

    function updateCheckedRows() {
        $('input[type="checkbox"].single_slot').each(function() {
            var isChecked = $(this).prop('checked');
            $(this).closest('tr').toggleClass('checked', isChecked);
        });
    }

    $('.delete_all').on('click', function() {
        var selectedIds = [];

        $('input[type="checkbox"]:checked').each(function() {
            selectedIds.push($(this).val()); 
        });

        if (selectedIds.length > 0) {
            $.ajax({
                url: 'notification/notification/delete_selected',
                type: 'POST',
                data: { ids: selectedIds },
                success: function(response) {
                    console.log(response);
                    window.location.reload();     
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    });

    $('input[type="checkbox"].single_slot').on('click', function() {
        var isChecked = $(this).prop('checked');
        $(this).closest('tr').toggleClass('checked', isChecked);
    });
});

</script>