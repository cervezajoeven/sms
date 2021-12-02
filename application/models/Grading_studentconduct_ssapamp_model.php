<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grading_studentconduct_ssapamp_model extends CI_Model {

    public function getList()
    {
        $query=$this->db->query("select id,alpha,checklistname from grading_checklist_ssapamp order by id");
        return $query->result();
    }

    public function getGrades($studentid)
    {
        //    SELECT studentgrade.studentid,studentgrade.checklistid,studentgrade.period1,studentgrade.period2,studentgrade.finalgrade,checklistdetails.detail,checklist.checklistname,checklist.id FROM studentgrade sg 
        // inner join checklistdetails cd on sg.checklistid=cd.id
        // inner join checklist c on c.id=cd.checklistid WHERE sg.studentid=1;
        $this->db->select("grading_studentconduct_ssapamp.studentid,grading_studentconduct_ssapamp.id as ssid,grading_studentconduct_ssapamp.conductid,grading_studentconduct_ssapamp.grade,grading_studentconduct_ssapamp.lg,grading_conduct_ssapamp.description,grading_conduct_ssapamp.id");
        $this->db->where('grading_studentconduct_ssapamp.studentid', $studentid);
        $this->db->from('grading_studentconduct_ssapamp');
        $this->db->join('grading_conduct_ssapamp', 'grading_studentconduct_ssapamp.conductid = grading_conduct_ssapamp.id');
        // var_dump($this->db->last_query());
        $query = $this->db->get();
  
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function getStudentGradeList($studentid,$level,$section,$session,$quarter)
    {
       
        $this->db->select("conductid,grade,lg");
        $this->db->where('studentid', $studentid);
        $this->db->where('levelid', $level);
        $this->db->where('sectionid', $section);
        $this->db->where('schoolyear', $session);
        $this->db->where('semester', $quarter);
        $this->db->from('grading_studentconduct_ssapamp');
        // var_dump($this->db->last_query());
        $query = $this->db->get();
  
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function updatestudentgrade($studentid,$sgid,$conductid,$dataarray) {
        $this->db->where('id', $sgid);
        $this->db->where('conductid', $conductid);
        $this->db->update('grading_studentconduct_ssapamp', $dataarray);
        var_dump($this->db->last_query());
    }


    public function batchinsert($dataarray) {            
        $this->db->insert_batch('grading_studentconduct_ssapamp',$dataarray);
        if ($this->db->affected_rows() > 0) {
            $inserted_id = $this->db->insert_id();
            return 1;
        } else {
            return 0;// false;
        } 
    }  

}