<!-- User menu -->
<div class="sidebar-section sidebar-user my-1">
    <div class="sidebar-section-body">
        <div class="media">
            <a href="#" class="mr-3">
                <img src="/resource/global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="">
            </a>

            <div class="media-body">
                <? if (isset($_SESSION['sess_adm']['sess_name'])) {  ?>
                    <div class="font-weight-semibold"><?= $_SESSION['sess_adm']['sess_name'] ?></div>
                    <div class="font-size-sm line-height-sm opacity-50">
                        LOGIN ID : <?= $_SESSION['sess_adm']['sess_id'] ?>
                    </div>
                <? } ?>
            </div>

            <div class="ml-3 align-self-center">
                <button type="button"
                        class="btn btn-outline-light text-body border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="icon-transmission"></i>
                </button>

                <button type="button"
                        class="btn btn-outline-light text-body border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                    <i class="icon-cross2"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /user menu -->