<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FW_Exceptions extends CI_Exceptions {

    function __construct()
    {
        parent::__construct();
    }

    public function show_custom_error($message)
    {
        //add your logic
        //assign your $header, $template, and $status values
        //if needed you can also call the show_error method of the parent class
        $header = isset($header) ? $header : '';
        $message = isset($message) ? $message : '';
        $template = isset($template) ? $template : '';
        $status = isset($status) ? $status : '';
        return $this->show_error($header, $message, $template, $status);
    }


    //show_error($heading, $message, $template = 'error_general', $status_code = 500)
    public function show_json_error($heading, $message, $template = 'error_general', $status_code = 200, $field='') {
        $rst = array('resp' => array('success' => false, 'msg' => $message, 'field' => $field));
        die(json_encode($rst));
    }

    public function show_json_success($heading, $message, $template = 'error_general', $status_code = 200, $field='') {
        $rst = array('resp' => array('success' => true, 'msg' => $message, 'field' => $field));
        die(json_encode($rst));
    }

    public function show_jsonp_error($heading, $message, $template = 'error_general', $status_code = 200, $callback) {
        $rst = array('resp' => array('success' => false, 'msg' => $message));
        $json_data = $callback."(".json_encode($rst).");";
        die($json_data);
    }

    //show_error($heading, $message, $template = 'error_general', $status_code = 500)
    public function show_json_error_adm($heading, $message, $template = 'error_general', $status_code = 200, $field='') {
        $rst = array('rst' => 'E1');
        die(json_encode($rst));
    }

}