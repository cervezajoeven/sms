<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_history extends JOE_Controller {

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
        $this->load->model('payment_model');
        $this->resources = base_url("resources/payment/");
  	}

	public function initialize($user_id,$role,$function){

		$userdata = array(
        'user_id'  => $user_id,
        'role'     => $role,
		);

		$this->session->set_userdata($userdata);
    
	    if($role=="parent"){
	      redirect(site_url('payment/'.$function.'/'));
	    }else{
	      // redirect(site_url('lms/payment/payment_history/'));
	    }
		
	}

	public function index(){

		$data['resources'] = $this->resources;
		$data['payment_history'] = $this->payment_model->lms_get("payment_history");
		$data['user_info'] = $this->payment_model->lms_get("users",$this->session->userdata('user_id'),"id")[0];

		$this->load->view('layouts/header',$data);
		$this->load->view('layouts/payment/payment_history/sidebar',$data);
		$this->load->view('payment/payment_history',$data);
		$this->load->view('layouts/payment/payment_history/footer',$data);
	}

	
}
