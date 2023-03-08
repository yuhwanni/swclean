<?php if ( !defined( 'BASEPATH' ) )
{
    exit( 'No direct script access allowed' );
}

/**
 * Name:  Ion Auth
 * Author: Ben Edmunds
 *          ben.edmunds@gmail.com
 * @benedmunds
 * Added Awesomeness: Phil Sturgeon
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 * Created:  10.01.2009
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux
 * Auth 2 should be. Original Author name has been kept but that does not mean that the method has not been modified.
 * Requirements: PHP5 or above
 * @property CI_DB_query_builder $db                           This is the platform-independent base Active Record
 *           implementation class.
 * @property CI_DB_forge         $dbforge                      Database Utility Class
 * @property CI_Benchmark        $benchmark                    This class enables you to mark points and calculate the
 *           time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar         $calendar                     This class enables the creation of calendars
 * @property CI_Cart             $cart                         Shopping Cart Class
 * @property CI_Config           $config                       This class contains functions that enable config files
 *           to be managed
 * @property CI_Controller       $controller                   This class object is the super class that every library
 *           in.<br />CodeIgniter will be assigned to.
 * @property CI_Email            $email                        Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt          $encrypt                      Provides two-way keyed encoding using XOR Hashing and
 *           Mcrypt
 * @property CI_Exceptions       $exceptions                   Exceptions Class
 * @property CI_Form_validation  $form_validation              Form Validation Class
 * @property CI_Ftp              $ftp                          FTP Class
 * @property CI_Hooks            $hooks                        //dead
 * @property CI_Image_lib        $image_lib                    Image Manipulation class
 * @property CI_Input            $input                        Pre-processes global input data for security
 * @property CI_Lang             $lang                         Language Class
 * @property CI_Loader           $load                         Loads views and files
 * @property CI_Log              $log                          Logging Class
 * @property CI_Model            $model                        CodeIgniter Model Class
 * @property CI_Output           $output                       Responsible for sending final output to browser
 * @property CI_Pagination       $pagination                   Pagination Class
 * @property CI_Parser           $parser                       Parses pseudo-variables contained in the specified
 *           template view,<br />replacing them with the data in the second param
 * @property CI_Profiler         $profiler                     This class enables you to display benchmark, query, and
 *           other data<br />in order to help with debugging and optimization.
 * @property CI_Router           $router                       Parses URIs and determines routing
 * @property CI_Session          $session                      Session Class
 * @property CI_Table            $table                        HTML table generation<br />Lets you create tables
 *           manually or from database result objects, or arrays.
 * @property CI_Trackback        $trackback                    Trackback Sending/Receiving Class
 * @property CI_Typography       $typography                   Typography Class
 * @property CI_Unit_test        $unit_test                    Simple testing class
 * @property CI_Upload           $upload                       File Uploading Class
 * @property CI_URI              $uri                          Parses URIs and determines routing
 * @property CI_User_agent       $user_agent                   Identifies the platform, browser, robot, or mobile
 *           devise of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc                       XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs                      XML-RPC server class
 * @property CI_Zip              $zip                          Zip Compression Class
 * @property CI_Javascript       $javascript                   Javascript Class
 * @property CI_Jquery           $jquery                       Jquery Class
 * @property CI_Utf8             $utf8                         Provides support for UTF-8 environments
 * @property CI_Security         $security                     Security Class, xss, csrf, etc...
 * @property CI_Driver_Library   $driver                       CodeIgniter Driver Library Class
 * @property CI_Cache            $cache                        CodeIgniter Caching Class
 * @property Ion_auth_model      $ion_auth_model
 *
 * @method bool|string hash_password($password, $salt=false, $use_sha1_override=false)
 * @method bool hash_password_db($id, $password, $use_sha1_override=false)
 * @method bool|string hash_code($password)
 * @method string salt()
 * @method bool activate($id,$code=false)
 * @method bool deactivate($id=null)
 * @method bool clear_forgotten_password_code($code)
 * @method bool reset_password($identity,$new)
 * @method bool change_password($identity,$old,$new)
 * @method bool username_check($username='')
 * @method bool email_check($email='')
 * @method bool identify_check($identity='')
 * @method bool login($identity,$password,$remember=false)
 * @method bool is_max_login_attempts_exceeded($identity)
 * @method int get_attempts_num($identity)
 * @method bool is_time_locked_out($identify)
 * @method int get_last_attempt_time($identity)
 * @method bool increase_login_attempts($identity)
 * @method bool|mixed clear_login_attempts($identity,$expire_period=86400)
 *
 * @method Ion_auth_model limit($limit)
 * @method Ion_auth_model offset($offset)
 * @method Ion_auth_model where($where,$value=null)
 * @method Ion_auth_model like($like,$value=null,$position='both')
 * @method Ion_auth_model select($select)
 * @method Ion_auth_model order_by($by,$order='desc')
 * @method Ion_auth_model row()
 * @method Ion_auth_model row_array()
 * @method Ion_auth_model result()
 * @method Ion_auth_model result_array()
 * @method Ion_auth_model num_rows()
 *
 * @method object users($groups=null)
 * @method object user($id=null)
 * @method array|object get_users_groups($id=false)
 * @method bool add_to_group($group_ids,$user_id=false)
 * @method bool remove_from_group($group_ids=false,$user_id=false)
 * @method object groups()
 * @method object group($id=null)
 * @method bool update($id, array $data)
 * @method bool delete_user($id)
 * @method bool update_last_login($id)
 * @method bool set_lang($lang='en')
 * @method bool set_session($user)
 * @method bool remember_user($id)
 * @method bool login_remembered_user()
 * @method bool create_group($group_name=false,$group_description='',$additional_data=array())
 * @method bool update_group($group_name=false,$group_description='',$additional_data=array())
 * @method bool delete_group($group_id=false)
 * @method void set_hook($event,$name,$class,$method,$arguments)
 * @method void remove_hook($event,$name)
 * @method void remove_hooks($event)
 * @method void trigger_events($events)
 *
 * @method bool set_message_delimiters($start_delimiter,$end_delimiter)
 * @method bool set_error_delimiters($start_delimiter,$end_delimiter)
 * @method array set_message($message)
 * @method string messages()
 * @method array messages_array($langify=true)
 * @method bool clear_messages()
 * @method array set_error($error)
 * @method string errors()
 * @method array errors_array($langify=true)
 * @method bool clear_errors()
 */
class Ion_auth
{
    /**
     * account status ('not_activated', etc ...)
     * @var string
     **/
    protected $status;
    /**
     * extra where
     * @var array
     **/
    public $_extra_where = array();
    /**
     * extra set
     * @var array
     **/
    public $_extra_set = array();
    /**
     * caching of users and their groups
     * @var array
     **/
    public $_cache_user_in_group;

    /**
     * __construct
     * @author Ben
     */
    public function __construct()
    {
        $this->load->config( 'ion_auth', true );
        $this->load->library( array( 'email' ) );
        $this->lang->load( 'ion_auth' );
        $this->load->helper( array( 'cookie', 'language', 'url' ) );

        $this->load->library( 'session' );

        $this->load->model( 'ion_auth_model' );

        $this->_cache_user_in_group =& $this->ion_auth_model->_cache_user_in_group;

        //auto-login the user if they are remembered
        if ( !$this->logged_in() && get_cookie( $this->config->item( 'identity_cookie_name', 'ion_auth' ) ) && get_cookie( $this->config->item( 'remember_cookie_name', 'ion_auth' ) ) )
        {
            $this->ion_auth_model->login_remembered_user();
        }

        $email_config = $this->config->item( 'email_config', 'ion_auth' );

        if ( $this->config->item( 'use_ci_email', 'ion_auth' ) && isset( $email_config ) && is_array( $email_config ) )
        {
            $this->email->initialize( $email_config );
        }

        $this->ion_auth_model->trigger_events( 'library_constructor' );
    }

    /**
     * __call
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     * @throws Exception
     */
    public function __call( $method, $arguments )
    {    	
        if ( !method_exists( $this->ion_auth_model, $method ) )
        {
            throw new Exception( 'Undefined method Ion_auth::' . $method . '() called' );
        }
        if ( $method == 'create_user' )
        {
            return call_user_func_array( array( $this, 'register' ), $arguments );
        }
        if ( $method == 'update_user' )
        {
            return call_user_func_array( array( $this, 'update' ), $arguments );
        }

        return call_user_func_array( array( $this->ion_auth_model, $method ), $arguments );
    }

    /**
     * __get
     * Enables the use of CI super-global without having to define an extra variable.
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     * @access    public
     *
     * @param    $var
     *
     * @return    mixed
     */
    public function __get( $var )
    {
        return get_instance()->$var;
    }

    /**
     * forgotten password feature
     *
     * @param $identity
     *
     * @return mixed boolean / array
     * @author Mathew
     */
    public function forgotten_password( $identity )    //changed $email to $identity
    {
        if ( $this->ion_auth_model->forgotten_password( $identity ) )   //changed
        {
            // Get user information
            $identifier = $this->ion_auth_model->identity_column; // use model identity column, so it can be overridden in a controller
            $user       = $this->where( $identifier, $identity )->where( 'active', 1 )->users()->row();  // changed to get_user_by_identity from email

            if ( $user )
            {
                $data = array( 'identity' => $user->{$this->config->item( 'identity', 'ion_auth' )}, 'forgotten_password_code' => $user->forgotten_password_code );

                if ( !$this->config->item( 'use_ci_email', 'ion_auth' ) )
                {
                    $this->set_message( 'forgot_password_successful' );

                    return $data;
                }
                else
                {
                    $message = $this->load->view( $this->config->item( 'email_templates', 'ion_auth' ) . $this->config->item( 'email_forgot_password', 'ion_auth' ), $data, true );
                    $this->email->clear();
                    $this->email->from( $this->config->item( 'admin_email', 'ion_auth' ), $this->config->item( 'site_title', 'ion_auth' ) );
                    $this->email->to( $user->email );
                    $this->email->subject( $this->config->item( 'site_title', 'ion_auth' ) . ' - ' . $this->lang->line( 'email_forgotten_password_subject' ) );
                    $this->email->message( $message );

                    if ( $this->email->send() )
                    {
                        $this->set_message( 'forgot_password_successful' );

                        return true;
                    }
                    else
                    {
                        $this->set_error( 'forgot_password_unsuccessful' );

                        return false;
                    }
                }
            }
            else
            {
                $this->set_error( 'forgot_password_unsuccessful' );

                return false;
            }
        }
        else
        {
            $this->set_error( 'forgot_password_unsuccessful' );

            return false;
        }
    }

    /**
     * forgotten_password_complete

     *
*@param $code

     *
*@author Mathew
     * @return array|bool
     */
    public function forgotten_password_complete( $code )
    {
        $this->ion_auth_model->trigger_events( 'pre_password_change' );

        $identity = $this->config->item( 'identity', 'ion_auth' );
        $profile  = $this->where( 'forgotten_password_code', $code )->users()->row(); //pass the code to profile

        if ( !$profile )
        {
            $this->ion_auth_model->trigger_events( array( 'post_password_change', 'password_change_unsuccessful' ) );
            $this->set_error( 'password_change_unsuccessful' );

            return false;
        }

        $new_password = $this->ion_auth_model->forgotten_password_complete( $code, $profile->salt );

        if ( $new_password )
        {
            $data = array( 'identity' => $profile->{$identity}, 'new_password' => $new_password );
            if ( !$this->config->item( 'use_ci_email', 'ion_auth' ) )
            {
                $this->set_message( 'password_change_successful' );
                $this->ion_auth_model->trigger_events( array( 'post_password_change', 'password_change_successful' ) );

                return $data;
            }
            else
            {
                $message = $this->load->view( $this->config->item( 'email_templates', 'ion_auth' ) . $this->config->item( 'email_forgot_password_complete', 'ion_auth' ), $data, true );

                $this->email->clear();
                $this->email->from( $this->config->item( 'admin_email', 'ion_auth' ), $this->config->item( 'site_title', 'ion_auth' ) );
                $this->email->to( $profile->email );
                $this->email->subject( $this->config->item( 'site_title', 'ion_auth' ) . ' - ' . $this->lang->line( 'email_new_password_subject' ) );
                $this->email->message( $message );

                if ( $this->email->send() )
                {
                    $this->set_message( 'password_change_successful' );
                    $this->ion_auth_model->trigger_events( array( 'post_password_change', 'password_change_successful' ) );

                    return true;
                }
                else
                {
                    $this->set_error( 'password_change_unsuccessful' );
                    $this->ion_auth_model->trigger_events( array( 'post_password_change', 'password_change_unsuccessful' ) );

                    return false;
                }
            }
        }

        $this->ion_auth_model->trigger_events( array( 'post_password_change', 'password_change_unsuccessful' ) );

        return false;
    }

    /**
     * forgotten_password_check
     *
     * @param $code
     *
     * @author Michael
     * @return bool
     */
    public function forgotten_password_check( $code )
    {
        $profile = $this->where( 'forgotten_password_code', $code )->users()->row(); //pass the code to profile

        if ( !is_object( $profile ) )
        {
            $this->set_error( 'password_change_unsuccessful' );

            return false;
        }
        else
        {
            if ( $this->config->item( 'forgot_password_expiration', 'ion_auth' ) > 0 )
            {
                //Make sure it isn't expired
                $expiration = $this->config->item( 'forgot_password_expiration', 'ion_auth' );
                if ( time() - $profile->forgotten_password_time > $expiration )
                {
                    //it has expired
                    $this->clear_forgotten_password_code( $code );
                    $this->set_error( 'password_change_unsuccessful' );

                    return false;
                }
            }

            return $profile;
        }
    }

    /**
     * register

     *
*@param       $identity
     * @param       $password
     * @param       $email
     * @param array $additional_data
     * @param array $group_ids

     *
*@author Mathew
     * @return array|bool
     */
    public function register( $identity, $password, $email, $additional_data = array(), $group_ids = array() ) //need to test email activation
    {
        $this->ion_auth_model->trigger_events( 'pre_account_creation' );

        $email_activation = $this->config->item( 'email_activation', 'ion_auth' );

        $id = $this->ion_auth_model->register( $identity, $password, $email, $additional_data, $group_ids );

        if ( !$email_activation )
        {
            if ( $id !== false )
            {
                $this->set_message( 'account_creation_successful' );
                $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_successful' ) );

                return $id;
            }
            else
            {
                $this->set_error( 'account_creation_unsuccessful' );
                $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_unsuccessful' ) );

                return false;
            }
        }
        else
        {
            if ( !$id )
            {
                $this->set_error( 'account_creation_unsuccessful' );

                return false;
            }

            // deactivate so the user much follow the activation flow
            $deactivate = $this->ion_auth_model->deactivate( $id );

            // the deactivate method call adds a message, here we need to clear that
            $this->ion_auth_model->clear_messages();

            if ( !$deactivate )
            {
                $this->set_error( 'deactivate_unsuccessful' );
                $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_unsuccessful' ) );

                return false;
            }

            $activation_code = $this->ion_auth_model->activation_code;
            $identity        = $this->config->item( 'identity', 'ion_auth' );
            $user            = $this->ion_auth_model->user( $id )->row();

            $data = array( 'identity' => $user->{$identity}, 'id' => $user->id, 'email' => $email, 'activation' => $activation_code, );
            if ( !$this->config->item( 'use_ci_email', 'ion_auth' ) )
            {
                $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_successful', 'activation_email_successful' ) );
                $this->set_message( 'activation_email_successful' );

                return $data;
            }
            else
            {
                $message = $this->load->view( $this->config->item( 'email_templates', 'ion_auth' ) . $this->config->item( 'email_activate', 'ion_auth' ), $data, true );

                $this->email->clear();
                $this->email->from( $this->config->item( 'admin_email', 'ion_auth' ), $this->config->item( 'site_title', 'ion_auth' ) );
                $this->email->to( $email );
                $this->email->subject( $this->config->item( 'site_title', 'ion_auth' ) . ' - ' . $this->lang->line( 'email_activation_subject' ) );
                $this->email->message( $message );

                if ( $this->email->send() == true )
                {
                    $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_successful', 'activation_email_successful' ) );
                    $this->set_message( 'activation_email_successful' );

                    return $id;
                }
            }

            $this->ion_auth_model->trigger_events( array( 'post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful' ) );
            $this->set_error( 'activation_email_unsuccessful' );

            return false;
        }
    }

    /**
     * logout
     * @return bool|void
     * @author Mathew
     **/
    public function logout()
    {
        $this->ion_auth_model->trigger_events( 'logout' );

        $identity = $this->config->item( 'identity', 'ion_auth' );

        if ( substr( CI_VERSION, 0, 1 ) == '2' )
        {
            $this->session->unset_userdata( array( $identity => '', 'id' => '', 'user_id' => '' ) );
        }
        else
        {
            $this->session->unset_userdata( array( $identity, 'id', 'user_id' ) );
        }

        // delete the remember me cookies if they exist
        if ( get_cookie( $this->config->item( 'identity_cookie_name', 'ion_auth' ) ) )
        {
            delete_cookie( $this->config->item( 'identity_cookie_name', 'ion_auth' ) );
        }
        if ( get_cookie( $this->config->item( 'remember_cookie_name', 'ion_auth' ) ) )
        {
            delete_cookie( $this->config->item( 'remember_cookie_name', 'ion_auth' ) );
        }

        // Destroy the session
        $this->session->sess_destroy();

        //Recreate the session
        if ( substr( CI_VERSION, 0, 1 ) == '2' )
        {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->session->sess_create();
        }
        else
        {
            if ( version_compare( PHP_VERSION, '7.0.0' ) >= 0 )
            {
                session_start();
            }
            $this->session->sess_regenerate( true );
        }

        $this->set_message( 'logout_successful' );

        return true;
    }

    /**
     * logged_in
     * @return bool
     * @author Mathew
     **/
    public function logged_in()
    {
        $this->ion_auth_model->trigger_events( 'logged_in' );

        return (bool)$this->session->userdata( 'identity' );
    }

    /**
     * logged_in
     * @return integer
     * @author jrmadsen67
     **/
    public function get_user_id()
    {
        $user_id = $this->session->userdata( 'user_id' );
        if ( !empty( $user_id ) )
        {
            return $user_id;
        }

        return null;
    }

    /**
     * is_admin
     *
     * @param bool $id
     *
     * @return bool
     * @author Ben Edmunds
     */
    public function is_admin( $id = false )
    {
        $this->ion_auth_model->trigger_events( 'is_admin' );

        $admin_group = $this->config->item( 'admin_group', 'ion_auth' );

        return $this->in_group( $admin_group, $id );
    }

    /**
     * in_group
     *
     * @param mixed $check_group group(s) to check
     * @param bool  $id user id
     * @param bool  $check_all check if all groups is present, or any of the groups
     *
     * @return bool
     * @author Phil Sturgeon
     **/
    public function in_group( $check_group, $id = false, $check_all = false )
    {
        $this->ion_auth_model->trigger_events( 'in_group' );

        $id || $id = $this->session->userdata( 'user_id' );

        if ( !is_array( $check_group ) )
        {
            $check_group = array( $check_group );
        }

        if ( isset( $this->_cache_user_in_group[ $id ] ) )
        {
            $groups_array = $this->_cache_user_in_group[ $id ];
        }
        else
        {
            $users_groups = $this->ion_auth_model->get_users_groups( $id )->result();
            $groups_array = array();
            foreach ( $users_groups as $group )
            {
                $groups_array[ $group->id ] = $group->name;
            }
            $this->_cache_user_in_group[ $id ] = $groups_array;
        }
        foreach ( $check_group as $key => $value )
        {
            $groups = ( is_string( $value ) ) ? $groups_array : array_keys( $groups_array );

            /**
             * if !all (default), in_array
             * if all, !in_array
             */
            if ( in_array( $value, $groups ) xor $check_all )
            {
                /**
                 * if !all (default), true
                 * if all, false
                 */
                return !$check_all;
            }
        }

        /**
         * if !all (default), false
         * if all, true
         */
        return $check_all;
    }
}
