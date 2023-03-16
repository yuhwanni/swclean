<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Class Couchphp
 * @property CI_DB_query_builder $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      //dead
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property CI_Driver_Library $driver            CodeIgniter Driver Library Class
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 * @property CouchbaseCluster $cluster
 * @property CouchbaseBucket $bucket
 * @property CI_Controller $CI
 */
class Couchphp
{
    protected $CI = null;
    protected $cluster = null;
    protected $bucket = null;
    protected $is_test = false;

    public function __construct()
    {
    }

    public function set_config( $is_test )
    {
        if ( is_null( $is_test ) ) {
            show_error( 'Error Couchphp Parameters empty!!!' );
            exit;
        }

        $CI =& get_instance();

        $CI->config->load( 'couchbase_settings' );
        $cb_settings = $CI->config->item( $is_test ? 'cb_test_info' : 'cb_real_info' );

        $this->is_test = $is_test;

        $this->connect( $cb_settings );
    }

    private function connect( $settings )
    {
        $this->cluster = new CouchbaseCluster( $settings[ 'url' ] . ':' . $settings[ 'port' ] );
        $this->bucket = $this->cluster->openBucket( $settings[ 'bucket' ], $settings[ 'pwd'] );

        if ( $settings[ 'is_n1ql' ] )
        {
            $this->bucket->enableN1ql( array( $settings[ 'url' ] . ':' . $settings[ 'port_n1ql' ] ) );
        }
    }

    public function get_cluster()
    {
        return $this->cluster;
    }

    public function get_bucket()
    {
        return $this->bucket;
    }

    public function action()
    {
        $toal_args = func_get_args();

        $method = func_get_arg( 0 );
        $params = array_slice( $toal_args, 1 );

        try
        {
            $ret = call_user_func_array( array( $this->bucket, $method ), $params );
        }
        catch ( Exception $e )
        {
            $ret = new stdClass();
            $ret->error = 'Exception ' . $e;
            $ret->errCode = $e->getCode();
        }

        return $ret;
    }

    public function query_n1ql( $str_query )
    {
        $query = CouchbaseN1qlQuery::fromString( $str_query );
        $res = $this->bucket->query( $query );

        var_dump( $res );

        return $res;
    }

    public function query_view( $name_design, $name_view, $skip = -1, $limit = -1 )
    {
        $query = CouchbaseViewQuery::from( $name_design, $name_view );

        if ( $skip >= 0 )
        {
            $query = $query->skip( $skip );
        }

        if ( $limit >= 0 )
        {
            $query = $query->limit( $limit );
        }

        $res = $this->bucket->query( $query );

//        var_dump( $res );

        return $res;
    }
}
