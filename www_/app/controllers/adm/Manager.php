<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


/**
 * Class Ads
 *
 * @property
 */
class Manager extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model( 'adm/auth_m');
        $this->GP = $this->load->get_vars();

        $this->post = $this->security->xss_clean($this->input->post());
        $this->get = $this->security->xss_clean($this->input->get());

        if (!$this->func->isAdm()) {
            redirect('/adm/auth', 'refresh');
        }

        if (isset($_SESSION['sess_adm']['sess_menu'])) {
            $this->func->AdmMenuAuthChk();
        }

        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    function _remap($method)
    {
        if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->index();
        }
    }

    public function index()
    {
        $this->func->putMsgAndBack('찾으시는 페이지가  존재하지 않습니다.');
    }

    public function act_proc() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $mode = isset($mode) ? $mode : "";
        $rst_json = array();

        switch($mode) {

            case "MOD_SITE" :
                if (!$id) die(json_encode(array('rst' => 'E0')));

                $args = [];
                $args['id'] = $id;
                $args['domain'] = $domain;
                $args['saup_company'] = $saup_company;
                $args['saup_ceo'] = $saup_ceo;
                $args['saup_num'] = $saup_num;
                $args['saup_zip1'] = $saup_zip1;
                $args['saup_adr'] = $saup_adr;
                $args['saup_uptae'] = $saup_uptae;
                $args['saup_jong'] = $saup_jong;
                $args['site_tel'] = $site_tel;
                $args['site_fax'] = $site_fax;
                $args['site_email'] = $site_email;
                $args['damdang'] = $damdang;
                $args['damdang_tel'] = $damdang_tel;
                $args['damdang_htel'] = $damdang_htel;
                $args['damdang_email'] = $damdang_email;
                $args['admin_bu_num'] = $admin_bu_num;
                $args['admin_tong_num'] = $admin_tong_num;
                $args['admin_bank1'] = $admin_bank1;
                $args['admin_bank2'] = $admin_bank2;
                $args['admin_bank3'] = $admin_bank3;
                $args['admin_bank4'] = $admin_bank4;
                $args['admin_bank5'] = $admin_bank5;
                $args['oadmin_bank1'] = $oadmin_bank1;
                $args['oadmin_bank2'] = $oadmin_bank2;
                $args['oadmin_bank3'] = $oadmin_bank3;
                $args['oadmin_bank4'] = $oadmin_bank4;
                $args['oadmin_bank5'] = $oadmin_bank5;
                $args['sadmin_bank1'] = $sadmin_bank1;
                $args['sadmin_bank2'] = $sadmin_bank2;
                $args['sadmin_bank3'] = $sadmin_bank3;
                $args['sadmin_bank4'] = $sadmin_bank4;
                $args['sadmin_bank5'] = $sadmin_bank5;
                $result = $this->auth_m->setSiteModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
            break;

            case "DEL_ADM":
                if (!$adm_idx) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['adm_idx'] = $adm_idx;
                $args['delyn'] = 'Y';
                $result = $this->auth_m->setAdminModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
                break;

            case "AUTH_ADM":
                if (!$adm_idx) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['adm_idx'] = $adm_idx;
                $args['adm_menu'] = implode(",", array_filter($tl_menu));
                $result = $this->auth_m->setAdminModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
                break;

            case "ADM_ID_DUPCHECK":
                if (!$adm_id) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['adm_id'] = $adm_id;
                $result = $this->auth_m->getAdmIdDupCheck($args);

                if ($result['cnt'] > 0) {
                    $rst_json = array('rst' => 'E1');
                } else {
                    $rst_json = array('rst' => 'S');
                }
                break;

            case "ADD_ADM":
                if (!$adm_id) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['adm_id']         = $adm_id;
                $args['adm_pw']         = hash("sha256", $adm_pw);
                $args['adm_name']       = $adm_name;
                $args['adm_department'] = $adm_department;
                $args['adm_position']   = $adm_position;
                $args['adm_tel']        = $adm_tel;
                $args['adm_email']      = isset($adm_email) ? $adm_email : "";
                $args['adm_entry_date'] = isset($adm_entry_date) ? $adm_entry_date : "";
                $args['adm_birthday']   = isset($adm_birthday) ? $adm_birthday : "";
                $args['adm_status']     = $adm_status;
                $args['adm_menu']       = "";
                $result = $this->auth_m->setAdminInsert($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '등록에 실패하였습니다.');
                }
                break;

            case "MOD_ADM":
                if (!$adm_idx) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['adm_idx']         = $adm_idx;
                $args['adm_id']         = $adm_id;

                if (isset($adm_pw_chk) == "Y") {
                    $args['adm_pw'] = hash("sha256", $adm_pw);
                }
                $args['adm_name']       = $adm_name;
                $args['adm_department'] = $adm_department;
                $args['adm_position']   = $adm_position;
                $args['adm_tel']        = $adm_tel;
                $args['adm_email']      = isset($adm_email) ? $adm_email : "";
                $args['adm_entry_date'] = isset($adm_entry_date) ? $adm_entry_date : "";
                $args['adm_birthday']   = isset($adm_birthday) ? $adm_birthday : "";
                $args['adm_status']     = $adm_status;
                $result = $this->auth_m->setAdminModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
                break;
        }
        die(json_encode($rst_json));
    }

    public function site_setup() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data['site_data'] = $site_data = $this -> auth_m -> getSiteInfo();
        $this->data['title'] = "설정";
        $this->data['sub_title'] = '사이트 정보설정';
        $this->data['btn_txt'] = "저장";

        $this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui', 'validate');

        $this->render('/adm/manager/site_setup', $this->data, LAYOUT_HLCF);
    }

    public function mng_auth() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        if (isset($adm_idx)) {
            $args['adm_idx'] = $adm_idx;
            $this->data['adm_data'] = $adm_data = $this -> auth_m -> getAdmInfo($args);

            if (isset($adm_data)) {
                foreach ($adm_data as $k => $v) $this->data[$k] = ${$k} = $v;
            }

            $this->data['title'] = "설정 ";
            $this->data['sub_title'] = '권한 설정 수정';
            $this->data['btn_txt'] = "수정";
        } else {
            $this->data['title'] = "설정";
            $this->data['sub_title'] = '권한 설정 등록';
            $this->data['btn_txt'] = "등록";
        }

        $this->load->view( '/adm/manager/mng_auth', $this->data );
    }

    public function mng_add() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $adm_idx = isset($adm_idx) ? $adm_idx : "";

        if ($adm_idx && $mode) {
            $row = $this -> auth_m -> getAdmInfo(['adm_idx'=>$adm_idx]);

            $this->data['adm_data'] = $row;
            $this->data['title'] = "설정";
            $this->data['sub_title'] = '관리자 수정';
            $this->data['btn_txt'] = "수정";
            $this->data['mode'] = $mode;

            $this->data = $this -> fnc_sel_box($row);
        } else {
            $this->data['title'] = "설정";
            $this->data['sub_title'] = '관리자 등록';
            $this->data['mode'] = "ADD_ADM";
            $this->data['btn_txt'] = "등록";

            $this->data = $this -> fnc_sel_box();
        }

        $this->load->view( '/adm/manager/mng_add', $this->data );
    }

    // desc : 관리자 리스트
    // auth  : JH
    // param :
    public function mng_list() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data[ 'title' ] = '설정 관리';
        $this->data[ 'sub_title' ] = '관리자 리스트';

        $args = array();
        if(isset($excel_file)) {
            $args['excel_file'] = $excel_file;
        }
        $args['page'] = isset($page) ? $page : 1;
        $args['show_row'] = isset($page_row) ? $page_row : 10;

        $types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
        foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

        $data = $this -> auth_m -> getAdmList($args);

        $this->data['L_list'] 			= $data['data'];
        $this->data['page_link'] 		= $data['page_info']['link'];
        $this->data['start_num'] 		= $data['page_info']['start_num'];
        $this->data['total'] 			= $data['page_info']['total'];
        $this->data['L_list_cnt'] 		= count($this->data['L_list']);

        $this->data = $this->fnc_sel_box();

        $this->data['JS_MODULE'] = array('select2','datepicker','validate');

        $this->render( '/adm/manager/mng_list', $this->data, LAYOUT_HLCF );
    }

    private function fnc_sel_box($args = array())
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        if (is_array($args)) {
            foreach ($args as $k => $v) ${$k} = $v;
        }

        //레벨
        $args = array();
        $args['select_name'] 	= "sc_type";
        $args['select_arr'] 	= ['A.adm_id' => '아이디', 'A.adm_name' => '이름'];
        $args['vals'] 			= isset($sc_type) ? $sc_type : "";
        $args['etc'] 			= " class='custom-select custom-select-lg wmin-sm-200 mb-3 mb-sm-0 border-dark' ";
        $args['basic'] 			= "- 선 택 -";
        $args['sort'] 			= "none_sort";
        $args['arr_type'] 		= "";
        $this->data['sc_type_sel'] = $this -> func -> makeSelect($args);

        //VIEW SELECTBOX
        $args = array();
        $args['select_name'] 	= "adm_status";
        $args['select_arr'] 	= $this -> GP['ADM_STATUS'];
        $args['vals'] 			= isset($adm_status) ? $adm_status : "";
        $args['etc'] 			= " class='form-control m-b-xs border-dark' ";
        $args['basic'] 			= "";
        $args['sort'] 			= "none_sort";
        $args['arr_type'] 		= "";
        $this->data['adm_status_sel'] = $this -> func -> makeSelect($args);

        //VIEW SELECTBOX
        $args = array();
        $args['select_name'] 	= "page_row";
        $args['select_arr'] 	= $this -> GP['VIEW_CNT'];
        $args['vals'] 			= isset($page_row) ? $page_row : 10;
        $args['etc'] 			= " class='form-control m-b-xs border-dark' ";
        $args['basic'] 			= "";
        $args['sort'] 			= "none_sort";
        $args['arr_type'] 		= "";
        $this->data['search_view'] = $this -> func -> makeSelect($args);

        return $this->data;
    }
}