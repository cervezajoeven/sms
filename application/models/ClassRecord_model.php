<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Classrecord_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
        $this->load->model('customfield_model');
        $this->load->model('teacher_model');
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date    = $this->setting_model->getDateYmd();
        $this->schoolname = $this->setting_model->getCurrentSchoolName(); 
        //-- Load database for writing
        $this->writedb = $this->load->database('write_db', TRUE);
    }
}