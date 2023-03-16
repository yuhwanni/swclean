<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


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
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 */
class FW_Model extends CI_Model
{
    protected $table_name = '';
    protected $is_where = FALSE;

    function __construct( $db_name = 'default' )
    {
        parent::__construct();

        $this->load->database( $db_name );
    }

    function set_table( $name_table )
    {
        $this->table_name = $name_table;
    }

    function make_sql_from_form( $db, $kind, $table, $post, $where = '' )
    {
        $return = array();

        if ( $kind == 'insert' )
        {
            $sql = "INSERT INTO $table ( ";
            $field = '';
            $values = '';
            $query_value = array();

            foreach ( $post as $key => $val )
            {
                /** @noinspection PhpUndefinedMethodInspection */
                if ( $db->field_exists( $key, $table ) )
                {
                    $field .= $key . ', ';
                    $values .= '?, ';
                    array_push( $query_value, $val );
                }
            }

            $sql .= substr( $field, 0, -2 ) . ' ) VALUES ( ' . substr( $values, 0, -2 ) . ' )';

            $return[ 'sql' ] = $sql;
            $return[ 'q_val' ] = $query_value;
        }
        else if ( $kind == 'update' )
        {
            $sql = 'UPDATE ' . $table . ' SET ';
            $field = '';
            $query_value = array();

            foreach ( $post as $key => $val )
            {
                /** @noinspection PhpUndefinedMethodInspection */
                if ( $db->field_exists( $key, $table ) )
                {
                    $field .= $key . '=?, ';
                    array_push( $query_value, $val );
                }
            }

            $sql .= substr( $field, 0, -2 ) . ( $where == '' ? '' : ' WHERE ' . $where );

            $return[ 'sql' ] = $sql;
            $return[ 'q_val' ] = $query_value;
        }

        return $return;
    }

    /*
    function get_serial_id( $table_name )
    {
        $sql = "SELECT gen_id FROM serial WHERE name='" . $table_name . '\'';

        $query = $this->db->query( $sql );

        $result = $query->result();

        $this->db->query( 'UPDATE serial SET gen_id = gen_id + 1 WHERE name=\'' . $table_name . '\'' );

        return $result[ 0 ]->gen_id;
    }
    */

    /**
     * 데이터베이스 동작 실패시 에러 메세지를 생성한다
     */
    function get_db_error()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $code = $this->db->_error_number(); // mysql_errno();
        /** @noinspection PhpUndefinedMethodInspection */
        $message = $this->db->_error_message(); //mysql_error();
        $sql     = $this->db->last_query();

        $ret = 'code: ' . $code . "\n";
        $ret .= 'message: ' . $message . "\n";
        $ret .= 'sql: ' . $sql;

        return $ret;
    }

    /**
     * 검색시 조건문을 추가한다
     *
     * @param string $field_name  조건필드
     *
     * @param string $data        실제 추가할 조건 데이터
     * @param string $empty_value 빈값체크하기 위한 값
     * @param bool   $is_number   데이터 비교가 숫자형인지 유무
     * @param bool   $is_like     Like 검색 유무
     *
     * @param string $op
     *
     * @return string
     */
    function add_where( $field_name, $data, $empty_value, $is_number, $is_like = FALSE, $op = '=' )
    {
        $sql = '';

        if ( $data != $empty_value )
        {
            if ( $this->is_where ) $sql .= ' AND ';
            else
            {
                $sql .= ' WHERE ';
                $this->is_where = TRUE;
            }

            if ( $is_number )
            {
                $sql .= "$field_name $op $data";
            }
            else
            {
                if ( $is_like )
                {
                    $sql .= "$field_name LIKE '%$data%'";
                }
                else
                {
                    $sql .= "$field_name $op '$data'";
                }
            }

            $this->is_where = TRUE;
        }

        return $sql;
    }
    
    // 업데이트문 만들기
	public function makeUpdate ($args) {
		if (is_array($args)) {
			foreach ($args as $v) {
				$tmp[] = $v . " = '$" . $v . "'";
			}
			
			$rst = implode(' , ', $tmp);
		}
		
		return $rst;
	}

    function escape_string($str) {
        return $this->db->escape_str($str);
    }
}
