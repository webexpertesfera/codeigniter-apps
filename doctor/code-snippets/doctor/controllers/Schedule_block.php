<?php
class Schedule_block extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doctors_model');
        $this->load->model('schedule_block_model');

    }

    public function index() {

        // doctor schedule report for admin and doctor //
        $param = [
            'is_admin' => (int) $this->session->userdata('is_admin'),
            'user_id' => (int) $this->session->userdata('user_id'),
        ];

        $data['title'] = 'Schedule block';
        $data['page'] =  'setting/schedule_block';
        $data['active_url'] =  'doctor/schedule_block';
        $data['datatable'] = true;
        $data['data'] = $this->schedule_block_model->get_block_schedule($param);
        $this->load->view('template',$data);

    }

    public function create() {

        /*
         * Block Doctor Schedule
         * */

        $data['title'] = 'Create New Block';
        $data['page'] = 'setting/schedule_block_create';
        $data['active_url'] =  'doctor/schedule_block';
        $data['data'] = $this->doctors_model->get_doctor();

        if(isset($_POST['submit'])) {


            // validation required data

            if($this->session->userdata('is_admin')==1) {
                $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|strip_tags|xss_clean');
            }

            $this->form_validation->set_rules('from_date', 'From Date', 'trim|required|strip_tags|xss_clean|callback_check_valid_from_date');
            $this->form_validation->set_rules('to_date', 'To Date', 'trim|required|strip_tags|xss_clean|callback_check_valid_to_date');



            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                // check schedule data
                if(empty($_POST['day_id'])) {
                    $this->session->set_flashdata('error_message', 'Schedule Not Found');
                    redirect('doctor/schedule_block/create');
                }

                $doctor_id = (int) isset($_POST['doctor'])?$_POST['doctor']:$this->session->userdata('user_id');

                // check schedule already exist
                $param = [
                    'from_date' => $this->input->post('from_date'),
                    'to_date' => $this->input->post('to_date'),
                    'doctor_id' => $doctor_id,
                ];

                $date_validation = $this->check_schedule_exist($param);

                if($date_validation['status']=='error') {
                    $this->session->set_flashdata('error_message', $date_validation['message']);
                    redirect('doctor/schedule_block/create');
                }

                // make Block data

                $block_data = [
                    'doctor_id' => $doctor_id,
                    'from_date' => date("Y-m-d",strtotime($this->input->post('from_date'))),
                    'to_date' => date("Y-m-d",strtotime($this->input->post('to_date'))),
                    'is_all   ' => (int) isset($_POST['all_slot'])?1:0,
                    'schedule_ids' => isset($_POST['all_slot'])?null:implode($_POST['day_id'],","),
                    'reason' => isset($_POST['reason'])?$_POST['reason']:null,
                    'created_by' => $this->user_id,
                    'created_time' => $this->created_time,
                    'created_by_ip' => $this->user_ip
                ];

                $create = $this->schedule_block_model->create($block_data);

                if ($create['status'] == 'success') {

                    $this->session->set_flashdata('success_message', 'Schedule Block Successfully');
                    redirect('doctor/schedule_block');

                } else {
                    $data['status'] = $create['status'];
                    $data['message'] = $create['message'];
                    $this->load->view('template', $data);
                }


            }

        }
        else {

            $this->load->view('template', $data);
        }

    }

    public function update() {

        $id = isset($_POST['submit'])?$_POST['id']:$this->uri->segment(4);

        /*
         * doctor schedule block update
         * */

        $data['title'] = 'Schedule Update';
        $data['page'] = 'setting/schedule_block_update';
        $data['active_url'] =  'doctor/schedule_block';
        $data['doctor'] = $this->doctors_model->get_doctor();

        $get_block_schedule = $this->schedule_block_model->get_update_schedule_block($id);


        $data['data'] = $get_block_schedule;

        $data['selected_schedule'] = explode(",",$get_block_schedule->schedule_ids);

        $param = [
            'from_date' => $get_block_schedule->from_date,
            'to_date' => $get_block_schedule->to_date,
            'doctor_id' => $get_block_schedule->doctor_id
        ];

        $schedule_data = $this->get_schedule($param);

        $data['schedule'] = $schedule_data['schedule'];
        $data['get_day'] = $schedule_data['get_day'];


        if(isset($_POST['submit'])) {


            // validation required data

            if($this->session->userdata('is_admin')==1) {
                $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|strip_tags|xss_clean');
            }

            $this->form_validation->set_rules('id', 'ID', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('from_date', 'From Date', 'trim|required|strip_tags|xss_clean|callback_check_valid_from_date');
            $this->form_validation->set_rules('to_date', 'To Date', 'trim|required|strip_tags|xss_clean|callback_check_valid_to_date');



            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                $doctor_id = (int) isset($_POST['doctor'])?$_POST['doctor']:$this->session->userdata('user_id');

                // check schedule data
                if(empty($_POST['day_id'])) {
                    $this->session->set_flashdata('error_message', 'Schedule Not Found');
                    redirect('doctor/schedule_block/update/'.$_POST['id']);
                }


                // check schedule already exist
                $param = [
                    'from_date' => date("Y-m-d",strtotime($this->input->post('from_date'))),
                    'to_date' => date("Y-m-d",strtotime($this->input->post('to_date'))),
                    'doctor_id' => $doctor_id,
                    'id' => (int) $this->input->post('id'),
                ];

                $date_validation = $this->check_schedule_exist($param);

                if($date_validation['status']=='error') {
                    $this->session->set_flashdata('error_message', $date_validation['message']);
                    redirect('doctor/schedule_block/update/'.$_POST['id']);
                }

                // make schedule Block data

                $block_data = [
                    'id' => (int) $this->input->post('id'),
                    'doctor_id' => $doctor_id,
                    'from_date' => date("Y-m-d",strtotime($this->input->post('from_date'))),
                    'to_date' => date("Y-m-d",strtotime($this->input->post('to_date'))),
                    'is_all   ' => (int) isset($_POST['all_slot'])?1:0,
                    'schedule_ids' => isset($_POST['all_slot'])?null:implode($_POST['day_id'],","),
                    'reason' => isset($_POST['reason'])?$_POST['reason']:null,
                    'updated_by' => $this->user_id,
                    'updated_time' => $this->created_time,
                    'updated_by_ip' => $this->user_ip
                ];

                $create = $this->schedule_block_model->update($block_data);

                if ($create['status'] == 'success') {

                    $this->session->set_flashdata('success_message', 'Schedule Block Updated Successfully');
                    redirect('doctor/schedule_block');

                } else {
                    $data['status'] = $create['status'];
                    $data['message'] = $create['message'];
                    $this->load->view('template', $data);
                }


            }

        }
        else {

            $this->load->view('template', $data);
        }

    }

    // check valid from date
    public function check_valid_from_date($date) {
        if(!validateDate($date)){
            $this->form_validation->set_message('check_valid_date', 'From date is not valid');
            return false;
        }
        else {
            return true;
        }
    }
    // check valid to date
    public function check_valid_to_date($date) {
        if(!validateDate($date)){
            $this->form_validation->set_message('check_valid_date', 'To date is not valid');
            return false;
        }
        else {
            return true;
        }
    }

    // check schedule is exist
    public function check_schedule_exist($data) {

        if(strtotime($data['from_date'])>strtotime($data['to_date'])) {
            return ['status'=>'error','message'=>'From date & To date is not valid','data'=>[]];
        }
        else {
            $is_exist = $this->schedule_block_model->check_schedule_block_is_exists($data);
            if($is_exist) {
                return ['status'=>'error','message'=>'schedule block already exist','data'=>[]];
            }
            else {
                return ['status'=>'success','message'=>'date is valid','data'=>[]];
            }

        }
    }

    public function delete() {



        $id= $this->uri->segment(4);
        $param = [
            'id' => (int) $id,
        ];

        $delete = $this->schedule_block_model->delete($param);
        if ($delete['status'] == 'success') {
            $this->session->set_flashdata('success_message', 'Schedule Block Delete Successfully');
            redirect('doctor/schedule_block');
        } else {
            $this->session->set_flashdata('error_message', $delete['message']);
            redirect('doctor/schedule_block');
        }

    }


    public function delete_dependency_check() {}

    public function get_schedule($receive=null) {

        // load doctor schedule for create & update
        if(is_null($receive)) {
            $from_date = date("Y-m-d",strtotime($this->input->get('from_date')));
            $to_date = date("Y-m-d",strtotime($this->input->get('to_date')));

            if ($this->session->userdata('is_admin') == 1) { // block by admin
                $doctor_id = $this->input->get('doctor_id');
            } else { // schedule block by doctor
                $doctor_id = $this->session->userdata('user_id');
            }

            $get_day = $this->schedule_block_model->get_day($from_date, $to_date);

            $param = [
                'doctor_id' => (int)empty($doctor_id) ? 0 : $doctor_id,
                'day_ids' => array_keys($get_day)
            ];
            $get_schedule = $this->schedule_block_model->get_doctor_schedule($param);

            $schedule_data = [];

            if ($get_schedule) {
                foreach ($get_schedule as $value) {
                    if (isset($schedule_data[$value->day])) {
                        $schedule_data[$value->day][] = $value; // already set
                    } else {
                        $schedule_data[$value->day][] = $value; // new day
                    }
                }

            }

            $data['schedule'] = $schedule_data;
            $data['get_day'] = $get_day;
            $this->load->view('setting/load_schedule', $data); // load schedule data
        }
        else { // return schedule data

            $get_day = $this->schedule_block_model->get_day($receive['from_date'], $receive['to_date']);

            $param = [
                'doctor_id' => (int)$receive['doctor_id'],
                'day_ids' => array_keys($get_day)
            ];
            $get_schedule = $this->schedule_block_model->get_doctor_schedule($param);

            $schedule_data = [];

            if ($get_schedule) {
                foreach ($get_schedule as $value) {
                    if (isset($schedule_data[$value->day])) {
                        $schedule_data[$value->day][] = $value; // already set
                    } else {
                        $schedule_data[$value->day][] = $value; // new day
                    }
                }

            }

            $data['schedule'] = $schedule_data;
            $data['get_day'] = $get_day;

            return $data;

        }
    }


}
