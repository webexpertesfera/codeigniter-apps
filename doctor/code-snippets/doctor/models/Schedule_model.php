<?php
class Schedule_model extends CI_Model {


    public function create($data) {

        $this->db->insert_batch("doct_schedule",$data);

        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'New Doctor Schedule Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }


    public function get_schedule($data) {

        if(isset($data['is_admin']) && $data['is_admin']==1) { 
           // admin
            $this->db->select("doct_schedule.day as day_id,doct_schedule.doctor_id,doct_schedule.day,count(doct_schedule.id) as total_slot,CONCAT(hr_doctor.first_name,' ',hr_doctor.last_name)as full_name,
             CASE 
             WHEN day = 1 THEN 'Saturday'
             WHEN day = 2 THEN 'Sunday' 
             WHEN day = 3 THEN 'Monday' 
             WHEN day = 4 THEN 'Tuesday' 
             WHEN day = 5 THEN 'Wednesday' 
             WHEN day = 6 THEN 'Thursday' 
             WHEN day = 7 THEN 'Friday' 
             END as day", FALSE)
            ->join("hr_doctor","hr_doctor.doctor_id=doct_schedule.doctor_id")
            ->group_by("doct_schedule.doctor_id,doct_schedule.day")
            ->order_by("doct_schedule.doctor_id,doct_schedule.day");

            if(isset($data['doctor_id'])) { // search by doctor
                $this->db->where('doct_schedule.doctor_id',$data['doctor_id']);
            }
        }
        else 
        { 
             // doctor self schedule
             $this->db->select("doct_schedule.day as day_id,doct_schedule.id,doct_schedule.doctor_id,count(doct_schedule.id) as total_slot,doct_schedule.start_time,doct_schedule.end_time,doct_schedule.created_by,doct_schedule.created_time,doct_schedule.updated_time,doct_schedule.maximum_visitor,CONCAT(hr_doctor.first_name,' ',hr_doctor.last_name)as full_name,
             CASE 
             WHEN day = 1 THEN 'Saturday'
             WHEN day = 2 THEN 'Sunday' 
             WHEN day = 3 THEN 'Monday' 
             WHEN day = 4 THEN 'Tuesday' 
             WHEN day = 5 THEN 'Wednesday' 
             WHEN day = 6 THEN 'Thursday' 
             WHEN day = 7 THEN 'Friday' 
             END as day", FALSE)
            ->join("hr_doctor","hr_doctor.doctor_id=doct_schedule.doctor_id")
            ->where('doct_schedule.doctor_id',$data['user_id'])
            ->group_by("doct_schedule.day")
            ->order_by("doct_schedule.doctor_id,doct_schedule.day");

        }

        $query = $this->db->get("doct_schedule");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }


    public function update($data) {


        if(!empty($data['remove_schedule'])) {
            $this->db->where_in("id", $data['remove_schedule']);
            $this->db->delete("doct_schedule");
        }

        if(!empty($data['update_schedule'])) {
            $this->db->update_batch("doct_schedule",$data['update_schedule'],"id");
        }

        if(!empty($data['new_schedule'])) {
            $this->db->insert_batch("doct_schedule",$data['new_schedule']);
        }

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Schedule Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($data) {

        $this->db->delete('doct_schedule',['day'=>$data['day_id'],'doctor_id'=>$data['doctor_id']]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor delete successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function get_update_schedule($day_id,$doctor_id) {
        $query = $this->db->select("*")
        ->where(['day'=>$day_id,'doctor_id'=>$doctor_id])
        ->get("doct_schedule");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

}