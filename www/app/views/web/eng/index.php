<?
$main_mov = "";
$youtube_url = "";
foreach ($main_img_list as $v) {
    if($v['mi_type'] == "1") {
        $main_mov = $this->GP['MAIN_IMG_URL'] . "" . $v['mi_img'];
    }
    if($v['mi_type'] == "2") {
        $youtube_url = $v['mi_link'];
    }
}
?>
<div role="main" class="main">

    <section class="section border-0 video overlay overlay-show overlay-op-8 m-0" data-video-path="<?=$main_mov?>"
             data-plugin-video-background data-plugin-options="{'posterType': 'jpg', 'position': '50% 50%'}" style="height: 100vh;">
        <div class="container position-relative z-index-3 h-100">
            <div class="row align-items-center h-100">
                <div class="col">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <h1 class="text-color-light font-weight-extra-bold text-12 line-height-1 mb-2 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="1000" data-plugin-options="{'minWindowWidth': 0}">
                            PIXELCAST
                        </h1>
                        <p class="text-4 text-color-light font-weight-light opacity-7 mb-0" data-plugin-animated-letters data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0}">
                            We help you reduce the cost of live production but improve the quality of the output
                        </p>
                    </div>
                </div>
            </div>
            <a href="#main" class="slider-scroll-button position-absolute bottom-10 left-50pct transform3dx-n50" data-hash data-hash-offset="0" data-hash-offset-lg="80">Sroll To Bottom</a>
        </div>
    </section>

    <section id="intro" class="section section-no-border section-angled bg-light pt-5 pb-5 m-0">
        <div class="container text-center py-5 mb-1">
            <div class="row justify-content-center text-center mb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                <div class="col-lg-12">
                    <h2 class="font-weight-bold mb-3" style="font-size:3.5rem">PIXELCAST</h2>
                    <p class="opacity-9 text-4 mt-5">
                        Pixelcast provides AI-based Automated Live Sports Broadcasting Production using high-speed cameras, <br>image processing, and deep learning technology. <br>
                        Pixelcast software senses with its unique awareness technology and enables "video production" without support from skilled staff intervention.<br>
                        PixelScope's software tracks ball trajectory and players in real-time in 3D and collects various kinds of information during gameplay.<br>
                        This can provide diverse game data content for fans and viewers.<br>
                        With PixelScope, anyone can produce high-quality sports broadcasting content easier, faster, and cheaper!
                    </p>
                    <div class="row mt-3 pt-5">
                        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                            <div class="card">
                                <div class="position-relative clearfix border " data-remove-min-height style="">
                                    <video id="presentation1" class="float-start" width="100%" height="100%" muted loop preload="metadata" >
                                        <source src="/web/movie/main_01.mp4" type="video/mp4">
                                    </video>
                                    <a href="#" class="position-absolute top-50pct left-50pct transform3dxy-n50 bg-light rounded-circle d-flex align-items-center justify-content-center text-decoration-none bg-color-hover-primary text-color-hover-light play-button-lg pulseAnim pulseAnimAnimated"
                                       data-trigger-play-video="#presentation1" data-trigger-play-video-remove="yes">
                                        <i class="fas fa-play text-5"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-dark">Unmanned auto-broadcasting controlled by AI software
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                            <div class="card">
                                <div class="position-relative clearfix border " data-remove-min-height style="">
                                    <video id="presentation2" class="float-start" width="100%" height="100%" muted loop preload="metadata" >
                                        <source src="/web/movie/main_02.mp4" type="video/mp4">
                                    </video>
                                    <a href="#" class="position-absolute top-50pct left-50pct transform3dxy-n50 bg-light rounded-circle d-flex align-items-center justify-content-center text-decoration-none bg-color-hover-primary text-color-hover-light play-button-lg pulseAnim pulseAnimAnimated"
                                       data-trigger-play-video="#presentation2" data-trigger-play-video-remove="yes">
                                        <i class="fas fa-play text-5"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-dark">Real-time analysis of ball and players data </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                            <div class="card">
                                <div class="position-relative clearfix border " data-remove-min-height style="">
                                    <video id="presentation3" class="float-start" width="100%" height="100%" muted loop preload="metadata" >
                                        <source src="/web/movie/main_03.mp4" type="video/mp4">
                                    </video>
                                    <a href="#" class="position-absolute top-50pct left-50pct transform3dxy-n50 bg-light rounded-circle d-flex align-items-center justify-content-center text-decoration-none bg-color-hover-primary text-color-hover-light play-button-lg pulseAnim pulseAnimAnimated"
                                       data-trigger-play-video="#presentation3" data-trigger-play-video-remove="yes">
                                        <i class="fas fa-play text-5"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-dark">Various contents and VAR with real time data</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-border section-angled section-dark pb-0 m-0" style="background-repeat: no-repeat; background-color: #132948 !important">
        <div class="spacer py-md-4 my-md-4"></div>
        <div class="container pt-0 mt-0">
            <div class="container py-5">

                <div class="row text-center">
                    <div class="col">
                        <h2 class="font-weight-normal text-12 mt-4">PIXELCAST <strong class="font-weight-extra-bold">SYSTEM</strong></h2>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col pb-1">
                        <div class="container row" style="float: none; margin:100 auto;">
                            <div class="col-md-10" style="float: none; margin:0 auto;">
                                <div class="position-relative border-width-10 border-color-light clearfix border border-radius" data-remove-min-height style="">
                                    <video id="presentation" class="float-start" width="100%" height="100%" muted playsinline loop preload="metadata">
                                        <source src="/web/movie/1_ai.mp4" type="video/mp4">
                                    </video>
                                    <a href="#" class="position-absolute top-50pct left-50pct transform3dxy-n50 bg-light rounded-circle d-flex align-items-center justify-content-center text-decoration-none bg-color-hover-primary text-color-hover-light play-button-lg pulseAnim pulseAnimAnimated" data-trigger-play-video="#presentation" data-trigger-play-video-remove="yes">
                                        <i class="fas fa-play text-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr class="solid my-5">
                        <div class="row mt-3 pt-0">
                            <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/main_system01.jpg" alt="System">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/main_system02.jpg" alt="System">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/main_system03.jpg" alt="System">
                                </div>
                            </div>
                        </div>
                        <p class="opacity-9 text-4 mt-3 text-center">
                            Pixelcast does not require complicated broadcasting equipment, cameramen, and <br>staff, and broadcasts live with just one man.<br>
                            Pixelcast automatically broadcasts the game with AI algorithm technology that is a </br>patent-pending.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-border section-angled bg-color-light-scale-1 m-0">
        <div class="section-angled-layer-top section-angled-layer-increase-angle" style="padding: 5rem 0; background-color: #132948;"></div>
        <div class="container py-5 my-5" style="">
            <div class="container py-2 mt-5">
                <div class="row text-center">
                    <div class="col">
                        <h2 class="font-weight-normal text-12 mt-4">GAME DATA <strong class="font-weight-extra-bold">CONTENT</strong></h2>
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col pb-1">
                        <hr class="solid my-3">
                        <div class="row mt-0 pt-3">
                            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/data_content01.jpg" alt="DATA CONTENT">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/data_content02.jpg" alt="DATA CONTENT">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-0 pt-3">
                            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/data_content03.jpg" alt="DATA CONTENT">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;">
                                <div class="card">
                                    <img class="card-img-top" src="/web/img/main/data_content04.jpg" alt="DATA CONTENT">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--<section class="section border-0 section-dark section-angled section-angled-reverse section-funnel m-0 position-relative overflow-visible lazyload" style="background-image: url(img/lazy.png); background-size: 100%; background-position: top; background-repeat: no-repeat;" data-bg-src="img/landing/porto_performance_bg.png">
        <div class="section-angled-layer-top section-angled-layer-increase-angle" style="padding: 5rem 0; background-color: #22252a;"></div>
        <div class="container text-center py-3 mb-1">
            <div class="row text-center">
                <div class="col">
                    <h2 class="font-weight-normal text-12 mt-4">PIXELCAST <strong class="font-weight-extra-bold px-main-line-up">LINE UP</strong></h2>
                </div>
            </div>
            <article class="post post-medium mt-4">
                <div class="row mb-3">
                    <div class="col-lg-5">
                        <div class="post-image">
                            <a href="javascript:void(0);">
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
                                Pixelcast Pro can produce broadcasting at the level of professional sports broadcasts.<br>
                                It also enables precise control and data acquisition.<br>
                                It automatically generates various contents and highlights such as game data during broadcasting.<br>
                                You can control multiple camera simultaneously regardless of the number of cameras
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="solid my-3">
                <div class="row mb-3">
                    <div class="col-lg-5">
                        <div class="post-image">
                            <a href="javascript:void(0);">
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
                                It can be used by amateur leagues, clubs, and individuals that do not need sports broadcasting at the level
                                of professional sports.<br>
                                It is a system that is significantly lighter than the Pixelcast Pro.<br>
                                Filming and broadcasting with personal mobile and acquiring data.<br>
                                Controlling one or the least number of cameras.
                            </p>
                        </div>
                    </div>
                </div>

            </article>

        </div>
    </section>-->

    <section id="review" class="section section-angled bg-light border-0 m-0 position-relative pt-0">
        <div class="container pb-5 mb-3">
            <div class="container">
                <div class="row text-center mt-5">
                    <div class="col">
                        <h2 class="font-weight-normal text-12 mt-4">CUSTOMER <strong class="font-weight-extra-bold">REVIEWS</strong></h2>
                    </div>
                </div>
                <!-- Step2 -->
                <div id="projects" class="container">

                    <div class="row pb-5 mb-5 mt-5">
                        <div class="col">
                            <div class="appear-animation popup-gallery-ajax" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                                <div class="owl-carousel owl-theme mb-0" data-plugin-options="{'items': 4, 'margin': 35, 'loop': false}">
                                    <?php
                                    for($i=0; $i<=5; $i++) {
                                        ?>
                                        <div class="col-sm-6 col-lg-12 mb-4 mb-lg-0">
                                        <span class="thumb-info thumb-info-hide-wrapper-bg thumb-info-no-zoom">
                                            <span class="thumb-info-wrapper">
                                                <a href="about-me.html">
                                                    <img src="img/team/team-1.jpg" class="img-fluid" alt="">
                                                </a>
                                            </span>
                                            <span class="thumb-info-caption">
                                                <h3 class="font-weight-extra-bold text-color-dark text-4 line-height-1 mt-3 mb-0">YUHWANNI</h3>
                                                <span class="text-2 mb-0">CEO</span>
                                                <span class="thumb-info-caption-text pt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac ligula mi, non suscipitaccumsan</span>
                                                <span class="thumb-info-social-icons">
                                                    <a target="_blank" href="https://www.facebook.com"><i
                                                                class="fab fa-facebook-f"></i><span>Facebook</span></a>
                                                    <a href="https://www.twitter.com"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                                                    <a href="http://www.linkedin.com"><i
                                                                class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
                                                </span>
                                            </span>
                                        </span>
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step2 -->
            </div>
        </div>

    </section>

</div>

<?php ob_start();
print("\n"); ?>
<?php $this->load->view('/web/eng/popup_layer', $this->data); ?>
<?php $this->buffer_script = ob_get_contents();
ob_end_clean(); ?>