<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Product
 *
 * @property
 */
class Qna extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model(array('adm/qna_m'));
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

            case "DEL_QNA":
                if (!$q_idx) die(json_encode(array('rst' => 'E0')));

                $args = [];
                $args['q_idx'] = $q_idx;
                $args['q_delyn'] = "Y";
                $result = $this->qna_m -> setQnaModify($args);

                if ($result) {
                    $rst_json = array('rst' => 'S');
                } else {
                    $rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
                }
                break;
        }
        die(json_encode($rst_json));
    }

    function qna_view() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $q_idx = isset($q_idx) ? $q_idx : "";

        $row = $this -> qna_m -> getQnaInfo(['q_idx'=>$q_idx]);

        $this->data['qna_data'] = $row;
        $this->data['title'] = "Contact 상세보기 ";
        $this->data['sub_title'] = '상세보기';

        $this->load->view( '/adm/qna/qna_view', $this->data );
    }

    function qna_list() {
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
        $args['show_row'] = isset($page_row) ? $page_row : 30;
        $args['show_page'] = 10;
        $types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
        foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

        $data = $this->qna_m->getQnaList($args);

        $this->data['L_list'] = $data['data'];
        $this->data['page_link'] = $data['page_info']['link'];
        $this->data['start_num'] = $data['page_info']['start_num'];
        $this->data['total'] = $data['page_info']['total'];
        $this->data['L_list_cnt'] = count($this->data['L_list']);

        //검색조건
        $args = array();
        $args['select_name'] = "sc_type";
        $args['select_arr'] = ['q_subject' => '제목', 'q_content' => '내용'];
        $args['vals'] = isset($sc_type) ? $sc_type : "";
        $args['etc'] = " class='custom-select custom-select-lg ' ";
        $args['basic'] = "- 검색조건 -";
        $args['sort'] = "none_sort";
        $args['arr_type'] = "";
        $this->data['sc_type_sel'] = $this->func->makeSelect($args);

        $this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui');

        $this->data['title'] = 'Contact 관리';
        $this->data['sub_title'] = 'Contract';

        $this->render('/adm/qna/qna_list', $this->data, LAYOUT_HLCF);
    }
}