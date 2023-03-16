<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark navbar-static">
    <div class="d-flex flex-1 d-lg-none">

        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
        <a href="/adm" class="d-inline-block">
            <span style="color:#fff; font-size:21px; ">PIXELCAST</span>
            <img src="/resource/global_assets/images/logo_icon_light.png" class="d-sm-none" alt="">
        </a>
    </div>

    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar-mobile">

    </div>

    <ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">


        <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100" data-toggle="dropdown">
                <img src="/resource/global_assets/images/placeholders/placeholder.jpg" class="rounded-pill" height="34" alt="">

                <? if (isset($_SESSION['sess_adm']['sess_name'])) {  ?>
                    <span class="d-none d-lg-inline-block ml-2"><?= $_SESSION['sess_adm']['sess_name'] ?></span>
                <? } ?>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <!--<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My Page</a>
                <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Setting</a>-->
                <a href="/adm/auth/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
            </div>
        </li>
    </ul>
</div>
<!-- /main navbar -->