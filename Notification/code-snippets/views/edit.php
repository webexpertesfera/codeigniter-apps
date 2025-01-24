<style>
    /* Same as before */
</style>
<div id="ribbon">
    <!-- Same as before -->
</div>
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark dashboard-title">
                <i class="fa fa-user-md"></i>
                Edit Notification
            </h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="notification/sendNotification"><button class="btn btn-md btn-success"><i class="fa fa-list"></i> Send Notification List</button></a>
        </div>
    </div>
    <?php $this->load->view('alert'); ?>
    <section id="widget-grid" class="reset-change edit">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget cstm-appcnt" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-user-md"></i> </span>
                        <h2>Edit Notification</h2>
                    </header>
                    <div class="appcontent-inner">
                        <div class="widget-body">
                            <?php echo form_open_multipart('notification/notification/update/' . $notification->id, ['id' => 'edit_message', 'method' => 'post', 'class' => 'form-horizontal']); ?>
                                <div class="form-group">
                                    <label for="patients" class="col-md-2 control-label">Select Patients:</label>
                                    <div class="col-md-8">
                                        <select id="patients" name="patient_id[]" class="form-control select2" multiple>
                                            <option value="all" <?php echo (in_array('all', $notification->patient_id)) ? 'selected' : ''; ?>>All Patients</option>
                                            <?php foreach ($patients as $patient): ?>
                                                <option value="<?php echo $patient->patient_id; ?>" <?php echo (in_array($patient->patient_id, $notification->patient_id)) ? 'selected' : ''; ?>>
                                                    <?php echo AesCipher::decrypt($patient->full_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="doctors" class="col-md-2 control-label">Select Doctors:</label>
                                    <div class="col-md-8">
                                        <select id="doctors" name="doctor_id[]" class="form-control select2" multiple>
                                            <option value="all" <?php echo (in_array('all', $notification->doctor_id)) ? 'selected' : ''; ?>>All Doctors</option>
                                            <?php foreach ($doctors as $doctor): ?>
                                                <option value="<?php echo $doctor->user_id; ?>" <?php echo (in_array($doctor->user_id, $notification->doctor_id)) ? 'selected' : ''; ?>>
                                                    <?php echo AesCipher::decrypt($doctor->first_name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title" class="col-md-2 control-label">Title <span class="require">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo $notification->title; ?>" required="required">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="notification" class="col-md-2 control-label">Notification:</label>
                                    <div class="col-md-8">
                                        <textarea id="notification" name="message" class="form-control" placeholder="Enter your notification here..."><?php echo $notification->message; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <button type="submit" class="btn btn-primary">Update Notification</button>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('body').addClass("side-t")
});
</script>
