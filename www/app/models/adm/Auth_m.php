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
class Auth_m extends FW_Model
{
    private $db2 = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->library('listclass');
        $this->db2 = $this->load->database('select', TRUE);
    }

    public function getSiteInfo() {
        $qry = "SELECT * FROM tb_site_setup where 1=1";
        $rst = $this->db->query($qry)->row_array();
        return $rst;
    }

    // DESC : 관리자 수정
    // AUTHOR :
    // PARAM :
    public function setSiteModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['id']);
        return $this->db->update('tb_site_setup', $args, array('id' => $id));
    }


    // DESC : 관리자 등록
    // AUTHOR :
    // PARAM :
    public function setAdminInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('tb_admin', $args);
        return $this->db->insert_id();

        //$this->db->insert('admin', $args);
        //return $this->db->insert_id();
        //echo $this->db->last_query(); //실행 쿼리 보기
    }

    // DESC : 관리자 수정
    // AUTHOR :
    // PARAM :
    public function setAdminModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['adm_idx']);
        return $this->db->update('tb_admin', $args, array('adm_idx' => $adm_idx));
    }

    function getAdmIdDupCheck($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        if ($adm_id) $where = "adm_id = '$adm_id'";
        $qry = "SELECT count(*) as cnt FROM tb_admin WHERE " . $where;
        $rst = $this->db->query($qry)->row_array();
        return $rst;
    }


    // DESC :
    // AUTHOR :
    // PARAM :
    function getAdmLoginChk($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        if (isset($adm_id)) $where = "adm_id = '$adm_id' ";

        $qry = "SELECT * FROM tb_admin WHERE " . $where;
        return $this->db-> query($qry)->row_array();
    }

    // desc : 관리자 정보 가져오기
    // auth  : JH
    // param :
    function getAdmInfo($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (isset($adm_idx)) $where = "adm_idx = '$adm_idx' and delyn='N' ";
        $qry = "SELECT * FROM tb_admin WHERE " . $where;
        return $this->db2-> query($qry)->row_array();
    }

    // desc : 관리자 리스트
    // auth  : JH [ ]
    // param :
    function getAdmList($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " delyn='N' ";

        $types = ['adm_type', 'adm_department', 'adm_position'];

        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " regdate BETWEEN '$s_date' AND '$e_date'";
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
        $args['q_idx'] = "adm_idx";
        $args['q_col'] = " * ";
        $args['q_table'] = " tb_admin ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }
}
