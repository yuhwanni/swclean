-- MySQL dump 10.15  Distrib 10.0.25-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cpi
-- ------------------------------------------------------
-- Server version	10.0.25-MariaDB-wsrep

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `ads_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '광고키',
  `aff_idx` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '제휴사키',
  `aff_ads` varchar(45) NOT NULL COMMENT '매체사 광고구분키',
  `aff_ads_status` enum('L','H','E') NOT NULL DEFAULT 'L' COMMENT '매체사 ads 상태 (L:라이브,H:홀드,E:종료)',
  `adv_idx` int(10) unsigned NOT NULL COMMENT '광고주키',
  `ads_type` tinyint(3) unsigned NOT NULL COMMENT '광고형식(1:CPM,2:CPC,3:쿠폰,4:프로모션)',
  `ads_name` varchar(50) NOT NULL COMMENT '광고명',
  `ads_day_reach` int(10) unsigned NOT NULL COMMENT '일예산',
  `ads_today_reach` int(10) unsigned NOT NULL COMMENT '금일소진액',
  `ads_today_click` int(10) unsigned NOT NULL COMMENT '금일클릭수',
  `ads_contract_reach` int(10) unsigned NOT NULL COMMENT '계약도달수',
  `ads_total_reach` int(10) unsigned NOT NULL COMMENT '총 도달수',
  `ads_total_click` int(10) unsigned NOT NULL COMMENT '총클릭수',
  `ads_live` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '노출상태 (''Y'':노출, ''N'':중지)',
  `ads_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '광고상태("0"=>"신규", "1"=>"진행", "2"=>"검수", "3"=>"보류", "4"=>"종료", "5"=>"삭제")',
  `ads_join_url` varchar(255) NOT NULL COMMENT '참가형 URL',
  `ads_icon_img` varchar(150) NOT NULL COMMENT '아이콘이미지',
  `ads_summary` text NOT NULL COMMENT '내용',
  `ads_sdate` date NOT NULL COMMENT '광고개시일',
  `ads_edate` date NOT NULL COMMENT '광고종료일',
  `ads_package` varchar(255) NOT NULL COMMENT '패키지명',
  `ads_contract_price` int(10) unsigned NOT NULL COMMENT '계약단가',
  `ads_reward_price` int(10) unsigned NOT NULL COMMENT '리워드금액',
  `ads_test_pass` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '테스트완료 (Y:완료, N:준비)',
  `ads_order` smallint(5) unsigned NOT NULL,
  `ads_service_past_on` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '과거에 서비스를 했었는지 확인 (0 : 서비스 안했슴, 1: 서비스 했슴) 서비스 한경우 검수단계 거치지 않음',
  `regdate` datetime NOT NULL COMMENT '등록일',
  `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제유무 (''Y'':삭제,''N'':미삭제)',
  PRIMARY KEY (`ads_idx`),
  KEY `adv_idx` (`adv_idx`),
  KEY `ads_type` (`ads_type`),
  KEY `ads_package` (`ads_package`)
) ENGINE=InnoDB AUTO_INCREMENT=583 DEFAULT CHARSET=utf8 COMMENT='광고관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ads_media_off`
--

DROP TABLE IF EXISTS `ads_media_off`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads_media_off` (
  `amo_idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ads_idx` int(10) unsigned NOT NULL COMMENT '광고키',
  `mda_idx` int(10) unsigned NOT NULL COMMENT '매체키',
  PRIMARY KEY (`amo_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='매체별 광고사용안함';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertiser`
--

DROP TABLE IF EXISTS `advertiser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertiser` (
  `adv_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '광고주 키',
  `agc_idx` int(11) unsigned NOT NULL COMMENT '대행사 키',
  `adv_id` varchar(45) DEFAULT NULL COMMENT '광고주아이디',
  `adv_pw` varchar(45) DEFAULT NULL COMMENT '비밀번호',
  `adv_name` varchar(45) DEFAULT '' COMMENT '회원명',
  `adv_hp` varchar(15) NOT NULL COMMENT '연락처',
  `adv_tel` varchar(20) NOT NULL COMMENT '사무실전화',
  `adv_staff` varchar(50) NOT NULL COMMENT '담당자명',
  `adv_auth_key` varchar(100) NOT NULL COMMENT '비밀번호 분실또는 자동로그인시 임시키',
  `adv_email_auth` enum('Y','N') DEFAULT 'N' COMMENT '이메일 인증 - 대행사에서 직접등록할 겨우에는 없슴',
  `adv_budget_status` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '금일 예산 상태(0:대기,1:라이브)',
  `adv_day_budget` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '일일 계정 예산',
  `adv_today_aval_cost` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '금일 소진 금액(머니)',
  `adv_today_bval_cost` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '금일 소진 금액(포인트)',
  `adv_aval` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '머니',
  `adv_bval` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '포인트',
  `adv_aval_card` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '카드결제금액',
  `adv_aval_cash` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '현금',
  `adv_biz_img` varchar(150) NOT NULL COMMENT '사업자등록증',
  `adv_biz_img_type` varchar(20) NOT NULL COMMENT '이미지타입',
  `tax_type` enum('P','C') NOT NULL COMMENT 'P:개인 C:법인',
  `tax_company` varchar(50) NOT NULL COMMENT '회사명',
  `tax_license` varchar(20) NOT NULL COMMENT '사업자번호',
  `tax_ceo` varchar(30) NOT NULL COMMENT '대표자',
  `tax_indutype1` varchar(50) NOT NULL COMMENT '업태',
  `tax_indutype2` varchar(50) NOT NULL COMMENT '종목',
  `tax_addr` varchar(250) NOT NULL COMMENT '주소',
  `tax_email` varchar(50) NOT NULL COMMENT '이메일',
  `tax_auto` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '자동 발행 여부(Y:자동발행,N:사용안함)',
  `regdate` datetime NOT NULL COMMENT '등록일',
  `secdate` datetime NOT NULL COMMENT '탈퇴일(삭제와동시에 탈퇴일시 기록)',
  `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제(Y:삭제)',
  PRIMARY KEY (`adv_idx`),
  UNIQUE KEY `adv_id` (`adv_id`),
  KEY `agc_idx` (`agc_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='광고주 정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advertiser_temp`
--

DROP TABLE IF EXISTS `advertiser_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertiser_temp` (
  `adv_tmp_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '가입대기키',
  `adv_id` varchar(45) DEFAULT NULL COMMENT '광고주아이디',
  `adv_pw` varchar(45) DEFAULT NULL COMMENT '비밀번호',
  `adv_name` varchar(45) DEFAULT '' COMMENT '회원명',
  `adv_hp` varchar(15) NOT NULL COMMENT '연락처',
  `adv_tel` varchar(20) NOT NULL COMMENT '사무실전화',
  `adv_staff` varchar(50) NOT NULL COMMENT '담당자명',
  `auth_key` varchar(255) NOT NULL COMMENT '인증키',
  `regdate` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY (`adv_tmp_idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='광고주 가입대기';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affliation`
--

DROP TABLE IF EXISTS `affliation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affliation` (
  `aff_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '매체키',
  `aff_name` varchar(45) NOT NULL COMMENT '매체명',
  `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제유무',
  PRIMARY KEY (`aff_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='제휴사';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `dvc_idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dvc_cb_key` varchar(45) NOT NULL,
  `dvc_androidid` varchar(45) NOT NULL COMMENT '안드로이드아이디 (androidId는 공장초기화시 재생성 또는 같은값이 많을 수도 있슴)',
  `dvc_deviceid` varchar(45) NOT NULL COMMENT '핸드폰아이디 (태블릿이나 웨어러블 기기에서는 null)',
  `dvc_advid` varchar(45) NOT NULL COMMENT '구글광고아이디 (사용자가 변경 가능)',
  `dvc_brand` varchar(45) NOT NULL COMMENT '브랜드',
  `dvc_model` varchar(45) NOT NULL COMMENT '모델명',
  `dvc_installed` enum('Y','N') NOT NULL DEFAULT 'N',
  `dvc_accountid` varchar(100) NOT NULL COMMENT '수컴용 구글계정 base64 encoding',
  `mdau_idx_ref` int(10) unsigned NOT NULL COMMENT '매체사용자 참고용',
  `regdate` datetime NOT NULL,
  PRIMARY KEY (`dvc_idx`),
  KEY `dvc_cb_key` (`dvc_cb_key`),
  KEY `dvc_androidid` (`dvc_androidid`),
  KEY `dvc_deviceid` (`dvc_deviceid`),
  KEY `dvc_advid` (`dvc_advid`)
) ENGINE=InnoDB AUTO_INCREMENT=17819 DEFAULT CHARSET=utf8 COMMENT='폰정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `device_account`
--

DROP TABLE IF EXISTS `device_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_account` (
  `dvcacc_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '디바이스 구글계정 키',
  `dvc_idx` int(10) unsigned NOT NULL COMMENT '디바이스키',
  `dvcacc_info` varchar(45) NOT NULL COMMENT '구글계정 sha1',
  PRIMARY KEY (`dvcacc_idx`),
  UNIQUE KEY `dvcacc_info` (`dvcacc_info`),
  KEY `dvc_idx` (`dvc_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=28668 DEFAULT CHARSET=utf8 COMMENT='디바이스 구글계정';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_trans_fail`
--

DROP TABLE IF EXISTS `log_trans_fail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_trans_fail` (
  `fail_idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fail_loc` varchar(100) NOT NULL COMMENT '위치',
  `fail_data` text NOT NULL COMMENT '실패 데이터',
  `regdate` datetime NOT NULL COMMENT '실패일',
  PRIMARY KEY (`fail_idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='트랜잭션 실패로그';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `mda_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '매체키',
  `mda_id` varchar(45) NOT NULL COMMENT '아이디',
  `mda_pw` varchar(45) NOT NULL COMMENT '비번',
  `mda_name` varchar(45) NOT NULL COMMENT '매체명',
  `mda_tel` varchar(20) NOT NULL COMMENT '연락처',
  `mda_code` varchar(10) NOT NULL COMMENT '매체코드',
  `mda_enc_code` varchar(16) NOT NULL COMMENT '매체암호화키',
  `mda_auth_key` varchar(100) NOT NULL COMMENT '매체인증키',
  `mda_callback` varchar(255) NOT NULL COMMENT '콜백url',
  `mda_point_name` varchar(20) NOT NULL DEFAULT 'P' COMMENT '포인트명',
  `mda_point_rate` float NOT NULL DEFAULT '1' COMMENT '포인트비율',
  `mda_point_unit` tinyint(3) unsigned NOT NULL COMMENT '표시단위',
  `mda_access_ips` text NOT NULL COMMENT '접근아이피목록',
  `mda_today_click` int(10) unsigned NOT NULL,
  `mda_today_turn` int(10) unsigned NOT NULL,
  `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제유무',
  `regdate` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY (`mda_idx`),
  UNIQUE KEY `mda_id` (`mda_id`),
  UNIQUE KEY `mda_enc_code` (`mda_enc_code`),
  KEY `mda_code` (`mda_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='매체';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media_user`
--

DROP TABLE IF EXISTS `media_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_user` (
  `mdau_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '매체유저키',
  `mda_idx` int(10) unsigned NOT NULL COMMENT '매체키',
  `dvc_idx` int(10) unsigned NOT NULL COMMENT '디바이스키',
  `mdau_uid` varchar(100) NOT NULL COMMENT '매체 사용자 아이디',
  `regdate` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY (`mdau_idx`),
  KEY `dvc_idx` (`dvc_idx`),
  KEY `mdau_uid` (`mdau_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=18841 DEFAULT CHARSET=utf8 COMMENT='매체유저정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reward`
--

DROP TABLE IF EXISTS `reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reward` (
  `rwd_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '리워드키',
  `ads_idx` int(10) unsigned NOT NULL COMMENT '광고키',
  `mda_idx` int(10) unsigned NOT NULL,
  `dvc_idx` int(11) unsigned NOT NULL COMMENT '디바이스키',
  `mdau_idx` int(10) unsigned NOT NULL COMMENT '매체사용자키',
  `click_key` varchar(45) NOT NULL COMMENT '클릭키',
  `rwd_cost` int(10) unsigned NOT NULL COMMENT '지급비용',
  `earn_cost` int(10) unsigned NOT NULL COMMENT '수익비용',
  `rwd_status` enum('R','W','D','S','P') NOT NULL DEFAULT 'R' COMMENT '지급상태 (R:대기,W:지급기준에안맞음,D:지급완료,S:모션까지 완전히 완료됨,P:과거에 설치되어 제외됨)',
  `rwd_condition` varchar(45) NOT NULL COMMENT '리워드 결과 상태값',
  `orderid` varchar(15) NOT NULL COMMENT '와이젬측 지급아이디',
  `reward_key` varchar(20) NOT NULL COMMENT 'aff 지급키',
  `etc` varchar(255) NOT NULL COMMENT '매체 callback 추가 파라미터',
  `past_block` enum('S','A') NOT NULL DEFAULT 'S' COMMENT '과거설치 블럭주체 (S:자체 self, A: 제휴사 aff)',
  `past_block_memo` varchar(255) NOT NULL COMMENT '참여불가 내용',
  `click_day` date NOT NULL,
  `click_time` varchar(2) NOT NULL,
  `click_date` datetime NOT NULL,
  `rwd_day` date NOT NULL,
  `rwd_time` varchar(2) NOT NULL,
  `sync_date` datetime NOT NULL,
  `regdate` datetime NOT NULL COMMENT '등록일',
  `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제유무',
  PRIMARY KEY (`rwd_idx`),
  KEY `ads_idx` (`ads_idx`),
  KEY `userid` (`mdau_idx`),
  KEY `click_key` (`click_key`),
  KEY `mda_idx` (`mda_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=25179 DEFAULT CHARSET=utf8 COMMENT='리워드지급';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rpt_day`
--

DROP TABLE IF EXISTS `rpt_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rpt_day` (
  `rpt_day_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '리포트키',
  `ads_idx` int(10) unsigned NOT NULL COMMENT '광고키',
  `mda_idx` int(11) unsigned NOT NULL COMMENT '매체키',
  `adv_idx` int(10) unsigned NOT NULL COMMENT '광고주키',
  `rpt_day_clk` int(10) unsigned NOT NULL COMMENT '클릭수',
  `rpt_day_turn` int(10) unsigned NOT NULL COMMENT '전환수',
  `rpt_day_cost` int(10) unsigned NOT NULL COMMENT '수익금',
  `rpt_day_earn` int(10) unsigned NOT NULL COMMENT '수익비용',
  `rpt_day_date` date NOT NULL COMMENT '날짜',
  `regdate` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY (`rpt_day_idx`),
  KEY `adv_idx` (`adv_idx`),
  KEY `ads_idx` (`ads_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=2280 DEFAULT CHARSET=utf8 COMMENT='일자별 리포트';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rpt_time`
--

DROP TABLE IF EXISTS `rpt_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rpt_time` (
  `rpt_time_idx` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '리포트키',
  `ads_idx` int(10) unsigned NOT NULL COMMENT '광고키',
  `mda_idx` int(11) unsigned NOT NULL COMMENT '매체키',
  `adv_idx` int(10) unsigned NOT NULL COMMENT '광고주키',
  `rpt_time_time` varchar(2) NOT NULL COMMENT '시간',
  `rpt_time_clk` int(10) unsigned NOT NULL COMMENT '클릭수',
  `rpt_time_turn` int(10) unsigned NOT NULL COMMENT '전환수',
  `rpt_time_cost` int(10) unsigned NOT NULL COMMENT '수익금',
  `rpt_time_earn` int(10) unsigned NOT NULL COMMENT '수익비용',
  `rpt_time_date` date NOT NULL COMMENT '날짜',
  `regdate` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY (`rpt_time_idx`),
  KEY `adv_idx` (`adv_idx`),
  KEY `ads_idx` (`ads_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=14719 DEFAULT CHARSET=utf8 COMMENT='광고주 시간대별 리포트';
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-05  0:00:01
