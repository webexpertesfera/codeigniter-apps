<?php
class Doctors_model extends CI_Model {


    public function create($employee_data,$user_data) {

        $this->db->insert("hr_doctor",$employee_data);
        $this->db->insert("users",$user_data);

        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'New Doctor Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function user_email_exist($data) {
        if(isset($data['user_id'])){
            $this->db->where(['user_type'=>$data['user_type'],'email'=>$data['email'],'id !='=>$data['user_id']]);
        }
        else {
            $this->db->where(['user_type'=>$data['user_type'],'email'=>$data['email']]);
        }

        $query = $this->db->select("id")->get("users");
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_doctor($data=null) {

        $this->db->select("hr_doctor.doctor_id,hr_doctor.prescription_fees,hr_doctor.hospital_department_id as department_id,hr_doctor.fee_is_applicable,hr_doctor.fee_payment,CONCAT(hr_doctor.first_name,' ',hr_doctor.last_name) AS full_name,hr_doctor.id,hr_doctor.mobile_no,hr_doctor.created_by,hr_doctor.is_active,hr_doctor.created_time,hr_doctor.created_by_ip,hr_doctor.updated_time,hr_doctor.specialist,users.email,department.name as department_name,designation.name as designation_name",FALSE)
        ->join("hospital_department as department","department.id=hr_doctor.hospital_department_id")
        ->join("hr_doctor_designation as designation","designation.id=hr_doctor.doctor_designation_id")
        ->join("users","users.user_id=hr_doctor.doctor_id")
        ->order_by("hr_doctor.id","desc");

        if(isset($data['hospital_department_id'])) {
            $this->db->where("hr_doctor.hospital_department_id",$data['hospital_department_id']);
        }

        if(isset($data['is_active'])) {
            $this->db->where("hr_doctor.is_active",$data['is_active']);
        }

        if(isset($data['doctor_id'])) {
            $this->db->where("hr_doctor.doctor_id",$data['doctor_id']);
        }

        $query=$this->db->get("hr_doctor");

        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_hr_doctor_department() {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active",1)
            ->get("hospital_department");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_hr_doctor_designation() {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active",1)
            ->get("hr_doctor_designation");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }


    public function get_hr_doctor_department_update($department_id) {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active=1 or (id=$department_id)")
            ->get("hospital_department");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_hr_doctor_designation_update($designation_id) {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active=1 or (id=$designation_id)")
            ->get("hr_doctor_designation");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_update_doctor($id) {
        $query = $this->db->select("hr_doctor.*,users.email,users.id as user_id")
            ->join("users","users.user_id=hr_doctor.doctor_id")
            ->get_where("hr_doctor",['hr_doctor.id'=>(int)$id]);
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }
    }

    public function update($data) {

        $id = $data['id'];
        $email = $data['email'];
        $user_id = $data['user_id'];
        unset($data['id'],$data['email'],$data['user_id']);
        $this->db->update("hr_doctor",$data,['id'=>$id]);
        $this->db->update("users",['email'=>$email],['id'=>$user_id]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor Information Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($id) {

        $this->db->where('id', $id);
        $this->db->delete('hr_doctor');

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Doctor delete successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function get_doctor_basic($data) {

        $query = $this->db->select("doct.*,dept.name as department_name,desig.name as designation_name")
            ->join("hospital_department as dept","doct.hospital_department_id=dept.id")
            ->join("hr_doctor_designation as desig","doct.doctor_designation_id=desig.id")
            ->where("doctor_id",$data['doctor_id'])
            ->get("hr_doctor as doct");
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }

    }

}