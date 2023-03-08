<ul class="nav nav-sidebar" data-nav-type="accordion">
    <?
    $now_link = str_replace("/index.php", "",$_SERVER['PHP_SELF']);
    $tmp_fld = explode("/", $now_link);
    $chk_fld = isset($tmp_fld[2]) ? $tmp_fld[2] : "";

    foreach ($this->GP['MENU'] as $k => $v) {

        if(isset($v['title'])) {
            echo '<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">'. $v['title'] .'</div><i class="'.$v['icon'].'" title="'. $v['title'] .'"></i></li>'. PHP_EOL;
        }

        if (isset($v['sub'])) {

            if($chk_fld == $v['folder']) {
                echo '<li class="nav-item nav-item-submenu nav-item-open"><a href="#" class="nav-link"><i class="' . $v['icon'] . '"></i> <span>' . $v['name'] . '</span></a>' . PHP_EOL;
            }else {
                echo '<li class="nav-item nav-item-submenu"><a href="#" class="nav-link"><i class="' . $v['icon'] . '"></i> <span>' . $v['name'] . '</span></a>' . PHP_EOL;
            }

            $line=0;
            $sub_str = "";
            foreach ($v['sub'] as $k2 => $v2) {

                $active_cls = "";
                if(!empty($v2['href'])) {
                    if (strpos($now_link, $v2['href']) !== false) {
                        $active_cls = "active";
                    }
                }

                if($line == 0) {
                    if($chk_fld == $v['folder']) {
                        $sub_str .= '<ul class="nav nav-group-sub" data-submenu-title="' . $v['name'] . '" style="display:block;">' . PHP_EOL;
                    }else {
                        $sub_str .= '<ul class="nav nav-group-sub" data-submenu-title="' . $v['name'] . '" >' . PHP_EOL;
                    }
                }

                $sub_str .= '<li class="nav-item"><a href="'. $v2['href'] .'" class="nav-link '. $active_cls . '">'.$v2['name'].'</a></li>'. PHP_EOL;

                $line++;
            }
            $sub_str .= "</ul>" . PHP_EOL;
            echo $sub_str;

            echo '</li>'. PHP_EOL;
        }else {
            echo '<li class="nav-item"><a href="'. $v['href'] .'" class="nav-link"><i class="'.$v['icon'].'"></i><span>'.$v['name'].'</span></a></li>'. PHP_EOL;
        }
    }
    ?>
</ul>