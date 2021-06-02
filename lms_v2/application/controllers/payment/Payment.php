<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends JOE_Controller {

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

	public function index(){
		$data['resources'] = $this->resources;
		$data['user_info'] = $this->payment_model->lms_get("users",$this->session->userdata('user_id'),"id")[0];
		$data['children'] = $this->payment_model->get_parent_children($this->session->userdata('user_id'));
		$data['user_info']['name'] = $data['children'][0]->guardian_name;
		
		$this->load->view('layouts/header',$data);
		$this->load->view('layouts/sidebar',$data);
		$this->load->view('payment/payment',$data);
		$this->load->view('layouts/footer',$data);
		$this->load->view('layouts/extra',$data);
	}

	public function process(){

		$data['name'] = $_REQUEST['name'];
		$data['email'] = $_REQUEST['email'];
		$data['card_number'] = $_REQUEST['card_number'];
		$data['exp_month'] = $_REQUEST['exp_month'];
		$data['exp_year'] = $_REQUEST['exp_year'];
		$data['cvc'] = $_REQUEST['cvc'];
		$data['amount'] = $_REQUEST['amount'];
		$data['purpose'] = $_REQUEST['purpose'];
		$payment_method = $this->create_payment_method($data);

		if($payment_method){

			$payment_method = json_decode($payment_method);
			$payment_intent = $this->create_payment_intent($data);
			if($payment_intent){
				$payment_intent = json_decode($payment_intent);
				$data['payment_intent_id'] = $payment_intent->data->id;
				$data['payment_method_id'] = $payment_method->data->id;
				$attach_payment_intent = $this->attach_payment_intent($data);
				if($attach_payment_intent){
					$attach_payment_intent = json_decode($attach_payment_intent);
					$data['attach_payment_intent_id'] = $attach_payment_intent->data->id;
					
					$db_data['account_id'] = $this->session->userdata('user_id');
					$db_data['payment_intent_id'] = $data['payment_intent_id'];
					$db_data['payment_method_id'] = $data['payment_method_id'];
					$db_data['attach_payment_intent_id'] = $data['attach_payment_intent_id'];
					$db_data['card_number'] = $data['card_number'];
					$db_data['exp_month'] = $data['exp_month'];
					$db_data['exp_year'] = $data['exp_year'];
					$db_data['cvc'] = $data['cvc'];
					$db_data['amount'] = $data['amount'];
					$db_data['name'] = $data['name'];
					$db_data['email'] = $data['email'];
					$db_data['purpose'] = $data['purpose'];
					$db_data['gateway'] = "paymonggo";

					if($this->payment_model->lms_create("payment_history",$db_data)){
						$redirect = base_url('payment/payment_history/index');
						echo "<script>alert('Payment Successfully Processed!');window.location.replace('$redirect');</script>";
					}else{
						echo "Issue on saving";
						exit;
					}

					
				}else{
					echo "Payment Attachment Issue";
					exit;
				}
			}else{
				echo "Payment Intent Issue.";
				exit;
			}

		}else{
			echo "Payment Method Issue.";
			exit;
		}
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

	public function create_payment_method($data){
		$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://api.paymongo.com/v1/payment_methods",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"data\":{\"attributes\":{\"details\":{\"card_number\":\"".$data['card_number']."\",\"exp_month\":".$data['exp_month'].",\"exp_year\":".$data['exp_year'].",\"cvc\":\"".$data['cvc']."\"},\"billing\":{\"name\":\"".$data['name']."\",\"email\":\"".$data['email']."\",\"phone\":\"09943230083\"},\"type\":\"card\"}}}",
		  CURLOPT_HTTPHEADER => [
		    "Accept: application/json",
		    "Authorization: Basic c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w6c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w=",
		    "Content-Type: application/json"
		  ],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  // echo "cURL Error #:" . $err;
		  return false;
		} else {
		  // echo $response;
		  return $response;
		}
	}


	public function create_payment_intent($data){

		$curl = curl_init();
		$amount = $data['amount']*100;
		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://api.paymongo.com/v1/payment_intents",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"data\":{\"attributes\":{\"amount\":".$amount.",\"payment_method_allowed\":[\"card\"],\"payment_method_options\":{\"card\":{\"request_three_d_secure\":\"any\"}},\"currency\":\"PHP\"}}}",
		  CURLOPT_HTTPHEADER => [
		    "Accept: application/json",
		    "Authorization: Basic c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w6c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w=",
		    "Content-Type: application/json"
		  ],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return false;
		} else {

		  	return $response;

		}
	}
	public function attach_payment_intent($data){

		$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://api.paymongo.com/v1/payment_intents/".$data['payment_intent_id']."/attach",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"data\":{\"attributes\":{\"payment_method\":\"".$data['payment_method_id']."\"}}}",
		  CURLOPT_HTTPHEADER => [
		    "Accept: application/json",
		    "Authorization: Basic c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w6c2tfdGVzdF9yQ0RDbk5vdlVBVnRyYmVZaXJRMnJHY0w=",
		    "Content-Type: application/json"
		  ],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  // echo "cURL Error #:" . $err;
		  return false;
		} else {
		  // echo $response;
		  return $response;
		}
	}
	
}
