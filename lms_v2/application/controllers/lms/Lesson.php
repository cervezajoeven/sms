<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {

        parent::__construct();
        $this->load->model('lesson_model');
    }
    public function index()
	{
		// print_r($this->db->lms_get("lms_lesson",'lms_lesson_online_159931671568269744',"id"));
	}
	public function create($id)
	{
		echo "<pre>";
		$data['id'] = $id;
		$data['lesson'] = $this->lesson_model->lms_get("lms_lesson",$id,"id");
		$data['classes'] = $this->lesson_model->lms_get("classes",'','','id,class');
		$data['class_section'] = $this->lesson_model->lms_get("class_sections",'','','id,class_id,section_id');
		$data['role'] = $this->lesson_model->lms_get("class_sections",'','','id,class_id,section_id');
		print_r($data['class_section']);


	}
}
