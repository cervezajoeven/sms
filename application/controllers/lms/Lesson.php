<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson extends General_Controller {

    function __construct() {
        
        parent::__construct();
        $this->load->model('lesson_model');
        $this->load->model('general_model');
        $this->load->model('discussion_model');
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');
    }

    function index() {
        
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');

        $data['title'] = 'Lesson';

        $data['role'] = $this->general_model->get_role();
        $data['classes'] = $this->general_model->get_classes();
        $data['subjects'] = $this->general_model->get_subjects(); 

        if($data['role']=='admin'){
            $this->load->view('layout/header');
            $data['list'] = $this->lesson_model->get_lessons($this->general_model->get_account_id());
            
        }else{

            $this->load->view('layout/student/header');
            $data['list'] = $this->lesson_model->student_lessons($this->general_model->get_account_id());
        }

        
        $this->load->view('lms/lesson/index', $data);
        $this->load->view('layout/footer');
    }

    function save(){

        $data['lesson_name'] = $_REQUEST['content_title'];
        $data['subject_id'] = $_REQUEST['subject'];
        $data['grade_id'] = $_REQUEST['grade'];
        $data['education_level'] = $_REQUEST['education_level'];
        $data['account_id'] = $this->general_model->get_account_id();


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
        $data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id")[0];

        $data['link'] = $this->lesson_model->lms_get("lms_lesson",$id,"id");
        $current_session = $this->setting_model->getCurrentSession();
        $data['students'] = $this->lesson_model->get_students("lms_lesson",$id,"id");
        $data['classes'] = $this->class_model->getAll();
        $data['class_sections'] = $this->lesson_model->get_class_sections();
        $data['role'] = $this->general_model->get_role();
        // echo "<pre>";
        // print_r($data['role']);
        // exit();
        $data['resources'] = site_url('backend/lms/');
        if(!is_dir(FCPATH."uploads/lms_lesson/".$id)){
            mkdir(FCPATH."uploads/lms_lesson/".$id);
            mkdir(FCPATH."uploads/lms_lesson/".$id."/thumbnails/");
            mkdir(FCPATH."uploads/lms_lesson/".$id."/contents/");
        }
        $this->load->view('lms/lesson/create', $data);
        
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
        // echo '<pre>';print_r($data);exit();
        // echo '<pre>';print_r($data);exit();
        print_r($this->lesson_model->lms_update("lms_lesson",$data));
        

        //thumbnails
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

    public function get($id){

        echo json_encode($this->lesson_model->lms_get("lms_lesson",$id,"id")[0]);

    }

    public function my_resources($search=""){
        $account_id = $this->session->userdata('admin')['id'];
        $search_result = $this->lesson_model->search_my_resources($account_id,$search);
        echo json_encode($search_result);

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
                        print_r($id);
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
        

         
    }

    public function send_chat(){

        $data['account_id'] = $this->general_model->get_account_id();
        $data['account_type'] = $this->general_model->get_role();
        $data['content'] = $_REQUEST['content'];
        $data['lesson_id'] = $_REQUEST['lesson_id'];

        $this->lesson_model->lms_create("lms_discussion",$data);

    }
    
    public function fetch_chat(){
        
        $lesson_id = $_REQUEST['lesson_id'];
        $discussion = $this->discussion_model->lesson_discussion($lesson_id);

        echo json_encode($discussion);

    }
}
 
?>