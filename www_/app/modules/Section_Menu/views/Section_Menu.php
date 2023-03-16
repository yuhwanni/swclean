<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?
                //print_r($_SERVER);
                $now_url  = $_SERVER['REQUEST_URI'];
                $arr_link = explode('?', $now_url);
                $now_link = isset($arr_link[0]) ? $arr_link[0] : "";

                $nv_cls = "";
                if($now_link != '') {
                    $arr_fld = explode('/', $now_link);
                    $nv_cls = $arr_fld[1];
                }

                $i = 0;
                foreach ($this->GP['nv'][LOC_TYPE] as $nv_title => $v) {
                    $nv_sub = $v[0];
                    $nv_icon = $v[1];
                    $nv_sub_exist = (!empty($nv_sub))? true : false;

                    $cls = "";
                    $cap = "";
                    if(in_array($now_link, $nv_sub) || (isset($M) && $M == $i)) {
                        $cls = "active";
                        $cap = "in";
                    }
                ?>
                    <li class="<?=$cls?>">
                        <a class="has-arrow waves-effect waves-dark <?=$cls?>" href="javascript:void(0)" aria-expanded="false">
                            <i class="fa <?=$nv_icon?>"></i>
                            <span class="hide-menu"><?=$nv_title?></span>
                        </a>
                        <?
                        if ($nv_sub_exist) {
                        ?>
                        <ul aria-expanded="false" class="collapse <?=$cap?>">
                            <?
                            $j = 0;
                            foreach ($nv_sub as $nv_sub_title => $nv_sub_link) {

                                $sub_cls = "";
                                if(strpos($now_link, $nv_sub_link) !== false || (isset($S) && $S == $j)) {
                                    $sub_cls = "active";
                                }
                            ?>
                            <li <?=$sub_cls?>><a href="<?=$nv_sub_link?>"  class="<?=$sub_cls?>"><?=$nv_sub_title?></a></li>
                            <?
                                $j++;
                            }
                            ?>
                        </ul>
                        <?
                        }
                        ?>
                    </li>

                <?
                    $i++;
                }
                ?>
            </ul>
        </nav>
    </div>
    <!-- End Sidebar scroll-->



