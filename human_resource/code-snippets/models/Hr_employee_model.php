<?php
class Hr_employee_model extends CI_Model {


    public function create($employee_data,$user_data) {

        $this->db->insert("hr_employee",$employee_data);

        $this->db->insert("users",$user_data);

        $error = $this->db->error();
        if($error['code']==0) {
            return ['status'=>'success','message'=>'New Employee Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function user_email_exist($data) {
        if(isset($data['user_id'])){
            $this->db->where(['email'=>$data['email'],'id !='=>$data['user_id']]);
        }
        else {
            $this->db->where(['email'=>$data['email']]);
        }

        $query = $this->db->select("id")->get("users");
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function user_mobile_exist($data) {
        if(isset($data['user_id'])){
            $this->db->where(['mobile_no'=>$data['mobile_no'],'id !='=>$data['user_id']]);
        }
        else {
            $this->db->where(['mobile_no'=>$data['mobile_no']]);
        }

        $query = $this->db->select("id")->get("users");
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }


public function get_employee() {
     $cntry = $this->session->userdata('country');
     if($cntry == 'all'){
     $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $query = $this->db->select("hr_employee.employee_id,hr_employee.first_name AS full_name,hr_employee.id,hr_employee.mobile_no,hr_employee.created_by,hr_employee.is_active,hr_employee.created_time,hr_employee.created_by_ip,hr_employee.updated_time,users.email,users.country,hr_employee.created_by",FALSE)
            ->join("users","users.user_id=hr_employee.employee_id")
            ->where(['hr_employee.is_admin !='=>1])
            ->order_by("hr_employee.id","desc")
            ->get("hr_employee");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
      }
      elseif($cntry == 'UK')
      {
             $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $query = $this->db->select("hr_employee.employee_id,hr_employee.first_name AS full_name,hr_employee.id,hr_employee.mobile_no,hr_employee.created_by,hr_employee.is_active,hr_employee.created_time,hr_employee.created_by_ip,hr_employee.updated_time,users.email,users.country,hr_employee.created_by",FALSE)
            ->join("users","users.user_id=hr_employee.employee_id")
            ->where(['hr_employee.is_admin !='=>1,'hr_employee.country'=>'UK'])
            ->order_by("hr_employee.id","desc")
            ->get("hr_employee");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
      }
      else
      {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $query = $this->db->select("hr_employee.employee_id,hr_employee.first_name AS full_name,hr_employee.id,hr_employee.mobile_no,hr_employee.created_by,hr_employee.is_active,hr_employee.created_time,hr_employee.created_by_ip,hr_employee.updated_time,users.email,users.country,hr_employee.created_by",FALSE)
            ->join("users","users.user_id=hr_employee.employee_id")
            ->where(['hr_employee.is_admin !='=>1,'hr_employee.country'=>'Egypt'])
            ->order_by("hr_employee.id","desc")
            ->get("hr_employee");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
      }
    }

    public function get_hr_department() {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active",1)
            ->get("hr_employee_department");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_hr_designation() {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where(["is_active"=>1,"is_admin"=>0])
            ->get("hr_employee_designation");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }


    public function get_hr_department_update($department_id) {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("is_active=1 or (id=$department_id)")
            ->get("hr_employee_department");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_hr_designation_update($designation_id)
    {

        $query = $this->db->select("*")
            ->order_by("id","ASC")
            ->where("(is_active=1 && is_admin=0) || (id=$designation_id)")
            ->get("hr_employee_designation");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_update_employee($id) {
        $query = $this->db->select("hr_employee.*,users.email,users.id as user_id,users.country")
            ->join("users","users.user_id=hr_employee.employee_id")
            ->get_where("hr_employee",['hr_employee.id'=>(int)$id]);
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }
    }

    public function update($data) {

        $id = $data['id'];
        $user_id = $data['user_id'];
        $email = $data['email'];
        unset($data['id'],$data['user_id'],$data['email']);
        $this->db->update("hr_employee",$data,['id'=>$id]);
        $this->db->update("users",['email'=>$email],['id'=>$user_id]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Employee Information Update Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($id) {

        $employee = $this->db->where('id', $id)->get('hr_employee')->row();
        $employee_id = $employee->employee_id;
       
        $this->db->where('id', $id);
        $this->db->delete('hr_employee');

        $this->db->where('user_id', $employee_id);
        $this->db->delete('users');

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Employee delete successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function get_employee_basic($data) {

        $query = $this->db->select("emp.*,u.*")
            ->join("users as u","u.user_id=emp.employee_id")
            ->where("employee_id",$data['employee_id'])
            ->get("hr_employee as emp");
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }

    }

    public function checkemailexist($where = array())
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($where);
        return $this->db->get()->result();
    }


    public function updateinfo($update,$user_id)
    {
        $this->db->where('employee_id',$user_id);
        $this->db->update('hr_employee',$update);
        return $this->db->affected_rows();
    }
    public function updateemail($update,$user_id)
    {
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$update);
        return $this->db->affected_rows();
    }
    public function updateusers($update,$user_id)
    {
        $this->db->where('id',$user_id);
        $this->db->update('users',$update);
        return $this->db->affected_rows();
    }

 public function get_subadmins() {
     $cntry = $this->session->userdata('country');
    
     $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $query = $this->db->select("hr_employee.employee_id,hr_employee.first_name AS full_name,hr_employee.id,hr_employee.mobile_no,hr_employee.created_by,hr_employee.is_active,hr_employee.created_time,hr_employee.created_by_ip,hr_employee.updated_time,users.email,users.country,hr_employee.created_by",FALSE)
            ->join("users","users.user_id=hr_employee.employee_id")
            ->where(['hr_employee.is_admin ='=>1])
            ->where(['hr_employee.employee_id !='=>1001800000])
            ->order_by("hr_employee.id","desc")
            ->get("hr_employee");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
      
      
          
    }


}