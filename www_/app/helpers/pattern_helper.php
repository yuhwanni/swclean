<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 26.
 * Time: AM 10:17
 */


function is_imei($subject) {
    return preg_match('/^([0-9]{15})$/', $subject);
}

function is_android_id($subject) {
    return preg_match('/^([0-9a-zA-Z]{16})$/', $subject);
}

function is_adid($subject) {
    return preg_match('/^([0-9A-Fa-f]{8}-([0-9A-Fa-f]{4}-){3}[0-9A-Fa-f]{12})$/', $subject);
}

function is_idfa($subject) {
    return preg_match('/^([0-9A-Fa-f]{8}-([0-9A-Fa-f]{4}-){3}[0-9A-Fa-f]{12})$/', $subject);
}

function is_mac_address($subject) {
    return preg_match('/^(([0-9A-Fa-f]{2}[:-]){5}[0-9A-Fa-f]{2})$/', $subject);
}