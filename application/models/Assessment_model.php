<?php
class Assessment_model extends MY_Model {

	public $table = "lms_assessment";

	public function all_assessment(){

        // $this->db->select('*');
        $this->db->select('*,lms_assessment.date_created as date_created, lms_assessment.id as id');
        $this->db->from('lms_assessment');
        $this->db->join('staff', 'staff.employee_id = lms_assessment.account_id','left');
        $this->db->where('lms_assessment.deleted',0);
        $this->db->order_by('lms_assessment.date_created',"desc");

        $query = $this->db->get();

        $return = $query->result_array();
        
        return $return;
    }

    public function assigned_assessment($account_id){

        $this->db->select('*');
        $this->db->from('lms_assessment');
        $this->db->where("FIND_IN_SET('".$account_id."', assigned) !=", 0);
        $this->db->where("deleted", 0);

        $query = $this->db->get();

        $return = $query->result_array();
        return $return;
    }

    public function assessment_sheets($assessment_id){

        $this->db->select('*');
        $this->db->from('lms_assessment_sheets');
        $this->db->where("assessment_id",$assessment_id);
        $this->db->where("deleted", 0);

        $query = $this->db->get();

        $return = $query->result_array();
        return $return;
    }

    public function delete_assessment($table,$id){
        $data['id'] = $id;
        $data['deleted'] = 1;
        
        $this->db->where('id',$id);
        $this->assessment_model->update($table,$data);
        return true;
    }
	
}
