<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Created by
 * User: yuhwanni
 * Date: 2021-08-31
 */

/**
 * Class Auth_m
 *
 * @property CI_DB_query_builder $cdb
 */
class Shop_m extends FW_Model
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

    public function setShopWishDel($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $id = $this->escape_string($id);

        $qry = "delete from ky_shop_wish where id='$id'";
        return $this->db->query($qry);
    }

    public function getMemberShopWishList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        //$qry_arr[] = " userid = '$userid' ";

        $qry_arr[] = " 1=1 ";

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " wdate BETWEEN '$s_date' AND '$e_date'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
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
        $args['q_idx'] = "A.id";
        $args['q_col'] = " 
                            A.*, B.*,
                            (SELECT category_name FROM ky_shop_category WHERE LEFT(CODE, 3) = LEFT(B.category, 3) LIMIT 1) AS depth1 , 
                            C.category_name AS depth2 
        ";
        $args['q_table'] = " 
                                ky_shop_wish A INNER JOIN ky_shop_brand B ON A.brandcode=B.brandcode
                                INNER JOIN ky_shop_category C ON B.category = C.code                                 
                            ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "A.id DESC";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    public function getProductList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " 1=1 ";

        /*$types = ['result', 'level'];

        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }*/

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " wdate BETWEEN '$s_date' AND '$e_date'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);

            if($sc_type == "all") {
                $qry_arr[] = " (brandname LIKE ('%$sc_val%') OR content LIKE ('%$sc_val%') )";
            } else {
                $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            }

            $tail[] = "&sc_type=" . $sc_type;
            $tail[] = "&sc_val=" . $sc_val;
        }

        //1차 카테고리
        if (!empty($category_1)) {
            $category_val = substr($category_1, 0,3);
            $qry_arr[] = " SUBSTRING(S.category , 1 , 3) = '".$category_val."' ";
            $tail[] = "cate=" . $category_1;
        }

        //2차 카테고리
        if (!empty($category_1) && !empty($category_2)) {
            $category_val2 = substr($category_2, 3,3);
            $qry_arr[] = " SUBSTRING(S.category , 4 , 3) = '".$category_val2."' ";
            $tail[] = "cate=" . $category_2;
        }

        //정렬
        $orderby_str = "";
        if (!empty($orderby)) {
            if($orderby == "1") {
                $orderby_str = "S.hit DESC";
            } else if($orderby == "2") {
                $orderby_str = "S.sellprice DESC";
            } else if($orderby == "3") {
                $orderby_str = "S.sellprice ASC";
            } else if($orderby == "4") {
                $orderby_str = "S.hit DESC";
            } else if($orderby == "5") {
                $orderby_str = "S.hit ASC";
            } else {
                $orderby_str = "S.shop_seq DESC";
            }
            $tail[] = "orderby=" . $orderby;
        }

        $tail[] = "page_row=" . $show_row;

        //상태
        $qry_arr[] = " status = '1' ";

        $addQry = implode(' AND ', $qry_arr);
        $addTail = implode('&', $tail);

        $excelHanArr = array(
            '상품코드' => 'brandcode',
            '상품명' => 'brandname',
            '제조원' => 'company',
            '원산지' => 'native',
            '단위' => 'unit',
            '소비자가' => 'price',
            '진열위치' => 'product_loc',
            '판매가격' => 'sellprice',
            '판매가격옵션' => 'sellprice_option',
            '적립금' => 'milage',
            '옵션' => 'options',
            '특성' => 'special',
            '상태' => 'status',
            '간단설명' => 'ment',
            '기타설명' => 'etc_field',
            '상품순위' => 'location',
            '상품이미지' => 'photo',
            '기타이미지수' => 'etc_image_num',
            '기타이미지' => 'etc_image',
            '상세설명' => 'content',
        );
        $excelHanArr_kr = array(
            //'sil' => $this->GP['SIL_AUTH'],
        );

        $args['search_match'] = array('');
        $args['show_row'] = isset($show_row) ? $show_row : 30;
        $args['show_page'] = isset($show_page) ? $show_page : 10;
        $args['sc_type'] = isset($sc_type) ? $sc_type : "";
        $args['sc_val'] = isset($sc_val) ? $sc_val : "";
        $args['excel'] = $excelHanArr;
        $args['excel_kr'] = $excelHanArr_kr;
        $args['q_idx'] = "S.shop_seq";
        $args['q_col'] = " 
                S.*,
                (SELECT category_name FROM ky_shop_category WHERE LEFT(CODE, 3) = LEFT(S.category, 3) LIMIT 1) AS depth1 , 
                C.category_name AS depth2
         ";
        $args['q_table'] = " ky_shop_brand S INNER JOIN ky_shop_category C ON(S.category = C.code) ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby_str;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    public function getCategoryInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $code = $this->escape_string($code);

        if (isset($code)) $where = "code = '$code' ";
        $qry = "SELECT * FROM ky_shop_category WHERE " . $where;
        return $this->db-> query($qry)->row_array();
    }

    //장바구니
    public function getCartList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $mem_id = $this->escape_string($mem_id);
        $prd_session = $this->escape_string($prd_session);

        $tail = $qry_arr = array();

        $qry_arr[] = " 1=1 ";

        //회원 장바구니일때
        if (!empty($mem_id)) {
            $qry_arr[] = " C.mem_id  = '$mem_id' OR C.prd_session = '$prd_session' ";
        } else {
            $qry_arr[] = " C.prd_session = '$prd_session' ";
        }

        //상태
        $qry_arr[] = " prd_type = 'S' ";
        $addQry = implode(' AND ', $qry_arr);

        $qry = "
            SELECT
                C.*, C.seq, S.shop_seq, S.brandname, S.category, S.sellprice, S.photo, S.status, S.new_chk
            FROM
              ky_shop_cart C LEFT OUTER JOIN ky_shop_brand S ON(S.shop_seq = C.shop_seq)
            WHERE $addQry
            ORDER BY C.wdate DESC
        ";

        return $this->db->query($qry)->result_array();
    }

    public function getProductInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $shop_seq = isset($shop_seq) ? $this->db->escape_str($shop_seq) : '';
        $qry = "
            SELECT 
                  S.*
                , (SELECT category_name FROM ky_shop_category WHERE LEFT(CODE, 3) = LEFT(S.category, 3) LIMIT 1) AS depth1  
                , C.category_name AS depth2
            FROM ky_shop_brand S INNER JOIN ky_shop_category C ON(S.category = C.code)
            WHERE S.shop_seq = '$shop_seq'
        ";
        return $this->db->query($qry)->row_array();
    }

    //DESC : 메인 노출 - 쇼핑몰
    function mainShopProduct($args) {

        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $sql = "
            SELECT 
              S.*, 
              (SELECT category_name FROM ky_shop_category WHERE LEFT(CODE, 3) = LEFT(S.category, 3) LIMIT 1) AS depth1 ,
              C.category_name AS depth2 FROM ky_shop_brand S 
            INNER JOIN ky_shop_category C ON(S.category = C.code) 
            WHERE status = '1' AND product_loc = '1'
            ORDER BY S.hit DESC
            LIMIT 10
        ";

        $list = $this->db->query($sql)->result_array();
        return $list;
    }

    // DESC : 상품 공통정보 가져오기
    public function getProductCommon($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $pr_type = isset($pr_type) ? $this->db->escape_str($pr_type) : '';
        $qry = " SELECT * FROM ky_product_common WHERE pr_type = '$pr_type' ";
        $rst = $this->db->query($qry)->result_array();
        return $rst;
    }


    //주문 원문 저장 (메인)
    public function setShopOrder($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_shop_order', $args);
        return $this->db->insert_id();
    }

    //주문 리스트 등록(서브)
    public function setShopOrderBrand($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_shop_order_brand', $args);
        return $this->db->insert_id();
    }

    //주문 원문 정보 (ONE ROW)
    public function getOrderInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $ordernum = $this->escape_string($ordernum);
        $where = "ordernum = '$ordernum' ";

        $userid = isset($userid) ? $userid : "";
        $userid = $this->escape_string($userid);
        if($userid) {
            $where .= " AND userid = '$userid'";
        }

        $qry = "SELECT * FROM ky_shop_order WHERE " . $where;
        return $this->db-> query($qry)->row_array();
    }

    //주문 리스트 정보 (List)
    public function getOrderSubList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $ordernum = $this->escape_string($ordernum);

        if (isset($ordernum)) $where = " A2.ordernum = '$ordernum' ";
        $qry = "
            SELECT A.*, A2.* FROM ky_shop_order_brand A2 INNER JOIN ky_shop_brand A ON(A2.brandcode = A.shop_seq)  
            WHERE 
        " . $where;
        return $this->db-> query($qry)->result_array();
    }

}