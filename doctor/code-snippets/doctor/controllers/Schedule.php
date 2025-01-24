<?php
class Schedule extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doctors_model');
        $this->load->model('schedule_model');
    }

    public function index() {

        // doctor schedule report for admin and doctor //
        $param = [
            'is_admin' => (int) $this->session->userdata('is_admin'),
            'user_id' => (int) $this->session->userdata('user_id'),
        ];

        $data['title'] = 'Schedule';
        $data['active_url'] =  'doctor/schedule';
        $data['page'] =  'setting/schedule';
        $data['datatable'] = true;
        $data['data'] = $this->schedule_model->get_schedule($param);
        $this->load->view('template',$data);

    }

    public function create() {

        /*
         * Create New Doctor Schedule
         * */

        $data['title'] = 'Schedule';
        $data['page'] = 'setting/schedule_create';
        $data['active_url'] =  'doctor/schedule';
        $data['data'] = $this->doctors_model->get_doctor();

        if(isset($_POST['submit'])) {


            // validation required data

            if($this->session->userdata('is_admin')==1) {
                $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|strip_tags|xss_clean');
            }

            $this->form_validation->set_rules('day', 'Day', 'trim|required|strip_tags|xss_clean');

            if(empty($_POST['visitor'])) { // check schedule is set
                $this->form_validation->set_rules('visitor[]',"Schedule not found", "trim|required|strip_tags|xss_clean");
            }

            if (!empty($_POST['visitor'])) { // check schedule is empty
                $this->form_validation->set_rules('visitor[]',"Visitor", "callback_valid_schedule_time");
            }

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                // make schedule data
                $doctor_id = (int) isset($_POST['doctor'])?$_POST['doctor']:$this->session->userdata('user_id');
                $schedule_data = [];

                foreach($_POST['visitor'] as $key => $value) {
                    $row = [
                        'doctor_id' => $doctor_id,
                        'day' => (int)$this->input->post('day'),
                        'start_time' => date('H:i:s',strtotime($_POST['start_time'][$key])),
                        'end_time   ' => date('H:i:s',strtotime($_POST['end_time'][$key])),
                        'maximum_visitor' => (int) $_POST['visitor'][$key],
                        'created_by' => $this->user_id,
                        'created_time' => $this->created_time,
                        'created_by_ip' => $this->user_ip
                    ];

                    $schedule_data[] = $row;
                }

                $create = $this->schedule_model->create($schedule_data);

                if ($create['status'] == 'success') {

                    $this->session->set_flashdata('success_message', 'New Schedule Create Successfully');
                    redirect('doctor/schedule/create');

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

        $day_id = $this->uri->segment(4);
        $doctor_id = $this->uri->segment(5);

        /*
         * doctor schedule update
         * */

        $data['title'] = 'Schedule Update';
        $data['page'] = 'setting/schedule_update';
        $data['active_url'] =  'doctor/schedule';
        $data['doctor'] = $this->doctors_model->get_doctor();
        $data['data'] = $this->schedule_model->get_update_schedule($day_id,$doctor_id);

        $data['doctor_id'] = $doctor_id;
        $data['day_id'] = $day_id;

        if(isset($_POST['submit'])) {

            // validation form data

            if($this->session->userdata('is_admin')==1) {
                $this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|strip_tags|xss_clean');
            }

            $this->form_validation->set_rules('day', 'Day', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('day_id', 'Day Id', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('doctor_id', 'Doctor', 'trim|required|strip_tags|xss_clean');

            if(empty($_POST['visitor'])) {
                $this->form_validation->set_rules('visitor[]',"Schedule not found", "trim|required|strip_tags|xss_clean");
            }

            if (!empty($_POST['visitor'])) {
                $this->form_validation->set_rules('visitor[]',"Visitor", "callback_valid_schedule_time");
            }

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {




                $doctor_id = (int) isset($_POST['doctor'])?$_POST['doctor']:$this->session->userdata('user_id');

                // make update schedule data

                $schedule_data = [
                    'remove_schedule' => empty($_POST['remove_ids'])?[]:explode(",",$_POST['remove_ids']),
                    'update_schedule' =>[],
                    'new_schedule' =>[]
                ];


                foreach($_POST['visitor'] as $key => $value) {

                    if(empty($_POST['id'][$key])) { // new schedule
                        $row = [
                            'doctor_id' => $doctor_id,
                            'day' => (int)$this->input->post('day'),
                            'start_time' => date('H:i:s',strtotime($_POST['start_time'][$key])),
                            'end_time   ' => date('H:i:s',strtotime($_POST['end_time'][$key])),
                            'maximum_visitor' => (int) $_POST['visitor'][$key],
                            'created_by' => $this->user_id,
                            'created_time' => $this->created_time,
                            'created_by_ip' => $this->user_ip
                        ];
                        $schedule_data['new_schedule'][] = $row;
                    }
                    else { // update schedule
                        $row = [
                            'id' => (int) $_POST['id'][$key],
                            'doctor_id' => $doctor_id,
                            'day' => (int)$this->input->post('day'),
                            'start_time' => date('H:i:s',strtotime($_POST['start_time'][$key])),
                            'end_time   ' => date('H:i:s',strtotime($_POST['end_time'][$key])),
                            'maximum_visitor' => (int) $_POST['visitor'][$key],
                            'updated_by' => $this->user_id,
                            'updated_time' => $this->created_time,
                            'updated_by_ip' => $this->user_ip
                        ];
                        $schedule_data['update_schedule'][] = $row;
                    }


                }

                $update = $this->schedule_model->update($schedule_data);

                if ($update['status'] == 'success') {
                    $this->session->set_flashdata('success_message', 'Schedule Update Successfully');
                    redirect('doctor/schedule');

                } else {
                    $data['status'] = $update['status'];
                    $data['message'] = $update['message'];
                    $this->load->view('template', $data);
                }


            }

        }
        else {

            $this->load->view('template', $data);
        }

    }

    // check valid schedule time
    public function valid_schedule_time() {
        foreach($_POST['visitor'] as $key => $value) {
            if(empty($_POST['start_time'][$key]) || empty($_POST['end_time'][$key]) || empty($_POST['visitor'][$key])) {
                $this->form_validation->set_message('valid_schedule_time', 'Invalid time schedule');
                return false;
            }
            elseif(strtotime($_POST['start_time'][$key])>= strtotime($_POST['end_time'][$key])) {
                $this->form_validation->set_message('valid_schedule_time', 'Invalid time schedule');
                return false;
            }
        }

        return true;
    }

    public function delete() {
        $day_id= $this->uri->segment(4);
        $doctor_id = $this->uri->segment(5);
        $param = [
            'day_id' => (int) $day_id,
            'doctor_id' => (int) $doctor_id,
        ];
        $delete = $this->schedule_model->delete($param);
        if ($delete['status'] == 'success') {
            $this->session->set_flashdata('success_message', 'Schedule Delete Successfully');
            redirect('doctor/schedule');
        } else {
            $this->session->set_flashdata('error_message', $delete['message']);
            redirect('doctor/schedule');
        }

    }

    public function delete_dependency_check() {}


}
