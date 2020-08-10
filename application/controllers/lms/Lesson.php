<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson extends General_Controller {

    function __construct() {
        
        parent::__construct();
        $this->load->model('lesson_model');
        $this->load->model('general_model');
        $this->load->model('discussion_model');
        $this->load->library('mailsmsconf');
        $this->load->model(array('conference_model', 'conferencehistory_model'));
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');
    }

    function index($lesson_query="upcoming") {

        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');

        $data['title'] = 'Lesson';

        $data['role'] = $this->general_model->get_role();
        $data['real_role'] = $this->general_model->get_real_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 

        if($data['role']=='admin'){
            $this->load->view('layout/header');
            if($data['real_role']=="7"||$data['real_role']=="1"){
                $data['list'] = $this->lesson_model->admin_lessons($this->general_model->get_account_id());
                foreach ($data['list'] as $key => $value) {
                    if($value['zoom_id']){
                        $zoom_data = $this->lesson_model->lms_get("conferences",$value['zoom_id'],"id")[0];
                        $data['list'][$key]['student_zoom_link'] = json_decode($zoom_data['return_response'])->join_url;

                    }
                    
                    $teacher_info = $this->lesson_model->lms_get("staff",$value['account_id'],"id")[0];
                    $data['list'][$key]['teacher_name'] = $teacher_info['name'];
                    $data['list'][$key]['google_meet'] = $teacher_info['google_meet'];
                    

                }
            }else{
                $data['list'] = $this->lesson_model->get_lessons($this->general_model->get_account_id());
            }
            
            
        }else{

            $data['lesson_query'] = $lesson_query;
            $this->load->view('layout/student/header');
            if($lesson_query == "upcoming"){
                $data['list'] = $this->lesson_model->student_lessons($this->general_model->get_account_id());

            }else{

            }
            foreach ($data['list'] as $key => $value) {
                if($value['zoom_id']){
                    $zoom_data = $this->lesson_model->lms_get("conferences",$value['zoom_id'],"id")[0];
                    $data['list'][$key]['student_zoom_link'] = json_decode($zoom_data['return_response'])->join_url;

                }
                
                $teacher_info = $this->lesson_model->lms_get("staff",$value['account_id'],"id")[0];
                $data['list'][$key]['teacher_name'] = $teacher_info['name'];
                $data['list'][$key]['google_meet'] = $teacher_info['google_meet'];
                

            }

        }
        
        $this->load->view('lms/lesson/index', $data);
        $this->load->view('layout/footer');
    }

    function get_zoom_data($id=""){

        // if($id){
        //     return $this->lesson_model->lms_get("conferences",$id,"id")[0];
        // }else{
        //     return "";
        // }
        
    }

    function shared() {
        
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/shared_lesson');

        $data['title'] = 'Lesson';

        $data['role'] = $this->general_model->get_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 

        if($data['role']=='admin'){
            $this->load->view('layout/header');
            $data['list'] = $this->lesson_model->get_shared_lessons($this->general_model->get_account_id());
            
        }else{

            $this->load->view('layout/student/header');
            $data['list'] = $this->lesson_model->student_lessons($this->general_model->get_account_id());
        }

        
        $this->load->view('lms/lesson/shared', $data);
        $this->load->view('layout/footer');
    }

    function virtual() {
        
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/virtual');

        $data['title'] = 'Lesson';

        $data['role'] = $this->general_model->get_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 

        if($data['role']=='admin'){
            $this->load->view('layout/header');
            $data['list'] = $this->lesson_model->get_lessons_virtual_only($this->general_model->get_account_id());
            
        }else{

            $this->load->view('layout/student/header');
            $data['list'] = $this->lesson_model->student_lessons($this->general_model->get_account_id());
        }

        
        $this->load->view('lms/lesson/virtual', $data);
        $this->load->view('layout/footer');
    }

    function save($lesson_type="classroom"){

        $data['lesson_name'] = $_REQUEST['content_title'];
        $data['subject_id'] = $_REQUEST['subject'];
        $data['grade_id'] = $_REQUEST['grade'];
        $data['education_level'] = $_REQUEST['education_level'];
        $data['term'] = $_REQUEST['term'];
        $data['lesson_type'] = $lesson_type;
        $data['account_id'] = $this->general_model->get_account_id();
        $data['google_meet'] = $this->general_model->get_account_name($data['account_id'],"admin")[0]['google_meet'];
        $lesson_data = array(
            "account_id" => $this->general_model->get_account_id(),
            "name" => $_REQUEST['content_title'],
        );

        // $zoom_id = $this->add_lms_lesson($lesson_data);
        // $data['zoom_id'] = $zoom_id;

        $id = $this->lesson_model->lms_create("lms_lesson",$data);
        
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){

            mkdir(FCPATH."uploads/lms_lesson/".$id);
            
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }


        
        redirect(site_url()."lms/lesson/create/".$id);
    }

    function create($id){

        $data['id'] = $id;

        $data['link'] = $this->lesson_model->lms_get("lms_lesson",$id,"id");
        $current_session = $this->setting_model->getCurrentSession();
        $data['students'] = $this->lesson_model->get_students("lms_lesson",$id,"id");
        $data['classes'] = $this->class_model->getAll();
        $data['class_sections'] = $this->lesson_model->get_class_sections();
        $data['role'] = $this->general_model->get_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 

        $data['account_id'] = $this->general_model->get_account_id();
        $data['google_meet'] = $this->general_model->get_account_name($data['account_id'],"admin")[0]['google_meet'];
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];
        $data['conference'] = $this->lesson_model->lms_get("conferences",$data['lesson']['zoom_id'],"id")[0];
        $data['start_url'] = json_decode($data['conference']['return_response'])->start_url;
        $data['lms_google_meet'] = $data['lesson']['google_meet'];
        if($data['google_meet']==""){
            $data['virtual_status'] = "available";
        }else{
            $data['virtual_status'] = "not_available";
        }
        if($data['role']!="student"){
            if($data['google_meet'] != $data['lms_google_meet']){

                $update_google_meet_data['google_meet'] = $data['google_meet'];
                $update_google_meet_data['id'] = $data['id'];
                $this->lesson_model->lms_update("lms_lesson",$update_google_meet_data);
            }

        }else{
            $lesson_log_data['lesson_id'] = $id;
            $lesson_log_data['account_id'] = $this->general_model->get_account_id();
            $lesson_log_data['session_id'] = $this->setting_model->getCurrentSession();
            $this->lesson_model->lms_create("lms_lesson_logs",$lesson_log_data);
        }
        
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];
        

        $data['resources'] = site_url('backend/lms/');
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){
            mkdir(FCPATH."uploads/lms_lesson/".$id);
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }
        $this->load->view('lms/lesson/create', $data);
        
    }

    function show($id){

        $data['id'] = $id;
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];

        $data['link'] = $this->lesson_model->lms_get("lms_lesson",$id,"id");
        $current_session = $this->setting_model->getCurrentSession();
        $data['students'] = $this->lesson_model->get_students("lms_lesson",$id,"id");
        $data['classes'] = $this->class_model->getAll();
        $data['class_sections'] = $this->lesson_model->get_class_sections();
        $data['role'] = $this->general_model->get_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 
        // echo "<pre>";
        // print_r($data['role']);
        // exit();
        $data['resources'] = site_url('backend/lms/');
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){
            mkdir(FCPATH."uploads/lms_lesson/".$id);
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }
        $this->load->view('lms/lesson/show', $data);
        
    }

    function import($id){

        $data['id'] = $id;
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];
        $data['lesson']['account_id'] = $this->general_model->get_account_id();
        $data['lesson']['shared'] = 0;
        unset($data['lesson']['id']);
        unset($data['lesson']['assigned']);
        $this->lesson_model->lms_create("lms_lesson",$data['lesson']);
        $data['resources'] = site_url('backend/lms/');
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){
            mkdir(FCPATH."uploads/lms_lesson/".$id);
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }
        redirect(site_url()."lms/lesson/index/".$id);
        // $this->load->view('lms/lesson/show', $data);
        
    }

    function view($id){

        $data['id'] = $id;
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];
        $data['link'] = $this->lesson_model->lms_get("lms_lesson",$id,"id");
        $current_session = $this->setting_model->getCurrentSession();
        $data['students'] = $this->lesson_model->get_students("lms_lesson",$id,"id");
        $data['classes'] = $this->class_model->getAll();
        $data['class_sections'] = $this->lesson_model->get_class_sections();
        $data['role'] = $this->general_model->get_role();
        
        // echo "<pre>";
        // print_r($data['students']);
        // exit();
        $data['resources'] = site_url('backend/lms/');
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){
            mkdir(FCPATH."uploads/lms_lesson/".$id);
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }
        $this->load->view('lms/lesson/create', $data);
        
    }

    public function update(){

        $data['id'] = $_REQUEST['id'];
        $data['lesson_name'] = $_REQUEST['title'];
        $data['content_order'] = json_encode($_REQUEST['content_order']);
        $data['content_pool'] = json_encode($_REQUEST['content_pool']);
        $data['folder_names'] = $_REQUEST['folder_names'];
        $data['assigned'] = $_REQUEST['assigned'];
        $data['email_notification'] = $_REQUEST['email_notification'];
        $data['lesson_type'] = $_REQUEST['lesson_type'];
        $data['start_date'] = $_REQUEST['start_date'];
        $data['end_date'] = $_REQUEST['end_date'];
        $data['learning_plan'] = $_REQUEST['learning_plan'];
        $data['subject_id'] = $_REQUEST['subject_id'];
        $data['grade_id'] = $_REQUEST['grade_id'];
        $data['education_level'] = $_REQUEST['education_level'];
        $data['term'] = $_REQUEST['term'];
        $data['shared'] = $_REQUEST['shared'];
        $data['allow_view'] = $_REQUEST['allow_view'];
        
        
        


        print_r($this->lesson_model->lms_update("lms_lesson",$data));
        

        // thumbnails
        // $this->db->select("content_id");
        // $this->db->where("table_id","thumbnail_".$data['id']);
        // $query = $this->db->get("resources_queue");
        // $thumbnails_result = $query->result_array();
        // $thumbnails = [];
        // foreach ($thumbnails_result as $key => $value) {
        //     array_push($thumbnails, $value['content_id']);
        // }

        // foreach ($_REQUEST['content_pool'] as $key => $value) {
        //     if(!in_array($value['content']['result_id'], $thumbnails)){
        //         $download_data['table_id'] = "thumbnail_".$data['id'];
        //         $download_data['file_type'] = "image";
        //         $download_data['content_id'] = $value['content']['result_id'];
        //         $download_data['url'] = urldecode($value['content']['image']);
        //         $download_data['output_path'] = "C:\\xampp\htdocs\campus\\resources\uploads\blackboard\\".$data['id']."\\thumbnails\\";
        //         $type = $this->check_url_type($value['content']['image']);
        //         $download_data['filename'] = $value['content']['result_id'];
        //         $download_data['completed'] = 0;
        //         $download_data['status'] = "download";

        //         $this->lesson_model->lms_create("resources_queue",$download_data);
        //     }
            

        // }
        //thumbnails

        //contents
        // $this->db->select("content_id");
        // $this->db->where("table_id",$data['id']);
        // $query = $this->db->get("resources_queue");
        // $content_result = $query->result_array();
        // $contents = [];
        // foreach ($content_result as $key => $value) {
        //     array_push($contents, $value['content_id']);
        // }
        // foreach ($_REQUEST['content_pool'] as $key => $value) {
            

        //     if(!in_array($value['content']['result_id'], $contents)){

        //         $download_data['output_path'] = "C:\\xampp\htdocs\campus\\resources\uploads\blackboard\\".$data['id']."\\contents\\";
        //         $download_data['filename'] = $value['content']['result_id'];
        //         $download_data['table_id'] = $data['id'];
        //         $download_data['content_id'] = $value['content']['result_id'];
        //         $download_data['completed'] = 0;

        //         if($value['content']['type'] == "youtube"){
        //             $download_data['file_type'] = "video";
        //             $download_data['url'] = $this->youtube($value['content']['source']);
        //         }else{
        //             $download_data['file_type'] = urldecode($value['content']['type']);
        //             $download_data['url'] = urldecode($value['content']['source']);
        //         }
                
        //         if($value['content']['type'] == "website"){
        //             $download_data['status'] = "convert";

        //         }else{
        //             $download_data['status'] = "download";
        //         }
                

        //         if($download_data['url']!=""){
        //             $this->blackboard_model->create_new("resources_queue",$download_data);
        //         }
                
        //     }
            

        // }
        //contents
    }

    public function send_email_notification(){
        $student_ids = $_REQUEST['student_ids'];
        $lesson_id = $_REQUEST['lesson_id'];
        $email_notification = $_REQUEST['email_notification'];

        // $student_ids = array("852","854","863","900");
        // $lesson_id = "lms_lesson_online_159670778980833632";
        // $email_notification = "true";
        // echo "<pre>";



        $lesson = $this->lesson_model->lms_get("lms_lesson",$lesson_id,"id")[0];
        $teacher = $this->lesson_model->lms_get("staff",$lesson['account_id'],"id")[0];

        if($email_notification=="true"){
            foreach($student_ids as $student_id_key => $student_id_value) {

                $students = $this->lesson_model->lms_get("students",$student_id_value,"id")[0];
                $credentials = $this->lesson_model->lms_get("users",$student_id_value,"user_id")[0];
                $sender_details['id'] = $student_id_value;
                $sender_details['email'] = "cervezajoeven@gmail.com";
                $sender_details['student_name'] = $students['firstname']." ".$students['lastname'];
                $sender_details['lesson_title'] = $lesson['lesson_name'];
                $sender_details['start_date'] = date("F d, Y h:i A",strtotime($lesson['start_date']));
                $sender_details['lesson_type'] = ($lesson['lesson_type']=="virtual")?"Google Meet":ucfirst($lesson['lesson_type']);
                $sender_details['teacher_name'] = $teacher['name']." ".$teacher['surname'];
                $sender_details['school_url_login_page'] = base_url('site/userlogin');
                $sender_details['username'] = $credentials['username'];
                $sender_details['password'] = $credentials['password'];

                $this->mailsmsconf->mailsms('lesson_assigned', $sender_details);
            }
        }
    }

    public function delete($id){

        $data['id'] = $id;
        $data['deleted'] = 1;
        $this->lesson_model->lms_update("lms_lesson",$data);
        // print_r();

        redirect(site_url()."lms/lesson/index/");
    
    }

    public function get($id){

        echo json_encode($this->lesson_model->lms_get("lms_lesson",$id,"id")[0]);

    }

    public function my_resources($search=""){
        $account_id = $this->session->userdata('admin')['id'];
        $search_result = $this->lesson_model->search_my_resources($account_id,$search);
        echo json_encode($search_result);

    }

    public function cms_resources($search=""){
        $account_id = $this->session->userdata('admin')['id'];
        $search_result = $this->lesson_model->search_cms_resources($account_id,$search);
        echo json_encode($search_result);

    }

    public function send_email_parent(){
        $this->db->select("*");
        $query = $this->db->get("students");
        $result = $query->result_array();
        echo "<pre>";
        $current_session = $this->setting_model->getCurrentSession();
        print_r("current session: ".$current_session);

        foreach ($result as $key => $value) {
            //for parent notification
            // $sender_details = array('student_id' => $value['id'], 'email' => 'cervezajoeven@gmail.com');
            $sender_details = array('id' => $value['id'], 'email' => $value['email']);
            
            print_r($sender_details);
            $this->mailsmsconf->mailsms('parent_notification', $sender_details);
        }
        
    }

    public function send_email_old_accounts(){
        $this->db->select("*");
        $query = $this->db->get("students");
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            //for parent notification
            // $sender_details = array('student_id' => $value['id'], 'email' => $value['email']);
            $sender_details = array('id' => $value['id'], 'email' => $value['email']);
            $this->mailsmsconf->mailsms('old_student_account', $sender_details);
        }
        
    }

    public function send_admission_details($id){

        $student = $this->lesson_model->lms_get("students",$id,"id")[0];
        $sender_details = array('student_id' => $student['id'], 'email' => $student['guardian_email']);
        $this->mailsmsconf->mailsms('student_admission', $sender_details);
    }

    public function send_login_credential($id){

        $student = $this->lesson_model->lms_get("students",$id,"id")[0];
        $sender_details = array('id' => $student['id'], 'email' => $student['guardian_email'],"credential_for"=>"student","resend"=>true);

        $this->mailsmsconf->mailsms('login_credential', $sender_details);
    }

    public function upload($upload_type="my_resources",$lesson_id=""){
        if($upload_type=="my_resources"){
            $file = $_FILES['upload_file'];

            foreach ($file['name'] as $key => $value) {



                $data['name'] = $value;

                $path_parts = pathinfo($file["name"][$key]);
                $extension = $path_parts['extension'];
                $image_array = array("png","jpg","jpeg","svg","gif");
                $video_array = array("mp4");
                if(in_array($extension, $image_array)){
                    $data['type'] = "image";
                }elseif(in_array($extension, $video_array)){
                    $data['type'] = "video";
                }else{
                    $data['type'] = $extension;
                }
                

                $data['description'] = "";
                $data['text_value'] = "";
                $data['lms_lesson_ids'] = $lesson_id;
                $data['shared'] =  0;

                if($upload_type=="my_resources"){
                    $data['account_id'] = $this->session->userdata('admin')['id'];
                    
                    if(!is_dir(FCPATH."uploads/lms_my_resources/".$data['account_id'])){

                        if(mkdir(FCPATH."uploads/lms_my_resources/".$data['account_id'])){

                            
                        }
                    }
                    $filename = $this->lesson_model->filename_generator().".".$extension;
                    if(move_uploaded_file($file['tmp_name'][$key], FCPATH."uploads/lms_my_resources/".$data['account_id']."/".$filename)){
                        $data['filename'] = $filename;
                        $data['link'] =  $data['account_id']."/".$filename;
                        
                        $id = $this->lesson_model->lms_create("lms_my_resources",$data);
                    }
                }
                
            }
        }elseif($upload_type=="add_text"){
            $data['name'] = $_REQUEST['title'];
            $data['type'] = "text";
            $data['description'] = "";
            $data['text_value'] = $_REQUEST['text_value'];
            $data['account_id'] = $this->session->userdata('admin')['id'];
            $data['lms_lesson_ids'] = $lesson_id;
            $data['shared'] =  0;
            $id = $this->lesson_model->lms_create("lms_my_resources",$data);
            print_r($id);
        }

        elseif($upload_type=="vimeo"){
            
            $data['name'] = $_REQUEST['name'];
            $data['type'] = $_REQUEST['type'];

            if (strpos($_REQUEST['link'], 'vimeo.com') !== false) {
                $data['link'] = "https://player.vimeo.com/video/".explode("/", $_REQUEST['link'])[3];
                $data['type'] = "youtube";
            }else if(strpos($_REQUEST['link'], 'youtube.com') !== false){

                $data['link'] = "https://www.youtube.com/embed/".explode("?v=", $_REQUEST['link'])[1];
                $data['type'] = "youtube";
                $data['image'] = "https://i.ytimg.com/vi/".explode("?v=", $_REQUEST['link'])[1]."/maxresdefault.jpg";

            }else{

                $data['link'] = $_REQUEST['link'];
                $data['type'] = "website";
            }
            
            // $data['link'] = $_REQUEST['link'];
            $data['description'] = $_REQUEST['description'];
            $data['account_id'] = $this->session->userdata('admin')['id'];
            $data['lms_lesson_ids'] = $lesson_id;
            $data['shared'] =  0;
            $id = $this->lesson_model->lms_create("lms_my_resources",$data);
            print_r($data['link']);
        }
        

         
    }

    public function send_chat(){

        $data['account_id'] = $this->general_model->get_account_id();
        $data['account_type'] = $this->general_model->get_role();
        $data['content'] = $_REQUEST['content'];
        $data['lesson_id'] = $_REQUEST['lesson_id'];

        $this->lesson_model->lms_create("lms_discussion",$data);

    }
    
    public function fetch_chat(){
        
        // $lesson_id = $_REQUEST['lesson_id'];
        // $discussion = $this->discussion_model->lesson_discussion($lesson_id);
        
        // $new_discussion = [];
        
        // foreach ($discussion as $key => $value) {
        //     $profile = $this->general_model->get_account_name($value['account_id'],$value['account_type'])[0];
        //     if($value['account_type']=="student"){
        //         $discussion[$key]['firstname'] = $profile['firstname'];
        //         $discussion[$key]['lastname'] = $profile['lastname'];
        //     }else{
        //         $discussion[$key]['firstname'] = $profile['name'];
        //         $discussion[$key]['lastname'] = $profile['surname'];
        //     }
            
        //     // print_r($discussion);
        // }

        // echo json_encode($discussion);

    }

    public function add_lms_lesson($lesson_data=array()) {

        $api_type = 'global';


        $params = array(
            'zoom_api_key' => $lesson_data['zoom_api_key'],
            'zoom_api_secret' => $lesson_data['zoom_api_secret'],
        );
        $this->load->library('zoom_api', $params);
        $account_data = $this->lesson_model->lms_get("staff",$lesson_data['account_id'],"id")[0];
        $title = $this->lesson_model->lms_get("lms_lesson",$lesson_data['lesson_id'],"id")[0]['lesson_name'];
        $zoom_email = $lesson_data['zoom_email'];
        

        $insert_array = array(
            'staff_id' => $lesson_data['account_id'],
            'title' => $title,
            'date' => $lesson_data['start_date'],
            'zoom_email' => trim($zoom_email),
            'class_id' => 3,
            'section_id' => 63,
            'duration' => 60,
            'password' => "cloudph",
            'created_id' => $lesson_data['account_id'],
            'api_type' => $api_type,
            'host_video' => "1",
            'client_video' => "1",
            'description' => "Zoom Class",
            'timezone' => $this->customlib->getTimeZone(),
        );

        $response = $this->zoom_api->createAMeeting($insert_array);
        // print_r($insert_array);
        // echo "response";
        // print_r($response);
        if ($response) {
            if (isset($response->id)) {
                $insert_array['return_response'] = json_encode($response);
                $zoom_id = $this->conference_model->add($insert_array);

                $sender_details = array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'title' => $this->input->post('title'), 'date' => $this->input->post('date'), 'duration' => $this->input->post('duration'));
                $this->mailsmsconf->mailsms('online_classes', $sender_details);

                $response = array('status' => 1, 'message' => $this->lang->line('success_message'));
            } else {
                $response = array('status' => 0, 'error' => array($response->message));
            }
        } else {
            $response = array('status' => 0, 'error' => array('Something went wrong.'));
        }

        return $zoom_id;
    }

    public function check_zoom_schedule(){

        // $start_date = $_POST['start_date'];
        // $end_date = $_POST['end_date'];
        // $lesson_id = $_POST['lesson_id'];
        // $account_id = $_POST['account_id'];

        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $lesson_id = $_REQUEST['lesson_id'];
        $account_id = $_REQUEST['account_id'];

        $converted_start_date = date("Y-m-d",strtotime($start_date));
        $converted_end_date = date("Y-m-d",strtotime($end_date));

        $this->db->select("id,lesson_name,lesson_type,start_date,end_date,zoom_account_id");
        $this->db->from("lms_lesson");
        $this->db->or_where("start_date LIKE '%".$converted_start_date."%'");
        $this->db->or_where("end_date LIKE '%".$converted_end_date."%'");
        $this->db->where("id !=",$lesson_id);
        $this->db->where("lesson_type","zoom");

        // echo "<pre>";
        // print_r($start_date);
        // echo "\n";
        // print_r($end_date);
        // echo "\n";
        // print_r($lesson_id);
        // echo "\n";

        $lesson_schedules = $this->db->get()->result_array();
        // echo "<pre>";
        // print_r($lesson_schedules);
        // exit;
        $conflict_zoom_ids = array();

        foreach ($lesson_schedules as $lesson_schedules_key => $lesson_schedules_value) {

            if($lesson_id!=$lesson_schedules_value['id']){
                if($lesson_schedules_value['lesson_type']=="zoom"){
                    $startTime = strtotime($start_date);
                    $endTime   = strtotime($end_date);
                    // print_r($startTime);
                    // echo "\n";
                    // print_r($endTime);
                    // echo "\n";
                    // print_r($lesson_id);
                    // echo "\n";
                    $chkStartTime = strtotime($lesson_schedules_value['start_date']);
                    $chkEndTime   = strtotime($lesson_schedules_value['end_date']);

                    if($chkStartTime > $startTime && $chkEndTime < $endTime)
                    {   #-> Check time is in between start and end time
                        // echo "1 Time is in between start and end time";
                        // print_r($lesson_schedules_value);
                        // echo "<br>";
                        if(!in_array($lesson_schedules_value['zoom_account_id'], $conflict_zoom_ids)){
                            array_push($conflict_zoom_ids,$lesson_schedules_value['zoom_account_id']);
                        }
                    }elseif(($chkStartTime > $startTime && $chkStartTime < $endTime) || ($chkEndTime > $startTime && $chkEndTime < $endTime))
                    {   #-> Check start or end time is in between start and end time
                        // echo "2 ChK start or end Time is in between start and end time";
                        // print_r($lesson_schedules_value);
                        // echo "<br>";
                        if(!in_array($lesson_schedules_value['zoom_account_id'], $conflict_zoom_ids)){
                            array_push($conflict_zoom_ids,$lesson_schedules_value['zoom_account_id']);
                        }
                    }elseif($chkStartTime==$startTime || $chkEndTime==$endTime)
                    {   #-> Check start or end time is at the border of start and end time
                        // echo "3 ChK start or end Time is at the border of start and end time";
                        // print_r($lesson_schedules_value);
                        // echo "<br>";
                        if(!in_array($lesson_schedules_value['zoom_account_id'], $conflict_zoom_ids)){
                            array_push($conflict_zoom_ids,$lesson_schedules_value['zoom_account_id']);
                        }
                    }elseif($startTime < $chkStartTime && $endTime > $chkEndTime)
                    {   #-> start and end time is in between  the check start and end time.
                        // echo "4 start and end Time is overlapping  chk start and end time";
                        // print_r($lesson_schedules_value);
                        // echo "<br>";
                        if(!in_array($lesson_schedules_value['zoom_account_id'], $conflict_zoom_ids)){
                            array_push($conflict_zoom_ids,$lesson_schedules_value['zoom_account_id']);
                        }
                    }
                }
                
            }
            

            
        }
        $this->db->select("id,email,api_key,api_secret");
        $this->db->from("lms_zoom_accounts");
        $this->db->where("owner","school");
        if(!empty($conflict_zoom_ids)){
            $this->db->where_not_in("id",$conflict_zoom_ids);
        }
        
        $lms_zoom_accounts = $this->db->get()->result_array();

        if(empty($lms_zoom_accounts)){
            $json_encode = array("status"=>"full","message"=>"There is no available zoom account for this schedule.");
            echo json_encode($json_encode);
        }else{
            
            
            $lesson_data['zoom_api_key'] = $lms_zoom_accounts[0]['api_key'];
            $lesson_data['zoom_api_secret'] = $lms_zoom_accounts[0]['api_secret'];
            $lesson_data['account_id'] = $account_id;
            $lesson_data['lesson_id'] = $lesson_id;
            $lesson_data['start_date'] = $start_date;
            $lesson_data['zoom_email'] = $lms_zoom_accounts[0]['email'];
            // print_r($lms_zoom_accounts);
            $this->add_lms_lesson($lesson_data);
            $lesson_update['id'] = $lesson_id;
            $lesson_update['zoom_account_id'] = $lms_zoom_accounts[0]['id'];
            $lesson_update['zoom_id'] = $this->add_lms_lesson($lesson_data);
            $this->lesson_model->lms_update("lms_lesson",$lesson_update);

            $json_encode = array("status"=>"success","message"=>"Successful! You are assigned to ".$lms_zoom_accounts[0]['email']);
            $json_encode['zoom_email'] = $lms_zoom_accounts[0]['email'];
            $json_encode['start_url'] = json_decode($this->lesson_model->lms_get("conferences",$lesson_update['zoom_id'],"id")[0]['return_response'])->start_url;
            echo json_encode($json_encode);
        }

        

    }

    public function get_zoom_status($data=array()){
        $data['api_key'] = '0NP_jYnjS5WXxW5NRTZc0g';
        $data['api_secret'] = 'BsryxBYn3QYBcJM8tYw987P3aIzPKshcpJPI';
        $params = array(
            'zoom_api_key' => $data['api_key'],
            'zoom_api_secret' => $data['api_secret'],
        );
        $this->load->library('zoom_api', $params);
        echo "<pre>";
        print_r($this->zoom_api->checkStatus()->participants);
    }

    public function update_lesson_status(){

        $data['id'] = $_REQUEST['id'];
        $data['lesson_status'] = $_REQUEST['lesson_status'];
     

        print_r($this->lesson_model->lms_update("lms_lesson",$data));
    }

    public function zoom_checker($lesson_id=""){
        // echo "<pre>";

        $data['api_key'] = '0NP_jYnjS5WXxW5NRTZc0g';
        $data['api_secret'] = 'BsryxBYn3QYBcJM8tYw987P3aIzPKshcpJPI';
        $params = array(
            'zoom_api_key' => $data['api_key'],
            'zoom_api_secret' => $data['api_secret'],
        );
        $this->load->library('zoom_api', $params);
        $data['lesson_id'] = $lesson_id;

        $this->db->select("*");
        $zoom_accounts = $this->db->get("lms_zoom_accounts")->result_array();

        $live_zoom = $this->zoom_api->check_live();
        // echo "<pre>";
        // print_r($live_zoom);
        // exit;
        $live_zoom_accounts = array();
        foreach ($live_zoom->meetings as $live_zoom_key => $live_zoom_value) {
            array_push($live_zoom_accounts, $live_zoom_value->email);
            
        }
        $unavailable_zoom = array();
        $available_zoom = array();
        foreach ($zoom_accounts as $zoom_accounts_key => $zoom_accounts_value) {
            
            if(in_array($zoom_accounts_value['email'], $live_zoom_accounts)){
                
                array_push($unavailable_zoom, $zoom_accounts_value['email']);
            }else{
                array_push($available_zoom, $zoom_accounts_value);
            }
        }
        
        if(!empty($available_zoom)){
            
            $the_lesson = $this->lesson_model->lms_get("lms_lesson",$lesson_id,"id")[0];

            $lesson_data['zoom_api_key'] = $available_zoom[0]['api_key'];
            $lesson_data['zoom_api_secret'] = $available_zoom[0]['api_secret'];
            $lesson_data['account_id'] = $the_lesson['account_id'];
            $lesson_data['lesson_id'] = $lesson_id;
            $lesson_data['start_date'] = date("Y-m-d H:i:s");
            $lesson_data['zoom_email'] = $available_zoom[0]['email'];
            $conference_id = $this->add_lms_lesson($lesson_data);
            $conference = $this->lesson_model->lms_get("conferences",$conference_id,"id")[0];
            $lesson_update['id'] = $lesson_id;
            $lesson_update['zoom_id'] = $conference_id;
            $this->lesson_model->lms_update("lms_lesson",$lesson_update);
            // print_r(json_decode($conference['return_response'])->start_url);
            $data['zoom_link'] = json_decode($conference['return_response'])->start_url;
            $data['zoom_account_status'] = "You are now assigned to ".$available_zoom[0]['email'];
            $data['zoom_email'] = $available_zoom[0]['email'];
            $data['zoom_status'] = "zoom";
        }else{
            $data['zoom_status'] = "no_zoom";
            $data['zoom_account_status'] = "No Zoom Accounts Available at this time. Please refresh this page to check again.";
        }
        
        $this->load->view('lms/lesson/zoom_checker', $data);

    }

}
 
?>