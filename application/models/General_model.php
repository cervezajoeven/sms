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
        $userdata = $this->session->userdata();
        if(array_key_exists('student', $userdata)){
            $role = "student";
        }else{
            $role = "admin";
        }
        return $role;
        
    }


}
