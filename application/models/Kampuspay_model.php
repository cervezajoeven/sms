<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kampuspay_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    // public function getUnixTimestamp()
    // {
    //     $this->db->select('UNIX_TIMESTAMP(current_timestamp()) AS timestamp');
    //     $this->db->limit(1);
    //     $query = $this->db->get();

    //     $ret = $query->row()->timestamp;
    //     return $ret;
    // }
}
