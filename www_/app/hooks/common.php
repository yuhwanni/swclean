<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class _Common
{
    function index()
    {
        $CI =& get_instance();
        $CI->load->library('mobile_detect');
        $this->GP =  $CI->load->get_vars();

        //언어 구분 폴더
        define( 'FOLDER', $CI->uri->segment(2));

        //페이지 폴더
        define( 'SUB_FOLDER', $CI->uri->segment(3));

        //상단메뉴
        if($CI->uri->segment(1) != 'adm') {
            define( 'TOP_MENU', $this->GP['SITE_MENU'][$CI->uri->segment(2)]);
        }

    }
}