<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Created by
 * User:
 * Date: 2021-08-31
 */

/**
 * Class Mypage_m
 *
 * @property CI_DB_query_builder $cdb
 */
class Mypage_m extends FW_Model
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

    //입찰제한자 삭제
    function setAuctionNoUserDel($args = []){
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $id = $this->escape_string($id);

        $qry = "delete from ky_auction_no_user where id='$id'";
        return $this->db->query($qry);
    }

    //입찰제한자 등록
    function setAuctionNoUserInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_auction_no_user', $args);
        return $this->db->insert_id();
    }

    //입찰제한자정보
    function getAuctionNoUserInfo($args=[]){
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select * from ky_auction_no_user where no_user='$no_user' and userid='$userid'
        ";
        return $this->db->query($qry)->row_array();
    }

    //입찰제한자 리스트
    function getAuctionNoUserList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "1=1";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " userid='$userid' ";
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
        $args['q_idx'] = "id";
        $args['q_col'] = " 
                            *
                        ";
        $args['q_table'] = " ky_auction_no_user ";
        $args['q_where'] = $addQry;
        $args['q_order'] = 'id desc';
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //회원리스트
    function getMemberList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " 1=1 ";

        $types = ['result', 'level'];

        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }

        if (!empty($s_date) && !empty($e_date)) {
            $qry_arr[] = " wdate BETWEEN '$s_date' AND '$e_date'";
            $tail[] = "s_date=" . $s_date;
            $tail[] = "e_date=" . $e_date;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
        }

        $addQry = implode(' AND ', $qry_arr);
        $addTail = implode('&', $tail);

        $excelHanArr = array(
            '이름' => 'name',
            '실명인증' => 'sil',
            '아이디' => 'userid',
            '비밀번호' => 'pass',
            '휴대폰1' => 'htel1',
            '휴대폰2' => 'htel2',
            '휴대폰3' => 'htel3',
            '주소' => 'addr',
            '상세주소' => 'addr1',
            '가입일' => 'wdate',
        );
        $excelHanArr_kr = array(
            'sil' => $this->GP['SIL_AUTH'],
        );

        $args['search_match'] = array('');
        $args['show_row'] = isset($show_row) ? $show_row : 10;
        $args['show_page'] = isset($show_page) ? $show_page : 5;
        $args['sc_type'] = isset($sc_type) ? $sc_type : "";
        $args['sc_val'] = isset($sc_val) ? $sc_val : "";
        $args['excel'] = $excelHanArr;
        $args['excel_kr'] = $excelHanArr_kr;
        $args['q_idx'] = "id";
        $args['q_col'] = " * ";
        $args['q_table'] = " ky_member ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "wdate desc";
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //판매대금수령계좌등록
    function setOutPriceInsert($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $this->db->insert('ky_out_price', $args);
        return $this->db->insert_id();
    }

    //구매관련정보 / BUY
    function getMyBuyAuctionDataDetail($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $now_day = date('Y-m-d');

        $addQry = "";
        $groupby = "B.brandcode";

        if($type == "1") {  //구매 및 낙찰물품
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= "AND (B.result >= 1 AND B.result <= 7) " .PHP_EOL;
        }

        if($type == "2") { //입금요청
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND B.result = 1 " .PHP_EOL;
        }

        if($type == "3") { //입금확인중
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) ".PHP_EOL;
            $addQry .= " AND (B.result = 2 OR B.result = 3)  " .PHP_EOL;
        }

        if($type == "4") { //배송요청
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND B.result = 4  " .PHP_EOL;
        }

        if($type == "5") { //구매결정
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) ".PHP_EOL;
            $addQry .= " AND B.result = 5  " .PHP_EOL;
        }

        if($type == "6") { //거래완료
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND (B.result = '7' or B.result='6')  " .PHP_EOL;
        }

        if($type == "7") { //입금배송 신청내역
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.wdate, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.bank_in_code != ''  " .PHP_EOL;

            $groupby = "B.bank_in_code";
        }

        if($type == "8") { //반품/취소
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.BP1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.result = 99  " .PHP_EOL;
        }

        if($type == "9") { //판매거부
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.PND, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.result = 98  " .PHP_EOL;
        }

        if($type == "10") { //입찰중인 물품
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.wdate, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.type=1 " .PHP_EOL;
        }

        if($type == "13") { //낙찰받지못한 물품
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.wdate, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.type=3 " .PHP_EOL;
        }


        $qry = " 
            SELECT
                COUNT(*) AS cnt
            FROM 
                ky_brand as A,
                (
                    SELECT 
                        brandcode, COUNT(*) AS auc_cnt
                    FROM 
                        ky_auction_list B 
                    WHERE 
                        B.userid='$userid'                         
                        $addQry
                    GROUP BY $groupby
                ) AS R
            WHERE
                A.brandcode=R.brandcode
                AND A.auction_now_sin_id = '$userid'
                AND A.auction_sin != 0                
        ";


        return  $this->db->query($qry)->row_array();
    }

    //구매관련정보 / BUY
    function getMyBuyAuctionData($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $return_data = [];

        //구매 및 낙찰받은 물품 (전체)
        $args['type'] = "1";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_2'] = $rst['cnt'];

        //구매 및 낙찰받은 물품 (오늘)
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_1'] = $rst['cnt'];

        //입금요청중 (전체)
        $args['type'] = "2";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_4'] = $rst['cnt'];

        //입금요청중 (오늘)
        $args['type'] = "2";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_3'] = $rst['cnt'];

        //입금확인중 (전체)
        $args['type'] = "3";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_6'] = $rst['cnt'];

        //입금확인중 (오늘)
        $args['type'] = "3";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_5'] = $rst['cnt'];

        //배송요청 (전체)
        $args['type'] = "4";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_8'] = $rst['cnt'];

        //배송요청 (오늘)
        $args['type'] = "4";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_7'] = $rst['cnt'];

        //구매결정 (전체)
        $args['type'] = "5";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_10'] = $rst['cnt'];

        //구매결정 (오늘)
        $args['type'] = "5";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_9'] = $rst['cnt'];

        //거래완료 (전체)
        $args['type'] = "6";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_12'] = $rst['cnt'];

        //거래완료 (오늘)
        $args['type'] = "6";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_11'] = $rst['cnt'];

        //입금배송 신청내역 (전체)
        $args['type'] = "7";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_14'] = $rst['cnt'];

        //입금배송 신청내역 (오늘)
        $args['type'] = "7";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_13'] = $rst['cnt'];

        //반품/취소 (전체)
        $args['type'] = "8";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_16'] = $rst['cnt'];

        //반품/취소 (오늘)
        $args['type'] = "8";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_15'] = $rst['cnt'];

        //판매거부 (전체)
        $args['type'] = "9";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_18'] = $rst['cnt'];

        //판매거부 (오늘)
        $args['type'] = "9";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_17'] = $rst['cnt'];

        //입찰중인 물품 (전체)
        $args['type'] = "10";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_20'] = $rst['cnt'];

        //입찰중인 물품 (오늘)
        $args['type'] = "10";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_19'] = $rst['cnt'];

        //최고 입찰 카운터 (전체)
        $args['type'] = "11";
        $args['day'] = "0";
        $rst = $this->getMyAuctionMaxBiding($args);
        $return_data['buy_cnt_22'] = $rst;

        //최고 입찰 카운터 (오늘)
        $args['type'] = "11";
        $args['day'] = "1";
        $rst = $this->getMyAuctionMaxBiding($args);
        $return_data['buy_cnt_21'] = $rst;

        //차순위 입찰 카운터 (전체)
        $args['type'] = "12";
        $args['day'] = "0";
        $rst = $this->getMyAuctionMaxBiding($args);
        $return_data['buy_cnt_24'] = $rst;

        //차순위 입찰 카운터 (오늘)
        $args['type'] = "12";
        $args['day'] = "1";
        $rst = $this->getMyAuctionMaxBiding($args);
        $return_data['buy_cnt_23'] = $rst;

        //낙찰받지못한 물품 (전체)
        $args['type'] = "13";
        $args['day'] = "0";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_26'] = $rst['cnt'];

        //낙찰받지못한 물품 (오늘)
        $args['type'] = "13";
        $args['day'] = "1";
        $rst = $this->getMyBuyAuctionDataDetail($args);
        $return_data['buy_cnt_25'] = $rst['cnt'];


        return $return_data;
    }

    //최고 입찰물품 , 차순위 입찰
    function getMyAuctionMaxBiding($args) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $now_day = date('Y-m-d');
        $time = time();

        $addQry = "";
        if(isset($day) && $day == "1") {
            $addQry .= "AND LEFT(wdate, 10) = '$now_day'" .PHP_EOL;
        }

        if($type == "11") {
            $orderby = "order by price desc limit 0,1";
        }

        if($type == "12") {
            $orderby = "order by price desc limit 1,1";
        }

        $qry = "
            SELECT 
              B.brandcode ,B.auction_seq
            FROM 
              ky_brand A, ky_auction_list B 
            WHERE 
            B.type = '1' 
            AND (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)
            AND B.userid ='$userid'
            AND unix_timestamp(A.edate) > $time             
         ";
        $data = $this->db->query($qry)->result_array();

        $cnt = 0;
        foreach($data as $k => $v) {
            $brandcode = $v['brandcode'];
            $auction_seq = $v['auction_seq'];

            $qry = "
              select 
                userid 
              from 
                ky_auction_list 
              where 
                (brandcode = '$brandcode' or auction_seq='$auction_seq')
                AND type != 97
                $addQry
                $orderby
            ";
            $rst = $this->db->query($qry)->row_array();

            if($userid == $rst['userid']) {
                $cnt++;
            }
        }
        return $cnt;
    }

    //판매관련정보
    function getMySellAuctionData($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $return_data = [];

        //구매 및 낙찰받은 물품 (전체)
        $args['type'] = "1";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_2'] = $rst['cnt'];

        //구매 및 낙찰받은 물품 (오늘)
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_1'] = $rst['cnt'];

        //입금확인중 (전체)
        $args['type'] = "2";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_4'] = $rst['cnt'];

        //입금확인중 (오늘)
        $args['type'] = "2";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_3'] = $rst['cnt'];

        //배송요청 (전체)
        $args['type'] = "3";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_6'] = $rst['cnt'];

        //배송요청 (오늘)
        $args['type'] = "3";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_5'] = $rst['cnt'];

        //수령이전 (전체)
        $args['type'] = "4";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_8'] = $rst['cnt'];

        //수령이전 (오늘)
        $args['type'] = "4";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_7'] = $rst['cnt'];

        //수령확인 (전체)
        $args['type'] = "5";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_10'] = $rst['cnt'];

        //수령확인 (오늘)
        $args['type'] = "5";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_9'] = $rst['cnt'];

        //입금배송 신청내역 (전체)
        $args['type'] = "6";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_12'] = $rst['cnt'];

        //입금배송 신청내역 (오늘)
        $args['type'] = "6";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_11'] = $rst['cnt'];

        //반품/취소 (전체)
        $args['type'] = "7";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_14'] = $rst['cnt'];

        //반품/취소 (오늘)
        $args['type'] = "7";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_13'] = $rst['cnt'];

        //판매거부 (전체)
        $args['type'] = "8";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_16'] = $rst['cnt'];

        //판매거부 (오늘)
        $args['type'] = "8";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_15'] = $rst['cnt'];

        //지난경매
        $args['type'] = "9";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_17'] = $rst['cnt'];

        //진행중인 경매 (전체)
        $args['type'] = "10";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_19'] = $rst['cnt'];

        //진행중인 경매 (오늘)
        $args['type'] = "10";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_18'] = $rst['cnt'];

        //등록물품중 낙찰물품 (전체)
        $args['type'] = "11";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_21'] = $rst['cnt'];

        //등록물품중 낙찰물품 (오늘)
        $args['type'] = "11";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_20'] = $rst['cnt'];

        //등록물품중 유찰물품 (전체)
        $args['type'] = "12";
        $args['day'] = "0";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_23'] = $rst['cnt'];

        //등록물품중 유찰물품 (오늘)
        $args['type'] = "12";
        $args['day'] = "1";
        $rst = $this->getMySellAuctionDataDetail($args);
        $return_data['sell_cnt_22'] = $rst['cnt'];

        return $return_data;
    }

    //판매관련정보
    function getMySellAuctionDataDetail($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $now_day = date('Y-m-d');

        $addQry = "";
        $groupby = "B.brandcode";

        if($type == "1") {  //구매 및 낙찰물품
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.D1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= "AND (B.result >= 1 AND B.result <= 7) " .PHP_EOL;
        }


        if($type == "2") { //입금확인중
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.d1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) ".PHP_EOL;
            $addQry .= " AND (B.result = 1 OR B.result = 2 OR B.result = 3)  " .PHP_EOL;
        }

        if($type == "3") { //배송요청
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.BYD, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND B.result = 4  " .PHP_EOL;
        }

        if($type == "4") { //수령이전
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.D1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) ".PHP_EOL;
            $addQry .= " AND B.result = 5  " .PHP_EOL;
        }

        if($type == "5") { //수령확인
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.D1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND (B.result='6')  " .PHP_EOL;
        }

        if($type == "6") { //거래완료 신청내역
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.D1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND (B.type=4 OR B.type =2) " .PHP_EOL;
            $addQry .= " AND (B.result='7')  " .PHP_EOL;
        }

        if($type == "7") { //반품/취소
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.BP1, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.result = 99  " .PHP_EOL;
        }

        if($type == "8") { //판매거부
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.PND, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.result = 98  " .PHP_EOL;
        }

        if($type == "13") { //낙찰받지못한 물품
            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(B.wdate, 10) = '$now_day'" .PHP_EOL;
            }
            $addQry .= " AND B.type=3 " .PHP_EOL;
        }

        if($type == "9") {  //지난경매
            $time = time();

            $qry = "
                select
                    count(*) as cnt
                from 
                    ky_brand
                where   
                  auction_sin != 0 
                  AND status != '4'
                  AND userid = '$userid'
                  AND unix_timestamp(edate) < $time
              ";
        }else if ($type == "10") { //진행중인 경매
            $time = time();

            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(sdate, 10) = '$now_day'" .PHP_EOL;
            }

            $qry = "
                select
                    count(*) as cnt
                from 
                    ky_brand
                where   
                  auction_sin = 0 
                  AND status != '4'
                  AND userid = '$userid'
                  AND unix_timestamp(edate) > $time
                  $addQry
              ";
        } else if ($type == "11") { //등록물품중 낙찰물품
            $time = time();

            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(sdate, 10) = '$now_day'" .PHP_EOL;
            }

            $qry = "
                select
                    count(*) as cnt
                from 
                    ky_brand
                where   
                  auction_sin != 0 
                  AND status != '4'
                  AND userid = '$userid'
                  AND unix_timestamp(edate) < $time
                  $addQry
              ";
        } else if ($type == "12") { //등록물품중 유찰물품
            $time = time();

            if(isset($day) && $day == "1") {
                $addQry .= "AND LEFT(sdate, 10) = '$now_day'" .PHP_EOL;
            }

            $qry = "
                select
                    count(*) as cnt
                from 
                    ky_brand
                where   
                  auction_sin = 0 
                  AND status != '4'
                  AND userid = '$userid'
                  AND unix_timestamp(edate) < $time
                  $addQry
              ";
        } else {

            $qry = " 
                SELECT
                    COUNT(*) AS cnt
                FROM 
                    ky_brand as A,
                    (
                        SELECT 
                            brandcode, COUNT(*) AS auc_cnt
                        FROM 
                            ky_auction_list B 
                        WHERE      
                            1=1                  
                            $addQry
                        GROUP BY $groupby
                    ) AS R
                WHERE
                    A.brandcode=R.brandcode
                    AND A.userid = '$userid'
                    AND A.auction_sin != 0                
            ";
        }
        return  $this->db->query($qry)->row_array();
    }

    //판매수익금 계산
    function getMySalesProfitCalc($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tmp_arr = [];

        $qry = "
            select 
              sum(A.price) - sum(A.auction_susu) as tot_sales_price
            from
              ky_auction_list A INNER JOIN ky_brand B ON (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)
            where   
              A.result='7'
              AND B.userid='$userid'           
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['tot_sales_price'] = $rst['tot_sales_price'];

        $qry = "
            select sum(price) as tot_out_price from ky_out_price where userid='$userid'
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['tot_out_price'] = $rst['tot_out_price'];
        return $tmp_arr;
    }

    //판매수익금 신청리스트
    function getMySalesProfitList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "1=1";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " userid='$userid' ";
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
        $args['q_idx'] = "id";
        $args['q_col'] = " 
                            *
                        ";
        $args['q_table'] = " ky_out_price ";
        $args['q_where'] = $addQry;
        $args['q_order'] = 'result desc, result_day desc, wdate desc';
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //나의정보관리
    function getMyInfoData($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $now_day = date('Y-m-d');

        $tmp_arr = [];

        $qry = "
            select 
              count(*)  as cnt
            from 
              ky_brand A, ky_auction_wish B 
            where 
              (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)
              AND B.userid='$userid'
              AND LEFT(B.wdate, 10) = '$now_day'
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['mypage_cnt_1'] = $rst['cnt'];

        $qry = "
            select 
              count(*)  as cnt
            from 
              ky_brand A, ky_auction_wish B 
            where 
              (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)
              AND B.userid='$userid'              
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['mypage_cnt_2'] = $rst['cnt'];

        $qry = "
            select count(*) as cnt from ky_auction_no_user where userid = '$userid' AND write_day= '$now_day' 
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['mypage_cnt_3'] = $rst['cnt'];

        $qry = "
            select count(*) as cnt from ky_auction_no_user where userid = '$userid'  
        ";
        $rst = $this->db->query($qry)->row_array();
        $tmp_arr['mypage_cnt_4'] = $rst['cnt'];

        return $tmp_arr;
    }

    //구매관련 정보관리 > > 구매 및 낙찰받은 물품
    function getAuctionBuyList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode = B.brandcode or A.auction_seq=B.auction_seq) AND (B.type = 4 or B.type = 2) ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.auction_now_sin_id='$userid' AND B.userid='$userid' ";
        }

        if(isset($result) && !empty($result)){
            switch ($result) {
                case "6" :
                    $qry_arr[] = " (B.result = '6' or B.result = '7') ";
                break;

                case "2" :
                    $qry_arr[] = " (B.result = '2' or B.result = '3') ";
                    break;
                default :
                    $qry_arr[] = " B.result = '$result' ";
                    break;
            }

            $tail[] = "&result=" . $result;
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            if($dt_type == "D1") { $orderby  = "B.D1 desc"; }
            if($dt_type == "baesong_date") { $orderby  = "B.baesong_date desc"; }
            if($dt_type == "BYE") { $orderby  = "B.BYE desc"; }
            $tail[] = "&dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " A.edate between '$sdate 00:00:00' and '$edate 23:59:59' ";
            $tail[] = "&sdate=" . $sdate;
            $tail[] = "&edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
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
                            A.*, B.price as end_price, B.id as auction_id, B.result as auction_result, B.bank_in_code,
                            B.id, B.BYD, B.baesong_date, B.baesong_company as pbc, B.baesong_num, B.BYE, B.type as btype,
                            B.auction_susu, B.commission
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //구매관련 정보관리 > 낙찰물품 구매결정
    function setAuctionPurcharse($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $now_day = date("Y-m-d");
        $qry = "
             update
                ky_auction_list
             set
              result = '6', 
              BYE = '$now_day', 
              D1=now()
             where
                id='$id' 
                and userid='$userid'               
        ";
        $this->db->query($qry);
    }

    //메일 보낼사람 정보
    function getAuctionMailUserInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $qry = "
            select 
              A.brandcode, B.userid as puserid 
            from 
              ky_auction_list A, ky_brand B 
            where 
            (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) 
            ANd A.id='$id'
        ";
        return $this->db->query($qry)->row_array();
    }

    //구매관련 정보관리 > 반품구매취소
    function getAuctionBuyCancleList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) AND (B.result = '99') ";
        $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") AND A.auction_sin != 0 ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.auction_now_sin_id='$userid' AND B.userid='$userid' ";
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            $orderby = $dt_type . " DESC";
            $tail[] = "&dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate' and '$edate' ";
            $tail[] = "&sdate=" . $sdate;
            $tail[] = "&edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
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
                            A.*, B.subject, B.price as end_price, B.banpum_result, B.BP1, B.id as auction_id, 
                            B.result as auction_result, B.userid as order_userid
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //구매관련 정보관리 > 반품구매취소 삭제처리
    function setBanfumDelete($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            update 
              ky_auction_list 
            set 
              result = history_result,
              subject = '',
              cancle_type = '',
              banpum_content = '',
              banpum_bankname = '',
              banpum_banknum = '',
              banpum_name = '',
              banpum_basong = '',
              banpum_basong_num = '',
              BP1 = ''
            where 
              id='$id' 
              AND userid='$userid'
        ";
        return $this->db->query($qry);
    }

    //구매관련 정보관리 > 정보
    function getAuctionBuyInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if(is_array($id)) {
            $ids = implode(",", $id);

            $qry = "
                select 
                    A.*, B.price as end_price, B.id as auction_id,
                    B.result, B.subject, B.banpum_content, B.cancle_type, B.banpum_bankname,
                    B.banpum_banknum, B.banpum_name, B.banpum_basong, B.banpum_basong_num,
                    B.commission, B.bank_result
                from
                  ky_brand A, ky_auction_list B
                where
                  (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) 
                  AND A.auction_now_sin_id='$userid' 
                  AND B.userid='$userid'
                  AND B.id in ($ids)
            ";
            return $this->db->query($qry)->result_array();
        }else {
            $qry = "
                select 
                    A.*, B.price as end_price, B.id as auction_id,
                    B.result, B.subject, B.banpum_content, B.cancle_type, B.banpum_bankname,
                    B.banpum_banknum, B.banpum_name, B.banpum_basong, B.banpum_basong_num,
                    B.commission, B.bank_result
                from
                  ky_brand A, ky_auction_list B
                where
                  (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) 
                  AND A.auction_now_sin_id='$userid' 
                  AND B.userid='$userid'
                  AND B.id='$id'
            ";
            return $this->db->query($qry)->row_array();
        }
    }

    //구매관련 정보관리 > > 판매거부
    function getAuctionRefusalList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) AND (B.result = '98') ";
        $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") AND A.auction_sin != 0 ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.auction_now_sin_id='$userid' AND B.userid='$userid' ";
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            $orderby = $dt_type . " DESC";
            $tail[] = "dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate' and '$edate' ";
            $tail[] = "sdate=" . $sdate;
            $tail[] = "edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
                            A.*, B.subject, B.price as end_price, B.banpum_result, B.BP1, B.id as auction_id, 
                            B.result as auction_result, B.userid as order_userid, B.type as btype, B.baesong_date, 
                            B.baesong_company as pbc, B.baesong_num, B.BYE, B.PND, B.PNO
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //구매관련 정보관리 > > 낙찰 받은 물품
    function getAuctionBuyBidList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) ";

        $dt_type = "A.sdate";
        $orderby = "A.edate asc";

        if($tp == "A") { //낙찰받은 물품
            $qry_arr[] = " (B.type = 4 or B.type = 2)";
            $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") ";
            $qry_arr[] = " (A.auction_sin != 0 or A.auction_now_sin != 0)";
            $qry_arr[] = " A.auction_now_sin_id='$userid'  ";
            $qry_arr[] = " B.userid='$userid'  ";

            $tail[] = "tp=" . $tp;
            $dt_type = "A.sdate";
            $orderby = "A.edate asc";
        }

        if($tp == "B") { //입찰중인 물품
            $qry_arr[] = " (unix_timestamp(A.edate) > ".time().") ";
            $qry_arr[] = " B.type=1 ";
            $qry_arr[] = " B.userid='$userid'  ";

            $tail[] = "tp=" . $tp;
            $dt_type = "B.wdate";
            $orderby = "B.wdate desc";
        }

        if($tp == "E") { //낙찰받지 못한 물품
            $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") ";
            $qry_arr[] = " (A.auction_sin != 0 or A.auction_now_sin != 0)";
            $qry_arr[] = " B.type=3 ";
            $qry_arr[] = " A.auction_now_sin_id='$userid'  ";
            $qry_arr[] = " B.userid='$userid'  ";

            $tail[] = "tp=" . $tp;
            $dt_type = "B.wdate";
            $orderby = "B.wdate desc";
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate' and '$edate' ";
            $tail[] = "sdate=" . $sdate;
            $tail[] = "edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
                            A.*,
                            B.price as end_price, B.id as auction_id, B.result as auction_result, B.bank_in_code,
                            B.id, B.BYD, B.baesong_date, B.baesong_company as pbc, B.baesong_num, B.BYE, B.type as btype
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //구매관련 정보관리 > > 낙찰 받은 물품
    function getAuctionBuyBidMaxList($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) ";

        if ($tp == "C") { //최고입찰 물품
            //$qry_arr[] = " (unix_timestamp(A.edate) > " . time() . ") ";
            $qry_arr[] = " B.type=1 ";
            $qry_arr[] = " B.userid='$userid'  ";

            $dt_type = "B.wdate";
            $orderby = "B.wdate desc";
            $limit = "0,1";
        }

        if ($tp == "D") { //차순위 물품
            //$qry_arr[] = " (unix_timestamp(A.edate) > " . time() . ") ";
            $qry_arr[] = " B.type=1 ";
            $qry_arr[] = " B.userid='$userid'  ";

            $dt_type = "B.wdate";
            $orderby = "B.wdate desc";
            $limit = "1,1";
        }

        if (isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate 00:00:00' and '$edate 23:59:59' ";
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
        }

        $addQry = implode(' AND ', $qry_arr);

        $qry = "
            select 
                A.*, B.brandcode, B.userid, max(B.wdate) as bwdate,
                B.price as end_price, B.id as auction_id, B.result as auction_result, B.bank_in_code,
                B.id, B.BYD, B.baesong_date, B.baesong_company as pbc, B.baesong_num, B.BYE, B.type as btype
            from
              ky_brand A, ky_auction_list B
            where   
              $addQry
            group by B.brandcode
            order by $orderby                   
        ";
        $data = $this->db->query($qry)->result_array();

        $nrow = [];
        foreach ($data as $v) {
            $qry = "
                select * from ky_auction_list where (brandcode='" . $v['brandcode'] . "' or auction_seq='". $v['auction_seq']."') order by price desc limit $limit
            ";
            echo $qry;
            $row = $this->db->query($qry)->row_array();

            if($row['userid'] == $v['userid']){
                $nrow[] = $v;
            }
        }
        return $nrow;
    }

    //일괄 배송시 같은 회원의 물품인지 여부
    function getDeliverUserChk($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $_user_id_chk = "";
        $chk = true;
        foreach ($id as $v) {
            $qry = "select userid from ky_auction_list where id='$v' ";
            $row = $this->db->query($qry)->row_array();

            if(empty($_user_id_chk)) $_user_id_chk = $row['userid'];

            if($_user_id_chk != $row['userid']) {
                $chk = false;
                break;
            }
        }
        return $chk;
    }

    //판매관련 > 구매 및 낙찰받은 물품
    function getAuctionSellList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) ";
        $qry_arr[] = " (B.type = 4 or B.type = 2) ";
        $qry_arr[] = " A.auction_sin != 0 ";
        //$qry_arr[] = " (unix_timestamp(A.edate) < ".time().") ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.userid='$userid' ";
        }

        if(isset($result) && !empty($result)){
            if($result == "2") {
                $qry_arr[] = " B.result in ('1','2','3') ";
            }else {
                $qry_arr[] = " B.result = '$result' ";
            }
            $tail[] = "&result=" . $result;
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            if($dt_type == "D1") { $orderby  = "B.D1 desc"; }
            if($dt_type == "baesong_date") { $orderby  = "B.baesong_date desc"; }
            if($dt_type == "BYE") { $orderby  = "B.BYE desc"; }
            $tail[] = "&dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate 00:00:00' and '$edate 23:59:59' ";
            $tail[] = "&sdate=" . $sdate;
            $tail[] = "&edate=" . $edate;
        }

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
        $args['show_row'] = isset($show_row) ? $show_row : 30;
        $args['show_page'] = isset($show_page) ? $show_page : 10;
        $args['sc_type'] = isset($sc_type) ? $sc_type : "";
        $args['sc_val'] = isset($sc_val) ? $sc_val : "";
        $args['excel'] = $excelHanArr;
        $args['excel_kr'] = $excelHanArr_kr;
        $args['q_idx'] = "A.auction_seq";
        $args['q_col'] = " 
                            A.*, B.price as end_price, B.id as auction_id, B.result as auction_result, B.bank_in_code,
                            B.userid as order_userid, B.type as btype, B.BYD, B.baesong_date, B.baesong_company as pbc,
                            B.baesong_num, B.BYE, B.auction_susu
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //판매관련 > 판매 정보
    function getAuctionSellInfo($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if(is_array($id)) {
            $ids = implode(",", $id);

            $qry = "
                select 
                    A.*, B.price as end_price, B.id as auction_id,
                    B.result, B.subject, B.banpum_content, B.cancle_type, B.banpum_bankname,
                    B.banpum_banknum, B.banpum_name, B.banpum_basong, B.banpum_basong_num,
                    B.commission, B.bank_result, B.panmae_no_content, B.name, B.tel, B.htel,
                    B.zip1, B.zip2, B.addr, B.addr1, B.baesong_content, B.userid as order_userid
                from
                  ky_brand A, ky_auction_list B
                where
                  (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)             
                  AND A.userid='$userid'
                  AND B.id in ($ids)
            ";
            return $this->db->query($qry)->result_array();
        }else {
            $qry = "
                select 
                    A.*, B.price as end_price, B.id as auction_id,
                    B.result, B.subject, B.banpum_content, B.cancle_type, B.banpum_bankname,
                    B.banpum_banknum, B.banpum_name, B.banpum_basong, B.banpum_basong_num,
                    B.commission, B.bank_result, B.panmae_no_content, B.name, B.tel, B.htel,
                    B.zip1, B.zip2, B.addr, B.addr1, B.baesong_content
                from
                  ky_brand A, ky_auction_list B
                where
                  (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)                  
                  AND A.userid='$userid'
                  AND B.id='$id'
            ";
            return $this->db->query($qry)->row_array();
        }
    }

    //판매관련 > 반품구매취소
    function getAuctionSellCancleList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)  AND (B.result = '99') ";
        $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") AND A.auction_sin != 0 ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.userid='$userid' ";
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            $orderby = $dt_type . " DESC";
            $tail[] = "&dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate' and '$edate' ";
            $tail[] = "&sdate=" . $sdate;
            $tail[] = "&edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
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
                            A.*, B.subject, B.price as end_price, B.banpum_result, B.BP1, B.id as auction_id, 
                            B.result as auction_result, B.userid as order_userid
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //판매관련 > 판매거부
    function getAuctionSellRefusalList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = "(A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)  AND (B.result = '98') ";
        $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") AND A.auction_sin != 0 ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.userid='$userid' ";
        }

        $orderby = "";
        if(isset($dt_type) && !empty($dt_type)){
            $orderby = $dt_type . " DESC";
            $tail[] = "dt_type=" . $dt_type;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate' and '$edate' ";
            $tail[] = "sdate=" . $sdate;
            $tail[] = "edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
                            A.*, B.subject, B.price as end_price, B.banpum_result, B.BP1, B.id as auction_id, 
                            B.result as auction_result, B.userid as order_userid, B.type as btype, B.baesong_date, 
                            B.baesong_company as pbc, B.baesong_num, B.BYE, B.PND, B.PNO, B.userid as order_userid
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    //판매관련 정보관리 > 지난경매, 진행중인경매, 낙찰, 유찰
    function getAuctionSellBidList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " status != 4 ";

        $dt_type = "sdate";
        $orderby = "edate asc";

        if($tp == "A") { //지난경매
            $qry_arr[] = " (unix_timestamp(edate) < ".time().") ";
            $qry_arr[] = " userid='$userid'  ";

            $tail[] = "tp=" . $tp;
        }

        if($tp == "B") { //진행중인 경매
            $qry_arr[] = " (unix_timestamp(edate) > ".time().") ";
            $qry_arr[] = " auction_now_sin = 0 ";
            $qry_arr[] = " userid='$userid'  ";

            $tail[] = "tp=" . $tp;
        }

        if($tp == "C") { //낙찰 물품
            $qry_arr[] = " unix_timestamp(edate) < ".time()." ";
            $qry_arr[] = " (auction_sin != 0 or auction_now_sin != 0) ";
            $qry_arr[] = " userid='$userid'  ";

            $tail[] = "tp=" . $tp;
        }

        if($tp == "D") { //유찰 물품
            $qry_arr[] = " (unix_timestamp(A.edate) < ".time().") ";
            $qry_arr[] = " auction_sin = 0 ";
            $qry_arr[] = " userid='$userid'  ";

            $tail[] = "tp=" . $tp;
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " $dt_type between '$sdate 00:00:00' and '$edate 23:59:59' ";
            $tail[] = "sdate=" . $sdate;
            $tail[] = "edate=" . $edate;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
            $tail[] = "sc_type=" . $sc_type;
            $tail[] = "sc_val=" . $sc_val;
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
        $args['q_idx'] = "auction_seq";
        $args['q_col'] = " 
                            *
                        ";
        $args['q_table'] = " ky_brand A";
        $args['q_where'] = $addQry;
        $args['q_order'] = $orderby;
        $args['q_group'] = "";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }



    //경매입금/주문/배송조회
    function getAuctionOrderList($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq)  ";
        $qry_arr[] = " (unix_timestamp(A.edate) < ".time().")";
        $qry_arr[] = " A.auction_sin != 0 and B.bank_in_code != '' ";

        if(isset($userid) && !empty($userid)){
            $qry_arr[] = " A.auction_now_sin_id='$userid' AND B.userid='$userid' ";
        }

        if(isset($sdate) && !empty($edate)) {
            $qry_arr[] = " B.$dt_type between '$sdate 00:00:00' and '$edate 23:59:59' ";
            $tail[] = "&sdate=" . $sdate;
            $tail[] = "&edate=" . $edate;
            $tail[] = "&dt_type=" . $dt_type;
        }

        if (!empty($sc_type) && !empty($sc_val)) {
            $sc_type = $this->escape_string($sc_type);
            $sc_val = $this->escape_string($sc_val);
            $qry_arr[] = " $sc_type LIKE ('%$sc_val%')";
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
        $args['q_idx'] = "B.id";
        $args['q_col'] = " 
                            B.*,
                            sum(B.price) as total, 
                            sum(B.commission) as total_com
                        ";
        $args['q_table'] = " ky_brand A, ky_auction_list B ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "B.$dt_type desc";
        $args['q_group'] = "B.bank_in_code";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this -> listclass -> listInfo($args);
    }

    function getAuctionOrderRead($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $qry = "
            select 
              A.*, B.price as end_price, 
              B.id as auction_id, B.commission, B.type, B.baesong_type_new, B.baesong_price_new,
              B.bank_result, B.pay_type, B.bank_number, B.bank_in_name, B.bank_in_date,
              B.name, B.tel, B.htel, B.zip1, B.zip2, B.addr, B.addr1, B.baesong_content,
              B.baesong_company, B.baesong_num
            from
              ky_brand A, ky_auction_list B
            where
              (A.brandcode=B.brandcode or A.auction_seq=B.auction_seq) 
              ANd B.bank_in_code='$bank_in_code'
              AND A.auction_now_sin_id = '$userid'
              AND B.userid = '$userid'
            group by A.brandcode
            order by B.price desc
        ";
        return $this->db->query($qry)->result_array();
    }

    //쇼핑주문조회
    public function getOrderList($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $tail = $qry_arr = array();

        $qry_arr[] = " A.ordernum = C.ordernum AND A.userid = '$userid' ";

        $types = ['result', 'pay_type', 'pay_result'];
        foreach ($types as $v) {
            if (isset(${$v}) && !empty(${$v})) {
                $qry_arr[] = " A." . $v . " = '${$v}' ";
                $tail[] = $v . "=" . ${$v};
            }
        }

        if (!empty($sdate) && !empty($edate)) {
            $qry_arr[] = " A.wdate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59'";
            $tail[] = "sdate=" . $sdate;
            $tail[] = "edate=" . $edate;
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
        $args['q_idx'] = "A.id";
        $args['q_col'] = " 
            A.id, A.wdate, A.name, A.userid, C.ordernum, A.result, A.pay_result, A.pay_type, A.total_end_price ,
            C.brandcode,
            if(COUNT(C.id) > 1, concat(B.brandname,'외 ',COUNT(C.id) - 1,' 종'), B.brandname) as brandname,
            BS.bae_type, BS.bae_company, BS.bae_num , DE.d_url
         ";
        $args['q_table'] = "
            ky_shop_order A 
            LEFT JOIN ky_shop_order_brand C ON(A.ordernum = C.ordernum) 
            LEFT JOIN ky_shop_brand B ON(B.shop_seq = C.brandcode OR B.brandcode = C.brandcode)
            LEFT JOIN ky_shop_baesong BS ON (A.ordernum = BS.ordernum)
            LEFT JOIN ky_delivery_comp DE ON (BS.d_seq = DE.seq)
        ";
        $args['q_where'] = $addQry;
        $args['q_order'] = "A.id desc";
        $args['q_group'] = "C.ordernum";
        $args['tail'] = $addTail;
        $args['q_see'] = "";
        return $this->listclass->listInfo($args);
    }

    //주문취소
    function setOrderCancle($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $now_day = date("Y-m-d");
        $qry = " update ky_shop_order set result = '9' where id='$id' and userid='$userid' ";
        $this->db->query($qry);
    }


}