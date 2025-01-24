<?php
class Doctors extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doctors_model');
    }

    public function index() {
        $data['title'] = 'Doctors';
        $data['page'] =  'doctors';
        $data['active_url'] =  'human_resource/doctors';
        $data['datatable'] = true;
        $data['data'] = $this->doctors_model->get_doctor();
        $this->load->view('template',$data);

    }

    public function create() {

        /*
         * Create New Doctor
         * */

        $data['title'] = 'Doctor Create';
        $data['page'] = 'create_doctor';
        $data['active_url'] = 'human_resource/doctors';
        $data['hr_doctor_department'] = $this->doctors_model->get_hr_doctor_department();
        $data['hr_doctor_designation'] = $this->doctors_model->get_hr_doctor_designation();


        if(isset($_POST['submit'])) {


            // validation required data

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('present_address', 'Present Address', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
            $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|strip_tags|xss_clean|valid_email|callback_user_email_exist');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('password_conf', 'Confirm Password', 'trim|required|strip_tags|xss_clean|matches[password]');
            $this->form_validation->set_rules('department', 'Department', 'trim|required|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('designation', 'Designation', 'trim|required|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('picture', 'Picture', 'callback_valid_user_picture');

            if(isset($_POST['allow_prescription_fees'])) {
                $this->form_validation->set_rules('prescription_fees', 'Prescription Fees', 'trim|required|strip_tags|xss_clean|numeric');
                $this->form_validation->set_rules('payment_with', 'Payment By', 'trim|required|strip_tags|xss_clean|numeric');
            }


            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                // doctor data

                $form_data = $this->input->post(NULL,TRUE,TRUE);

                $user_id = get_user_id(2);

                $doctor_data = [
                    'doctor_id' =>  $user_id,
                    'first_name' => (string) $form_data['first_name'],
                    'last_name' => (string) $form_data['last_name'],
                    'mobile_no' => (string) $form_data['mobile_no'],
                    'present_address' => (string) $form_data['present_address'],
                    'permanent_address' => (string) $form_data['permanent_address'],
                    'gender' => (int) $form_data['gender'],
                    'birth_date' =>  $form_data['birth_date'],
                    'hospital_department_id' => (int) $form_data['department'],
                    'doctor_designation_id' => (int) $form_data['designation'],
                    'emergency_contact_number' =>  (string) $form_data['emergency_contact'],
                    'biography' => empty($form_data['biography'])?null:(string) $form_data['biography'],
                    'education_qualification' => empty($form_data['education_qualification'])?null:(string) $form_data['education_qualification'],
                    'medical_degree' => empty($form_data['medical_degree'])?null:(string) $form_data['medical_degree'],
                    'specialist' => empty($form_data['specialist'])?null:(string) $form_data['specialist'],
                    'prescription_fees' => empty($_POST['prescription_fees'])?null:(string) $_POST['prescription_fees'],
                    'fee_is_applicable'=> isset($_POST['allow_prescription_fees'])?1:0,
                    'fee_payment'=> isset($_POST['payment_with'])?$_POST['payment_with']:null,
                    'created_by' => $this->user_id,
                    'created_time' =>  $this->created_time,
                    'created_by_ip' => $this->user_ip
                ];

                // user data
                $user_data = [
                    'user_id' => $user_id,
                    'email' => (string) $form_data['email'],
                    'user_type' => 2,
                    'password' => (string) sha1($form_data['password']),
                    'created_by' => $this->user_id,
                    'created_time' =>  $this->created_time,
                    'created_by_ip' => $this->user_ip
                ];

                $create = $this->doctors_model->create($doctor_data,$user_data);

                if ($create['status'] == 'success') {

                    // user picture upload
                    $upload_path = 'assets/img/profile/doctor/';
                    user_picture_upload($upload_path,$user_id,$_FILES);

                    $this->session->set_flashdata('success_message', 'New Doctor create Successfully');
                    redirect('human_resource/doctors/create');

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

    // check valid date
    public function valid_date($birth_date) {
        $valid = validateDate($birth_date);
        if($valid){
            return true;
        }
        else {
            $this->form_validation->set_message('valid_date', 'The Birth date is not valid');
            return false;
        }
    }

    // user email exist
    public function user_email_exist_update($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */

        $param = [
            'user_type' => 2,
            'user_id' => $_POST['user_id'],
            'email' => (string) $email,
        ];
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_email_exist_update', 'The Email address already exist');
            return false;
        }
        else {
            return true;
        }

    }

    // valid user picture
    public function valid_user_picture() {

        if (empty($_FILES['picture']['name'])) {
            $this->form_validation->set_message('valid_user_picture', 'The Picture field is empty');
            return false;
        }
        else {
            return true;
        }

    }


    public function update() {

        $id = (int) isset($_POST['id'])?$this->input->post('id'):$this->uri->segment(4);

        /*
         * doctor update
         * */

        $data['title'] = 'Doctor update';
        $data['page'] = 'update_doctor';
        $data['active_url'] =  'human_resource/doctors';
        $data['data'] = $this->doctors_model->get_update_doctor($id);
        $data['doctor_department'] = $this->doctors_model->get_hr_doctor_department_update($data['data']->hospital_department_id);
        $data['doctor_designation'] = $this->doctors_model->get_hr_doctor_designation_update($data['data']->doctor_designation_id);

        if(isset($_POST['submit'])) {

            // validation form data

            $this->form_validation->set_rules('id', 'id', 'trim|required|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric');
            $this->form_validation->set_rules('present_address', 'Present Address', 'trim|required');
            $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|required');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|numeric');
            $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|callback_valid_date');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_user_email_exist_update');
            $this->form_validation->set_rules('emergency_contact', 'Emergency Contact', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
            $this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
            $this->form_validation->set_rules('designation', 'Designation', 'trim|required|numeric');

            if(isset($_POST['allow_prescription_fees'])) {
                $this->form_validation->set_rules('prescription_fees', 'Prescription Fees', 'trim|required|numeric');
                $this->form_validation->set_rules('payment_with', 'Payment By', 'trim|required|numeric');
            }

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                // doctor data

                $doctor_data = [
                    'id' => (int) $this->input->post('id'),
                    'first_name' => (string) $this->input->post('first_name'),
                    'last_name' => (string) $this->input->post('last_name'),
                    'mobile_no' => (string) $this->input->post('mobile_no'),
                    'present_address' => (string) $this->input->post('present_address'),
                    'permanent_address' => (string) $this->input->post('permanent_address'),
                    'gender' => (int) $this->input->post('gender'),
                    'birth_date' =>  $this->input->post('birth_date'),
                    'user_id' =>  $this->input->post('user_id'),
                    'email' =>  $this->input->post('email'),
                    'hospital_department_id' => (int) $this->input->post('department'),
                    'doctor_designation_id' => (int) $this->input->post('designation'),
                    'emergency_contact_number' =>  (string) $this->input->post('emergency_contact'),
                    'biography' => empty($this->input->post('biography'))?null:(string) $this->input->post('biography'),
                    'education_qualification' => empty($this->input->post('education_qualification'))?null:(string) $this->input->post('education_qualification'),
                    'medical_degree' => empty($this->input->post('medical_degree'))?null:(string) $this->input->post('medical_degree'),
                    'specialist' => empty($this->input->post('specialist'))?null:(string) $this->input->post('specialist'),
                    'prescription_fees' => empty($_POST['prescription_fees'])?null:(string) $_POST['prescription_fees'],
                    'fee_is_applicable'=> isset($_POST['allow_prescription_fees'])?1:0,
                    'fee_payment'=> isset($_POST['payment_with'])?$_POST['payment_with']:null,
                    'is_active' =>  (int) $this->input->post('status'),
                    'updated_by' => $this->user_id,
                    'updated_time' =>  $this->created_time,
                    'updated_by_ip' => $this->user_ip
                ];


                $create = $this->doctors_model->update($doctor_data);

                if ($create['status'] == 'success') {

                    if(isset($_FILES['picture']['name'])) { // user picture update if new picture is selected
                        $upload_path = 'assets/img/profile/doctor/';
                        user_picture_upload($upload_path, $data['data']->doctor_id, $_FILES);
                    }

                    $this->session->set_flashdata('success_message', 'Doctor Information Update Successfully');
                    redirect('human_resource/doctors');

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

    public function delete() {
        $id = $this->uri->segment(4);
        $delete = $this->doctors_model->delete($id);
        if ($delete['status'] == 'success') {
            $this->session->set_flashdata('success_message', 'Doctor Delete Successfully');
            redirect('human_resource/doctors');
        } else {
            $this->session->set_flashdata('error_message', $delete['message']);
            redirect('human_resource/doctors');
        }

    }

    public function delete_dependency_check() {}


}
