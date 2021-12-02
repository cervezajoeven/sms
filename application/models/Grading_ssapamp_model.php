<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grading_ssapamp_model extends CI_Model {

    public function getSectionId($section)
    {
        $this->db->where('section',$section);
        $this->db->select('id');
        $query=$this->db->get('sections');
        return $query->result();
    }

    public function getSchoolYearId($schoolyear)
    {       
        $this->db->where('session',$schoolyear);
        $this->db->select('id');
        $query=$this->db->get('sessions');
        return $query->result();
    }

    public function getLevelId($level)
    {
        $this->db->where('class',$level);
        $this->db->select('id');
        $query=$this->db->get('classes');
        return $query->result();
    }

    public function getClassBySection($classid) {
        // $userdata = $this->customlib->getUserData();
        // $role_id = $userdata["role_id"];
        // $carray = array();
     
        // if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
        //     $section=$this->teacher_model->get_teacherrestricted_modesections($userdata["id"],$classid);
   
           
        // } else {
        $this->db->select('class_sections.id,class_sections.section_id,sections.section');
        $this->db->from('class_sections');
        $this->db->join('sections', 'sections.id = class_sections.section_id');
        $this->db->where('class_sections.class_id', $classid);
        $this->db->order_by('class_sections.id');
        $query = $this->db->get();
       $section= $query->result_array();
    // }
        return $section;
    }

}