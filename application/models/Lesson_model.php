<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */

    public function get_lessons($account_id=""){

        $this->db->select("*");
        $this->db->where("account_id",$account_id);
        $this->db->where('deleted',0);
        $query = $this->db->get("lms_lesson");

        $result = $query->result_array();
        return $result;
    }

    public function student_lessons($account_id=""){

        $this->db->select("*");
        $this->db->where("FIND_IN_SET('".$account_id."', assigned) !=", 0);
        $this->db->where('deleted',0);
        $query = $this->db->get("lms_lesson");

        $result = $query->result_array();
        return $result;
    }

    public function get_students(){
        $current_session = $this->setting_model->getCurrentSession();
        $this->db->select("*");
        $this->db->join("students","students.id = student_session.student_id");
        $this->db->where("session_id",$current_session);

        $query = $this->db->get("student_session");

        $result = $query->result_array();
        return $result;
    }

    public function get_class_sections(){
        $this->db->select("*");
        $this->db->join("classes","classes.id = class_sections.class_id");
        $this->db->join("sections","sections.id = class_sections.section_id");
        $query = $this->db->get("class_sections");
        $result = $query->result_array();
        return $result;
        
    }
    
    public function search_my_resources($account_id="",$search=""){
        $this->db->select("*");
        if($search){
            $this->db->like("name",$search);    
        }
        $this->db->where("account_id",$account_id);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get("lms_my_resources");
        $result = $query->result_array();
        return $result;
    }

}
