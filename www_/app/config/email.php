<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

$config[ 'protocol' ] = 'smtp';
$config[ 'smtp_host' ] = 'smtp.hiworks.co.kr';
$config[ 'smtp_port' ] = 587;
$config[ 'smtp_user' ] = 'fwlaker';
$config[ 'smtp_pass' ] = 'Alwo0@11';
$config[ 'smtp_timeout' ] = 10;


/* End of file email.php */
/* Location: ./application/config/email.php */
