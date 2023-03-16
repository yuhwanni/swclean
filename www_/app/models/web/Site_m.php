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
class Site_m extends FW_Model
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

    public function getSiteSetInfo($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "SELECT * FROM tb_site_setup ";
        return $this->db->query($qry)->row_array();
    }
}