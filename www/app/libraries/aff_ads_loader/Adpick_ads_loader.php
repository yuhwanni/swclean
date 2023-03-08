<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 12.
 * Time: PM 9:03
 */

require_once APPPATH . 'libraries/aff_ads_loader/Default_ads_loader.php';

class Adpick_ads_loader extends Default_ads_loader
{
    public function load()
    {
        $url = 'http://adpick.co.kr/apis/offers.php?affid=fbfb33';
        $rst = $this->CI->func->sendGetData(array('url' => $url));
        $json = json_decode($rst, true);
        $len = count($json);

        $arr = array();
        for($i = 0; $i < $len; $i++) {
            $ad_info = $json[$i];
            $aff_ads = $ad_info['apOffer'];
            $remain = $ad_info['apRemain'];

            if($remain > 0) {
                array_push($arr, $aff_ads);
            }
        }

        return $arr;
    }
}