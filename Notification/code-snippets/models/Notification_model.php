<?php
class Notification_model extends CI_Model {

	public function getnotification($where = array())
	{
		$this->db->select('*');
		$this->db->from('admin_notification');
		$this->db->where($where);
		$this->db->order_by('id','DESC');
		return $this->db->get()->result();
	}

	public function getmessage($where = array())
	{
		$this->db->select('*');
		$this->db->from('admin_message');
		$this->db->where($where);
		$this->db->order_by('id','DESC');
		return $this->db->get()->result();
	}


	public function getuser($where = array())
	{
		$this->db->select('fcm_token,device_type,user_id,email');
		$this->db->from('users');
		$this->db->where($where);
		return $this->db->get()->result();
	}


	public function saveMessage($where = array())
	{
		$this->db->select('fcm_token,device_type,user_id');
		$this->db->from('users');
		$this->db->where($where);
		return $this->db->get()->result();
	}


	public function deletenotification($id)
	{
		$this->db->where_in('id',$id);
		$this->db->delete('admin_notification');
		return $this->db->affected_rows();
	}

	public function deleteMessage($id){
    // Adding a condition to delete the records with matching ids
    $this->db->where_in('id', $id);

    // Executing the delete query
    $this->db->delete('admin_message');

    // Returning the actual query executed
    $query = $this->db->last_query();

    // Returning the query along with the number of affected rows
    return [
        'affected_rows' => $this->db->affected_rows(),
        'query' => $query
    ];
}



	public function updateNotification($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('admin_notification',$data);
		return $this->db->affected_rows();
	}


	public function insertMessage($insert_notification_data){
	    $this->db->insert('admin_message',$insert_notification_data);

	    return $this->db->insert_id();
	}

	public function updateAllNotification($data)
	{
		$this->db->update('admin_notification',$data);
		return $this->db->affected_rows();
	}

	public function getAllPatients() {
    $cntry = $this->session->userdata('country');
    
    // Select fields with a gender case statement
    $this->db->select("
        pat_patient.first_name AS full_name, 
        pat_patient.*, 
        CASE 
            WHEN pat_patient.gender = 1 THEN 'Male' 
            WHEN pat_patient.gender = 2 THEN 'Female' 
            ELSE 'Other' 
        END as gender, 
        users.email, 
        users.fcm_token,
        users.device_type,
        users.user_id,
        users.is_insurance", FALSE)
        ->join("users", "users.user_id = pat_patient.patient_id", "left") // Consider using 'left' if not all patients have a matching user
        ->order_by("pat_patient.id", "desc");

    // Adding version conditions
    $this->db->where("(users.android_version >= 21 OR users.ios_version >= 37)");

    // Check if patient_id is set and add it as a condition
    if (isset($data['patient_id'])) {
        $this->db->where("pat_patient.patient_id", $data['patient_id']);
    }

    // Execute the query
    $query = $this->db->get("pat_patient");

    // Debug the last query executed (optional)
  

    // Return the results
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return [];
    }
}


    // Function to get all doctors
    public function getAllDoctors() {
    $this->db->select('u.id, u.user_id, d.id as doc_id, d.first_name, u.email,u.user_id,u.fcm_token,u.device_type, d.country_code, d.mobile_no, d.doctor_id, d.is_active, u.admin_approve, d.registeration_no, d.rcc_no');
    $this->db->from('hr_doctor as d');
    $this->db->join('users as u', 'd.doctor_id = u.user_id', 'left');      
    $this->db->where('u.user_type', 2); // Ensures the user is a doctor
    
    // Correct aliasing for android_version and ios_version
    $this->db->where("(u.android_version >= 12 OR u.ios_version >= 10)");

    return $this->db->get()->result();
}




    // Method to get selected patients
public function getSelectedPatients($patient_ids) {
    if (empty($patient_ids)) {
        return [];
    }

    $this->db->select('pat_patient.first_name AS full_name, pat_patient.*, users.email, users.fcm_token, users.device_type,users.device_type,users.user_id')
        ->join('users', 'users.user_id = pat_patient.patient_id', 'left')
        ->where_in('pat_patient.patient_id', $patient_ids)
        ->order_by('pat_patient.id', 'DESC');

    return $this->db->get('pat_patient')->result();
}

// Method to get selected doctors
 public function getSelectedDoctors($doctor_ids) {
        if (empty($doctor_ids)) {
            return [];
        }

        $this->db->select('u.id, u.user_id, d.id as doc_id, d.first_name, u.email, u.fcm_token AS fcm_token, u.device_type, d.country_code, d.mobile_no, d.doctor_id, d.is_active, u.admin_approve, d.registeration_no, d.rcc_no')
            ->from('hr_doctor as d')
            ->join('users as u', 'd.doctor_id = u.user_id', 'left')
            ->where_in('d.doctor_id', $doctor_ids)
            ->where('u.user_type', 2)
            ->order_by('u.id', 'DESC');

        return $this->db->get()->result();
    }


	 public function sendNotification($fcm_token,$device_type,$title,$description,$type='general-message',$data='')
    {
    
            if(isset($device_type) && isset($fcm_token)){

                if($device_type == 'android')
                {                    
                    $tok = androidnotification($fcm_token,$title,$description,$type,$data);

                }
                elseif($device_type == 'ios')
                {
                    $tok = iosNotification($fcm_token,$title,$description,$type,$data);
                }
                else
                {
                    $tok = sendwebPushNotification($fcm_token, $title, $description, $id = null,$icon = null);
                }
            }
            return $tok;

    }


     public function getNotificationById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('admin_message');
        return $query->row();
    }

    public function updateSendMessage($id, $data) {
    // Ensure `$id` is a valid identifier
    if (!empty($id) && is_array($data) && !empty($data)) {
        // Apply the `WHERE` clause to specify the notification ID to update
        $this->db->where('id', $id);
        
        // Execute the update with the provided data
        $result = $this->db->update('admin_message', $data);

        // Optionally, check if the update was successful and return the result
        return $result;
    }

    // If the ID or data is invalid, return `false`
    return false;
}

}
?>