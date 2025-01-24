<?php
class Hr_employee extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hr_employee_model');
        $this->load->library('uploadfiles');

    }



    public function index() {
        $data['title'] = 'Employee';
        $data['page'] =  'hr_employee';
        $data['active_url'] =  'human_resource/hr_employee';
        $data['datatable'] = true;
        $data['data'] = $this->hr_employee_model->get_employee();
       // prx($data['data']);
        $this->load->view('template',$data);

    }


    
public function getAdmin() {

        $data['title'] = 'Admins';
        $data['page'] =  'admins';
        $data['active_url'] =  'human_resource/hr_employee/getAdmin';
        $data['datatable'] = true;
        $data['data'] = $this->hr_employee_model->get_subadmins();
       
        $this->load->view('template',$data);

    }


    public function create() {

        /*
         * Create New Employee
         * */

        $data['title'] = 'Employee Create';
        $data['page'] = 'create_employee';
        $data['active_url'] =  'human_resource/hr_employee';
        $data['hr_department'] = $this->hr_employee_model->get_hr_department();
        $data['hr_designation'] = $this->hr_employee_model->get_hr_designation();


        if(isset($_POST['submit'])) {

            if(isset($_POST['is_admin'])){
                $is_admin=1;
            }else{
                $is_admin=0;
            }
            // validation form data

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|strip_tags|xss_clean');  
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|strip_tags|xss_clean|callback_user_mobile_exist');
            $this->form_validation->set_rules('present_address', 'Present Address', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|numeric|strip_tags|xss_clean');
            $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|callback_valid_date|strip_tags|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_user_email_exist|strip_tags|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('password_conf', 'Confirm Password', 'trim|required|matches[password]|strip_tags|xss_clean');
            $this->form_validation->set_rules('picture', 'Picture', 'callback_valid_user_picture');


            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {
                //prx($this->input->post('email'));
                // employee data;
                $password = $this->input->post('password');

                 $user_id = get_user_id(1);
                // $user_id = 2323;
                $employee_data = [
                    'employee_id'      =>  $user_id,
                    'first_name'       =>  AesCipher::encrypt($this->input->post('first_name')),
                    'country_code'     =>  AesCipher::encrypt($this->input->post('country_code')),
                    'mobile_no'        =>  AesCipher::encrypt($this->input->post('mobile_no')),
                    'present_address'  =>  AesCipher::encrypt($this->input->post('present_address')),
                    // 'country'          => $this->input->post('country'),
                    'gender'           =>  (int) $this->input->post('gender'),
                    'birth_date'       =>  $this->input->post('birth_date'),
                    'created_by'       =>  $this->user_id,
                    'created_time'     =>  $this->created_time,
                    'created_by_ip'    =>  $this->user_ip,
                    'is_admin'         => $is_admin
                ];

                // user data
                $user_data = [
                    'user_id'          => $user_id,
                    'email'            =>  AesCipher::encrypt($this->input->post('email')),
                    'country_code'     =>  AesCipher::encrypt($this->input->post('country_code')),
                    'mobile_no'        =>  AesCipher::encrypt($this->input->post('mobile_no')),
                    //'country'          => $this->input->post('country'),
                    'user_type'        => 1,
                    'password'         => md5($this->input->post('password')),
                    'created_by'       => $this->user_id,
                    'created_time'     =>  $this->created_time,
                    'created_by_ip'    => $this->user_ip
                ];
                $create = $this->hr_employee_model->create($employee_data,$user_data);
                if ($create['status'] == 'success') {
                   $ext = array('jpg','jpeg','png');
                   $resultImage = array();
                   $isSave = 0;
                   $path = '';
                   $uploadImage = array();
                   $saveData = [];
                   $name = $_FILES['picture']['name'];
                   if($name != '')
                   {
                    $exR = explode('.',$name);
                    $ex = end($exR);
                    if(in_array($ex,$ext))
                    {                                        
                        $path = getcwd().'/upload/employee/';
                        $imgName = rand(0,999999).'.'.$ex;
                        $saveData['image'] = $imgName;
                        $uploadImage['name'] = $imgName;
                        $uploadImage['type'] = $_FILES['picture']['type'];
                        $uploadImage['tmp_name'] = $_FILES['picture']['tmp_name'];
                        $uploadImage['type'] = $_FILES['picture']['type'];
                        $uploadImage['error'] = $_FILES['picture']['error'];
                        $uploadImage['size'] = $_FILES['picture']['size'];
                        $resultImage = $this->uploadfiles->uploadImages($uploadImage,$imgName,$path);
                        $isSave = $this->hr_employee_model->updateinfo($saveData,$user_id);
                    }
                }
                $p_name=$this->input->post('first_name');
                 $email=$this->input->post('email');
                $subject = 'Create Sub Admin';
                $body ="Dear ".$p_name."<br /><br /> Your account has been created successfully. your password is ".$password." .";
                $s=$this->sendmail($email,$subject,$body);
                //prx($s);
                $this->session->set_flashdata('success_message', 'New employee create Successfully');
                redirect('human_resource/hr_employee');

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
public function user_email_exist($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */

        $param = [
            'user_type' => 1,
            'email' =>  AesCipher::encrypt($email),
        ];
        $exist = $this->hr_employee_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_email_exist', 'The Email address already exist');
            return false;
        }
        else {
            return true;
        }

    }

    public function user_mobile_exist($mobile) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */

        $param = [
            'user_type' => 1,
            'mobile_no' =>  AesCipher::encrypt($mobile),
        ];
        $exist = $this->hr_employee_model->user_mobile_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_mobile_exist', 'The Mobile No already exist');
            return false;
        }
        else {
            return true;
        }

    }

    // user email exist
    public function user_email_exist_update($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */

        $param = [
            'user_type' => 1,
            'user_id' => $_POST['user_id'],
            'email' =>  AesCipher::encrypt($email),
        ];
        $exist = $this->hr_employee_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_email_exist_update', 'The Email address already exist');
            return false;
        }
        else {
            return true;
        }

    }

    public function user_mobile_exist_update($mobile) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */

        $param = [
            'user_type' => 1,
            'user_id' => $_POST['user_id'],
            'mobile_no' =>  AesCipher::encrypt($mobile),
        ];
        $exist = $this->hr_employee_model->user_mobile_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_mobile_exist_update', 'Mobile No. is already exist');
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
        // prx($id);
        /*
         * employee update
         * */

        $data['title'] = 'Employee Update';
        $data['page'] = 'update_employee';
        $data['active_url'] =  'human_resource/hr_employee';
        $data['data'] = $this->hr_employee_model->get_update_employee($id);
        if(isset($_POST['submit'])) {

            // validation form data

            $this->form_validation->set_rules('id', 'id', 'trim|required|numeric|strip_tags|xss_clean');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|strip_tags|xss_clean');
              $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|strip_tags|xss_clean|callback_user_mobile_exist_update');
            $this->form_validation->set_rules('present_address', 'Present Address', 'trim|required|strip_tags|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_user_email_exist_update|strip_tags|xss_clean');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|numeric|strip_tags|xss_clean');
            $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|callback_valid_date|strip_tags|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric|strip_tags|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('template',$data);
            }
            else
            {

                // employee data

                $employee_data = [
                    'id' => (int) $this->input->post('id'),
                   'first_name'       =>  AesCipher::encrypt($this->input->post('first_name')),
                    'country_code'     =>  AesCipher::encrypt($this->input->post('country_code')),
                    'mobile_no'        =>  AesCipher::encrypt($this->input->post('mobile_no')),
                    'present_address'  =>  AesCipher::encrypt($this->input->post('present_address')),
                    'gender'           =>  (int) $this->input->post('gender'),
                    'birth_date'       =>  $this->input->post('birth_date'),
                    'is_active'           => $this->input->post('status'),
                    'created_by'       =>  $this->user_id,
                    'created_time'     =>  $this->created_time,
                    'created_by_ip'    =>  $this->user_ip
                ];

                 $user_data = [
                    
                    'email'            =>  AesCipher::encrypt($this->input->post('email')),
                    'country_code'     =>  AesCipher::encrypt($this->input->post('country_code')),
                    'mobile_no'        =>  AesCipher::encrypt($this->input->post('mobile_no')),
                   // 'country'          => $this->input->post('country'),
                    'user_type'        => 1,
                    'password'         => md5($this->input->post('password')),
                    'created_by'       => $this->user_id,
                    'created_time'     =>  $this->created_time,
                    'created_by_ip'    => $this->user_ip
                ];
             
                $up = $this->hr_employee_model->updateusers($user_data,$this->input->post('user_id'));

                $create = $this->hr_employee_model->update($employee_data);

                if ($create['status'] == 'success' || $up > 0) {

                    $ext = array('jpg','jpeg','png');
                   $resultImage = array();
                   $isSave = 0;
                   $path = '';
                   $uploadImage = array();
                   $saveData = [];
                   $name = $_FILES['picture']['name'];
                //    prx($name);
                   if($name != '')
                   {
                    $exR = explode('.',$name);
                    // prx($exR);
                    $ex = end($exR);
                    if(in_array($ex,$ext))
                    {                                        
                        $path = getcwd().'/upload/employee/';
                        $imgName = rand(0,999999).'.'.$ex;
                        $saveData['image'] = $imgName;
                        $uploadImage['name'] = $imgName;
                        $uploadImage['type'] = $_FILES['picture']['type'];
                        $uploadImage['tmp_name'] = $_FILES['picture']['tmp_name'];
                        $uploadImage['type'] = $_FILES['picture']['type'];
                        $uploadImage['error'] = $_FILES['picture']['error'];
                        $uploadImage['size'] = $_FILES['picture']['size'];
                        $resultImage = $this->uploadfiles->uploadImages($uploadImage,$imgName,$path);
                        // prx($id);

                        $isSave = $this->hr_employee_model->updateinfo($saveData,$id);
                    }
                }
                    $this->session->set_flashdata('success_message', 'Employee Information Update Successfully');
                    redirect('human_resource/hr_employee');

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
   public function sendmail($email, $title, $body)
{
    // Configuration array
    $config = array(
        'protocol' => SMTP_PROTOCOL,
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_user' => SMTP_USER,
        'smtp_pass' => SMTP_PASS,
        'mailtype'  => SMTP_MAILTYPE,
        'charset'   => SMTP_CHARSET
    );

    // Load the email library and initialize with your configuration
    $this->load->library('email');
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");

    // Set the sender's email and name
    $mail_from = "Hello@teledoc.com.ng";
    $mail_from_name = APP_TITLE; // Ensure APP_TITLE is defined
    $this->email->from($mail_from, $mail_from_name);
    $this->email->to($email); // Set the recipient's email address
    $this->email->subject($title); // Set the email subject
    $this->email->message($body); // Set the email body

    // Send the email and check the result
    if (!$this->email->send()) {
        // Email not sent, print debugging data
        echo $this->email->print_debugger();
    } else {
        // Email was sent successfully
        echo 'Email sent successfully.';
    }
}




   public function deleteEmployee(){
        $id=$_POST['id'];

       
        $delete=$this->hr_employee_model->delete($id);
       
        echo json_encode($delete);
    }



}
