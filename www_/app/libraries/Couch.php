<?php
class Couch extends FW_Controller {
	
	public $GP = "";
	private $DB;
		
	function __construct($type = '') {	
		
		parent::__construct();	
				
		$this->load->library('globals');
		$this->GP =  $this->load->get_vars();
		
		//$cluster = new CouchbaseCluster("172.31.16.203:8091,172.31.16.207:8091");
		$cluster = new CouchbaseCluster("172.31.16.203:8091");
		
		switch ($type) {
			
			case 'installed' :
				$bucket = $this->GP['COUCHBASE_INST']['bucket'];
				$password = $this->GP['COUCHBASE_INST']['password'];
				break;
		
			case 'click' :
				$bucket = $this->GP['COUCHBASE_CLICK']['bucket'];
				$password = $this->GP['COUCHBASE_CLICK']['password'];
				break;
				
			case 'callback' :
				$bucket = $this->GP['COUCHBASE_CALLBACK']['bucket'];
				$password = $this->GP['COUCHBASE_CALLBACK']['password'];
				break;				
				
			case 'affsend' :
				$bucket = $this->GP['COUCHBASE_AFFSEND']['bucket'];
				$password = $this->GP['COUCHBASE_AFFSEND']['password'];
				break;					
		}
		
		if (isset($bucket) && isset($password)) {	
			$this -> DB = $cluster -> openBucket($bucket, $password);
//			$this->DB->operationTimeout=30000000;
		}
	}
	
	// DESC : 
	// DATE : Thu Jun 23 07:29:48 GMT 2016
	// PARAM : id
	function exist_key ($id) {		
		try {						
			$val = $this -> DB -> get($id) -> value;						
			$val = json_encode(array('rst' => 'S', 'err' => '', 'val'=> $val));						
		} catch(CouchbaseException $e) {
			$val = json_encode(array('rst' => 'E10', 'err' => 'CouchBase No exist key'));						
		}
		return json_decode((($val) ? $val : false),true); 
	}
	
	
	// DESC : 
	// DATE : Thu Jun 23 07:29:48 GMT 2016
	// PARAM : id
	function get ($id) {		
		try {						
			$val = $this -> DB -> get($id) -> value;						
		} catch(CouchbaseException $e) {
			die(json_encode(array('rst' => 'E10', 'err' => 'CouchBase No exist key')));						
		}

		return json_decode((($val) ? $val : false),true); 
	}
	
	// DESC :
	// DATE : Thu Jun 23 07:29:48 GMT 2016
	// PARAM : id, data, option (expiry, flags)
	function set ($id, $data, $option = array()) {
		return (!$this -> DB -> upsert($id, json_encode($data), $option) -> value) ? true : false;
	}	
	
	// DESC :
	// DATE : Thu Jun 23 07:29:48 GMT 2016
	// PARAM : id, option	
	function delete ($id, $option = array()) {
		return (!$this -> DB -> remove($id, $option) -> value) ? true : false;
	}		
	
	// DESC :
	// DATE : Thu Jun 23 09:01:43 GMT 2016
	// PARAM : $qry
	function sendQry ($qry) {
		$query = CouchbaseN1qlQuery::fromString($qry);
		
		$result = $this -> DB -> query($query);
		$data = json_decode(json_encode($result->rows), True);		
		//$data = json_decode(json_encode($result), True);		
		return $data;
	}
	
	// DESC :
	// DATE : Thu Jun 23 09:01:43 GMT 2016
	// PARAM : $qry
	function sendViewQry ($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$query = CouchbaseViewQuery::from($design, $view);		
		
		if ( isset($skip) && $skip >= 0 ){
            $query = $query->skip( $skip );
        }

        if ( isset($limit) && $limit >= 0 ) {
            $query = $query->limit( $limit );
        }
        
        if( isset($skey) && isset($ekey)) {
        	$query = $query -> range($skey,$ekey,true);
        }
        
        if( isset($key) ) {
        	$query = $query->key($key);
        }
        
        if( isset($group_level) ) {
        	$query = $query->group_level($group_level);
        }
        
        
        if( isset($reduce) && $reduce > 0 ) {        	
        	$query = $query->reduce(true);
        }else{
        	$query = $query->reduce(false);
        }   
             
        $result = $this -> DB -> query($query);
		$data = json_decode(json_encode($result->rows), True);				
		
		if(!array_key_exists('0', $data)){		
			return 0;
		}else {
			return $data;
		}
	}
	
	//example viewquery
	function test_time_view($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_rpt_time';
    	$args['skey'] = array($s_date);
    	$args['ekey'] = array($e_date);
    	$args['group_level'] = $group_level;
    	
    	if(isset($offset) && isset($limit)) {
    		$args['skip'] = $offset;
    		$args['limit'] = $limit;
    	}
    	
    	if(isset($reduce)) {
    		$args['reduce'] = $reduce;	
    	}
    	
    	$data = $this->sendViewQry($args);
    	return $data;
    }
	
	//example viewquery
	function test_day_view($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_rpt_day';
    	$args['skey'] = array($s_date);
    	$args['ekey'] = array($e_date);
    	$args['group_level'] = $group_level;
    	
    	if(isset($offset) && isset($limit)) {
    		$args['skip'] = $offset;
    		$args['limit'] = $limit;
    	}
    	
    	if(isset($reduce)) {
    		$args['reduce'] = $reduce;	
    	}
    	
    	$data = $this->sendViewQry($args);
    	return $data;
    }
	
	//example viewquery
	function test_click_view($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_date_log';
    	$args['skey'] = array($ads_idx,$s_date);
    	$args['ekey'] = array($ads_idx,$e_date);
    	
    	if(isset($offset) && isset($limit)) {
    		$args['skip'] = $offset;
    		$args['limit'] = $limit;
    	}
    	
    	if(isset($reduce)) {
    		$args['reduce'] = $reduce;	
    	}
    	
    	$data = $this->sendViewQry($args);
    	return $data;
    }
    
    
    //example viewquery
	function click_mem_ads_view($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_mem_ads';
    	$args['skey'] = array($dvc_cb_key,$s_date);
    	$args['ekey'] = array($dvc_cb_key,$e_date);
    	
    	if(isset($offset) && isset($limit)) {
    		$args['skip'] = $offset;
    		$args['limit'] = $limit;
    	}
    	
    	if(isset($reduce)) {
    		$args['reduce'] = $reduce;	
    	}
    	
    	$data = $this->sendViewQry($args);
    	return $data;
    }
	
	
	//example viewquery
	function test_view($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_ads_cnt';
    	$args['key'] = $ads_idx;
    	$args['reduce'] = 1;
    	$data = $this->sendViewQry($args);
    	return $data;
    }
	
    
    function Ads_F_Sum($args = '') {
    	if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
    	
    	$query = CouchbaseViewQuery::from( 'click', 'click_ads_cnt' );
		
    	$query->key($ads_idx);
    	$query->reduce( true );    	
    	$res = $this -> DB -> query( $query );
        
    	$data = 0;    	
    	if(isset($res->rows[0]->value)) {
    		$data = $res->rows[0]->value;
    	}
        return $data;
        //return $res;
    }
	
	// DESC : 노출 광고 합계
	// DATE : 
	// PARAM : $qry
	function Ads_Front_Sum($arg = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry = "SELECT * FROM CPI_click WHERE imp_day = '$imp_day' AND adv_idx = '$adv_idx' AND ads_idx = '$ads_idx'";
		//echo $qry . "<br /><br />";
		return $this -> sendQry ($qry);
	}
	
	
	// DESC : 패키지 내역 확인
	// DATE : 
	// PARAM : $qry
	function getInstallLog ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$qry = "SELECT packages FROM CPI_installed WHERE META().id = '$dvc_cb_key'";
		return $this -> sendQry ($qry);
	}	
	
	// DESC :
	// DATE : Thu Jun 23 09:31:29 GMT 2016
	// PARAM : 
	function getClickLog ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$column = "meta().id , ads_idx,appcode, app_uid, mda_idx, mdau_idx, dvc_idx, dvc_cb_key, adv_price, contract_price,reward_price,media_price, click_day, click_time, click_date, etc, f_type, user_key, sub_param1, sub_param2, sub_param3, sub_param4, sub_param5";
		 
		if (isset($click_key)) { 
			$qry = "SELECT $column FROM CPI_click WHERE META().id = '$click_key'";
		} else {
			$qry = "SELECT $column FROM CPI_click WHERE app_uid = '$app_uid' AND appcode = '$appcode' AND ads_idx = '$ads_idx' AND click_date > '" . date('Y-m-d H:i:s',strtotime(' -3 days')) . "' ORDER BY click_date DESC LIMIT 1";
		}		
		return $this -> sendQry ($qry);
	}
	
	// DESC :
	// DATE : Thu Jun 23 09:31:29 GMT 2016
	// PARAM : 
	function getClickSeverLog ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$column = "meta().id , ads_idx,appcode, app_uid, mda_idx, mdau_idx, dvc_idx, dvc_cb_key,adv_price, contract_price,reward_price,media_price, click_day, click_time, click_date
			, etc, f_type, user_key";
		 
		if (isset($click_key)) { 
			$qry = "SELECT $column FROM CPI_click WHERE META().id = '$click_key'";
		} else {
			
			if($advid != '') {			
				$qry = "SELECT $column FROM CPI_click WHERE ads_idx = '$ads_idx' AND advid = '$advid' AND click_date > '" . date('Y-m-d H:i:s',strtotime(' -6 days')) . "' ORDER BY click_date DESC LIMIT 1";
			}else {
				$qry = "SELECT $column FROM CPI_click WHERE ads_idx = '$ads_idx' AND deviceid = '$deviceid' AND click_date > '" . date('Y-m-d H:i:s',strtotime(' -6 days')) . "' ORDER BY click_date DESC LIMIT 1";
			}
		}	

		//echo $qry;	
		return $this -> sendQry ($qry);
	}
	
	// DESC :
	// DATE : Thu Jun 23 09:31:29 GMT 2016
	// PARAM : 
	function getClickApiLog ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$column = "meta().id , ads_idx,appcode, app_uid, mda_idx, mdau_idx, dvc_idx, dvc_cb_key,adv_price, contract_price,reward_price,media_price, click_day, click_time, click_date
			, etc, f_type, user_key";
		 
		if (isset($click_key)) { 
			$qry = "SELECT $column FROM CPI_click WHERE META().id = '$click_key'";
		} else {
			
			if($advid != '') {			
				$qry = "SELECT $column FROM CPI_click WHERE appcode = '$appcode' AND ads_idx = '$ads_idx' AND advid = '$advid' AND click_date > '" . date('Y-m-d H:i:s',strtotime(' -6 days')) . "' ORDER BY click_date DESC LIMIT 1";
			}else {
				$qry = "SELECT $column FROM CPI_click WHERE appcode = '$appcode' AND ads_idx = '$ads_idx' AND deviceid = '$deviceid' AND click_date > '" . date('Y-m-d H:i:s',strtotime(' -6 days')) . "' ORDER BY click_date DESC LIMIT 1";
			}
		}	

		return $this -> sendQry ($qry);
	}
	
	
	// DESC :
	// DATE : Thu Jun 23 09:31:29 GMT 2016
	// PARAM :
	function getClickCnt($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$qry_add = array();			
					
		if (!empty($ads_idx)) {
			$qry_add[] = " ads_idx = '$ads_idx'";
		}	
				
		if (!empty($qry_add)) {
			$add_qry = "WHERE " . implode(' AND ' , $qry_add);
		}		
		
		$qry = "SELECT count(*) as cnt FROM CPI_click $add_qry";		
		return $this -> sendQry ($qry);
	}
	
	function qnaClickLogs($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$column = "meta().id , type, rwd_date, ads_idx,appcode, app_uid, mda_idx, mdau_idx, dvc_idx, dvc_cb_key, contract_price,reward_price, click_day, click_time, click_date, etc";
		
		$qry_add = array();
			
		if (!empty($mda_idx)) {
			$qry_add[] = " mda_idx = '$mda_idx'";
		}	
		
		if (!empty($mdau_idx)) {
			$qry_add[] = " mdau_idx = '$mdau_idx'";
		}	
			
		if (!empty($ads_idx)) {
			$qry_add[] = " ads_idx = '$ads_idx'";
		}	
				
		if (!empty($dvc_idx)) {
			$qry_add[] = " dvc_idx = '$dvc_idx'";
		}		
				
		if (!empty($app_uid)) {
			$qry_add[] = " app_uid = '$app_uid'";
		}		
			
		if (!empty($s_date) && !empty($e_date)) {
			$qry_add[] = " click_date BETWEEN '$s_date' AND '$e_date' ";
		}
		
		if (!empty($click_key)) {
			$qry_add[] = " meta().id = '$click_key' ";
		}
					
		if (!empty($qry_add)) {
			$add_qry = "WHERE " . implode(' AND ' , $qry_add);
		}		
		
		$qry = "SELECT $column FROM CPI_click $add_qry and etc='SDK' ORDER BY click_date";			
		return $this -> sendQry ($qry);
	}
	
	
	// DESC :
	// DATE : Tue Jun 28 08:25:22 GMT 2016
	// PARAM : $page_row, $mda_idx
	function getClickLogs ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		//$column = "meta().id , type, rwd_date, ads_idx, appcode, app_uid, mda_idx, mdau_idx, dvc_idx, dvc_cb_key, contract_price, reward_price, click_day, click_time, click_date, etc";
		$column = "meta().id, accountid, accountid2, ads_idx, advid, androidid, app_uid, appcode, brand, click_date, click_day, click_time, contract_price, deviceid,  dvc_cb_key,  dvc_idx, f_type, mda_idx, mdau_idx, media_price, model, reward_price, type, user_key, rwd_date ";
		
		$page_row = ($page_row)? $page_row : 10;
		
		if (isset($click_key)) {
			if(!empty($tot_cnt)) {
				$qry = "SELECT count(*) as cnt FROM CPI_click WHERE META().id = '$click_key'";
			}else{
				$qry = "SELECT $column FROM CPI_click WHERE META().id = '$click_key' LIMIT $page_row OFFSET $offset ";	
			}
		} else {
			
			$qry_add = array();
			
			if (!empty($mda_idx)) {
				$qry_add[] = " mda_idx='$mda_idx'";
			}		
				
			if (!empty($ads_idx)) {
				$qry_add[] = " ads_idx='$ads_idx'";
			}	

			if (!empty($advid)) {
				$qry_add[] = " advid='$advid'";
			}

			if(!empty($idfa)) {
                $qry_add[] = " deviceid='$idfa'";
            }

			if (!empty($dvc_idx)) {
				$qry_add[] = " dvc_idx='$dvc_idx'";
			}		
				
			if (!empty($s_date) && !empty($e_date)) {
				$qry_add[] = " click_date BETWEEN '$s_date 00:00:00' AND '$e_date 23:59:59' ";
			}			
						
			if (!empty($qry_add)) {
				$add_qry = "WHERE " . implode(' AND ' , $qry_add);
			}
			
			if(!empty($tot_cnt)) {
				$qry = "SELECT count(*) as cnt FROM CPI_click $add_qry";
			}else{
				//$qry = "SELECT $column FROM CPI_click $add_qry ORDER BY click_date LIMIT $page_row OFFSET $offset ";		
				$qry = "SELECT $column FROM CPI_click $add_qry LIMIT $page_row OFFSET $offset ";										
			}			
		}		
		return $this -> sendQry ($qry);
	}
	
	// DESC :
	// DATE : 
	// PARAM : $click_day, $total_sum
	function getRptClick ($args = '') {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;
		
		$this->load->library('couch', 'click');		
		$this->load->model( 'rpt_day_m' );				
		$C_CBCLK = new Couch('click');
		
		// 금일 매체별 총 리포트 입력
		/*
		if (!$total_sum) {
			
			$rst = "";
			$qry = "SELECT COUNT(*) AS cnt, mda_idx FROM CPI_click USE INDEX(click_getclklog1_idx using gsi) WHERE click_day = '$click_day' GROUP BY mda_idx";
			echo $qry . "<br /><br />";
			$rst = $this -> sendQry ($qry);
			
			if (isset($rst) && is_array($rst)) {
				foreach ($rst as $k => $v) {
					
					if(isset($v['mda_idx'])) {
						$args = array();					
						$args['mda_idx'] = $v['mda_idx'];
						$args['mda_today_click'] = $v['cnt'];
						$args['click_day'] = $click_day;
						$this -> rpt_day_m -> rptDayMediaSet ($args);
					}
				}
			}
		}
		
		// 금일 총 리포트 입력
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, ads_idx FROM CPI_click USE INDEX(click_getclklog2_idx using gsi) WHERE click_day = '$click_day' GROUP BY ads_idx";
		echo $qry . "<br /><br />";
		$rst = $this -> sendQry ($qry);
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['ads_idx'])) {
					$args = array();
					$args['ads_idx'] = $v['ads_idx'];				
					$args['ads_today_click'] = $v['cnt'];
					$args['click_day'] = $click_day;
					$args['total_sum'] = $total_sum;
	
					$this -> rpt_day_m -> rptDayTotalSet ($args);
				}
			}
		}
		*/
		
		// 날짜별 전면 노출 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx FROM CPI_click WHERE imp_day = '$click_day' and mda_idx != '' GROUP BY mda_idx, ads_idx";
		echo $qry . "<br /><br />";				
		$rst = $this -> sendQry ($qry);
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_day_imp_f'] = $v['cnt'];
					$args['rpt_day_date'] = $click_day;
					
					$this -> rpt_day_m -> rptDaySet ($args);
				}
			}
		}
		*/
		
		// 날짜별 전면 클릭 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx FROM CPI_click WHERE click_day = '$click_day' AND f_type = 'F' AND mda_idx != '' GROUP BY mda_idx, ads_idx";
		echo $qry . "<br /><br />";
		$rst = $this -> sendQry ($qry);
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_day_clk_f'] = $v['cnt'];
					$args['rpt_day_date'] = $click_day;
					
					$this -> rpt_day_m -> rptDaySet ($args);
				}
			}
		}
		*/

		//일자별 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx FROM CPI_click WHERE click_day = '$click_day' AND f_type = '' AND mda_idx != '' GROUP BY mda_idx, ads_idx";
		echo $qry . "<br /><br />";
		$rst = $this -> sendQry ($qry);
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_day_clk'] = $v['cnt'];
					$args['rpt_day_date'] = $click_day;
					
					$this -> rpt_day_m -> rptDaySet ($args);
				}
			}
		}
		*/

		$rst = "";
		$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_rpt_day';
    	$args['skey'] = array($click_day);
    	$args['ekey'] = array($next_day);
    	$args['group_level'] = 3;    	
    	$args['reduce'] = 1;	
    	$rst = $this->sendViewQry($args);
		
    	if (isset($rst) && is_array($rst)) {
	    	foreach($rst as $key => $val) {				
				$args = array();
				$args['mda_idx'] = $val['key'][2];
				$args['ads_idx'] = $val['key'][1];				
				$args['rpt_day_clk'] =  $val['value'];
				$args['rpt_day_date'] = $val['key'][0];
				$this -> rpt_day_m -> rptDaySet ($args);
			}
    	}
		
		$this -> rpt_day_m -> rptDayTurnSet (array('rpt_day_date' => $click_day));
		
		
		
		// 시간대별 전면 노출 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx, imp_time FROM CPI_click WHERE imp_day = '$click_day' AND mda_idx != '' GROUP BY mda_idx, ads_idx, imp_time";
		echo $qry . "<br /><br />";
		$rst = $this -> sendQry ($qry);	
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_time_imp_f'] = $v['cnt'];
					$args['rpt_time_time'] = $v['imp_time'];
					$args['rpt_time_date'] = $click_day;
					
					$this -> rpt_day_m -> rptTimeSet ($args);
				}
			}
		}
		*/
		
		// 시간대별 전면 클릭 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx, click_time FROM CPI_click WHERE click_day = '$click_day' AND f_type = 'F' AND mda_idx != '' GROUP BY mda_idx, ads_idx, click_time";
		echo $qry . "<br /><br />";
		$rst = $this -> sendQry ($qry);	
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_time_clk_f'] = $v['cnt'];
					$args['rpt_time_time'] = $v['click_time'];
					$args['rpt_time_date'] = $click_day;
					
					$this -> rpt_day_m -> rptTimeSet ($args);
				}
			}
		}
		*/
		
		// 시간대별 클릭 리포트 입력
		/*
		$rst = "";
		$qry = "SELECT COUNT(*) AS cnt, mda_idx, ads_idx, click_time FROM CPI_click WHERE click_day = '$click_day' AND f_type = '' AND mda_idx != '' GROUP BY mda_idx, ads_idx, click_time";
		echo $qry . "<br /><br />";
		//$rst = $this -> sendQry ($qry);	
		
		if (isset($rst) && is_array($rst)) {
			foreach ($rst as $k => $v) {
				if(isset($v['mda_idx'])) {
					$args = array();
					$args['mda_idx'] = $v['mda_idx'];
					$args['ads_idx'] = $v['ads_idx'];				
					$args['rpt_time_clk'] = $v['cnt'];
					$args['rpt_time_time'] = $v['click_time'];
					$args['rpt_time_date'] = $click_day;
					
					//$this -> rpt_day_m -> rptTimeSet ($args);
				}
			}
		}
		*/
		
		$rst = "";
		$args = "";
    	$args['design'] = 'click';
    	$args['view'] = 'click_rpt_time';
    	$args['skey'] = array($click_day);
    	$args['ekey'] = array($next_day);
    	$args['group_level'] = 4;    	
    	$args['reduce'] = 1;	
    	$rst = $this->sendViewQry($args);
		
    	if (isset($rst) && is_array($rst)) {
	    	foreach($rst as $key => $val) {				
				$args = array();
				$args['mda_idx'] = $val['key'][2];
				$args['ads_idx'] = $val['key'][1];				
				$args['rpt_time_clk'] =  $val['value'];
				$args['rpt_time_time'] =  $val['key'][3];
				$args['rpt_time_date'] = $val['key'][0];
				$this -> rpt_day_m -> rptTimeSet ($args);
			}
    	}
    	
		$this -> rpt_day_m -> rptTimeTurnSet (array('rpt_time_date' => $click_day));	
	}
}
?>