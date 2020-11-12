<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Class_record extends Student_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('gradereport_model');
        $this->load->model('setting_model');

        $this->sch_setting_detail = $this->setting_model->getSetting();
    }
    public function index()
    {
        $this->session->set_userdata('top_menu', 'Class_Record');

        $data['title'] = 'Class Record';

        
        $student_current_class = $this->customlib->getStudentCurrentClsSection();
        $student_id = $this->customlib->getStudentSessionUserID();
        $data['quarter_list'] = $this->gradereport_model->get_quarter_list();
        // print_r("Erwin Nora");die();
        $class_record = $this->gradereport_model->get_student_class_record($this->sch_setting_detail->session_id, $student_id, $student_current_class->class_id, $student_current_class->section_id);
        // print_r($class_record);die();
        $data['resultlist'] = $class_record;
        
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/class_record/class_record', $data);
        $this->load->view('layout/student/footer', $data);
    }

}
