<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Defines common exception functions that are globally available
 */

if ( ! function_exists('show_custom_error'))
{
    function show_custom_error($message)
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_custom_error($message);
        exit;
    }
}


if ( ! function_exists('show_json_error'))
{
    function show_json_error($heading, $message, $template = 'error_general', $status_code = 200, $field='')
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_json_error($heading, $message, $template = 'error_general', $status_code = 200, $field);
        exit;
    }
}


if ( ! function_exists('show_json_success'))
{
    function show_json_success($heading, $message, $template = 'error_general', $status_code = 200, $field='')
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_json_success($heading, $message, $template = 'error_general', $status_code = 200, $field);
        exit;
    }
}


if ( ! function_exists('show_jsonp_error'))
{
    function show_jsonp_error($heading, $message, $template = 'error_general', $status_code = 200, $callback, $field='')
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_jsonp_error($heading, $message, $template = 'error_general', $status_code = 200, $callback, $field);
        exit;
    }
}


if ( ! function_exists('show_json_error_adm'))
{
    function show_json_error_adm($heading, $message, $template = 'error_general', $status_code = 200, $field='')
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_json_error_adm($heading, $message, $template = 'error_general', $status_code = 200, $field);
        exit;
    }
}
