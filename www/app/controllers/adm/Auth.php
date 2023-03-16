<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Class Auth
 *
 * @property
 */
class Auth extends FW_Controller {

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url','security','common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model( 'adm/auth_m');
        $this->GP =  $this->load->get_vars();

        $this->post = $this->security->xss_clean($this->input->post());
        $this->get = $this->security->xss_clean($this->input->get());

        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    function _remap($method)
    {
        if(method_exists($this, $method))
        {
            $this->{$method}();
        }
        else
        {
            $this->index();
        }
    }

    public function index() {
        $this->login();
        //$this->func->putMsgAndBack('찾으시는 페이지가  존재하지 않습니다.');
    }

    public function act_proc() {

        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        switch($mode){

            case "LOGIN_ADM" : // 관리자 로그인

                $args = array();
                $args['adm_id'] 	= $adm_id;
                $rst = $this -> auth_m -> getAdmLoginChk($args);

                if(empty($rst)) {
                    $rst = array('rst' => 'E1', 'msg' => '아이디 혹은 패스워드가 틀립니다.', 'url' => '/');
                    die(json_encode($rst));
                }

                $input_pw = hash("sha256", $adm_pw);
                $chk_pw	= $rst['adm_pw'];

                if($input_pw == $chk_pw) {
                    $_SESSION['sess_adm']['sess_idx'] = $rst['adm_idx'];
                    $_SESSION['sess_adm']['sess_id'] = $rst['adm_id'];
                    $_SESSION['sess_adm']['sess_name'] = $rst['adm_name'];
                    $_SESSION['sess_adm']['sess_type'] = $rst['adm_type'];
                    $_SESSION['sess_adm']['sess_menu'] = $rst['adm_menu'];

                    $backurl = (isset($backurl)) ? $backurl : "";

                    if(strpos($backurl, 'logout') !== false) {
                        $url = "/adm/manager/mng_list";
                    } else {
                        if($backurl != '') {
                            $url = $backurl;
                        }else{
                            $url = "/adm/manager/mng_list";
                        }
                    }

                    $rst = array('rst' => 'S', 'url' => $url);
                }else{
                    $rst = array('rst' => 'E1', 'msg' => '아이디 혹은 패스워드가 틀립니다.', 'url' => '/');
                }

                break;
        }

        die(json_encode($rst));
    }

    // log the user in
    public function login()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        if ($this->func->isAdm()) {
            redirect( '/adm/manager/mng_list', 'refresh' );
        }

        $this->data['title'] = "관리자 로그인";
        $this->data['backurl'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
        $this->data['JS_MODULE'] = array('validate');
        $this->render( 'adm/auth/login', $this->data, LAYOUT_C );
    }

    public function logout() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        // Destroy the session
        unset($_SESSION['sess_adm']['sess_idx']);
        unset($_SESSION['sess_adm']['sess_id']);
        unset($_SESSION['sess_adm']['sess_name']);
        unset($_SESSION['sess_adm']['sess_type']);
        unset($_SESSION['sess_adm']['sess_menu']);
        session_destroy();
        session_unset();
        redirect( 'adm/auth/login', 'refresh' );
    }
}