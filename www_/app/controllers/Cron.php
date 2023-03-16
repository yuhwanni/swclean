<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

//define( 'LOC_TYPE', 'www');

/**
 * Class Member
 *
 * @property Member_mcb $member_mcb
 */
class Cron extends FW_Controller
{

    private $m_idx = "";
    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('adm/auction_m','common/mail_m'));
        $this->load->helper(array('url', 'security', 'common', 'download', 'array'));
        $this->load->library(array('globals', 'func'));
        $this->GP = $this->load->get_vars();


        $this->post = $this->security->xss_clean($this->input->post());
        $this->get = $this->security->xss_clean($this->input->get());

        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    public function _remap($method)
    {
        if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->index();
        }
    }

    public function index()
    {
        $this->func->putMsgAndBack('찾으시는 페이지가  존재하지 않습니다.');
    }

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

    function setAuctionListModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['id']);
        return $this->db->update('ky_auction_list', $args, array('id' => $id));
    }

    function setAuctionBrandModify($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        unset($args['auciton_seq']);
        return $this->db->update('ky_brand', $args, array('auciton_seq' => $auciton_seq));
    }

    function getpoprice($auciton_seq, $data, $acid){

        $qry = "
            select count(*) as cnt from ky_auction_list where auciton_seq='$auciton_seq' group by userid order by price desc
        ";
        $rst = $this->db->query($qry)->row_array();
        $user_cnt = $rst['cnt'];

        // 혼자 여러번 입찰일때
        if($user_cnt == 1){
            $offprice = $data['sprice'];
            // 여러명이서 입찰일때
        } else if($user_cnt > 1){
            $qry = "
                select * from ky_auction_list where auciton_seq='$auciton_seq' && userid!='$acid' order by price desc, id desc limit 0, 1
            ";
            $rst1 = $this->db->query($qry)->row_array();
            $offprice = $rst1['price'] + $data['order_price_unit'];

            // 입찰가격이 시작가격보다 작을때는 시작가
            if($data['sprice'] > $offprice) $offprice = $data['sprice'];
        }
        return $offprice;
    }

    public function setMemPwdSet() {
        $qry = "
            select 
              id, pass
            from 
              ky_member 
            where
              npass = ''
        ";
        $rst = $this->db-> query($qry)->result_array();

        foreach ($rst as $v) {
            $id = $v['id'];
            $pass = $v['pass'];
            $npass = hash("sha256", $pass);

            $qry = "
                update 
                    ky_member
                set
                  npass = '$npass'
                where
                  id='$id'
            ";
            $this->db-> query($qry);
        }
        echo "success";
    }

    //재경매 등록
    public function setAuctionReCron() {

        $_brand_reinsert_count = $this->GP['BRAND_REINSERT_COUNT'];

        //경매가 끝났 물건중에 즉시구매가 없는경우
        //list($num, $pcode) = $this->par_code($brandcode);

        $qry  = "
          select 
            * 
          from 
            ky_brand 
          where
            auto_insert='예'
            and grp < $_brand_reinsert_count
            and unix_timestamp(edate) < ".time()." 
            and auction_sin = 0
        ";
        echo $qry .PHP_EOL;
        $rst = $this->db-> query($qry)->result_array();

        foreach ($rst as $v) {
            $auction_seq = $v['auction_seq'];
            $brandcode = $v['brandcode'];
            $auto_insert_price = $v['auto_insert_price'];
            $sdate = $v['edate'];
            $edate = date("Y-m-d", strtotime($sdate) + (86400 * $v['brand_life_day']));
            if(strlen($v['emin']) == 1) {
                $edate = $edate . " " . $v['ehour'] . ":" . "0".$v['emin'] . ":01";
            }else {
                $edate = $edate . " " . $v['ehour'] . ":" . $v['emin'] . ":01";
            }

            $qry  = "
              update 
                ky_brand 
              set 
                sdate = '$sdate',
                edate = '$edate',
                grp = grp + 1, 
                sprice = '$auto_insert_price',
                hit=0 
              where 
                auction_seq = '$auction_seq'
            ";
            echo $qry .PHP_EOL;
            $this->db-> query($qry);
        }
    }

    //수수료 정보 업데이트
    public function setAuctionCommissionCron() {
        $qry = "
            select
                A.*, B.price as end_price, B.id as auction_id 
            from
              ky_brand A, ky_auction_list B
            where
              (A.brandcode = B.brandcode or A.auction_seq=B.auction_seq) 
              AND (B.type = 4 or B.type = 2)
              AND B.commission = ''              
        ";
        echo $qry .PHP_EOL;
        $data = $this->db->query($qry)->result_array();

        foreach ($data as $v) {
            $category = $v['category'];
            $edate = $v['edate'];
            $end_price = $v['end_price'];
            $auction_id = $v['auction_id'];

            // 온라인 특별경매일때 11%
            if($category == "111000000000"){
                // 2011년 경매 종료 상품부터 수수료 적용 (11%)
                if(date("Y", strtotime($edate)) >= "2011"){
                    $commission = ($end_price / 100 ) * 11;
                } else {
                    $commission = 0;
                }
            } else {
                $end_year = date("Y", strtotime($edate));

                if($end_year >= "2011" && $end_year < 2019 ){
                    // 2011년 경매 종료 상품부터 수수료 적용 (5%)
                    $commission = ($end_price / 100 ) * 5;
                } else if($end_year>= "2019"){
                    // 2019년 경매 종료 상품부터 수수료 적용 (10%)
                    $commission = ($end_price / 100 ) * 10;
                } else {
                    $commission = 0;
                }

                // 2019년 입금신청 부터 수수료 적용 (10%)
                if($end_year >= 2019) {
                    $commission = ($end_price / 100) * 10;
                }
            }

            $qry = "
              update 
                ky_auction_list 
              set 
                commission='$commission' 
              where 
                id='$auction_id' 
            ";
            echo $qry .PHP_EOL;
            $this->db->query($qry);
        }
    }

    //낙찰 설정
    public function setAuctionResultUpdate() {

        //입찰한 상품의 경매가 끝났다면 처리(즉시구매가 있는 경매면 업안한다)
        $qry = "
            select 
              B.*
            from 
              ky_auction_list A, ky_brand B 
            where 
                (A.brandcode = B.brandcode or A.auction_seq=B.auction_seq)           
                AND A.type = 1
                AND A.result = 1
                AND unix_timestamp(B.edate) < ".time()."
                AND B.auction_sin!=0
            group by B.brandcode
        ";
        echo $qry .PHP_EOL;
        $rst = $this->db-> query($qry)->result_array();

        foreach ($rst as $v) {
            $auciton_seq = $v['auciton_seq'];
            $brandcode = $v['brandcode'];

            $qry = "select * from ky_auction_list where auciton_seq='$auciton_seq' order by price desc";
            $rst1 = $this->db-> query($qry)->result_array();
            $acnt = count($rst1);
            $arow = $rst1[0];

            if($acnt == 1){
                $offprice = $rst1[0]['sprice'];
            } else if($acnt > 1){
                $offprice = $this->getpoprice($auciton_seq, $v, $arow['userid']);
            }

            // 낙찰 설정
            $args = [];
            $args['price']			= $offprice;
            $args['old_price']		= $arow['price'];
            $args['auction_susu']	= $offprice * $this->GP['AUCTION_COMMISION'];

            if($v['category'] == "111000000000"){   //특별경매
                $args['commission']	= $offprice * 0.11;	// 수수료 적용 (11%)
            } else {
                $args['commission']	= $offprice * 0.1;	// 수수료 적용 (10%) - 2019 년부터 수수료인상
            }

            $args['type']		    = 4;	// 낙찰 처리
            $args['D1']			    = $v['edate'];
            $args['auction_date']	= date("Y-m-d H:i:s");
            $args['id'] = $arow['id'];
            $this->setAuctionListModify($args);

            // 나머지 입찰 유찰처리
            $qry = "update ky_auction_list set type='3' where auciton_seq = '$auciton_seq' AND id != '" . $arow['id'] . "'";
            echo $qry .PHP_EOL;
            $this->db->query($qry);

            // 낙찰상품 수정
            $args = [];
            $args['auction_now_sin_id'] = $arow['id'];

            // 온라인 특별경매 상품일경우
            if($v['category'] == "111000000000"){
                // 배송료 설정
                if($offprice > $this->GP['DELIVARY_LIMIT_PRICE2']){
                    $args['baesong_type'] = "판매자부담";
                    $args['baesong_price'] = 0;
                } else {
                    $args['baesong_type'] = "낙찰자부담";
                    $args['baesong_price'] = 4000;
                }
            } else {
                // 배송료 설정
                if($offprice > $this->GP['DELIVARY_LIMIT_PRICE']){
                    $args['baesong_type'] = "판매자부담";
                    $args['baesong_price'] = 0;
                } else {
                    $args['baesong_type'] = "낙찰자부담";
                    $args['baesong_price'] = $this->GP['DELIVARY_PRICE'];
                }
            }
            $args['auciton_seq'] = $auciton_seq;
            $this->setAuctionBrandModify($args);

            /*********************** 메일 발송 ************************/
            $args = [];
            $args['_mail_userid_']	= $arow['userid'];
            $args['_mail_loc_']		= "낙찰안내";
            $args['_brand_code_']	= $brandcode;
            //$this->mail_m->setAuctionMailSend($args);

            $args = [];
            $args['_mail_userid_']	= $v['userid'];
            $args['_mail_loc_']		= "입금안내";
            $args['_brand_code_']	= $brandcode;
            //$this->mail_m->setAuctionMailSend($args);
            /*********************** 메일 발송 ************************/
        }
    }

    //메일 안내
    public function setAuctionAfterMailSend() {

        // 수입금 등록값이 없을 경우 수익금 업데이트
        $qry = "select  auction_susu,price,id,wdate from ky_auction_list where auction_susu=0 && substring(wdate,1,10)>=2016 order by id desc";
        $rst = $this->db-> query($qry)->result_array();
        foreach ($rst as $k => $v) {
            $susu_price = $v['price'] * $this->GP['AUCTION_COMMISION'];

            $qry = "update ky_auction_list set auction_susu='$susu_price' where id='" . $v['id'] ."'";
            $this->db-> query($qry);
        }
        // 수입금 등록값이 없을 경우 수익금 업데이트

        /*****************************************************/
        //특정 날짜 지난 후 입금이 되지 않으면 입금확인 안내메일 5일 이전
        $qry  = "select * from ky_auction_list where ";
        $qry .= "unix_timestamp(concat(left(D1,10),' 00:00:01')) < ";
        $qry .= "unix_timestamp(date_add(concat(left(now(),10),' 23:59:59'), INTERVAL -5 day)) and ";
        $qry .= "type = 4 and result = 1 and auto_mail = 0 ";
        $auto_mail_rs = $this->db->query($qry)->result_array();
        foreach ($auto_mail_rs as $auto_mail) {
            $_mt_ = strtotime(date("Y-m-d 23:59:59"))-strtotime(substr($auto_mail['D1'],0,10)." 00:00:01");
            $_mail_type_	= @round(($_mt_/86400));

            if(!$auto_mail['auto_mail']){

                $args = [];
                $args['_mail_type_'] = $_mail_type_;
                $args['_mail_userid_']	= $auto_mail['userid'];
                $args['_mail_loc_']		= "입금안내";
                $args['_brand_code_']	= $auto_mail['brandcode'];
                $this->mail_m->setAuctionMailSend($args);

                $qry  = "update ".AUCTION_LIST." set auto_mail = '$_mail_type_' where id = '".$auto_mail['id']."'";
                $this->db-> query($qry);
            }
        }

        $qry  = "select * from ky_auction_list where ";
        $qry .= "unix_timestamp(concat(left(baesong_date,10),' 00:00:01')) < ";
        $qry .= "unix_timestamp(date_add(concat(left(now(),10),' 23:59:59'), INTERVAL -5 day)) and ";
        $qry .= "type = 4 and result = 5 and auto_mail1 = 0 ";
        $auto_mail_rs = $this->db->query($qry)->result_array();

        foreach ($auto_mail_rs as $auto_mail2) {
            $_mt_ = strtotime(date("Y-m-d 23:59:59"))-strtotime(substr($auto_mail2['baesong_date'],0,10)." 00:00:01");
            $_mail_type_	= @round(($_mt_/86400));
            if(!$auto_mail2['auto_mail1']){

                $args = [];
                $args['_mail_type_'] = $_mail_type_;
                $args['_mail_userid_']	= $auto_mail2['userid'];
                $args['_mail_loc_']		= "수령요청";
                $args['_brand_code_']	= $auto_mail2['brandcode'];
                $this->mail_m->setAuctionMailSend($args);

                $qry  = "update ky_auction_list set auto_mail1 = '$_mail_type_' where id = '".$auto_mail2['id']."'";
                $this->db-> query($qry);
            }
        }
        /*****************************************************/
    }
}