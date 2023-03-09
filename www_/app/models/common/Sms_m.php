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
class Sms_m extends FW_Model
{
    private $db2 = "";
    public function __construct()
    {
        parent::__construct();

        $this->load->library('listclass');
        $this->db2 = $this->load->database('select', TRUE);
    }

    // DESC : SMS등록
    // AUTHOR :
    // PARAM :
    public function setInsertSms($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        //$code = isset($code) ? $this->db->escape_str($code) : '';
        
        $this->db->insert('ky_sms', $args);
        return $this->db->insert_id();
    }



}
