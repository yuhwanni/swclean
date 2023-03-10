<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Class Home
 *
 * @property
 */
class Kor extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->load->model(array('adm/qna_m','adm/design_m' ,'adm/gita_m', 'adm/news_m'));
        $this->GP = $this->load->get_vars();

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

    function index() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        //$this->data['ADD_SCRIPT'] = "<script src='".WEB_RES."/js/search/search_info.js'></script>";
        $this->data['main_stype'] = "";
        $this->data['JS_MODULE'] = array('');

        //메인 이미지 관리
//        $args = array();
//        $this->data['main_img_list'] = $this->design_m->getMainImgData($args);

        $this->data['popup_data'] = $this->gita_m->getPopupShow([]);

        $this->render( 'web/kor/index', $this->data, LAYOUT_HLCRF );
    }

    function about() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        //$this->data['ADD_SCRIPT'] = "<script src='".WEB_RES."/js/search/search_info.js'></script>";
        $this->data['main_stype'] = "";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/about/greeting', $this->data, LAYOUT_HLCRF );
    }

    function conditioner() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        //$this->data['ADD_SCRIPT'] = "<script src='".WEB_RES."/js/search/search_info.js'></script>";
        $this->data['main_stype'] = "";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/about/conditioner', $this->data, LAYOUT_HLCRF );
    }














    function product() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        //메인 이미지 관리
        $args = array();
        $this->data['main_img_list'] = $this->design_m->getMainImgData($args);

        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/product/index', $this->data, LAYOUT_HLCRF );
    }

    function pixelscope() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/pixelscope/index', $this->data, LAYOUT_HLCRF );
    }


    function sports() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/sports/sports', $this->data, LAYOUT_HLCRF );
    }

    function news() {
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
        $args['list_type'] = "front";
        $args['bd_type'] = "K";

        $types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
        foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

        $data = $this->news_m->getNewsList($args);

        $this->data['L_list'] = $data['data'];
        $this->data['page_link'] = $data['page_info']['link'];
        $this->data['start_num'] = $data['page_info']['start_num'];
        $this->data['total'] = $data['page_info']['total'];
        $this->data['L_list_cnt'] = count($this->data['L_list']);

        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";
        $this->data['JS_MODULE'] = array('');

        $this->render( 'web/kor/news/news', $this->data, LAYOUT_HLCRF );
    }

    function news_view() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $bd_idx = isset($bd_idx) ? $bd_idx : "";

        if ($bd_idx) {
            $row = $this->news_m->getNewsInfo(['bd_idx' => $bd_idx]);
        }

        if(!$row) {
            redirect( '/web/eng/news');
        }
        $this->data['news_data'] = $row;
        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";

        $this->render( 'web/kor/news/news_view', $this->data, LAYOUT_HLCRF );
    }

    function contact() {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }
        if (is_array($this->get)) {
            foreach ($this->get as $k => $v) ${$k} = $v;
        }

        $this->data['image_bg'] = "/web/img/landing/header_bg.jpg";
        $this->data['JS_MODULE'] = array('validate');

        $this->render( 'web/kor/contact/contact', $this->data, LAYOUT_HLCRF );
    }

    public function act_proc()
    {
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) ${$k} = $v;
        }

        switch($mode) {
            case "QNA_KOR":

                $args = [];
                $args['q_type'] = "K";
                $args['q_name'] = isset($name) ? $name : "";
                $args['q_email'] = isset($email) ? $email : "";
                $args['q_subject'] = isset($subject) ? $subject : "";
                $args['q_content'] = isset($message) ? $message : "";
                $result = $this->qna_m->setQnaInsert($args);

                if ($result) {
                    //메일발송
                    $this->load->library('mailsend');

                    $args = array();
                    $args['sender'] = array($this -> GP['EMAIL_DEF'][0], '관리자');
                    $args['reciever'][] = array($this -> GP['CONTACTUS_MAIL'], '관리자님');
                    //$args['reciever'][] = array('info@pxscope.com', '관리자님');
                    //$args['reciever'][] = array('yuhwanni@naver.com', '관리자님');
                    $args['subject'] = $name .'고객의 문의가 접수되었습니다.';
                    $args['contents'] = "제목 : " . $subject . "<br />내용 : " . $message;
                    $this->mailsend->sendMail($args);

                    $rst_json = array('rst' => 'S', 'msgTxt' => "등록되었습니다.");
                } else {
                    $rst_json = array('rst' => 'E1');
                }
            break;
        }
        die(json_encode($rst_json));
    }

}