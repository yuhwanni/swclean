<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * @property  array data
 */
class Section_Side extends FW_Controller
{
    function __construct()
    {
        parent::__construct('base', LAYOUT_EMPTY);
    }

    function index()
    {
        $this->load->view( "Section_Side", $this->data );
    }
}