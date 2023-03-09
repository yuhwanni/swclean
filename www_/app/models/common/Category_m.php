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
class Category_m extends FW_Model
{
    private $db2 = "";
    public function __construct()
    {
        parent::__construct();

        $this->load->library('listclass');
        $this->db2 = $this->load->database('select', TRUE);
    }

    // DESC : 쇼핑몰 카테고리 1차 조회
    // AUTHOR :
    // PARAM :
    public function shop_category_depth1($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            SELECT 
              C.id,
              C.category_name,
              C.category_options,
              C.category_location,
              C.code,
              C.image,
              (
                SELECT 
                  group_concat(CONCAT(CODE, '|', category_name, '|', (SELECT COUNT(*) AS CNT FROM ky_shop_brand B WHERE B.category = CODE AND status = '1') ) ORDER BY category_location ASC SEPARATOR '^')  
                FROM ky_shop_category 
                WHERE 
                  LEFT(CODE, 3) = LEFT(C.code, 3) AND RIGHT(CODE, 6) = RIGHT(C.code,6) AND CODE != C.code
                ORDER BY category_location ASC
              ) AS sub_category                              
            FROM ky_shop_category C
            WHERE RIGHT(C.code,9) = '000000000' 
            ORDER BY C.category_location ASC
        ";

        $list = $this->db->query($qry)->result_array();
        $type = isset($type) ? $this->db->escape_str($type) : '';
        $rst = array();
        if($type == "menu") {
            foreach ($list as $k => $v) {
                $rst[$v['code']] = $v['category_name'];
            }
        } else {
            $rst = $list;
        }

        return $rst;
    }

    // DESC : 경매 카테고리 1차 조회
    // AUTHOR :
    // PARAM :
    public function category_depth1($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            SELECT 
              C.id,
              C.category_name,
              C.category_options,
              C.category_location,
              C.code,
              C.image,
              (
                SELECT
                  group_concat(CONCAT(CODE, '|', category_name, '|', (SELECT COUNT(*) AS CNT FROM ky_brand B WHERE B.category = CODE AND B.status != '4' and (unix_timestamp(B.edate) > ".time().") ) ) ORDER BY category_location ASC SEPARATOR '^')
                FROM ky_category 
                WHERE 
                  LEFT(CODE, 3) = LEFT(C.code, 3) AND RIGHT(CODE, 6) = RIGHT(C.code,6) AND CODE != C.code
                ORDER BY category_location ASC
              ) AS sub_category                             
            FROM ky_category C
            WHERE RIGHT(C.code,9) = '000000000' 
            ORDER BY C.category_location ASC
        ";

        $list = $this->db->query($qry)->result_array();
        $type = isset($type) ? $this->db->escape_str($type) : '';
        $rst = array();
        if($type == "menu") {
            foreach ($list as $k => $v) {
                $rst[$v['code']] = $v['category_name'];
            }
        } else {
            $rst = $list;
        }

        return $rst;
    }


    // DESC : 쇼핑몰 카테고리 1차 조회
    // AUTHOR :
    // PARAM :
    public function sel_shop_category($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            SELECT 
              C.id,
              C.category_name,
              C.category_options,
              C.category_location,
              C.code,
              C.image                                           
            FROM ky_shop_category C
            WHERE RIGHT(C.code,9) = '000000000' 
            ORDER BY C.category_location ASC
        ";

        $list = $this->db->query($qry)->result_array();
        $type = isset($type) ? $this->db->escape_str($type) : '';
        $rst = array();
        foreach ($list as $k => $v) {
            $rst[$v['code']] = $v['category_name'];
        }
        return $rst;
    }

    // DESC : 쇼핑몰 카테고리 2차 조회
    // AUTHOR :
    // PARAM :
    public function sel_shop_category2($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $code = isset($code) ? $this->db->escape_str($code) : '';

        //1차
        $code_1 = substr($code, 0,3);
        //2차
        $code_2 = substr($code, 3, 3);
        //3차
        $code_3 = substr($code, 6,3);

        //SUBSTRING('111222333444', 1,3),
        //SUBSTRING('111222333444', 4,3),
        //SUBSTRING('111222333444', 7,3)

        $qry = "
            SELECT 
              C.id,
              C.category_name,
              C.category_options,
              C.category_location,
              C.code,
              C.image 
            FROM 
              ky_shop_category C  
            WHERE 
              substring(C.code,1,3) = $code_1 AND substring(C.code,4,3) != '000'
              ORDER BY C.category_location ASC
        ";

        $list = $this->db->query($qry)->result_array();
        $rst = array();
        foreach ($list as $k => $v) {
            $rst[$v['code']] = $v['category_name'];
        }
        return $rst;
    }





}
