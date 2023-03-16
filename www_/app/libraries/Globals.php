<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Globals {

	// Pass array as an argument to constructor function
	public function __construct($config = array()) {

		// Create associative array from the passed array
		$data = array();
		foreach ($config as $key => $value) {
			$data[$key] = $value;
		}
		
		// Make instance of CodeIgniter to use its resources
		$CI = & get_instance();

		// Load data into CodeIgniter
		$CI->load->vars($data);
	}
}
?>