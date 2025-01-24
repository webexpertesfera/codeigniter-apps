<?php
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/
class Doctors extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('doctors_model','pharmacies/pharmacy_model','booking_model','doctor_model'));
        $this->load->library(array('AesCipher'));
    }
   public function index() {
    $data['title'] = 'Doctors';
    $data['page'] = 'doctors';
    $data['active_url'] = 'doctor/doctors';
    $data['datatable'] = true;

    // Fetch all doctors
    $doctors = $this->doctors_model->get_doctor(array());

    foreach ($doctors as $doctor) {
        $userId = $doctor->user_id;
        
        // Get available slots count for the doctor
        $availableSlotsCount = $this->getAvailableSlotsCount($userId, 'online');
        $documents = $this->doctors_model->get_doctors(array('u.user_id'=>$userId));
       // prx($documents);
        // Get the balances for the current doctor
        $withdrawBalance = $this->doctors_model->totalwithdrawbal(array('user_id' => $userId, 'type' => 'withdraw'));

        $depositBalance = $this->doctors_model->totalwithdrawbal(array('user_id' => $userId, 'type' => 'deposite'));


        $withdrawAmount = !empty($withdrawBalance) ? $withdrawBalance[0]->amount : 0;
        $depositAmount = !empty($depositBalance) ? $depositBalance[0]->amount : 0;
        $newBalance = $depositAmount - $withdrawAmount;

        // Store the balances in the doctor object
        $doctor->withdraw_bal = $withdrawAmount;
        $doctor->deposit_bal = $depositAmount;
        $doctor->new_bal = $newBalance;
         $getTransactions= $this->doctors_model->getTransactions($userId);
         $doctor->getTransactions =$getTransactions;
        // Determine if there are available slots
        $doctor->available_slots_count = $availableSlotsCount > 0 ? 'Yes' : 'No';

          // Check if the doctor has uploaded documents
    $education =isset($documents[0]->education) ? $documents[0]->education : '';


    $educationQualification = isset($documents[0]->education_qualification) ? $documents[0]->education_qualification : '';
    $medicalLicense = isset($documents[0]->medical_license) ? $documents[0]->medical_license : '';
    // Set document upload status
    $doctor->is_document_uploaded = (!empty($educationQualification) && !empty($medicalLicense)&& !empty($education)) ? 'Yes' : 'No';

    $online_commission=isset($documents[0]->online_commission) ? $documents[0]->online_commission : '';
    $clinic_commission=isset($documents[0]->clinic_commission) ? $documents[0]->clinic_commission : '';

    $home_commission=isset($documents[0]->home_commission) ? $documents[0]->home_commission : '';
    $doctor->is_clinic_seleted=$documents[0]->is_clinic != 0 ? 'Yes' : 'No';
      $doctor->is_online_seleted=$documents[0]->is_chat != 0 ||  $documents[0]->is_video != 0 ? 'Yes' : 'No';
      $doctor->is_commission_added = (!empty($online_commission) && !empty($clinic_commission)&& !empty($home_commission)) ? 'Yes' : 'No';
    }


    $data['data'] = $doctors;
    //prx($data);
    // Print the data (for debugging)


    // Load the view with the data
    $this->load->view('template', $data);
}


   public function create()
    {    
       
        $return_id  = $this->uri->segment(4);      
        if(empty($return_id))
        {
            $data['title'] = 'Doctors Create';
            $data['page'] = 'create_doctor';
            $data['active_url'] =  'doctor/doctors';
            $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
            $data['countries'] = $this->pharmacy_model->getAllCountries();
            $data['Designation'] = array();//$this->doctors_model->getdocdesign(array('is_active'=>1));
            $data['doc'] = [];     
                 $doc_id = $this->input->post('doctor_id');
                 // $post = $this->input->post();
                 // echo "<pre>";
                 // print_r($post); die;
                 if($doc_id == null || $doc_id == '')
                 {
                     $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric|callback_user_phone_exist');
                    // $this->form_validation->set_rules('ic_no', 'IC No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
                    $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
                    $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
                    //$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|strip_tags|xss_clean|valid_email|callback_user_email_exist');
                    $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
                     $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');
                    if ($this->form_validation->run() == FALSE)
                    {
                        $this->load->view('template',$data);
                    }// end if create form validation
                    else
                    {
                       
                       $service = $this->input->post('service', TRUE); // Fetch the selected services from POST data
                        $is_online = 0;
                        $is_clinic = 0;
                        $is_chat = 0;
                        $is_video = 0;
                        $is_home = 0;

                        for($i=0;$i<count($service);$i++)
                        {
                           
                            if($service[$i] == 'is_chat')
                            {
                                $is_chat = 1;
                                 $is_online = 1;
                            }
                            elseif ($service[$i] == 'is_video') {
                                $is_video = 1;
                                 $is_online = 1;
                            }
                            elseif ($service[$i] == 'is_clinic') {
                               $is_clinic = 1;
                            }
                            elseif ($service[$i] == 'is_home')
                            {
                                $is_home = 1;
                            }
                        }

                        $chat_first_time = '0.00';
                        $chat_follow_up = '0.00'; 
                        $video_first_time = '0.00';
                        $video_follow_up = '0.00';  
                        $home_first_time = '0.00'; 
                        $home_follow_up = '0.00';
                        $clinic_first_time = '0.00';
                        $clinic_follow_up = '0.00';
                        $chatFT = $this->input->post('chatFT');
                        $chatFU = $this->input->post('chatFU');
                        $videoFT = $this->input->post('videoFT');
                        $videoFU = $this->input->post('videoFU');
                        $homeFT = $this->input->post('homeFT');
                        $homeFU = $this->input->post('homeFU');
                        $clinicFT = $this->input->post('clinicFT');
                        $clinicFU = $this->input->post('clinicFU');
                        if(empty($chatFT))
                        {
                          $chat_first_time = '0.00';
                        }
                        else
                        {
                          $chat_first_time = $chatFT;
                        }
                        if(empty($chatFU))
                        {
                          $chat_follow_up = '0.00';
                        }
                        else
                        {
                          $chat_follow_up = $chatFU;
                        }
                        if(empty($videoFT))
                        {
                          $video_first_time = '0.00';
                        }
                        else
                        {
                          $video_first_time = $videoFT;
                        }
                        if(empty($videoFU))
                        {
                          $video_follow_up = '0.00';
                        }
                        else
                        {
                          $video_follow_up = $videoFU;
                        }
                        if(empty($homeFT))
                        {
                          $home_first_time = '0.00';
                        }
                        else
                        {
                          $home_first_time = $homeFT;
                        }
                        if(empty($homeFU))
                        {
                          $home_follow_up = '0.00';
                        }
                        else
                        {
                          $home_follow_up = $homeFU;
                        }
                         if(empty($clinicFT))
                        {
                          $clinic_first_time = '0.00';
                        }
                        else
                        {
                          $clinic_first_time = $clinicFT;
                        }
                        if(empty($clinicFU))
                        {
                          $clinic_follow_up = '0.00';
                        }
                        else
                        {
                          $clinic_follow_up = $clinicFU;
                        }
                        
                        $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }
                        // patient data
                        $user_id = get_user_id(2);
                       // prx($user_id);

                        if (!empty($_FILES['profile_image']['name']))
                        {
                            $fileinfo = @getimagesize($_FILES["profile_image"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["profile_image"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                  redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                            else if (($_FILES["profile_image"]["size"] > 2000000)) {                   
                                 $this->session->set_flashdata('error','Image size exceeds 2MB');
                                  redirect('doctor/doctors');
                            }    // Validate image file dimension
                            else {
                                
                                $profile_name = '200220000_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $profile_name;
                                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target)) {
                                    $pic_path = $profile_name;
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading profile image.');
                                     redirect('doctor/doctors');
                                   
                                }
                            }
                        }else{
                            $pic_path= null;
                        }

                        if(!empty($_FILES['ic_pic']['name']))
                        {
                           $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                    redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                    redirect('doctor/doctors');

                            }   
                            else {
                                
                                $ic_picture = $user_id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $ic_picture;
                                //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                    $ic_path = $ic_picture;
                                     $upload = array('ic_pic'=>$ic_path);
                                   // $upload_ic_profile = $this->doctor_model->updatedoctorinfo($upload,$sess_data['user_id']);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                    redirect('doctor/doctors');
                                   
                                }
                            }
                        }else{
                            $ic_path=null;
                        }

                        if(!empty($_FILES['education']['name'])){
                           $fileinfo = @getimagesize($_FILES["education"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                    redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                    redirect('doctor/doctors');

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $user_id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                   
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                    redirect('doctor/doctors');
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                                redirect('doctor/doctors');
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                                redirect('doctor/doctors');
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $user_id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    redirect('doctor/doctors');
                                }
                            }
                        }

                       
                        $patient_data = [
                            'doctor_id'    => $user_id,
                            'first_name'    => AesCipher::encrypt($this->input->post('first_name')),
                            'last_name'    => $this->input->post('first_name'),
                            'mobile_no'     => AesCipher::encrypt($this->input->post('phone_no')),
                            'country_code'  =>AesCipher::encrypt($this->input->post('country_code')),
                            'gender'        =>  (int) $this->input->post('gender'),
                            'profile_pic'        =>$pic_path,
                            'medical_license' => $medical_license_filename,
                            'education'=>$edu_path,
                            'ic_pic'=>$ic_path,
                            'birth_date'    =>  date('Y-m-d',strtotime($this->input->post('birth_date'))),
                            'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                            'permanent_address' =>AesCipher::encrypt($this->input->post('permanent_address')),
                            'country'       => $this->input->post('country'),
                            'rcc_no' =>$rcc_no,
                            'education_qualification'=>AesCipher::encrypt($this->input->post('education')),
                            'current_wokplace'=>AesCipher::encrypt($this->input->post('current_workplace')),
                            'about'=>AesCipher::encrypt($this->input->post('aboutus')),
                            'hospital_department_id'=>$this->input->post('category'),
                            'clicnic_intrest'=>AesCipher::encrypt($this->input->post('clinic_intrest')),
                            'appointment_description'=>AesCipher::encrypt($this->input->post('appointment_description')),
                            'is_online'=>$is_online,
                            'timezone'=>$this->input->post('timezone'),
                            'is_home'=>$is_home,
                            'is_clinic'=>$is_clinic,
                            'is_chat'=>$is_chat,
                            'is_video'=>$is_video,
                            'created_by'    => $this->user_id,
                            'created_time'  => $this->created_time,
                            'created_by_ip' => $this->user_ip,
                            'chat_first_time'=>$chat_first_time,
                            'chat_follow_up'=>$chat_follow_up,
                            'video_first_time'=>$video_first_time,
                            'video_follow_up'=>$video_follow_up,
                            'home_fee'=>$home_first_time,
                            'home_follow_up'=>$home_follow_up,
                            'clinic_fee'=>$clinic_first_time,
                            'clinic_fllow_up'=>$clinic_follow_up,
                            'latitude' => $this->input->post('address_latitude'),
                            'longitude' => $this->input->post('address_longitude')
                        ];
                       
                         $p_name=  $this->input->post('first_name');
                         $namekey =  mb_substr($p_name, 0, 4);
                         $dob = $this->input->post('birth_date');
                         $dob1 = date('Y',strtotime($dob));
                         $generate_password = strtoupper($namekey).'@'.$dob1;
                         
                         $email = $this->input->post('email');
                         $user_data = [
                            'user_id'       => $user_id,
                            'email'         => (string) AesCipher::encrypt($this->input->post('email')),
                            'user_type'     => 2,
                            'mobile_no'     => AesCipher::encrypt($this->input->post('phone_no')),
                            'country_code'  =>AesCipher::encrypt($this->input->post('country_code')),
                            'password'      => (string) AesCipher::encrypt($generate_password),
                            'country'       => $this->input->post('country'),
                            'created_by'    => $this->user_id,
                            'created_time'  => $this->created_time,
                            'created_by_ip' => $this->user_ip,
                            'admin_approve'=>1,
                            'is_info'=>1                  
                        ];
                        $insert_catg_id = [];
                        $insert_spec_id = [];
                        $create = $this->doctors_model->create($patient_data,$user_data);
                       $user_bank_data =[
                        "bank_name" => AesCipher::encrypt($this->input->post('bank_name')),
                        "bank_account_name" => AesCipher::encrypt($this->input->post('bank_account_name')),
                        "account_number" => AesCipher::encrypt($this->input->post('account_number')),
                        "ifsc_code" => AesCipher::encrypt($this->input->post('ifsc_code')),

                        "doctor_id" => $user_id
                    ];
                    
                       
                    $insert_id = $this->doctors_model->saveaccount($user_bank_data);
                       
                       
                        $speciality = $this->input->post('speciality');
                        
                            for($i=0;$i<count($speciality);$i++)
                            {
                               // $insert_spec = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i]);
                               
                                 $updateData = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i],'chat_first_time'=>$chat_first_time, 'chat_follow_up'=>$chat_follow_up,'video_first_time'=>$video_first_time, 'video_follow_up'=>$video_follow_up,'home_first_time'=>$home_first_time, 'home_follow_up'=>$home_follow_up,'clinic_first_time'=>$clinic_first_time, 'clinic_follow_up'=>$clinic_follow_up);
                                  $insert_spec_id[] = $this->doctors_model->insertdocspeciality($updateData);
                            }

                        if ($create['status'] == 'success'  && count($insert_spec_id) > 0) 
                        {
                             $subject = 'Create Doctor';
                            $body ="Dear ".$p_name."<br /><br /> Your account has been created successfully by Admin. Your password is combination of the first four letters of your name written in CAPITALS (Name as mentioned during signup) @ your Year of Birth (in YYYY format).<br /><br />Thank you for choosing TeleDoc";
                            $this->sendmail($email,$subject,$body);
                            $this->session->set_flashdata('success_message', 'New Doctor create successfully');
                            redirect('doctor/doctors');
                        } 
                        else 
                        {
                             $data['status'] = 'error';
                             $data['message'] = 'Doctor Not Created';
                            $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
                            $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active'=>1));
                            $this->load->view('template', $data);
                        }
                    } // end else create form validation

                 } // end if $doc_id
                 else
                 {
                    
                    $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric');
                    // $this->form_validation->set_rules('ic_no', 'IC No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
                    $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
                    $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|strip_tags|xss_clean|valid_email');
                    $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
                     $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');
                     if ($this->form_validation->run() == FALSE)
                    {
                        $this->load->view('template',$data);
                    } // end if doctor update form validation
                    else
                    {
                            $doc_id = decrypt($doc_id);
                            $ $pic_path = $this->handle_image_upload('profile_image', 'doctor', $id);
           
                        if(!empty($_FILES['ic_pic']['name'])){
                               $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                                $width = $fileinfo[0];
                                $height = $fileinfo[1];    
                                $allowed_image_extension = array("png","jpg","jpeg");                
                                $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                                if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                    $this->session->set_flashdata('error','Choose image file to upload');
                                        
                                }   
                                else if (! in_array($file_extension, $allowed_image_extension)) {
                                     $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                        

                                }    // Validate image file size
                                 // Validate image file dimension
                                else {
                                    if(!empty($doctor[0]->ic_pic))
                                    {
                                        $path = getcwd()."/upload/doctor/".$doctor[0]->ic_pic;
                                        unlink($path);                       
                                    }
                                    $ic_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                    $target = getcwd()."/upload/doctor/" . $ic_picture;
                                    //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                    if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                         $ic_path = $ic_picture;
                                         $upload = array('ic_pic'=>$ic_path);
                                        $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    } else {
                                         $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                        
                                       
                                    }
                                }
                        }
                        if(!empty($_FILES['education_pic']['name'])){
                           $fileinfo = @getimagesize($_FILES["education_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                   
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education_pic"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                    $$upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                            prx('lll');
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                               
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                               
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    
                                }
                            }
                        }
            // Process selected services
            $services = $this->input->post('service', TRUE) ?: [];

            $is_chat = in_array('chat_service', $services) ? 1 : 0;
            $is_video = in_array('video_service', $services) ? 1 : 0;
            $is_clinic = in_array('clinic_service', $services) ? 1 : 0;
            $is_home = in_array('home_service', $services) ? 1 : 0;
         
            $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }

                         $chat_first_time = $this->input->post('chatFT');
                        $chat_follow_up = $this->input->post('chatFU');
                        $video_first_time = $this->input->post('videoFT');
                        $video_follow_up = $this->input->post('videoFU');
                        $home_first_time = $this->input->post('homeFT');
                        $home_follow_up = $this->input->post('homeFU');
                        $clinic_first_time = $this->input->post('clinicFT');
                        $clinic_follow_up = $this->input->post('clinicFU');
            // Patient data array
            $patient_data = [
                'doctor_id' => $id,
                'first_name' => AesCipher::encrypt($this->input->post('first_name')),
                'last_name' => $this->input->post('first_name'),
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt('234'),
                'gender' => (int) $this->input->post('gender'),
                
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                'permanent_address' => AesCipher::encrypt($this->input->post('permanent_address')),
                'country' => $this->input->post('country'),
               /* 'registeration_no' => AesCipher::encrypt($this->input->post('registration_no')),*/
                'rcc_no' => $rcc_no,
                'education_qualification' => AesCipher::encrypt($this->input->post('education')),
                'current_wokplace' => AesCipher::encrypt($this->input->post('current_workplace')),
                'about' => AesCipher::encrypt($this->input->post('aboutus')),
                'hospital_department_id' => $this->input->post('category'),
                'clicnic_intrest' => AesCipher::encrypt($this->input->post('clinic_intrest')),
                'appointment_description' => AesCipher::encrypt($this->input->post('appointment_description')),
                'is_online' => 0,
                'timezone' => $this->input->post('timezone'),
                'is_home' => $is_home,
                'is_clinic' => $is_clinic,
                'is_chat' => $is_chat,
                'is_video' => $is_video,
                'created_by' => $this->user_id,
                'created_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'chat_first_time' => $chat_first_time,
                'chat_follow_up' => $chat_follow_up,
                'video_first_time' => $video_first_time,
                'video_follow_up' => $video_follow_up,
                'home_fee' => $home_first_time,
                'home_follow_up' => $home_follow_up,
                'clinic_fee' => $clinic_first_time,
                'clinic_fllow_up' => $clinic_follow_up,
                'latitude' => $this->input->post('address_latitude'),
                'longitude' => $this->input->post('address_longitude')
            ];
         

            $user_data = [
                'user_type' => 2,
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt($this->input->post('country_code')),
                'created_by' => $this->user_id,
                'updated_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'timezone' => $this->input->post('timezone'),
                'admin_approve' => 1,
                'is_info' => 1
            ];

                        if(!empty($speciality)){
                            $delcatg = $this->doctors_model->deletedoctorspeciality(array('doc_id'=>$doc_id));
                            for($i=0;$i<count($speciality);$i++)
                            {
                                $insert_spec = array('doc_id'=>$doc_id,'spec_id'=>$speciality[$i]);
                                $insert_spec_id[] = $this->doctors_model->insertdocspeciality($insert_spec);
                            }
                        }
                         if ($create >0 && count($insert_catg_id) > 0 && count($insert_spec_id) > 0) 
                            {
                                $this->session->set_flashdata('success_message', 'New Doctor updated successfully');
                                redirect('doctor/doctors');
                            } 
                            else 
                            {
                               
                                $data['title'] = 'Doctors Update';
                                $data['page'] = 'create_doctor';
                                $data['active_url'] =  'doctor/doctors/create/'.$return_id;
                                $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
                                $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active'=>1));
                                $return_id = decrypt($return_id);
                                $data['doc'] = $this->doctors_model->get_doctors(array('u.user_id'=>$return_id));
                                $spec = $this->doctors_model->getspeciality(array('doc_id'=>$return_id));
                                $catg = $this->doctors_model->getcategory(array('doc_id'=>$return_id));
                                $speciality = [] ;
                                $category = [];
                                foreach($spec as $key)
                                {
                                    $speciality[] = $key->id;
                                }
                                foreach($catg as $key)
                                {
                                    $category[] = $key->id;
                                }
                                $data['speciality'] = $speciality;
                                $data['category'] = $category;    
                                 $data['doc'] = [];     
                                $this->load->view('template', $data);
                            }
                    }// end else doctor update form validation
                 } // end else $doc_id
       }// end if return_id
       
    }

    public function add_clinic($user_id)
    {

        $data['title'] = 'Create Doctor Clinic';
        $data['page'] =  'clinic';
        $data['active_url'] =  'doctor/doctors';
        $data['user_id'] = $user_id;
        $data['clinic'] = $this->doctors_model->getclinics(array('c.doctor_id'=>decrypt($user_id)));
       // prx($data['clinic']);
        $this->load->view('template', $data);
    }

    public function createclinic()
    {
            $clinic_name = $this->input->post('clinic_name');
            $clinic_address = $this->input->post('clinic_address');
            $time_slot = $this->input->post('select_time');
            $user_id = $this->input->post('user_id');
           
            $clinic_data = $this->input->post('exit_doctor');
            if($clinic_data == 0){
            $user_id = decrypt($user_id);
            // prx($user_id);
            $clinic_id = [];
            $time_id = [];
            $new_time = '';
            for($i=0;$i<count($clinic_name);$i++)
            {
                if($clinic_name[$i] != '')
                {
                    $insert = array('doctor_id'=>$user_id,'name'=>(string)AesCipher::encrypt($clinic_name[$i]),'address'=>(string)AesCipher::encrypt($clinic_address[$i]),'latitude'=>'','longitude'=>'','status'=>'active');
                    $clinic_id = $this->doctors_model->inertclinic($insert);
                    

                        $new_time = explode(',', $time_slot[$i]);
                        for($j=0;$j<count($new_time);$j++)
                        {
                           $ex_time = explode('#', $new_time[$j]);
                           $insert_time = array('doctor_id'=>$user_id,'clinic_id'=>$clinic_id,'day'=>$ex_time[0],'start_time'=>$ex_time[1],'end_time'=>$ex_time[2],'evening_start_time'=>$ex_time[3],'evening_end_time'=>$ex_time[4],'created_time'=>date('Y-m-d h:i:s'),'created_by'=>$user_id);  
                            $time_id[] = $this->doctors_model->inserttimeslot($insert_time);        
                        }    
                }                
            }
           
            if(count($clinic_id) >0 && count($time_slot)>0)
            {
                 $update = array('is_clinic'=>1,'is_doc'=>1);
                $up = $this->doctors_model->updateuser($update,$user_id);
               $this->session->set_flashdata('success_message', 'Clinic create successfully');
                    redirect('doctor/doctors/add_fees/'.encrypt($user_id));
            }
            else
            {
                 $this->session->set_flashdata('error_message', 'Clinic not create.Please try again later');
                    redirect('doctor/doctors/add_clinic/'.encrypt($user_id));
            }
        }
        else
        {
            $user_id = decrypt($user_id);
            
            $clinic_id = [];
            $time_id = [];
            $new_time = '';
            $dell = $this->doctors_model->deleteclinic(array('doctor_id'=>$user_id));
            $delete = $this->doctors_model->deletetimeslot(array('doctor_id'=>$user_id));
            for($i=0;$i<count($clinic_name);$i++)
            {
                if($clinic_name[$i] != '')
                {
                    $insert = array('doctor_id'=>$user_id,'name'=>(string)AesCipher::encrypt($clinic_name[$i]),'address'=>(string)AesCipher::encrypt($clinic_address[$i]),'latitude'=>'','longitude'=>'','status'=>'active');
                    $clinic_id = $this->doctors_model->inertclinic($insert);
                    

                        $new_time = explode(',', $time_slot[$i]);
                        for($j=0;$j<count($new_time);$j++)
                        {
                           $ex_time = explode('#', $new_time[$j]);
                           $insert_time = array('doctor_id'=>$user_id,'clinic_id'=>$clinic_id,'day'=>$ex_time[0],'start_time'=>$ex_time[1],'end_time'=>$ex_time[2],'evening_start_time'=>$ex_time[3],'evening_end_time'=>$ex_time[4],'created_time'=>date('Y-m-d h:i:s'),'created_by'=>$user_id);  
                            $time_id[] = $this->doctors_model->inserttimeslot($insert_time);        
                        }    
                }                
            }
           
            if(count($clinic_id) >0 && count($time_slot)>0)
            {
                 $update = array('is_clinic'=>1,'is_doc'=>1);
                $up = $this->doctors_model->updateuser($update,$user_id);
               $this->session->set_flashdata('success_message', 'Clinic Updated successfully');
                    redirect('doctor/doctors/add_fees/'.encrypt($user_id));
            }
            else
            {
                 $this->session->set_flashdata('error_message', 'Clinic not Updated.Please try again later');
                    redirect('doctor/doctors/add_clinic/'.encrypt($user_id));
            }
        }

    }
    public function add_fees($user_id)
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'fees';
        $data['active_url'] =  'doctor/fees';
        $data['user_id'] = $user_id;
        $user_id = decrypt($user_id);
        $data['doc'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
        $specialities = $this->doctors_model->getdoctorspecialitiesWithName(array('s.doc_id'=>$user_id));
        $data['specialities'] = $specialities;
        $this->load->view('template', $data);
    }

    public function savefees()
    {
         $data['title'] = 'Doctors';
        $data['page'] =  'fees';
        $data['active_url'] =  'doctor/fees';   
        
        $post = $this->input->post();
     
       

       
        if(!empty($post)){
        $user_id = decrypt($post['user_id']);
      
        $doctor = $this->doctors_model->saveCVOH($post); // CVOH -> Chat,video,online and home

       
        $specialities = $this->doctors_model->getdoctorspecialities(array('doc_id'=>$user_id));
       
        $specialities[0]->chat_first_time   = $post['chat_first_time'];
        $specialities[0]->chat_follow_up    = $post['chat_follow_up'];
        $specialities[0]->video_first_time  = $post['video_first_time'];
        $specialities[0]->video_follow_up   = $post['video_follow_up'];
        $specialities[0]->home_first_time   = $post['home_first_time'];
        $specialities[0]->home_follow_up    = $post['home_follow_up'];
        $specialities[0]->clinic_first_time = $post['clinic_first_time'];
        $specialities[0]->clinic_follow_up  = $post['clinic_follow_up'];

        foreach($specialities as $speciality){
            $price_first_time = $post['categoryFT'.$speciality->spec_id];
            $price_follow_up = $post['categoryFU'.$speciality->spec_id];
            $updateData = array('price_first_time'=>$price_first_time, 'price_follow_up'=>$price_follow_up);
            $updateSpec = $this->doctors_model->updateDoctorSpecility(array('doc_id'=>$user_id,'spec_id'=>$speciality->spec_id),$updateData);
        }
      
            $update = array('is_fees'=>1);
            $up = $this->doctors_model->updateuser($update,$user_id);
            $this->session->set_flashdata('success_message','Doctor Information saved successfully.');
           redirect('doctor/doctors/add_commission/'.encrypt($user_id));
        
       }
       else
       {
            $this->session->set_flashdata('success_message','Something went wrong. Please try again later');
            redirect('doctor/doctors/add_fees/'.$post['user_id']);
            
       }
            

    }

    public function view()
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'view';
        $data['active_url'] =  'doctor/view';
        $user_id = $this->uri->segment(4);
        $user_id = decrypt($user_id);
       //prx($user_id);
        $doc = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
       $data['doctor'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));

        $data['speciality'] = $this->doctors_model->getspeciality(array('doc_id'=>$doc[0]->user_id));
        $data['category'] = $this->doctors_model->getcategory(array('doc_id'=>$doc[0]->user_id));
        $data['category_name'] = $this->doctors_model->getcategories(array('id'=>$doc[0]->hospital_department_id));
       
        $clinic = $this->doctors_model->getclinic(array('c.doctor_id'=>$user_id));
        //prx($clinic);
        $orderr = [];
       foreach ($clinic as $key => $value) {
            $orderr[$value->id][] = $value;
        }
       $data['clinic'] = $orderr;
        $data['doc'] = $doc;
        $data['online'] = $this->doctors_model->getdoctorschedule(array('doctor_id'=>$user_id,'service'=>'online'));
        $data['home'] = $this->doctors_model->getdoctorschedule(array('doctor_id'=>$user_id,'service'=>'home'));
        $data['specialities'] = $this->doctors_model->getdoctorspecialitiesWithName(array('doc_id'=>$user_id));
        $data['bank_details'] = $this->doctors_model->getdoctoraccount(array('doctor_id'=>$user_id));
      
        $this->load->view('template', $data);
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
        $param = array('email'=>(string) AesCipher::encrypt($this->input->post('email')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_email_exist', 'The Email address already exist');
            return false;
        }
        else {
            return true;
        }

    }
     public function user_phone_exist($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */
        $param = array('mobile_no'=>(string) AesCipher::encrypt($this->input->post('phone_no')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_phone_exist', 'The Phone No. already exist');
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
    $id = (int) isset($_POST['id']) ? $this->input->post('id') : $this->uri->segment(4);
    $bank_id=isset($_POST['bank_id'])? $this->input->post('bank_id') : '';
    $return_id = $this->uri->segment(4);

    $data['title'] = 'Doctor update';
    $data['page'] = 'update_doctor';
    $data['active_url'] = 'doctor/doctors';
    $data['data'] = $this->doctors_model->get_doctors(array('u.user_id' => $id));
    $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active' => 1));
   // prx($_FILES);
    if (isset($_POST['submit'])) {
    
        $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric');

        $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
        $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template',$data);
        } else {
        
            if (!empty($_FILES['profile_image']['name'])){
                            $fileinfo = @getimagesize($_FILES["profile_image"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["profile_image"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                  redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                            else if (($_FILES["profile_image"]["size"] > 2000000)) {                   
                                 $this->session->set_flashdata('error','Image size exceeds 2MB');
                                  redirect('doctor/doctors');
                            }    // Validate image file dimension
                            else {
                                
                                $profile_name = $id.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $profile_name;
                                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target)) {
                                    $pic_path = $profile_name;
                                     $upload = array('profile_pic'=>$pic_path);
                                   $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading profile image.');
                                     redirect('doctor/doctors');
                                   
                                }
                            }
                        }
                    
                        if(!empty($_FILES['ic_pic']['name'])){
                               $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                                $width = $fileinfo[0];
                                $height = $fileinfo[1];    
                                $allowed_image_extension = array("png","jpg","jpeg");                
                                $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                                if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                    $this->session->set_flashdata('error','Choose image file to upload');
                                        
                                }   
                                else if (! in_array($file_extension, $allowed_image_extension)) {
                                     $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                        

                                }    // Validate image file size
                                 // Validate image file dimension
                                else {
                                    if(!empty($doctor[0]->ic_pic))
                                    {
                                        $path = getcwd()."/upload/doctor/".$doctor[0]->ic_pic;
                                        unlink($path);                       
                                    }
                                    $ic_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                    $target = getcwd()."/upload/doctor/" . $ic_picture;
                                    //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                    if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                         $ic_path = $ic_picture;
                                         $upload = array('ic_pic'=>$ic_path);
                                        $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    } else {
                                         $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                        
                                       
                                    }
                                }
                        }
                        if(!empty($_FILES['education_pic']['name'])){
                           $fileinfo = @getimagesize($_FILES["education_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                   
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education_pic"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                          
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                               
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                               
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    
                                }
                            }
                        }
                    // Process selected services
                    $services = $this->input->post('service', TRUE) ?: [];

                    $is_chat = in_array('chat_service', $services) ? 1 : 0;
                    $is_video = in_array('video_service', $services) ? 1 : 0;
                    $is_clinic = in_array('clinic_service', $services) ? 1 : 0;
                    $is_home = in_array('home_service', $services) ? 1 : 0;
         
                    $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }

                        $chat_first_time = $is_chat ? $this->input->post('chatFT') : '0.00';
                        $chat_follow_up = $is_chat ? $this->input->post('chatFU') : '0.00';
                        $video_first_time = $is_video ? $this->input->post('videoFT') : '0.00';
                        $video_follow_up = $is_video ? $this->input->post('videoFU') : '0.00';
                        $home_first_time = $is_home ? $this->input->post('homeFT') : '0.00';
                        $home_follow_up = $is_home ? $this->input->post('homeFU') : '0.00';
                        $clinic_first_time = $is_clinic ? $this->input->post('clinicFT') : '0.00';
                        $clinic_follow_up = $is_clinic ? $this->input->post('clinicFU') : '0.00';
            // Patient data array
            $patient_data = [
                'doctor_id' => $id,
                'first_name' => AesCipher::encrypt($this->input->post('first_name')),
                'last_name' => $this->input->post('first_name'),
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt('234'),
                'gender' => (int) $this->input->post('gender'),
                
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                'permanent_address' => AesCipher::encrypt($this->input->post('permanent_address')),
                'country' => $this->input->post('country'),
                'registeration_no' => AesCipher::encrypt($this->input->post('registration_no')),
                'rcc_no' => $rcc_no,
                'education_qualification' => AesCipher::encrypt($this->input->post('education')),
                'current_wokplace' => AesCipher::encrypt($this->input->post('current_workplace')),
                'about' => AesCipher::encrypt($this->input->post('aboutus')),
                'hospital_department_id' => $this->input->post('category'),
                'clicnic_intrest' => AesCipher::encrypt($this->input->post('clinic_intrest')),
                'appointment_description' => AesCipher::encrypt($this->input->post('appointment_description')),
                'is_online' => 0,
                'timezone' => $this->input->post('timezone'),
                'is_home' => $is_home,
                'is_clinic' => $is_clinic,
                'is_chat' => $is_chat,
                'is_video' => $is_video,
                'created_by' => $this->user_id,
                'created_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'chat_first_time' => $chat_first_time,
                'chat_follow_up' => $chat_follow_up,
                'video_first_time' => $video_first_time,
                'video_follow_up' => $video_follow_up,
                'home_fee' => $home_first_time,
                'home_follow_up' => $home_follow_up,
                'clinic_fee' => $clinic_first_time,
                'clinic_fllow_up' => $clinic_follow_up,
                'latitude' => $this->input->post('address_latitude'),
                'longitude' => $this->input->post('address_longitude')
            ];
          
            $user_data = [
                'user_type' => 2,
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt($this->input->post('country_code')),
                'created_by' => $this->user_id,
                'updated_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'timezone' => $this->input->post('timezone'),
                'admin_approve' => 1,
                'is_info' => 1
            ];



            $create = $this->doctors_model->updatedoctors($user_data, $patient_data,$id);
            $user_bank_data =[
                "bank_name" => AesCipher::encrypt($this->input->post('bank_name')),
                "bank_account_name" => AesCipher::encrypt($this->input->post('bank_account_name')),
                "account_number" => AesCipher::encrypt($this->input->post('account_number')),
                "ifsc_code" => AesCipher::encrypt($this->input->post('ifsc_code')),
                "doctor_id" => $id
            ];
            if ($bank_id == '') {
               
                    $insert_id = $this->doctors_model->saveaccount($user_bank_data);
                } else {
                  
                    $insert_id = $this->doctors_model->updateaccount($user_bank_data, $bank_id);

                }
            
             $speciality = $this->input->post('speciality');
             $del_spec = $this->doctors_model->deletespeciality(array('doc_id'=>$id));           
            for($i=0;$i<count($speciality);$i++)
            {
               // $insert_spec = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i]);
               
                 $updateData = array('doc_id'=>$id,'spec_id'=>$speciality[$i],'chat_first_time'=>$chat_first_time, 'chat_follow_up'=>$chat_follow_up,'video_first_time'=>$video_first_time, 'video_follow_up'=>$video_follow_up,'home_first_time'=>$home_first_time, 'home_follow_up'=>$home_follow_up,'clinic_first_time'=>$clinic_first_time, 'clinic_follow_up'=>$clinic_follow_up);
                  $insert_spec_id[] = $this->doctors_model->insertdocspeciality($updateData);
            }

            if ($create['status'] == 'success') {
                $this->session->set_flashdata('success_message', 'Doctor Information Update successfully');
                redirect('doctor/doctors');
            } else {
                $data['status'] = $create['status'];
                $data['message'] = $create['message'];
                $this->load->view('template', $data);
            }
        }
    } else {
        $return_id = $return_id;

        $doc = $this->doctors_model->get_doctors(array('u.user_id' => $return_id));
        $spec = $this->doctors_model->getspeciality(array('doc_id' => $return_id));
        $catg = $this->doctors_model->getcategory(array('doc_id' => $return_id));
        $data['categories'] = $this->doctors_model->getcategories(array('status' => 'active'));
        $data['specialities'] = $this->doctors_model->getdoctorspecialitiesWithName(array('s.doc_id' => $return_id));
        $data['Designation'] = $this->doctors_model->getdocdesign(array('category_id' => $doc[0]->hospital_department_id));
        $data['doc'] = $doc;

        $speciality = [];
        $category = [];
        foreach ($spec as $key) {
            $speciality[] = $key->id;
        }

        $data['speciality'] = $speciality;
        $data['category'] = $category;
        $this->load->view('template', $data);
    }
}

/**
 * Handle image upload and return the uploaded file path.
 * 
 * @param string $field_name
 * @param string $folder
 * @param int $user_id
 * @param string|null $old_file
 * @return string|null
 */
private function handle_image_upload($field_name, $folder, $user_id, $old_file = null) {
    if (!empty($_FILES[$field_name]['name'])) {
        $fileinfo = @getimagesize($_FILES[$field_name]["tmp_name"]);
        $file_extension = pathinfo($_FILES[$field_name]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg");

        if (!file_exists($_FILES[$field_name]["tmp_name"])) {
            $this->session->set_flashdata('error', 'Choose image file to upload');
            redirect('doctor/doctors');
        } elseif (!in_array($file_extension, $allowed_image_extension)) {
            $this->session->set_flashdata('error', 'Upload valid images. Only PNG and JPEG and JPG are allowed');
            redirect('doctor/doctors');
        } elseif ($_FILES[$field_name]["size"] > 2000000) {
            $this->session->set_flashdata('error', 'Image size exceeds 2MB');
            redirect('doctor/doctors');
        } else {
            if ($old_file) {
                $old_file_path = getcwd() . "/upload/$folder/$old_file";
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            $new_filename = $user_id . '_' . rand(0, 999999) . '.' . $file_extension;
            $target = getcwd() . "/upload/$folder/" . $new_filename;

            if (move_uploaded_file($_FILES[$field_name]["tmp_name"], $target)) {
                return $new_filename;
            } else {
                $this->session->set_flashdata('error', 'Problem in uploading image files.');
                redirect('doctor/doctors');
            }
        }
    }
    return null;
}


     public function sendmail($email,$title,$body)
    {

        $config = Array(
        'protocol' => SMTP_PROTOCOL,
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_user' => SMTP_USER,
        'smtp_pass' => SMTP_PASS,
        'mailtype'  => SMTP_MAILTYPE, 
        'charset'   => SMTP_CHARSET,
        'newline' => "\r\n"
    );

        /*$setting = appsetting();
        $support_email = $setting[0]->support_email;
        $application_name = $setting[0]->website_title;*/
        $this->load->library('email');
         $this->email->initialize($config);
        //$this->email->set_newline("\r\n");
        $mail_from = SMTP_USER;
        $mail_from_name = APP_TITLE;
        $this->email->from($mail_from, $mail_from_name);
        $this->email->to($email);
        $this->email->subject($title);
        $this->email->message($body);
        $this->email->send();
    //prx($this->email->print_debugger());
        //$this->Emaillibrary->sendEmail($email,$title,$body);
    
    }
public function status()
{
    $doctor_id = $this->uri->segment(4);
    $status = $this->uri->segment(5);
    $doctor_detail = $this->doctors_model->get_doctors(array('u.user_id'=>$doctor_id));


    if ($status == 'rejectDoctor') {
       
        $update = ['admin_approve' => 0];
        $update_id = $this->doctors_model->updatedoctorsss($update, $doctor_id);
        $updates = ['is_active' => 2];
        $updated_doc = $this->doctors_model->updatedoctorstatus($updates, $doctor_id);

        if ($update_id > 0 || $updated_doc > 0) {
            $this->session->set_flashdata('success_message', 'Doctor Unapproved successfully');
            redirect('doctor/doctors');
        } else {
            $this->session->set_flashdata('error_message', 'Doctor not approved due to technical issue');
            redirect('doctor/doctors');
        }
    } elseif ($status == 'approve') {
      
        $update = ['admin_approve' => 1];
        $update_id = $this->doctors_model->updatedoctorsss($update, $doctor_id);
        $updates = ['is_active' => 1];
        $updated_doc = $this->doctors_model->updatedoctorstatus($updates, $doctor_id);

        if ($update_id > 0 || $updated_doc > 0) {
            // Ensure you have fetched the doctor's name and email correctly
           // Assuming this function gets the doctor's details
            $p_name = AesCipher::decrypt($doctor_detail[0]->first_name);
            $email = AesCipher::decrypt($doctor_detail[0]->email);

            $subject = 'Congratulations, Doctor! Your TeleDoc Account is Live!';
            $body = "
                Dear Dr. " . $p_name . ",<br /><br />

                Congratulations and welcome to TeleDoc!<br /><br />

                We are delighted to inform you that your application has been approved.<br /><br />

                Your TeleDoc account is now live, and you’re officially part of a growing family of healthcare professionals transforming patient care through telemedicine.<br /><br />

                Here’s what you can do next:<br /><br />

                <strong>Step 1: Open Your Available Timeslot/Booking Calendar:</strong><br />
                Set your availability so patients can start booking appointments with you right away.<br /><br />

                <strong>Step 2: Install the \"TeleDoc Doctor\" App:</strong><br />
                Download and install the TeleDoc Doctor App:<br /><br />

                <strong>Android:</strong> Install the Doctor App <a href='https://play.google.com/store/apps/det...torteledoc'>here</a><br /><br />
                <strong>iOS:</strong> Install the Doctor App <a href='https://apps.apple.com/gb/app/teledoc-...6499308065'>here</a><br /><br />

                <strong>Step 3: Generate Your Marketing Flyer:</strong><br />
                Create your personalized consultation flyer, share it on your social media, and start attracting consultations from your patients quickly and easily.<br /><br />

                Generate Flyer: <a href='https://getdp.co/doctors'>Click Here to Create Your Flyer</a><br /><br />

                If you have any questions or need assistance, feel free to contact our support team at:<br /><br />

                Email: <a href='mailto:doctors@teledoc.com.ng'>doctors@teledoc.com.ng</a><br />
                WhatsApp: +2349031664872<br /><br />

                We’re here to help!<br /><br />

                Once again, welcome to TeleDoc. We’re excited to have you on board!<br /><br />

                Best regards,<br />
                The TeleDoc Team<br />
                Compliance Dept. | TeleDoc App<br /><br />
            ";

            $this->sendmail($email, $subject, $body);

            $this->session->set_flashdata('success_message', 'Doctor approved successfully');
            redirect('doctor/doctors/add_commission/' . encrypt($doctor_id));
        } else {
            $this->session->set_flashdata('error_message', 'Doctor not approved due to technical issue');
            redirect('doctor/doctors');
        }
    } else {
        $this->session->set_flashdata('error_message', 'Something Went Wrong. Please try again later');
        redirect('doctor/doctors');
    }
}

    public function add_commission()
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'commission';       
        $user_id = $this->uri->segment(4);
        $data['active_url'] =  'doctor/add_commission/'.$user_id;
        $user_id = decrypt($user_id);

        $data['doctor'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
        //prx($data);
         $this->load->view('template',$data);
    }


   public function rewardDoctor() {
    $reward_amount = $this->input->post('reward_amount');
    $doctor_id = $this->input->post('doctor_id');

    if (empty($reward_amount) || empty($doctor_id)) {
        echo json_encode(['status' => false, 'message' => 'Invalid input data.']);
        return;
    }

    $insertwallet = array(
        'user_id' => $doctor_id,
        'amount' => $reward_amount,
        'type' => 'deposite',
        'status' => '1',
         'added_by' => 'admin',
        'created_at' => date('Y-m-d h:i:s')
    );
    //prx($insertwallet);
    // Ensure the model is loaded

    $inserted_wallet = $this->doctors_model->insertwallet($insertwallet);
    
    if ($inserted_wallet) {
        echo json_encode(['status' => true, 'message' => 'Reward added successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to add reward']);
    }
}
   public function deductDoctor() {
    $deduct_amount = $this->input->post('deduct_amount');
    $doctor_id = $this->input->post('doctor_id');

    if (empty($deduct_amount) || empty($doctor_id)) {
        echo json_encode(['status' => false, 'message' => 'Invalid input data.']);
        return;
    }

    $insertwallet = array(
        'user_id' => $doctor_id,
        'amount' => $deduct_amount,
        'type' => 'withdraw',
        'status' => '1',
         'added_by' => 'admin',
        'created_at' => date('Y-m-d h:i:s')
    );
    //prx($insertwallet);
    // Ensure the model is loaded

    $inserted_wallet = $this->doctors_model->insertwallet($insertwallet);
    
    if ($inserted_wallet) {
        echo json_encode(['status' => true, 'message' => 'amount deducted successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to deduct amount']);
    }
}
    public function savecommission()
    {
        $online_com = $this->input->post('online_commission');
        $home_com = $this->input->post('home_commission');
        $clinic_com = $this->input->post('clinic_commission');
        $doctor_id = decrypt($this->input->post('doctor_id'));
        if(!empty($online_com) && $online_com == 0)
        {
             $this->session->set_flashdata('error_message', 'Online Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        elseif (!empty($home_com) && $home_com == 0) {
            $this->session->set_flashdata('error_message', 'Home Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        elseif (!empty($clinic_com) && $clinic_com == 0) {
            $this->session->set_flashdata('error_message', 'Clinic Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        else
        {
            $update = array('online_commission'=>$online_com,'clinic_commission'=>$clinic_com,'home_commission'=>$home_com);
            $updated_id = $this->doctors_model->savefees($update,$doctor_id);
            if($updated_id > 0)
            {
                 $this->session->set_flashdata('success_message', 'Admin commission added successfully');
                    redirect('doctor/doctors');
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Commission not added please try again later');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
            }
        }
    }

    public function clinic($user_id)
    {
       
        $data['title'] = 'Doctors Clinic';
        $data['page'] =  'clinic_list';
        $data['active_url'] =  'doctor/clinic';
        $data['datatable'] = true;
        $data['doctor_id'] = $user_id;
        $data['data'] = $this->doctors_model->get_doctor_clinic(array('doctor_id'=>$user_id));
        $this->load->view('template',$data);
    }

    public function create_clinic($user_id)
    {
        $doctor_id = decrypt($this->uri->segment(4));
        $data['title'] = 'Doctors Clinic';
        $data['page'] =  'create_clinics';
        $data['active_url'] =  'doctor/clinic/create_clinic/'.encrypt($doctor_id);
        $data['datatable'] = true;
         $data['doctor_id'] = $user_id;

        // prx($data);
        $this->load->view('template',$data);
    }

    public function getspeciality()
    {
         $service = $this->input->post('service');

         $cat_id = isset($service)&& !empty($service) ? $service : '';
        $productsubCatg = $this->doctors_model->getspecialities(array('category_id'=>$cat_id,'is_active'=>1));
      
        foreach($productsubCatg as $key =>$val){
            echo "<option value='".$val->id."'>".$val->name."</option>";
        }
    }

    public function userEmail_exist() {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */
        $param = array('email'=>(string) AesCipher::encrypt($this->input->post('email')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            echo "false";
        }
        else {
            echo "true";
        }

    }
    public function userPhone_exist() {

        $param = array('mobile_no'=>(string) AesCipher::encrypt($this->input->post('phone_no')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            echo "false";
        }
        else {
            echo "true";
        }

    }

    public function rejectDoctor() {

        $requiredData['doctor_id']= $this->security->xss_clean($this->input->post('doctor_id'));
        $requiredData['reject_reason']= $this->security->xss_clean($this->input->post('reject_reason'));
        foreach ($requiredData as $key => $val) {
              if (trim($val) == '') {
                  $message = 'Please Specify ' . ucwords(str_replace("_", " ", $key));
                  $this->session->set_flashdata('error_message', $message);
                  redirect('doctor/doctors');
                  exit();
              }
          }

        $err = 0;
        $errType = 'success_message';
        
            $updateData = array();
            $updateData['admin_approve'] = 2;
            $updateData['reject_reason'] = $requiredData['reject_reason'];
            $update = $this->doctors_model->updateuser($updateData,$requiredData['doctor_id']);
            if($update)
            {
                $err = 0;
                $message = 'Account rejected';
                $errType = 'success_message';
                $this->sendNotification($requiredData['doctor_id'],$message,'Your Account has been rejected by Admin');
            }
            else
            {
                $err = 1;
                $message = 'error in reject doctor account';
                $errType = 'error_message';
            }

        $this->session->set_flashdata($errType, $message);
        redirect('doctor/doctors');
        
    }

    public function sendNotification($doctor_id,$title,$description)
    {
        $user = $this->doctors_model->getuserdetails(array('user_id'=>$doctor_id));

        if(!empty($user))
        {
            $insert_notification = array('doctor_id'=>$doctor_id,'title'=>$title,'description'=>$description,'create_by'=>$this->session->userdata('user_id'),'create_date'=>date('Y-m-d h:i:s'),'status'=>'active','is_view'=>0,'url'=>base_url('my-account'));
                $data = array('doctor_id'=>$doctor_id);
                $inserted_id = $this->doctors_model->addnotifications($insert_notification);
                $user_fcm = $user[0]->fcm_token;
            if($user[0]->device_type == 'android')
            {                    
                $tok = androidnotification($user_fcm,$title,$description,"account_reject",$data);
            }
            elseif($user[0]->device_type == 'ios')
            {
                $tok = iosNotification($user_fcm,$title,$description,"account_reject",$data);
            }
            else
            {
                $tok = sendwebPushNotification($user_fcm, $title, $description, $id = null,$icon = null);
            }
        }
    }



    public function deleteDoctor(){
        $user_id=$_POST['user_id'];
        // prx($user_id);
        $delete=$this->doctors_model->delete_doctor($user_id);
        if($delete)
        {
           $output['status']=true;
           $output['message']="Deleted Successfully";
        }
        else
        {
           $output['status']=false;
           $output['message']="Something went wrong";
        }
        echo json_encode($output);
    }


public function getAvailableSlotsCount($doctor_id, $service)
{
   

    $timezone = 'Africa/Lagos';
    date_default_timezone_set($timezone);

    $date = new DateTime('now', new DateTimeZone('UTC'));
    $current_date = $date->format('Y-m-d'); // Current date in UTC
    $from_date = new DateTime($current_date, new DateTimeZone('UTC')); // Start of today in UTC
    $to_date = new DateTime($current_date, new DateTimeZone('UTC'));   // End of today in UTC

    $totalAvailable = 0;

    $dd = $from_date->format('Y-m-d');
    $day = ucwords(date('l', strtotime($dd)));
    $where = array('doctor_id' => $doctor_id, 'day' => $day);
    $time = $this->booking_model->gettimeslot($where);
    $booking = $this->booking_model->getbookingdetails(array('doctor_id' => $doctor_id, 'booking_date' => $dd));

    $booked_slot = [];
    foreach ($booking as $key) {
        list($start_time_str, $end_time_str) = explode(' - ', $key->time_slot);
        $start_time_utc = new DateTime($start_time_str, new DateTimeZone('UTC'));
        $end_time_utc = new DateTime($end_time_str, new DateTimeZone('UTC'));
        $start_time_utc->setTimezone(new DateTimeZone($timezone));
        $end_time_utc->setTimezone(new DateTimeZone($timezone));
        $converted_slot = $start_time_utc->format('h:i a') . ' - ' . $end_time_utc->format('h:i a');
        $booked_slot[] = $converted_slot;
    }

    $morningslots = [];
    $eveningslots = [];
    foreach ($time as $key) {
        if ($key->patient_time != 0) {
            if ($key->start_time != '00:00:00') {
                $slot_time = (int)$key->patient_time;
                $morningslots[] = getTimeSlot($service, $slot_time, $key->start_time, $key->end_time, 'UTC', $doctor_id);
            }
            if ($key->evening_start_time != '00:00:00') {
                $slot_time1 = (int)$key->patient_time;
                $eveningslots[] = getTimeSlot($service, $slot_time1, $key->evening_start_time, $key->evening_end_time, 'UTC', $doctor_id);
            }
        }
    }

    // Check available slots for morning and evening
    foreach ($morningslots as $key => $value) {
        foreach ($value as $key1) {
            $unbooked = date("H:i", strtotime($key1['end']));
            if (strtotime($unbooked) - time() > 0) {
                $testtime = date('h:i a', strtotime($key1['start'])) . ' - ' . date('h:i a', strtotime($key1['end']));
                if (!in_array($testtime, $booked_slot)) {
                    $totalAvailable++;
                }
            }
        }
    }

    foreach ($eveningslots as $key => $value) {
        foreach ($value as $key1) {
            $unbooked = date("H:i", strtotime($key1['end']));
            if (strtotime($unbooked) - time() > 0) {
                $testtime = date('h:i a', strtotime($key1['start'])) . ' - ' . date('h:i a', strtotime($key1['end']));
                if (!in_array($testtime, $booked_slot)) {
                    $totalAvailable++;
                }
            }
        }
    }

    return $totalAvailable;
}



/* public function online_time_slot($user_id)
    {

        $data['title'] = 'Create Doctor Online Time Slot';
        $data['page'] =  'online_slots';
        $data['active_url'] =  'doctor/doctors';
        $data['user_id'] = $user_id;
        $this->load->view('template', $data);
    }*/


public function online_time_slot($user_id){
   
    $sess_data = $this->doctor_model->getuserdetails(array('user_id'=>$user_id));


    $getdoctortimezone = $this->doctor_model->getdoctorprofile(array('doctor_id'=>$user_id));
   
    $timezone='Africa/Lagos';
    $clinic_id = null;
    $time = $this->doctor_model->getdoctorslot(array('d.doctor_id' => $user_id, 'd.service' => 'online'));

    $newTime = [];
    $dys = [];
    $days = array('0' => 'Monday', '1' => 'Tuesday', '2' => 'Wednesday', '3' => 'Thursday', '4' => 'Friday', '5' => 'Saturday', '6' => 'Sunday');

    // Get user's timezone
    $userTimezone = new DateTimeZone($timezone);

    if (!empty($time)) {
        $data['patient_time'] = $time[0]->patient_time;

        foreach ($time as $key) {
            $new_key = array_search($key->day, $days);
            $dys[] = $new_key;

            // Convert UTC to user's timezone
            $start_time = new DateTime($key->start_time, new DateTimeZone('UTC'));
            $start_time->setTimezone($userTimezone);

            $end_time = new DateTime($key->end_time, new DateTimeZone('UTC'));
            $end_time->setTimezone($userTimezone);

            $evening_start_time = new DateTime($key->evening_start_time, new DateTimeZone('UTC'));
            $evening_start_time->setTimezone($userTimezone);

            $evening_end_time = new DateTime($key->evening_end_time, new DateTimeZone('UTC'));
            $evening_end_time->setTimezone($userTimezone);

            $newTime[$key->day] = array(
                'clinic_id' => $key->clinic_id,
                'day' => $new_key,
                'start_time' => $start_time->format('H:i'),
                'end_time' => $end_time->format('H:i'),
                'evening_start_time' => $evening_start_time->format('H:i'),
                'evening_end_time' => $evening_end_time->format('H:i')
            );
        }
    }

    $newTime1 = [];
    foreach ($days as $key => $value) {
        if (!array_key_exists($value, $newTime)) {
            $newTime1[$value] = array('clinic_id' => '', 'day' => $key, 'start_time' => '', 'end_time' => '', 'evening_start_time' => '', 'evening_end_time' => '');
        }
    }

    $new_array = array_merge($newTime, $newTime1);
    $newTime2 = [];
    foreach ($new_array as $key => $value) {
        $new_key1 = array_search($value['day'], $days);
        $newTime2[$value['day']] = array('day' => $value['day'], 'start_time' => $value['start_time'], 'end_time' => $value['end_time'], 'evening_start_time' => $value['evening_start_time'], 'evening_end_time' => $value['evening_end_time']);
    }
  
            $newt = asort($newTime2);
            $data['time'] = $newTime2;
            $data['title'] = 'Edit Online Time Slot';
            $data['dys'] = $dys;
        $data['page'] =  'online_slots';
        $data['active_url'] =  'doctor/doctors';
        $data['user_id'] = $user_id;
         //prx($data);
        $this->load->view('template', $data);
    
}



   public function onlineupdate($user_id){

    //$sess_data = $this->session->userdata('doctorsession');
    $getdoctortimezone = $this->doctor_model->getdoctorprofile(array('doctor_id'=>$user_id));
    $timezone='Africa/Lagos';
    $dayss = array('0' => 'Monday', '1' => 'Tuesday', '2' => 'Wednesday', '3' => 'Thursday', '4' => 'Friday', '5' => 'Saturday', '6' => 'Sunday');
    $post = $this->input->post();

    //prx($post);
    $insert_time = [];
    $time_id = [];

    // User's time zone
    $user_time_zone = new DateTimeZone($timezone); // Set your user's time zone here
    $utc_time_zone = new DateTimeZone('UTC');

    if ($post['patient_allowed'] != 0 && count($post['day']) != 0) {
        $deleted_id[] = $this->doctor_model->deleteclinictimeslot(array('doctor_id' => $user_id, 'service' => 'online'));
        $isExist = $this->doctor_model->getexisttime(array('doctor_id' =>$user_id, 'service' => 'online'));
       
            for ($i = 0; $i < count($post['day']); $i++) {
                $dsname = '';
                $dname = $post['day'][$i];
                $morning_start_time = $post[$dname . '_morning_from'];
                $morning_end_time = $post[$dname . '_morning_to'];
                $evening_start_time = $post[$dname . '_evening_from'];
                $evening_end_time = $post[$dname . '_evening_to'];
                foreach ($dayss as $key => $value) {
                    if ($key == $dname) {
                        $dsname = $value;
                    }
                }
                if ($morning_start_time != '' && $morning_end_time != '' || $evening_start_time != '' && $evening_end_time != '') {
                    $isExist1 = $this->doctor_model->getexisttime(array('doctor_id' => $user_id, 'day' => $dsname, 'start_time' => $morning_start_time, 'end_time' => $morning_end_time, 'evening_start_time' => $evening_start_time, 'evening_end_time' => $evening_end_time, 'service !=' => 'online'));
                    if (empty($isExist1)) {
                        // Convert user's local time to UTC
                        $start_time_utc = new DateTime($morning_start_time, $user_time_zone);
                        $start_time_utc->setTimezone($utc_time_zone);
                        $start_time_utc = $start_time_utc->format('Y-m-d H:i:s');

                        $end_time_utc = new DateTime($morning_end_time, $user_time_zone);
                        $end_time_utc->setTimezone($utc_time_zone);
                        $end_time_utc = $end_time_utc->format('Y-m-d H:i:s');

                        $evening_start_time_utc = new DateTime($evening_start_time, $user_time_zone);
                        $evening_start_time_utc->setTimezone($utc_time_zone);
                        $evening_start_time_utc = $evening_start_time_utc->format('Y-m-d H:i:s');

                        $evening_end_time_utc = new DateTime($evening_end_time, $user_time_zone);
                        $evening_end_time_utc->setTimezone($utc_time_zone);
                        $evening_end_time_utc = $evening_end_time_utc->format('Y-m-d H:i:s');

                        $insert_time[] = array('doctor_id' => $user_id, 'day' => $dsname, 'start_time' => $start_time_utc, 'end_time' => $end_time_utc, 'evening_start_time' => $evening_start_time_utc, 'evening_end_time' => $evening_end_time_utc, 'created_time' => date('Y-m-d h:i:s'), 'created_by' => 1001800000, 'service' => 'online', 'patient_time' => $post['patient_allowed']);
                    } else {
                        $this->session->set_flashdata('error', 'This time slot already exists.');
                        redirect('doctor/doctors/online_time_slot/'.$user_id);
                    }
                }
            }
            $time_id[] = $this->doctor_model->inserttimeslots($insert_time);
            //prx($time_id);

        if (count($time_id) > 0) {

            $this->session->set_flashdata('success_message', 'Online Time Slot created successfully');
            redirect('doctor/doctors');
        } else {
            prx('ppp');
            $this->session->set_flashdata('error', 'Time Slot not created. Please try again later');
            redirect('doctor/doctors/online_time_slot/'.$user_id);
        }
    } else {
       
        $this->session->set_flashdata('error', 'Please fill all required fields');
        redirect('doctor/doctors/online_time_slot/'.$user_id);
    }
}




public function saveclinic($user_id)
    {
       //prx('doctor/doctors/clinic/'.$user_id);
        $post = $this->input->post();
        $time_id = [];

         //$sess_data = $this->session->userdata('doctorsession');

        if(!empty($post['clinic_name']) && !empty($post['address']))
        { 
            $insert = array('doctor_id'=>$user_id,'name'=>(string)AesCipher::encrypt($post['clinic_name']),'address'=>(string)AesCipher::encrypt($post['address']),'latitude'=>$post['address_latitude'],'longitude'=>$post['address_longitude'],'admin_status'=>$post['status'],'status'=>'active');
            $clinic_id = $this->doctor_model->inertclinic($insert);
           
             if($clinic_id > 0)
             {
                $this->session->set_flashdata('success_message','clinic saved successfully');
                redirect('doctor/doctors/clinic/'.$user_id);
             } 
             else
             {
                 $this->session->set_flashdata('error','Clinic not saved due to an error.Please try again later');
                  redirect('doctor/doctors/clinic/'.$user_id);
             }
        }
        else
        { 
            $this->session->set_flashdata('error','Please fill all required fields');
            redirect('doctor/doctors/clinic/'.$user_id);
        }
        
       
    }



      public function edit_clinic($clinic_id)
    {
        
        
  
        $data['title'] = 'Doctors Clinic';
        $data['page'] =  'edit_clinics';
        $data['active_url'] =  'doctor/clinic/edit_clinic/'.$clinic_id;
        $data['clinic'] = $this->doctors_model->getclinics(array('id'=>$clinic_id));
        $data['datatable'] = true;

        // prx($data);
        $this->load->view('template',$data);
    }

    public function updateclinic()
{
    $post = $this->input->post(); // Retrieve form data
 

    // Validate required fields
    if (!empty($post['clinic_name']) && !empty($post['address']) && !empty($post['clinic_id'])) {
        // Prepare the data array
        $insert = [
            'name' => AesCipher::encrypt($post['clinic_name']),
            'address' => AesCipher::encrypt($post['address']),
            'latitude' => $post['address_latitude'],
            'longitude' => $post['address_longitude'],
            'admin_status' => 'active',
            'status' => 'active'
        ];

        // Call the model's updateclinic method
        $clinic_id = $this->doctors_model->updateclinic($insert, $post['clinic_id']);

        // Check if the update was successful
        if ($clinic_id) {
            $this->session->set_flashdata('success_message', 'Clinic updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Clinic not updated due to an error. Please try again later.');
        }
    } else {
        // Handle validation error
        $this->session->set_flashdata('error', 'Please fill all required fields.');
    }

    // Redirect to the clinic list page
    redirect('doctor/doctors/clinic/' . $post['doctor_id']);
}

    public function delete($clinic_id,$doctor_id)
    {
        
        $data['title'] = 'Doctor Clinics';
        $clinic_id = $clinic_id;
        $doctor_id = $doctor_id;
        $delete_clinic = $this->doctors_model->deleteclinic(array('id'=>$clinic_id));
        //$delete_time = $this->doctors_model->deleteclinictime(array('clinic_id'=>$clinic_id));
        if($delete_clinic > 0 || $delete_time > 0)
        {
            $this->session->set_flashdata('success_message','Clinic Deleted successfully');
             redirect('doctor/doctors/clinic/'.$doctor_id);
        }
        else
        {
              $this->session->set_flashdata('error','Clinic not Deleted');
                redirect('doctor/doctors/clinic/'.$doctor_id);
        }
    }


     public function add_timeslot($clinic_id,$doctor_id)
    {
        
     
       
        $getdoctortimezone = $this->doctor_model->getdoctorprofile(array('doctor_id'=>$doctor_id));
        $timezone = 'Africa/Lagos';
        $clinic_id = $clinic_id;
        $data['clinics'] = $this->doctor_model->getdoctorclinic(array('c.id'=>$clinic_id));      
        $time = $this->doctor_model->getdoctorslot(array('c.id'=>$clinic_id));

        $newTime = [];
        $dys = [];
        $days = array('0'=>'Monday','1'=>'Tuesday','2'=>'Wednesday','3'=>'Thursday','4'=>'Friday','5'=>'Saturday','6'=>'Sunday');
        foreach($time as $key)
        {
            $new_key = array_search($key->day, $days);
            $dys[] = $new_key;
            $start_time = new DateTime($key->start_time, new DateTimeZone('UTC'));
            $start_time->setTimezone(new DateTimeZone($timezone));

            $end_time = new DateTime($key->end_time, new DateTimeZone('UTC'));
            $end_time->setTimezone(new DateTimeZone($timezone));

            $evening_start_time = new DateTime($key->evening_start_time, new DateTimeZone('UTC'));
            $evening_start_time->setTimezone(new DateTimeZone($timezone));

            $evening_end_time = new DateTime($key->evening_end_time, new DateTimeZone('UTC'));
            $evening_end_time->setTimezone(new DateTimeZone($timezone));

            $newTime[$key->day] = array(
                'clinic_id' => $key->clinic_id,
                'day' => $new_key,
                'start_time' => $start_time->format('H:i'),
                'end_time' => $end_time->format('H:i'),
                'evening_start_time' => $evening_start_time->format('H:i'),
                'evening_end_time' => $evening_end_time->format('H:i')
            );
        }

        $newTime1 = [];
        foreach($days as $key => $value)
        {
            if(!array_key_exists($value, $newTime))
            {
                $newTime1[$value] =  array('clinic_id'=>'','day'=>$key,'start_time'=>'','end_time'=>'','evening_start_time'=>'','evening_end_time'=>''); 
            }
        }

        $new_array = array_merge($newTime,$newTime1);     
        $newTime2 = [];
        foreach($new_array as $key =>$value)
        {
            $new_key1 = array_search($value['day'], $days);
            $newTime2[$value['day']] = array('day'=>$value['day'],'start_time'=>$value['start_time'],'end_time'=>$value['end_time'],'evening_start_time'=>$value['evening_start_time'],'evening_end_time'=>$value['evening_end_time']); 
        }

        asort($newTime2);
        $data['time'] = $newTime2; 
        $data['title'] = 'Edit Clinic Time Slot';   
        $data['dys'] = $dys;
        $data['clinic_id'] = $clinic_id;
        $data['doctor_id'] = $doctor_id;
        $data['page'] =  'clinic_slots';
        $data['active_url'] =  'doctor/doctors/edit_clinic/'.$clinic_id;


       $this->load->view('template',$data);
    }


    public function update_clinic_slots(){
    // Check doctor login
        

        // Get the user's session data
        $sess_data = $this->session->userdata('doctorsession');
        $getdoctortimezone = $this->doctor_model->getdoctorprofile(array('doctor_id'=>$post['doctor_id']));
        $timezone ='Africa/Lagos';
        $dayss = array('0' => 'Monday', '1' => 'Tuesday', '2' => 'Wednesday', '3' => 'Thursday', '4' => 'Friday', '5' => 'Saturday', '6' => 'Sunday');
        $post = $this->input->post();
        $insert_time = [];
        $time_id = [];

        if ($post['clinic_id'] != '' && count($post['day']) != 0 ) {
            $user_time_zone = new DateTimeZone($timezone); // Set your user's time zone here
            $deleted_id[] = $this->doctor_model->deleteclinictimeslot(array('clinic_id' => $post['clinic_id']));
            $isExist = $this->doctor_model->getexisttime(array('doctor_id' => $post['doctor_id'], 'clinic_id' => $post['clinic_id']));
         
                foreach ($post['day'] as $dname) {
                    $dsname = '';
                    $morning_start_time = new DateTime($post[$dname.'_morning_from'], $user_time_zone);
                    $morning_end_time = new DateTime($post[$dname.'_morning_to'], $user_time_zone);
                    $evening_start_time = new DateTime($post[$dname.'_evening_from'], $user_time_zone);
                    $evening_end_time = new DateTime($post[$dname.'_evening_to'], $user_time_zone);
                    foreach ($dayss as $key => $value) {
                        if ($key == $dname) {
                            $dsname = $value;
                        }
                    }
                    $isExist1 = $this->doctor_model->getexisttime(array('doctor_id' => $post['doctor_id'], 'clinic_id' => $post['clinic_id'], 'day' => $dsname, 'start_time' => $morning_start_time->format('Y-m-d H:i:s'), 'end_time' => $morning_end_time->format('Y-m-d H:i:s'), 'evening_start_time' => $evening_start_time->format('Y-m-d H:i:s'), 'evening_end_time' => $evening_end_time->format('Y-m-d H:i:s')));
                    if (empty($isExist1)) {
                        $morning_start_time->setTimezone(new DateTimeZone('UTC'));
                        $morning_end_time->setTimezone(new DateTimeZone('UTC'));
                        $evening_start_time->setTimezone(new DateTimeZone('UTC'));
                        $evening_end_time->setTimezone(new DateTimeZone('UTC'));
                        $isExist3 = $this->doctor_model->getexisttime(array('doctor_id' => $post['doctor_id'],'clinic_id' => $post['clinic_id'], 'day' => $dsname, 'start_time' => $morning_start_time->format('Y-m-d H:i:s'), 'end_time' => $morning_end_time->format('Y-m-d H:i:s'), 'evening_start_time' => $evening_start_time->format('Y-m-d H:i:s'), 'evening_end_time' => $evening_end_time->format('Y-m-d H:i:s')));
                        if (empty($isExist3)) {
                            $insert_time[] = array(
                                'doctor_id' => $post['doctor_id'],
                                'clinic_id' => $post['clinic_id'],
                                'day' => $dsname,
                                'start_time' => $morning_start_time->format('Y-m-d H:i:s'),
                                'end_time' => $morning_end_time->format('Y-m-d H:i:s'),
                                'evening_start_time' => $evening_start_time->format('Y-m-d H:i:s'),
                                'evening_end_time' => $evening_end_time->format('Y-m-d H:i:s'),
                                'created_time' => date('Y-m-d h:i:s'),
                                'created_by' => 1001800000,
                                'maximum_visitor' => $post['patient_allowed'],
                                'service' => 'clinic',
                                'evening_maximum_visitor' => $post['eve_patient_allowed']
                            );
                        } else {
                            $this->session->set_flashdata('error' ,'This clinic time slot already exist');
                            redirect('doctor/doctors/add_timeslot/'.$post['clinic_id'].'/'.$post['doctor_id']);
                        }
                    } else {
                        $this->session->set_flashdata('error' ,'This clinic time slot already exist');
                      redirect('doctor/doctors/add_timeslot/'.$post['clinic_id'].'/'.$post['doctor_id']);
                    }
                }
                $time_id[] = $this->doctor_model->inserttimeslots($insert_time);
            
            
            if (count($time_id) > 0) {
                $this->session->set_flashdata('success_message', 'Time Slot updated successfully');
               redirect('doctor/doctors/clinic/'.$post['doctor_id']);
            } else {
                $this->session->set_flashdata('error', 'Time Slot not updated. Please try again later');
                redirect('doctor/doctors/add_timeslot/'.$post['clinic_id'].'/'.$post['doctor_id']);
            }
        } else {
            $this->session->set_flashdata('error_message', 'Please fill all required fields');
           redirect('doctor/doctors/add_timeslot/'.$post['clinic_id'].'/'.$post['doctor_id']);
        }
    }


    public function profile_link() {
    $doctor_id = $this->uri->segment(4);

    // Ensure that the doctor_id is valid (numeric and not empty)
    if (empty($doctor_id) || !is_numeric($doctor_id)) {
        // Optionally, add an error message for invalid doctor_id
        $this->session->set_flashdata('error_message', 'Invalid doctor ID');
        redirect('doctor/doctors/list'); // Redirect to the doctor list or another relevant page
    }

    // Generate a 10-character random string
    $random_string = bin2hex(random_bytes(5));

    // Generate the unique profile link
    $base_url = base_url('doctor/profile/');
    $unique_link = $base_url . $doctor_id . '/' . $random_string;

    // Prepare data to update the doctor's profile link
    $doctor_data['profile_link'] = $unique_link;

    // Update the doctor's profile link
    $update_status = $this->doctors_model->updatedoctorstatus($doctor_data, $doctor_id);

    // Check if the update was successful
    if ($update_status > 0) {
        // Successfully updated the profile link
        $this->session->set_flashdata('success_message', 'Profile link created successfully.');
    } else {
        // If the update failed, show an error message
        $this->session->set_flashdata('error_message', 'Failed to create profile link.');
    }

    // Redirect to the doctor's profile view page
    redirect('doctor/doctors/view/' . encrypt($doctor_id));
}

/*public function export_doctors()
{
    // Load the model to fetch doctor data
    $this->load->model('Doctor_model');

    // Fetch doctor data
    $doctors = $this->doctors_model->get_doctors();

    // File name for download (Optional: define a filename)
    $filename = 'doctor_list_' . date('Ymd') . '.csv';

    // Loop through doctor data
    foreach ($doctors as $doctor) {
        $documents = $this->doctors_model->get_doctors(array('u.user_id' => $doctor->user_id));

        // Fetch withdraw and deposit balances for the doctor
        $withdrawBalance = $this->doctors_model->totalwithdrawbal(['user_id' => $doctor->user_id, 'type' => 'withdraw']);
        $withdrawAmount = !empty($withdrawBalance) ? $withdrawBalance[0]->amount : 0;

        // Get the deposit balance
        $depositBalance = $this->doctors_model->totalwithdrawbal(['user_id' => $doctor->user_id, 'type' => 'deposite']);
        $depositAmount = !empty($depositBalance) ? $depositBalance[0]->amount : 0;

        // Calculate the new balance (Deposit - Withdraw)
        $newBalance = $depositAmount - $withdrawAmount;
        $doctor->new_balance = $newBalance;  // Assign new balance

        // Assuming $documents is available to check document status
        $education = isset($documents[0]->education) ? $documents[0]->education : '';
        $educationQualification = isset($documents[0]->education_qualification) ? $documents[0]->education_qualification : '';
        $medicalLicense = isset($documents[0]->medical_license) ? $documents[0]->medical_license : '';

        // Set document upload status
        $doctor->is_document_uploaded = (!empty($educationQualification) && !empty($medicalLicense) && !empty($education)) ? 'Yes' : 'No';

        // Check if commission is added for the doctor
        $online_commission = isset($documents[0]->online_commission) ? $documents[0]->online_commission : '';
        $clinic_commission = isset($documents[0]->clinic_commission) ? $documents[0]->clinic_commission : '';
        $home_commission = isset($documents[0]->home_commission) ? $documents[0]->home_commission : '';

        // Determine whether clinic and online options are selected
        $doctor->is_clinic_selected = $documents[0]->is_clinic != 0 ? 'Yes' : 'No';
        $doctor->is_online_selected = $documents[0]->is_chat != 0 || $documents[0]->is_video != 0 ? 'Yes' : 'No';
        
        // Set commission added status
        $doctor->is_commission_added = (!empty($online_commission) && !empty($clinic_commission) && !empty($home_commission)) ? 'Yes' : 'No';

        // Decrypt the values before adding to CSV
            $firstName = isset($doctor->first_name) ? $doctor->first_name : null;
            $mobileNo = isset($doctor->mobile_no) ? $doctor->mobile_no : null;
            $email = isset($doctor->email) ? $doctor->email : null;
            $registrationNo = isset($doctor->registeration_no) ? $doctor->registeration_no : null;

        prx([
            'First Name' => isset($firstName) ? AesCipher::decrypt($firstName) ?? 'N/A' : 'N/A',
            'Mobile No' => isset($mobileNo) ? AesCipher::decrypt($mobileNo) : 'N/A',
            'Email' => isset($email) ? AesCipher::decrypt($email) : 'N/A',
            'Registration No' => isset($registrationNo) ? AesCipher::decrypt($registrationNo) : 'N/A',
        ]);

        // You can also directly continue writing the doctor data to CSV here after debugging if needed
    }
}
*/






public function export_doctors()
{
    // Load the model to fetch doctor data
    $this->load->model('Doctor_model');

    // Fetch doctor data
    $doctors = $this->doctors_model->get_doctors(array('u.user_type' => 2));
    //prx($doctors);
    // File name for download
    $filename = 'doctor_list_' . date('Ymd') . '.csv';

    // Set headers for download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV header row
    fputcsv($output, [
        'Doctor ID', 'Name', 'Mobile', 'Email', 'RCC Number', 'Wallet','Approval Status', 'Online Slot', 'Document Uploaded', 'Commission Added'
    ]);
       
    // Loop through doctor data and write to CSV
    foreach ($doctors as $doctor) {
        $documents = $this->doctors_model->get_doctors(array('u.user_id' => $doctor->user_id));

        // Fetch withdraw and deposit balances for the doctor
        $withdrawBalance = $this->doctors_model->totalwithdrawbal(['user_id' => $doctor->user_id, 'type' => 'withdraw']);
        $withdrawAmount = !empty($withdrawBalance) ? $withdrawBalance[0]->amount : 0;

        // Get the deposit balance
        $depositBalance = $this->doctors_model->totalwithdrawbal(['user_id' => $doctor->user_id, 'type' => 'deposite']);
        $depositAmount = !empty($depositBalance) ? $depositBalance[0]->amount : 0;

        // Calculate the new balance (Deposit - Withdraw)
        $newBalance = $depositAmount - $withdrawAmount;
        $doctor->new_balance = $newBalance;  // Assign new balance

        // Assuming $documents is available to check document status
        $education = isset($documents[0]->education) ? $documents[0]->education : '';
        $educationQualification = isset($documents[0]->education_qualification) ? $documents[0]->education_qualification : '';
        $medicalLicense = isset($documents[0]->medical_license) ? $documents[0]->medical_license : '';

        // Set document upload status
        $doctor->is_document_uploaded = (!empty($educationQualification) && !empty($medicalLicense) && !empty($education)) ? 'Yes' : 'No';

        // Check if commission is added for the doctor
        $online_commission = isset($documents[0]->online_commission) ? $documents[0]->online_commission : '';
        $clinic_commission = isset($documents[0]->clinic_commission) ? $documents[0]->clinic_commission : '';
        $home_commission = isset($documents[0]->home_commission) ? $documents[0]->home_commission : '';

        // Determine whether clinic and online options are selected
        $doctor->is_clinic_selected = $documents[0]->is_clinic != 0 ? 'Yes' : 'No';
        $doctor->is_online_selected = $documents[0]->is_chat != 0 || $documents[0]->is_video != 0 ? 'Yes' : 'No';
        
        // Set commission added status
        $doctor->is_commission_added = (!empty($online_commission) && !empty($clinic_commission) && !empty($home_commission)) ? 'Yes' : 'No';

        // Decrypt the values before adding to CSV
        $firstName = isset($doctor->first_name) ? AesCipher::decrypt($doctor->first_name) : 'N/A';
        $mobileNo = isset($doctor->mobile_no) ? AesCipher::decrypt($doctor->mobile_no) : 'N/A';
        $email = isset($doctor->email) ? AesCipher::decrypt($doctor->email) : 'N/A';
        $registrationNo = isset($doctor->registeration_no) ? AesCipher::decrypt($doctor->registeration_no) : 'N/A';

        // Write doctor data to CSV
        fputcsv($output, [
            $doctor->doctor_id,
            $firstName,
            $mobileNo,
            $email,
            $registrationNo,
            $doctor->new_balance,  // New balance
            $doctor->admin_approve == 1 ? 'Approved' : 'Unapproved',
            $doctor->is_online_selected,
            $doctor->is_document_uploaded,
            $doctor->is_commission_added,
        ]);
    }

    // Close the output stream
    fclose($output);
    exit;
}

public function getWalletTransactions()
{
        $doctorId = $this->uri->segment(4);


    // Query to fetch the wallet transactions based on the doctor ID
   
    $transactions = $this->doctors_model->getTransactions($doctorId);

    if ($transactions) {
        $response = array('status' => 'success', 'data' => $transactions);
    } else {
        $response = array('status' => 'error', 'message' => 'No transactions found.');
    }

    
    echo json_encode($response);
}








}
