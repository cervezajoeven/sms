<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classrecord_model extends MY_Model 
{

    public function __construct() {
        parent::__construct();
        //-- Load database for writing
        $this->writedb = $this->load->database('write_db', TRUE);
    }

    
}
