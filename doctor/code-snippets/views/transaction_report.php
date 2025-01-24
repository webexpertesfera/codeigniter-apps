<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-list-alt"></i>
                Transaction Report
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
    </div>

    <!--- form submit notification---->
    <?php $this->load->view('alert'); ?>

    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                        <h2> Transaction Report </h2>

                    </header>

                    <!-- widget div-->
                    <div>



                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone">SL</th>
                                    <th data-hide="phone">Record ID</th>
                                    <th data-hide="phone">Record Type</th>
                                    <th data-hide="phone">Invoice ID</th>
                                    <th data-hide="phone">Transaction Type</th>
                                    <th data-hide="phone">Debit</th>
                                    <th data-hide="phone">Credit</th>
                                    <th data-hide="phone">Amount</th>
                                    <th data-hide="phone">Created By</th>
                                    <th data-hide="phone">Created Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $transaction_type = [
                                    1=>'expense',
                                    2=>'income',
                                    3=>'transport',
                                    4=>'admission',
                                    5=>'service',
                                    6=>'doctor service commission',
                                    7=>'doctor appointment fees',
                                    8=>'Drawing & Capital',
                                    9=>'Tax Payment'
                                ];
                                $i=1;
                                foreach($data as $value) {
                                    $url = $value->record_type==1?'welcome/employee_details/':($value->record_type==2?'welcome/doctor_details/':'welcome/patient_details/')
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><a target="_blank" href="<?php echo $url.$value->record_id; ?>"><?php echo $value->record_id; ?></a></td>
                                        <td><?php echo $value->record_type==1?'Employee':($value->record_type==2?'Doctor':($value->record_type==3?'Patient':'')); ?></td>
                                        <td><a target="_blank" href="welcome/invoice_print?invoice_id=<?php echo $value->invoice_id; ?>"><?php echo $value->invoice_id; ?><a/></td>
                                        <td><?php echo $transaction_type[$value->transaction_type]; ?></td>
                                        <td><?php echo $value->debit_name; ?></td>
                                        <td><?php echo $value->credit_name; ?></td>
                                        <td><?php echo $value->amount; ?></td>
                                        <td><a target="_blank" href="welcome/employee_details/<?php echo $value->created_by; ?>"><?php echo $value->created_by; ?></a></td>
                                        <td><?php echo get_date_time($value->created_time,'Y-m-d h:i:A'); ?></td>
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