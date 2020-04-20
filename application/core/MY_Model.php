<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function log($message=NULL,$record_id= NULL,$action= NULL)
    {
    	$user_id= $this->customlib->getStaffID();

        $ip = $this->input->ip_address();

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {

            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $platform = $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

        $insert = array(
            'message'    => $message,
            'user_id'    => $user_id,
            'record_id'    => $record_id,
            'ip_address' => $ip,
            'platform'   => $platform,
            'agent'      => $agent,
            'action'     => $action,
        );

        $this->db->insert('logs', $insert);
    }
    /* campuscloud development */
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
            $query = $this->db->get("lms_lesson");
            $return = $query->result_array();
            return $return;
        }else{
            die("Table name was not defined.");
        }
        
    }
    public function lms_create($table="",$data=array()){

        if($table&&is_string($table)){

            if(!empty($data)){
                $id = $table."_".$this->mode."_".microtime(true)*10000;
                $id = $id.rand(1000,9999);
                $data['id'] = $id;
                
                $escaped_data = array();
                foreach ($data as $data_key => $data_value) {
                    $escaped_data[$data_key] = html_escape($data_value);
                }
                
                $escaped_data['date_created'] = date("Y-m-d H:i:s");
                if($this->db->insert($table, $escaped_data)){
                    return $id;
                }else{ 
                    print_r($this->db->error());
                    return false; 
                }
            }else{
                exit("Data is empty");
            }
            
            
        }else{
            echo "Table name was not declared.";
            return false;
        }
    }
}
