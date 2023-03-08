<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
class Gita_m extends FW_Model
{
    private $db2 = "";
    private $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('listclass', 'globals'));
        $this->GP = $this->load->get_vars();
        $this->db2 = $this->load->database('select', TRUE);
    }

    public function getPopupShow($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select * from tb_popup_setup where pop_use='Y' AND ('".date('Y-m-d H:i:s')."' BETWEEN pop_start_date AND pop_end_date) ORDER BY pop_idx asc 
        ";
        return $this->db2-> query($qry)->result_array();
    }

    public function setPopupModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['pop_idx']);
        return $this->db->update('tb_popup_setup', $args, array('pop_idx' => $pop_idx));
    }

    public function setPopupInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('tb_popup_setup', $args);
        return $this->db->insert_id();
    }

    function setPopupDel($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "delete from tb_popup_setup where pop_idx = '$pop_idx'";
        return $this->db2-> query($qry);
    }

    function getPopupInfo($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (isset($pop_idx)) $where = "pop_idx = '$pop_idx' ";
        $qry = "SELECT * FROM tb_popup_setup WHERE " . $where;
        return $this->db2-> query($qry)->row_array();
    }

    public function getPopupList($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " 1=1  ";

        $types = [];

        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }

        /*if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " pop_reg_date BETWEEN '$s_date 00:00:00' AND '$e_date 23:59:59'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
        }*/

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "&sc_type=" . $sc_type;
            $tail[] = "&sc_val=" . $sc_val;
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
        $args['q_idx'] = "pop_idx";
        $args['q_col'] = " 
            *
         ";
        $args['q_table'] = " tb_popup_setup ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "pop_reg_date desc";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this->listclass->listInfo($args);
    }
}