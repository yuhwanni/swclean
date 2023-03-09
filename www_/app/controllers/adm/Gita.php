<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Ads
 *
 * @property
 */
class Gita extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model('adm/gita_m');
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
            case "DEL_IMG_POPUP" :

                $del_photo = isset($del_photo) ? $del_photo : "";
                $del_id = isset($del_id) ? $del_id : "";

                if (empty($del_photo) || empty($del_id)) {
                    die(json_encode(array('rst' => 'E0')));
                }

                $args = array();
                $args['pop_idx'] = isset($del_id) ? $del_id : "";
                $row = $this->gita_m->getPopupInfo($args);

                //파일 풀경로 : 폴더명 +  파일명
                $full_file_nm = $this->GP['POPUP_IMG_DIR'] . $del_photo;

                $args = array();
                $args['pop_idx'] = $del_id;
                $args['pop_file'] = '';
                $result = $this->gita_m->setPopupModify($args);

                @unlink($full_file_nm);

                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "삭제 되었습니다.");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
                break;


            case "MOD_POPUP" :
                if (!$pop_idx) die(json_encode(array('rst' => 'E0')));

                $args = [];

                if (isset($_FILES["pop_file"]['name']) && !empty($_FILES["pop_file"]['name'])) {
                    $img_result = $this->func->img_upload_resize($this->GP['POPUP_IMG_DIR'], 'pop_file', false, '160', '160', false);
                    $args['pop_file'] = $img_result['target_file'];
                } else {
                    $args['pop_file'] = isset($pop_file_old) ? $pop_file_old : "";
                }

                $args['pop_idx'] 				= isset($pop_idx) ? $pop_idx : '';
                $args['pop_type'] 				= isset($pop_type) ? $pop_type : '';
                $args['pop_start_date'] 		= isset($pop_start_date) ? $pop_start_date : '';
                $args['pop_end_date'] 			= isset($pop_end_date) ? $pop_end_date : '';
                $args['pop_title'] 				= isset($pop_title) ? $pop_title : '';
                $args['pop_use'] 				= isset($pop_use) ? $pop_use : '';
                $args['pop_contents'] 			= isset($pop_contents) ? $this->func->encContentsEdit($pop_contents) : "";
                $args['pop_link_url'] 			= isset($pop_link_url) ? $pop_link_url : '';
                $args['pop_width'] 				= isset($pop_width) ? $pop_width : '';
                $args['pop_height'] 			= isset($pop_height) ? $pop_height : '';
                $args['pop_scroll'] 			= isset($pop_scroll) ? $pop_scroll : '';
                $args['pop_x_position'] 		= isset($pop_x_position) ? $pop_x_position : '';
                $args['pop_y_position'] 		= isset($pop_y_position) ? $pop_y_position : '';
                $args['pop_mod_date'] = date('Y-m-d H:i:s');

                $result = $this->gita_m->setPopupModify($args);
                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "수정 되었습니다.");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
            break;

            case "ADD_POPUP" :

                $args = [];

                if (isset($_FILES["pop_file"]['name']) && !empty($_FILES["pop_file"]['name'])) {
                    $img_result = $this->func->img_upload_resize($this->GP['POPUP_IMG_DIR'], 'pop_file', false, '160', '160', false);
                    $args['pop_file'] = $img_result['target_file'];
                } else {
                    $args['pop_file'] = isset($pop_file_old) ? $pop_file_old : "";
                }

                $args['pop_type'] 				= isset($pop_type) ? $pop_type : '';
                $args['pop_start_date'] 		= isset($pop_start_date) ? $pop_start_date : '';
                $args['pop_end_date'] 			= isset($pop_end_date) ? $pop_end_date : '';
                $args['pop_title'] 				= isset($pop_title) ? $pop_title : '';
                $args['pop_use'] 				= isset($pop_use) ? $pop_use : '';
                $args['pop_contents'] 			= isset($pop_contents) ? $this->func->encContentsEdit($pop_contents) : "";
                $args['pop_link_url'] 			= isset($pop_link_url) ? $pop_link_url : '';
                $args['pop_width'] 				= isset($pop_width) ? $pop_width : '';
                $args['pop_height'] 			= isset($pop_height) ? $pop_height : '';
                $args['pop_scroll'] 			= isset($pop_scroll) ? $pop_scroll : '';
                $args['pop_x_position'] 		= isset($pop_x_position) ? $pop_x_position : '';
                $args['pop_y_position'] 		= isset($pop_y_position) ? $pop_y_position : '';
                $args['pop_reg_date'] = date('Y-m-d H:i:s');

                $result = $this->gita_m->setPopupInsert($args);

                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "등록되었습니다.", "url" => "/adm/gita/popup_list");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
                break;

            case "DEL_POPUP":
                if (!$pop_idx) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['pop_idx'] = $pop_idx;
                $result = $this->gita_m->getPopupInfo($args);

                $pop_file_name = $result['pop_file_name'];
                $editor_img_code = $result['editor_img_code'];

                if($pop_file_name != '') {
                    @unlink($this->GP['POPUP_IMG_DIR'].$pop_file_name);
                }

                if($editor_img_code != '') {
                    $tmp_arr = explode(',', $editor_img_code);
                    for($i=0; $i<count($tmp_arr); $i++) {
                        @unlink($this->GP['EDIT_UPLOAD_DIR'].$tmp_arr[$i]);
                    }
                }
                $result = $this->gita_m -> setPopupDel($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
                break;
        }
        die(json_encode($rst_json));
    }

    public function popup_layer() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $pop_idx = isset($pop_idx) ? $pop_idx : "";


        $row = $this->gita_m->getPopupInfo(['pop_idx' => $pop_idx]);

        $this->data['title'] = "팝업 미리보기";
        $this->data['rst'] = $row;

        $this->render('/adm/gita/popup_preview', $this->data, LAYOUT_EMPTY);
    }


    //DESC : 이미지 다운
    public function getImageDown()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $file_nm= isset($file_nm) ? $file_nm : '';

        $fn_name_arr = explode("/", $file_nm);
        $saveName = end($fn_name_arr);
        $rst_file = $this->GP['POPUP_IMG_DIR'] . $file_nm;


        header("Content-type: image/jpeg");
        header("Content-Disposition: attachment; filename=$saveName");
        header("Pragma: no-cache");
        header("Expires: 0");

        @ini_set("allow_url_fopen", "ON");
        print(file_get_contents($rst_file));
    }

    // DESC : 이미지 상세 팝업
    public function popupImage()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }
        $this->data['rst'] = $this->post;
        $this->load->view('/adm/gita/popup_image_view', $this->data);
    }

    public function popup_mng() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $mode = isset($mode) ? $mode : "";

        if(isset($pop_idx)) {
            $row = $this->gita_m->getPopupInfo(['pop_idx' => $pop_idx]);

            $this->data['p_data'] = $row;

            $this->data['sub_title'] = '팝업 수정';
            $this->data['btn_txt'] = "수정";
            $this->data['mode'] = $mode;
            $this->data = $this->fnc_sel_box($row);
        }else {
            $this->data['sub_title'] = '팝업 등록';
            $this->data['btn_txt'] = "등록";
            $this->data['mode'] = "ADD_POPUP";
            $this->data = $this->fnc_sel_box();
        }

        $this->data['title'] = "팝업 관리";

        $this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui', 'validate');
        $this->data['ADD_SCRIPT'] = "<script src='" . $this->GP['EDITOR_DIR'] . "js/HuskyEZCreator.js'></script>";

        $this->render('/adm/gita/popup_mng', $this->data, LAYOUT_HLCF);
    }

    public function popup_list()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $args = array();
        if (isset($excel_file)) {
            $args['excel_file'] = $excel_file;
        }
        $args['page'] = isset($page) ? $page : 1;
        $args['show_row'] = isset($page_row) ? $page_row : 10;

        $yesterday = $this->func->dateTerm(array('term' => '-7 day'));
        $s_date = isset($s_date) ? $s_date : $yesterday;
        $e_date = isset($e_date) ? $e_date : date('Y-m-d');

        //$types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
        $types = ['sc_type', 'sc_val'];
        foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

        $data = $this->gita_m->getPopupList($args);

        $this->data['L_list'] = $data['data'];
        $this->data['page_link'] = $data['page_info']['link'];
        $this->data['start_num'] = $data['page_info']['start_num'];
        $this->data['total'] = $data['page_info']['total'];
        $this->data['L_list_cnt'] = count($this->data['L_list']);

        $this->data = $this->fnc_sel_box();

        $this->data['title'] = '팝업 관리';
        $this->data['sub_title'] = '팝업 목록';
        $this->data['JS_MODULE'] = array('datepicker', 'select2');

        $this->render('/adm/gita/popup_list', $this->data, LAYOUT_HLCF);
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

        $args = array();
        $args['select_name'] = "sc_type";
        $args['select_arr'] = [
            'pop_title' => '제목'
        ];
        $args['vals'] = isset($sc_type) ? $sc_type : "";
        $args['etc'] = " class='custom-select custom-select-lg wmin-sm-200 mb-3 mb-sm-0 border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['sc_type_sel'] = $this->func->makeSelect($args);

        $args = array();
        $args['radio_name'] = "pop_type";
        $args['radio_arr'] = ['T'=>'TEXT','I' =>'IMAGE'];
        $args['vals'] = isset($pop_type) ? $pop_type : "T";
        $args['etc'] = " class='form-control m-b-xs border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['pop_type_sel'] = $this->func->makeRadio($args);

        $args = array();
        $args['radio_name'] = "pop_use";
        $args['radio_arr'] = ['Y'=>'사용','N' =>'미사용'];
        $args['vals'] = isset($pop_use) ? $pop_use : "Y";
        $args['etc'] = " class='form-control m-b-xs border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['pop_use_sel'] = $this->func->makeRadio($args);

        $args = array();
        $args['radio_name'] = "pop_scroll";
        $args['radio_arr'] = ['Y'=>'사용','N' =>'미사용'];
        $args['vals'] = isset($pop_scroll) ? $pop_scroll : "Y";
        $args['etc'] = " class='form-control m-b-xs border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['pop_scroll_sel'] = $this->func->makeRadio($args);

        $args = array();
        $args['radio_name'] = "pop_today";
        $args['radio_arr'] = ['Y'=>'사용','N' =>'미사용'];
        $args['vals'] = isset($pop_today) ? $pop_today : "Y";
        $args['etc'] = " class='form-control m-b-xs border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['pop_today_sel'] = $this->func->makeRadio($args);

        //VIEW SELECTBOX
        $args = array();
        $args['select_name'] = "page_row";
        $args['select_arr'] = $this->GP['VIEW_CNT'];
        $args['vals'] = isset($page_row) ? $page_row : 10;
        $args['etc'] = " class='form-control m-b-xs border-dark' ";
        $args['basic'] = "- 선 택 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['search_view'] = $this->func->makeSelect($args);

        return $this->data;
    }
}