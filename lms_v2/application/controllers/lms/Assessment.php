<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends JOE_Controller {

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
        $this->load->model('assessment_model');
  }

  public function index(){

	}

	public function initialize($user_id,$role,$id){

		$userdata = array(
        'user_id'  => $user_id,
        'role'     => $role,
		);

		$this->session->set_userdata($userdata);
		redirect(site_url('lms/assessment/answer/'.$id));
	}


	public function answer($id,$tester='false'){

			// echo "<pre>";
			$data['role'] = "student";

			if($tester=='false'){
				if(!array_key_exists('user_id',$this->session->userdata())){
					echo "User was not initialized. Please go back to the previous page.";
					exit;
				}else{

					$data['role'] = $this->session->userdata('role');
					$data['account_id'] = $this->session->userdata('user_id');
				}
			}else{
				$random_students = $this->assessment_model->lms_get("students","","","id");
				$random_student = array_rand($random_students,1);

				$data['account_id'] = $random_students[$random_student]['id'];
			}

			$data['id'] = $id;
			$data['resources'] = base_url('resources/lms/');
			$data['old_resources'] = old_url('backend/lms/');


	    $data['student_data'] = $this->assessment_model->lms_get("students",$data['account_id'],"id","firstname,lastname")[0];
	    $data['student_name'] = $data['student_data']['firstname']." ".$data['student_data']['lastname'];
			$data['assessment'] = $this->assessment_model->lms_get("lms_assessment",$id,"id","id,attempts,duration,assessment_file,assessment_name,enable_timer")[0];


			$response = $this->assessment_model->response($id,$data['account_id'],1);

			if(count($response)>=$data['assessment']['attempts']){
	        echo "<script>alert('Maximum Attempts Have Been Reached! Account ID:".$data['account_id']."');window.location.replace('".site_url('lms/assessment/index')."')</script>";
	        $this->load->view('lms/assessment/answer', $data);
	    }else{

					$new_response = $this->assessment_model->response($id,$data['account_id'],0);


	        if(empty($new_response)){
	            $assessment_data['assessment_id'] = $id;
	            $assessment_data['account_id'] = $data['account_id'];
	            $assessment_data['response_status'] = 0;
	            $assessment_data['expiration'] = date("Y-m-d H:i:s",strtotime("+".$data['assessment']['duration']." minutes",strtotime(date("Y-m-d H:i:s"))));
              $assessment_data['start_date'] = date("Y-m-d H:i:s");

	            $new_assessment_id = $this->assessment_model->lms_create("lms_assessment_sheets",$assessment_data);
	            $new_response = $this->assessment_model->lms_get("lms_assessment_sheets",$new_assessment_id,"id","id,expiration");
	        }
	        $data['assessment_sheet'] = $new_response[0];

	        $this->load->view('lms/assessment/answer', $data);
	    }

	}

	public function stored_json(){
      $id = $_REQUEST['assessment_id'];
      $sheet = $this->assessment_model->lms_get('lms_assessment',$id,"id","sheet")[0]['sheet'];
      echo $sheet;
  }

	public function stored_answer(){
      $id = $_REQUEST['assessment_sheet_id'];
      $answer = $this->assessment_model->lms_get('lms_assessment_sheets',$id,"id","answer")[0]['answer'];
      echo $answer;
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
        $data['end_date'] = date("Y-m-d H:i:s");

        print_r($this->assessment_model->lms_update("lms_assessment_sheets",$data));
    }
}
