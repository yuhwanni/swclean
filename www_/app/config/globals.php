<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$_DEF_PATH = str_replace('\\', '/', dirname(__FILE__));
//$_DEF_PATH = explode('/',$_DEF_PATH);
//array_pop($_DEF_PATH);
//$_DEF_PATH = implode('/',$_DEF_PATH);

$config['DOCROOT'] = $_SERVER['DOCUMENT_ROOT'];

$config['WEBROOT'] =  '/';

$config['ROOT'] 	= $config['DOCROOT']. $config['WEBROOT'];	

$config['Eng']		= $config['ROOT'];

$config['DOMAIN'] 	= $_SERVER['HTTP_HOST'];

$config['HTTP']		= 'http://' . $config['DOMAIN'];

$config['SELFPAGE']	= $_SERVER['REQUEST_URI'];

$config['NOWPAGE']	= $config['SELFPAGE'] . '?' . $_SERVER['QUERY_STRING'];

$config['SERVER_IP'] = "localhost";

//리스트 VIEW CNT
$config['VIEW_CNT']			= ["10"=>"VIEW 10", "30"=>"VIEW 30", "100"=>"VIEW 100", "1000"=>"VIEW 1000"];

//관리자 상태
$config['ADM_STATUS'] = ['1' => '대기', '2' => '정상', '3' => '정지'];

//회원상태
$config['MEM_STATUS'] = ['1' => '정상', '2' => '임시차단', '3' => '접근거부', '4' => '승인대기', '5' => '탈퇴처리'];

//회원레벨
$config['MEM_LEVEL'] = ['1' => '운영자', '2' => '부운영자', '3' => '정회원', '4' => '일반회원', '5' => '손님'];

$config['ORDER_STATUS_COLOR'] = array(
    "1" => "<span class=\"badge badge2 badge-primary\">주문접수</span>",
    "3" => "<span class=\"badge badge2 badge-danger\">입금확인</span>",
    "4" => "<span class=\"badge badge2 badge-secondary\">배송준비중</span>",
    "5" => "<span class=\"badge badge2 badge-success\">배송완료</span>",
    "7" => "<span class=\"badge badge2 badge-warning\">반품접수</span> ",
    "8" => "<span class=\"badge badge2 badge-warning\">반품완료</span> ",
    "9" => "<span class=\"badge badge2 badge-warning\">주문취소</span> "
);

//Y.H 사용자 업로드 폴더
//보안관계상 업로드 폴더는 외부로 놓는다.
$web_sys_dir = str_replace("www", "", $_SERVER['DOCUMENT_ROOT']);

//스마트 에디터 경로
$config['EDITOR_DIR'] = "/resource/editor/";
$config['EDIT_ACTION'] = "/editor/editor_photo_insert";
$config['EDIT_UPLOAD_DIR'] = $_SERVER['DOCUMENT_ROOT'].'/_upload/editor/';
$config['EDIT_UPLOAD_URL'] = '/_upload/editor/';

$config['POPUP_IMG_DIR'] = $_SERVER['DOCUMENT_ROOT']."/_upload/popup/";
$config['POPUP_IMG_URL'] = "/_upload/popup/";

//리스트 VIEW CNT
$config['WEB_VIEW_CNT']			= ["10"=>"10개씩 보기", "20"=>"20개씩 보기", "30"=>"30개씩 보기", "50"=>"50개씩 보기"];

$config['WEB_LIST_VIEW_CNT']			= ["12"=>"12개씩 보기", "24"=>"24개씩 보기", "36"=>"36개씩 보기"];

////////////////////////////////////////////////////////////////
//# SMTP config
////////////////////////////////////////////////////////////////
$config['SMTP_USE'] 		= true;
$config['SMTP_SERVER']		= 'smtp.gmail.com';
$config['SMTP_PORT']		= '587';
$config['SMTP_USER']		= 'contact@pxscope.com';
$config['SMTP_PASS']		= '!Pxscontact0700';
/*$config['SMTP_USER']		= 'yuhwanni9896@gmail.com';
$config['SMTP_PASS']		= 'tonoghrsmqncdtat';*/
/*$config['EMAIL_DEF'] 		= ['contact@pxscope.com','PIXELCAST'];
$config['EMAIL_TEST'] 		= ['contact@pxscope.com','PIXELCAST'];*/
$config['EMAIL_DEF'] 		= ['contact@pxscope.com','PIXELCAST'];
$config['EMAIL_TEST'] 		= ['contact@pxscope.com','PIXELCAST'];

$config['CONTACTUS_MAIL'] = "info@pxscope.com";
//$config['CONTACTUS_MAIL'] = "yuhwanni@naver.com";

$config['MENU'] = [];
if (isset($_SESSION['sess_adm']['sess_idx'])) { //관리자

    array_push($config['MENU'],
        [
            'title' => 'Board',
            'name' => '게시판관리', 'en_name' => '', "icon" => "icon-package", "href" => "#", "folder" => "news",
            "sub" => [
                ["name" => "국문 NEWS", 'en_name' => '', "href" => "/adm/news/news_list?type=K", "auth" => "news_list"],
                ["name" => "영문 NEWS", 'en_name' => '', "href" => "/adm/news/news_list?type=E", "auth" => "news_list"],
            ]
        ]
    );

    array_push($config['MENU'],
        [
            'title' => 'Design',
            'name' => '메인', 'en_name' => '', "icon" => "icon-design", "href" => "#", "folder" => "design",
            "sub" => [
                ["name" => "메인 관리", 'en_name' => '', "href" => "/adm/design/main_img_list", "auth" => "design1"],
                /*["name" => "메인 YOUTOBE 관리", 'en_name' => '', "href" => "/adm/design/main_img_list", "auth" => "design2"],*/
            ]
        ]
    );

    array_push($config['MENU'],
        [
            'title' => 'Etc',
            'name' => '팝업관리', 'en_name' => '', "icon" => "icon-package", "href" => "#", "folder" => "gita",
            "sub" => [
                ["name" => "팝업목록", 'en_name' => '', "href" => "/adm/gita/popup_list", "auth" => "gita1"],
                ["name" => "팝업등록", 'en_name' => '', "href" => "/adm/gita/popup_mng", "auth" => "gita2"],
            ]
        ]
    );

    array_push($config['MENU'],
        [
            'title' => 'Contact',
            'name' => 'Contact', 'en_name' => '', "icon" => "icon-package", "href" => "#", "folder" => "contact",
            "sub" => [
                ["name" => "문의 리스트", 'en_name' => '', "href" => "/adm/qna/qna_list", "auth" => "contact1"],
            ]
        ]
    );

    array_push(
        $config['MENU'],
        [
            'title' => 'Settings',
            'name' => '설정', 'en_name' => 'Auth Setting', "icon" => "icon-cog3", "href" => "#", "folder" => "manager",
            "sub" => [
                ["name" => "관리자 리스트", 'en_name' => '', "href" => "/adm/manager/mng_list", "auth" => "set1"],
                /*["name" => "사이트정보", 'en_name' => '', "href" => "/adm/manager/site_setup", "auth" => "set2"],*/
            ]
        ]
    );
}

//전화번호 기본 입력(휴대폰만)
$config['HP_NUM'] = array (
  "010" => "010"
, "011" => "011"
, "016" => "016"
, "017" => "017"
, "018" => "018"
, "019" => "019"
);


/* 사이트 설정 */

$config['MAIN_IMG_DIR'] = $_SERVER['DOCUMENT_ROOT']."/"."_upload/main/";
$config['MAIN_IMG_URL'] = "/"."_upload/main/";

$config['NEWS_IMG_DIR'] = $_SERVER['DOCUMENT_ROOT']."/"."_upload/news/";
$config['NEWS_IMG_URL'] = "/"."_upload/news/";

//영문메뉴
$config['SITE_MENU']['eng'] = [];

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'HOME',
        'name' => 'HOME', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng", "folder" => "",
    ]
);

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'PRODUCT',
        'name' => 'PRODUCT', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/product", "folder" => "product",
    ]
);

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'SPORTS',
        'name' => 'SPORTS', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/sports", "folder" => "sports",
        /*"sub" => [
            ["name" => "SPORTS", 'en_name' => '', "href" => "/web/eng/tableTennis", "auth" => "tableTennis"],
            ["name" => "BASEBALL", 'en_name' => '', "href" => "/web/eng/baseball", "auth" => "baseball"],
            ["name" => "BILLIARDS", 'en_name' => '', "href" => "/web/eng/billiards", "auth" => "billiards"],
        ]*/
    ]
);

/*array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'PIXELSCOPE',
        'name' => 'PIXELSCOPE', 'en_name' => '', "icon" => "icon-package", "href" => "#", "folder" => "product",
        "sub" => [
            ["name" => "Pixcelcast Pro", 'en_name' => '', "href" => "/web/eng/productPro", "auth" => "pro"],
            ["name" => "Pixcelcast Lite", 'en_name' => '', "href" => "/web/eng/productLite", "auth" => "lite"],
        ]
    ]
);*/

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'PIXELSCOPE',
        'name' => 'PIXELSCOPE', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/pixelscope", "folder" => "pixelscope",
    ]
);


/*array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'Company',
        'name' => 'Company', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/company", "folder" => "company",
    ]
);*/

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'NEWS',
        'name' => 'NEWS', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/news", "folder" => "news",
    ]
);

array_push($config['SITE_MENU']['eng'],
    [
        'title' => 'CONTACT',
        'name' => 'CONTACT', 'en_name' => '', "icon" => "icon-package", "href" => "/web/eng/contact", "folder" => "contact",
    ]
);

//국문메뉴
$config['SITE_MENU']['Main'] = [];

array_push($config['SITE_MENU']['Main'],
    [
        'title' => '홈',
        'name' => '홈', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor", "folder" => "",
    ]
);


array_push($config['SITE_MENU']['Main'],
    [
        'title' => '제품',
        'name' => '제품', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor/product", "folder" => "product",
    ]
);

array_push($config['SITE_MENU']['Main'],
    [
        'title' => '스포츠',
        'name' => '스포츠', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor/sports", "folder" => "sports",
    ]
);

array_push($config['SITE_MENU']['Main'],
    [
        'title' => 'PIXELSCOPE',
        'name' => 'PIXELSCOPE', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor/pixelscope", "folder" => "pixelscope",
    ]
);


array_push($config['SITE_MENU']['Main'],
    [
        'title' => '뉴스',
        'name' => '뉴스', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor/news", "folder" => "news",
    ]
);

array_push($config['SITE_MENU']['Main'],
    [
        'title' => '문의',
        'name' => '문의', 'en_name' => '', "icon" => "icon-package", "href" => "/web/kor/contact", "folder" => "contact",
    ]
);
?>