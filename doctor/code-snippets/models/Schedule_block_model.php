<?php
class Schedule_block_model extends CI_Model {


    public function create($data) {

        $this->db->insert("doct_schedule_block",$data);

        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'Schedule Block Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }


    public function get_block_schedule($data) {

        if(isset($data['is_admin']) && $data['is_admin']==1) { // admin
            $this->db->select("doct_schedule_block.*,CONCAT(hr_doctor.first_name,' ',hr_doctor.last_name)as full_name", FALSE)
                ->join("hr_doctor","hr_doctor.doctor_id=doct_schedule_block.doctor_id");

            if(isset($data['doctor_id'])) { // search by doctor
                $this->db->where('doct_schedule_block.doctor_id',$data['doctor_id']);
            }
        }
        else { // doctor self schedule
            $this->db->select("doct_schedule_block.*,CONCAT(hr_doctor.first_name,' ',hr_doctor.last_name)as full_name", FALSE)
                ->join("hr_doctor","hr_doctor.doctor_id=doct_schedule_block.doctor_id")
                ->where('doct_schedule_block.doctor_id',$data['user_id']);

        }

        $query = $this->db->get("doct_schedule_block");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }


    public function update($data) {
        $id = $data['id'];
        unset($data['id']);
        $this->db->update("doct_schedule_block",$data,['id'=>$id]);
        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Schedule Block Update successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($data) {

        $this->db->delete('doct_schedule_block',['id'=>$data['id']]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Block Data Delete successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function get_update_schedule_block($id) {
        $query = $this->db->select("*")
            ->where(['id'=> $id])
            ->get("doct_schedule_block");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return [];
        }
    }

    public function get_day($from,$to) {
        $from_date = new DateTime($from);
        $to_date = new DateTime($to);
        $days = [];
        for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {

            if($date->format('l')=='Saturday') {
                $days[1] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            elseif($date->format('l')=='Sunday'){
                $days[2] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            elseif($date->format('l')=='Monday'){
                $days[3] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            elseif($date->format('l')=='Tuesday'){
                $days[4] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            elseif($date->format('l')=='Wednesday'){
                $days[5] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            elseif($date->format('l')=='Thursday'){
                $days[6] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }
            else {
                $days[7] = ['day'=>$date->format('l'),'date'=>$date->format('Y-m-d')];
            }

        }
        return $days;
    }

    public function get_doctor_schedule($data) {

        if(empty($data['doctor_id'])) {
            return false;
        }
        else {
            $query = $this->db->select("*")
                ->where(['doctor_id'=>$data['doctor_id']])
                ->where_in("day",$data['day_ids'])
                ->order_by("day")
                ->get("doct_schedule");
            if($query->num_rows()>0) {
                return $query->result();
            }
            else {
                return false;
            }
        }
    }

    public function check_schedule_block_is_exists($data) {

        if(isset($data['id'])) { // check for update operation
            $this->db->where(['id !='=>$data['id']]);
        }

        $this->db->select("id")
            ->where("doctor_id", $data['doctor_id'])
            ->where("( ( (from_date BETWEEN '{$data['from_date']}' AND '{$data['to_date']}') OR (to_date BETWEEN '{$data['from_date']}' AND '{$data['to_date']}') ) OR (from_date < '{$data['from_date']}' AND to_date > '{$data['to_date']}') )");
        $query = $this->db->get("doct_schedule_block");
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

}