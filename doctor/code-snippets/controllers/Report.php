<?php
class Report extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accounts/tax_payment_model');
        $this->load->model('accounts/chart_of_account_model');
        $this->load->model('accounts/report_model');
    }

    public function index()
    {
        redirect('/');
    }

    public function transaction_report()
    {

        $data = [
            'title' => 'Transaction Report',
            'page' => 'transaction_report',
            'active_url'=>'doctor/report/transaction_report',
            'ribbon' => [
                ['item'=>'<a href="doctor/report/transaction_report">Transaction Report</a>']
            ],
            'datatable' => true
        ];

        $data['data'] = [];

        $param = [
            'doctor_id' => $this->session->userdata('user_id')
        ];

        $data['data'] = $this->report_model->doctor_transaction($param);

        $this->load->view('template', $data);
    }



}
