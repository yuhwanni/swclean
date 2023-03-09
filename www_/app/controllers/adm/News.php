<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Product
 *
 * @property
 */
class News extends FW_Controller
{

	public $GP = "";

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('url', 'security', 'common'));
		$this->load->library('globals');
		$this->load->library('func');
		$this->load->model(array('adm/news_m'));
		$this->GP = $this->load->get_vars();

		//$this->post = $this->security->xss_clean($this->input->post());
        $this->post = $this->input->post();
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

			case "DEL_NEWS":
				if (!$bd_idx) die(json_encode(array('rst' => 'E0')));

				$args = array();
				$args['bd_idx'] = $bd_idx;
				$result = $this->news_m->getNewsInfo($args);

				$bd_file_name = $result['bd_thumb'];

				if($bd_file_name != '') {
					@unlink($this->GP['NEWS_IMG_DIR'].$bd_file_name);
				}

				$args['bd_delyn'] = "Y";
				$result = $this->news_m -> setNewsModify($args);

				if ($result) {
					$rst_json = array('rst' => 'S');
				} else {
					$rst_json = array('rst' => 'E10', 'err' => '변경된 내역이 없습니다.');
				}
				break;

			case "NEWS_IMG_DEL" :

				$del_photo = isset($del_photo) ? $del_photo : "";
				$del_id = isset($del_id) ? $del_id : "";

				if (empty($del_photo) || empty($del_id)) {
					die(json_encode(array('rst' => 'E0')));
				}

				$args = array();
				$args['bd_idx'] = isset($del_id) ? $del_id : "";
				$row = $this->news_m->getNewsInfo($args);

				//파일 풀경로 : 폴더명 +  파일명
				$full_file_nm = $this->GP['NEWS_IMG_DIR'] . $del_photo;

				$args = array();
				$args['bd_idx'] = $del_id;
				$args['bd_thumb'] = '';
				$result = $this->news_m->setNewsModify($args);

				@unlink($full_file_nm);

				if ($result) {
					$rst_json = array('rst' => 'S', 'msgTxt' => "삭제 되었습니다.");
				} else {
					$rst_json = array('rst' => 'E1');
				}
				break;

			case "MOD_NEWS" :
				if (!$bd_idx) die(json_encode(array('rst' => 'E0')));

				$args = [];

                if (isset($_FILES["bd_thumb"]['name']) && !empty($_FILES["bd_thumb"]['name'])) {
                    $img_result = $this->func->img_upload_resize($this->GP['NEWS_IMG_DIR'], 'bd_thumb', true, '640', '640', false);
                    $args['bd_thumb'] = $img_result['target_file'];
                } else {
                    $args['bd_thumb'] = isset($bd_thumb_old) ? $bd_thumb_old : "";
                }

				$args['bd_idx'] = isset($bd_idx) ? $bd_idx : '';;
				$args['bd_type'] = isset($bd_type) ? $bd_type : "";
				$args['bd_subject'] = isset($bd_subject) ? $bd_subject : "";
				$args['bd_writer'] = isset($bd_writer) ? $bd_writer : "";
				$args['bd_content'] = isset($bd_content) ? $this->func->encContentsEdit($bd_content) : "";
				$args['bd_regdate'] = isset($bd_regdate) ? $bd_regdate : "";
				$args['adm_idx'] = $_SESSION['sess_adm']['sess_idx'];

				$result = $this->news_m->setNewsModify($args);

				if ($result) {
					$rst_json = array('rst' => 'S', 'msgTxt' => "수정 되었습니다.");
				} else {
					$rst_json = array('rst' => 'E1');
				}
				break;

			case "ADD_NEWS" :

				$args = [];

				if (isset($_FILES["bd_thumb"]['name']) && !empty($_FILES["bd_thumb"]['name'])) {
					$img_result = $this->func->img_upload_resize($this->GP['NEWS_IMG_DIR'], 'bd_thumb', true, '640', '640', false);
					$args['bd_thumb'] = $img_result['target_file'];
				} else {
					$args['bd_thumb'] = isset($bd_thumb_old) ? $bd_thumb_old : "";
				}

				$args['bd_type'] = isset($bd_type) ? $bd_type : "";
				$args['bd_subject'] = isset($bd_subject) ? $bd_subject : "";
				$args['bd_writer'] = isset($bd_writer) ? $bd_writer : "";
				$args['bd_content'] = isset($bd_content) ? $this->func->encContentsEdit($bd_content) : "";
				$args['bd_regdate'] = isset($bd_regdate) ? $bd_regdate : "";
				$args['adm_idx'] = $_SESSION['sess_adm']['sess_idx'];

				$result = $this->news_m->setNewsInsert($args);

				if ($result) {
					$rst_json = array('rst' => 'S', 'msgTxt' => "등록되었습니다.", "url" => "/adm/news/news_list?type=" . $bd_type);
				} else {
					$rst_json = array('rst' => 'E1');
				}
				break;
		}
		die(json_encode($rst_json));
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
		$rst_file = $this->GP['NEWS_IMG_DIR'] . $file_nm;


		header("Content-type: image/jpeg");
		header("Content-Disposition: attachment; filename=$saveName");
		header("Pragma: no-cache");
		header("Expires: 0");

		@ini_set("allow_url_fopen", "ON");
		print(file_get_contents($rst_file));
	}


	// DESC : 이미지 상세 팝업
	public function thumbImage()
	{
		if (is_array($this->post)) {
			foreach ($this->post as $k => $v) ${$k} = $v;
		}
		if (is_array($this->get)) {
			foreach ($this->get as $k => $v) ${$k} = $v;
		}
		$this->data['rst'] = $this->post;
		$this->load->view('/adm/news/news_image_view', $this->data);
	}

	function news_mng() {
		if (is_array($this->post)) {
			foreach ($this->post as $k => $v) ${$k} = $v;
		}

		if (is_array($this->get)) {
			foreach ($this->get as $k => $v) ${$k} = $v;
		}

		$bd_idx = isset($bd_idx) ? $bd_idx : "";

		if ($bd_idx && $mode) {
			$row = $this -> news_m -> getNewsInfo(['bd_idx'=>$bd_idx]);

			$this->data['news_data'] = $row;
			$this->data['title'] = "게시글 등록";
			if($type == "K") {
				$this->data['sub_title'] = '국문NEWS 수정';
			}else {
				$this->data['sub_title'] = '영문NEWS 수정';
			}
			$this->data['btn_txt'] = "수정";
			$this->data['mode'] = $mode;
		} else {
			$this->data['title'] = "게시글 등록";
			if($type == "K") {
				$this->data['sub_title'] = '국문NEWS 등록';
			}else {
				$this->data['sub_title'] = '영문NEWS 등록';
			}
			$this->data['mode'] = "ADD_NEWS";
			$this->data['btn_txt'] = "등록";
		}
		$this->data['bd_type'] = isset($type) ? $type : "K";

		$this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui', 'validate');
		$this->data['ADD_SCRIPT'] = "<script src='" . $this->GP['EDITOR_DIR'] . "js/HuskyEZCreator.js'></script>";

		$this->render('/adm/news/news_mng', $this->data, LAYOUT_HLCF);
	}

	function news_list() {
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
		$this->data['bd_type'] = $args['bd_type'] = isset($type) ? $type : "K";
		$args['page'] = isset($page) ? $page : 1;
		$args['show_row'] = isset($page_row) ? $page_row : 30;
		$args['show_page'] = 10;
		$types = ['s_date', 'e_date', 'sc_type', 'sc_val'];
		foreach ($types as $v) $this->data[$v] = $args[$v] = isset(${$v}) ? ${$v} : "";

		$data = $this->news_m->getNewsList($args);

		$this->data['L_list'] = $data['data'];
		$this->data['page_link'] = $data['page_info']['link'];
		$this->data['start_num'] = $data['page_info']['start_num'];
		$this->data['total'] = $data['page_info']['total'];
		$this->data['L_list_cnt'] = count($this->data['L_list']);

		//검색조건
		$args = array();
		$args['select_name'] = "sc_type";
		$args['select_arr'] = ['bd_subject' => '제목', 'bd_content' => '내용'];
		$args['vals'] = isset($sc_type) ? $sc_type : "";
		$args['etc'] = " class='custom-select custom-select-lg ' ";
		$args['basic'] = "- 검색조건 -";
		$args['sort'] = "none_sort";
		$args['arr_type'] = "";
		$this->data['sc_type_sel'] = $this->func->makeSelect($args);

		$this->data['JS_MODULE'] = array('select2', 'datepicker', 'blockui');

        $this->data['title'] = '게시판 관리';
        $this->data['sub_title'] = $this->data['bd_type'] == "K" ? '국문 NEWS' : '영문 NEWS';

		$this->render('/adm/news/news_list', $this->data, LAYOUT_HLCF);
	}
}