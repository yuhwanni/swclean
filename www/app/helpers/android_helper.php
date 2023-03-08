<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14. 9. 4
 * Time: 오후 6:56
 */
/**
 * @param $registration_ids
 * @param $api_key
 * @param $data
 *
 * @return mixed
 */
function send_gcm( $registration_ids, $api_key, $data )
{
    $url = 'https://android.googleapis.com/gcm/send';

    /*
    $data = array(
        'title' => $title,
        'msg' => $msg,
        'is_url' => $is_url,
        'push_url' => $push_url
    );
    */

    $fields = array(
        'registration_ids' => $registration_ids,
        'data' => $data
    );

    $headers = array
    (
        'Content-Type:application/json',
        'Authorization:key=' . $api_key
    );

    $ch = curl_init();

    // Set the url, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url );

    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    // Disabling SSL Certificate support temporarly
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

    // Excute post
    $result = curl_exec( $ch );

    if ( $result === FALSE )
    {
        //die( 'Curl failed: ' . curl_errno( $ch ) );
        $ret[ 'ret' ] = 0;
        $ret[ 'errno' ] = curl_errno( $ch );
    }
    else
    {
        $ret[ 'ret' ] = 1;
        $ret[ 'result' ] = $result;
    }

    // Close connection
    curl_close( $ch );

    return $ret;
}

function send_gcm_ext( $registration_ids, $api_key, $data )
{
    $url = 'https://android.googleapis.com/gcm/send';
    /*
    $data = array(
        'title' => $title,
        'msg' => $msg,
        'is_url' => $is_url,
        'push_url' => $push_url
    );
    */
    $fields = array(
        'registration_ids' => $registration_ids,
        'collapse_key' => 'welcome_message',
        'data'             => $data
    );
    $headers = array
    (
        'Content-Type:application/json',
        'Authorization:key=' . $api_key
    );
    $ch = curl_init();
    // Set the url, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    // Disabling SSL Certificate support temporarly
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
    // Excute post
    $result = curl_exec( $ch );
    if ( $result === false )
    {
        //die( 'Curl failed: ' . curl_errno( $ch ) );
        $ret[ 'ret' ]   = 0;
        $ret[ 'errno' ] = curl_errno( $ch );
    }
    else
    {
        $ret[ 'ret' ]    = 1;
        $ret[ 'result' ] = $result;
    }
    // Close connection
    curl_close( $ch );

    return $ret;
}

/*
function send_gcm( $conn, $id, $title, $msg, $isurl, $url, $userid, $gameid, $marketid, $isConnDb )
{
    $apikey = "AIzaSyC4XMEmWmF6UGKmXTN1-_NkWHzukfLe-Dg";
    $headers = array
    (
        'Content-Type:application/json',
        'Authorization:key=' . $apikey
    );
    $arr                            = array();
    $arr[ 'data' ]                  = array();
    $arr[ 'data' ][ 'title' ]       = $title;
    $arr[ 'data' ][ 'msg' ]         = $msg;
    $arr[ 'data' ][ 'isurl' ]       = $isurl;
    $arr[ 'data' ][ 'url' ]         = urlencode( $url );
    $arr[ 'registration_ids' ]      = array();
    $arr[ 'registration_ids' ][ 0 ] = "$id";
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $arr ) );
    $response = curl_exec( $ch );
    $isResult = true;
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    if ( $httpCode != 200 || curl_errno( $ch ) )
    {
        $isResult = false;
    }
    curl_close( $ch );
    if ( $isResult )
    {
    }
    else
    {
        $insert_result = query( $conn, "insert into pushfail ( uid, gameid, marketid, pushid, msg, regtime ) values ( '$userid', '$gameid', $marketid, '$id', '$msg', from_unixtime( unix_timestamp() ) )" );
        $isResult = false;
    }

    return $isResult;
}

function send_gcmmulti( $conn, $id, $title, $msg, $isurl, $url, $gameid, $marketid )
{
    $apikey = "AIzaSyC4XMEmWmF6UGKmXTN1-_NkWHzukfLe-Dg";
    $headers = array
    (
        'Content-Type:application/json',
        'Authorization:key=' . $apikey
    );
    $arr                       = array();
    $arr[ 'data' ]             = array();
    $arr[ 'data' ][ 'title' ]  = $title;
    $arr[ 'data' ][ 'msg' ]    = $msg;
    $arr[ 'data' ][ 'isurl' ]  = $isurl;
    $arr[ 'data' ][ 'url' ]    = urlencode( $url );
    $arr[ 'registration_ids' ] = $id;
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $arr ) );
    $response = curl_exec( $ch );
    $isResult = true;
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    if ( $httpCode != 200 || curl_errno( $ch ) )
    {
        $isResult = false;
    }
    curl_close( $ch );
    if ( $isResult )
    {
        echo "성공<br>";
        $json_output = json_decode( $response, false );

        return $json_output->success;
    }
    else
    {
        echo "실패<br>";
    }

    return 0;
}
*/

function verify_market_in_app( $signed_data, $signature, $public_key_base64 )
{
    $key = "-----BEGIN PUBLIC KEY-----\n" . chunk_split( $public_key_base64, 64, "\n" ) . '-----END PUBLIC KEY-----';
    //using PHP to create an RSA key
    $key = openssl_get_publickey( $key );
    //$signature should be in binary format, but it comes as BASE64.
    //So, I'll convert it.
    $signature = base64_decode( $signature );
    //using PHP's native support to verify the signature
    $result = openssl_verify( json_decode( $signed_data, true ), $signature, $key, OPENSSL_ALGO_SHA1 );
    if ( 0 === $result )
    {
        return false;
    }
    else if ( 1 !== $result )
    {
        return false;
    }

    return true;
}
