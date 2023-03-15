<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Class Home
 *
 * @property
 */
class Main extends FW_Controller
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

//        //메인 이미지 관리
//        $args = array();
//        $this->data['main_img_list'] = $this->design_m->getMainImgData($args);

        $this->data['popup_data'] = $this->gita_m->getPopupShow([]);

        $this->render( 'web/kor/index', $this->data, LAYOUT_HLCRF );
    }


}