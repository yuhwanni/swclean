<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<div class="side-mini-panel">
    <ul class="mini-nav">
        <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>
        <?
        //print_r($_SERVER);
        $now_url = $_SERVER['REQUEST_URI'];
        $arr_link = explode('?', $now_url);
        $now_link = isset($arr_link[0]) ? $arr_link[0] : "";

        $nv_cls = "";
        if ($now_link != '') {
            $arr_fld = explode('/', $now_link);
            $nv_cls = $arr_fld[1];
        }

        $i = 0;
        foreach ($this->GP['nv'][LOC_TYPE] as $nv_title => $v) {
            $nv_sub = $v[0];

            if(isset($v[1]) && is_array($v[1])) {
                $nv_icon = $v[1][0][0];
                $nv_memo = "ARRAY";
            } else {
                $nv_icon = $v[1];
                $nv_memo = isset($v[2]) ? $v[2] : "";
            }

            $nv_sub_exist = (!empty($nv_sub)) ? true : false;

            $cls = "";
            $cap = "";
            if (in_array($now_link, $nv_sub) || (isset($M) && $M == $i)) {
                $cls = "selected";
                $cap = "active";
            }
            ?>
            <li class="<?= $cls ?>">
                <a href="javascript:void(0)">
                    <!--                    <i class="--><?//=$nv_icon?><!--"></i>-->
                    <img src="<?= $nv_icon ?>" style="width:32px; height:32px;">
                </a>

                <div class="sidebarmenu">
                    <!-- Left navbar-header -->
                    <h3 class="menu-title"><?= $nv_title ?></h3>

                    <?
                    if ($nv_sub_exist) {
                        ?>
                        <ul class="sidebar-menu">
                            <?
                            $j = 0;
                            foreach ($nv_sub as $nv_sub_title => $nv_sub_link) {

                                $sub_cls = "";
                                if (strpos($now_link, $nv_sub_link) !== false || (isset($S) && $S == $j)) {
                                    $sub_cls = "active";
                                }
                                ?>
                                <li>
                                    <a href="<?= $nv_sub_link ?>" class="<?= $sub_cls ?>"><?= $nv_sub_title ?></a>
                                </li>
                                <?
                                if($nv_memo == "ARRAY") {
                                    $sub_arg_v = $v[1];
                                    print("
                                    <li style='width:100%; text-align: center'>
                                        <div style=''>
                                            <p>".$sub_arg_v[$j][1]."</p>
                                            <div style='width:100%; margin:auto; text-align:center'>
                                                <img src=".$sub_arg_v[$j][0]." style='width:128px; height:128px;'>
                                            </div>
                                        </div>
                                    </li>
                                    ");
                                }
                                $j++;
                            }
                            ?>

                            <? if($nv_memo != "ARRAY") { ?>
                            <li style="width:100%; text-align: center">
                                <div style="">
                                    <p><?=$nv_memo?></p>
                                    <div style="width:100%; margin:auto; text-align:center">
                                        <img src="<?= $nv_icon ?>" style="width:128px; height:128px;">
                                    </div>
                                </div>
                            </li>
                            <? } ?>
                        </ul>
                        <!-- Left navbar-header end -->
                        <?
                    }
                    ?>

                </div>
            </li>
            <?
            $i++;
        }
        ?>
</div>
</ul>
</div>