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
        $this->load->model('conduct_model');

        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'Class_Record');

        $data['title'] = 'Grades';        
        $student_current_class = $this->customlib->getStudentCurrentClsSection();
        $student_id = $this->customlib->getStudentSessionUserID();
        // print_r("CloudPH Debug Mode");die();
        $data['quarter_list'] = $this->gradereport_model->get_quarter_list();  
        $data['legend_list'] = $this->conduct_model->get_conduct_legend_list();
        
        $class_record = $this->gradereport_model->get_student_class_record($this->sch_setting_detail->session_id, $student_id, $student_current_class->class_id, $student_current_class->section_id);
        $data['resultlist'] = $class_record;
        $data['conduct_grading_type'] = $this->sch_setting_detail->conduct_grading_type;       

        $student_conduct = null;
        if ($this->sch_setting_detail->conduct_grade_view == 0)
        {
            // print_r("CloudPH Debug Mode");die();
            if ($this->sch_setting_detail->conduct_grading_type == 'letter')
                $student_conduct = $this->gradereport_model->get_student_conduct($this->sch_setting_detail->session_id, $student_current_class->class_id, $student_current_class->section_id, $student_id);
            else if ($this->sch_setting_detail->conduct_grading_type == 'number')
                $student_conduct = $this->gradereport_model->get_student_conduct_numeric($this->sch_setting_detail->session_id, $student_current_class->class_id, $student_current_class->section_id, $student_id);
        }
            
        print_r($student_conduct);die();
        // print_r($class_record);die();        
        $data['student_conduct'] = $student_conduct;
        
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/class_record/class_record', $data);
        $this->load->view('layout/student/footer', $data);
    }

}
