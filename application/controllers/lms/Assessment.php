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
        $this->load->library('customlib');
        $this->load->library('mailsmsconf');
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'lms/assessment');
        date_default_timezone_set('Asia/Manila');
    }

    public function index(){

        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/assessment');

        $data['role'] = $this->general_model->get_role();
        $data['real_role'] = $this->general_model->get_real_role();


        if($data['role']=='admin'){

            $this->load->view('layout/header');
            if($data['real_role']==7){
                $data['list'] = $this->assessment_model->admin_all_assessment($this->general_model->get_account_id());
            }else{
                $data['list'] = $this->assessment_model->all_assessment($this->general_model->get_account_id());
            }
            
        }else{

            $data['list'] = $this->assessment_model->assigned_assessment($this->general_model->get_account_id());
            $this->load->view('layout/student/header');
        }

        $this->load->view('lms/assessment/index', $data);
        $this->load->view('layout/footer');
    }

    public function reports($assessment_id){

        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/assessment');
        $data['list'] = $this->assessment_model->all_assessment();

        $data['role'] = $this->general_model->get_role();
        $current_session = $this->setting_model->getCurrentSession();

        $data['assessment'] = $this->assessment_model->lms_get('lms_assessment',$assessment_id,"id")[0];


        $query = $this->db
        ->select("lms_assessment_sheets.*,lms_assessment_sheets.account_id as student_id,students.firstname,students.lastname,classes.*,sections.*,lms_assessment.*,students.id as student_id,lms_assessment_sheets.id as id,lms_assessment_sheets.date_created as date_created")

        ->from("lms_assessment_sheets")
        ->join("lms_assessment","lms_assessment.id = lms_assessment_sheets.assessment_id","left")
        ->join("students","students.id = lms_assessment_sheets.account_id","left")
        ->join("student_session","lms_assessment_sheets.account_id = student_session.student_id")
        ->join("classes","classes.id = student_session.class_id","left")
        ->join("sections","sections.id = student_session.section_id","left")
        ->where("student_session.session_id",$current_session)
        ->where("lms_assessment_sheets.assessment_id", $assessment_id)
        ->where("lms_assessment_sheets.response_status", 1)
        ->order_by("lms_assessment_sheets.date_created","desc")
        // ->group_by("lms_assessment_sheets.account_id")
        ->get();
        $students = $query->result_array();

        // echo '<pre>';print_r($students);exit();
        $student_ids = array();
        $filtered_students = array();
        // echo '<pre>';
        foreach ($students as $student_key => $student_value) {
            if(array_key_exists($student_value['student_id'], $student_ids)){
                // echo "<pre>";
                if($student_ids[$student_value['student_id']]>strtotime($student_value['date_created'])){

                    $student_ids[$student_value['student_id']] = $student_value;
                    $filtered_students[$student_value['student_id']] = $student_value;
                    
                }
                
            }else{
                $student_ids[$student_value['student_id']] = $student_value['id'];
                $filtered_students[$student_value['student_id']] = $student_value;
            }
            
        }
    
        $data['students'] = $filtered_students;

        if($data['role']=='admin'){
            $this->load->view('layout/header');
        }else{

            $this->load->view('layout/student/header');
        }

        $this->load->view('lms/assessment/reports', $data);
        $this->load->view('layout/footer');
    }

    public function get_sheets($id) {
        if($id){
            $assessment = $this->assessment_model->lms_get('lms_assessment',$id,"id")[0];
            $assessment_sheets = $this->assessment_model->assessment_sheets($id);

            $json_sheet = json_decode($assessment['sheet']);
            $responses['data'] = array();
            $array_pos = 0;

            //var_dump($json_sheet[0]->type);
            foreach ($assessment_sheets as $row) {
                $json_respond = json_decode($row['answer']);
                //var_dump($json_respond);
                $answers_count['data'] = array();
                $resp_pos = 0;
                // echo '<pre>';print_r($json_respond);exit();
                if ($json_respond != null || $json_respond != '') {
                    foreach($json_respond as $respond) {
                        // var_dump($respond);
                        // echo($respond->type);
                        
                        if ($respond->type != "long_answer" && $respond->type != "short_answer" && $respond->type != "section") {

                            if (strpos($respond->answer, '1') > -1) {
                                if ($array_pos == 0) {
                                    $responses['data'][] = array (
                                        'type' => $respond->type,
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
                                        'type' => $respond->type,
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
                                'type' => $respond->type,
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
        
    }

    public function assigned(){

        $this->page_title = "Assigned";
        $this->data = $this->assessment_model->assigned_assessment($this->session->userdata('id'));
        $this->sms_view(__FUNCTION__);
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
        date_default_timezone_set('Asia/Manila');
        $data['id'] = $id;
        $data['account_id'] = $this->general_model->get_account_id();
        $data['student_data'] = $this->general_model->get_account_name($data['account_id'],"student")[0];
        $data['student_name'] = $data['student_data']['firstname']." ".$data['student_data']['lastname'];

        $this->db->select("*");
        $this->db->where("account_id", $data['account_id']);
        $this->db->where("assessment_id",$id);
        $this->db->where("response_status",1);


        $query = $this->db->get("lms_assessment_sheets");


        $response = $query->result_array();
        $attempt_data = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        
        $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        
        $data['resources'] = site_url('backend/lms/');

            
        if(count($response)>=$attempt_data['attempts']){
            echo "<script>alert('Maximum Attempts Have Been Reached! Account ID:".$data['account_id']."');window.location.replace('".site_url('lms/assessment/index')."')</script>";
            
            $this->load->view('lms/assessment/answer', $data);
        }else{
            $this->db->select("*");
            $this->db->where("account_id",$data['account_id']);
            $this->db->where("assessment_id",$id);
            $this->db->where("response_status",0);
            $new_query = $this->db->get("lms_assessment_sheets");
            $new_response = $new_query->result_array();

            // echo '<pre>';print_r(strtotime("+10 minutes",strtotime(date("Y-m-d H:i:s"))));exit();
            if(empty($new_response)){
                $assessment_data['assessment_id'] = $id;
                $assessment_data['account_id'] = $data['account_id'];
                $assessment_data['response_status'] = 0;
                $assessment_data['expiration'] = date("Y-m-d H:i:s",strtotime("+".$data['assessment']['duration']." minutes",strtotime(date("Y-m-d H:i:s"))));

                $new_assessment_id = $this->assessment_model->lms_create("lms_assessment_sheets",$assessment_data);
                $new_response = $this->assessment_model->lms_get("lms_assessment_sheets",$new_assessment_id,"id");
            }
            $data['assessment_sheet'] = $new_response[0];
            
            $this->load->view('lms/assessment/answer', $data);
        }
        
    }

    public function review($id,$account_id=""){
        $data['id'] = $id;
        if($account_id){
            $data['account_id'] = $account_id;
            $data['teacher_review'] = TRUE;
        }else{
            $data['account_id'] = $this->general_model->get_account_id();
            $data['teacher_review'] = FALSE;

        }
        

        $this->db->select("*");
        $this->db->where("account_id", $data['account_id']);
        $this->db->where("assessment_id",$id);
        $this->db->where("response_status",1);
        $this->db->order_by("date_created","desc");

        $query = $this->db->get("lms_assessment_sheets");
        $response = $query->result_array();

        $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];

        if(!$data['assessment']['allow_result_viewing']||$data['assessment']['allow_result_viewing']==0){
            if($account_id){
                
            }else{
                redirect(site_url('lms/assessment/index'));
            }
        }

        $data['resources'] = site_url('backend/lms/');
        $data['student_data'] = $this->general_model->get_account_name($data['account_id'],"student")[0];
        $data['assessment_sheet'] = $response[0];
        
        $this->load->view('lms/assessment/review', $data);
        
        
    }

    public function update(){
        $data['id'] = $_REQUEST['id'];
        $data['sheet'] = $_REQUEST['sheet'];
        $data['assigned'] = $_REQUEST['assigned'];
        $data['duration'] = $_REQUEST['duration'];
        $data['percentage'] = $_REQUEST['percentage'];
        $data['attempts'] = $_REQUEST['attempts'];
        $data['start_date'] = $_REQUEST['start_date'];
        $data['end_date'] = $_REQUEST['end_date'];
        $data['email_notification'] = $_REQUEST['email_notification'];
        $data['allow_result_viewing'] = $_REQUEST['allow_result_viewing'];
        $sheet = (array)json_decode($data['sheet']);

        if($data['email_notification']=="1"){
            $sender_details = array('student_id' => 1, 'contact_no' => '+639953230083', 'email' => 'cervezajoeven@gmail.com');
            $this->mailsmsconf->mailsms('assessment_assigned', $sender_details);

        }
        // print_r($data['email_notification']);
        $total_score = 0;
        //convert to array
        foreach ($sheet as $answer_key => $answer_value) {
            if($answer_value->type!="section"){
                $sheet[$answer_key] = (array)$answer_value;

                $total_score +=$sheet[$answer_key]['points'];
            }
            
        }
        //convert to array
        $data['total_score'] = $total_score;
        $this->assessment_model->lms_update("lms_assessment",$data);
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
        $data['deleted'] = 1;
        if($this->assessment_model->lms_update("lms_assessment",$data)){
            redirect(site_url("lms/assessment/index"));
        }
    }

    public function answer_submit(){
        
        $data['id'] = $_REQUEST['id'];
        $data['assessment_id'] = $_REQUEST['assessment_id'];
        $data['answer'] = $_REQUEST['answer'];
        $answer = (array)json_decode($data['answer']);
        $assessment = $this->assessment_model->lms_get("lms_assessment",$data['assessment_id'],"id")[0];
        $assessment_answer = (array)json_decode($assessment['sheet']);
        
        //convert to array
        foreach ($answer as $answer_key => $answer_value) {
            $answer[$answer_key] = (array)$answer_value;
        }
        foreach ($assessment_answer as $answer_key => $answer_value) {
            $assessment_answer[$answer_key] = (array)$answer_value;
        }
        //convert to array
        $score = 0;
        $total_score = 0;
        foreach ($answer as $answer_key => $answer_value) {
            $total_score += 1;
            $assessment_value = $assessment_answer[$answer_key];
            if($answer_value['type']=="multiple_choice"||$answer_value['type']=="multiple_answer"){

                if($answer_value['answer'] == $assessment_value['correct']){
                    if(array_key_exists("points", $assessment_value)){

                        $score += $assessment_value['points'];
                    }else{

                        $score += 1;
                    }
                }
            }else if($answer_value['type']=="short_answer"){
                if(in_array(trim(strtolower($answer_value['answer'])), explode(",", trim(strtolower($assessment_value['correct']))))){
                    if(array_key_exists("points", $assessment_value)){

                        $score += $assessment_value['points'];
                    }else{

                        $score += 1;
                    }
                }
            }else{

            }

        }

        $data['score'] = $score;
        $data['response_status'] = "1";

        print_r($this->assessment_model->lms_update("lms_assessment_sheets",$data));
    }

    public function auto_save(){
        
        $data['id'] = $_REQUEST['id'];
        $data['assessment_id'] = $_REQUEST['assessment_id'];
        $data['answer'] = $_REQUEST['answer'];
        $answer = (array)json_decode($data['answer']);
        $assessment = $this->assessment_model->lms_get("lms_assessment",$data['assessment_id'],"id")[0];
        $assessment_answer = (array)json_decode($assessment['sheet']);
        
        //convert to array
        foreach ($answer as $answer_key => $answer_value) {
            $answer[$answer_key] = (array)$answer_value;
        }
        foreach ($assessment_answer as $answer_key => $answer_value) {
            $assessment_answer[$answer_key] = (array)$answer_value;
        }
        //convert to array
        $score = 0;
        $total_score = 0;
        foreach ($answer as $answer_key => $answer_value) {
            $total_score += 1;
            $assessment_value = $assessment_answer[$answer_key];
            if($answer_value['type']=="multiple_choice"||$answer_value['type']=="multiple_answer"){

                if($answer_value['answer'] == $assessment_value['correct']){
                    if(array_key_exists("points", $assessment_value)){

                        $score += $assessment_value['points'];
                    }else{

                        $score += 1;
                    }
                }
            }else if($answer_value['type']=="short_answer"){
                if(in_array(trim(strtolower($answer_value['answer'])), explode(",", trim(strtolower($assessment_value['correct']))))){
                    if(array_key_exists("points", $assessment_value)){

                        $score += $assessment_value['points'];
                    }else{

                        $score += 1;
                    }
                }
            }else{

            }

        }

        $data['score'] = $score;
        $data['response_status'] = "0";

        print_r($this->assessment_model->lms_update("lms_assessment_sheets",$data));
    }

    public function recheck_answers($id){

        $assessment = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        $students = explode(",", $assessment['assigned']);
        $this->db->select("account_id");
        $this->db->where("assessment_id",$id);
        $students = $this->db->get("lms_assessment_sheets")->result_array();
        // $students = $this->assessment_model->lms_get("lms_assessment_sheets",$id,"assessment_id");
        foreach ($students as $key => $value) {
            $students[$key] = $value['account_id'];
        }
        
        foreach ($students as $student_key => $student_value) {
            $this->db->select("MAX(date_created) as max_date");
            $this->db->where("assessment_id",$id);
            $this->db->where("account_id",$student_value);
            $this->db->where("response_status",1);
            $max_date = $this->db->get("lms_assessment_sheets")->result_array()[0]['max_date'];

            $this->db->select("id,answer,account_id");
            $this->db->where("assessment_id",$id);
            $this->db->where("account_id",$student_value);
            $this->db->where("response_status",1);
            $this->db->where("date_created", $max_date);
            $student_answer = $this->db->get("lms_assessment_sheets")->result_array()[0];
            $data['id'] = $student_answer['id'];
            $data['assessment_id'] = $assessment['id'];
            $data['answer'] = $student_answer['answer'];
            $answer = (array)json_decode($data['answer']);
            $assessment_answer = (array)json_decode($assessment['sheet']);

            //convert to array
            foreach ($answer as $answer_key => $answer_value) {
                $answer[$answer_key] = (array)$answer_value;
            }
            foreach ($assessment_answer as $answer_key => $answer_value) {
                $assessment_answer[$answer_key] = (array)$answer_value;
            }
            //convert to array
            $score = 0;
            $total_score = 0;

            foreach ($answer as $answer_key => $answer_value) {
                $total_score += 1;
                $assessment_value = $assessment_answer[$answer_key];
                if($answer_value['type']=="multiple_choice"||$answer_value['type']=="multiple_answer"){

                    if($answer_value['answer'] == $assessment_value['correct']){
                        if(array_key_exists("points", $assessment_value)){

                            $score += $assessment_value['points'];
                        }else{

                            $score += 1;
                        }
                    }
                }else if($answer_value['type']=="short_answer"){
                    if(in_array(trim(strtolower($answer_value['answer'])), explode(",", trim(strtolower($assessment_value['correct']))))){
                        if(array_key_exists("points", $assessment_value)){

                            $score += $assessment_value['points'];
                        }else{

                            $score += 1;
                        }
                    }
                }else{

                    
                    if(array_key_exists("score", $answer_value)){

                        $score += $answer_value['score'];
                    }else{
                        $score += 0;
                    }
                }

            }

            $data['score'] = $score;
            $data['response_status'] = "1";

            $this->assessment_model->lms_update("lms_assessment_sheets",$data);
        }

        // echo '<pre>';print_r($data);exit();
        
        redirect(base_url('lms/assessment/reports/').$assessment['id']);
    }

    public function check_essays($id){
        if($id){
            $data['id'] = $id;
            $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
            $data['resources'] = site_url('backend/lms/');

            $this->db->select("id,firstname,lastname");
            $this->db->where_in("id",explode(",", $data['assessment']['assigned']));
            $students = $this->db->get("students")->result_array();

            $student_answers = $this->lesson_model->lms_get("lms_assessment_sheets",$id,"assessment_id");

            foreach ($students as $student_key => $student_value) {

                foreach ($student_answers as $student_answers_key => $student_answers_value) {
                    if($student_value['id'] == $student_answers_value['account_id']){

                        $students[$student_key]['has_answered'] = 1;
                        $students[$student_key]['answer'] = $student_answers_value['answer'];
                        $students[$student_key]['assessment_sheet_id'] = $student_answers_value['id'];

                    }
                }
                
            }

            // echo '<pre>';print_r($students);exit();
            $data['students'] = $students;
            $data['classes'] = $this->class_model->getAll();
            $data['class_sections'] = $this->lesson_model->get_class_sections();

            $this->load->view('lms/assessment/check_essays', $data);
        }
    }

    public function fetch_essays($id,$account_id){
        if($id){

            $data['id'] = $id;
            $data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
            $this->db->select("MAX(date_created) as max_date");
            $this->db->where("assessment_id",$id);
            $this->db->where("account_id",$account_id);
            $this->db->where("response_status",1);
            $max_date = $this->db->get("lms_assessment_sheets")->result_array()[0]['max_date'];
            
            $this->db->select("*");
            $this->db->where("assessment_id",$id);
            $this->db->where("account_id",$account_id);
            $this->db->where("response_status",1);
            $this->db->where("date_created", $max_date);

            $student_answers = $this->db->get("lms_assessment_sheets")->result_array()[0];

            // foreach ($students as $student_key => $student_value) {

            //     foreach ($student_answers as $student_answers_key => $student_answers_value) {
            //         if($student_value['id'] == $student_answers_value['account_id']){

            //             $students[$student_key]['has_answered'] = 1;
            //             $students[$student_key]['answer'] = $student_answers_value['answer'];

            //         }
            //     }
                
            // }

            echo json_encode($student_answers);

        }
    }

    public function update_essay(){
        $data['id'] = $_REQUEST['assessment_sheet_id'];
        $data['answer'] = json_encode($_REQUEST['updated_answer']);
        $this->lesson_model->lms_update("lms_assessment_sheets",$data,"id");
    }

    public function analysis($id){
        $this->page_title = "Item Analysis";
        $assessment_sheets = $this->assessment_model->assessment_sheets($id);
        $assessment = $this->assessment_model->lms_get("lms_assessment",$id,"id")[0];
        $data['data'] = $assessment_sheets;
        $data['assessment'] = $assessment;
        // echo '<pre>';print_r(json_decode($assessment['sheet']));exit();
        // $data['id'] = $id;
        $data['resources'] = site_url('backend/lms/');

        $this->load->view('lms/assessment/analysis', $data);
    }
}
