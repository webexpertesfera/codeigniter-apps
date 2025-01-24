<?php
class Doctors_model extends CI_Model {

    /*public function get_doctor() {

        $query = $this->db->select("hr_doctor.first_name AS full_name,hr_doctor.doctor_id,hr_doctor.id,hr_doctor.mobile_no,hr_doctor.created_by,hr_doctor.is_active,hr_doctor.created_time,hr_doctor.created_by_ip,hr_doctor.updated_time,hr_doctor.specialist,users.email,department.name as department_name,designation.name as designation_name", FALSE)
            ->join("hospital_department as department", "department.id=hr_doctor.hospital_department_id")
            ->join("hr_doctor_designation as designation", "designation.id=hr_doctor.doctor_designation_id")
            ->join("users", "users.user_id=hr_doctor.doctor_id")
            ->order_by("hr_doctor.id", "desc")
            ->get("hr_doctor");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }

    }*/
     public function getspecialities($where = array())
    {
        $this->db->select('*');
        $this->db->from('hr_doctor_designation');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function insertnotifications($insert_notification_data)
   {
    $this->db->insert('doctor_notifications',$insert_notification_data);
    return $this->db->insert_id();
   }

public function get_doctor() {   
       $this->db->select('u.id,u.user_id,d.id as doc_id,d.first_name,u.email,d.country_code,d.mobile_no,d.doctor_id,d.is_active,u.admin_approve,d.registeration_no,d.rcc_no');
        $this->db->from('hr_doctor as d');
       $this->db->join('users as u','d.doctor_id=u.user_id','left');      
       $this->db->where('u.user_type',2);
        $this->db->order_by('u.id','DESC');
       return $this->db->get()->result();
    }
   public function get_doctors($where = array()) {
    $this->db->select(
        'd.id AS doc_id,
        d.doctor_id,
        d.first_name,
        d.country_code,
        d.mobile_no,
        d.present_address,
        d.permanent_address,
        d.gender,
        d.ic_no,
        d.country,
        d.registeration_no,
        d.current_wokplace,
        d.language,
        d.profile_pic,
        d.ic_pic,
        d.education,
        d.birth_date,
        d.education_qualification,
        d.medical_license,
        d.about,
        d.clicnic_intrest,
        d.is_online,
        d.is_chat,
        d.is_video,
        d.is_home,
        d.is_clinic,
        d.clinic_fee,
        d.clinic_fllow_up,
        d.home_fee,
        d.home_follow_up,
        d.online_fee,
        d.online_extra,
        d.video_fee,
        d.video_first_time,
        d.chat_follow_up,
        d.chat_first_time,
        d.video_extra,
        d.video_follow_up,
        d.profile_link,
        u.id AS u_id,
        u.user_id,
        u.email,
        u.country_code,
        u.mobile_no,
        u.admin_approve,
        u.is_fees,
        u.timezone,
        d.online_first_time,
        d.online_follow_up,
        d.online_commission,
        d.clinic_commission,
        d.home_commission,
        d.hospital_department_id,
        d.latitude,
        d.longitude,
        d.appointment_description,
        d.rcc_no,
        b.bank_account_name,
        b.id,
        b.bank_name,
        b.account_number,
        b.ifsc_code'
    );
    $this->db->from('users as u');
    $this->db->join('hr_doctor as d', 'd.doctor_id = u.user_id', 'left');
    $this->db->join('doctor_bank_details as b', 'b.doctor_id = u.user_id', 'left');  // Join with the doctor_bank_details table
    $this->db->where($where);
     $this->db->order_by('u.id','DESC');


    return $this->db->get()->result();
}

    public function getspeciality($where = array())
    {
        $this->db->select('hdd.name,hdd.id');
        $this->db->from('doc_speciality as ds');
        $this->db->join('hr_doctor_designation as hdd','hdd.id = ds.spec_id','left');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function getcategory($where = array())
    {
        $this->db->select('hdd.name,hdd.id');
        $this->db->from('doc_services as ds');
        $this->db->join('category_service as hdd','hdd.id = ds.service_id','left');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    
    public function getcategories($where = array())
    {
        $this->db->select('name,id');
        $this->db->from('category_service');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    public function get_doctor_basic($data) {

        $query = $this->db->select("*")->where("doctor_id",$data['doctor_id'])
            ->get("hr_doctor");
        if($query->num_rows()>0) {
           return $query->row();
        }
        else {
            return [];
        }
    }
    public function updatedoctorinfo($update,$updated_id){ 
            //print_r($update);die;
            $this->db->trans_begin();
            $this->db->where('doctor_id',$updated_id);
            $this->db->update('hr_doctor',$update);
            if(isset($update['country']))
            {
              $this->db->where('user_id',$updated_id);
              $this->db->update('users',array('country'=>$update['country']));
            }
            //echo $this->db->last_query(); 
            if ($this->db->trans_status() === FALSE) {
                # Something went wrong.
                $this->db->trans_rollback();
                return 0;
            } 
            else {
                # Everything is Perfect. 
                # Committing data to the database.
                $this->db->trans_commit();
                return 1;
            }           
    }

    public function hospitaldepart($where = array())
    {
        $this->db->select('*');
        $this->db->from('category_service');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    public function getdocdesign($where = array())
    {
         $this->db->select('*');
        $this->db->from('hr_doctor_designation');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    public function create($patient_data,$user_data) {

         $this->db->insert("users",$user_data);
        $this->db->insert("hr_doctor",$patient_data);
      
        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'New Doctor Create Successfully'];
        }
        else {
          
            return ['status'=>'error','message'=>$error['message']];
        }
    }
    public function user_email_exist($data) {
       $this->db->select('*');
       $this->db->from('users');
       $this->db->where($data);       
       return $this->db->get()->result();
    }
   /* public function get_update_patient($id) {
        $query = $this->db->select("*")
            ->get_where("hr_doctor",['id'=>(int)$id]);
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }
    }*/
      public function insertdoctrcatg($insert)
    {
        $this->db->insert('doc_services',$insert);
        return $this->db->insert_id();
    }
    public function insertdocspeciality($insert)
    {
        
        $this->db->insert('doc_speciality',$insert);
        //return $this->db->last_query(); 
        return $this->db->affected_rows();
    }
     public function updatedocspeciality($insert,$doctor_id)
    {
        $this->db->where('doc_id', $doctor_id);
        $this->db->delete('doc_speciality');
        $this->db->insert('doc_speciality',$insert);
        //return $this->db->last_query(); 
        return $this->db->affected_rows();
    }
     public function inertclinic($insert)
    {
        $this->db->insert('clinic',$insert);
        return $this->db->insert_id();
    }
    public function inserttimeslot($insert)
    {
         $this->db->insert('doct_schedule',$insert);
        return $this->db->insert_id();
    }

    public function savefees($update,$update_id)
    {
        $this->db->where('doctor_id',$update_id);
        $this->db->update('hr_doctor',$update);
        return $this->db->affected_rows();
    }

    public function updateuser($update,$update_id)
    {
        $this->db->where('user_id',$update_id);
        $this->db->update('users',$update);
        return $this->db->affected_rows();
    }
     public function update($data) {

        $id = $data['id'];
        unset($data['id']);
        $this->db->update("hr_doctor",$data,['id'=>$id]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor Information Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function updatedoctors($update,$patient_data,$update_id)
    {
        $this->db->where('user_id',$update_id);
        $this->db->update('users',$update);
        $this->db->where('doctor_id',$update_id);
        $this->db->update('hr_doctor',$patient_data);
        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor Information Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

     public function updatedoctorsss($update,$update_id)
    {
        $this->db->where('user_id',$update_id);
        $this->db->update('users',$update);
        
        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor Information Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function getclinic($where = array())
    {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->db->select('c.*,d.day,d.start_time,d.end_time,d.evening_start_time,d.evening_end_time,d.clinic_id,d.maximum_visitor,d.evening_maximum_visitor,d.patient_time');
        $this->db->from('clinic as c');
        $this->db->join('doct_schedule as d','d.clinic_id = c.id','left');
        $this->db->where($where);
        //$this->db->group_by('d.clinic_id');
        return $this->db->get()->result();
    }
    public function getclinics($where = array())
    {
        
        $this->db->select('c.*');
        $this->db->from('clinic as c');
        $this->db->where($where);
        //$this->db->group_by('d.clinic_id');
        return $this->db->get()->result();
    }
    public function gettime($where = array())
    {
        $this->db->select('');
        $this->db->from('doct_schedule');
        $this->db->where($where);
        return $this->db->get()->result();
    }
     public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('hr_doctor');
        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor delete successfully'];
        }else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }
    public function delete_doctor($user_id) {
        $this->db->trans_start(); // Start transaction
        
        $this->db->where('doctor_id', $user_id);
        $this->db->delete('hr_doctor');
        $error_hr_doctor = $this->db->error();
        
        $this->db->where('user_id', $user_id);
        $this->db->delete('users');
        $this->db->where('doctor_id', $user_id);
        $this->db->delete('booking');

         $this->db->where('doctor_id', $user_id);
        $this->db->delete('pharmacy_prescriptions');

        $this->db->where('doc_id', $user_id);
        $this->db->delete('doc_speciality');
        
        $this->db->where('doctor_id', $user_id);
        $this->db->delete('doct_schedule');

        $this->db->where('doctor_id', $user_id);
        $this->db->delete('coupon_doctors');
        
        $this->db->where('doctor_id', $user_id);
        $this->db->delete('doctor_bank_details');

        $this->db->where('user_id', $user_id);
        $this->db->delete('user_login_session');

        $this->db->where('doctor_id', $user_id);
        $this->db->delete('doctor_notifications');

        $this->db->where('doctor_id', $user_id);
        $this->db->delete('doctor_review');
        
        $this->db->where('user_id', $user_id);
        $this->db->delete('wallets');
        $error_users = $this->db->error();
        
        if ($error_hr_doctor['code'] === 0 && $error_users['code'] === 0) {
            $this->db->trans_complete(); 
            return ['status' => 'success', 'message' => 'Doctor deleted successfully'];
        } else {
            $this->db->trans_rollback(); 
            return ['status' => 'error', 'message' => 'Error deleting doctor'];
        }
    }
    

    public function deletedoctorcatg($where = array())
    {
        $this->db->where($where);
        $this->db->delete('doc_services');
        return $this->db->affected_rows();
    }
     public function deletedoctorspeciality($where = array())
    {
        $this->db->where($where);
        $this->db->delete('doc_speciality');
        return $this->db->affected_rows();
    }

    public function deleteclinic($where = array())
    {   
        $this->db->where($where);
        $this->db->delete('clinic');
        return $this->db->affected_rows();
    }
    public function deletetimeslot($where = array())
    {
        $this->db->where($where);
        $this->db->delete('doct_schedule');
        return $this->db->affected_rows();
    }

    public function getdoctorschedule($where = array())
    {
        $this->db->select('*');
        $this->db->from('doct_schedule');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function insertnot($insert)
    {
        $this->db->insert('user_notifications',$insert);
        return $this->db->insert_id();
    }

    public function get_doctor_clinic($where = array())
    {
        $this->db->select('*');
        $this->db->from('clinic');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function updatedoctorstatus($update,$id)
    {
        $this->db->where('doctor_id',$id);
        $this->db->update('hr_doctor',$update);
        return $this->db->affected_rows();
    }

    public function getuserdetails($where = array())
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    
    public function addnotifications($insert)
    {
        $this->db->insert('doctor_notifications',$insert);
        return $this->db->insert_id();
    }

    public function getdoctorspecialitiesWithName($where){
      $this->db->select('s.*, hd.name as speciaility_name');
      $this->db->from('doc_speciality s');
      $this->db->join('hr_doctor_designation hd','hd.id = s.spec_id','left');
      $this->db->where($where);
      $query = $this->db->get();
      if($query && $query->num_rows() > 0){
        return $query->result();
      }
      return false;
    }

    public function getdoctorspecialities($where){
      $this->db->select('*');
      $this->db->from('doc_speciality');
      $this->db->where($where);
      $query = $this->db->get();
      if($query && $query->num_rows() > 0){
        return $query->result();
      }
      return false;
    }
      public function deletespeciality($where = array())
    {
        $this->db->where($where);
        $this->db->delete('doc_speciality');
        return $this->db->affected_rows();
    }

    public function updateDoctorSpecility($where, $data)
    {
        $this->db->where($where);
        $this->db->update('doc_speciality',$data);
        return $this->db->affected_rows();
    }

    public function getdoctorspecialitiesInString($where){
      $this->db->select('hd.name as speciaility_name');
      $this->db->from('doc_speciality s');
      $this->db->join('hr_doctor_designation hd','hd.id = s.spec_id','left');
      $this->db->where($where);
      $query = $this->db->get();
      if($query && $query->num_rows() > 0){
        $resultArr = $query->result_array();
        $specialityArr = array_column($resultArr, 'speciaility_name');
        return implode(', ', $specialityArr);
      }
      return '';
    }

    public function saveCVOH($post) {
        $user_id = decrypt($post['user_id']);

        $query = $this->db->select('*')
                          ->from('hr_doctor')
                          ->where('doctor_id', $user_id)          
                          ->get();
   
        if ($query->num_rows() > 0) {
            $data = array(
                'chat_first_time' => $post['chat_first_time'],
                'chat_follow_up' => $post['chat_follow_up'],
                'video_first_time' => $post['video_first_time'],
                'video_follow_up' => $post['video_follow_up'],
                'clinic_first_time' => $post['clinic_first_time'],
                'clinic_follow_up' => $post['clinic_follow_up']
            );
            
            $this->db->where('doctor_id', $user_id);
            $update = $this->db->update('hr_doctor', $data);
    
            // Check if the update was successful
            if ($this->db->affected_rows() > 0) {
                return 'Update successful';
            } else {
                return 'Update failed or no data changed';
            }
        } else {
            return NULL;  
        }
    }
    
    
public function getdoctoraccount($where = array())
      {
        $this->db->select('*');
        $this->db->from('doctor_bank_details');
        $this->db->where($where);
        return $this->db->get()->result();
      }


      public function insertwallet($insert)
      {
        $this->db->insert('wallets',$insert);
        //return $this->db->last_query(); 
        return $this->db->insert_id();
      }

    public function totalwithdrawbal($where = array()) {        
        $this->db->select('sum(amount) as amount');
        $this->db->from('wallets');
        $this->db->where($where);
        $query = $this->db->get();

        // Return the generated SQL query
       // echo $this->db->last_query();  // This will print the SQL query
        return $query->result();
    }



      public function totaldepositebal($user_id,$type) {        
       $this->db->select_sum('amount');
      $this->db->from('wallets');
      $this->db->where('user_id',$user_id);
      $this->db->where('type','deposite');
      $this->db->where('status','1');
        

      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row()->amount;
     }

         return 0;
    }



     public function getTransactions($user_id) {        
        $this->db->select('*');
        $this->db->from('wallets');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->order_by('created_at', 'DESC'); // Order by most recent
        // Debug the query
        $query = $this->db->get();
        return $query->result();


        }




      public function saveaccount($insert)
        {
            $this->db->insert('doctor_bank_details', $insert);
            $insert_id = $this->db->insert_id();
            $last_query = $this->db->last_query();

            return array('insert_id' => $insert_id, 'last_query' => $last_query);
        }


      public function updateaccount($update,$id)
      {
        $this->db->where('id',$id);
        $this->db->update('doctor_bank_details',$update);
        return $this->db->affected_rows();
      }

      public function updateclinic($data, $clinic_id){
            // Ensure the clinic ID is provided
            if (!$clinic_id) {
                return false; // Return false if clinic ID is not provided
            }

            // Update the clinic record where `id` matches the given `$clinic_id`
            $this->db->where('id', $clinic_id);
            $updated = $this->db->update('clinic', $data);

            // Return true if the update was successful, false otherwise
            return $updated;
        }


}