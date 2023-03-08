<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/* load the MX_Loader class */
/** @noinspection PhpIncludeInspection */
require APPPATH."third_party/MX/Loader.php";

class FW_Loader extends MX_Loader {
	
	public function __construct() {
		parent::__construct();
		/*$domain = $_SERVER['HTTP_HOST'];
		$arr_dm = explode(".", $domain);
		$controllerFolderName = array_shift($arr_dm);
		
		if(DEV_STR != '') {
			if(strpos($controllerFolderName, DEV_STR) !== false) {
				$controllerFolderName = str_replace(DEV_STR, "", $controllerFolderName);
			}
		}*/
        
        //$this -> _ci_view_paths = array(APPPATH . 'views/' . $controllerFolderName . '/' => TRUE);
	}	
	
	public function ext_view($folder, $view, $vars = array(), $return = FALSE) {			
		$this->_ci_view_paths = array_merge($this->_ci_view_paths, array(FCPATH . $folder . '/' => TRUE));
		return $this->_ci_load(array(
	            '_ci_view' => $view,
	            '_ci_vars' => $this->_ci_object_to_array($vars),
	            '_ci_return' => $return
	        ));
	}
}
