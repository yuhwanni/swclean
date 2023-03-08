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
        <div class="container py-1">
            <div class="row">

                <h2 class="font-weight-normal text-7" style="margin:0px"><strong class="">PIXELCAST NEWS</strong></h2>
                <hr class="solid my-3">

                <div class="col-lg-12">
                    <div class="blog-posts">

                        <?
                        if ($L_list_cnt > 0) {
                            for ($i = 0; $i < $L_list_cnt; $i++) {
                                $bd_idx = $L_list[$i]['bd_idx'];
                                $bd_thumb = $L_list[$i]['bd_thumb'];
                                $bd_subject = $L_list[$i]['bd_subject'];
                                $bd_writer = $L_list[$i]['bd_writer'];
                                $bd_regdate = $L_list[$i]['bd_regdate'];
                                $bd_regdate = date('M d , Y', strtotime($bd_regdate));

                                $img_link = $this->func->getImageMainShow(['fld'=>$this->GP['NEWS_IMG_DIR'],'img'=>$bd_thumb]);
                                $img_src = "";
                                if($img_link == '::NO IMAGE::') {
                                    $img_src = $img_link;
                                } else {
                                    $img_src =  "<img src='" . $img_link . "' style='max-width:420px;' class='img-fluid img-thumbnail img-thumbnail-no-borders rounded-0' />";
                                }

                                $bd_content = $L_list[$i]['bd_content'];
                                $bd_content = $this->func->decContentsView($bd_content);
                                $bd_content = $this->func->noImageTags($bd_content);
                                $bd_content = strip_tags($bd_content);

                                $bd_content = $this->func->utf8CutKr($bd_content, 0, 280);
                        ?>
                            <article class="post post-medium">
                                <div class="row mb-3">
                                    <div class="col-lg-5">
                                        <div class="post-image">
                                            <a href="/web/eng/news_view?bd_idx=<?=$bd_idx?>">
                                                <!--<img src="#" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="" />-->
                                                <?=$img_src?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="post-content">
                                            <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2">
                                                <a href="/web/eng/news_view?bd_idx=<?=$bd_idx?>"><?=$bd_subject?></a>
                                            </h2>
                                            <p class="mb-0">
                                                <?=$bd_content?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="post-meta">
                                            <span><i class="far fa-calendar-alt"></i> <?=$bd_regdate?> </span>
                                            <span><i class="far fa-user"></i> By <a href="#"><?=$bd_writer?></a> </span>
                                            <span class="d-block d-sm-inline-block float-sm-end mt-3 mt-sm-0">
                                                <a href="/web/eng/news_view?bd_idx=<?=$bd_idx?>" class="btn btn-xs btn-light text-1 text-uppercase">Read More</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?
                            }
                        } else {
                            echo "<div class='align-middle text-center' style='min-height:250px; line-height: 200px'>NO DATA</div>";
                        }
                        ?>

                        <?= $page_link ?>
                    </div>
                </div>

            </div>
        </div>
    </section>


</div>