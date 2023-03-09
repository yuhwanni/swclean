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
class Mail_m extends FW_Model
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

    function setAuctionMailSend($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        //사이트 환경설정
        $qry = "select * from tb_site_setup";
        $site_setup = $this->db-> query($qry)->row_array();

        //회원 환경설정
        $qry = "select * from ky_member_setup";
        $member_setup = $this->db-> query($qry)->row_array();

        $bank_list_array = array(
            $site_setup['admin_bank1'],
            $site_setup['admin_bank2'],
            $site_setup['admin_bank3'],
            $site_setup['admin_bank4'],
            $site_setup['admin_bank5']
        );
        $bank_list = @implode("<br>", $bank_list_array);

        //회원 이메일 정보 알기
        $qry = "select * from ky_member where userid = '".$_mail_userid_."'";
        $member_info =$this->db-> query($qry)->row_array();
        $_mail_email_ = $member_info['email'];
        $_mail_name_ = $member_info['name'];

        $qry = "select * from ky_brand where brandcode = '".$_brand_code_."'";
        $rom = $this->db-> query($qry)->row_array();

        //경매 기록 조회
        $qry  = "select * from ky_auction_list where brandcode = '".$_brand_code_."' ";
        $qry .= "order by price desc limit 1";
        $auction_row = $this->db-> query($qry)->row_array();

        switch($_mail_loc_) {

            case "판매거부":

                $subject = "[".$site_setup['saup_company']."] 판매자 판매거부 - " . $rom['brandname'];

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>판매자 판매거부 안내 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    <font color=red>판매자가 낙찰받으신 상품을 판매 거부하였습니다.<br>
                    <b>".$site_setup['saup_company']."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>" .$_mail_userid_. "</b></font> 님께서 낙찰정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=" . $rom['brandcode'] ."' target=_blank><b>" . $rom['brandname'] ."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>" . $rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>" . $rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ판매자</td>
                            <td style=padding-left:5px;>" . $rom['userid'] . "</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>판매자가 낙찰받으신 상품을 판매거부 하였습니다.<br>자세한 내용은 홈페이지를 참조하세요.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup['saup_company']." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup['saup_company']."가 책임지지 않습니다. </font>
                    </p>
                ";

                break;

            case "구매거부":

                $subject = "[".$site_setup['saup_company']."] 구매자 구매거부 - " .$rom['brandname'];

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>구매자가 낙찰받은 상품을 구매거부 하였습니다.</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup['saup_company']."</b> 입니다. <br>
                    <font color=red>구매자가 낙찰받으신 상품을 구매거부 하였습니다.<br>
                    <b>".$site_setup['saup_company']."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 판매정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=" . $rom['brandcode'] ."' target=_blank><b>" . $rom['brandname'] ."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>" . $rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>" . $rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ구매자</td>
                            <td style=padding-left:5px;>" .$auction_row['userid'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>구매자가 낙찰받은 상품을 구매거부 하였습니다.<br>자세한 내용은 홈페이지를 참조하세요.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 판매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			";

                break;

            case "거래완료":

                $subject = "[".$site_setup["saup_company"]."] 판매자 거래완료 - $rom[brandname]";

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>판매자 거래완료 안내 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    <font color=red>사이트 관리자가 아래 물품에 대한 상태를 거래완료로 처리하였습니다.<br>
                    물품대금은 출금신청을 통해 지급받으실수 있습니다.<br></font>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 판매정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ실수령액</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price']-$auction_row['auction_susu'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ구매자</td>
                            <td style=padding-left:5px;>".$auction_row['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ거래완료일</td>
                            <td style=padding-left:5px;>".$ADE."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>모든 거래가 완료되었습니다.<br>물품대금은 출금신청을 통해 지급받으실수 있습니다.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			";

                break;

            case "수령요청":

                $subject = "[".$site_setup["saup_company"]."] 구매자 수령요청 - $rom[brandname]";
                if($_mail_type_){
                    $msg = " ($_mail_type_  일째) ";
                }
                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>구매자 수령요청 안내 메일 $msg</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    물품배송 후 $_mail_type_ 일이 경과 되었습니다.<br>
                    물품이 정상적으로 배송되었다면 홈페이지에서 수령확인을 해주시면 감사하겠습니다.<br>
                    
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 구매정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>물품배송 후 $_mail_type_ 일이 경과 되었습니다.<br>물품이 정상적으로 배송되었다면 홈페이지에서 수령확인을 해주세요.</td>
                        </tr>
                    </table>
                    <br>
                    
                    <p style=line-height:150%;>
                    
                    제25조(구매결정 및 송금)<br>
                    가. 구매자는 물품을 수령한 후 반품하지 않고 구매를 최종 결정하게 되면, 판매자에 대한 대금송금을 위하여 즉시 서비스화면에서 [구매결정]항목을 클릭해야 합니다. 구매결정을 하게 되면 구매자가 금요경매에 보관의뢰한 물품대금은 판매자에게 송금되므로 구매결정 이후에는 반품을 일체할 수 없습니다. (단, 구매결정이후 배송일로부터 7일이내에 구매결정 클릭을 하지 않으신 경우에는 금요경매에서 대리하여 거래완료로 처리 할 수 있습니다. )<br><br>
                    
                    나의경매관리-나의정보관리-판매대금수령계좌번호<br>
                    <font color=red>[국민은행,조흥은행,우리은행,농협중앙회,우체국이외에 은행계좌는 수수료가 부가됩니다.]</font>
                    
                    </p>
                    <br>
                    
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
                ";



                break;

            case "수령확인":
                $subject = "[".$site_setup["saup_company"]."] 구매자 수령확인 - $rom[brandname]";

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>구매자 수령확인 안내 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    구매자가 구매결정을 하였습니다.<br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 판매정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ구매자</td>
                            <td style=padding-left:5px;>".$auction_row['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>구매자가 수령확인을 하였습니다.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
                ";

                break;

            case "물품배송":

                $subject = "[".$site_setup["saup_company"]."] 판매자 물품배송 - $rom[brandname]";

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>판매자 물품배송 안내 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    판매자가 구매자의 배송지 정보로 상품을 배송하였습니다.<br>
                    <font color=red>물품이 정상적으로 도착하셨다면 꼭 구매결정을 해주세요</font><br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 낙찰정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ판매자</td>
                            <td style=padding-left:5px;>".$rom['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>판매자가 구매자의 주소로 물품을 배송하였습니다.</td>
                        </tr>
                    </table>
                    <br>
                    <b>배송정보</b>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td bgcolor=f4f4f4 width=18%>ㆍ배송업체</td>
                            <td style=padding-left:5px;>".$baesong_company."</td>
                        </tr>
                    
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ운송장번호</td>
                            <td style=padding-left:5px;>".$baesong_num."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ물품배송일</td>
                            <td style=padding-left:5px;>".$baesong_date."</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			";

                break;

            case "배송요청":

                $subject = "[".$site_setup["saup_company"]."] 판매자 배송요청 - $rom[brandname]";

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>판매자 배송요청 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    등록하신 상품이 정상적으로 입금확인이 완료되었습니다.<br>
                    구매자의 배송지 정보로 배송하여 주시기 바랍니다.<br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님의 물품정보입니다.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ구매자</td>
                            <td style=padding-left:5px;>".$auction_row['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ배송요청일</td>
                            <td style=padding-left:5px;>".$D1."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>입금이 완료 되었습니다.<br>판매자는 구매자의 주소로 배송하시기 바랍니다.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			";


                break;

            case "입금확인":

                $subject = "[".$site_setup["saup_company"]."] 구매자 입금확인 - $rom[brandname]";

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>구매자 입금확인 메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    낙찰받으신 상품의 입금확인이 완료되었습니다.<br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 낙찰정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ판매자</td>
                            <td style=padding-left:5px;>".$rom['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ입금확인일</td>
                            <td style=padding-left:5px;>".$B3."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ안내</td>
                            <td style=padding-left:5px;>입금확인이 정상적으로 완료 되었습니다.</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction_main.htm' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리</b></a>에 들어가셔서 상태를 확인하실수 있습니다.<br><br>
                    
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			    ";

                break;

            case "입금안내":

                $subject = "[".$site_setup["saup_company"]."] 구매자 입금안내 - $rom[brandname]";

                $commission = ($auction_row[price] / 100 ) * 10;

                if($_mail_type_){
                    $msg = " ($_mail_type_  일째) ";
                }

                $html = "
                    <p style=line-height:150%;>
                    <font color=red><b>구매자 입금안내 메일 $msg </b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    낙찰 받으신 상품의 금액을 입금하여 주시기 바랍니다.<br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 낙찰정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ결재금액</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원 + ".number_format($commission)." 원(수수료 10%) = ".number_format($auction_row['price']+$commission)." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ판매자</td>
                            <td style=padding-left:5px;>".$rom['userid']."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ입금계좌번호</td>
                            <td style=padding-left:5px;><p style=line-height:150%;>".$bank_list."</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction01_1.htm?mode=1' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리 > 입금요청</b></a>에 들어가셔서 배송지 입력 및 입금정보를 입력해주세요. <br><br>
                    [".$site_setup["saup_company"]."] 이용약관 제15조 나항]에 따라 낙찰 후 ".$this->GP['AUCTION_IN_MONEY_LIMIT_DAY']."일(토.공휴일포함)안에 입금하셔야 합니다. <br>
                    입금기한(".$this->GP['AUCTION_IN_MONEY_LIMIT_DAY']."일)이 지나도록 구매자의 입금내역이 확인되지 않으면, 구매거부로 자동 경매취소처리 됩니다. <br>
                    꼭 입금신청을 하셔야만 입금확인이 됩니다. 입금신청 정보가 없을 경우에는 입금확인이 불가합니다.<br>
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>
			        ";
                break;

            case "낙찰안내":

                $subject = "[".$site_setup["saup_company"]."] 구매자 낙찰안내 - $rom[brandname]";

                $commission = ($auction_row[price] / 100 ) * 10;

                $html = "
                    <p style=line-height:150%;>			
                    <font color=red><b>구매자 낙찰 안내메일</b></font><br><br>	
                    안녕하십니까? <b>".$site_setup["saup_company"]."</b> 입니다. <br>
                    축하드립니다. 입찰하신 상품이 낙찰되셨습니다.<br>
                    <b>".$site_setup["saup_company"]."</b>를 이용해주셔서 대단히 감사합니다. <br>
                    <font color=blue><b>$_mail_userid_</b></font> 님께서 낙찰정보는 아래를 참조 하세요.<br><br>
                    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=cccccc bordercolorlight=999999 bordercolordark=ffffff align=center>
                        <tr height=26>
                            <td width=18% bgcolor=f4f4f4>ㆍ물품명</td>
                            <td style=padding-left:5px;><a href='http://".$_SERVER['HTTP_HOST']."/htm/productlist_detail.htm?brandcode=".$rom['brandname']."' target=_blank><b>".$rom['brandname']."</b></a></td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매번호</td>
                            <td style=padding-left:5px;><font color=red><b>".$rom['auction_code'] ."</td>
                        </tr>
                        <tr height=26 height=26>
                            <td bgcolor=f4f4f4>ㆍ낙찰시간</td>
                            <td style=padding-left:5px;>".$rom['edate'] ."</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 시작가</td>
                            <td style=padding-left:5px;>".number_format($rom['sprice'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ경매 낙찰가</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ결재금액</td>
                            <td style=padding-left:5px;><font color=red><b>".number_format($auction_row['price'])." 원 + ".number_format($commission)." 원(수수료 10%) = ".number_format($auction_row['price']+$commission)." 원</td>
                        </tr>
                        <tr height=26>
                            <td bgcolor=f4f4f4>ㆍ판매자</td>
                            <td style=padding-left:5px;>$rom[userid]</td>
                        </tr>
                    </table>
                    <br>
                    <b><a href='http://".$_SERVER['HTTP_HOST']."/htm/myauction01_1.htm?mode=1' target=_blank>".$site_setup["saup_company"]." 홈페이지 > 나의 경매관리 > 구매관련 정보관리 > 입금요청</b></a>에 들어가셔서 배송지 입력 및 입금정보를 입력해주세요. <br><br>
                    [".$site_setup["saup_company"]."] 이용약관 제15조 나항]에 따라 낙찰 후 ".$this->GP['AUCTION_IN_MONEY_LIMIT_DAY']."일(토.공휴일포함)안에 입금하셔야 합니다. <br>
                    입금기한(".$this->GP['AUCTION_IN_MONEY_LIMIT_DAY']."일)이 지나도록 구매자의 입금내역이 확인되지 않으면, 구매거부로 자동 경매취소처리 됩니다. <br>
                    꼭 입금신청을 하셔야만 입금확인이 됩니다. 입금신청 정보가 없을 경우에는 입금확인이 불가합니다.<br>
                    기타 자세한 안내는 홈페이지를 참조하세요. <a href='http://".$_SERVER['HTTP_HOST']."/htm/customer04_1.htm' target=_blank><font color=blue>[도움말 바로가기]</font></a><br>
                    <font color=red>※ 직거래로 발생하는 불이익에 대해서는 ".$site_setup["saup_company"]."가 책임지지 않습니다. </font>
                    </p>			
			    ";
                break;
        }

        $this->load->library('mailsend');

        $sender = isset($sender) ? $sender : $this -> GP['EMAIL_DEF'][1];

        $args = array();
        $args['sender'] = array($this -> GP['EMAIL_DEF'][0], $sender);
        $args['reciever'][] = array($_mail_email_, $_mail_name_ . ' 님');
        $args['subject'] = $subject;
        $args['contents'] = $html;
        //$rst = $this->mailsend->sendMail($args);
        $rst = 1;
        return $rst;
    }
}