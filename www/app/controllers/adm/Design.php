<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Product
 *
 * @property
 */
class Design extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model(array('adm/design_m'));
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

        //BUFFER 스크립트 초기화
        $this->buffer_script = '';
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


    public function act_proc()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $mode = isset($mode) ? $mode : "";
        $rst_json = array();

        switch ($mode) {

            case "DEL_MAIN_IMG" :
                if (!$mi_idx) die(json_encode(array('rst' => 'E0')));

                $args = [];
                $args['mi_delyn'] = 'Y';
                $args['mi_idx'] = $mi_idx;
                $result = $this->design_m->setMainImgModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '삭제에 실패하였습니다.');
                }
                break;

            case "MOD_MAIN_IMG" :
                if (!isset($mi_idx)) die(json_encode(array('rst' => 'E0')));

                $args = array();
                $args['mi_title_1'] = isset($mi_title_1) ? $mi_title_1 : '';
                $args['mi_title_2'] = isset($mi_title_2) ? $mi_title_2 : '';
                $args['mi_title_3'] = isset($mi_title_3) ? $mi_title_3 : '';
                $args['mi_link'] = isset($mi_link) ? $mi_link : '';
                $args['mi_show'] = isset($mi_show) ? $mi_show : 'N';
                $args['mi_idx'] = isset($mi_idx) ? $mi_idx : '';
                $args['mi_type'] = isset($mi_type) ? $mi_type : '1';

                if (isset($_FILES["mi_img"]['name']) && !empty($_FILES["mi_img"]['name'])) {
                    $img_result = $this->func->img_upload_resize($this->GP['MAIN_IMG_DIR'], 'mi_img', false, '0', '0', false, 'mp4');
                    $args['mi_img'] = $img_result['target_file'];
                } else {
                    $args['mi_img'] = isset($mi_img_old) ? $mi_img_old : "";
                }

                $result = $this->design_m->setMainImgModify($args);
                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "수정 되었습니다.");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
                break;

            case "ADD_MAIN_IMG":
                if (!isset($mi_title_1)) die(json_encode(array('rst' => 'E0')));

                $args = [];
                $args['mi_title_1'] = isset($mi_title_1) ? $mi_title_1 : '';
                $args['mi_title_2'] = isset($mi_title_2) ? $mi_title_2 : '';
                $args['mi_title_3'] = isset($mi_title_3) ? $mi_title_3 : '';
                $args['mi_link'] = isset($mi_link) ? $mi_link : '';
                $args['mi_show'] = isset($mi_show) ? $mi_show : 'N';
                $args['mi_type'] = isset($mi_type) ? $mi_type : '1';


                if (isset($_FILES["mi_img"]['name']) && !empty($_FILES["mi_img"]['name'])) {
                    $img_result = $this->func->img_upload_resize($this->GP['MAIN_IMG_DIR'], 'mi_img', true, '160', '160', false, 'mp4');
                    $args['mi_img'] = $img_result['target_file'];
                } else {
                    $args['mi_img'] = isset($mi_img_old) ? $mi_img_old : "";
                }

                $result = $this->design_m->setMainImgInsert($args);

                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "등록되었습니다.", "url" => "/adm/design/main_img_list");
                } else {
                    $rst_json = array('rst' => 'E1');
                    //등록된 이미지 삭제
                }
                break;

            case "MAIN_IMG_DEL" :
                $del_photo = isset($del_photo) ? $del_photo : "";
                $del_id = isset($del_id) ? $del_id : "";

                if (empty($del_photo) || empty($del_id)) {
                    die(json_encode(array('rst' => 'E0')));
                }

                $args = array();
                $args['mi_idx'] = isset($del_id) ? $del_id : "";
                $row = $this->design_m->getMainImgInfo($args);

                //파일 풀경로 : 폴더명 +  파일명
                $full_file_nm = $this->GP['MAIN_IMG_DIR'] . $del_photo;
                @unlink($full_file_nm);

                $args = array();
                $args['mi_idx'] = isset($del_id) ? $del_id : "";
                $args['mi_img'] = '';
                $result = $this->design_m->setMainImgModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S', 'msgTxt' => "삭제 되었습니다.");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
                break;
        }
        die(json_encode($rst_json));
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
        $this->load->view('/adm/design/imagePopup', $this->data);
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

        $args = array();
        $args['file_nm'] = isset($file_nm) ? $file_nm : '';

        if (empty($args['file_nm'])) {
            show_json_error_adm('', '잘못된 정보입니다.', '', '');
        }

        $this->func->getMainImageDown($args);

    }

    function main_img_add() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $mi_idx = isset($mi_idx) ? $mi_idx : "";

        if ($mi_idx && $mode) {
            $row = $this -> design_m -> getMainImgInfo(['mi_idx'=>$mi_idx]);

            $this->data['rst'] = $row;
            $this->data['title'] = "설정";
            $this->data['sub_title'] = '메인이미지 수정';
            $this->data['btn_txt'] = "수정";
            $this->data['mode'] = $mode;

            $this->data = $this -> fnc_sel_box($row);
        } else {
            $this->data['title'] = "설정";
            $this->data['sub_title'] = '메인이미지 등록';
            $this->data['mode'] = "ADD_MAIN_IMG";
            $this->data['btn_txt'] = "등록";

            $this->data = $this -> fnc_sel_box();
        }

        $this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui','validate');

        $this->render('/adm/design/main_img_mng', $this->data, LAYOUT_HLCF);
    }

    function main_img_list() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data['title'] = '디자인 관리';
        $this->data['sub_title'] = '메인 이미지관리';

        $args = array();
        if (isset($excel_file)) {
            $args['excel_file'] = $excel_file;
        }
        $args['page'] = isset($page) ? $page : 1;
        $args['show_row'] = isset($page_row) ? $page_row : 30;
        $args['show_page'] = 10;
        $types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
        foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

        $data = $this->design_m->getMainImgList($args);

        $this->data['L_list'] = $data['data'];
        $this->data['page_link'] = $data['page_info']['link'];
        $this->data['start_num'] = $data['page_info']['start_num'];
        $this->data['total'] = $data['page_info']['total'];
        $this->data['L_list_cnt'] = count($this->data['L_list']);

        //검색조건
        $args = array();
        $args['select_name'] = "sc_type";
        $args['select_arr'] = ['A.mi_title_1' => '제목'];
        $args['vals'] = isset($sc_type) ? $sc_type : "";
        $args['etc'] = " class='custom-select custom-select-lg ' ";
        $args['basic'] = "- 검색조건 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['sc_type_sel'] = $this->func->makeSelect($args);

        $this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui');

        $this->render('/adm/design/main_img_list', $this->data, LAYOUT_HLCF);
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