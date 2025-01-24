<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon"
        href="<?php echo base_url('assets/img/favicon/favicon-16x16.png') . '?random=rand(1000,90000)'; ?>"
        type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/img/favicon/favicon-16x16.png') . '?random=rand(1000,90000)'; ?>"
        type="image/x-icon">
    <!-- Animate With CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontend/css/animate.css'); ?>">
    <!-- Slick Slider -->
    <link href="<?php echo base_url('frontend/css/slick.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('frontend/css/slick-theme.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('frontend/css/intlTelInput.css'); ?>" />
    <!-- Bootstrap Grids -->
    <link href="<?php echo base_url('frontend/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom Stylings -->
    <link href="<?php echo base_url('frontend/css/custom.css'); ?>" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url('frontend/css/jquery.toast.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('frontend/web-fonts-with-css/css/fontawesome-all.min.css'); ?>" rel="stylesheet">

    <!-- Jquery Library -->

    <link rel="stylesheet" href="<?php echo base_url('frontend/select2/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('frontend/select2-bootstrap-theme/select2-bootstrap.min.css'); ?>">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
</head>
<style type="text/css">
    .invalid-feedback {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 100%;
        color: #ea071d;
        margin-left: 0%;
    }


    .toggle.android {
        border-radius: 0px;
    }

    .toggle.android .toggle-handle {
        border-radius: 0px;
    }
</style>


    
    <div id="ribbon">

        <span class="ribbon-button-alignment">
            <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip"
                data-placement="bottom"
                data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
                data-html="true">
                <i class="fa fa-refresh"></i>
            </span>
        </span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Doctor</li>
            <li><a href="doctor/doctors">Doctors</a></li>
            <li>Create</li>
        </ol>

    </div>
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-user-md"></i>
                    Edit Online Time Slots
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
                    <div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false"
                        data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">


                        <header role="heading" class="ui-sortable-handle add-fee-header">
                            <span class="widget-icon"> <i class="fa fa-user-md"></i> </span>
                            <h2>Online Time Slot</h2>
                        </header>


                        <form id="new_doctor_clinic" method="post" class="form-horizontal"
                            action="<?php echo base_url('doctor/doctors/onlineupdate/' . $user_id); ?>"
                            enctype="multipart/form-data">

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-field2 form-group">
                                    <label><?php echo $this->lang->line('How much time will you spent on one patient'); ?>
                                    </label>
                                    <select class="form-control" name="patient_allowed" id="patient_allowed" required>
                                        print_r($patient_time);
                                        <option value="">Select</option>
                                        <?php
                                        for ($i = 1; $i <= 20; $i++) {
                                            $select = ($patient_time == (5 * $i)) ? 'selected' : '';
                                            echo '<option value="' . (5 * $i) . '" ' . $select . '>' . (5 * $i) . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <h6 id="patient_allowed_error" style="color: red;"></h6>
                                </div>
                            </div>

                            <?php $days = array('0' => 'Monday', '1' => 'Tuesday', '2' => 'Wednesday', '3' => 'Thursday', '4' => 'Friday', '5' => 'Saturday', '6' => 'Sunday'); ?>
                            <div class="schedule-days">
                                <?php foreach ($days as $key => $value) {
                                    if (in_array($key, $dys)) {
                                        $check = 'checked';
                                    } else {
                                        $check = '';
                                    }
                                    ?>

                                    <h5> <input class="messageCheckbox_1" type="checkbox" name="day[]"
                                            id="<?php echo $value; ?>" value="<?php echo $key; ?>" <?php echo $check; ?>><?php echo $value; ?></h5>
                                <?php } ?>
                            </div>
                            <div class="schedule-slots">
                                <div class="slots-head">
                                    <h4> Morning Slots </h4>
                                </div>
                                <div class="slots-data">
                                    <?php foreach ($time as $key => $value) {

                                        ?>
                                        <div class="row">
                                            <div>
                                                <input type="time" name="<?php echo $value['day'] . '_morning_from'; ?>"
                                                    id="<?php echo $value['day'] . '_morning_from'; ?>"
                                                    placeholder="<?php echo $this->lang->line('From'); ?>"
                                                    value="<?php echo $value['start_time'] == '00:00:00' ? '' : $value['start_time']; ?>" />
                                            </div>
                                            <div>
                                                <input type="time" name="<?php echo $value['day'] . '_morning_to'; ?>"
                                                    id="<?php echo $value['day'] . '_morning_to'; ?>"
                                                    placeholder="<?php echo $this->lang->line('To'); ?>"
                                                    value="<?php echo $value['end_time'] == '00:00:00' ? '' : $value['end_time']; ?>" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="schedule-slots">
                                <div class="slots-head">
                                    <h4> Evening Slots </h4>
                                </div>
                                <div class="slots-data">
                                    <?php foreach ($time as $key => $value) {
                                        ?>
                                        <div class="row">
                                            <div>
                                                <input type="time" name="<?php echo $value['day'] . '_evening_from'; ?>"
                                                    id="<?php echo $value['day'] . '_evening_from'; ?>"
                                                    placeholder="<?php echo $this->lang->line('From'); ?>"
                                                    value="<?php echo $value['evening_start_time'] == '00:00:00' ? '' : $value['evening_start_time']; ?>" />
                                            </div>
                                            <div>
                                                <input type="time" name="<?php echo $value['day'] . '_evening_to'; ?>"
                                                    id="<?php echo $value['day'] . '_evening_to'; ?>"
                                                    placeholder="<?php echo $this->lang->line('To'); ?>"
                                                    value="<?php echo $value['evening_end_time'] == '00:00:00' ? '' : $value['evening_end_time']; ?>" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <h6 id="day_error" style="color: red;"></h6>
                            <h6 id="time_error" style="color: red;"></h6>


                            <div class="schedule-button">
                                <input type="submit" id="checkBtn" value="submit" type="button" class="btn btn-info">
                            </div>

                        </form>

                    </div>
            </div>
    </div>
    </div>
    </div>
    </section>

           <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
       
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
       
         <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    

<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function () {
        let error = 0;
        const clinicName = $('#clinic_name').val();

        

        const checkedDays = $("input[type=checkbox]:checked");
        if (checkedDays.length === 0) {
            error++;
            $('#day_error').text('You must select at least one day.');
        } else {
            $('#day_error').text('');
        }

        checkedDays.each(function () {
            const day = $(this).val();
            const mfrom = $(`#${day}_morning_from`).val();
            const mto = $(`#${day}_morning_to`).val();
            const efrom = $(`#${day}_evening_from`).val();
            const eto = $(`#${day}_evening_to`).val();

            if (!mfrom && !mto && !efrom && !eto) {
                error++;
                $('#time_error').text('Please fill at least one slot.');
            } else if ((mfrom && !mto) || (efrom && !eto)) {
                error++;
                $('#time_error').text('Please fill both start and end times.');
            } else if ((mto && mto < mfrom) || (eto && eto < efrom)) {
                error++;
                $('#time_error').text('End time should be greater than Start Time.');
            } else {
                $('#time_error').text('');
            }
        });

        if (error > 0) {
            return false; // Prevent form submission
        }
    });
});


</script>