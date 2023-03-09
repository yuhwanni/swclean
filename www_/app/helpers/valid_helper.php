<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Validate the password
 *
 * @param string $password
 *
 * @return bool
 */
function valid_password($password = '') {
    $CI =& get_instance();
    $CI->load->library('form_validation');

    //사용안함
}
