<?php
class Employee_designation extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('employee_designation_model');

    }


    public function index() {
        $data['title'] = 'Employee Designation';
        $data['page'] = 'setting/employee_designation';
        $data['active_url'] = 'human_resource/employee_designation';
        $data['datatable'] = true;
        $data['data'] = $this->employee_designation_model->get_employee_designation();
        $this->load->view('template',$data);

    }

    public function create() {

        /*
         * Employee Designation Create
         * */

        $data['title'] = 'Designation Create';
        $data['page'] = 'setting/create_employee_designation';
        $data['active_url'] = 'human_resource/employee_designation';

        if(isset($_POST['submit'])) {

            $this->form_validation->set_rules('name', 'Designation Name', 'trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                $designation_data = [
                    'name' => (string) $this->input->post('name'),
                    'created_by' => $this->user_id,
                    'created_time' =>  $this->created_time,
                    'created_by_ip' => $this->user_ip
                ];

                // department duplicate check
                $duplicate = $this->employee_designation_model->create_duplicate_check($designation_data);

                if($duplicate) {
                    $data['status'] = 'error';
                    $data['message'] = 'Designation Name is Duplicate';
                    $this->load->view('template', $data);
                }
                else {

                    $create = $this->employee_designation_model->create($designation_data);

                    if ($create['status'] == 'success') {
                        $this->session->set_flashdata('success_message', 'New Designation Create Successfully');
                        redirect('human_resource/employee_designation/create');
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
         * Employee Designation Update
         * */

        $data['title'] = 'Designation Update';
        $data['page'] = 'setting/update_employee_designation';
        $data['active_url'] = 'human_resource/employee_designation';
        $data['data'] = $this->employee_designation_model->get_update_designation($id);

        if(isset($_POST['submit'])) {

            $this->form_validation->set_rules('name', 'Designation Name', 'trim|required');
            $this->form_validation->set_rules('id', 'id', 'trim|required');
            $this->form_validation->set_rules('status', 'status', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                $designation_data = [
                    'id' => (int) $this->input->post('id'),
                    'name' => (string) $this->input->post('name'),
                    'is_active' => (int) $this->input->post('status'),
                    'updated_by' => $this->user_id,
                    'updated_time' =>  $this->created_time,
                    'updated_by_ip' => $this->user_ip
                ];

                // department update duplicate check
                $duplicate = $this->employee_designation_model->update_duplicate_check($designation_data);

                if($duplicate) {
                    $data['status'] = 'error';
                    $data['message'] = 'Designation Name is Duplicate';
                    $this->load->view('template', $data);
                }
                else {

                    $create = $this->employee_designation_model->update($designation_data);

                    if ($create['status'] == 'success') {
                        $this->session->set_flashdata('success_message', 'Employee Designation Update Successfully');
                        redirect('human_resource/employee_designation/update/'.$designation_data['id']);
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

        /*
         * Employee Designation Delete
         * */
        $id = $this->uri->segment(4);
        if($this->delete_dependency_check($id)){
            $this->session->set_flashdata('error_message','Sorry Dependency has found');
            redirect('human_resource/employee_designation');
        }
        else {
            $delete = $this->employee_designation_model->delete($id);
            if ($delete['status'] == 'success') {
                $this->session->set_flashdata('success_message', 'Employee Designation Delete Successfully');
                redirect('human_resource/employee_designation');
            } else {
                $this->session->set_flashdata('error_message', $delete['message']);
                redirect('human_resource/employee_designation');
            }
        }

    }

    public function delete_dependency_check($id =null) {
        if(!is_null($id)) {
            $is_depend = $this->employee_designation_model->delete_dependency_check($id);
            return $is_depend;
        }
    }


}
