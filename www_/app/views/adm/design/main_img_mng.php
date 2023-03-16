<?
if(isset($rst)) {
    if (is_array($rst)) foreach ($rst as $k => $v) ${$k} = $v;
}else {
    $mi_show = "N";
    $mi_type = "1";
}
?>
<div class="row">
    <div class="col-lg-8">

        <!-- Basic layout-->
        <div class="card">
            <form name="frmMem" id="frmMem" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <input type="hidden" name="mode" id="mode" value="<?= isset($mode) ? $mode : "" ?>" />
                <input type="hidden" name="mi_idx" value="<?= isset($mi_idx) ? $mi_idx : "" ?>" />
                <input type="hidden" name="mi_img_old" value="<?= isset($mi_img) ? $mi_img : "" ?>">

                <div class="card-body">
                    <h5 class="card-title text-success mt-1">메인 등록관리</h5>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">제목</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control border-dark" placeholder="타이틀_1" name="mi_title_1" id="mi_title_1" value="<?= isset($mi_title_1) ? $mi_title_1 : "" ?>">
                        </div>
                    </div>
                    <!--<div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">타이틀_2</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control border-dark" placeholder="타이틀_2" name="mi_title_2" id="mi_title_2" value="<?/*= isset($mi_title_2) ? $mi_title_2 : "" */?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">타이틀_3</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control border-dark" placeholder="타이틀_3" name="mi_title_3" id="mi_title_3" value="<?/*= isset($mi_title_3) ? $mi_title_3 : "" */?>">
                        </div>
                    </div>-->
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">LINK</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control border-dark" placeholder="LINK" name="mi_link" id="mi_link" value="<?= isset($mi_link) ? $mi_link : "" ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">타입</label>
                        <div class="col-lg-10 mt-2">
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="mi_type" value="1" <?= ($mi_type == "1") ? "checked" : "" ?>>
                                <span class="custom-control-label">메인영상</span>
                            </label>
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="mi_type" value="2" <?= ($mi_type == "2") ? "checked" : "" ?>>
                                <span class="custom-control-label">메인 Youtube URL </span>
                            </label>
                            <!--<label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="mi_type" value="3" <?/*= ($mi_type == "3") ? "checked" : "" */?>>
                                <span class="custom-control-label">우측 상단페이드형</span>
                            </label>-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">노출여부</label>
                        <div class="col-lg-10 mt-2">
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="mi_show" value="Y" <?= ($mi_show == "Y") ? "checked" : "" ?>>
                                <span class="custom-control-label">노출</span>
                            </label>
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="mi_show" value="N" <?= ($mi_show == "N") ? "checked" : "" ?>>
                                <span class="custom-control-label">미노출</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">영상</label>
                        <div class="col-lg-10">
                            <label class="custom-file">
                                <input type="file" class="custom-file-input" name="mi_img" id="mi_img">
                                <span class="custom-file-label">Choose file</span>
                            </label>
                            <p class="text-primary mt-1">* mp4파일만 허용가능합니다.</p>
                            <?php
                            if (isset($mi_img) && !empty($mi_img)) {
                            ?>
                            <div class="row mt-1">
                                <div class="col-lg-6">
                                    <?= $mi_img ?>
                                </div>
                                <div class="col-lg-6">
                                    <!--<button type="button" class="btn btn-secondary btn-sm" onclick="fn_img_view('<?/*= $mi_img */?>')">상세보기
                                    </button>-->
                                    <button type="button" class="btn btn-info btn-sm" onclick="fn_img_view('<?= $mi_img ?>')">바로보기</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="fn_img_del('<?= $mi_img ?>','<?= $mi_idx ?>')">
                                        삭제
                                    </button>
                                </div>
                            </div>
                            <?
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">저장하기</button>
                        <button type="button" class="btn btn-secondary cancel">돌아가기</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
    <!-- /basic layout -->

</div>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>

    $(document).ready(function () {

        $('.cancel').click(function () {
            location.href = "main_img_list";
        })

        $("#frmMem").submit(function(e) {
            e.preventDefault();
        }).validate({
            errorClass: "validate-error",
            rules: {
                mi_title_1: {required: true },
                mi_link: {required: true },
                <?/* if(!isset($mi_img)) {*/?>/*
                mi_img: { required: true }
                */<?/* } */?>
            },
            messages: {
                mi_title_1: { required: "타이틀_1을 입력해 주세요"},
                mi_link: { required: "이동 링크를 입력해 주세요"},
                <?/* if(!isset($mi_img)) {*/?>/*
                mi_img: { required: "이미지를 선택해 주세요"}
                */<?/* } */?>
            },
            errorPlacement: function(error, element) {
                console.log(element.attr("id"));
                if ($('#' + element.attr('id') + '_error').length > 0) {
                    $('#' + element.attr('id') + '_error').text(error.text());
                } else if  (element.attr("id").indexOf("gm_target") !== -1 || element.attr("id").indexOf("gm_target") !== -1){
                    //error.insertAfter(element.parent().parent().find(".errmsg"));
                    element.parent().parent().find(".errmsg").text(error.text());
                } else if  (element.attr("id") == "gm_join_s" || element.attr("id") == "gm_join_e" || element.attr("id") == "gm_time_s"|| element.attr("id") == "gm_time_e"){
                    element.parent().parent().find(".errmsg").text(error.text());
                }else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(e){
                ajaxProcess ({url:'act_proc', form_id:'frmMem', fileup:1, func:'commonRst'});
                return false;
            }
        });
    });

    var fn_img_view = function(photo) {
        funcModalOpen("popupImage", {mode: '', "<?=$csrf['name']?>":"<?=$csrf['hash']?>" , "file_nm" : photo }, 'I', 'POST', 'modal-content');
        return false;
    };

    var fn_img_down = function(photo) {
        alert(photo); return;
        location.href = "getImageDown/?file_nm="+photo;
    };

    //이미지 개별삭제
    var del_photo = "";
    var del_id = "";
    var fn_img_del = function(photo, id) {
        del_photo = photo;
        del_id = id;
        confirmMsg ("삭제 하시겠습니까?", "imgDeletCallback");
    };

    var imgDeletCallback = function(rst) {
        if(rst) {
            var frm_data = "<?=$csrf['name']?>=<?=$csrf['hash']?>&mode=MAIN_IMG_DEL&del_photo="+del_photo+"&del_id="+del_id;
            ajaxProcess ({url:'act_proc',data:frm_data, func:'commonRst'});
        }
    };
</script>