<?php
defined('BASEPATH') or exit('No direct script access allowed');
class JOE_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database('default');

    }

    public function lms_get($table="",$value="",$where="",$select="*") {

        if($table){
            $this->db->select($select);
            if($value){
                if($where){
                    $this->db->where($where,$value);
                }else{
                    die("Where is not defined!");
                }
            }
            $query = $this->db->get($table);
            $return = $query->result_array();
            return $return;
        }else{
            die("Table name was not defined.");
        }

    }
}
