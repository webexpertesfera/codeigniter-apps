<?php
class Hospital_department_model extends CI_Model {


    public function create($data) {
        $this->db->insert("hospital_department",$data);
        $error = $this->db->error();
        if($error['code']==0){
            return ['status'=>'success','message'=>'New Department Create Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function create_duplicate_check($data) {
        $query = $this->db->select("id")->get_where("hospital_department",['name'=>$data['name']]);
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function update_duplicate_check($data) {
        $query = $this->db->select("id")->get_where("hospital_department",['name'=>$data['name'],'id !='=> $data['id']]);
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_hospital_department($data=null) {
        if(is_null($data)) {
            $query = $this->db->select("*")
                ->order_by("id", "desc")
                ->get("hospital_department");
        }
        else {
            $query = $this->db->select("*")
                ->where("is_active",$data['is_active'])
                ->order_by("id", "desc")
                ->get("hospital_department");
        }
        if($query->num_rows()>0) {
            return $query->result();
        }
        else {
            return [];
        }
    }

    public function get_update_department($id) {
        $query = $this->db->select("*")
            ->get_where("hospital_department",['id'=>(int)$id]);
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
        $this->db->update("hospital_department",[
            'name'=>$data['name'],
            'description'=>$data['description'],
            'establish_year'=>$data['establish_year'],
            'updated_by'=>$data['updated_by'],
            'updated_time'=>$data['updated_time'],
            'updated_by_ip'=>$data['updated_by_ip'],
            'is_active'=>$data['is_active'],
        ],['id'=>$id]);

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Hospital Department Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete($id) {

        $this->db->where('id', $id);
        $this->db->delete('hospital_department');

        $error = $this->db->error();

        if($error['code']==0) {
            return ['status'=>'success','message'=>'Hospital Department Delete Successfully'];
        }
        else {
            return ['status'=>'error','message'=>$error['message']];
        }
    }

    public function delete_dependency_check($id) {

        $query = $this->db->select("id")
            ->where("hospital_department_id",$id)
            ->get("hr_doctor");
        if($query->num_rows()>0) {
            return true;
        }
        else {
            return false;
        }
    }

}