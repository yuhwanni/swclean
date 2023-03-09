<?
$main_mov = "";
$youtube_url = "";
foreach ($main_img_list as $v) {
    if($v['mi_type'] == "2") {
        $youtube_url = $v['mi_link'];
    }
}
?>

<style>
    html section.section-dark {
        background-color: #132948 !important;
        border-color: #132948 !important;
    }
</style>

<div role="main" class="main">
    <section
            class="section section-concept section-no-border section-dark section-angled section-angled-reverse p-relative z-index-2 pt-5 m-0"
            style="background-image: url('<?= $image_bg ?>'); background-size: cover; background-position:
                    center; animation-duration: 750ms; animation-delay: 300ms; animation-fill-mode: forwards; min-height: 545px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle"
             style="padding: 8rem 0; background: #ffffff;"></div>
        <div class="container pt-lg-5 mt-5" style="">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-8 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="/">Home</a></li>
                        <li class="text-color-primary"><a href="#">PRODUCT</a></li>
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">PRODUCT</h1>
                    <p class="font-weight-light opacity-7 pb-2 mb-4">
                        &nbsp;
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section id="intro" class="section section-no-border section-angled bg-light pt-0 pb-5 mb-4" style="margin-top: -100px !important; z-index:9999999">
        <div class="container text-center py-5 mb-1">
            <div class="row align-items-center py-5 appear-animation" data-appear-animation="fadeInRightShorter">
                <div class="col-md-6 pe-md-5 mb-1 mb-md-0">
                    <h2 class="font-weight-normal text-6 mb-3">
                        <strong class="font-weight-extra-bold" style="font-size:3.5rem">PIXELCAST</strong>
                    </h2>
                    <p class="text-5" style="font-size:1.5rem">
                        AI-based Automated Live Sports Production
                    </p>
                </div>
                <div class="col-md-6 px-5 px-md-3">
                    <div class="position-relative border-width-10 border-color-light2 clearfix border border-radius" data-remove-min-height style="">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="100%" height="280px" src="<?=$youtube_url?>" title="pixcel" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section border-0 section-dark section-angled section-angled-reverse section-funnel m-0 position-relative overflow-visible lazyload" style="background-image: url(img/lazy.png); background-size: 100%; background-position: top; background-repeat: no-repeat;" data-bg-src="img/landing/porto_performance_bg.png">
        <div class="section-angled-layer-top section-angled-layer-increase-angle" style="padding: 5rem 0; background-color: #132948;"></div>
        <div class="container text-center py-3 mb-1">
            <div class="row text-center mt-5 pb-3">
                <div class="col">
                    <h2 class="font-weight-normal text-12 mt-4">PIXELCAST <strong class="font-weight-extra-bold px-main-line-up">LINE UP</strong></h2>
                </div>
            </div>
            <article class="post post-medium mt-4 mb-5">
                <div class="row mb-3">
                    <div class="col-lg-5">
                        <div class="post-image">
                            <a href="https://www.youtube.com/channel/UCP0BZXdWJdEMRN_XUsd-oMQ/featured" target="_blank">
                                <img src="/web/img/main/pixcelcast_pro.jpg" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="post-content">
                            <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2 text-left">
                                <span style="color:#0088cc">PIXELCAST PRO</span>
                            </h2>
                            <p class="mb-0 text-left">
                                <a href="https://www.youtube.com/channel/UCP0BZXdWJdEMRN_XUsd-oMQ/featured" target="_blank" style="color:#fff">
                                    전문 스포츠 방송사 수준의 스포츠 중계 제작이 가능하며, 정밀한 제어와 데이터 획득을 할 수 있습니다. <br>
                                    중계 방송 중 게임 데이터 등 다양한 컨텐츠와 하이라이트를 자동으로 생성할 수 있습니다.<br>
                                    여러 대의 방송 중계 카메라를 동시에 제어가 가능하며, 카메라 수에 제한을 받지 않습니다.
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="solid my-3">
                <div class="row mb-3">
                    <div class="col-lg-5">
                        <div class="post-image">
                            <a href="https://www.youtube.com/channel/UCP0BZXdWJdEMRN_XUsd-oMQ/featured" target="_blank">
                                <img src="/web/img/main/pixcelcast_lite.jpg" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="post-content">
                            <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2 text-left">
                                <span style="color:#0088cc">PIXELCAST LITE</span>
                            </h2>
                            <p class="mb-0 text-left">
                                <a href="https://www.youtube.com/channel/UCP0BZXdWJdEMRN_XUsd-oMQ/featured" target="_blank" style="color:#fff">
                                    전문 스포츠 방송사 수준의 스포츠 중계가 필요하지 않은 아마추어 리그나 팀, 개인이 사용할 수 있으며, PIXELCAST PRO
                                    에 비해 대폭 경량화 된 시스템입니다. <br>
                                    개인이 가지고 있는 모바일에서 촬영 및 데이터를 취득하고, 이를 통해 중계를 할 수 있습니다. <br>
                                    한대 혹은 최소한의 카메라를 제어합니다.
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </article>

        </div>
    </section>


</div>