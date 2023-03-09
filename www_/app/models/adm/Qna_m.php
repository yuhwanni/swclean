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
class Qna_m extends FW_Model
{
    private $db2 = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->library('listclass');
        $this->db2 = $this->load->database('select', TRUE);
    }


    public function setQnaModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['q_idx']);
        return $this->db->update('tb_qna', $args, array('q_idx' => $q_idx));
    }

    public function setQnaInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('tb_qna', $args);
        return $this->db->insert_id();
    }

    // desc : 정보 가져오기
    // auth  : JH
    // param :
    function getQnaInfo($args = array())
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (isset($q_idx)) $where = "q_idx = '$q_idx' and q_delyn='N' ";
        $qry = "SELECT * FROM tb_qna WHERE " . $where;
        return $this->db2->query($qry)->row_array();
    }


    // desc : 리스트
    // auth  : JH [ ]
    // param :
    function getQnaList($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " q_delyn='N' ";

        $types = ['q_type', 'q_subject'];

        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " A.q_regdate BETWEEN '$s_date' AND '$e_date'";
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
        $args['q_idx'] = "q_idx";
        $args['q_col'] = " * ";
        $args['q_table'] = " tb_qna as A";
        $args['q_where'] = $addQry;
        $args['q_order'] = " q_idx DESC";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }
}