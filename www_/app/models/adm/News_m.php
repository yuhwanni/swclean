<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Created by
 * User: jh
 * Date: 2021-08-03
 */

/**
 * Class Auth_m
 *
 * @property CI_DB_query_builder $cdb
 */
class News_m extends FW_Model
{
	private $db2 = "";

	public function __construct()
	{
		parent::__construct();

		$this->load->library('listclass');
		$this->db2 = $this->load->database('select', TRUE);
	}

	public function setNewsModify($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		unset($args['bd_idx']);
		return $this->db->update('tb_news', $args, array('bd_idx' => $bd_idx));
	}

	public function setNewsInsert($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$this->db->insert('tb_news', $args);
		return $this->db->insert_id();
	}

	// desc : 정보 가져오기
	// auth  : JH
	// param :
	function getNewsInfo($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		if (isset($bd_idx)) $where = "bd_idx = '$bd_idx' and bd_delyn='N' ";
		$qry = "SELECT * FROM tb_news WHERE " . $where;
		return $this->db2-> query($qry)->row_array();
	}

	// desc : 리스트
	// auth  : JH [ ]
	// param :
	function getNewsList($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$tail = $qry_arr = array();

		$qry_arr[] = " bd_delyn='N' ";

		$types = ['bd_type', 'bd_subject', 'bd_writer'];

		foreach ($types as $v) {
			if (isset(${$v}) && !empty(${$v})) {
				$qry_arr[] = " A." . $v . " = '${$v}' ";
				$tail[] = $v . "=" . ${$v};
			}
		}

		if (!empty($s_date) && !empty($e_date)) {
			$qry_arr[] = " A.bd_regdate BETWEEN '$s_date' AND '$e_date'";
			$tail[] = "s_date=" . $s_date;
			$tail[] = "e_date=" . $e_date;
		}

		if (!empty($search_key) && !empty($search_content)) {
			$qry_arr[] = " $search_key LIKE ('%$search_content%')";
			$tail[] = "search_key='$search_key'";
			$tail[] = "search_content='$search_content'";
		}

		$addQry = implode(' AND ', $qry_arr);
		$addTail = implode('&', $tail);

		$excelHanArr = array();
		$excelHanArr_kr = array();

		$args['search_match'] = array('');
		$args['show_row'] = isset($show_row) ? $show_row : 10;
		$args['show_page'] = isset($show_page) ? $show_page : 5;
		$args['sc_type'] = isset($sc_type) ? $sc_type : "";
		$args['sc_val'] = isset($sc_val) ? $sc_val : "";
		$args['excel'] = $excelHanArr;
		$args['excel_kr'] = $excelHanArr_kr;
		$args['q_idx'] = "bd_idx";
		$args['q_col'] = " * ";
		$args['q_table'] = " tb_news as A";
		$args['q_where'] = $addQry;
		$args['q_order'] = " bd_regdate desc";
		$args['q_group'] = "";
		$args['tail'] = $addTail;
		$args['q_see'] = "";
		return $this -> listclass -> listInfo($args);
	}
}