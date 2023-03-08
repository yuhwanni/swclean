<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 6. 27.
 * Time: PM 6:36
 */


/**
 * NCPI 참여를 위한 key를 생성한다.
 *
 * @param $ads_idx 광고 인덱스
 * @param $mda_idx 매체 인덱스
 * @return string NCPI key
 */
function make_ncpi_link_key($ads_idx, $mda_idx): string
{
    $CI = &get_instance();
    $CI->config->load("globals", true);
    $CI->load->library("func");

    $key = $ads_idx . "_" . $mda_idx;
    $link_key = urlencode($CI->func->encryptByKey($key, $CI->config->item('ENC_KEY', 'globals')));
    return $link_key;
}


/**
 * value가 있으면 value를 반환하고, 없으면 공백 문자를 반환한다.
 *
 * @param $value
 * @return string
 */
function get_value_if_set($value) {
    return isset($value) ? $value : "";
}

/**
 * API 로그를 남긴다.
 *
 * @param $log_type 로그 타입
 * @param $write_data 기록할 데이터
 * @param bool $append_request 요청 인자들을 write_data에 추가할지 여부
 */
function api_log($log_type, $write_data, $append_request = false) {
    $fp = @fopen('/var/log/api/' . $log_type . '.' . date('Ymd'), "a+");

    if(empty($write_data) || $append_request) {
        foreach ($_REQUEST as $key => $value) {
            if(strpos($key, '?') === false) {
                $write_data[$key] = $value;
            } else {
                $keys = explode('?', $key);
                $write_data['__url__'] = $keys[0];
                $write_data[$keys[1]] = $value;
            }
        }
    }

    $msg = array('type' => $log_type,
        'time' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'data' => $write_data);

    $json_msg = json_encode($msg);

    if(empty($json_msg)) {
        $serialized_msg = serialize($msg);
        @fwrite($fp, json_encode(array("json_err" => utf8_encode($serialized_msg)))."\n");
    } else {
        @fwrite($fp, "$json_msg\n");
    }

    @fclose($fp);
}