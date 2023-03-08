<div role="main" class="main">
    <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse p-relative z-index-2 pt-5 m-0"
             style="background-image: url('<?=$image_bg?>'); background-size: cover; background-position:
             center; animation-duration: 750ms; animation-delay: 300ms; animation-fill-mode: forwards; min-height: 545px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle" style="padding: 8rem 0; background: #f7f7f7;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-8 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="/">홈</a></li>
                        <li class="text-color-primary"><a href="#">문의</a></li>
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">문의</h1>
                    <p class="font-weight-light opacity-7 pb-2 mb-4">
                        &nbsp;
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="elements" class="section section-height-2 border-0 p-relative z-index-3 mt-0 pt-0 mb-0" style="padding-bottom:0px !important;">

        <div class="container text-center py-1">
            <div class="row justify-content-center pb-md-0 mb-md-2">
                <div class="col-md-12 mb-md-5">
                    <h2 class="font-weight-bold text-9 mb-3" >TRACK EVERY MOMENT</h2>
                    <div class="py-0">
                        <img src="/web/img/sports/PIXELSCOPE_LOGO_2-02.png" style="width:240px">
                    </div>
                    <p class="custom-text-color-1 mt-3 color-inherit mb-0 pb-lg-2">
                        스포츠중계 자동화 플랫폼 개발 및 관련 스포츠 데이터 수집 딥러닝하여 서비스하는 스포츠 비전 전문 기업입니다. <br>
                        <a style="color:#0088cc;">
                            # 고속 카메라 기반 영상 수집 # 이미지 프로세싱 # 딥러닝 #<br>
                        </a>
                    <p class="text-center">Since 2018</p>
                    </p>
                </div>
            </div>
        </div>

        <div class="container py-2">
            <div class="row mb-2">
                <div class="col">
                    <h2 class="font-weight-bold text-7 mt-0 mb-0">Contact Us</h2>
                    <p class="mb-4">Feel free to ask for details, don't save any questions!</p>
                    <form class="contact-form-recaptcha-v3" action="?" name="frmQna" id="frmQna" method="POST">
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
                        <input type="hidden" name="mode" value="QNA_KOR" />
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2">이름</label>
                                <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control text-3 h-auto py-2" name="name" id="name" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label mb-1 text-2">이메일 주소</label>
                                <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control text-3 h-auto py-2" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label mb-1 text-2">제목</label>
                                <input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control text-3 h-auto py-2" name="subject" id="subject" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label mb-1 text-2">내용</label>
                                <textarea maxlength="5000" data-msg-required="Please enter your message." rows="5" class="form-control text-3 h-auto py-2" name="message" id="message" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <input type="submit" value="Send Message" class="btn btn-primary btn-modern" data-loading-text="Loading...">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
        <div id="googlemaps" class="google-map m-0 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300" style="height:450px;"></div>


    </section>

</div>


<?php ob_start(); print("\n"); ?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVCQdrZK78v8nxgyVGvluSEoRr3JNwPyY&callback=initMap&region=kr"></script>

<script>
    var map;

    function initMap() {
        var seoul = { lat: 37.46581164606588 ,lng: 126.88877082524508 };
        map = new google.maps.Map( document.getElementById('googlemaps'), {
            zoom: 15,
            center: seoul
        });

        new google.maps.Marker({
            position: seoul,
            map: map,
            label: "PIXELCAST"
        });
    }

    $(document).ready(function(){
        $("#frmQna").submit(function(e) {
            e.preventDefault();
        }).validate({
            errorClass: "validate-error",
            rules: {
                name: {required: true },
                email: { required: true, email:true },
                subject: {required: true },
                message: {required: true },
            },
            messages: {
                name: { required: "이름을 입력해 주세요"},
                email: { required: "이메일을 입력해 주세요", email: "올바른 이메일을 입력하세요"},
                subject: { required: "제목을 입력해 주세요"},
                message: { required: "내용을 입력해 주세요"},
            },
            errorPlacement: function(error, element) {
                console.log(element.attr("id"));
                if ($('#' + element.attr('id') + '_error').length > 0) {
                    $('#' + element.attr('id') + '_error').text(error.text());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(e){
                ajaxProcess ({url:'/web/kor/act_proc', form_id:'frmQna', func:'commonRst'});
                return false;
            }
        });
    });

</script>
<?php $this->buffer_script = ob_get_contents(); ob_end_clean(); ?>