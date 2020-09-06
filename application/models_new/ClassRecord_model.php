<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ClassRecord_model extends MY_Model 
{

    public function __construct() {
        parent::__construct();
        //-- Load database for writing
        $this->writedb = $this->load->database('write_db', TRUE);
    }

    public function get($table, $id=null) 
    {
        $this->db->select()->from($table);

        if ($id != null) 
            $this->db->where('id', $id);
            
        $this->db->order_by('id');
        $query = $this->db->get();

        if ($id != null) 
            return $query->row_array();
        else 
            return $query->result_array();
    }

    public function add($table, $data)
    {
        // var_dump($data);die;

        if (isset($data['id'])) {
            $this->writedb->where('id', $data['id']);
            $this->writedb->update($table, $data);
        } else {
            $this->writedb->insert($table, $data);
        }
    }

    public function remove($table, $id)
    {
        $this->writedb->trans_start(); # Starting Transaction
        $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->writedb->where('id', $id);
        $this->writedb->delete($table); 

        $message   = DELETE_RECORD_CONSTANT . " On ".$table." id " . $id;
        $action    = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->writedb->trans_complete(); # Completing transaction
        /*Optional*/
        if ($this->writedb->trans_status() === false) {
            # Something went wrong.
            $this->writedb->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    function check_data_exists($data, $table, $field) {
        $this->db->where($field, $data[$field]);        
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
