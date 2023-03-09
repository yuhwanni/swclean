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
class Design_m extends FW_Model
{
    private $db2 = "";
    private $GP = "";

    function __construct()
    {
        parent::__construct();

        $this->load->library(array('listclass', 'globals'));
        $this->GP = $this->load->get_vars();
        $this->db2 = $this->load->database('select', TRUE);
    }

    function getMainImgData($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "SELECT * FROM tb_main_img WHERE mi_delyn='N' AND mi_show='Y' ORDER BY mi_sort ASC";
        return $this->db2-> query($qry)->result_array();
    }

    // DESC :
    // AUTHOR :
    // PARAM :
    public function setMainImgInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('tb_main_img', $args);
        return $this->db->insert_id();
    }

    // DESC :
    // AUTHOR :
    // PARAM :
    public function setMainImgModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['mi_idx']);
        return $this->db->update('tb_main_img', $args, array('mi_idx' => $mi_idx));
    }

    // desc : 관리자 정보 가져오기
    // auth  : JH
    // param :
    function getMainImgInfo($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (isset($mi_idx)) $where = "mi_idx = '$mi_idx' and mi_delyn='N' ";
        $qry = "SELECT * FROM tb_main_img WHERE " . $where;
        return $this->db2-> query($qry)->row_array();
    }

    //메인 이미지 리스트
    function getMainImgList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "mi_delyn='N'";

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " mi_regdate BETWEEN '$s_date 00:00:00' AND '$e_date 23:59:59'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "&sc_type=" . $sc_type;
            $tail[] = "&sc_val=" . $sc_val;
        }

        $addQry = implode(' AND ', $qry_arr);
        $addTail = implode('&', $tail);

        $excelHanArr = array(

        );
        $excelHanArr_kr = array(

        );

        $args['search_match'] = array('');
        $args['show_row'] = isset($show_row) ? $show_row : 30;
        $args['show_page'] = isset($show_page) ? $show_page : 10;
        $args['sc_type'] = isset($sc_type) ? $sc_type : "";
        $args['sc_val'] = isset($sc_val) ? $sc_val : "";
        $args['excel'] = $excelHanArr;
        $args['excel_kr'] = $excelHanArr_kr;
        $args['q_idx'] = "A.mi_idx";
        $args['q_col'] = " 
                            A.*
                        ";
        $args['q_table'] = " tb_main_img as A";
        $args['q_where'] = $addQry;
        $args['q_order'] = "A.mi_idx desc";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }
}