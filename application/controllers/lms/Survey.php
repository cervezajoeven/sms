<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends General_Controller {
    public $current_function;
    function __construct() {

        parent::__construct();
        $this->module_folder = "general";
        $this->load->model('survey_model');
        $this->load->model('general_model');
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'lms/survey');
    }

    public function index(){
        $this->page_title = "Survey Lists";
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');

        $data['list'] = $this->survey_model->all_survey();
        $data['role'] = $this->general_model->get_role();
        


        if($data['role']=='admin'){
            $this->load->view('layout/header');
        }else{

            $this->load->view('layout/student/header');
        }

        $this->load->view('lms/survey/index', $data);
        $this->load->view('layout/footer');
    }

    public function assigned(){
        $this->page_title = "Assigned";
        $this->data = $this->survey_model->assigned_survey($this->session->userdata('id'));
        $this->sms_view(__FUNCTION__);
    }

    public function respond($id){
        $data['survey_id'] = $id;
        $data['id'] = $id;

        $data['survey'] = $this->survey_model->lms_get("lms_survey",$id,"id");
        $data['account_id'] = $this->general_model->get_account_id();
        $this->db->select("*");
        $this->db->where("account_id", $data['account_id']);
        $this->db->where("survey_id",$id);
        $this->db->where("response_status",1);
        $query = $this->db->get("lms_survey_sheets");
        $response = $query->result_array();
        $data['survey'] = $this->survey_model->lms_get("lms_survey",$id,"id")[0];
        // echo "pre";
        // print_r($data);
        // exit();
        $data['resources'] = site_url('backend/lms/');
            
        if(!empty($response)){
            echo "<script>alert('Survey has already been responded Account ID:".$data['account_id']."');window.location.replace('".site_url('lms/survey/index')."')</script>";
            
            $this->load->view('lms/survey/respond', $data);
        }else{
            $this->db->select("*");
            $this->db->where("account_id",$data['account_id']);
            $this->db->where("survey_id",$id);
            $new_query = $this->db->get("lms_survey_sheets");
            $new_response = $new_query->result_array();
            if(empty($new_response)){
                $survey_data['survey_id'] = $id;
                $survey_data['account_id'] = $data['account_id'];
                $this->survey_model->lms_create("lms_survey_sheets",$survey_data);
                
            }
            $this->load->view('lms/survey/respond', $data);
        }
        
    }

    public function save(){
        
        $data['survey_name'] = $_REQUEST['survey_name'];
        $data['account_id'] = $this->customlib->getStaffID();
        $survey_id = $this->survey_model->lms_create("lms_survey",$data);

        redirect(site_url()."lms/survey/edit/".$survey_id);
    }

    public function edit($id){
        $data['id'] = $id;
        $data['survey'] = $this->survey_model->lms_get("lms_survey",$id,"id")[0];
        $data['resources'] = site_url('backend/lms/');

        $this->load->view('lms/survey/edit', $data);
    }

    public function update(){
        $data['id'] = $_REQUEST['id'];
        $data['sheet'] = $_REQUEST['sheet'];


        $this->survey_model->lms_update("lms_survey",$data);
    }

    public function update_survey_sheet(){
        $data['survey_id'] = $_REQUEST['survey_id'];
        $data['respond'] = $_REQUEST['respond'];
        $data['account_id'] = $_REQUEST['account_id'];
        $data['response_status'] = 1;

        $this->db->select("*");
        $this->db->where("survey_id", $data["survey_id"]);
        $this->db->where("account_id", $data["account_id"]);
        $data['date_updated'] = date("Y-m-d H:i:s");
        $this->db->update("lms_survey_sheets", $data);
    }

    public function upload($id){
        
        // print_r(strpos($_FILES['survey_form']['type'], "pdf"));

        if(strpos($_FILES['survey_form']['type'], "pdf")!==0){
            $tmp_name = $_FILES['survey_form']['tmp_name'];
            $file_name = $this->survey_model->id_generator("survey").".pdf";
            $dest = FCPATH."uploads/lms_survey/".$id."/".$file_name;
            if(!is_dir(FCPATH."uploads/lms_survey/".$id)){
                mkdir(FCPATH."uploads/lms_survey/".$id);

            }

            if(move_uploaded_file($tmp_name, $dest)){
                $data['id'] = $id;
                $data['survey_file'] = $file_name;

                $this->survey_model->lms_update("lms_survey",$data);
                
                echo "<script>alert('Successfully uploaded');window.location.replace('".site_url('lms/survey/edit/'.$id)."')</script>";
            }

        }else{
            echo "<script>alert('Only PDF files are allowed');window.location.replace('".site_url('lms/survey/edit/'.$id)."')</script>";
        }
        
    }

    public function delete($id){

        if($this->survey_model->delete_survey("survey",$id)){
            $this->ben_redirect("general/survey/index");
        }
    }
}
