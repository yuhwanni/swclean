<?php
$mobile = 0;
$mobile_agent = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';

// preg_match() 함수를 이용해 모바일 기기로 접속하였는지 확인
if (preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])) {
    $mobile = 1;
}

if (!empty($popup_data)) {
    ?>
    <!--<script src="/resource/global_assets/js/main/jquery.min.js"></script>-->
    <script src="/resource/popup/jquery-ui.js"></script>
    <?php
    $rst = $popup_data;
    for ($i = 0; $i < count($rst); $i++) {
        $pop_idx = $rst[$i]['pop_idx'];
        $pop_type = $rst[$i]['pop_type'];
        $pop_contents = $rst[$i]['pop_contents'];
        $pop_file = $rst[$i]['pop_file'];
        $pop_width = $rst[$i]['pop_width'];
        $pop_height = $rst[$i]['pop_height'];
        $pop_link_url = $rst[$i]['pop_link_url'];
        $pop_x_position = $rst[$i]['pop_x_position'];
        $pop_y_position = $rst[$i]['pop_y_position'];

        $css_img_height = $pop_height - 31;

        if ($rst[$i]['pop_scroll'] == "Y") {
            $scrollbars = "scroll";
        } else {
            $scrollbars = "hidden";
        }

        //Text OR Image
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
        ?>
        <script>
            function closeWin_<?=$pop_idx?>() {
                if (document.Pop_form_<?=$pop_idx?>.chkbox.checked)
                    setCookie('popup_<?=$pop_idx?>', 'done', <?=$pop_idx?>);
                else
                    setCookie('popup_<?=$pop_idx?>');

                $('#divpop_<?=$pop_idx?>').hide();
            }
        </script>
        <?
        if ($mobile == 0) {
        ?>
            <div id="divpop_<?= $pop_idx ?>" style="width:<?= $pop_width ?>px; height:<?= $pop_height ?>px; position:absolute; left:<?= $pop_x_position ?>px; top:<?= $pop_y_position ?>px; z-index:9999; display: none; overflow:<?= $scrollbars ?>;">
        <?
        }else{ //모바일
        ?>
            <div id="divpop_<?= $pop_idx ?>" style="position:fixed;top:50px;left:5%;right:5%; z-index:9999; display: none; overflow:<?= $scrollbars ?>;">
        <?
        }
        ?>
                <form name="Pop_form_<?= $pop_idx ?>">
                    <?= $pop_str ?>
                    <div style="height:30px;background:#000;font-size:14px; color:#FFFFFF;">
                        <label style="float:left;padding:5px;"><input name="chkbox" type="checkbox" value="1" /> 이 창을 하루동안 열지 않습니다.</label>
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
            <script>
                if (getCookie('popup_<?=$pop_idx?>') != 'done') {
                    $('#divpop_<?=$pop_idx?>').show();
                }

                $(function () {
                    $("#divpop_<?=$pop_idx?>").draggable();
                });
            </script>
        <?php
    }
}
?>