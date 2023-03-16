<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/** @noinspection PhpIncludeInspection */
require APPPATH."third_party/MX/Controller.php";



/**
 * @property CI_DB_query_builder $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
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
 * @property CI_Cache         $cache                      CodeIgniter Caching Class
 * @property Fwl_base64     $fwalker_base64             Base64 extend
 * @property Fwl_Excel      $fwalker_excel               PHPExcel wrapper
 * @property Fwl_Json       $fwalker_json                 Json wrapper
 * @property Fwl_Pagination $fwalker_pagination     cron_pagination
 * @property Fb               $fb                               logger wrapper
 * @property Firephp          $firephp                     logger firefox
 * @property Ion_auth         ion_auth
 *
 * @property array            data
 * @property float            offset
 * @property int              limit
 */
class FW_Controller extends MX_Controller
{
    protected $name_theme = 'base';
    protected $name_ctr = FALSE;
    protected $name_method = '';
    protected $name_layout = LAYOUT_HCF;

    protected $url_home = '';
    protected $url_self = '';

    protected $path_cur = '';
    protected $path_resbase = '';
    protected $path_viewdef = '';
    protected $path_viewctr = '';
    protected $path_filebase = '';
    protected $path_view = '';
    protected $path_lib = '';
    protected $path_upload = '';

    protected $path_basemodel = '';

    function __construct( $name_theme = 'base', $name_layout = LAYOUT_EMPTY )
    {
        date_default_timezone_set( "Asia/Seoul" );

        parent::__construct();

        $this->name_theme = $name_theme;
        $this->name_ctr = $this->router->class;
        $this->name_method = $this->router->method;
        $this->name_layout = $name_layout;

        $this->url_home = $this->config->item( 'base_url' );

        $this->path_cur = $this->router->directory;

        $this->path_filebase = FCPATH;

        $this->path_resbase = '/assets/dist/';
        $this->path_viewdef = $this->path_cur;
        $this->path_viewctr = $this->path_cur . $this->name_ctr;
        $this->path_lib = $this->path_resbase . 'libs';
        $this->path_upload = 'assets/uploads';
        $this->path_basemodel = '';

        $this->url_self = $this->get_localurl( $this->name_method );

        $this->data = array(
            'path_baseimg' => $this->path_resbase . 'img',
            'path_basecss' => $this->path_resbase . 'css',
            'path_basejs'  => $this->path_resbase . 'js',
            'path_themeimg' => $this->path_resbase . 'img/' . $this->name_theme,
            'path_themecss' => $this->path_resbase . 'css/' . $this->name_theme,
            'path_themejs'  => $this->path_resbase . 'js/' . $this->name_theme,
            'url_home' => $this->url_home,
            'name_ctr' => $this->name_ctr,
            'url_self' => $this->url_self,
        );

        $this->data[ 'add_style' ] = array();
        $this->data[ 'add_js' ] = array();

        /*
        if ( $name_layout != LAYOUT_EMPTY )
        {
            $this->add_style( FALSE, $this->name_layout . '.css' );
        }
        */

        //$this->fb->log( 'Call FWALKER_Controller ' . $this->name_ctr . ' ' . $this->url_self );
    }

    public function set_model( $model_name )
    {
        $this->load->model( $this->path_basemodel . '/' . $model_name );
    }

    public function get_localurl( $method )
    {
        //return $this->url_home . $this->path_cur . $this->name_ctr . ( $method == '' ? '' : '/' . $method );
        return $this->url_home . '/' . $this->name_ctr . ( $method == '' ? '' : '/' . $method );
    }

    public function get_externurl( $path, $ctr, $method )
    {
        $path = $path == '' ? '' : $path . '/';
        $ctr = $ctr == '' ? '' : $ctr . '/';
        $method = $method == '' ? '' : $method;
        return $this->url_home . '/' . $path . $ctr . $method;
    }

    public function get_path_filebase()
    {
        return $this->path_filebase;
    }

    public function get_path_upload()
    {
        return $this->path_upload;
    }

    public function render( $name_main_content, $data, $name_layout = '' )
    {

        if ( $name_layout == '' )
        {
            $name_layout = 'layout_' . $this->name_layout;
        }
        else
        {
            $name_layout = 'layout_' . $name_layout;
        }

        /*if(LOC_TYPE == "adm") {
            $name_layout = "adm/" . $name_layout;
        } else if(LOC_TYPE == "web") {
            $name_layout = "web/" . $name_layout;
        }*/

        $name_layout = LOC_TYPE."/". $name_layout;
        
        $data[ 'main_content' ] = $name_main_content;

        $this->load->view( $name_layout, $data );
    }

    public function add_style( $kind, $name_style )
    {
        switch ( $kind )
        {
        case CSS_KIND_WEB:
            array_push( $this->data[ 'add_style' ], $name_style );
            break;
        case CSS_KIND_BASE:
            array_push( $this->data[ 'add_style' ], $this->data[ 'path_basecss' ] . '/' . $name_style );
            break;
        case CSS_KIND_THEME:
            array_push( $this->data[ 'add_style' ], $this->data[ 'path_themecss' ] . '/' . $name_style );
            break;
        }
    }

    public function add_js( $kind, $name_js )
    {
        switch ( $kind )
        {
        case JS_KIND_WEB:
            array_push( $this->data[ 'add_js' ], $name_js );
            break;
        case JS_KIND_BASE:
            array_push( $this->data[ 'add_js' ], $this->data[ 'path_basejs' ] . '/' . $name_js );
            break;
        case JS_KIND_THEME:
            array_push( $this->data[ 'add_js' ], $this->data[ 'path_themejs' ] . '/' . $name_js );
            break;
        }
    }

    protected function parsing_request( $isWebview = false )
    {
        $in_data = $this->input->get_post( 'parm', true );

        if ( $in_data == '' || empty( $in_data ) )
        {
            $ret[ 'ret' ] = 0;
            $ret[ 'errno' ] = 'ERR_AUTH_02';
            $ret[ 'msg' ] = '데이터가 존재하지 않습니다';
            $this->response( $ret, $isWebview );
        }

        $base64_param = $this->fwalker_base64->decode( $in_data );

        if ( $base64_param == null || empty( $base64_param ) )
        {
            $ret[ 'ret' ] = 0;
            $ret[ 'errno' ] = 'ERR_AUTH_03';
            $ret[ 'msg' ] = '올바르지 않은 값입니다';
            $this->response( $ret, $isWebview );
        }

        $parm = json_decode( $base64_param );

        if ( $parm == null || empty( $parm ) )
        {
            $ret[ 'ret' ] = 0;
            $ret[ 'errno' ] = 'ERR_AUTH_04';
            $ret[ 'msg' ] = '잘못된 인자입니다';
            $this->response( $ret, $isWebview );
        }

        return $parm;
    }

    protected function response( $ret, $isPrint = false )
    {
        if ( $isPrint )
        {
            if ( $ret[ 'ret' ] == 0 )
            {
                echo $ret[ 'msg' ];
            }
        }
        else
        {
            $json = json_encode( $ret );

            //*
            echo $this->fwalker_base64->encode( $json );
            /*/
            echo htmlentities( json_encode( $ret ) );
            //*/
        }

        exit;
    }

    protected function set_pagenation( $page_cnt, $total_rows, $uri_segment, $query_string = null )
    {
        $this->load->library( 'Fwalker_Pagination' );

        // 페이지 네이션 설정
        $page_conf[ 'base_url' ] = $this->get_localurl( $this->name_method ) . '/' . $page_cnt;

        $page_conf[ 'total_rows' ] = $total_rows;

        $page_conf[ 'per_page' ] = $page_cnt; // 한 페이지에 표시할 개수
        $page_conf[ 'num_links'] = 3; // 페이지 링크 개수( 좌우 기준 )

        $page_conf[ 'full_tag_open' ] = '<ul class="pagination">';
        $page_conf[ 'full_tag_close' ] = '</ul>';
        $page_conf[ 'first_link' ] = '<<';
        $page_conf[ 'first_tag_open' ] = '<li>';
        $page_conf[ 'first_tag_close' ] = '</li>';
        $page_conf[ 'last_link' ] = '>>';
        $page_conf[ 'last_tag_open' ] = '<li>';
        $page_conf[ 'last_tag_close' ] = '</li>';
        $page_conf[ 'prev_link' ] = '<';
        $page_conf[ 'prev_tag_open' ] = '<li>';
        $page_conf[ 'prev_tag_close' ] = '</li>';
        $page_conf[ 'next_link' ] = '>';
        $page_conf[ 'next_tag_open' ] = '<li>';
        $page_conf[ 'next_tag_close' ] = '</li>';
        $page_conf[ 'cur_tag_open' ] = '<li class="active"><a href="#">';
        $page_conf[ 'cur_tag_close' ] = '</a></li>';
        $page_conf[ 'num_tag_open' ] = '<li>';
        $page_conf[ 'num_tag_close' ] = '</li>';

        $page_conf[ 'suffix' ] = !is_null( $query_string ) ? '?sd=' . $query_string : '';

        $page_conf[ 'uri_segment' ] = $uri_segment; // 페이지 번호가 위치한 세그먼트

        $page_conf[ 'first_url' ] = $page_conf[ 'base_url' ] . $page_conf[ 'suffix' ];

        // 페이지네이션 초기화
        $this->fwalker_pagination->initialize( $page_conf );

        // 페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $this->data[ 'pagination' ] = $this->fwalker_pagination->create_links();

        $page = $this->uri->segment( $uri_segment, 1 );

        if ( $page < 1 )
        {
            $page = 1;
        }

        if ( $page > 1 )
        {
            $this->offset = ( ( $page / $page_conf[ 'per_page' ] ) ) * $page_conf[ 'per_page' ];
        }
        else
        {
            $this->offset = ( $page - 1 ) * $page_conf[ 'per_page' ];
        }

        $this->limit = $page_conf[ 'per_page' ];

        $this->data[ 'offset' ] = $this->offset + 1;
    }
}
