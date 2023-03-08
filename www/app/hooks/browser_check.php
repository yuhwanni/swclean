<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class _Browser
{
    function index()
    {
        $CI =& get_instance();
        $CI->load->library('mobile_detect');

        /*
            *  브라우저 체크
            */
        if ($CI->mobile_detect->isMobile() || $CI->mobile_detect->isTablet()) {
            define('BROWSER_TYPE', 'MOBILE');
        } else {
            define('BROWSER_TYPE', 'BROWSER');
        }

        if ($CI->mobile_detect->isiOS()) {
            define('OS_TYPE', 'IOS');
        } else if ($CI->mobile_detect->isAndroidOS()) {
            define('OS_TYPE', 'ANDROID');
        } else {
            define('OS_TYPE', 'WINDOWS');
        }

        $version = array();
        foreach ($CI->mobile_detect->getProperties() as $name => $match) {
            $check = $CI->mobile_detect->version($name);
            if ($check !== false) {
                $version[] = $name . " " . $check;
            }
        }

        $ver_str = implode(",", $version);
        define('BROWSER_VERSION', $ver_str);


        /*
        *   브라우저 체크 끝
        */
    }
}