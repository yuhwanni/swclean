<?
/*
*		TITLE 	: 공통 기능 클레스
*		FILE 	: class.func.php
*		AUTHOR 	: JOYPLUX
*		BUILD 	: Mon Jan 25 04:55:59 GMT 2016
*		MODIFY 	: 
*/

CLASS Func
{

    protected $GP;
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->library(array('globals', 'func'));
        $this->GP =  $this->CI->load->get_vars();
    }
#############################################################
#
#	기본 컨포넌트
#
#############################################################		

    // DESC : SELECT박스 자동 생성
    // AUTHOR : JOYPLUX (Mon Jan 25 04:55:26 GMT 2016)
    // PARAM : select_name, select_arr, vals, etc, basic, sort, arr_type
    // USAGE :
    /* sample :
    $mail_type_arr = array(
                        'news_def'=>'뉴스레터 기본',
                        'exam_delay'=>'심사보류',
                        'deposit'=>'입금확인'
                        );
    $args = array();
    $args['select_name'] 	= "mail_type";
    $args['select_arr'] 	= $mail_type_arr;
    $args['vals'] 			= $mail_type;
    $args['etc'] 			= "onchange='mailSet(this.value)'";
    $args['basic'] 			= "::없슴::";
    $args['sort'] 			= "";
    $mail_type_sel = $C_Func -> makeSelect($args);
    */

    function makeSelect ($args = array()) {
        foreach ($args as $k => $v) ${$k} = $v;

        if ($select_name) {
            $add_str = "name='$select_name' id='$select_name'";
        }
        $str = "<select $add_str $etc>";
        if ($basic) {
            $str .= "<option value=''>$basic</option>";
        }

        if (count($select_arr) && is_array($select_arr)) {
            if ($sort != 'none_sort') {
                asort($select_arr);
            }

            foreach ($select_arr as $key => $value) {
                $option_value = "";
                $option_name = "";
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;
                $selected = "";
                if($vals != '' && $vals == $option_value && isset($vals)) $selected = "selected";
                $str .= "<option value='$option_value' $selected>$option_name</option>";
            }

        }
        $str .= "</select>";

        return $str;
    }

    // DESC : RADIO 박스 자동 생성
    // AUTHOR : YUHWANNI (2016.01.28)
    // PARAM : array, name, val;
    // USAGE :
    function makeRadio ($args = array()) {

        foreach ($args as $k => $v) ${$k} = $v;

        if ($radio_name) {
            $add_str = "name='$radio_name' id='$radio_name'";
        }
        $str = "";
        if ($basic) {
            //$str .= "";
        }

        if (count($radio_arr) && is_array($radio_arr)) {
            if ($sort != 'none_sort') {
                asort($radio_arr);
            }

            foreach ($radio_arr as $key => $value) {
                $option_value = "";
                $option_name = "";
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;
                $selected = "";
                if($vals != '' && $vals == $option_value && isset($vals)) $selected = "checked";

                //$str .= "<input type='radio' $add_str value='$option_value' $selected>".$option_name;
                $radio_labelId = $radio_name."_".$option_value;

                $str .= "<div class='custom-control custom-radio custom-control-inline'>";
                $str .= "<input type='radio' id='$radio_labelId' value='$option_value' class='custom-control-input' name='$radio_name' $selected>";
                $str .= "<label class='custom-control-label' for='$radio_labelId'>$option_name</label>";
                $str .= "</div>";
            }
        }
        $str .= "";

        return $str;
    }

    function makeCheckbox($args = array()) {
        foreach ($args as $k => $v) ${$k} = $v;

        if ($ckb_name) {
            $ck_name = "name='$ckb_name" . "[]" . "'";
        }

        $str = "";

        if (count($ckb_arr) && is_array($ckb_arr)) {
            if ($sort != 'none_sort') {
                asort($ckb_arr);
            }

            $k=0;
            foreach ($ckb_arr as $key => $value) {
                $option_value = "";
                $option_name = "";
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;

                $selected = "";
                if (is_array($vals) && isset($vals)) {
                    $selected = (in_array($key,$vals))? 'checked' : '';
                }

                $id = $ckb_name. "_" . $k;

                $str .= "<div class='custom-control custom-checkbox'>";
                $str .= "<input type='checkbox' class='custom-control-input' value='$option_value' $ck_name $selected id='$id'>";
                $str .= "<label class='custom-control-label' for='$id'>$option_name</label>";
                $str .= "</div>";
                $k++;
            }
        }
        $str .= "";

        return $str;
    }


    // DESC : 배열에서 키와 값이될 변수명을 입력받아 SELECT박스 배열로 변환
    // AUTHOR : JOYPLUX (Mon Jan 25 04:55:13 GMT 2016)
    // PARAM :
    function makeSelectArray ($args = array()) {
        foreach ($args as $k => $v) ${$k} = $v;
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                $rst[$v[$key]] = $v[$val];
            }
        }

        return $rst;
    }

    // DESC : 키와 값이 같을때 SELECT박스 배열로 변환
    // AUTHOR : JOYPLUX (Mon Jan 25 04:55:06 GMT 2016)
    // PARAM :
    function makeSelectValArray ($arr) {
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                $rst[$v] = $v;
            }
        }

        return $rst;
    }

    // DESC : 도메인 루트 폴더 확인
    // AUTHOR : JOYPLUX (Mon Jan 25 04:55:00 GMT 2016)
    // PARAM :
    function docRootForder () {
        global $DEF_PAGE;
        $doc_arr = explode($GP -> PATH_BAR, $_SERVER['DOCUMENT_ROOT']);
        $rst = (end($doc_arr))? end($doc_arr) : prev($doc_arr);

        if ($DEF_PAGE) $rst .= '.def';
        return $rst;
    }

    // DESC : 문자열 보안체크
    // AUTHOR : JOYPLUX (Mon Jan 25 04:54:53 GMT 2016)
    // PARAM :
    function securityStr ($str = '') {
        $bf_str = $str;
        if (!is_array($str)) {
            $str = trim($str);
            //$str = urldecode($str);
            $str = str_replace("\"",'"',$str);
            $str = str_replace("\'","'",$str);
            //$str = str_replace(" ","",$str);
            $str = strip_tags($str);
            if (!$this -> includeHangul ($str))	$str = htmlentities($str);
            if (preg_match("/['\"]/",$str)) {
                $str = addslashes($str);
            }
            $af_str = $str;
        }
        return $str;
    }

    // DESC : 한글이 포함되어있는지 확인
    // AUTHOR : JOYPLUX (Mon Jan 25 04:54:47 GMT 2016)
    // PARAM :
    function includeHangul($str) {
        $cnt = strlen($str);
        for ($i=0; $i<$cnt; $i++) {
            $char = ord($str[$i]);
            if($char >= 0xa1 && $char <= 0xfe) {
                return true;
            }
        }
        return false;
    }

    // DESC : encode string
    // AUTHOR : JOYPLUX (Mon Jan 25 04:54:40 GMT 2016)
    // PARAM :
    function encryptByKey($string, $key) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }

        return base64_encode($result);
    }

    // DESC : decode string
    // AUTHOR : JOYPLUX (Mon Jan 25 04:54:33 GMT 2016)
    // PARAM :
    function decryptByKey($string, $key) {
        $result = '';
        $string = base64_decode($string);

        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }

        return $result;
    }

    function goUrl($url) {
        echo "<script>location.href='$url';</script>";
        exit;
    }

    // alert 메세지 출력
    function putMsg($msg) {
        echo "<script>alert('$msg');</script>";
        exit;
    }

    // alert 메세지 출력 후 상단 reload
    function putMsgAndTopReload($msg) {
        echo "<script>alert('$msg'); top.location.reload();</script>";
        exit;
    }

    // alert 메세지 출력 후 보냄
    function putMsgAndGo($msg,$url) {
        $url = ($url)? $url : '/';
        echo "<script>alert('$msg'); location.replace('$url');</script>";
        exit;
    }

    // alert 후 해당 url 로 보냄
    function putMsgAndTopGoUrl($msg , $url) {
        $url = ($url)? $url : '/';
        echo "<script>alert('$msg'); top.location.href='$url';</script>";
        exit;
    }

    // alert 메세지 출력 후 뒤로
    function putMsgAndBack($msg) {
        echo "<script>alert('$msg'); history.back();</script>";
        exit;
    }

    // alert 메세지 출력 후 뒤로
    function putMsgAndClose($msg) {
        echo "<script>alert('$msg'); self.close();</script>";
        exit;
    }

    // alert 메세지 출력 후 뒤로
    function WindowsClose() {
        echo "<meta http-equiv='Content-type' content='text/html; charset=utf-8'>";
        echo "<script type='text/javascript'>window.open('','_self').close();</script>";
        exit;
    }

    function putMsgAndModalClose($msg) {
        echo "<script>alert('$msg'); setTimeout('closeModal()',100);</script>";
        exit;
    }

    // DESC : EUC-KR -> UTF-8 변환
    // AUTHOR : JOYPLUX (Mon Jan 25 04:52:01 GMT 2016)
    // PARAM :
    function iconvUtf ($str) {
        return iconv('EUC-KR','UTF-8',$str);
    }

    // DESC : UTF-8 -> EUC-KR 변환
    // AUTHOR : JOYPLUX (Mon Jan 25 04:51:51 GMT 2016)
    // PARAM :
    function iconvEuc ($str) {
        return iconv('UTF-8','EUC-KR',$str);
    }

    // DESC : 숫자 변환
    // AUTHOR : JOYPLUX (Mon Jan 25 04:51:44 GMT 2016)
    // PARAM :
    function makeInt ($val) {
        return (int)str_replace(',','',$val);
    }

    // DESC : 엑셀 다운로드
    // AUTHOR : JOYPLUX (Mon Jan 25 04:51:29 GMT 2016)
    // PARAM :
    function getExcelData ($args = '') {
        global $GP;
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        if (!$loc || !$fname || empty($data) || empty($format)) return;

        include_once $GP -> CLS . "PHPExcel/PHPExcel.php";
        include_once $GP -> CLS . "PHPExcel/PHPExcel/IOFactory.php";
        include_once $GP -> CLS . "PHPExcel/PHPExcel/Writer/Excel2007.php";
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $keyArr = array_keys($format);
        $valueArr = array_values($format);
        $data_cnt 	= count($data);

        $i = 0;
        foreach ($keyArr as $v) {
            $objPHPExcel->getActiveSheet()->SetCellValue(chr(ord('A') + $i) . "1" , $v);
            $i++;
        }

        for ($i = 2 ; $i < $data_cnt + 2 ; $i++) {
            $j = 0;
            foreach ($valueArr as $v) {
                $objPHPExcel->getActiveSheet()->SetCellValue(chr(ord('A') + $j) . $i , $data[$i-2][$v]);
                $j++;
            }
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($loc . $fname);

        if ($type == "down") {
            include_once $GP -> CLS . 'class.filedown.php';
            $C_FileDownload = new FileDownload;
            $C_FileDownload -> fDown($loc . $fname, $fname);
            @unlink($loc . $fname);
        }
    }

    // DESC : 엑셀 데이터 읽기
    // AUTHOR : JOYPLUX (Mon Jan 25 04:50:11 GMT 2016)
    // PARAM :
    function readExcelData ($args = '') {
        global $GP;
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        include_once $GP -> CLS . 'PHPExcel/PHPExcel.php';
        include_once $GP -> CLS . 'PHPExcel/PHPExcel/IOFactory.php';

        if (is_file($file)) {
            $objReader = PHPExcel_IOFactory::createReaderForFile($file);
            $objReader->setReadDataOnly(true);
            $objExcel = $objReader->load($file);
            $objExcel->setActiveSheetIndex(0);
            $objWorksheet = $objExcel->getActiveSheet();

            $maxRow = $objWorksheet->getHighestRow();

            $keyArr = array_keys($format);

            for ($i = 2 ; $i <= $maxRow ; $i++) {
                $j = 0;
                foreach ($keyArr as $v) {
                    $cell_name = chr(ord('A') + $j);
                    $rst[$i - 2][$v] 			= trim($objWorksheet->getCell($cell_name . $i)->getValue());
                    $j++;
                }
            }
        }

        return $rst;
    }


    // DESC : xmls 파일 생성
    // AUTHOR : JOYPLUX (Mon Jan 25 04:38:41 GMT 2016)
    // PARAM : col_info, data, file
    function makeXlsx ($args = '') {
        if (is_array($args)) extract($args);
        global $GP;
        include_once $GP -> CLS . "PHPExcel/PHPExcel.php";
        include_once $GP -> CLS . "PHPExcel/PHPExcel/IOFactory.php";
        include_once $GP -> CLS . "PHPExcel/PHPExcel/Writer/Excel2007.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // Add some data
        $col_info_arr1 = array_keys($col_info);
        $col_info_arr2 = array_values($col_info);
        $i = 0;
        foreach ($col_info_arr1 as $v) {
            $objPHPExcel->getActiveSheet()->SetCellValue(chr(ord('A') + $i) . "1", $v);
            $i++;
        }

        $j = 2;
        foreach ($data as $v) {
            $i = 0;
            foreach ($col_info_arr2 as $v2) {
                $cell_name = chr(ord('A') + $i) . $j;
                $objPHPExcel->getActiveSheet()->SetCellValue($cell_name, $v[$v2]);
                $i++;
            }
            $j++;
        }

        // Save Excel 2007 file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($file);

        return true;
    }


    // desc	 :
    // auth  : JOYPLUX [Wed Jun 26 03:16:51 GMT 2013]
    // param : filename, startrow, sheet
    function xlsRead ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        global $GP;
        include_once $GP -> CLS . 'PHPExcel/PHPExcel.php';
        include_once $GP -> CLS . 'PHPExcel/PHPExcel/IOFactory.php';

        $sheet = (isset($sheet) && $sheet)? $sheet : 0;
        $startrow = (isset($startrow) && $startrow)? $startrow : 1;
        if (is_file($filename)) {
            try {
                // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
                $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
                // 읽기전용으로 설정
                $objReader->setReadDataOnly(true);
                // 엑셀파일을 읽는다
                $objExcel = $objReader->load($filename);
                // 첫번째 시트를 선택
                $objExcel->setActiveSheetIndex($sheet);

                $objWorksheet = $objExcel->getActiveSheet();
            } catch (exception $e) {
                die("파일 리드 실패!");
            }
        } else {
            die("파일이 존재하지 않습니다.");
        }

        $maxRow = $objWorksheet->getHighestRow();
        $maxCol = $objWorksheet->getHighestColumn();
        $maxCol = ord($maxCol) - 64;

        $k = 0;
        for ($i = $startrow ; $i <= $maxRow ; $i++) { // 두번째 행부터 읽는다
            if ($maxCol) {
                for ($j = 0 ; $j < $maxCol ; $j++) {
                    $data[$k][$j] = trim($objWorksheet->getCell(chr(65 + $j) . $i)->getValue());
                }
            }
            $k++;
        }

        return $data;
    }

    // DESC : array_merge 단점 보완 (2차 배열의 key값 유지)
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:55 GMT 2016)
    // PARAM :
    function arrayMerge ($arr1,$arr2) {
        $rst = array();
        if (is_array($arr1) && is_array($arr2)) {
            $arr3 = array_merge(array_keys($arr1) , array_keys($arr2));
            $arr4 = array_merge(array_values($arr1) , array_values($arr2));
            $rst = array_combine($arr3,$arr4);
        }
        return $rst;
    }

    // DESC : 현재시간
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:47 GMT 2016)
    // PARAM :
    function nowDate () {
        return date('Y-m-d H:i:s');
    }

    // DESC : 0 "0" 도 분별
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:39 GMT 2016)
    // PARAM :
    function is_blank($value) {
        return empty($value) && !is_numeric($value);
    }


    function utf8CutKr($str, $start, $len) {
        $str =  mb_substr($str, $start, $len, 'UTF-8');
        $cutstr = "..";
        return $str . $cutstr;
    }

    // DESC : 한글 문자열 자름
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:32 GMT 2016)
    // PARAM :
    function textCutKr ($str,$start,$len) { 		// 한글 문자 자르기
        $str = iconv('UTF-8', 'EUC-KR',$str);
        $str = trim($str);
        $backcnt= 0; // 시작첫글자에서 뒤로간 byte 수 (space나 영/숫자가 나올때 까지 또는 문장의 맨 처음시작까지)
        $cntcheck =0;

        if ($start>0 ) {
            if(ord($str[$start]) >= 128) { // 첫 시작글자가 한글이면
                for ($i=$start;$i>0;$i--) {
                    if (ord($str[$i]) >= 128) {
                        $backcnt++;
                    }else{
                        break;
                    }
                }

                if( (ord($str[0]) < 128) || ($backcnt != $start)) {    //첫글자가 한글이 아니거나, 영숫자 없고, 띄어 쓰기 없는 한글로만 되어 있는 경우가 아니면
                    $start= ($backcnt%2) ? $start : $start-1;    //첫글짜가 깨지면, 시작점 = (시작 byte -1byte)
                }

                if (($backcnt%2)==1) {
                    $cntcheck = 0;    //문장 시작 첫글자 안짤림
                }else{
                    $cntcheck = 1;        //문장 시작 첫글자 짤림
                }

            }
        }

        $backcnt2= 0; // 마지막글자에서 뒤로간 byte 수 (space나 영/숫자가 나올때 까지)

        for ($i=($len-1);$i>=0;$i--) {
            if (ord($str[$i+$start]) >= 128){
                $backcnt2++;
            }else{
                break;
            }
        }

        if (($backcnt2%2)==1) {
            $cntcheck2 = 1;    //문장 마지막 글자 짤림
        }else{
            $cntcheck2 = 0;        //문장 마지막 글자 안짤림
        }

        (int)$cnt=$len-abs($backcnt2%2);    //자를 문자열 길이 (byte)
        if(($cntcheck+$cntcheck2)==2) $cnt+=2;    //$cntcheck가 짤리고, $cntcheck2가 짤리는 경우

        $cutstr = substr($str,$start,$cnt);
        if(strlen($str) && strlen($str) > strlen($cutstr))
            $cutstr .= "..";

        $cutstr = iconv('EUC-KR','UTF-8',$cutstr);
        return $cutstr;
    }

    // DESC : 2차배열에서 키값에 맞는 정보 열 받아오기
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:23 GMT 2016)
    // PARAM :
    function find2thArrayInfo (&$arr, $key, $val) {
        if (is_array($arr)) {

            foreach ($arr as $k => $v) {
                if ($val == $v[$key]) {

                    $tmp_data = $v;
                    //print_r($tmp_data); echo '<br>';
                    break;
                }
            }
        }
        return $tmp_data;
    }

    // DESC : url 존재유무 확인
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:08 GMT 2016)
    // PARAM :
    function serviceChk ($url)
    {
        $options['http'] = array(
            'method' => "HEAD",
            'ignore_errors' => 1,
            'max_redirects' => 0
        );
        $body = file_get_contents($url, NULL, stream_context_create($options));
        sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
        return $code === 200;
    }

    // DESC : url 존재유무 확인
    // AUTHOR : JOYPLUX (Mon Jan 25 04:49:13 GMT 2016)
    // PARAM :
    function WebService($server_url)
    {
        if($server_url && strpos($server_url, "http://") === false && strpos($server_url, "https://") === false){
            $url = "http://" . trim(strtolower($server_url));
        }else{
            $url = trim(strtolower($server_url));
        }

        $curlsession = curl_init ();
        curl_setopt ($curlsession, CURLOPT_URL,             $url);
        curl_setopt ($curlsession, CURLOPT_HEADER,          1);
        curl_setopt ($curlsession, CURLOPT_NOBODY,          1);
        curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER,  1);
        curl_setopt ($curlsession, CURLOPT_TIMEOUT,         3);

        $buffer = curl_exec ($curlsession);
        $cinfo = curl_getinfo($curlsession);
        curl_close($curlsession);

        if ($cinfo['http_code'] != 200){
            $rst = 0;
        }else{
            $rst = 1;
        }

        return $rst;
    }

    // DESC : CURL send post
    // AUTHOR : JOYPLUX (Mon Jan 25 04:38:12 GMT 2016)
    // PARAM : url, data, timeout, info
    function sendPostData ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $timeout = (isset($timeout))? $timeout : 60;
        $data = (isset($data))? $data : "";
        $info = (isset($info))? $info : false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $rst = curl_exec($ch);

        if ($info) {
            var_dump($rst); //결과값 출력
            print_r(curl_getinfo($ch)); //모든정보 출력
            echo curl_errno($ch); //에러정보 출력
            echo curl_error($ch); //에러정보 출력
        }
        curl_close($ch);
        return $rst;
    }

    // DESC : CURL send post
    // AUTHOR : JOYPLUX (Mon Jan 25 04:38:12 GMT 2016)
    // PARAM : url, data, timeout, info
    function CallBackCheck ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $timeout = (isset($timeout))? $timeout : 60;
        $data = (isset($data))? $data : "";
        $info = (isset($info))? $info : false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $rst = '';
        $data = curl_exec($ch);
        $rs_ch = curl_getinfo($ch);

        curl_close($ch);

        $rst['http_code'] = $rs_ch['http_code'];
        return $rst;
    }

    function sendGetData ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $timeout = (isset($timeout))? $timeout : 60;
        $info = (isset($info))? $info : false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 0);
        $rst = curl_exec($ch);

        if ($info) {
            var_dump($rst); //결과값 출력
            print_r(curl_getinfo($ch)); //모든정보 출력
            echo curl_errno($ch); //에러정보 출력
            echo curl_error($ch); //에러정보 출력
        }
        curl_close($ch);

        return $rst;
    }

    function sendGetDataNPosting ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $timeout = (isset($timeout))? $timeout : 60;
        $info = (isset($info))? $info : false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_COOKIE, 1);
        curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750");
        curl_setopt($ch, CURLOPT_POST, 0);
        $rst = curl_exec($ch);

        if ($info) {
            var_dump($rst); //결과값 출력
            print_r(curl_getinfo($ch)); //모든정보 출력
            echo curl_errno($ch); //에러정보 출력
            echo curl_error($ch); //에러정보 출력
        }
        curl_close($ch);

        return $rst;
    }

    // DESC : 부스트랩용 버튼 생성
    // AUTHOR : JOYPLUX (Mon Jan 25 04:39:59 GMT 2016)
    // PARAM :  $name, $icon, $act, $etc, $size (l,m,s) , $color (blue, green, orange, red, sky)
    // USAGE : $C_Func -> bootBtn(array('name'=>'LOGIN', 'icon'=>'ok', 'act'=>'chkForm ()', 'etc'=>'style="margin-top:-5px; margin-left:10px"', 'size'=>'s'))

    function bootBtn ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        switch ($size) {
            case 'l': $size = 'btn-lg';	break;
            case 'm': $size = 'btn-sm';	break;
            case 's': $size = 'btn-xs';	break;
            default:$size = '';break;
        }

        switch ($color) {
            case 'blue' :
                $btn_color = 'btn-primary';
                break;
            case 'green' :
                $btn_color = 'btn-success';
                break;
            case 'orange' :
                $btn_color = 'btn-warning';
                break;
            case 'red' :
                $btn_color = 'btn-danger';
                break;
            case 'sky' :
                $btn_color = 'btn-info';
                break;
            default:
                $btn_color = 'btn-default';
                break;
        }
        $str = "<button type=\"button\" class=\"btn $btn_color $size\" $etc onclick=\"$act\"><span class=\"glyphicon glyphicon-$icon\"></span> $name</button>";

        return $str;
    }

    function encContents ($contents) {
        $result = htmlspecialchars(addslashes($contents));

        return $result;
    }

    function decContents ($contents) {
        $result = stripslashes($contents);

        return $result;
    }

    function decContentsView ($contents) {
        $result = htmlspecialchars_decode(nl2br(stripslashes($contents)));

        return $result;
    }

    function encContentsEdit ($contents) {
        $result = htmlspecialchars(addslashes($this -> noScriptTags($contents)));

        return $result;
    }

    function decContentsEdit ($contents) {
        $result = html_entity_decode(stripslashes($contents));

        return $result;
    }

    // DESC : 스크립트태그 제거
    // AUTHOR : JOYPLUX (Mon Jan 25 04:44:17 GMT 2016)
    // PARAM :
    function noImageTags ($str) {
        return preg_replace("/<img[^>]+\>/i", "", $str);

    }

    function editPtagRemove ($str) {
        return preg_replace("/<p[^>]+\>/i", "", $str);

    }

    // DESC : 스크립트태그 제거
    // AUTHOR : JOYPLUX (Mon Jan 25 04:44:17 GMT 2016)
    // PARAM :
    function noScriptTags ($str) {
        $pattern = array('/<!--(.*?)-->/s', '/<script[^>]*?>(.*?)<\/script>/is', '/<style[^>]*?>(.*?)<\/style>/is');
        return preg_replace($pattern, '', $str);
    }

    // DESC : 이메일 유효성 체크
    // AUTHOR : JOYPLUX (Mon Jan 25 04:44:50 GMT 2016)
    // PARAM :
    function checkEmail($email) {
        return preg_match('/^[A-z0-9][\w\d.-_]*@[A-z0-9][\w\d.-_]+\.[A-z]{2,6}$/',$email);
    }

    // DESC : 세션키 생성
    // AUTHOR : JOYPLUX (Mon Jan 25 04:45:04 GMT 2016)
    // PARAM :
    function sessKeySet () {
        return $this -> encryptByKey(md5(uniqid()) , $this -> GP['ENC_KEY']);
    }

    /*	// 로그인형식 리턴
        // Wed Aug 06 09:19:31 GMT 2014 / JOYPLUX
        // PARAM :
        function getLoginTemp ($args = '') {
            if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
            if ($u_id) {
                switch ($u_type) {
                    case 'ADV':
                        $idx = ($idx)? $idx : $uidx;
                        $rst = '<a href="#"><span class="glyphicon glyphicon-log-in padding-right-small adv_login" at_data="' . $u_id . '" at_type="' . $u_type . '"></span></a>(' . $idx . ') <a href="/manage/member_info.html?uidx=' . $uidx . '">' . $u_id . '</a>' .  (($u_name)? ' (' . $u_name . ')' : '');
                        break;
                    case 'AGC':
                        $idx = ($idx)? $idx : $agidx;
                        $rst = '<a href="#"><span class="glyphicon glyphicon-log-in padding-right-small adv_login" at_data="' . $u_id . '" at_type="' . $u_type . '"></span></a>(' . $idx . ') ' . $u_id .  (($u_name)? ' (' . $u_name . ')' : '');
                        break;
                    case 'MDA':
                        $idx = ($idx)? $idx : $midx;
                        $rst = '<a href="#"><span class="glyphicon glyphicon-log-in padding-right-small adv_login" at_data="' . $u_id . '" at_type="' . $u_type . '"></span></a>(' . $idx . ')' . $u_id .  (($u_name)? ' (' . $u_name . ')' : '');
                        break;
                }
            }
            return $rst;
        }*/


    // DESC : 난수 생성
    // AUTHOR : JOYPLUX (Wed Jan 27 10:11:27 GMT 2016)
    // PARAM :
    function genRandomString($length=16)
    {
        $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $final_rand='';
        for($i=0;$i<$length; $i++)
        {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];

        }
        return $final_rand;
    }

    function getNumRandomString($length=16) {

        $chars ="1234567890";
        $final_rand='';
        for($i=0;$i<$length; $i++)
        {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];

        }
        return $final_rand;
    }

    // DESC : CDN 이미지 업로드
    // AUTHOR : JOYPLUX (Mon Jan 25 04:47:52 GMT 2016)
    // PARAM : type, name
    function sendCdnImg ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        global $GP,  $_FILES;
        include_once $GP -> CLS . "class.ftp.php";

        $args = "";
        $args['loc'] = './' . $type;
        $args['FTP'] = $GP -> FTP_CDN;
        $C_Ftp = new Ftp ($args);

        switch ($type) {
            case 'ads':	// 광고 이미지 등록
                $args = "";
                $args['file'] = $_FILES[$name];
                //$args['max_file_size'] 	= 1024 * 40;	// 30kb
                $args['max_file_size'] 	= $max_file_size == "" ? 1024 * 40 : $max_file_size;
                $args['able_file'] 		= array('jpg','jpeg','png','gif');
                /* 이미지 사이즈 조정
                $args['thumbx'] = '30';
                $args['thumby'] = '30';
                */
                $rst = $C_Ftp -> upFileSend ($args);
                break;

            default:
                break;
        }

        return $rst;
    }

    // DESC : 로컬파일 업로드
    // AUTHOR : JOYPLUX (Wed Jan 27 01:56:06 GMT 2016)
    // PARAM : type, name
    function sendLocalFile ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        global $GP;

        $args = array();
        $args['forder'] = $GP -> ROOT . "/upload/$type/";

        switch ($type) {
            case 'biz_paper' : // 사업자등록증
                $args['name'] = $name;
                $args['max_file_size'] 	= $max_file_size == "" ? 1024 * 30 : $max_file_size;
                $args['able_file'] 		= array('jpg','gif','png');
                /* 이미지 사이즈 조정
                $args['thumbx'] = '30';
                $args['thumby'] = '30';
                */

                $rst = $this -> fileUp ($args);
                break;

            default:
                break;
        }

        return $rst;
    }

    // DESC : 싱글파일 업로드
    // AUTHOR : JOYPLUX (Mon Jan 25 04:50:03 GMT 2016)
    // PARAM : forder, name / option : able_file, thumb, thumb_w. thumb_h
    function fileUp ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $CI =& get_instance();

        $CI -> load -> library( 'Fileup' );

        global $GP, $HTTP_POST_FILES;

        if($_FILES[$name]['name'])
        {
            $args = array();
            $args['forder'] 		= $forder;
            $args['files'] 			= $_FILES[$name];
            $args['max_file_size'] 	= ($max_file_size) ? $max_file_size : 1024 * 1000;// 100kb

            $args['able_file'] 		= ($able_file) ? $able_file : '';
            $args['thumb'] 			= ($thumb) ? $thumb : '';
            $args['thumb_w'] 		= ($thumb_w) ? $thumb_w : '';
            $args['thumb_h'] 		= ($thumb_h) ? $thumb_h : '';

            if ($args['files']['error']) {
                $rst['rst'] = 'E10';
                $rst['err'] = '파일이 정상적이지 않습니다.';
            } else {
                $C_Fileup = new Fileup ($args);
                $updata = $CI -> Fileup -> fileUpload();
                if ($updata['error']) {
                    $rst['rst'] = 'E10';
                    $rst['err'] = $updata['error'];
                } else {
                    $rst['rst'] = 'S';
                    $rst['loc'] = $updata['new_file_name'];
                    $rst['type'] = $updata['file_type'];
                }
            }
        }

        return $rst;
    }

    // DESC : 확장자 얻기
    // AUTHOR : JOYPLUX (Mon Jan 25 12:13:19 GMT 2016)
    // PARAM :
    function getExtension () {
        $tmp = explode('.',$_SERVER['SCRIPT_NAME']);
        return end($tmp);
    }

    // DESC : CDN 이미지 삭제
    // AUTHOR : YUHWANNI (2016-01-29)
    // PARAM : type, name
    function deleteCdnImg ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        global $GP,  $_FILES;
        include_once $GP -> CLS . "class.ftp.php";

        $args = "";
        $args['loc'] = './' . $type;
        $args['FTP'] = $GP -> FTP_CDN;
        $C_Ftp = new Ftp ($args);

        switch ($type) {
            case 'ads':	// 광고 이미지 등록
                $args = "";

                $fname = str_replace($GP -> FTP_CDN['WWW'], "", $fname);
                $args['file'] = $fname;

                $rst = $C_Ftp -> delfile ($args);
                break;

            default:
                break;
        }

        return $rst;
    }

    // DESC : 특수문자 체크
    // AUTHOR : YUHWANNI (2016-01-29)
    // PARAM : str
    function specialStringCheck ($str) {
        $chk = false;
        //특수문자체크
        if(preg_match("/[!#$%^&*()?+=\/]/",$str)) $chk = true;
        return $chk;
    }

    // DESC : 로컬 미리보기
    // AUTHOR : JOYPLUX (Mon Feb 01 03:48:02 GMT 2016)
    // PARAM : type, img, img_type
    function localPreview ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        if ($this -> isAdvAbove()) {
            switch ($type) {
                case 'biz_paper':
                    $filename = $this -> GP['Eng'] . "inc/img/" . $type . "/" . $img;
                    break;

                case 'bank_paper':
                    $filename = $this -> GP['Eng'] . "inc/img/" . $type . "/" . $img;
                    break;

                default:
                    break;
            }

        } else {
            $filename = $this -> GP['Eng'] . "inc/img/common/access_denied.png";
            $img_type = "image/png";
        }

        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);

        header("content-type: " . $img_type);

        echo $contents;
    }

    // DESC : 날짜구간
    // AUTHOR : JOYPLUX (Fri Feb 05 03:21:01 GMT 2016)
    // PARAM : date, term
    function dateTerm ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $date = (isset($date))? $date : 'Y-m-d';
        return date($date, strtotime($term)); // 어제
    }

    // DESC : 시간 구간 표현
    // AUTHOR : JOYPLUX (Fri Feb 05 08:23:48 GMT 2016)
    // PARAM :
    function makeTimeTerm ($val) {
        $start = $val;
        $end = $val + 1;
        if (strlen($end) == 1) {
            $end = '0' . $end;
        }

        return $start . " ~ " . $end;
    }

    // DESC :
    // DATE : Wed Feb 17 11:47:33 GMT 2016
    // PARAM : $url, $data
    function addGetQuery ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $out = parse_url($url);
        $url = $out['scheme'] . "://" . $out['host'] . $out['path'];
        $q = (isset($out['query'])) ? $out['query'] : "";

        parse_str($q, $q_out);
        $q_out = array_merge($q_out, $data);
        return $url . "?" . http_build_query ($q_out);

    }

    // DESC : JSON BODY POST 용
    // AUTHOR : JOYPLUX (Tue Feb 23 09:21:42 GMT 2016)
    // PARAM :  url, data (json), type
    // 받을때는 $HTTP_RAW_POST_DATA 로 받아야 함
    function httpPost($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        global $GP;
        $data_url = '';
        $data_len = 0;

        $data_len = strlen ($data);
        return file_get_contents ($url, false, stream_context_create (array (
            'http'=>array (
                'method'=>$type
            ,
                'header'=>"Content-Type: application/json\r\n".
                    "Cache-Control: no-cache\r\n" .
                    "Content-Length: $data_len"
            ,
                'content'=>$data
            ))));

    }

    // DESC :
    // DATE : Tue Feb 23 10:58:47 GMT 2016
    // PARAM : log_type, data
    function errLogs ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $fp = @fopen('/logs/donkeycpi/' . date('Ymd') . '_' . $log_type, "a+");
        $log_arr = array();
        $log_arr['time'] = time();
        $log_arr['ip'] = $_SERVER['REMOTE_ADDR'];
        $msg = serialize(array_merge($log_arr, $data));
        @fwrite($fp, "#$msg\n");
        @fclose($fp);
    }

    function AESEncode($str, $key)
    {
        return base64_encode(openssl_encrypt($str, "aes-256-cbc", $key, true, str_repeat(chr(0), 16)));
    }

    function AESDecode($str, $key)
    {
        return openssl_decrypt(base64_decode($str), "aes-256-cbc", $key, true, str_repeat(chr(0), 16));
    }

    // DESC :
    // DATE : Mon Jul 11 03:55:39 GMT 2016
    // PARAM : $sender = array('email','name'),$reciever = array('email','name'), $subject, $contents
    function sendMail ($args = '') {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
        global $GP;
        include_once $GP -> CLS . '/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet    = "UTF-8";
        $mail->Encoding   = "base64";
        $mail->Host = $GP -> SMTP_SERVER;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $GP -> SMTP_USER;                 // SMTP username
        $mail->Password = $GP -> SMTP_PASS;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $GP -> SMTP_PORT;                                    // TCP port to connect to

        $mail->setFrom($GP -> SMTP_USER, 'CPI관리메일');

        $mail->AddReplyTo($sender[0], $sender[1]);

        if (!empty($reciever) && is_array($reciever)) {
            foreach ($reciever as $v) {

                $mail->addAddress($v[0], $v[1]);     // Add a recipient
            }
        }

        $mail->Subject = $subject;
        $mail->Body    = $contents;

        return ($mail->send()) ? true : false;

    }

    function cReturnRmove ($str) {
        return strtr($str,array("\r\n"=>'',"\r"=>'',"\n"=>''));
    }
#############################################################
#
#	SESSION 관련
#
#############################################################	

    function isAdm () {
        return isset($_SESSION['sess_adm']) ? true : false;
    }

    function isMem () {
        return isset($_SESSION['sess_mem']) ? true : false;
    }

    // DESC : 권한체크
    // AUTHOR :
    // PARAM :
    function AdmMenuAuthChk()
    {
        $user_link = array();
        $all_link = array();
        $this_url = str_replace("/index.php", "",$_SERVER['PHP_SELF']);
        $arr_tmp = explode(",", $_SESSION['sess_adm']['sess_menu']);

        foreach ($this->GP['MENU'] as $k => $v) {
            if (isset($v['sub'])) {
                foreach ($v['sub'] as $v2) {
                    if (in_array($v2['auth'], $arr_tmp)) {
                        $user_link[] = $v2['href'];
                    }
                    if (isset($v2['sub2'])) {
                        foreach ($v2['sub2'] as $v3) {
                            if (in_array($v3['auth'], $arr_tmp)) {
                                $user_link[] = $v3['href'];
                            }
                        }
                    }
                }
            }
        }

        foreach ($this->GP['MENU'] as $k => $v) {
            if (isset($v['sub'])) {
                foreach ($v['sub'] as $v2) {
                    $all_link[] = $v2['href'];
                    if (isset($v2['sub2'])) {
                        foreach ($v2['sub2'] as $v3) {
                            $all_link[] = $v3['href'];
                        }
                    }
                }
            }
        }

        $diff_arr = array_diff($all_link, $user_link);

        if (in_array($this_url, $diff_arr)) {
            $this->putMsgAndBack("접근권한이 없습니다");
            exit();
        }
    }

    // DESC : 세션용 난수 생성
    // AUTHOR : JOYPLUX (Thu Feb 04 04:48:36 GMT 2016)
    // PARAM :
    function makeSessKey () {
        return $this -> encryptByKey(md5(uniqid()) , $this -> GP['ENC_KEY']);
    }

    // DESC : 로그인 링크
    // AUTHOR : JOYPLUX (Thu Feb 04 05:41:56 GMT 2016)
    // PARAM : type, idx
    function getLoginLink ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $gubun = isset($gubun) ? $gubun : "";
        $rst = '<a href="#"><span class="icon-login login" data-idx="' . $idx . '" data-type="' . $type . '" data-gubun="' . $gubun . '"></span></a>';

        return $rst;
    }

    function logged_in()
    {
        return isset($_SESSION['sess_type']) ? true : false;
    }

    //사양변경 신청시 이용기간중 남은 일수 구하기
    //시작년월일, 마감년월일
    function request_day($start_date, $end_date)
    {
        $now_time = strtotime("$start_date");
        $end_time = strtotime("$end_date");
        $tot_day=floor(($end_time - $now_time)/86400);
        return $tot_day;
    }

    // 시작일부터 몇일후 구하기
    // ( 시작년월일 , 계약 일수 )
    function request_term_day($start_date, $add_day)
    {
        $date = date("Y-m-d", strtotime($start_date."+". $add_day." days"));
        return $date;
    }

    // 시작일부터 몇일후 구하기
    // ( 시작년월일 , 계약 일수 )
    function request_minus_day($start_date, $add_day)
    {
        $date = date("Y-m-d", strtotime($start_date."-". $add_day." days"));
        return $date;
    }

    // 시작일부터 몇일후 구하기
    // ( 시작년월일 , 계약 일수 )
    function request_term_minute($start_date, $add_min, $type)
    {
        if($type == "p") {
            $date = date("Y-m-d H:i:s", strtotime($start_date . "+" . $add_min . " minutes"));
        }else {
            $date = date("Y-m-d H:i:s", strtotime($start_date . "-" . $add_min . " minutes"));
        }
        return $date;
    }

    // 시작일부터 몇일후 구하기
    // ( 시작년월일 , 계약 일수 )
    function request_term_hour($start_date, $add_min, $type)
    {
        if($type == "p") {
            $date = date("Y-m-d H:i:s", strtotime($start_date . "+" . $add_min . " hours"));
        }else {
            $date = date("Y-m-d H:i:s", strtotime($start_date . "-" . $add_min . " hours"));
        }
        return $date;
    }

    //다음달 구하기
    function getNextMonth($year, $month)
    {
        return date("Y-m-d", @mktime(0, 0, 0, $month+1, 1, $year));
    }

    function getBeforeMonth($year, $month)
    {
        return date("Y-m-d", @mktime(0, 0, 0, $month-1, 1, $year));
    }

    function getLastDay($year, $month)
    {
        return date("Y-m-d", @mktime(0, 0, 0, $month+1, 1, $year) - 1 );
    }

    function arr_del($list_arr, $del_num) // 배열, 삭제할 값
    {
        $key = array_search($del_num, $list_arr); //배열에 키를 알아오고
        array_splice($list_arr, $key, 1); // 배열에서 위에서 받아온 키를 삭제
        return $list_arr;
    }


    /**
     * Upload한 이미지를 저장 하고 사이즈가 정사각형인 이미지로 썸네일 만든다.
     * @param String $upload_file
     * @param String $target_file
     * @param String $s
     */
    function img_upload_resize($upload_path, $upload_file, $thumb, $s = 90 ,$f = 90, $wmark, $allowed_types = "gif|jpg|png|jpeg|mp4|wmv|avi") {

        if(!is_dir($upload_path)){
            mkdir($upload_path, 0707);
        }

        // 이미지 업로드 설정
        $config = array(
            'upload_path' => $upload_path,
            'overwrite' => TRUE,
            //'allowed_types' => 'gif|jpg|png|jpeg|mp4|wmv|avi',
            //'allowed_types' => 'gif|jpg|png|jpeg|mp4|wmv|avi',
            'allowed_types' => $allowed_types, //메인영상만
            'encrypt_name' => TRUE,
            'remove_spaces' => TRUE,
        );

        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);

        $rst = array();
        if ($this->CI->upload->do_upload($upload_file)) {
            $data = array('upload_data' => $this->CI->upload->data());
            $target_file = $data['upload_data']['file_name'];
            $target_image_type = $data['upload_data']['image_type'];
            $ori_file = $data['upload_data']['orig_name'];

            $rst['target_file'] = $target_file;
            $rst['target_image_type'] = $target_image_type;

            if($wmark) {
                list($w, $h) = getimagesize($config['upload_path']  . $target_file);
                $master_dim = $w > $h ? 'height' : 'width';

                $config = array(
                    'image_library' => 'gd2',
                    'source_image' => $upload_path . $target_file,
                    'new_image' => $upload_path . 'wmark_' . $target_file,
                    'wm_overlay_path' => $this->GP['WATER_IMG'],
                    'wm_type' => 'overlay',
                    'wm_opacity' => '10',
                    'wm_vrt_alignment' => 'middle',
                    'wm_hor_alignment' => 'center',
                    'master_dim' => $master_dim
                );

                $this->CI->load->library('image_lib');
                $this->CI->image_lib->initialize($config);
                $this->CI->image_lib->resize();
                $this->CI->image_lib->watermark();
                $this->CI->image_lib->clear();

                $rst['file_water_name'] = "wmark_" . $target_file;
            }

            if($thumb) {
                list($w, $h) = getimagesize($config['upload_path'] . $target_file);
                $master_dim = $w > $h ? 'height' : 'width';

                $config = array(
                    'image_library' => 'gd2',
                    'source_image' => $config['upload_path'] . $target_file,
                    'new_image' => $config['upload_path'] . 'thumb_' . $target_file,
                    'master_dim' => $master_dim,
                    'create_thumb' => false,
                    'width' => $s,
                    'height' => $f
                );

                $this->CI->load->library('image_lib');
                $this->CI->image_lib->initialize($config);
                $this->CI->image_lib->resize();
                $this->CI->image_lib->clear();

                $rst['file_thum_name'] = "thumb_" . $target_file;
            }

            return $rst;
        }else{
            $rst['rst'] = 'E10';
            $rst['err'] = $this->CI->upload->display_errors();
            die(json_encode($rst));
        }
    }

    /**
     * Upload한 이미지를 저장 하고 사이즈가 정사각형인 이미지로 썸네일 만든다.
     * @param String $upload_file
     * @param String $target_file
     * @param String $s
     */
    function prd_img_upload_resize($upload_path, $upload_file, $thumb, $s = 90 ,$f = 90, $wmark, $rename_word, $resize) {

        if(!is_dir($upload_path)){
            mkdir($upload_path, 0707);
        }

        // 이미지 업로드 설정
        $config = array(
            'upload_path' => $upload_path,
            'overwrite' => TRUE,
            //'allowed_types' => 'gif|jpg|png|jpeg|mp4|wmv|avi',
            'allowed_types' => 'gif|jpg|png|jpeg',
            'encrypt_name' => TRUE,
            'remove_spaces' => TRUE,
        );

        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);

        $rst = array();
        if ($this->CI->upload->do_upload($upload_file)) {
            $data = array('upload_data' => $this->CI->upload->data());
            $target_file = $data['upload_data']['file_name'];
            $target_image_type = $data['upload_data']['image_type'];
            $ori_file = $data['upload_data']['orig_name'];

            $rst['target_file'] = $target_file;
            $rst['target_image_type'] = $target_image_type;

            //원본 삭제를 위해
            $source_file_nm = $upload_path . $target_file;
            
            $new_target_file = $target_file;
            if (isset($rename_word) && $rename_word == "L") {
                $new_target_file = $this->CI->func->img_file_nm($target_file, "L");
                $rst['target_file'] = $new_target_file;
            } else if (isset($rename_word) && $rename_word == "M") {
                $new_target_file = $this->CI->func->img_file_nm($target_file, "M");
                $rst['target_file'] = $new_target_file;
            } else if (isset($rename_word) && $rename_word == "S") {
                $new_target_file = $this->CI->func->img_file_nm($target_file, "S");
                $rst['target_file'] = $new_target_file;
            } else if (isset($rename_word) && $rename_word == "V") {
                $new_target_file = $this->CI->func->img_file_nm($target_file, "V");
                $rst['target_file'] = $new_target_file;
            }

            //원본이미지를 워터마크를 생성한다음... 썸네일을 생성하면 된다.. 여기 할차례
            $config = array(
                'image_library' => 'gd2',
                'source_image' => $upload_path . $target_file,
                'new_image' => $upload_path . $new_target_file,
                //워터마크
                'wm_overlay_path' => $this->GP['WATER_IMG'],
                'wm_type' => 'overlay',
                'wm_opacity' => '10',
                'wm_vrt_alignment' => 'middle',
                'wm_hor_alignment' => 'ceneter',
                //워터마크
                'create_thumb' => false,
            );

            $this->CI->load->library('image_lib');
            $this->CI->image_lib->initialize($config);
            $this->CI->image_lib->watermark();
            $this->CI->image_lib->clear();

            //워터마크가 생성된이후에 리사이즈를 해야한다..
            //원본이미지를 워터마크를 생성한다음... 썸네일을 생성하면 된다.. 여기 할차례
            if($resize) {
                $config = array(
                    'image_library' => 'gd2',
                    'source_image' => $config['new_image'],
                    'new_image' => $config['new_image'],
                    'create_thumb' => false,
                    //리사이즈
                    'maintain_ratio' => TRUE,
                    'master_dim' => TRUE,
                    'width' => $this->GP['SHOP_IMG_RESIZE'],
                    'height' => $this->GP['SHOP_IMG_RESIZE']
                );
                $this->CI->image_lib->initialize($config);
                $this->CI->image_lib->resize();
                $this->CI->image_lib->clear();
            }

            $middle_size = false;
            $small_size = false;
            if($thumb) {
                list($w, $h) = getimagesize($upload_path . $target_file);
                $master_dim = $w > $h ? 'height' : 'width';

                $thumb_img_l = $this->CI->func->img_file_nm($target_file, "L");
                $thumb_img_m = $this->CI->func->img_file_nm($target_file, "M");
                $thumb_img_s = $this->CI->func->img_file_nm($target_file, "S");

                $config = array(
                    'image_library' => 'gd2',
                    'source_image' => $upload_path . $target_file,
                    'new_image' => $upload_path . $thumb_img_l,
                    'master_dim' => $master_dim,
                    'create_thumb' => false,
                    'width' => $s,
                    'height' => $f
                );

                $this->CI->load->library('image_lib');
                $this->CI->image_lib->initialize($config);
                $this->CI->image_lib->resize();
                $this->CI->image_lib->clear();

                $rst['file_l_name'] = $thumb_img_l;
                $middle_size = true;

                if($middle_size) {
                    $config = array(
                        'image_library' => 'gd2',
                        'source_image' => $upload_path . $target_file,
                        'new_image' => $upload_path . $thumb_img_m,
                        'master_dim' => $master_dim,
                        'create_thumb' => false,
                        'width' => $this->GP['SHOP_IMG_SIZE']['M']['w'],
                        'height' => $this->GP['SHOP_IMG_SIZE']['M']['h'],
                    );

                    $this->CI->image_lib->initialize($config);
                    $this->CI->image_lib->resize();
                    $this->CI->image_lib->clear();

                    $rst['file_m_name'] = $thumb_img_m;
                    $small_size = true;
                }

                if($small_size) {
                    $config = array(
                        'image_library' => 'gd2',
                        'source_image' => $upload_path . $target_file,
                        'new_image' => $upload_path . $thumb_img_s,
                        'master_dim' => $master_dim,
                        'create_thumb' => false,
                        'width' => $this->GP['SHOP_IMG_SIZE']['S']['w'],
                        'height' => $this->GP['SHOP_IMG_SIZE']['S']['h']
                    );

                    $this->CI->image_lib->initialize($config);
                    $this->CI->image_lib->resize();
                    $this->CI->image_lib->clear();

                    $rst['file_s_name'] = $thumb_img_s;
                }

                @unlink($source_file_nm);
            } else {
                @unlink($source_file_nm);
            }

            return $rst;
        }else{
            $rst['rst'] = 'E10';
            $rst['err'] = $this->CI->upload->display_errors();
            die(json_encode($rst));
        }
    }


    function ads_img_show($img) {
        $ads_icon_img = "";
        if($img != '' && strpos($img, 'http') !== false) {
            $ads_icon_img = $img;
        }else{
            $ads_icon_img = $this->GP['ADS_IMG_URL'] . "thumb_" . $img;
        }
        return $ads_icon_img;
    }


    /**
     * 참여를 위한 key를 생성한다. (키워드용)
     *
     * @param string $ads_idx 광고 인덱스
     * @param string $mda_idx 매체 인덱스
     * @return string NCPI key
     */
    function make_ncpi_link_key($ads_idx, $mda_idx, $ptn_idx) {
        $key = $ads_idx . "_" . $mda_idx . "_" . $ptn_idx;
        $link_key = rawurlencode($this -> encryptByKey ($key, $this->GP['ENC_KEY']));
        return $link_key;
    }

    /**
     * NCPI 참여를 위한 url을 생성한다.
     *
     * @param string $ads_idx 광고 인덱스
     * @param string $mda_idx 매체 인덱스
     * @return string NCPI 참여 url
     */
    function make_ncpi_link_url($ads_idx, $mda_idx, $ptn_idx) {
        $link_key = $this->make_ncpi_link_key($ads_idx, $mda_idx, $ptn_idx);
        $ads_join_url = "http://" . $this->GP['DOMAIN_API'] ."/napi/ncpi_click?key=" . $link_key;
        return $ads_join_url;
    }


    /**
     * NCPI 참여를 위한 url을 생성한다.
     *
     * @param string $ads_idx 광고 인덱스
     * @param string $mda_idx 매체 인덱스
     * @return string NCPI 참여 url
     */
    function make_ncpi_click_link_url($ads_idx, $mda_idx, $ptn_idx) {
        $link_key = $this->make_ncpi_link_key($ads_idx, $mda_idx, $ptn_idx);
        $ads_join_url = "http://" . $this->GP['CLICK_API'] ."/napi/ncpi_click?key=" . $link_key;
        return $ads_join_url;
    }

    /**
     * http GET 요청을 보낸다.
     * @param $args [url]
     * @return array 배열에 [http_code, total_time, connect_time, starttransfer_time, result]를 담아서 반환한다.
     */
    function send_http_get($args) {
        $url = $args['url'];
        $timeout = element('timeout', $args, 5);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);

        $curl_exec_result = curl_exec($ch);
        $curl_info = curl_getinfo($ch);

        $curl_e_num = "";
        $curl_e_str = "";
        if($curl_exec_result === false) {
            $curl_e_num = curl_errno($ch);
            $curl_e_str = curl_error($ch);
        }

        curl_close($ch);

        return $this->make_curl_result($curl_exec_result, $curl_info, $curl_e_num, $curl_e_str);
    }

    /**
     * curl_exec_result와 curl_info를 가지고 최종 결과 배열을 생성한다.
     *
     * @param $curl_exec_result curl_exec()의 반환 값
     * @param $curl_info curl_getinfo()의 반환 값
     * @param $curl_errno 에러 번호
     * @param $curl_error 에러 문자열
     * @return array [http_code, total_time, connect_time, starttransfer_time, result]
     */
    function make_curl_result($curl_exec_result, $curl_info, $curl_errno, $curl_error) {
        $result = array();
        $result['http_code'] = $curl_info['http_code'];
        $result['total_time'] = $curl_info['total_time'];
        $result['result'] = $curl_exec_result;

        if( ! empty($curl_errno)) {
            $result['curl_e_num'] = $curl_errno;
        }

        if( ! empty($curl_error)) {
            $result['curl_e_str'] = $curl_error;
        }

        return $result;
    }

    /**
     * 콤마로 연결된 계정 주소 문자열을 배열로 변경해서 (SHA1이 적용돼있지 않다면 SHA1 적용해서) 반환한다.
     *
     * @param string $account_with_comma
     * @return array
     */
    function make_sha1_account_arr($account_with_comma) {
        if(empty($account_with_comma))
            return array();

        $account_arr = explode(',', $account_with_comma);
        $length = count($account_arr);
        for($i = 0; $i < $length; $i++) {
            $account = $account_arr[$i];

            //'@'를 찾았다는 것은 SHA1 형태가 아니라는 뜻이므로 SHA1 해싱한다.
            if(strpos($account, '@') !== FALSE) {
                $account_arr[$i] = sha1($account);
            }
        }

        return $account_arr;
    }

    function make_status_message($status, $message) {
        return array('status' => $status, 'message' => $message);
    }


    function room_name($cs_type, $cs_year, $cs_grade, $cs_name) {
        return "[" . $this->GP['ROOM_TYPE'][$cs_type] . "]" . " " . $cs_year . "년 " . $cs_grade . "학년 " . $cs_name . "반";
    }

    function password_check($str) {
        if (!preg_match('/^[0-9A-Za-z~!@#$%^&*]{4,20}$/', $str) ||
            !preg_match('/\d/', $str) || !preg_match('/[a-zA-Z]/', $str)) {
            return false;
        } else {
            return true;
        }
    }

    function getMaxCategoryStr($max_num, $depth, $code) {

        $max_code = $max_num + 1;

        if($depth == 1) {
            $max_code = sprintf('%03d', $max_code) . "000000000";
        }

        if($depth == 2) {
            $code = substr($code, 0,3);
            $max_code = $code . sprintf('%03d', $max_code) . "000000";
        }

        if($depth == 3) {
            $code = substr($code, 0,6);
            $max_code = $code . sprintf('%03d', $max_code) . "000";
        }
        return $max_code;
    }

    //첫번째 이미지 가져오기
    function getProductFirst($photo) {
        $photo_arg = explode(",", $photo);
        foreach ($photo_arg as $v) {
            if (preg_match('/M./', $v)) {
                return $v;
                break;
            }
        }
    }

    //이미지 구분별 가져오기 L,M,S
    function getProductChoice($photo, $types) {
        $photo_arg = explode(",", $photo);
        foreach ($photo_arg as $v) {
            if (preg_match('/'.$types.'./', $v)) {
                return $v;
                break;
            }
        }
    }

    //이미지 순서 재배열 L,M,S
    function getProductOrder($photo_arg) {
        $new_arr = [];
        foreach ($photo_arg as $v) {
            if (preg_match('/L/', $v)) {
                array_push($new_arr, $v);
                break;
            }
        }
        foreach ($photo_arg as $v) {
            if (preg_match('/M/', $v)) {
                array_push($new_arr, $v);
                break;
            }
        }
        foreach ($photo_arg as $v) {
            if (preg_match('/S/', $v)) {
                array_push($new_arr, $v);
                break;
            }
        }
        return $new_arr;
    }

    //배열에서 이미지 찾아 제거
    //이미지 String (콤마로 구분된..), 삭제이미지명
    function getImagrArrDelete($photo_args, $del_photo) {
        $photo_arr = explode("," , $photo_args);
        foreach ($photo_arr as $key => $val) {
            if($val == $del_photo) {
                unset($photo_arr[$key]); break;
            }
        }
        return $photo_arr;
    }

    //이미지 파일명에 첨자 추가
    function img_file_nm($filename, $type) {
        /*
        [dirname] => .
        [basename] => 8e753083aa253fce49fbf102b7ebbdce.PNG
        [extension] => PNG
        [filename] => 8e753083aa253fce49fbf102b7ebbdce
        */
        $fileinfo = pathinfo($filename);
        if($type == "L") {
            $ext = $fileinfo['filename']. "_L" . "." . $fileinfo['extension'];
        } else if($type == "M") {
            $ext = $fileinfo['filename']. "_M" . "." . $fileinfo['extension'];
        } else if($type == "S") {
            $ext = $fileinfo['filename']. "_S" . "." . $fileinfo['extension'];
        } else if($type == "V") {
            $ext = $fileinfo['filename']. "_V" . "." . $fileinfo['extension'];
        }

        return $ext;
    }

    //이미지 불러오기
    function getImageCall($list_img, $new_chk, $category, $size, $width="") {

        if($size) {
            $size = "max-width:".$size."px";
        } else {
            $size = "";
        }
        if($width) {
            $width = ";width:".$width."px";
        }
        if($new_chk == "N") {
            if($list_img !="") {
                $list_img = $this->GP['SHOP_IMG_URL']."".$category."/".$list_img;
                if(is_file($list_img)) {
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode(file_get_contents($list_img))."' alt='' style='".$size.$width."'>";
                } else {
                    $list_img = "::NO IMAGE::";
                }
            } else {
                $list_img = "::NO IMAGE::";
            }
        } else {
            if($list_img !="") {
                //$list_img = $this->GP['SHOP_IMG_URL_OLD'].$list_img;
                $list_img = $this->old_water_view($list_img, $this->GP['SHOP_IMG_URL_OLD']);
                if($list_img != '') {
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode($list_img)."' style='".$size."'>";
                } else {
                    $list_img = "::NO IMAGE::";
                }
            } else {
                $list_img = "::NO IMAGE::";
            }
        }
        return $list_img;
    }

    //이미지 불러오기
    function getWebImageCall($list_img, $new_chk, $category, $size, $types, $title = "") {
        $noimage_class = "noimage";
        $add_zoom_img = "";
        if($types == "list") {
            $size = "height:280px; overflow: hidden;";
        } else if($types == "right_cart") {
            $size = "width:90px; height:90px; overflow: hidden;";
            $noimage_class = "noimage-sm";
        } else if($types == "view_mini_img") {
            $noimage_class = "noimage-xs";
        } else if($types == "cart") {
            $size = "width:90px; height:90px; overflow: hidden;";
            $noimage_class = "noimage-xs";
        } else if($types == "view") {
            $add_zoom_img = true;
            $size = "width:100%; min-height:580px; max-height:587px; overflow: hidden;";
            $noimage_class = "noimage-lg";
        } else if($types == "content_view") {
            $size = "max-width:100%;";
            $noimage_class = "noimage-lg";
        } else if($types == "main_list") {
            $size = "height:220px; overflow: hidden;";
            $noimage_class = "main-list-noimage";
        } else if($types == "quick_view") {
            $add_zoom_img = true;
            $size = "width:100%; min-height:580px; max-height:590px; overflow: hidden;";
            $noimage_class = "noimage-lg";
        }

        $add_zoom_img_url = "";

        if($new_chk == "N") {
            if($list_img !="") {
                $list_img = $this->GP['SHOP_IMG_URL']."".$category."/".$list_img;
                if(is_file($list_img)) {
                    if($add_zoom_img) {
                        $add_zoom_img_url = "data-zoom-image='data:image/jpg;base64,".base64_encode(file_get_contents($list_img))."'";
                    }
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode(file_get_contents($list_img))."' alt='$title' style='".$size."' ".$add_zoom_img_url.">";
                } else {
                    $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
                }
            } else {
                $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
            }
        } else {
            if($list_img !="") {
                //$list_img = $this->GP['SHOP_IMG_URL_OLD'].$list_img;
                $list_img = $this->old_water_view($list_img, $this->GP['SHOP_IMG_URL_OLD']);
                if($list_img != '') {
                    if($add_zoom_img) {
                        $add_zoom_img_url = "data-zoom-image='data:image/jpg;base64,".base64_encode($list_img)."'";
                    }
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode($list_img)."' alt='$title' style='".$size."' ".$add_zoom_img_url.">";
                } else {
                    $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
                }
            } else {
                $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
            }
        }
        return $list_img;
    }

    //이미지 불러오기
    function getAuctionWebImageCall($list_img, $new_chk, $category, $size, $types, $title = "") {
        $noimage_class = "noimage";
        $add_zoom_img = "";
        if($types == "list") {
            $size = "height:280px; overflow: hidden;";
        } else if($types == "list2") {
            $size = "height:300px; overflow: hidden;";
            $noimage_class = "noimage2";
        } else if($types == "right_cart") {
            $size = "width:90px; height:90px; overflow: hidden;";
            $noimage_class = "noimage-sm";
        } else if($types == "view_mini_img") {
            $noimage_class = "noimage-xs";
        } else if($types == "cart") {
            $size = "width:90px; height:90px; overflow: hidden;";
            $noimage_class = "noimage-xs";
        } else if($types == "view") {
            $add_zoom_img = true;
            $size = "width:100%; min-height:580px; max-height:587px; overflow: hidden;";
            $noimage_class = "noimage-lg";
        } else if($types == "content_view") {
            $size = "max-width:100%;";
            $noimage_class = "noimage-lg";
        } else if($types == "main_list") {
            $size = "height:220px; overflow: hidden;";
            $noimage_class = "main-list-noimage";
        }

        $add_zoom_img_url = "";

        if($new_chk == "N") {
            if($list_img !="") {
                $list_img = $this->GP['AUC_IMG_URL']."".$category."/".$list_img;
                if(@is_file($list_img)) {
                    if($add_zoom_img) {
                        $add_zoom_img_url = "data-zoom-image='data:image/jpg;base64,".base64_encode(file_get_contents($list_img))."'";
                    }
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode(file_get_contents($list_img))."' alt='$title' style='".$size."' ".$add_zoom_img_url.">";
                } else {
                    $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
                }
            } else {
                $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
            }
        } else {
            if($list_img !="") {
                $list_img = $this->old_water_view($list_img, $this->GP['AUC_IMG_URL_OLD']);

                if($list_img != '') {
                    if($add_zoom_img) {
                        $add_zoom_img_url = "data-zoom-image='data:image/jpg;base64,".base64_encode($list_img)."'";
                    }
                    $list_img = "<img src='data:image/jpg;base64,".base64_encode($list_img)."' alt='$title' style='".$size."' ".$add_zoom_img_url.">";
                } else {
                    $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
                }
            } else {
                $list_img = "<div class='$noimage_class'>::NO IMAGE::</div>";
            }
        }
        return $list_img;
    }

    function old_water_view($img, $img_dirs) {

        ob_start();
        $fld_link = $img_dirs;

        $fileInfo = @getimagesize($fld_link.$img);

        $o_width = $fileInfo[0];
        $o_height = $fileInfo[1];

        $new_width = $o_width;
        $new_height = $o_height;

        $file = $fld_link.$img;

        if($fileInfo[2] == 1) $newimg = ImageCreateFromGif($file);
        else if($fileInfo[2] == 2) $newimg = ImageCreateFromJPEG($file);
        else if($fileInfo[2] == 3) $newimg = ImageCreateFromPNG($file);

        $waterimg = ImageCreateFromPNG($this->GP['WATER_IMG']);

        if(isset($type) && $type == "small"){
            ImageCopyResized($newimg, $waterimg, 0, 0, 0, 0, $new_width, $new_height, 600, 450);
        } else {
            $copycnt = @ceil($fileInfo[1] / 1350);
            for ($i = 0; $i < $copycnt; $i++) {
                $yst = 1350 * $i;
                imagecopy($newimg, $waterimg, 0, $yst, 0, 0, 600, 1350);
            }
        }

        switch($fileInfo[2]){
            case"1": // gif
                //header("content-type : image/gif");
                imagegif($newimg);
                break;

            case"2": // jpg
                //header("content-type : image/jpeg");
                imagejpeg($newimg);
                break;

            case"3": // png
                //header("content-type : image/png");
                imagepng($newimg);
                break;
        }
        @ImageDestroy ($newimg);

        $img    =   ob_get_contents();
        ob_end_clean();
        return $img;
    }

    //1차카테고리 찾기
    function category1($cate) {
        $cate = substr($cate, 0,3);
        return $cate."000000000";
    }

    //이미지다운로드
    public function getImageDown($args) {

        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $fn_name_arr = explode("/", $file_nm);
        $saveName = end($fn_name_arr);

        if(isset($type) && $type == "auction") {
            if($new_chk == "N") {
                $list_img = $this->GP['AUC_IMG_URL'] . "" . $category . "/" . $file_nm;
            }else {
                $list_img = $this->GP['AUC_IMG_URL_OLD'] . "" . $category . "/" . $file_nm;
            }
        }else {
            if($new_chk == "N") {
                $list_img = $this->GP['SHOP_IMG_URL'] . "" . $category . "/" . $file_nm;
            }else {
                $list_img = $this->GP['SHOP_IMG_URL_OLD'] . "" . $category . "/" . $file_nm;
            }
        }

        $rst_file = "";
        if(is_file($list_img)) {
            $rst_file = $list_img;
        } else {
            $rst_file = "";
        }

        header("Content-type: image/jpeg");
        header("Content-Disposition: attachment; filename=$saveName");
        header("Pragma: no-cache");
        header("Expires: 0");

        @ini_set("allow_url_fopen", "ON");
        print(file_get_contents($rst_file));
        return;
    }

    function get_image($image){
        $exp = explode(",", $image);
        foreach ($exp as $k => $v) {
            if($v != '') {
                $get_image[$k] = $v;
            }
        }
        return $get_image;
    }

    function getImageShow($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $img_data = "";

        if($type == "auction") {
            if($new_chk == "N") {
                $fld_link = $this->GP['AUC_IMG_URL']. $category ."/";
            } else {
                $fld_link = $this->GP['AUC_IMG_URL_OLD'];
            }
        }

        $img_arr = explode(".", $img);

        $img_url = $fld_link . $img;

        if(is_file($img_url)) {
            if($img_arr[1] == "jpg") {
                $img_data = "data:image/jpg;base64,".base64_encode(file_get_contents($img_url));
            }

            if($img_arr[1] == "png") {
                $img_data = "data:image/png;base64,".base64_encode(file_get_contents($img_url));
            }
        } else {
            $img_data = "::NO IMAGE::";
        }

        return $img_data;
    }

    //이미지다운로드
    public function getMainImageDown($args) {

        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $fn_name_arr = explode("/", $file_nm);
        $saveName = end($fn_name_arr);

        $list_img = $this->GP['MAIN_IMG_URL'] . $file_nm;


        $rst_file = "";
        if(is_file($list_img)) {
            $rst_file = $list_img;
        } else {
            $rst_file = "";
        }

        //header("Content-type: image/jpeg");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$saveName");
        header("Pragma: no-cache");
        header("Expires: 0");

        @ini_set("allow_url_fopen", "ON");
        print(file_get_contents($rst_file));
        return;
    }

    function getImageMainShow($args = []) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $img_data = "";
        $fld_link = isset($fld) ? $fld : $this->GP['MAIN_IMG_URL'];

        $img_arr = explode(".", $img);
        $img_url = $fld_link . $img;

        if(is_file($img_url)) {
            if($img_arr[1] == "jpg") {
                $img_data = "data:image/jpg;base64,".base64_encode(file_get_contents($img_url));
            }

            if($img_arr[1] == "png") {
                $img_data = "data:image/png;base64,".base64_encode(file_get_contents($img_url));
            }
        } else {
            $img_data = "::NO IMAGE::";
        }

        return $img_data;
    }

    function select_num($name, $start, $end, $selected, $etc = "", $style = ""){
        echo "<select name='$name' id='$name' class='form-control' $style>\n";
        for($i = $start ; $i <= $end ; $i ++){
            if((int)$selected == $i) echo "<option value='$i' selected>$i</option>\n";
            else echo "<option value='$i'>$i</option>\n";
        }
        echo "</select> \n".$etc;
    }

    function brandcode_encode($brandcode){
        $new_code = "";
        for($i = "A", $j = 0 ; $i < "ZZZ" ; $i++, $j++){
            $array[sprintf("%03d", $j)] = $i;
            if($j == 999) break;
        }
        for($i = 0 ; $i <= CATE_NUM ; $i++) $code[] = substr($brandcode,($i*CATE_NUM), 3);
        foreach($code as $k => $v) $new_code .= $array[$v];
        return $new_code.intval(substr($brandcode,-7));
    }

    //폴더 문자열찾기
    function menuStringSearch($str, $val) {
        $rst = "";
        if (preg_match('/'.$val.'/', $str, $matches)) {
            //print_r($matches);
            //return $matches[0];
        }
        $rst = isset($matches[0]) ? $matches[0] : "";
        if($val == $rst) {
            return true;
        } else {
            return false;
        }
    }

    function count_clock($sec){
        $d_sec  = $sec%60;
        $d_min  = (($sec-$d_sec)/60)%60;
        $d_time = (((($sec-$d_sec)/60)-$d_min)/60) %24;
        $d_day  = ((((($sec-$d_sec)/60)-$d_min)/60)-$d_time)/24;
        $msg = "";
        if($d_day > 0)  $msg .= $d_day."일 ";
        if($d_time > 0) $msg .= $d_time."시간 ";
        if($d_min > 0)  $msg .= $d_min."분 ";
        if($d_sec > 0 && $d_min < 0)  $msg .= $d_sec."초 ";
        return $msg;
    }

    function ip_mask($ip) {
        if($ip == "::1") {
            $ip = "127.0.0.1";
        }
        $tmp_arr = explode('.' , $ip);
        return $tmp_arr[0] ."." .$tmp_arr[1] .".♥.". $tmp_arr[3];
    }

    //전화번호 유효성검사
    function valid_phone_number_or_empty($value)
    {
        $value = trim($value);
        if ($value == '') {
            return TRUE;
        } else {
            if (preg_match('/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/', $value)) {
                return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
            } else {
                return FALSE;
            }
        }
    }

    //주문번호생성
    function setOrderNum() {
        $today = date("Ymd");
        $rand = sprintf("%05d", rand(0,99999));
        $unique = $today . $rand;

        return $unique;
    }

    function get_client_ip() {
        $ipaddress = "";
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    function sms_send($args) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $apiKey = $this->GP['gabia_sms_apikey'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sms.gabia.com/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Basic $apiKey"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        /*
        $decode = json_decode( $response );
        print_r($decode);
        $encode = json_encode( $decode, JSON_UNESCAPED_UNICODE );
        print_r($encode);
        */

        $callback = $this->GP['callback_number'];
        $refkey = "KUM".uniqid();
        $sms_type = "lms";
        //$sms_type = "sms";

        if (!$err) {

            $access_token = "";
            if(isset($response)) {
                $decode_response = json_decode( $response );
                $access_token = $decode_response->access_token;
            }

            if($access_token) {
                $curl = curl_init();

                $access_token = base64_encode($this->GP['gabia_sms_id'] . ":" .$access_token);

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://sms.gabia.com/api/send/".$sms_type,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "phone=$phone&callback=$callback&message=$message&refkey=[[$refkey]]&subject=$subject",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "Authorization: Basic $access_token"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                $this->CI->load->model(array('common/sms_m'));

                $msg = json_decode( $response );
                if (!$err) {
                    //메세지 성공시 DB저장??
                    //print_r($response);
                } else {
                    //메세지 실패시 DB저장??
                }

                $args = [];
                $args['sms_type'] = "L";
                $args['sms_gunun'] = "M";
                $args['sms_title'] = $subject;
                $args['sms_content'] = $message;
                $args['sms_status'] = $msg->message;
                $args['crt_date'] = date("Y-m-d H:i:s");
                $args['crt_id'] = "sysadmin";

                $this->CI->sms_m->setInsertSms($args);

            }



        }


    }



}
?>