<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body { padding:0px; margin:0px; }
    </style>
</head>
<body>
<?php
if (isset($rst)) {
    if (is_array($rst)) foreach ($rst as $k => $v) ${$k} = $v;

    $css_img_height = $pop_height - 31;

    if ($pop_scroll == "Y") {
        $scrollbars = "scroll";
    } else {
        $scrollbars = "hidden";
    }

    if ($pop_type == "T") {
        $pop_str = $this->func->decContentsView($pop_contents);
        $pop_str = "<div style='width:${pop_width}px; height:${css_img_height}px; background-color:#CCC;'>" . $pop_str . "</div>";
    } else {
        $url = $this->GP['POPUP_IMG_URL'] . $pop_file;
        //이미지 클릭시 이동할 페이지
        if ($pop_link_url != "") {
            $pop_str = "<a href='" . $pop_link_url . "'><img src='${url}' border='0' class='pop_img'></a>";
        } else {
            $pop_str = "<img src='${url}' width='${pop_width}' height='${pop_height}' border=0>";
        }
    }
}

$mobile = 0;
$mobile_agent = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';

// preg_match() 함수를 이용해 모바일 기기로 접속하였는지 확인
if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
    $mobile = 1;
}
?>
<script src="/resource/global_assets/js/main/jquery.min.js"></script>
<script type="text/javascript" src="/resource/popup/jquery-ui.js"></script>
<script type="text/javascript">
    var getCookie = function (name) {
        var nameOfCookie = name + "=";
        var x = 0;
        while (x <= document.cookie.length) {
            var y = (x + nameOfCookie.length);
            if (document.cookie.substring(x, y) == nameOfCookie) {
                if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                    endOfCookie = document.cookie.length;
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf(" ", x) + 1;
            if (x == 0)
                break;
        }
        return;
    }

    var setCookie = function (name, value, expiredays) {
        var todayDate = new Date();
        todayDate.setDate(todayDate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
    }

    var move_page = function (page) {
        window.open(page, "_self");
    }

    function closeWin_<?=$pop_idx?>() {
        if (document.Pop_form_<?=$pop_idx?>.chkbox.checked)
            setCookie('popup_<?=$pop_idx?>', 'done', <?=$pop_idx?>);
        else
            setCookie('popup_<?=$pop_idx?>');

        document.getElementById('divpop_<?=$pop_idx?>').style.visibility = 'hidden';
    }
</script>
<?
if ($mobile == 0) {
?>
<div id="divpop_<?= $pop_idx ?>" style="width:<?= $pop_width + 0 ?>px; height:<?= $pop_height + 0 ?>px; z-index:9999; visibility: hidden; overflow:<?= $scrollbars ?>;">
    <?
    } else { //모바일
    ?>
    <div id="divpop_<?= $pop_idx ?>" style="position:fixed;top:50px;left:5%;right:5%; z-index:9999; visibility: hidden; overflow:<?= $scrollbars ?>;">
        <?
        }
        ?>
        <form name="Pop_form_<?= $pop_idx ?>">
            <?= $pop_str ?>
            <div style="height:30px;background:#000;font-size:14px; color:#FFFFFF;">
                <label style="float:left;padding:5px;"><input name="chkbox" type="checkbox" value="1" checked/> 이 창을 하루동안 열지 않습니다.</label>
                <a href="javascript:closeWin_<?= $pop_idx ?>();" style="float:right;padding:5px;color:#fff;font-weight:bold;">[닫기]</a>
            </div>
        </form>
    </div>
    <style type="text/css">
        <?
            if($mobile == 0) {
        ?>
        .pop_img {
            width: <?=$pop_width?>px;
            height: <?=$css_img_height?>px;
        }

        <? }else{?>
        .pop_img {
            width: 100%;
        }

        <? } ?>
    </style>
    <script type="text/javascript">
        if (getCookie('popup_<?=$pop_idx?>') != 'done') {
            document.getElementById('divpop_<?=$pop_idx?>').style.visibility = 'visible';
        }

        $(function () {
            $("#divpop_<?=$pop_idx?>").draggable();
        });
    </script>
</body>
</html>



