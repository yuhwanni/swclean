<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/* load the MX_Router class */
/** @noinspection PhpIncludeInspection */
require APPPATH . "third_party/MX/Router.php";

class FW_Router extends MX_Router
{
    //put your code here
    public function __construct( $routing = null )
    {
        parent::__construct( $routing );
    }	


    
    /*
    protected function _set_default_controller()
    {    	 
        parent::_set_default_controller();

        if ( empty( $this->default_controller ) )
        {
            show_error( 'Unable to determine what should be displayed. A default route has not been specified in the routing file.' );
        }  

        echo $this->default_controller . "<br>";
        
            
        if ( sscanf( $this->default_controller, '%[^/]/%[^/]/%s', $directory, $class, $method ) !== 3 )
        {
            $method = 'index';
        }
        
        echo $directory . "<br>";
        echo $class . "<br>";
        echo $method;        

        if ( is_dir( APPPATH . 'controllers' . DIRECTORY_SEPARATOR . $directory ) === true )
        {
            if ( !file_exists( APPPATH . 'controllers' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . ucfirst( $class ) . '.php' ) )
            {
                // This will trigger 404 later
                echo 'not found<br/>';
                return;
            }
            $this->set_directory( $directory );
            $this->set_class( $class );
            $this->set_method( $method );
        }
        else
        {
            if ( sscanf( $this->default_controller, '%[^/]/%s', $class, $method ) !== 2 )
            {
                $method = 'index';
            }
            if ( !file_exists( APPPATH . 'controllers' . DIRECTORY_SEPARATOR . ucfirst( $class ) . '.php' ) )
            {
                // This will trigger 404 later
                return;
            }
            $this->set_class( $class );
            $this->set_method( $method );
        }
        // Assign routed segments, index starting from 1
        $this->uri->rsegments = array( 1 => $class, 2 => $method );

        log_message( 'debug', 'No URI present. Default controller set.' );
    }
    */
}