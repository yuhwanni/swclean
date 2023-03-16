<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Created by
 * User: yh
 * Date: 2021-08-11
 */

/**
 * Class Category_m_m
 *
 * @property CI_DB_query_builder $cdb
 */
class Cart_m extends FW_Model
{
    private $db2 = "";
    public function __construct()
    {
        parent::__construct();

        $this->load->library('listclass');
        $this->db2 = $this->load->database('select', TRUE);
    }

    // DESC : 장바구니 입력
    // AUTHOR :
    // PARAM :
    public function setCart($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        //$code = isset($code) ? $this->db->escape_str($code) : '';
        
        $this->db->insert('ky_shop_cart', $args);
        return $this->db->insert_id();
    }

    // DESC : 장바구니 삭제
    // AUTHOR :
    // PARAM :
    public function removeCart($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $seq = isset($seq) ? $this->db->escape_str($seq) : '';
        $prd_type = isset($prd_type) ? $this->db->escape_str($prd_type) : '';
        $prd_session = isset($prd_session) ? $this->db->escape_str($prd_session) : '';
        $mem_id = isset($mem_id) ? $this->db->escape_str($mem_id) : '';

        $addWhere = " seq = '$seq' ";

        //회원 장바구니일때
        if (!empty($mem_id) && !empty($mem_id)) {
            $addWhere .= " AND (mem_id  = '$mem_id' OR prd_session = '$prd_session') ";
        } else {
            $addWhere .= " AND prd_session = '$prd_session' ";
        }

        $qry = " DELETE FROM ky_shop_cart WHERE $addWhere ";
        return $this->db->query($qry);
    }

    // DESC : 장바구니 삭제(전체)
    // AUTHOR :
    // PARAM :
    public function removeAllCart($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $prd_type = isset($prd_type) ? $this->db->escape_str($prd_type) : '';
        $prd_session = isset($prd_session) ? $this->db->escape_str($prd_session) : '';
        $mem_id = isset($mem_id) ? $this->db->escape_str($mem_id) : '';

        $addWhere = " ";

        //회원 장바구니일때
        if (!empty($mem_id) && !empty($mem_id)) {
            $addWhere .= " (mem_id  = '$mem_id' OR prd_session = '$prd_session') ";
        } else {
            $addWhere .= " prd_session = '$prd_session' ";
        }

        $qry = " DELETE FROM ky_shop_cart WHERE $addWhere ";
        return $this->db->query($qry);
    }

    // DESC : 장바구니 업데이트
    // AUTHOR :
    // PARAM :
    public function updateCart($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $seq = isset($seq) ? $this->db->escape_str($seq) : '';
        $prd_cnt = isset($prd_cnt) ? $this->db->escape_str($prd_cnt) : '';
        $prd_session = isset($prd_session) ? $this->db->escape_str($prd_session) : '';
        $mem_id = isset($mem_id) ? $this->db->escape_str($mem_id) : '';

        $addWhere = " seq = '$seq' ";

        //회원 장바구니일때
        if (!empty($mem_id) && !empty($mem_id)) {
            $addWhere .= " AND (mem_id  = '$mem_id' OR prd_session = '$prd_session') ";
        } else {
            $addWhere .= " AND prd_session = '$prd_session' ";
        }

        $qry = " UPDATE ky_shop_cart SET prd_cnt = '$prd_cnt' WHERE $addWhere ";
        return $this->db->query($qry);
    }





}
