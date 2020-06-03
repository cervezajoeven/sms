<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends General_Controller {
    public $current_function;
    function __construct() {

        parent::__construct();
        $this->module_folder = "general";
        $this->load->model('survey_model');
        $this->load->model('general_model');
        $this->load->model('class_model');
        $this->load->model('lesson_model');
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
        $data['students'] = $this->lesson_model->get_students();
        $data['classes'] = $this->class_model->getAll();
        $data['class_sections'] = $this->lesson_model->get_class_sections();
        $this->load->view('lms/survey/edit', $data);
    }

    public function update(){
        $data['id'] = $_REQUEST['id'];
        $data['sheet'] = $_REQUEST['sheet'];
        $data['start_date'] = $_REQUEST['start_date'];
        $data['end_date'] = $_REQUEST['end_date'];
        $data['assigned'] = $_REQUEST['assigned'];

        print_r($data);
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

    public function get_responses($id) {
        $survey = $this->survey_model->survey($id);

        $survey_responses = $this->survey_model->survey_responses($id);
        
        $json_sheet = json_decode($survey[0]['sheet']);
        $responses['data'] = array();
        $array_pos = 0;

        //var_dump($json_sheet[0]->type);
        
        foreach ($survey_responses as $row) {
            $json_respond = json_decode($row['respond']);
            //var_dump($json_respond);
            $answers_count['data'] = array();
            $resp_pos = 0;

            if ($json_respond != null || $json_respond != '') {
                foreach($json_respond as $respond) {
                    // var_dump($respond);
                    // echo($respond->type);
                    
                    if ($respond->type != "long_answer" && $respond->type != "short_answer") {
                        if (strpos($respond->answer, '1') > -1) {
                            if ($array_pos == 0) {
                                $responses['data'][] = array (
                                    'answer_choices' => explode(',', $json_sheet[$resp_pos]->option_labels),
                                    'respondents' => 1,
                                    'answers_count' =>  explode(',', $respond->answer)
                                );
                            } else {
                                $responses['data'][$resp_pos]['respondents'] = $responses['data'][$resp_pos]['respondents'] + 1;
        
                                $answer = explode(',', $respond->answer);
                                $answerIdx = 0;
                                foreach($answer as $ans) {
                                    $responses['data'][$resp_pos]['answers_count'][$answerIdx] = (string)((int)$responses['data'][$resp_pos]['answers_count'][$answerIdx] + (int)$ans);
                                    $answerIdx++;
                                }
                            }
                            
                        } else {
                            if ($array_pos == 0) {
                                $responses['data'][] = array (
                                    'answer_choices' => explode(',', $json_sheet[$resp_pos]->option_labels),
                                    'respondents' => 0,
                                    'answers_count' => explode(',', $respond->answer)
                                );
                            } else {
                                //
                            }
                        }
                    } else {
                        $responses['data'][] = array (
                            'answer_choices' => array(''),
                            'respondents' => 0,
                            'answers_count' =>  array('')
                        );
                    }                   
    
                    //var_dump($responses['data']);
                    $resp_pos++;
                }
            }           

            //var_dump($responses['data'][$array_pos]['respondents']);            
            $array_pos++;
        }

        //var_dump($responses['data']);
        echo json_encode($responses['data']);
    }

    public function responses($id){
        $this->page_title = "Survey Result";
        $survey_sheets = $this->survey_model->survey_sheets($id);
        $data['data'] = $survey_sheets;

        // $data['id'] = $id;
        $data['resources'] = site_url('backend/lms/');

        $this->load->view('lms/survey/responses', $data);
    }

}
