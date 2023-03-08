<?
$bd_content = "";
if(isset($news_data)) {
    if (is_array($news_data)) foreach ($news_data as $k => $v) ${$k} = $v;

    $bd_content = $this->func->decContentsEdit($bd_content);
}
?>
<div role="main" class="main">
    <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse p-relative z-index-2 pt-5 m-0"
             style="background-image: url('<?=$image_bg?>'); background-size: cover; background-position:
             center; animation-duration: 750ms; animation-delay: 300ms; animation-fill-mode: forwards; min-height: 545px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle" style="padding: 8rem 0; background: #f7f7f7;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="/">Home</a></li>
                        <li class="text-color-primary"><a href="#">PIXELCAST NEWS</a></li>
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">PIXELCAST NEWS</h1>
                    <p class="font-weight-light opacity-7 pb-2 mb-4">&nbsp;</p>
                </div>
            </div>
        </div>
    </section>

    <section id="elements" class="section section-height-2 border-0 p-relative z-index-3 mt-0 pt-0 mb-0" style="padding-bottom:0px !important;">

        <?
        //썸네일 원본 이미지
        $img_link = $this->func->getImageMainShow(['fld'=>$this->GP['NEWS_IMG_DIR'],'img'=>$bd_thumb]);
        $img_src = "";
        if($img_link == '::NO IMAGE::') {
            $img_src = $img_link;
        } else {
            $img_src =  "<img src='" . $img_link . "' style='' class='img-fluid img-thumbnail img-thumbnail-no-borders rounded-0' />";
        }

        $bd_regdate = isset($bd_regdate) ? $bd_regdate : "";
        $bd_regdate1 = date('M', strtotime($bd_regdate));
        $bd_regdate2 = date('d', strtotime($bd_regdate));
        ?>

        <div class="container py-1">
            <div class="row">
                <h2 class="font-weight-normal text-7" style="margin:0px"><strong class="">PIXELCAST NEWS</strong></h2>
                <hr class="solid my-3">
                <div class="col-lg-12">
                    <div class="blog-posts">
                        <article class="post post-large">
                            <div class="post-date">
                                <span class="day"><?=$bd_regdate2?></span>
                                <span class="month"><?=$bd_regdate1?></span>
                            </div>
                            <div class="post-content news_content">
                                <h2 class="font-weight-semibold text-6 line-height-3 mb-3">
                                    <a href="javascript:void(0);"><?=$bd_subject?></a>
                                </h2>
                                <!--<div class="post-image mt-5">
                                    <a href="javascript:void(0);"><?/*=$img_src*/?></a>
                                </div>-->
                                <?=$bd_content?>
                                <div class="post-meta">
                                    <span><i class="far fa-user"></i> By <a href="#"><?=$bd_writer?></a> </span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>

    </section>


</div>