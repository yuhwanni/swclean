<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 12.
 * Time: PM 9:03
 */

require_once APPPATH . 'libraries/aff_ads_loader/Default_ads_loader.php';

class Ohc_ads_loader extends Default_ads_loader
{

    public function load()
    {
        $url = 'http://w6.ohpoint.co.kr/charge/banner/offerList.do?mId=ivekorea';
        $rst = $this->CI->func->sendGetData(array('url' => $url));
        $json = json_decode($rst, true);
        $len = $json['adcount'];

        $arr = array();
        for($i = 0; $i < $len; $i++) {
            $ad_info = $json['list'][$i];
            $aff_ads = $ad_info['eId'];

            array_push($arr, $aff_ads);
        }

        return $arr;
    }
}