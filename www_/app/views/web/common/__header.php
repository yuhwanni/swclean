<?php  if(!empty(SUB_FOLDER)) { ?>
<style>
#header { background:#34373b !important; }
#header .header-body {
    background: #24252a !important;
    border-bottom: 0px solid #504444 !important;
}
#header .header-nav-features .header-nav-features-dropdown {
    min-width: 135px; margin-right: -64px;
}
.page-header .container { margin-top:75px }
</style>
<? } ?>
<header id="header" class="header-transparent header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
    <div class="header-body border-top-0 bg-dark box-shadow-none">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="/web/<?=FOLDER?>">
                                <img class="hlogs" alt="Porto" src="/web/img/top_log.png">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row">
                        <div class="header-nav header-nav-links header-nav-dropdowns-dark header-nav-light-text order-2 order-lg-1">
                            <div class="header-nav-main header-nav-main-font-lg header-nav-main-font-lg-upper-2 header-nav-main-mobile-dark header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                <nav class="collapse">
                                    <ul class="nav nav-pills" id="mainNav">
                                        <?php  foreach (TOP_MENU as $k => $v) { ?>
                                            <li class="dropdown">
                                                <a class="dropdown-item dropdown-toggle <?=SUB_FOLDER == $v['folder'] ? "active" : ""?> " href="<?=$v['href']?>">
                                                    <?=$v['name']?>
                                                </a>
                                                <?
                                                if(isset($v['sub']) && count($v['sub']) > 0) {
                                                    ?>
                                                    <ul class="dropdown-menu" style="margin:-24px 0 0 13px">
                                                        <?php  foreach ($v['sub'] as $k1 => $v1) { ?>
                                                            <li class="">
                                                                <a class="dropdown-item" href="<?=$v1['href']?>"><?=$v1['name']?></a>
                                                            </li>
                                                        <? } ?>
                                                    </ul>
                                                    <?
                                                }
                                                ?>
                                            </li>
                                        <? } ?>
                                    </ul>
                                </nav>
                            </div>
                            <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        <div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-1">
                            <div class="header-nav-feature header-nav-features-search d-inline-flex">
                                <a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch">
                                    <?=FOLDER == "kor" ? "Korea" : "English"?>
                                    <i class="fas fa-angle-down"></i>
                                </a>
                                <div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed" id="headerTopSearchDropdown">
                                    <div>
                                        <a class="dropdown-item <?=FOLDER == "eng" ? "active" : ""?>" href="/web/eng">English</a>
                                    </div>
                                    <div>
                                        <a class="dropdown-item <?=FOLDER == "kor" ? "active" : ""?>" href="/web/kor">Korea</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>