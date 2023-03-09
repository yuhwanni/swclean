<?php
/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 4.
 * Time: PM 3:23
 */


/**
 * [url, data]를 포함하는 args 배열을 받아서 url에 data를 모두 추가한 최종 url을 생성한다.
 * @param $args [url, data]
 * @return string
 */
function make_full_url($args) {
    $parsed_url = parse_url($args['url']);
    $full_url = $parsed_url['scheme'] . "://" . $parsed_url['host'] . $parsed_url['path'];
    $query = isset($parsed_url['query']) ? $parsed_url['query'] : "";

    parse_str($query, $query_array);
    $query_array = array_merge($query_array, $args['data']);
    return $full_url . "?" . http_build_query ($query_array);
}

/**
 * http POST 요청을 보낸다.
 * @param $args [url, timeout, data]
 * @return array 배열에 [http_code, total_time, connect_time, starttransfer_time, result]를 담아서 반환한다.
 */
function send_http_post($args) {
    $url = $args['url'];
    $timeout = isset($args['timeout'])? $args['timeout'] : 60;
    $data = isset($args['data'])? $args['data'] : "";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);

    //curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);

    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $curl_exec_result = curl_exec($ch);
    $curl_info = curl_getinfo($ch);

    $curl_e_num = "";
    $curl_e_str = "";
    if($curl_exec_result === false) {
        $curl_e_num = curl_errno($ch);
        $curl_e_str = curl_error($ch);
    }

    curl_close($ch);

    return make_curl_result($curl_exec_result, $curl_info, $curl_e_num, $curl_e_str);
}


/**
 * http GET 요청을 보낸다.
 * @param $args [url]
 * @return array 배열에 [http_code, total_time, connect_time, starttransfer_time, result]를 담아서 반환한다.
 */
function send_http_get($args) {
    $url = $args['url'];
    $timeout = element('timeout', $args, 5);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);

    $curl_exec_result = curl_exec($ch);
    $curl_info = curl_getinfo($ch);

    $curl_e_num = "";
    $curl_e_str = "";
    if($curl_exec_result === false) {
        $curl_e_num = curl_errno($ch);
        $curl_e_str = curl_error($ch);
    }

    curl_close($ch);

    return make_curl_result($curl_exec_result, $curl_info, $curl_e_num, $curl_e_str);
}

/**
 * curl_exec_result와 curl_info를 가지고 최종 결과 배열을 생성한다.
 *
 * @param $curl_exec_result curl_exec()의 반환 값
 * @param $curl_info curl_getinfo()의 반환 값
 * @param $curl_errno 에러 번호
 * @param $curl_error 에러 문자열
 * @return array [http_code, total_time, connect_time, starttransfer_time, result]
 */
function make_curl_result($curl_exec_result, $curl_info, $curl_errno, $curl_error) {
    $result = array();
    $result['http_code'] = $curl_info['http_code'];
    $result['total_time'] = $curl_info['total_time'];
    $result['result'] = $curl_exec_result;

    if( ! empty($curl_errno)) {
        $result['curl_e_num'] = $curl_errno;
    }

    if( ! empty($curl_error)) {
        $result['curl_e_str'] = $curl_error;
    }

    return $result;
}