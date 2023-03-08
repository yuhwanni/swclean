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
class Auction_m extends FW_Model
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

    //즉시구매 입찰수 업데이트
    function setAuctionListNowSinUpdate($auction_seq) {

        $qry = "select count(*) as cnt from ky_auction_list where auction_seq='$auction_seq' and type=2";
        $row = $this->db->query($qry)->row_array();
        $cnt = $row['cnt'];

        $edate = date("Y-m-d H:i:s");
        $ehour = date("H");
        $emin = date("i");

        $qry = "
            update
                ky_brand
            set
              auction_now_sin = '$cnt',
              edate = '$edate',
              ehour = '$ehour',
              emin = '$emin',
              auction_sin = auction_sin + 1,
              auction_date = now()
            where   
              auction_seq='$auction_seq'
        ";
        return $this->db->query($qry);
    }

    //일반 입찰 입찰수 업데이트
    function setAuctionListSinUpdate($auction_seq) {

        $qry = "select count(*) as cnt from ky_auction_list where auction_seq='$auction_seq' and type=1";
        $row = $this->db->query($qry)->row_array();
        $cnt = $row['cnt'];

        $qry = "
            update
                ky_brand
            set
              auction_sin = '$cnt'
            where   
              auction_seq='$auction_seq'
        ";
        return $this->db->query($qry);
    }

    // DESC :
    // AUTHOR :
    // PARAM :
    function setAuctionListModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['id']);
        return $this->db->update('ky_auction_list', $args, array('id' => $id));
    }

    function setAuctionListInsert($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_auction_list', $args);
        return $this->db->insert_id();
    }

    //자신이 등록한 물품인지 확인
    function getMemberAuctionChk($args=[]) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "select count(*) as cnt from ky_brand where auction_seq='$auction_seq' and userid='$userid'";
        $rst = $this->db->query($qry)->row_array();
        return $rst['cnt'];
    }

    function getAuctionBidMaxInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select * from ky_auction_list where auction_seq='$auction_seq' and result='1' order by price desc limit 1
        ";
        return $this->db->query($qry)->row_array();
    }

    function getAuctionNoUserCnt($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $no_user = isset($no_user) ? $this->escape_string($no_user) : '';

        $qry = "
            select count(*) as cnt from ky_auction_no_user where no_user='$no_user'
        ";
        $rst = $this->db->query($qry)->row_array();
        return $rst['cnt'];
    }

    function setAuctionHitUp($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = isset($auction_seq) ? $this->escape_string($auction_seq) : '';

        $qry = "update ky_brand set hit = hit + 1 where auction_seq = '$auction_seq'";
        return $this->db-> query($qry);
    }

    function getAuctionInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = isset($auction_seq) ? $this->escape_string($auction_seq) : '';

        $qry_arr = array();
        $qry_arr[] = "1=1";

        if(isset($auction_seq) && !empty($auction_seq)){
            $qry_arr[] = " S.auction_seq='$auction_seq' ";
        }

        if(isset($brandcode) && !empty($brandcode)){
            $qry_arr[] = " S.brandcode='$brandcode' ";
        }

        $addQry = implode(' AND ', $qry_arr);

        $qry = "
            SELECT 
            S.*
            , (SELECT category_name FROM ky_category WHERE LEFT(CODE, 3) = LEFT(S.category, 3) LIMIT 1) AS depth1  
            , C.category_name AS depth2
            FROM 
              ky_brand S INNER JOIN ky_category C ON(S.category = C.code)
            WHERE 
              $addQry
        ";
        return $this->db-> query($qry)->row_array();
    }

    function getAuctionListCnt($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $addqry = "";
        if(isset($edate) && strtotime($edate) > time()) {
            $addqry = " and type != 9 ";
        }

        $qry = "SELECT count(*) as cnt FROM ky_auction_list WHERE auction_seq='$auction_seq' $addqry";
        $rst = $this->db-> query($qry)->row_array();
        return $rst['cnt'];
    }

    //경매기록
    function getAuctionSellList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "SELECT * FROM ky_auction_list WHERE brandcode='$brandcode' order by price desc";
        $rst = $this->db-> query($qry)->result_array();
        return $rst;
    }

    function getAuctionList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $tail[] = "timeview=" . $timeview;
        $tail[] = "list_type=" . $list_type;
        $tail[] = "view_type=" . $view_type;

        if(isset($cate) && !empty($cate)){
            list($i, $par_code) = $this->par_code($cate);
            $qry_arr[] = " A.brandcode LIKE '$par_code%' ";
            $tail[] = "cate=" . $cate;
        }

        if($list_type == "1") { //전체경매
            //$qry_arr[] = " A.status != '4' and (unix_timestamp(A.edate) > ".time()." and unix_timestamp(A.sdate) < ".time().") and A.auction_sin = 0 ";
            $qry_arr[] = " A.status != '4' and (unix_timestamp(A.edate) > ".time()." and unix_timestamp(A.sdate) < ".time().")  ";
        }

        if($list_type == "yes_list") {
            //$qry_arr[] = " A.status != '4' and (unix_timestamp(A.edate) > ".time().") and A.auction_now_sin = 0 ";
            $qry_arr[] = " A.status != '4' and (unix_timestamp(A.edate) > ".time().")  ";
        }

        if($list_type == "auction_list") {
            $qry_arr[] = " (B.type='2' or B.type = '4') and (unix_timestamp(A.edate) < " . time() . ") and auction_sin != 0 ";
        }

        if($list_type == "99") { //지난경매
            $qry_arr[] = " unix_timestamp(A.edate) < " . time();
        }

        $orderby_str = "";
        if(isset($orderby) && !empty($orderby)) {
            $orderby = $this->escape_string($orderby);

            switch ($orderby) {
                case "1": $orderby_str = "unix_timestamp(A.edate) asc "; break;
                case "2": $orderby_str = "A.wdate desc "; break;
                case "3": $orderby_str = "A.auction_sin desc "; break;
                case "4": $orderby_str = "A.sprice desc "; break;
                case "5": $orderby_str = "A.sprice asc "; break;
                case "6": $orderby_str = "A.hit desc "; break;
                case "7": $orderby_str = "A.hit asc "; break;
                default:  $orderby_str = "unix_timestamp(A.edate) desc "; break;
            }

            $tail[] = "orderby=" . $orderby;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);

            if($sc_type == "all") {
                $qry_arr[] = " (A.brandname LIKE ('%$sc_val%') or A.content LIKE ('%$sc_val%'))";
            }else {
                $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            }
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
        $args['q_idx'] = "A.auction_seq";
        $args['q_col'] = " 
                            A.*
                            , (SELECT category_name FROM ky_category WHERE LEFT(CODE, 3) = LEFT(A.category, 3) LIMIT 1) AS depth1  
                            , C.category_name AS depth2
                            , (SELECT COUNT(*) AS CNT FROM ky_auction_list WHERE type != 9 AND (auction_seq=A.auction_seq OR brandcode = A.brandcode)) AS auc_cnt
                        ";
        $args['q_table'] = " ky_brand A INNER JOIN ky_category C ON(A.category = C.code) ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby_str;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //상품코드 파싱
    function par_code($code){
        if(strlen($code) == (3*CATE_NUM)) return array(CATE_NUM, $code);
        for($i = 1 ; $i <= CATE_NUM ; $i ++){
            if(substr($code, ($i * 3) , 3) == '000'){
                $par_code = substr($code, 0, (3 * $i));
                break;
            }
        }
        return array($i, $par_code);
    }

    function getBidSecondPrice($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = $this->escape_string($auction_seq);

        $qry  = "
            select 
              A.*, B.edate, B.auction_now_sin_id 
            from 
              ky_auction_list A, ky_brand B 
            where
              (A.brandcode=B.brandcode OR A.auction_seq=B.brandcode) 
              AND B.auction_seq='$auction_seq' 
            order by price desc, id asc 
            limit 1,1
        ";
        $rst = $this->db->query($qry)->row_array();
        return ["id"=>$rst['id'], "price"=>$rst['price']];
    }

    function getAuctionBidList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = $this->escape_string($auction_seq);

        $qry = "
            select * from ky_brand A, ky_auction_list B where (A.brandcode=B.brandcode OR A.auction_seq=B.brandcode) 
            AND B.auction_seq='$auction_seq' order by id asc
        ";
        return $this->db->query($qry)->result_array();
    }

    function getAuctionBidChk($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = $this->escape_string($auction_seq);

        $qry = "
            select count(*) as cnt from ky_brand A, ky_auction_list B where (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)  
            AND A.auction_seq='$auction_seq' and A.userid='$userid'
        ";
        return $this->db->query($qry)->row_array();
    }

    function setAuctionWishInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = $this->escape_string($auction_seq);
        $userid = $this->escape_string($userid);

        $qry = "select count(*) as cnt from ky_auction_wish where (brandcode='$auction_seq' or auction_seq='$auction_seq') and userid='$userid'";
        $rst = $this->db->query($qry)->row_array();
        return $rst['cnt'];
    }

    function setAuctionWishInsert($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_auction_wish', $args);
        return $this->db->insert_id();
    }

    function setAuctionWishDel($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $id = $this->escape_string($id);

        $qry = "delete from ky_auction_wish where id='$id'";
        return $this->db->query($qry);
    }

    function getMemberAuctionWishList($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " A.userid = '$userid' ";
        //$qry_arr[] = " 1=1 ";

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " wdate BETWEEN '$s_date' AND '$e_date'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
        }

        $addQry = implode(' AND ', $qry_arr);
        $addTail = implode('&', $tail);

        $excelHanArr = array();
        $excelHanArr_kr = array();

        $args['search_match'] = array('');
        $args['show_row'] = isset($show_row) ? $show_row : 30;
        $args['show_page'] = isset($show_page) ? $show_page : 10;
        $args['sc_type'] = isset($sc_type) ? $sc_type : "";
        $args['sc_val'] = isset($sc_val) ? $sc_val : "";
        $args['excel'] = $excelHanArr;
        $args['excel_kr'] = $excelHanArr_kr;
        $args['q_idx'] = "A.id";
        $args['q_col'] = " * ";
        $args['q_table'] = " ky_auction_wish A INNER JOIN ky_brand B ON (A.auction_seq=B.auction_seq or A.brandcode=B.brandcode) ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "A.id DESC";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this->listclass->listInfo($args);
    }

    function getAuctionData($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select * from ky_auction_list where grp='$grp' AND brandcode='$brandcode' order by price desc limit 1
        ";
        return $this->db->query($qry)->row_array();
    }

    function getAuctionNowPrice($auction_seq, $data, $price = '') {

        $qry  = "select a.*, b.auction_now_sin,b.edate,b.order_price_unit,b.sprice ";
        $qry .= "from ky_auction_list a, ky_brand b where ";
        $qry .= "a.auction_seq = '$auction_seq' and (a.brandcode=b.brandcode or a.auction_seq=b.auction_seq)  and a.result != '97' ";
        $qry .= "group by a.price order by a.price desc, a.id asc ";
        $rst_data = $this->db->query($qry)->result_array();

        $i = 0;
        $_array_id = [];

        //배열로 만든다.
        $sprice = 0;
        $order_price_unit = 0;
        foreach ($rst_data as $k => $v) {
            $row_price = $v['price'];
			$row_auction_seq = $v['auction_seq'];
            $row_brandcode = $v['brandcode'];
            $row_userid = $v['userid'];
            $row_order_price_unit = $v['order_price_unit'];
            $row_sprice = $v['sprice'];

            $qry = "select count(*) as cnt from ky_auction_list where auction_seq='$row_auction_seq' AND price='$row_price'";
            $crow = $this->db->query($qry)->row_array();

            // 같은 금액의 입찰자가 둘이상일때.
            if($crow['cnt'] > 1){
                if($i == 0){
                    $qry = "select * from ky_auction_list where auction_seq='$row_auction_seq' AND price='$row_price' order by id desc";
                    $crow1 = $this->db->query($qry)->row_array();

                    $_array_id[$i] = $crow1['userid'];
                    $_array_pr[$i] = $crow1['price'];
                } else {
                    $chkid = $_array_id[($i-1)];

                    if($brandcode == "0020010000000008707"){
                        $qry = "select * from ky_auction_list where auction_seq='$row_auction_seq' AND price='$row_price' AND userid!='$chkid'";
                        $crow1 = $this->db->query($qry)->row_array();

                        $_array_id[$i] = $crow1['userid'];
                        $_array_pr[$i] = $crow1['price'];
                    } else {
                        if(trim($chkid)){
                            $qry = "select * from ky_auction_list where auction_seq='$row_auction_seq' AND price='$row_price' AND userid!='$chkid'";
                            $crow1 = $this->db->query($qry)->row_array();

                            $_array_id[$i] = $crow1['userid'];
                            $_array_pr[$i] = $crow1['price'];
                        }
                    }
                }
            } else {
                $_array_id[$i] = $row_userid;
                $_array_pr[$i] = $row_price;
            }

            $order_price_unit = $row_order_price_unit;
            $sprice = $row_sprice;
            $i++;
        }

        $chkdate = 20180723;
        $end_date = str_replace("-", "", substr($data['edate'], 0, 10));

        // 경매종료가 기준날짜 이후면 적용
        $new_id = [];
        $new_pr = [];
        if($end_date > $chkdate){
            $j = 0;
            while(@list($k, $v) = @each($_array_id)){
                if(!trim($v)) continue;
                $new_id[$j] = $v;
                $new_pr[$j] = $_array_pr[$k];
                $j++;
            }
            $_array_id = $new_id;
            $_array_pr = $new_pr;
        }

        //한건이면
        if(count($_array_id) == 1) $price = $sprice;
        else{
            //한건 이상일 경우에
            $i = 0;
            foreach($_array_id as $k => $v) {
                //다음에 아이디가 없으면
                if(isset($_array_id[($k+1)]) && $_array_id[($k+1)] != $v){
                    if($_array_pr[($k+1)]){
                        //아래의 금액과 동일금액이면 그냥 그금액대로한다
                        if($_array_pr[($k+1)] == $_array_pr[$k]){
                            $price = $_array_pr[($k+1)];
                            //동일금액이 아니면 이전 금액에 + 입찰단위금액
                        }else $price = $_array_pr[($k+1)]+$order_price_unit;
                    }
                    //자기혼자 여러번 입찰일경우
                    else{
                        $price = $sprice;
                    }
                    //echo "xx";
                    break;
                }
                $i++;
            }

            if(!$price || $price < $sprice) $price = $sprice;
        }

        return $price;

    }

    //DESC : 메인 노출 - 경매
    function mainAuctionProduct($args) {

        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $addQry = "";
        if($types == "recommend") {
            $addQry .= " AND A.product_loc = '1' ";

            $sql = "
                SELECT 
                    A.* , 
                    (SELECT category_name FROM ky_category WHERE LEFT(CODE, 3) = LEFT(A.category, 3) LIMIT 1) AS depth1 , 
                    C.category_name AS depth2 
                FROM 
                  ky_brand A INNER JOIN ky_category C ON(A.category = C.code)
                WHERE 
                  A.status != '4' and (unix_timestamp(A.edate) > ".time()." and unix_timestamp(A.sdate) < ".time().") and A.auction_sin = 0
                  ".$addQry." 
                ORDER BY unix_timestamp(A.edate) ASC
                LIMIT 10  
            ";

        } else if($types == "popularity") {
            $sql = "
                SELECT 
                    A.* , 
                    (SELECT category_name FROM ky_category WHERE LEFT(CODE, 3) = LEFT(A.category, 3) LIMIT 1) AS depth1 , 
                    C.category_name AS depth2 
                FROM 
                  ky_brand A INNER JOIN ky_category C ON(A.category = C.code)
                WHERE 
                  A.status != '4' and (unix_timestamp(A.edate) > ".time()." and unix_timestamp(A.sdate) < ".time().") and A.auction_sin = 0                   
                ORDER BY A.hit DESC
                LIMIT 10  
            ";
        }

        $list = $this->db->query($sql)->result_array();
        return $list;
    }

    function getCategoryDepth($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $code = isset($code) ? $this->escape_string($code) : "";
        $cate = isset($cate) ? $this->escape_string($cate) : "";

        if($cate == "1") {
            $qry = "
                  select 
                    code,category_name, image, category_location  
                  from 
                    ky_category 
                  where 
                    substring(code,4,3) = '000' 
                  group by left(code, 3) 
                  order by category_location ASC, left(code, 3) ASC
            ";
        }

        if($cate == "2") {
            $code_1 = substr($code, 0,3);

            $qry = "
                select 
                  code,category_name, image, category_location  
                from 
                  ky_category 
                where 
                  substring(code,7,3) = '000' 
                  AND substring(code,1,3) = '$code_1'
                  AND substring(code,4,3) != '000'
                order by category_location asc
            ";
        }

        if($cate == "3") {
            $code_2 = substr($code, 0,6);

            $qry = "
                select 
                  code,category_name, image, category_location  
                from 
                  ky_category 
                where 
                  substring(code,10,3) = '000' 
                  AND substring(code,1,6) = '$code_2'
                  AND substring(code,7,3) != '000'
                order by category_location asc
            ";
        }
        return $this->db->query($qry)->result_array();
    }

    function getAuctionBrandInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $auction_seq = isset($auction_seq) ? $this->escape_string($auction_seq) : '';

        $qry = "
            SELECT 
            S.*
            , (SELECT category_name FROM ky_category WHERE LEFT(CODE, 3) = LEFT(S.category, 3) LIMIT 1) AS depth1  
            , C.category_name AS depth2
            FROM 
              ky_brand S INNER JOIN ky_category C ON(S.category = C.code)
            WHERE S.auction_seq = '$auction_seq'
        ";
        return $this->db-> query($qry)->row_array();
    }

    function getMaxBrandCode($args=[]) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select brandcode from ky_brand where left(category, 12) = '$category' order by brandcode desc limit 1
        ";
        return $this->db->query($qry)->row_array();
    }

    // DESC : 경매 수정
    function setAuctionModify($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $auction_seq = isset($auction_seq) ? $this->db->escape_str($auction_seq) : '';

        unset($args['auction_seq']);
        return $this->db->update('ky_brand', $args, array('auction_seq' => $auction_seq));
    }

    // DESC : 경매 등록
    function setAuctionInsert($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $args['wdate'] = date("Y-m-d H:i:s");
        $this->db->insert('ky_brand', $args);
        return $this->db->insert_id();
    }

    // DESC : 이미지 개별삭제 업데이트
    function getAuctionImgDel($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $auction_seq = isset($id) ? $this->db->escape_str($auction_seq) : '';
        $photo = isset($photo) ? $this->db->escape_str($photo) : '';
        $photo_type = isset($photo_type) ? $this->db->escape_str($photo_type) : '';

        if($photo_type == "photo") {
            $qry = " UPDATE ky_brand SET photo = '$photo' WHERE shop_seq = '$auction_seq' ";
        } else if($photo_type == "etc") {
            $qry = " UPDATE ky_brand SET etc_image = '$photo' WHERE shop_seq = '$auction_seq' ";
        }

        return $this->db->query($qry);
    }

    function getAuctionListInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $id = isset($id) ? $this->escape_string($id) : '';

        $qry = "
          SELECT 
            A.*, B.*, 
            A.userid as auction_userid, 
            A.price as end_price
          FROM 
            ky_auction_list as A INNER JOIN ky_brand B ON (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) 
        WHERE 
          A.id='$id' 
        ";
        return $this->db-> query($qry)->row_array();
    }

    // DESC : 상품 공통정보 가져오기
    function getProductCommon($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $pr_type = isset($pr_type) ? $this->db->escape_str($pr_type) : '';
        $qry = " SELECT * FROM ky_product_common WHERE pr_type = '$pr_type' ";
        $rst = $this->db->query($qry)->result_array();
        return $rst;
    }

    function getBrandInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "select * from ky_brand where auction_seq='$auction_seq'";
        return $this->db->query($qry)->row_array();
    }

    function getAuctionMaxPrice($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "select max(price) as max_price from ky_auction_list where auction_seq='$auction_seq'";
        return $this->db->query($qry)->row_array();
    }
}