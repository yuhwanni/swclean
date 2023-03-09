<?
/*
function getList () {
	global $C_ListClass;
	
	$args['search'] = array('');
	$args['search_match'] = array('');
	$args['sc_type'] = $sc_type;
	$args['sc_val'] = $sc_val;
	$args['show_page'] = 10;
	$args['show_row'] = 10;
	$args['excel'] = array('');
	$args['excel_kr'] = array('');
	
	$args['q_idx'] = "";
	$args['q_col'] = "";
	$args['q_table'] = "";
	$args['q_where'] = "";
	$args['q_order'] = "";
	$args['q_group'] = "";
	$args['tail'] = "";
	$args['q_see'] = "";
	
	return $C_ListClass -> listInfo($args);
}

$L_list 			= $data['data'];
$page_link 		= $data['page_info']['link'];
$page_search	= $data['page_info']['search'];
$total 				= $data['page_info']['total'];
$L_list_cnt 	= count($L_list);

*/
class Listclass extends FW_Model
{	
	
	private $page_info = array();
	private $conf_info = array();
	private $db2;
	
	function __construct($DB = '') {						
		$this->db2 = $this->load->database( 'select', TRUE ); 	
	}
	
	function setVals ($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v; 
		if (!$q_idx) die('IDX 설정이 없습니다.');
		
		$this -> conf_info = $args;
		$this -> conf_info['page'] 			= (intval($page))? intval($page) : 1;
		$this -> conf_info['show_row'] 	= (isset($show_row))? $show_row : 10;
		$this -> conf_info['show_page'] = ($show_page)? $show_page : 10;
		$this -> conf_info['q_where'] 	= ($q_where)? ' WHERE ' . $q_where : '';	
		$this -> conf_info['q_group'] 	= ($q_group)? ' GROUP BY ' . $q_group : '';	
		$this -> conf_info['q_order'] 	= ($q_order)? ' ORDER BY ' . $q_order : '';
		//$this -> conf_info['search_rst'] 	= array($sc_type, $sc_val);
		$this -> conf_info['list_dsp_none'] = (isset($list_dsp_none))? $list_dsp_none : "";		
		
		$this -> conf_info['totalCount'] 	= (isset($totalCount))? $totalCount : 0;
		
	}
	
	function listInfo ($args) {
		
		$excel_file = (isset($excel_file))? $excel_file : "";
		$args['ajax'] = (isset($args['ajax']))? $args['ajax'] : false;
		
		//$args['search_rst'] = array($args['sc_type'], $args['sc_val']);
		
		$this -> setVals($args);
		
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 
		
		// QRY
		$qry_def = $this -> conf_info['q_order'];
		
		if ($excel_file) {
			$qry_get = $this -> getQuery('excel');
		} else {
			// 검색어가 있을경우
			//if (!empty($search_rst[0])) {
				//$qry_get = $this -> getQuery('search');
			//} else {
				$qry_get = $this -> getQuery();
			//}
		}
		
		if ($this -> conf_info['q_see']) {
			print_r($qry_get);// die($qry_get);
			exit;
		}				
		
		
		//if (!$list_dsp_none || $sc_type) {
		if (!$list_dsp_none) {			
			$query = $this -> db -> query ($qry_get);				
			$data = $query->result_array();			
		}				
		
		if($excel_file)
		{			
			$args = array();
			$args['excel'] = $excel;			
			$args['data'] = $data;
			$this -> getExcel($args);
			exit;
		}


		
		if($args['ajax'] == true){
			$this -> getPageLinkAjax();
		}else{
			if(isset($args['list_type']) && $args['list_type'] == "front") {
				$this->getPageLinkFront();
			}else {
				$this->getPageLink();
			}
		}
		
		$rst['qry'] 				= $qry_get;
		$rst['data'] 				= $data;
		$rst['page_info'] 	= $this -> page_info;	
		return $rst;			
	}
	
	function addWhere ($str = '') {
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 
		
		if ($str) $this -> conf_info['q_where'] .= (($q_where)? ' AND ' : ' WHERE ') . $str;
		return $qry_def = 'SELECT ' . $q_col. ' FROM ' . $q_table. $this -> conf_info['q_where']. $q_group. $q_order;
	}
	
	function getQuery ($__type = '') {
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 
		
			$excel_chk = (isset($excel_chk))? $excel_chk : "";
			$excel_chk_val = (isset($excel_chk_val))? $excel_chk_val : "";
			$str = "";

			if ($excel_chk && $excel_chk_val) {
				$str = " " . $excel_chk . " IN (" . str_replace('_',',',$excel_chk_val) . ")";
			}
			//echo print_r($str);
			$rst = $this -> addWhere ($str);
	
			$this -> setCounts ();				
			$this -> getCounts ();	
						
			if ($this -> conf_info['show_row']) {
				$add_limit = " LIMIT " . $this -> page_info['start_limit'] . ", " . $this -> conf_info['show_row'];
			}
			
			// 엑셀이 아닌경우에만 limit
			if ($__type != 'excel' && !$list_dsp_none) $rst .= $add_limit;
		return $rst;
	}

	
	// 검색 형식 설정
	function searchTypeChoice ($col,$val) {
		if(is_array($this -> conf_info['search_match']) && in_array($col,$this -> conf_info['search_match']))
			$str = " " . $col." = '" .$val . "'";
		else
			$str = "REPLACE(" . $col.", ' ','') like '%" . $val . "%'";
			
		return $str;
	}
	
	function setCounts () {
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 

		$qry = 'SELECT COUNT(' . $q_idx. ') as cnt FROM ' . $q_table. $q_where . $q_group;		
		if($totalCount){
			$rst = $totalCount;
		}else{
			if ($q_group) {
				$result = $this->db->query($qry);
				$data = $result->result_array();
				$rst = count($data);
			} else {				
				$result = $this->db->query($qry);
				if ($result->num_rows() > 0) {
					$rst = $result->row_array(); 
				}
				$rst = $rst['cnt'];
			}
		}
		$this -> page_info['total'] = $rst;
	}
	
	// page, total, show_row, show_page
	function getCounts () {
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 
		if (is_array($this -> page_info)) foreach ($this -> page_info as $k => $v) ${$k} = $v; 

		$startnum 	= ($page - 1) * $show_row;		
		if ($show_row) $totalpages	= ceil($total / $show_row);
		if ($show_page) $startpage 	= ((ceil(($page / $show_page) - 0.01) - 1) * $show_page) + 1;
		$endpage   	= $startpage + ($show_page - 1);
		$endpage   	= ($totalpages < $endpage) ? $totalpages : $endpage;
		$prevpage  	= ($startpage != 1) ? $startpage - $show_page : 1;
		$nextpage  	= (($endpage + 1) > $totalpages) ? $totalpages : $endpage + 1;
		$startrownum = $total - (($show_row * $page) - $show_row) ;

		$this -> page_info['start_limit'] = $startnum;
		$this -> page_info['start'] = $startpage;
		$this -> page_info['end'] 	= $endpage;
		$this -> page_info['prev'] 	= $prevpage;
		$this -> page_info['next'] 	= $nextpage;
		$this -> page_info['tpage'] = $totalpages;
		$this -> page_info['start_num'] = $startrownum;
	}

	function getPageLinkFront()
	{
        if (is_array($this->conf_info)) foreach ($this->conf_info as $k => $v) ${$k} = $v;
        if (is_array($this->page_info)) foreach ($this->page_info as $k => $v) ${$k} = $v;

        $rst = "";
        if ($total > 0) {
            //$rst = "<li class='page-item first'><a href=\"?page=1&" . $tail . "\" class='page-link'> << </a></li>";
            $rst .= "<li class='page-item '><a href=\"?page=" . $this->page_info['prev'] . "&" . $tail . "\" class='page-link'><i class=\"fas fa-angle-left\"></i></a></li>";

            for ($i = $start; $i <= $end; $i++) {
                $rst .= "<li " . (($i == $page) ? "class='page-item active'" : "class='page-item'") . "><a href='?page=" . $i . '&' . $tail . "'class='page-link'>" . $i . "</a></li>";
            }

            $rst .= "<li class='page-item '><a href=\"?page=" . $this->page_info['next'] . "&" . $tail . "\" class='page-link'><i class=\"fas fa-angle-right\"></i></a></li>";
            //$rst .= "<li class='page-item last'><a href=\"?page=" . $this -> page_info['tpage'] . "&" . $tail . "\" class='page-link'>Last</a></li>";
            $rst = "<ul class=\"pagination float-end\">" . $rst . "</ul>";
        } else {
            //$rst = ($tqry)?  "<font color='red'><b>$tqry</b></font> 에 대한 검색 결과가 없습니다.":"";
            $rst = "";
        }

        $this->page_info['link'] = $rst;
	}

    function postPageLink()
    {
        if (is_array($this->conf_info)) foreach ($this->conf_info as $k => $v) ${$k} = $v;
        if (is_array($this->page_info)) foreach ($this->page_info as $k => $v) ${$k} = $v;

        $script = "";
        $script .= "<form name='frm_pagelink' id='frm_pagelink' method='POST'>";
        $script .= "<input type='hidden' name='page' id='page' value='1' />";

        parse_str($tail, $output);

        foreach ($output as $k => $v) {
            $script .= "<input type='hidden' name='" . $k . "' value='" . $v . "' />";
        }

        $script .= "</form>";
        $script .= "<script>";
        $script .= "
            function postPageSubmit(page) {
                $('#page').val(page);
                $('#frm_pagelink').submit();
            }
        ";
        $script .= "</script>";

        $rst = "";
        if ($total > 0) {
            //$rst = "<li class='page-item first'><a href=\"?page=1&" . $tail . "\" class='page-link'> << </a></li>";
            $rst .= "<li class='page-item'><a href=\"javascript:;\" onclick=\"postPageSubmit('" . $this->page_info['prev'] . "')\" class='page-link'>&larr; &nbsp; Prev</a></li>";

            for ($i = $start; $i <= $end; $i++) {
                $rst .= "<li " . (($i == $page) ? "class='page-item active'" : "class='page-item'") . "><a href=\"javascript:;\" onclick=\"postPageSubmit('" . $i . "')\" class='page-link'>" . $i . "</a></li>";
            }

            $rst .= "<li class='page-item'><a href=\"javascript:;\" onclick=\"postPageSubmit('" . $this->page_info['next'] . "')\" class='page-link'>Next &nbsp; &rarr;</a></li>";
            //$rst .= "<li class='page-item last'><a href=\"?page=" . $this -> page_info['tpage'] . "&" . $tail . "\" class='page-link'>Last</a></li>";
            $rst = "<ul class=\"pagination pagination-flat pagination-rounded align-self-center\">" . $rst . "</ul>";
        } else {
            //$rst = ($tqry)?  "<font color='red'><b>$tqry</b></font> 에 대한 검색 결과가 없습니다.":"";
            $rst = "";
        }

        $rst .= $script;
        $this->page_info['link'] = $rst;
    }

    function getPageLink()
    {
        if (is_array($this->conf_info)) foreach ($this->conf_info as $k => $v) ${$k} = $v;
        if (is_array($this->page_info)) foreach ($this->page_info as $k => $v) ${$k} = $v;

        $rst = "";
        if ($total > 0) {
            //$rst = "<li class='page-item first'><a href=\"?page=1&" . $tail . "\" class='page-link'> << </a></li>";
            $rst .= "<li class='page-item prev'><a href=\"?page=" . $this->page_info['prev'] . "&" . $tail . "\" class='page-link'>&larr; &nbsp; 이전</a></li>";

            for ($i = $start; $i <= $end; $i++) {
                $rst .= "<li " . (($i == $page) ? "class='page-item active'" : "class='page-item'") . "><a href='?page=" . $i . '&' . $tail . "'class='page-link'>" . $i . "</a></li>";
            }

            $rst .= "<li class='page-item next'><a href=\"?page=" . $this->page_info['next'] . "&" . $tail . "\" class='page-link'>다음 &nbsp; &rarr;</a></li>";
            //$rst .= "<li class='page-item last'><a href=\"?page=" . $this -> page_info['tpage'] . "&" . $tail . "\" class='page-link'>Last</a></li>";
            $rst = "<ul class=\"pagination pagination-flat pagination-rounded align-self-center\">" . $rst . "</ul>";
        } else {
            //$rst = ($tqry)?  "<font color='red'><b>$tqry</b></font> 에 대한 검색 결과가 없습니다.":"";
            $rst = "";
        }

        $this->page_info['link'] = $rst;
    }
	
	// list_page_script
	function getPageLinkAjax()
	{
		if (is_array($this -> conf_info)) foreach ($this -> conf_info as $k => $v) ${$k} = $v; 
		if (is_array($this -> page_info)) foreach ($this -> page_info as $k => $v) ${$k} = $v; 
		
		//if ($search_rst[0] && $search_rst[1]) {
			//$tail .= '&sc_type=' . $search_rst[0] . '&sc_val=' . $search_rst[1];
		//}
		
		if($total > 0)
		{ 				
			$rst = "<li><a href=\"javascript:goAjaxLink('$ajax_target','$ajax_url','page=1&" . $tail . "')\">&laquo;</a></li>";
			$rst .= "<li><a href=\"javascript:goAjaxLink('$ajax_target','$ajax_url','page=" . $prev . "&" . $tail . "')\">&lsaquo;</a></li>";
			
			for($i = $start ; $i <= $end ; $i++){
				$rst .= "<li " .  (($i == $page)? "class=\"link_now\"" : "") . "><a href=\"javascript:goAjaxLink('$ajax_target','$ajax_url','page=" . $i . '&' . $tail . "')\">" . $i ."</a></li>";
			}		
			
			$rst .= "<li><a href=\"javascript:goAjaxLink('$ajax_target','$ajax_url','page=" . $this -> page_info['next'] . "&" . $tail . "')\">&rsaquo;</a></li>";
			$rst .= "<li><a href=\"javascript:goAjaxLink('$ajax_target','$ajax_url','page=" . $this -> page_info['tpage'] . "&" . $tail . "')\">&raquo;</a></li>";
			
			$rst = "<ul class=\"pagination\">" . $rst . "</ul>";

		} else {
			$rst = "<font color='red'><b>조건에 맞는</b></font> 검색 결과가 없습니다.";
		}
		
		/*
		if ($class) {
			$rst = "<table class='$class'><tr><td>" . $rst . "</td></tr></table>";
		}
		*/
		$this -> page_info['link'] = $rst;
	}	
	
	
	function makeInputValue ($data) {
		$data_arr = explode('&', $data);
		
		if (is_array($data_arr)) {
			foreach ($data_arr as $v) {
				$input_val = explode('=' , $v);
				
				$str .= "<input type='hidden' name='" . $input_val[0] . "' id='" . $input_val[0] . "' value='" . $input_val[1] . "'>";
			}
		}
		
		return $str;
	}
/*
*		엑셀설정 시작 V.0.2
*
*/	
	function getExcel ($args = array()) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v; 		

		require APPPATH."third_party/PHPExcel.php";

		if (PHP_SAPI == 'cli') die('This Service should only be run from a Web Browser');		

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$keyArr = array_keys($excel);
		$valueArr = array_values($excel);
		
		$cell = 'a';
		$col = 0;
		// Add some data
		if (is_array($keyArr)) {
			foreach ($keyArr as $v) {
				//$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr(ord($cell) + $col) . '1', $v);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue(strtoupper($cell) . '1', $v);
				//$col++;
				//echo strtoupper($cell) . "_". $v ."_" . $col ."<br>";
				++$cell;
			}
		}
		
		$rstCnt1 = count($excel);
		$rstCnt2 = count($data);
				
		$cell = 'a';
		$tell = "A";
		$row = 2;		
		for($i = 0; $i < $rstCnt2; $i++)
		{
			for($j = 0 ;$j < $rstCnt1 ; $j++)
			{
				$column_name = $valueArr[$j];
				
				$args = array();
				$args['data'] = $data[$i];
				$args['column_name'] = $column_name;
				$data_str = $this -> checkReplaceData ($args);
				
				//$range = chr(ord($cell) + $j) . $row;
				$range = strtoupper($cell) . $row;

				//echo chr(ord($tell) + $j) . $row . " =====> " . $range ."___" .$j ."____" . $rstCnt1 . "<br>";
                if(preg_match( "/^[0-9]/i", $data_str ) && strlen($data_str) >= 3) {
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($range, $data_str, PHPExcel_Cell_DataType::TYPE_STRING);					
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($range, $data_str);
				}

				++$cell;

				if($rstCnt1 == $j + 1) {
					$cell = "a";
				}
			}
			$row++;
		}


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $this->conf_info['excel_file'] . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
	}		
	
	
	function checkReplaceData ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v; 
		
		$rst = isset($data[$column_name]) ? $data[$column_name] : '';
		
		if (!empty($this -> conf_info['excel_kr']) && array_key_exists($column_name,$this -> conf_info['excel_kr'])) {
			foreach ($this -> conf_info['excel_kr'][$column_name] as $k => $v) {
				if ($rst == $k) {
					$rst = $v;
					return $rst;
					break;
				}
			}
			$rst = ''; 
		}		
		
		// 변수가 존재할 경우 연산 치환
		if (preg_match('/\$/',$column_name)) {
			if (is_array($data)) foreach ($data as $k => $v) ${$k} = $v; 
			//echo '$rst = ' . $column_name . ";"; exit;
			eval('$rst = ' . $column_name . ";");
		}
		
		if(is_numeric($rst)) {
			if(is_nan($rst)) {
				$rst = 0;
			}
		}
		
		return $rst;
	}
}
?>