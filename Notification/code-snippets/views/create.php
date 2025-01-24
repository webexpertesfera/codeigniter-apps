<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    #header {  
        top: 0;
        left: 0;
    }
    select, textarea, input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    button {
        background-color: #4CAF50;
        color: white;
       
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }

    .error.invalid-feedback {
    position: absolute;
    left: 183px !important;
    bottom: -22px;
}
.is-invalid .select2-container--default .select2-selection--single {
    border-color: #dc3545;
}
.error.invalid-feedback {
    position: absolute;
    left: 166px !important;
    bottom: -4px;
}
</style>

<div id="ribbon">
    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"
            rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>
    <ol class="breadcrumb">
        <li>Notification</li>
        <li><a href="category/category">Notification</a></li>
        <li><?php echo $page == 'create' ? 'Create' : 'Edit'; ?></li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-bell"></i>
                <?php
// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Check if the URL contains "edit"
if (strpos($currentUrl, 'edit') !== false) {
    $pageType = 'Notification Update';
} else {
    $pageType = 'Notification Create'; // Or any other default value
}

// Echo the determined page type
echo $pageType;
?>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="notification/sendNotification">
                <button class="btn btn-md btn-success"><i class="fa fa-list"></i> Send Notification List</button>
            </a>
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
                <div class="jarviswidget cstm-appcnt" id="wid-id-5" data-widget-colorbutton="false"
                    data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bell"></i> </span>
                        <h2><?php echo $page == 'create' ? 'New Notification' : 'Edit Notification'; ?></h2>
                    </header>
                    <!-- widget div-->
                    <div class="appcontent-inner">
                        <div class="widget-body">
                            <?php echo form_open_multipart('notification/notification/saveMessage', ['id' => 'notification_form', 'method' => 'post', 'class' => 'form-horizontal']); ?>

                                <input type="hidden" name="notification_id" value="<?php echo $notification->id; ?>">
                                
                                <div class="form-group">
                                        <label for="user_type" class="col-md-2 control-label">Select User Type<span class="require">*</span></label>
                                        <div class="col-md-8">
                                            <select id="user_type" name="user_type" required class="form-control">
                                            <option value="" disabled>Select User Type</option>
                                            <option value="patient" <?php echo $notification->user_type == 'patient' ? 'selected' : ''; ?>>Patient</option>
                                            <option value="doctor" <?php echo $notification->user_type == 'doctor' ? 'selected' : ''; ?>>Doctor</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group" id="patient_group">
                                        <label for="patients" class="col-md-2 control-label">Select Patients<span class="require">*</span></label>
                                        <div class="col-md-8">
                                            <select id="patients" name="patient_id[]" class="form-control select2" multiple>
                                                <option value="all" <?php echo in_array('all', (array) $notification->patients) ? 'selected' : ''; ?>>All Patients</option>
                                                <?php foreach ($patients as $patient): ?>
                                                    <option value="<?php echo $patient->patient_id; ?>" <?php echo in_array($patient->patient_id, (array) $notification->patients) ? 'selected' : ''; ?>>
                                                        <?php echo AesCipher::decrypt($patient->full_name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div id="patients-error" class="error invalid-feedback"></div>
                                    </div>

                                    <div class="form-group" id="doctor_group">
                                        <label for="doctors" class="col-md-2 control-label">Select Doctors<span class="require">*</span></label>
                                        <div class="col-md-8">
                                            <select id="doctors" name="doctor_id[]" class="form-control select2" multiple>
                                                <option value="all" <?php echo in_array('all', $notification->doctors) ? 'selected' : ''; ?>>All Doctors</option>
                                                <?php foreach ($doctors as $doctor): ?>
                                                    <option value="<?php echo $doctor->user_id; ?>" <?php echo in_array($doctor->user_id, $notification->doctors) ? 'selected' : ''; ?>>
                                                        <?php echo AesCipher::decrypt($doctor->first_name); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div id="doctors-error" class="error invalid-feedback"></div>
                                    </div>

                                 <div class="form-group">
                                    <label for="type" class="col-md-2 control-label">Type<span class="require">*</span></label>
                                    <div class="col-md-8">
                                        <select id="type" name="type" required class="form-control">
                                            <option value="" disabled selected>Select Type</option>
                                            <!-- Options will be populated dynamically based on user type -->
                                        </select>
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label for="title" class="col-md-2 control-label">Title <span class="require">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo set_value('title', $notification->title); ?>" maxlength="70" required >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="notification" class="col-md-2 control-label">Notification<span class="require">*</span></label>
                                    <div class="col-md-8">
                                        <textarea id="notification" name="message" id="message" required class="form-control" placeholder="Enter your notification here..." maxlength="1000"><?php echo set_value('message', $notification->message); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <button type="submit" class="btn btn-primary">Send Notification</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </article>
            <!--- COL END ---->
        </div>
        <!-- end row -->
    </section>
    <!-- end widget grid -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="text/javascript">


$(document).ready(function () {
    // Initialize Select2 plugin
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    // Define type options for different user types
    const patientTypes = [
        { value: 'home', text: 'Home' },
        { value: 'appointment', text: 'Appointment' },
        { value: 'health_tips', text: 'Health Tips' },
        { value: 'wallet', text: 'Wallet' },
        { value: 'prescription', text: 'Prescription' },
        { value: 'appointment_rate', text: 'Rate Us' }
    ];

    const doctorTypes = [
        { value: 'home', text: 'Home' },
        { value: 'appointment', text: 'Appointment' },
        { value: 'time_slot', text: 'Time Slot' },
        { value: 'earning', text: 'Earning' },
        { value: 'appointment_rate', text: 'Rate Us' }
    ];

    // Function to populate type select options
    function populateTypeOptions(options, selectedValue) {
        const $typeSelect = $('#type');
        $typeSelect.empty(); // Clear existing options
        $typeSelect.append('<option value="" disabled selected>Select Type</option>'); // Default option
        options.forEach(option => {
            $typeSelect.append(new Option(option.text, option.value, false, option.value === selectedValue));
        });
    }

    // Setup form validation
    $("#notification_form").validate({
    ignore: [],
    rules: {
        "user_type": {
            required: true
        },
        "type": {
            required: true
        },
        "patient_id[]": {
            required: function (element) {
                return $('#user_type').val() === 'patient' && $('#patients').val().length === 0;
            }
        },
        "doctor_id[]": {
            required: function (element) {
                return $('#user_type').val() === 'doctor' && $('#doctors').val().length === 0;
            }
        },
        "title": {
            required: true,
         
            maxlength: 20 // Added maxlength for consistency
        },
        "message": {
            required: true,
           
            maxlength: 100 // Added maxlength for consistency
        }
    },
    messages: {
        "user_type": {
            required: "Please select a user type."
        },
        "type": {
            required: "Please select a type."
        },
        "patient_id[]": {
            required: "Please select at least one patient."
        },
        "doctor_id[]": {
            required: "Please select at least one doctor."
        },
        "title": {
            required: "Please enter a title.",
           
            maxlength: "Title must be at most 15 characters long."
        },
        "message": {
            required: "Please enter a notification message.",
           
            maxlength: "Message must be at most 100 characters long."
        }
    },
    errorElement: "div",
    errorPlacement: function (error, element) {
        if (element.hasClass('select2-hidden-accessible')) {
            error.addClass('text-danger');
            error.insertAfter(element.next('.select2-container'));
        } else {
            error.addClass('text-danger');
            error.insertAfter(element);
        }
    },
    highlight: function (element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    onfocusout: function (element) {
        $(element).valid();
    }
});

    // Ensure Select2 elements trigger validation on change
    $('.select2').on('change', function () {
        $(this).valid();
    });

    // Hide or show patient and doctor selection based on user type
    $('#user_type').on('change', function () {
        var userType = $(this).val();
        var selectedType = $('#type').val();
        if (userType === 'patient') {
            $('#patient_group').show();
            $('#doctor_group').hide();
            populateTypeOptions(patientTypes, selectedType);
        } else if (userType === 'doctor') {
            $('#doctor_group').show();
            $('#patient_group').hide();
            populateTypeOptions(doctorTypes, selectedType);
        } else {
            $('#patient_group').hide();
            $('#doctor_group').hide();
            $('#type').empty().append('<option value="" disabled selected>Select Type</option>'); // Clear options
        }
    }).trigger('change'); // Trigger the change event on page load to set the initial visibility

    // Initial setup for type options based on existing notification data
    const userType = $('#user_type').val();
    const existingType = '<?php echo $notification->type; ?>'; // Ensure this value is correctly passed
    if (userType === 'patient') {
        populateTypeOptions(patientTypes, existingType);
    } else if (userType === 'doctor') {
        populateTypeOptions(doctorTypes, existingType);
    }
});







</script>

<!-- <script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2 plugin
    $('.select2').select2();

    // Form submission event
    document.querySelector('form').addEventListener('submit', function (event) {

        let valid = true;

        // Get Select2 dropdown values
        let patients = document.getElementById('patients').value;
        let doctors = document.getElementById('doctors').value;
        // Error message containers
        let patientsError = document.getElementById('patients-error');
        let doctorsError = document.getElementById('doctors-error');

        // Clear previous error messages
        patientsError.textContent = '';
        doctorsError.textContent = '';

        // Validate patients dropdown
        if (patients.length === 0) {
            patientsError.textContent = 'Please select at least one patient.';
            valid = false;
        }

        // Validate doctors dropdown
        if (doctors.length === 0) {
            doctorsError.textContent = 'Please select at least one doctor.';
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });
});
</script> -->
