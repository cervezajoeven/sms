<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends General_Controller {
    public $current_function;
    function __construct() {

        parent::__construct();
        $this->load->model('assessment_model');
        $this->load->model('general_model');
        $this->load->model('class_model');
        $this->load->model('lesson_model');
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'lms/assessment');
    }

    public function index(){

        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/assessment');
        $data['list'] = $this->assessment_model->all_assessment();

        $data['role'] = $this->general_model->get_role();
        


        if($data['role']=='admin'){
            $this->load->view('layout/header');
        }else{

            $this->load->view('layout/student/header');
        }

        $this->load->view('lms/assessment/index', $data);
        $this->load->view('layout/footer');
    }

    public function assigned(){

        $this->page_title = "Assigned";
        $this->data = $this->assessment_model->assigned_assessment($this->session->userdata('id'));
        $this->sms_view(__FUNCTION__);
    }

    public function respond($id){
        $this->data['survey_id'] = $id;
        $data['id'] = $id;

        $this->data['survey'] = $this->survey_model->get("survey",$data);
        $this->data['account_profile'] = $this->survey_model->ben_where("profile","account_id",$this->session->userdata('id'))[0];
        $this->db->select("*");
        $this->db->where("account_id",$this->data['account_profile']['account_id']);
        $this->db->where("survey_id",$id);
        $this->db->where("response_status",1);
        $query = $this->db->get("survey_sheets");
        $response = $query->result_array();
        if(!empty($response)){
            echo "<script>alert('Survey has already been responded ".$this->data['account_profile']['account_id']."');window.location.replace('".$this->ben_link('general/survey/assigned')."')</script>";
            
            $this->ben_view_ultraclear(__FUNCTION__);
        }else{
            $this->db->select("*");
            $this->db->where("account_id",$this->data['account_profile']['account_id']);
            $this->db->where("survey_id",$id);
            $new_query = $this->db->get("survey_sheets");
            $new_response = $new_query->result_array();
            if(empty($new_response)){
                $survey_data['survey_id'] = $id;
                $survey_data['account_id'] = $this->session->userdata('id');
                $this->survey_model->create_new("survey_sheets",$survey_data);
                
            }
            $this->ben_view_ultraclear(__FUNCTION__);
        }
        
    }

    public function save(){

        $data['assessment_name'] = $_REQUEST['assessment_name'];
        $data['account_id'] = $this->customlib->getStaffID();
        $data['assigned'] = $_REQUEST['assigned'];

        $assessment_id = $this->assessment_model->lms_create("lms_assessment",$data);

        redirect(site_url()."lms/assessment/edit/".$assessment_id);
    }

    public function edit($id){

        if($id){
            $data['id'] = $id;
            $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
            $data['resources'] = site_url('backend/lms/');
            $data['students'] = $this->lesson_model->get_students("lms_lesson",$id,"id");
            $data['classes'] = $this->class_model->getAll();
            $data['class_sections'] = $this->lesson_model->get_class_sections();
            

            $this->load->view('lms/assessment/edit', $data);

            
        }
        
    }

    public function answer($id){
        $data['id'] = $id;
        $data['account_id'] = $this->general_model->get_account_id();

        $this->db->select("*");
        $this->db->where("account_id", $data['account_id']);
        $this->db->where("assessment_id",$id);
        $this->db->where("response_status",1);

        $query = $this->db->get("lms_assessment_sheets");
        $response = $query->result_array();
        
        $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        
        $data['resources'] = site_url('backend/lms/');

        
            
        if(!empty($response)){
            echo "<script>alert('Assesment has already been answered Account ID:".$data['account_id']."');window.location.replace('".site_url('lms/assessment/index')."')</script>";
            
            $this->load->view('lms/assessment/answer', $data);
        }else{
            $this->db->select("*");
            $this->db->where("account_id",$data['account_id']);
            $this->db->where("assessment_id",$id);
            $new_query = $this->db->get("lms_assessment_sheets");
            $new_response = $new_query->result_array();
            if(empty($new_response)){
                $assessment_data['assessment_id'] = $id;
                $assessment_data['account_id'] = $data['account_id'];
                $new_assessment_id = $this->assessment_model->lms_create("lms_assessment_sheets",$assessment_data);
                $new_response = $this->assessment_model->lms_get("lms_assessment_sheets",$new_assessment_id,"id");
            }
            $data['assessment_sheet'] = $new_response[0];
            
            $this->load->view('lms/assessment/answer', $data);
        }
        
    }

    public function review($id){
        $data['id'] = $id;
        $data['account_id'] = $this->general_model->get_account_id();

        $this->db->select("*");
        $this->db->where("account_id", $data['account_id']);
        $this->db->where("assessment_id",$id);
        $this->db->where("response_status",1);

        $query = $this->db->get("lms_assessment_sheets");
        $response = $query->result_array();
        
        $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        $data['resources'] = site_url('backend/lms/');
            
        if(!empty($response)){
            echo "<script>alert('Assesment has already been answered Account ID:".$data['account_id']."');window.location.replace('".site_url('lms/assessment/index')."')</script>";
            
            $this->load->view('lms/assessment/answer', $data);

        }else{

            $this->db->select("*");
            $this->db->where("account_id",$data['account_id']);
            $this->db->where("assessment_id",$id);
            $new_query = $this->db->get("lms_assessment_sheets");
            $new_response = $new_query->result_array();

            if(empty($new_response)){
                $assessment_data['assessment_id'] = $id;
                $assessment_data['account_id'] = $data['account_id'];
                $new_assessment_id = $this->assessment_model->lms_create("lms_assessment_sheets",$assessment_data);
                $new_response = $this->assessment_model->lms_get("lms_assessment_sheets",$new_assessment_id,"id");
            }

            $data['assessment_sheet'] = $new_response[0];
            
            $this->load->view('lms/assessment/review', $data);
        }
        
    }

    public function update(){
        $data['id'] = $_REQUEST['id'];
        $data['sheet'] = $_REQUEST['sheet'];
        $data['assigned'] = $_REQUEST['assigned'];
        $this->assessment_model->lms_update("lms_assessment",$data);

        // $this->assessment_model->lms_update("lms_assessment",$data);
    }

    public function update_survey_sheet(){
        $data['assessment_id'] = $_REQUEST['assessment_id'];
        $data['respond'] = $_REQUEST['respond'];
        $data['account_id'] = $_REQUEST['account_id'];
        $data['response_status'] = 1;
        $this->db->select("*");
        $this->db->where("survey_id", $data["survey_id"]);
        $this->db->where("account_id", $data["account_id"]);
        $data['date_updated'] = date("Y-m-d H:i:s");
        $this->db->update("survey_sheets", $data);
    }

    public function upload($id){
        
        // print_r(strpos($_FILES['survey_form']['type'], "pdf"));

        if(strpos($_FILES['assessment_form']['type'], "pdf")!==0){
            $tmp_name = $_FILES['assessment_form']['tmp_name'];
            $file_name = $this->assessment_model->id_generator("assessment").".pdf";
            $dest = FCPATH."uploads/lms_assessment/".$id."/".$file_name;
            if(!is_dir(FCPATH."uploads/lms_assessment/".$id)){
                mkdir(FCPATH."uploads/lms_assessment/".$id);
            }
            
            if(move_uploaded_file($tmp_name, $dest)){
                $data['id'] = $id;
                $data['assessment_file'] = $file_name;

                $this->assessment_model->lms_update("lms_assessment",$data);
                
                echo "<script>alert('Successfully uploaded');window.location.replace('".site_url('lms/assessment/edit/'.$id)."')</script>";
            }
        }else{
            echo "<script>alert('Only PDF files are allowed');window.location.replace('".site_url('lms/assessment/edit/'.$id)."')</script>";
        }
        
    }

    public function delete($id){
        $data['id'] = $id;
        if($this->assessment_model->lms_delete("lms_assessment",$data)){
            redirect(site_url("lms/assessment/index"));
        }
    }

    public function answer_submit(){
        
        $data['id'] = $_REQUEST['id'];
        $data['answer'] = $_REQUEST['answer'];
        print_r($this->assessment_model->lms_update("lms_assessment_sheets",$data));
    }

    public function check_answers($assessment_id){
        
    }
}
