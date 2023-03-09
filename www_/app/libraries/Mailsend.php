<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailsend extends FW_Controller
{
    private $mail;
    private $WWW = "";
    private $lookup_match_arr = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->library('globals');
        $this->GP =  $this->load->get_vars();
        $this->mail = new PHPMailer;
        $this -> WWW = $this -> GP['DOMAIN'];
    }

    public function parseMatchString($args = array())
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $patterns = array();
        $replacements = array();

        $origin = $this->lookup_match_arr;

        foreach ($origin as $v) {
            $patterns[] = "/{" . $v . "}/";
            $replacements[] = ${$v};
        }

        return preg_replace($patterns, $replacements, $str);
    }

    public function getMailBean($args = array())
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $mail_contents 	= $this->getMailContents($args);
        $args['str'] 		= $mail_contents;
        return $this->parseMatchString($args);
    }

    function getSubject($mail_type)
    {
        global $GP;
        switch ($mail_type) {

            case 'pass_tmp_send':
                $rst = "[" . $this ->GP['TH']['NAME'] . "] 임시 비밀번호를 입니다.";
                break;
        }
        return $rst;
    }

    function getMailContents($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $str = "";

        switch ($mail_type) {
            case 'pass_tmp_send':
                $str = "
	<div style=\"width:720px;height:20px;background:url(http://" . $this -> WWW . "/resource/custom/img/mail/mail_head.gif) no-repeat;\"></div>
	<div style=\"width:720px;min-height:300px; background:url(http://" . $this -> WWW . "/resource/custom/img/mail/mail_body.gif) repeat-y;\">
		<div style=\"padding:10px 30px;\">
			<div><a href=\"http://" . $this -> WWW . "\" target=\"_blank\"><img src='http://" . $this -> WWW . "/web/assets/images/logo.png' width='150'></a></div>
			<hr>
		</div>
		<div>
			<div style=\"font-family:NanumB;color:#414141;text-align:center; padding:30px 0px\"><h1>" . $this ->GP['TH']['NAME'] . " <span style=\"color:#5a7dbc\">임시 비밀번호 발송</span> 메일입니다.</h1></div>
			<div style=\"padding:0px 70px; line-height:180%\">임시 비밀번호는 <span style=\"color:#5a7dbc\">" . $tmp_pwd . "</span> 입니다.</div>			
		</div>
	</div>			
				";
                break;
        }

        // 해더,푸터 사용시 앞뒤로 붙임
        $str = $this->mailHead() . $str . $this->mailFoot($args);

        return $str;
    }

    function mailHead($args = array())
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $str = "<div style=\"width:720px; margin:auto\">";
        return $this->mailStyleHead() . $str;
    }

    function mailStyleHead()
    {
        $str = "
			<!doctype html>
			<html lang=\"en\"><head>
			<meta charset=\"utf-8\">
			<style>
			@font-face{
			font-family:NanumB;
			src: url('http://" . $this->WWW . "/resource/custom/fonts/NanumGothicBold.eot');
			src: local('※'), 
			url('http://" . $this->WWW . "/resource/custom/fonts/NanumGothicBold.eot?#iefix') format('embedded-opentype'), 
			url('http://" . $this->WWW . "/resource/custom/fonts/NanumGothicBold.woff') format('woff'),
			url('http://" . $this->WWW . "/resource/custom/fonts/NanumGothicBold.ttf') format('truetype');
			}

			html, body {margin:0px;width:100%}
			div {font-family: 돋움; font-size:12px}
			img {border:0px}
			</style>

			<body>
		";

        return $str;
    }

    // title  : 메일 html 푸터
    // author : 11.06.09
    // param  :
    function mailFoot ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        $str = "
	<div style=\"width:720px;height:280px;background:url(http://" . $this -> WWW . "/resource/mail/mail_foot.gif) no-repeat;\">
		<div style=\"padding:40px; padding-top:100px\">
			<div style=\"color:#a0a0a0\">본 메일은 발신전용 입니다. 궁금하신 점이나 불편한 사항은 고객센터를 통해 문의해 주시기 바랍니다. </div>
			<div style=\"color:#FFFFFF; line-height:150%; padding-top:10px\">
			<p>주식회사 " . $this -> GP['TH']['MNG_NAME'] . "</p>
			사업자등록번호 : " . $this -> GP['TH']['BRM'] . "  |  대표이사 : " . $this -> GP['TH']['CEO'] . " <br>
			전화번호 : " . $this -> GP['TH']['TEL'] . "  |  팩스번호 : " . $this -> GP['TH']['FAX'] . " <br>
			주소 : " . $this -> GP['TH']['ADDR'] . " | Email : " . $this -> GP['TH']['HELP_EMAIL'] . "<br>
			Copyright " . $this -> GP['TH']['ENG_NAME'] . " co.,LTD All Rights Reserved.
			</div>
		</div>
	</div>
";
        return $str . $this -> mailStyleFoot();
    }

    function mailStyleFoot()
    {
        $str = "</div>			
		</body></html>";
        return $str;
    }

    // DESC :
    // DATE : Wed Dec 28 03:00:29 GMT 2016
    // PARAM : $cate , $type, $join_link
    function sendMail($args = [])
    {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        try {
            $contents = isset($contents) ? $contents : "";
            if ($contents == "") {
                $contents = $this->getMailBean($args);
            }

            $subject = isset($subject) ? $subject : "";
            if ($subject == "") {
                $subject = $this->getSubject($mail_type);
            }

            $this->mail->isSMTP();                                    // Set mailer to use SMTP
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $this->mail->SMTPDebug = 0;
            $this->mail->SMTPSecure = "tls";
            $this->mail->SMTPKeepAlive = true;
            $this->mail->CharSet    = "UTF-8";
            $this->mail->Encoding   = "base64";
            $this->mail->Host = $this -> GP['SMTP_SERVER'];  					// Specify main and backup SMTP servers
            $this->mail->SMTPAuth = true;                             // Enable SMTP authentication
            $this->mail->Username = $this -> GP['SMTP_USER'];                 // SMTP username
            $this->mail->Password = $this -> GP['SMTP_PASS'];                 // SMTP password
            $this->mail->Port =$this -> GP['SMTP_PORT'];                     // TCP port to connect to

            // address , name
            $this->mail->setFrom($sender[0], $sender[1]);
            $this->mail->AddReplyTo($sender[0], $sender[1]);

            $this->mail->ClearAllRecipients();

            if (!empty($reciever) && is_array($reciever)) {
                foreach ($reciever as $v) {
                    // address , name
                    $this->mail->addAddress($v[0], $v[1]);     		// Add a recipient
                }
            }

            $this->mail->Subject = $subject;
            $this->mail->MsgHTML($contents);

            return ($this->mail->send()) ? true : false;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
        }
    }
}
