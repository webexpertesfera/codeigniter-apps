<?php
class Employee_department extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('employee_department_model');

    }


    public function index() {
        $data['title'] = 'Employee Department';
        $data['page'] = 'setting/employee_department';
        $data['active_url'] = 'human_resource/employee_department';
        $data['datatable'] = true;
        $data['data'] = $this->employee_department_model->get_employee_department();
        $this->load->view('template',$data);

    }

    public function create() {

        /*
         * Employee Department Update
         * */

        $data['title'] = 'Department Create';
        $data['page'] = 'setting/create_employee_department';
        $data['active_url'] = 'human_resource/employee_department';

        if(isset($_POST['submit'])) {

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                $hospital_data = [
                    'name' => (string) $this->input->post('name'),
                    'created_by' => $this->user_id,
                    'created_time' =>  $this->created_time,
                    'created_by_ip' => $this->user_ip
                ];

                // department duplicate check
                $duplicate = $this->employee_department_model->create_duplicate_check($hospital_data);

                if($duplicate) {
                    $data['status'] = 'error';
                    $data['message'] = 'Department Name is Duplicate';
                    $this->load->view('template', $data);
                }
                else {

                    $create = $this->employee_department_model->create($hospital_data);

                    if ($create['status'] == 'success') {
                        $this->session->set_flashdata('success_message', 'New Employee Department Create Successfully');
                        redirect('human_resource/employee_department/create');
                    } else {
                        $data['status'] = $create['status'];
                        $data['message'] = $create['message'];
                        $this->load->view('template', $data);
                    }
                }


            }

        }
        else {

            $this->load->view('template', $data);
        }

    }

    public function update() {

        $id = (int) isset($_POST['id'])?$this->input->post('id'):$this->uri->segment(4);

        /*
         * Hospital Department Update
         * */

        $data['title'] = 'Department Update';
        $data['page'] = 'setting/update_employee_department';
        $data['active_url'] = 'human_resource/employee_department';
        $data['data'] = $this->employee_department_model->get_update_department($id);

        if(isset($_POST['submit'])) {

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required');
            $this->form_validation->set_rules('id', 'id', 'trim|required');
            $this->form_validation->set_rules('status', 'status', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                $hospital_data = [
                    'id' => (int) $this->input->post('id'),
                    'name' => (string) $this->input->post('name'),
                    'is_active' => (int) $this->input->post('status'),
                    'updated_by' => $this->user_id,
                    'updated_time' =>  $this->created_time,
                    'updated_by_ip' => $this->user_ip
                ];

                // department update duplicate check
                $duplicate = $this->employee_department_model->update_duplicate_check($hospital_data);

                if($duplicate) {
                    $data['status'] = 'error';
                    $data['message'] = 'Department Name is Duplicate';
                    $this->load->view('template', $data);
                }
                else {

                    $create = $this->employee_department_model->update($hospital_data);

                    if ($create['status'] == 'success') {
                        $this->session->set_flashdata('success_message', 'Employee Department Update Successfully');
                        redirect('human_resource/employee_department/update/'.$hospital_data['id']);
                    } else {
                        $data['status'] = $create['status'];
                        $data['message'] = $create['message'];
                        $this->load->view('template', $data);
                    }
                }


            }

        }
        else {

            $this->load->view('template', $data);
        }

    }

    public function delete() {
        $id = $this->uri->segment(4);
        if($this->delete_dependency_check($id)) { // department dependency check
            $this->session->set_flashdata('error_message', 'Sorry Dependency has found');
            redirect('human_resource/employee_department');
        }
        else {
            $delete = $this->employee_department_model->delete($id);
            if ($delete['status'] == 'success') {
                $this->session->set_flashdata('success_message', 'Employee Department Delete Successfully');
                redirect('human_resource/employee_department');
            } else {
                $this->session->set_flashdata('error_message', $delete['message']);
                redirect('human_resource/employee_department');
            }
        }

    }

    public function delete_dependency_check($id =null) {
        if(!is_null($id)) {
            $is_depend = $this->employee_department_model->delete_dependency_check($id);
            return $is_depend;
        }
    }


}
