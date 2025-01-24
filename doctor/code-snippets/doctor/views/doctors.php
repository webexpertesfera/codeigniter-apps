<!--RIBBON -->
<style>
    /* Add scrolling for modal body */
    .modal-body {
        max-height: 400px; /* You can adjust this height as needed */
        overflow-y: auto; /* Makes the content scrollable */
    }

    /* Ensure modals stack in the correct order */
 
    /* Optional: Add custom positioning for modals */
    
</style>

<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Doctors</li><li><a href="doctor/doctors">Doctors</a></li>
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
                 List of Doctors
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>


    <!--- update notification---->
    <?php $this->load->view('alert'); ?>

            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- New Doctor Button -->
                        <a href="doctor/doctors/create">
                            <button class="btn btn-theme btn-success">
                                <i class="fa fa-user-md custom"></i> New Doctor
                            </button>
                        </a>

                        <!-- Export Button -->
                        <a href="<?php echo base_url('doctor/doctors/export_doctors'); ?>">
                            <button class="btn btn-theme btn-success">
                                <i class="fa fa-download"></i> Export Doctors
                            </button>
                        </a>
                    </div>
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
                        <h2>List of Doctors</h2>

                    </header>

                    <!-- widget div-->
                    <div class="employee-list doctors">

                        <!-- widget content -->
                        <div class="widget-body no-padding">
 <div class="table-responsive">
                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone"><p>ID</p></th>
                                    <th data-class="expand"><p>Doctor Id</p></th>
                                    <!-- <th data-class="expand"><p>Registration Id</p></th> -->
                                    <th data-class="expand"><p>Name</p></th>
                                    <th data-hide="phone"><p>Mobile</p></th>
                                    <th data-hide="phone"><p>Email</p></th>
                                    <th data-class="expand"><p>RCC Number</p></th>
                                    <th data-class="expand"><p>Wallet</p></th>
                                    <!-- <th>Created By</th>
                                    <th data-hide="phone,tablet">Last Update</th> -->
                                    <th data-hide="phone,tablet"><p>Status</p></th>
                                    <th data-hide="phone,tablet"><p>Approval Status</p></th>
                                    <th data-hide="phone,tablet"><p>Is Online Slot Available</p></th>
                                    <th data-hide="phone,tablet"><p>Is Document Uploded</p></th>
                                     <th data-hide="phone,tablet"><p>Is Commission Added</p></th>
                                     <th data-hide="phone,tablet"><p>Add Time Slot</p></th>
                                    <th style="width:16%;"><p>Action</p></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                // prx($data);
                                $secretKey = '26kozQaKwRuNJ24t26kozQaKwRuNJ24t';
                                $uniqueDoctorIds = [];
                                $sl=1; 
                                foreach($data as $value){ 
                                    if (!in_array($value->doctor_id, $uniqueDoctorIds)) {
                                        // If not, add it to the array and display the row
                                        $uniqueDoctorIds[] = $value->doctor_id;
                                        ?>
                                        
                                    <tr>
                                        <td><?php echo $sl++; ?></td>
                                        <td><?php echo $value->doctor_id; ?></td>
                                       <!--  <td><?=empty($value->registeration_no) ? '' : AesCipher::decrypt($value->registeration_no); ?></td> -->
                                        <td><?php echo (string)AesCipher::decrypt($value->first_name); ?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->country_code).(string)AesCipher::decrypt($value->mobile_no); ?></td>
                                        <td><?php echo (string)AesCipher::decrypt($value->email); ?></td>
                                        <td><?=empty($value->rcc_no) ? 'NA' : AesCipher::decrypt($value->rcc_no); ?></td>
                                        <!-- <td><a target="_blank" href="welcome/employee_details/<?php echo $value->created_by; ?>"><?php echo $value->created_by; ?></a></td> -->
                                       <!--  <td><?php echo get_date_time($value->updated_time,'Y-m-d h:i:A'); ?></td> -->
                                       <td>
                                            <?php
                                            if (!empty($value->new_bal)) {
                                                echo $value->new_bal . ' NGN';
                                            } else {
                                                echo '0.00 NGN';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $value->is_active==1?'Active':'Inactive'; ?></td>
                                         <td><?php echo $value->admin_approve==1?'Approved':'Unapproved'; ?></td>
                                         <td><?php echo $value->available_slots_count; ?></td>
                                          <td><?php echo $value->is_document_uploaded; ?></td>
                                          <td><?php echo $value->is_commission_added; ?></td>
                                          <td>
                                                <?php if (!empty($value->is_online_seleted=='Yes')) { ?> <!-- Replace with your condition -->
                                                    <a data-toggle="tooltip" data-placement="top" title="Online Time Slot" href="<?php echo base_url('doctor/doctors/online_time_slot/' . $value->user_id); ?>">
                                                        <button class="btn btn-success">
                                                            <i class="fa fa-clock-o"></i> <!-- Online time slot icon -->
                                                        </button>
                                                    </a>
                                                <?php } else { ?>
                                                    <!-- Optional: Show a disabled button or a message -->
                                                    <button class="btn btn-secondary" disabled>
                                                        <i class="fa fa-clock-o"></i> <!-- Online time slot icon -->
                                                    </button>
                                                <?php } ?>


                                            <!-- Clinic Time Slot Icon -->
                                             <?php if (!empty($value->is_clinic_seleted=='Yes')) { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="clinic time slot" href="<?php echo base_url('doctor/doctors/clinic/'.$value->user_id); ?>">
                                                <button class="btn btn-warning">
                                                    <i class="fa fa-calendar"></i> <!-- Clinic time slot icon -->
                                                </button>
                                            </a>
                                          <?php }else { ?>
                                                <!-- Optional: Show a disabled button or a message -->
                                                <button class="btn btn-secondary" disabled>
                                                    <i class="fa fa-calendar"></i> <!-- Online time slot icon -->
                                                </button>
                                            <?php } ?></td>
                                        <td class="actions-btn-2">
                                        <p class="table-btns">
                                            <a data-toggle="tooltip" data-placement="top" title="Edit Commission" href="<?php echo base_url('doctor/doctors/add_commission/'.encrypt($value->user_id)); ?>"><button class="btn btn-info"><i class="fa fa-usd"></i></button></a> 
                                            <a data-toggle="tooltip" data-placement="top" title="View Details" href="doctor/doctors/view/<?php echo encrypt($value->user_id); ?>"><button class="btn btn-info"><i class="fa fa-eye"></i></button></a> 
                                            <button value="<?= $value->user_id; ?>" class="btn btn-info deleteDoctor"><i class="fa fa-trash-o"></i></button>
                                            <?php if($value->admin_approve != 2){ ?>                                          
                                                <a data-toggle="tooltip" data-placement="top" title="Reject" href="javascript:void(0);" onclick="showDoctorRejectModel(<?=$value->user_id ?>)"><button class="btn btn-danger"><i class="fa fa-ban"></i></button></a>
                                            <?php }
                                            if($value->admin_approve != 1) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Approve" href="doctor/doctors/status/<?php echo $value->doctor_id.'/'.'approve'; ?>"><button class="btn btn-success"><i class="fa fa-check"></i></button></a>
                                            <?php } ?>
                                            <a data-toggle="tooltip" data-placement="top" title="edit doctor" href="<?php echo base_url('doctor/doctors/update/'.$value->user_id); ?>"><button class="btn btn-info"><i class="fa fa-pencil"></i></button></a>
                                            <button value="<?= $value->user_id; ?>" data-balance="<?= $value->new_bal; ?>" class="btn btn-info rewardDoctor"><i class="fa fa-gift"></i></button> <!-- Reward Button -->
                                            <button value="<?= $value->user_id; ?>"  data-bal="<?= $value->new_bal; ?>" class="btn btn-danger deductMoney"><i class="fa fa-minus-circle"></i></button>&nbsp;

                                          <!-- Online Time Slot Icon -->
                                            
                                        </p>
                                    </td>

                                    </tr>
                                <?php }} ?>
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
<!-- END MAIN CONTENT -->
<!-- Start Reward Model -->
<div class="modal fade" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="rewardModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="rewardForm" method="POST" action="<?= base_url() ?>doctor/doctors/rewardDoctor">
               <div class="custom-modal">
                  <h3>Add Reward Amount</h3>
                  <input type="number" name="reward_amount" class="form-control" placeholder="Enter Reward Amount" min="0" required>
                  <input type="hidden" name="doctor_id" id="rewardDoctorId">
                  <div class="reward-approve-btn-d" style="margin-top: 25px;">
                     <button type="submit" class="reward-btn">Submit</button>
                     <button type="button" data-dismiss="modal" class="reapprove-btn">Cancel</button>
                     <button type="button" class="wallet-btn" data-toggle="modal" data-target="#walletTransactionModal">View Wallet Transactions</button><br>
                     <div id="doctorBalance" style="margin-left: 437px;"></div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Wallet Transaction Modal -->
<div class="modal fade" id="walletTransactionModal" tabindex="-1" role="dialog" aria-labelledby="walletTransactionModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="walletTransactionModalLabel">Wallet Transactions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Wallet transaction content -->
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Date</th>
                     <th>Booking</th>
                     <th>Amount</th>
                     <th>Type</th>
                     <th>Added By</th>

                  </tr>
               </thead>

               <tbody id="walletTransactionList">
                  <!-- Wallet transaction rows will go here -->
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

<!-- End Reward Model -->


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
<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really want to add reward?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Deduct Modal -->
<div id="deductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deductModalLabel">Deduct Money from Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deductForm">
                    <div class="form-group">
                        <label for="deductAmount">Deduct Amount</label>
                        <input type="number" class="form-control" id="deductAmount" name="deduct_amount" required min="0" placeholder="Enter Deduct Amount">
                    </div>


                    <input type="hidden" id="deductDoctorId">
                    <button type="submit" class="btn btn-primary deduct-btn">Submit</button>
                    <button type="button" class="wallet-btn-rej" data-toggle="modal" data-target="#walletTransactionModal">View Wallet Transactions</button><br>

                    <span id="doctorBal" style="margin-left: 200px;">Balance: <strong id="walletBalance"></strong></span>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Confirmation Modal for Deduct -->
<div id="deductConfirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deductConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deductConfirmationModalLabel">Confirm Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really want to deduct the amount?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmDeductSubmit">Confirm</button>

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

   
   document.getElementById('rewardForm').addEventListener('submit', function (e) {
       const rewardAmount = document.querySelector('input[name="reward_amount"]').value;
       if (rewardAmount < 0) {
           alert("Negative values are not allowed for reward amount.");
           e.preventDefault(); // Prevent form submission
       }
   });

$(document).ready(function(){
    // Delegate the click event to a static parent element
    $(document).on('click', '.rewardDoctor', function(e){
        e.preventDefault();
        
        var doctorId = $(this).val();
        $('#rewardDoctorId').val(doctorId);
        var doctorBalance = $(this).data('balance'); 
        $('#doctorBalance').html('<span style="font-weight: bold;"> Wallet Bal: ' + doctorBalance + ' NGN</span>');
        $('#rewardModal').modal('show');
    });

    // Handle form submission for reward
    $('#rewardForm').submit(function(e){
        e.preventDefault();

        var rewardAmount = $('input[name="reward_amount"]').val();
        var doctorId = $('#rewardDoctorId').val();

        if (!rewardAmount || !doctorId) {
            toastr.error('Please enter a reward amount.');
            return;
        }

        $('#confirmationModal').modal('show');
    });

    // Handle confirmation modal action for reward
    $('#confirmSubmit').click(function(){
        var rewardAmount = $('input[name="reward_amount"]').val();
        var doctorId = $('#rewardDoctorId').val();

        // Show loading spinner or disable submit button
        $('.reward-btn').prop('disabled', true).text('Submitting...');

        $.ajax({
            type: "POST",
            url: 'doctor/doctors/rewardDoctor',
            data: {
                reward_amount: rewardAmount,
                doctor_id: doctorId
            },
            success: function(response) {
                var data = JSON.parse(response);

                if (data.status === true) {
                    toastr.success(data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                    // Re-enable the button in case of an error
                    $('.reward-btn').prop('disabled', false).text('Submit');
                }

                $('#rewardModal').modal('hide');
                $('#confirmationModal').modal('hide');
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
                // Re-enable the button in case of an error
                $('.reward-btn').prop('disabled', false).text('Submit');
                $('#rewardModal').modal('hide');
                $('#confirmationModal').modal('hide');
            }
        });
    });

    // Handle deduct doctor action
    $(document).on('click', '.deductMoney', function(e){
        e.preventDefault();
        
        var doctorId = $(this).val();
        $('#deductDoctorId').val(doctorId);
        var doctorBalance = $(this).data('bal'); 
        if(doctorBalance > 0){
           $('#doctorBal').html('<span style="font-weight: bold;"> Wallet Bal: ' + doctorBalance + ' NGN</span>');
            $('#deductModal').modal('show'); 
        }else{
             toastr.error("Insufficient wallet balance: Unable to deduct money as the user's wallet balance is zero.");
            return;
        }
        
    });

    // Handle form submission for deduct
    $('#deductForm').submit(function(e){
        e.preventDefault();

        var deductAmount = $('input[name="deduct_amount"]').val();
        var doctorId = $('#deductDoctorId').val();

        if (!deductAmount || !doctorId) {
            toastr.error('Please enter an amount to deduct.');
            return;
        }

        $('#deductConfirmationModal').modal('show');
    });

    // Handle confirmation modal action for deduct
    $('#confirmDeductSubmit').click(function(){
        var deductAmount = $('input[name="deduct_amount"]').val();
        var doctorId = $('#deductDoctorId').val();

        // Show loading spinner or disable submit button
        $('.deduct-btn').prop('disabled', true).text('Submitting...');

        $.ajax({
            type: "POST",
            url: 'doctor/doctors/deductDoctor',
            data: {
                deduct_amount: deductAmount,
                doctor_id: doctorId
            },
            success: function(response) {
                var data = JSON.parse(response);

                if (data.status === true) {
                    toastr.success(data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                    // Re-enable the button in case of an error
                    $('.deduct-btn').prop('disabled', false).text('Submit');
                }

                $('#deductModal').modal('hide');
                $('#deductConfirmationModal').modal('hide');
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
                // Re-enable the button in case of an error
                $('.deduct-btn').prop('disabled', false).text('Submit');
                $('#deductModal').modal('hide');
                $('#deductConfirmationModal').modal('hide');
            }
        });
    });

    // Handle delete doctor action
    $(document).on('click', '.deleteDoctor', function(e){
        e.preventDefault();
        if (confirm('Are you sure You want to delete?')) {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: 'doctor/doctors/deleteDoctor',
                data: { user_id: id },
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status=true){
                        toastr.success(data.message);
                        setInterval(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    });

    // When the 'View Wallet Transactions' button is clicked
 $('.wallet-btn').on('click', function() {
    $('#rewardModal').modal('hide');
    var doctorId = $('#rewardDoctorId').val(); // Assuming doctor_id is set correctly
    
    // Make an AJAX request to fetch the wallet transactions for the doctor
    $.ajax({
        url: '<?= base_url() ?>doctor/doctors/getWalletTransactions/' + doctorId, // Replace with your correct endpoint
        method: 'GET',
        data: { doctor_id: doctorId },
        success: function(response) {
        var response = JSON.parse(response);            
            // Ensure response.data is an array
            if (response.status == 'success') {
                var transactionList = response.data;
                var tableContent = '';

                // Loop through the transaction data and create table rows
                $.each(transactionList, function(index, transaction) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + transaction.created_at + '</td>';
                    tableContent += '<td>' + (transaction.booking_id ? transaction.booking_id : 'N/A') + '</td>';
                    tableContent += '<td>' + transaction.amount + '</td>';
                    tableContent += '<td>' + transaction.type + '</td>';
                    tableContent += '<td>' + (transaction.added_by ? transaction.added_by : 'N/A') + '</td>';
                    tableContent += '</tr>';
                });

                // Insert the table rows into the modal's transaction list
                $('#walletTransactionList').html(tableContent);
            } else {
                // If response.data is not an array or no data, show a message
                $('#walletTransactionList').html('<tr><td colspan="6">No transactions found or invalid data format.</td></tr>');
            }
        },
        error: function() {
            $('#walletTransactionList').html('<tr><td colspan="6">Error fetching data.</td></tr>');
        }
    });
});

  $('.wallet-btn-rej').on('click', function() {
      $('#deductModal').modal('hide');
    var doctorId = $('#deductDoctorId').val(); // Assuming doctor_id is set correctly
    
    // Make an AJAX request to fetch the wallet transactions for the doctor
    $.ajax({
        url: '<?= base_url() ?>doctor/doctors/getWalletTransactions/' + doctorId, // Replace with your correct endpoint
        method: 'GET',
        data: { doctor_id: doctorId },
        success: function(response) {
        var response = JSON.parse(response);            
            // Ensure response.data is an array
            if (response.status == 'success') {
                var transactionList = response.data;
                var tableContent = '';

                // Loop through the transaction data and create table rows
                $.each(transactionList, function(index, transaction) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + transaction.created_at + '</td>';
                    tableContent += '<td>' + (transaction.booking_id ? transaction.booking_id : 'N/A') + '</td>';
                    tableContent += '<td>' + transaction.amount + '</td>';
                    tableContent += '<td>' + transaction.type + '</td>';
                    tableContent += '<td>' + (transaction.added_by ? transaction.added_by : 'N/A') + '</td>';
                    tableContent += '</tr>';
                });

                // Insert the table rows into the modal's transaction list
                $('#walletTransactionList').html(tableContent);
            } else {
                // If response.data is not an array or no data, show a message
                $('#walletTransactionList').html('<tr><td colspan="6">No transactions found or invalid data format.</td></tr>');
            }
        },
        error: function() {
            $('#walletTransactionList').html('<tr><td colspan="6">Error fetching data.</td></tr>');
        }
    });
});


});

</script>