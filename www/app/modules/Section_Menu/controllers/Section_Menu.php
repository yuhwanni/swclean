<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * @property  array data
 */
class Section_Menu extends FW_Controller
{
    public $GP;

	function __construct()
	{
		parent::__construct( 'base', LAYOUT_EMPTY );
        $this->load->library(array('globals','func'));
        $this->GP =  $this->load->get_vars();
	}

	function index()
	{
        $this->load->view( "Section_Menu", $this->data );
	}
}
