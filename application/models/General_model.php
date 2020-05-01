<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_model extends MY_Model {

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

    public function get_role(){
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
    

}
