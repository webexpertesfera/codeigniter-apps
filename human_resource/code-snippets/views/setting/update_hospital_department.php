<!-- RIBBON -->
<div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Human Resource</li><li><a href="human_resource/hospital_department">Hospital Department</a></li><li>Update</li>
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

<!--CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-edit fa-fw "></i>
                Update Hospital Department
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <a href="human_resource/hospital_department"><button class="btn btn-md btn-success list-btn"><i class="fa fa-list"></i> Department List</button></a>
        </div>
    </div>

    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <!-- widget grid -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW COL START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-8">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false"	data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
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
                        <span class="widget-icon"> <i class="fa fa-pencil"></i> </span>
                        <h2>Update Hospital Department</h2>
                    </header>

                    <!-- widget div-->

                    <div>

                        <!-- widget content -->
                        <div class="widget-body">

                            <?php
                            $attributes = ['id' => 'hospital_department_update','method'=>'post'];
                            echo form_open('human_resource/hospital_department/update', $attributes);
                            ?>

                            <fieldset>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Name" required="required" value="<?php echo $data->name; ?>" name="name"/>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $data->id; ?>"/>
                                    <label>Description</label>
                                    <textarea name="description" placeholder="Description" class="form-control"><?php echo $data->description; ?></textarea>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label>Establish Year</label>
                                    <select class="form-control" name="establish_year" required>
                                        <option value="">Select</option>
                                        <?php for($i=1990;$i<=date("Y");$i++){ ?>
                                            <option <?php echo ($data->establish_year==$i?"selected":false); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" <?php echo ($data->is_active==1?"selected":false); ?>>Active</option>
                                        <option value="2" <?php echo ($data->is_active==2?"selected":false); ?>>Inactive</option>
                                    </select>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn-md btn btn-primary" name="submit" type="submit">Update
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
<!-- END CONTENT -->