<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class KampusPay extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('kampuspay_model');
        $this->load->model('setting_model');

        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function index()
    {
        // --
    }

    public function collections()
    {
        if (!$this->rbac->hasPrivilege('kampuspay', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/kampuspay_collections');

        $userdata = $this->customlib->getUserData();
        $data["staff_id"] = $userdata["id"];
        // $data['access_key'] = $this->sch_setting_detail->kampuspay_access_key;
        // $data['key'] = $this->sch_setting_detail->kampuspay_key;
        // $data['sign'] = strtoupper(md5("access_key=" . $data['access_key'] . "&ts=1618649846873&key=" . $data['key']));
        // $data['ts'] = strtotime("now");

        // $timestamp=1486830234542;
        // echo date('Y-m-d H:i:s', $timestamp/1000);

        $this->load->view("layout/header", $data);
        $this->load->view("admin/kampuspay/collections", $data);
        $this->load->view("layout/footer", $data);
    }

    public function getKampusPayCollections()
    {
        $access_key = $this->sch_setting_detail->kampuspay_access_key;
        $key = strtoupper($this->sch_setting_detail->kampuspay_key);
        $ts = strval(strtotime("now"));
        $sign = strtoupper(md5("access_key=" . $access_key . "&ts=" . $ts . "&key=" . $key));

        // echo ("<PRE>");
        // print_r("access_key=" . $access_key . "&ts=" . $ts . "&key=" . $key);
        // echo ("<PRE>");
        // print_r(md5("access_key=" . $access_key . "&ts=" . $ts . "&key=" . $key));
        // echo ("<PRE>");
        // die();

        $data_array =  array(
            "access_key" => "$access_key",
            "ts" => $ts,
            "sign" => $sign
        );

        // echo ("<PRE>");
        // print_r(json_encode($data_array));
        // echo ("<PRE>");
        // die();

        $data_string = json_encode($data_array);

        $url = 'http://test.bananapay.cn/phl/api/v3.0/Cashier.Payment.GetTransactions';
        $ch = curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string))
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        // $data = json_decode(file_get_contents('php://input'), true);
        $result = json_decode($response, true);
        $error = $result['errno'];
        $message = $result['message'];
        $data = $result['results']['order_collection'];

        foreach ($data as $key => $value) {
            $retVal['data'][$key] = array(
                $value['transaction_id'],
                $value['out_trade_no'],
                $value['goods_name'],
                $value['goods_ext_price'],
                $value['goods_ext_price'] * .025,
                date("m-d-Y H:i:s a", $value['pay_time'])
            );
        }

        echo json_encode($retVal);
    }

    // public function getKampusPayTransactions()
    // {
    //     $userdata = $this->customlib->getUserData();
    //     $app_user_id = $userdata["id"];


    //     $access_key = $this->sch_setting_detail->kampuspay_access_key;
    //     $key = strtoupper($this->sch_setting_detail->kampuspay_key);
    //     $ts = strval(strtotime("now"));
    //     $sign = strtoupper(md5("access_key=" . $access_key . "&app_user_id=" . $app_user_id . "&bill_state=COMPLETED&bill_type=PAYMENT&pay_way=bananapay&platform=Fucent&ts=" . $ts . "&key=" . $key));

    //     // echo ("<PRE>");
    //     // print_r("access_key=" . $access_key . "&app_user_id=" . $app_user_id . "&bill_state=COMPLETED&bill_type=PAYMENT&pay_way=bananapay&platform=Fucent&ts=" . $ts . "&key=" . $key);
    //     // echo ("<PRE>");
    //     // print_r(strtoupper(md5("access_key=" . $access_key . "&app_user_id=" . $app_user_id . "&bill_state=COMPLETED&bill_type=PAYMENT&pay_way=bananapay&platform=Fucent&ts=" . $ts . "&key=" . $key)));
    //     // echo ("<PRE>");
    //     // die();

    //     $data_array =  array(
    //         "access_key" => "$access_key",
    //         "app_user_id" => $app_user_id,
    //         "bill_state" => "COMPLETED",
    //         "bill_type" => "PAYMENT",
    //         "pay_way" => "bananapay",
    //         "platform" => "Fucent",
    //         "ts" => $ts,
    //         "sign" => $sign
    //     );

    //     // echo ("<PRE>");
    //     // print_r(json_encode($data_array));
    //     // echo ("<PRE>");
    //     // die();

    //     $data_string = json_encode($data_array);

    //     $url = 'http://test.bananapay.cn/phl/api/v3.0/Cashier.Payment.BananapayGlobalBillQuery';
    //     $ch = curl_init($url);

    //     curl_setopt_array($ch, array(
    //         CURLOPT_POST => true,
    //         CURLOPT_POSTFIELDS => $data_string,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string))
    //     ));

    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     // $data = json_decode(file_get_contents('php://input'), true);
    //     $result = json_decode($response, true);
    //     $error = $result['errno'];
    //     $message = $result['message'];
    //     $data = $result['results']['orders'];

    //     foreach ($data as $key => $value) {
    //         $retVal['data'][$key] = array(
    //             $value['trade_no'],
    //             $value['out_trade_no'],
    //             $value['subject'],
    //             $value['pay_amount'],
    //             $value['gmt_payment']
    //         );
    //     }

    //     echo json_encode($retVal);
    // }
}
