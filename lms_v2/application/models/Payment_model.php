<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends JOE_Model {

    public function __construct() {
        parent::__construct();

    }
    public function user_info($parent_id)
    {
        $this->db->select('*')->from('students');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('students.is_active', 'yes');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_parent_children($parent_id)
    {
        $this->db->select('*')->from('students');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('students.is_active', 'yes');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_payment_info(){

        $this->db->select('payment_history.*,students.firstname,students.lastname')->from('payment_history');
        $this->db->join('students','payment_history.student_id = students.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_payment_info_parent($account_id){

        $this->db->select('payment_history.*,students.firstname,students.lastname')->from('payment_history');
        $this->db->where('payment_history.account_id',$account_id);
        $this->db->join('students','payment_history.student_id = students.id');
        $query = $this->db->get();
        return $query->result();
        
    }
}
