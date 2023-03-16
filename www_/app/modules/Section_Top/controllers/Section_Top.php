<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * @property  array data
 */
class Section_Top extends FW_Controller
{
	public $GP = "";
	function __construct()
	{
		parent::__construct( 'base', LAYOUT_EMPTY );
		$this->load->library(array('globals', 'func'));
		$this->GP = $this->load->get_vars();
	}

	function index()
	{
        $this->data[ 'link_logout' ] = $this->get_externurl( '', 'Auth', 'logout' );
        $this->load->view( "Section_Top", $this->data );
	}
}
