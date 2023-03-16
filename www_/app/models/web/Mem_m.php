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
class Mem_m extends FW_Model
{
    private $db2 = "";
    private $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('listclass','globals'));
        $this->GP =  $this->load->get_vars();
        $this->db2 = $this->load->database('select', TRUE);
    }

    public function userIdExistsChk($userid) {
        $userid = isset($userid) ? $this->db->escape_str($userid) : '';
        $qry = "SELECT COUNT(*) AS cnt FROM ky_member WHERE userid='$userid'";
        $row = $this->db->query($qry)->row_array();
        return $row['cnt'];
    }

    public function setMemberInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_member', $args);
        return $this->db->insert_id();
    }

    public function setMemberModify($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['id']);
        return $this->db->update('ky_member', $args, array('id' => $id));
    }

    public function getMemberSetInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "SELECT * FROM ky_member_setup ";
        return $this->db->query($qry)->row_array();
    }

    public function getMemberInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if (isset($id) && !empty($id)) {
            $id = isset($id) ? $this->db->escape_str($id) : '';
            $qry_arr[] = " id='$id' ";
        }

        if (isset($userid) && !empty($userid)) {
            $userid = isset($userid) ? $this->db->escape_str($userid) : '';
            $qry_arr[] = " userid='$userid' ";
        }

        if (isset($name) && !empty($name)) {
            $name = isset($name) ? $this->db->escape_str($name) : '';
            $qry_arr[] = " name='$name' ";
        }

        if (isset($htel1) && !empty($htel1)) {
            $htel1 = isset($htel1) ? $this->db->escape_str($htel1) : '';
            $qry_arr[] = " htel1='$htel1' ";
        }

        if (isset($htel2) && !empty($htel2)) {
            $htel2 = isset($htel2) ? $this->db->escape_str($htel2) : '';
            $qry_arr[] = " htel2='$htel2' ";
        }

        if (isset($htel3) && !empty($htel3)) {
            $htel3 = isset($htel3) ? $this->db->escape_str($htel3) : '';
            $qry_arr[] = " htel3='$htel3' ";
        }

        $addQry = implode(' AND ', $qry_arr);

        $qry = "SELECT * FROM ky_member WHERE $addQry ";
        //echo $qry;
        return $this->db->query($qry)->row_array();
    }

    // desc : 임시비번 발송
    // auth  : JH
    // param :
    function setMemberTmpPwd($args = array()){
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tmp_pwd = isset($tmp_pwd) ? $this->db->escape_str($tmp_pwd) : '';

        $qry = "
            update
                ky_member
            set
              npass = '$tmp_pwd'
            WHERE
              id='$id'
        ";
        return $this->db->query($qry);
    }













}