<?php
class Survey_model extends MY_Model {

	public $table = "lms_survey";

	public function all_survey(){

        $this->db->select('*,lms_survey.date_created as date_created, lms_survey.id as id');
        $this->db->from('lms_survey');
        $this->db->join('staff', 'staff.employee_id = lms_survey.account_id','left');
        $this->db->where('lms_survey.deleted',0);
        $this->db->order_by('lms_survey.date_created',"desc");

        $query = $this->db->get();

        $return = $query->result_array();
        return $return;
    }

    public function assigned_survey($account_id){

        $this->db->select('*');
        $this->db->from('lms_survey');
        $this->db->where("FIND_IN_SET('".$account_id."', assigned) !=", 0);
        $this->db->where("deleted", 0);

        $query = $this->db->get();

        $return = $query->result_array();
        return $return;
    }

    public function delete_survey($table,$id){
        $data['id'] = $id;
        $data['deleted'] = 1;
        
        $this->db->where('id',$id);
        $this->survey_model->update($table,$data);
        return true;
    }
	
}
