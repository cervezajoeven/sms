<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson extends General_Controller {

    function __construct() {
        
        parent::__construct();
        $this->load->model('lesson_model');
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');
    }

    function index() {
        
        $this->session->set_userdata('top_menu', 'Download Center');
        $this->session->set_userdata('sub_menu', 'content/lesson');

        $data['title'] = 'Lesson';
        $data['list'] = $this->lesson_model->lms_get("lms_lesson");
        // echo "<pre>";
        // print_r($this->session->userdata());
        // exit;
        $this->load->view('layout/header');
        $this->load->view('lms/lesson/index', $data);
        $this->load->view('layout/footer');
    }

    function save(){

        $data = array("lesson_name"=>$_REQUEST['content_title']);
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
        print_r($data);
        $this->lesson_model->lms_update("lms_lesson",$data);
        

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
    

}
 
?>