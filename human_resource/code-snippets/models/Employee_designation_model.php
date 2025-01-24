<?php
class Employee_designation_model extends CI_Model {


    public function create($data) {
        $this->db->insert("hr_employee_designation",$data);
        $error = $this->db->error();
        if($error['code']==0){
            return ['status'=>'success','message'=>'New Designation Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function create_duplicate_check($data) {
        $query = $this->db->select("id")->get_where("hr_employee_designation",['name'=>$data['name']]);
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function update_duplicate_check($data) {
        $query = $this->db->select("id")->get_where("hr_employee_designation",['name'=>$data['name'],'id !='=> $data['id']]);
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_employee_designation() {
        $query = $this->db->select("*")
            ->order_by("id","desc")
            ->get("hr_employee_designation");
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_update_designation($id) {
        $query = $this->db->select("*")
            ->get_where("hr_employee_designation",['id'=>(int)$id]);
        if($query->num_rows()>0) {
            return $query->row();
        }
        else {
            return [];
        }
    }

    public function update($data) {

        $id = $data['id'];
        unset($data['id']);
        $this->db->update("hr_employee_designation",[
            'name'=>$data['name'],
            'updated_by'=>$data['updated_by'],
            'updated_time'=>$data['updated_time'],
            'updated_by_ip'=>$data['updated_by_ip'],
            'is_active'=>$data['is_active'],
        ],['id'=>$id]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Employee Designation Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($id) {

        $this->db->where('id', $id);
        $this->db->delete('hr_employee_designation');

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Employee Designation Delete Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete_dependency_check($id) {
        $query = $this->db->select("id")
            ->get_where("hr_employee",['designation_id'=>(int)$id]);
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

}