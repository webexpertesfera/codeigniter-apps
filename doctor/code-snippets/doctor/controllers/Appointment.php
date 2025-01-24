<?php
class Appointment extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('appointment_model');
    }

    public function index() {

        $data = [
            'title' => 'My Appointment',
            'active_url' => 'doctor/appointment',
            'page' => 'my_appointment',
            'datatable' => true
        ];

        $param = [
            'user_id' => (int) $this->session->userdata('user_id'),
            'date' => isset($_POST['search'])?date("Y-m-d",strtotime($_POST['date'])):date("Y-m-d"),
        ];

        $data['data'] = $this->appointment_model->get_appointment($param);
        $this->load->view('template',$data);

    }


}
