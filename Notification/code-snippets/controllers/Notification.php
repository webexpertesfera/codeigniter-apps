<?php

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
class Notification extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('notification_model');
        $this->load->library(array('AesCipher'));
    }
    public function index() {
        $updateNotification = $this->notification_model->updateAllNotification(array('is_read'=>1));
        $data['title'] = 'Notifications';
        $data['page'] =  'notification_list';
        $data['active_url'] =  'notification';
        $data['datatable'] = true;
        $data['notification'] = $this->notification_model->getnotification(array());
        $this->load->view('template',$data);
    }

    public function sendNotification() {
        $data['title'] = 'Send Notification';
        $data['page'] =  'send_notification';
        $data['active_url'] =  'sendNotification';
        $data['datatable'] = true;
        $data['notification'] = $this->notification_model->getmessage(array());
        $this->load->view('template',$data);
    }


    public function create() {
        $data['title'] = 'create Notification';
        $data['page'] =  'create';
        $data['active_url'] =  'create';
         $data['patients'] = $this->notification_model->getAllPatients();
        $data['doctors'] = $this->notification_model->getAllDoctors();
     
        $this->load->view('template',$data);
    }

 public function saveMessage()
{
    // Set the page data
    $data['title'] = 'Save Notification';
    $data['page'] = 'create';
    $data['active_url'] = 'create';

    try {
        // Get user type and input data
        $user_type = $this->input->post('user_type');
        $patient_ids = $this->input->post('patient_id');  // Array of selected patient IDs
        $doctor_ids = $this->input->post('doctor_id');    // Array of selected doctor IDs
        $title = $this->input->post('title');
        $type = $this->input->post('type');
        $message = $this->input->post('message');
        $notification_id = $this->input->post('notification_id');  // Get notification ID

        // Validate required fields
        if (empty($patient_ids) && empty($doctor_ids)) {
            throw new Exception('At least one patient or doctor must be selected.');
        }
        if (empty($title)) {
            throw new Exception('Title is required.');
        }
        if (empty($message)) {
            throw new Exception('Notification message is required.');
        }

        // Initialize variables
        $users = [];

        // Check if patient_ids and doctor_ids are arrays and process accordingly
        if (is_array($patient_ids) && in_array('all', $patient_ids)) {
            // Get all patients
            $users = $this->notification_model->getAllPatients();
        } elseif (is_array($doctor_ids) && in_array('all', $doctor_ids)) {
            // Get all doctors
            $users = $this->notification_model->getAllDoctors();

        } else {
            // Handle selected patients and doctors
            if (is_array($patient_ids) && !empty($patient_ids)) {
                $users = array_merge($users, $this->notification_model->getSelectedPatients($patient_ids));
            }

            if (is_array($doctor_ids) && !empty($doctor_ids)) {
                $users = array_merge($users, $this->notification_model->getSelectedDoctors($doctor_ids));
            }
        }

       // prx($users);

        if (empty($users)) {
            throw new Exception('No users found to send notifications.');
        }

        // Prepare notification data
        $notificationData = [
            'title' => $title,
            'message' => $message,
            'type' => $type
        ];

        // Prepare data for inserting or updating notification
        $notificationData = [
            'title' => $title,
            'user_type' => $user_type,
            'message' => $message,
            'type' => $type,
            'doctors' => json_encode($doctor_ids), // Save selected doctors as JSON
            'patients' => json_encode($patient_ids), // Save selected patients as JSON
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Check if it's an update or create operation
        if (!empty($notification_id)) {
            // Update existing notification
            $this->notification_model->updateSendMessage($notification_id, $notificationData);
           
        } else {
            // Insert new notification
            $this->notification_model->insertMessage($notificationData);
            
        }

        $validUsersCount = 0;
        $invalidUsers = [];

        // Send notification to each user
        foreach ($users as $user) {
            $fcm_token = isset($user->fcm_token) ? $user->fcm_token : '';
            $device_type = isset($user->device_type) ? $user->device_type : '';

            if ($fcm_token && $device_type) {
                try {
                    if ($device_type === 'ios') {
                        $notificationSent = iosnotification($fcm_token, $title, $message, $type, $notificationData,1);
                    } elseif ($device_type === 'android') {
                        $notificationSent = androidnotification($fcm_token, $title, $message, $type, $notificationData,1);
                        
                    } else {
                        log_message('error', 'Unsupported device type: ' . $device_type . ' for user ID: ' . $user->user_id);
                        continue;
                    }

                    if ($notificationSent) {
                        $validUsersCount++;
                    } else {
                        $invalidUsers[] = $user->id;  // Log the user ID that failed
                    }
                } catch (Exception $e) {
                    log_message('error', 'Error sending notification to user ID ' . $user->id . ': ' . $e->getMessage());
                    $invalidUsers[] = $user->user_id;  // Log the user ID that failed
                }
            } else {
                log_message('error', 'Missing fcm_token or device_type for user ID: ' . $user->user_id);
                $invalidUsers[] = $user->user_id;  // Log the user ID that failed
            }
        }

        // Set flash messages for success or failure
        if ($validUsersCount > 0) {
            $this->session->set_flashdata('success_message', 'Notification sent to ' . $validUsersCount . ' users successfully.');
        }

        if (count($invalidUsers) > 0) {
         

            $this->session->set_flashdata('error_message', 'Failed to send notifications to some users. Check logs for more details.'.$invalidUsers);
        }

    } catch (Exception $e) {
        log_message('error', 'Exception: ' . $e->getMessage());
        $this->session->set_flashdata('error_message', 'Failed to send notifications: ' . $e->getMessage());
    }

    // Redirect to the create notification page
    redirect('notification/sendNotification');
}









    public function notificationview($id) {
        $updateNotification = $this->notification_model->updateNotification($id,array('is_read'=>1));
        $data['title'] = 'Notifications';
        $data['page'] =  'notification_list';
        $data['active_url'] =  'notification';
        $data['datatable'] = true;
        $data['notification'] = $this->notification_model->getnotification(array());
        $this->load->view('template',$data);
    }

    public function edit($id) {
        $data['title'] = 'Edit Notification';
        $data['page'] = 'create';
        $data['active_url'] = 'edit';

        // Decrypt the ID from the URL segment
        if (!$id) {
            show_404();  // If decryption fails or ID is not valid
        }
        $id = decrypt($id);
        
        // Fetch notification details
        $notification = $this->notification_model->getNotificationById($id);
        if (!$notification) {
            show_404();  // If notification not found
        }

        // Decode JSON strings into arrays
        $notification->patients = json_decode($notification->patients, true);
        $notification->doctors = json_decode($notification->doctors, true);

        // Fetch patients and doctors for the dropdown
        $data['patients'] = $this->notification_model->getAllPatients();
        $data['doctors'] = $this->notification_model->getAllDoctors();

        // Populate the form with existing data
        $data['notification'] = $notification;

        $this->load->view('template', $data);
    }


    public function update($id) {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        $data = [
            'title' => $this->input->post('title'),
            'message' => $this->input->post('message'),
            'patient_id' => $this->input->post('patient_id'),
            'doctor_id' => $this->input->post('doctor_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->notification_model->updateNotification($id, $data);

        $this->session->set_flashdata('success_message', 'Notification updated successfully.');
        redirect('notification/sendNotification');
    }


    public function delete()
    {
        $id = decrypt($this->uri->segment(4));
        $deleted_id = $this->notification_model->deletenotification($id);
        if($deleted_id > 0)
        {
            $this->session->set_flashdata('success_message','Notification deleted successfully');
            redirect('notification/notification');
        }
        else
        {
             $this->session->set_flashdata('error_message','Notification not delete due to techinical issue');
            redirect('notification/notification');
        }
    }

    public function delete_selected()
    {
        $id = $this->input->post('ids');
        $deleted_id = $this->notification_model->deletenotification($id);
        if($deleted_id > 0)
        {
            $this->session->set_flashdata('success_message','Selected Notification deleted successfully');
            redirect('notification/notification');
        }
        else
        {
             $this->session->set_flashdata('error_message','Notification not delete due to techinical issue');
            redirect('notification/notification');
        }    
    }


    public function deleteMessage()
    {
        $id = decrypt($this->uri->segment(4));
        $deleted_id = $this->notification_model->deleteMessage($id);
        if($deleted_id > 0)
        {
            $this->session->set_flashdata('success_message','Notification deleted successfully');
            redirect('notification/notification/sendNotification');
        }
        else
        {
             $this->session->set_flashdata('error_message','Notification not delete due to techinical issue');
            redirect('notification/notification/sendNotification');
        }
    }

    public function delete_selected_message()
{
    // Retrieve the 'ids' from POST data
    $id = $this->input->post('ids');

    // Check if 'ids' is an array and filter out unwanted values like 'on'
    if (is_array($id)) {
        // Filter the array to exclude non-numeric values and 'on'
        $id = array_filter($id, function($value) {
            return is_numeric($value) && $value !== 'on';
        });
        
    }

    // If the array is empty after filtering, handle the error
    if (empty($id)) {
        $this->session->set_flashdata('error_message', 'No valid notifications selected');
        redirect('notification/notification/sendNotification');
        return;
    }

    // Call the model method to delete messages with the filtered IDs
    $deleted_id = $this->notification_model->deleteMessage($id);

    if ($deleted_id > 0) {
        $this->session->set_flashdata('success_message', 'Selected Notification deleted successfully');
    } else {
        $this->session->set_flashdata('error_message', 'Notification not deleted due to technical issue');
    }

    // Redirect back to the notifications page
    redirect('notification/notification/sendNotification');
}

    

    public function sendmail($email, $title, $body)
    {
        $config = array(
            'protocol' => SMTP_PROTOCOL,
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USER,
            'smtp_pass' => SMTP_PASS,
            'mailtype' => SMTP_MAILTYPE,
            'charset' => SMTP_CHARSET
        );

        /*$setting = appsetting();
        $support_email = $setting[0]->support_email;
        $application_name = $setting[0]->website_title;*/
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $mail_from = SMTP_USER;
        $mail_from_name = APP_TITLE;
        $this->email->from($mail_from, $mail_from_name);
        $this->email->to($email);
        $this->email->subject($title);
        $this->email->message($body);
        $this->email->send();
        /*prx($this->email->print_debugger());*/
        //$this->Emaillibrary->sendEmail($email,$title,$body);

    }
}
