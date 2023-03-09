<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 12.
 * Time: PM 9:02
 */
class Default_ads_loader
{
    protected $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('func');
    }

    public function load() {
        return array();
    }
}