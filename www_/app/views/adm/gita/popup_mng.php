<?
$pop_contents = "";
$pop_type = "T";

if (isset($p_data)) {
    if (is_array($p_data)) foreach ($p_data as $k => $v) ${$k} = $v;

    $pop_contents = $this->func->decContentsEdit($pop_contents);
}
?>
    <div class="row">
        <div class="col-lg-9">
            <form name="frmPopup" id="frmPopup" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
                <input type="hidden" name="mode" id="mode" value="<?= isset($mode) ? $mode : "" ?>"/>
                <input type="hidden" name="pop_idx" id="pop_idx" value="<?= isset($pop_idx) ? $pop_idx : "" ?>"/>
                <input type="hidden" name="pop_file_old" id="pop_file_old" value="<?= isset($pop_file) ? $pop_file : "" ?>"/>
                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">팝업정보 입력</legend>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3">타이틀</label>
                                <div class="col-lg-9">
                                    <input type="text" name="pop_title" id="pop_title" class="form-control" data-popup="tooltip" data-trigger="focus" title="" placeholder="팝업제목" data-original-title="팝업제목 입력란입니다." value="<?= isset($pop_title) ? $pop_title : ""; ?>">
                                </div>
                            </div>
                            <hr class="dot"/>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3">형식</label>
                                <div class="col-lg-3 pt-2">
                                    <?=$pop_type_sel?>
                                </div>

                                <label class="col-form-label text-right col-lg-3">사용여부</label>
                                <div class="col-lg-3 pt-2">
                                    <?=$pop_use_sel?>
                                </div>
                            </div>
                            <hr class="dot"/>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3">게시기간</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control date border-dark" name="pop_start_date" id="pop_start_date" value="<?= isset($pop_start_date) ? $pop_start_date : "" ?>">
                                        <span class="input-group-prepend"><span class="input-group-text">~</span></span>
                                        <input type="text" class="form-control date border-dark" name="pop_end_date" id="pop_end_date" value="<?= isset($pop_end_date) ? $pop_end_date : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="dot"/>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3">위치(left X top)</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                    <input type="text" class="form-control  border-dark" name="pop_x_position" id="pop_x_position" value="<?= isset($pop_x_position) ? $pop_x_position : "" ?>">
                                    <span class="input-group-prepend"><span class="input-group-text">X</span></span>
                                    <input type="text" class="form-control  border-dark" name="pop_y_position" id="pop_y_position" value="<?= isset($pop_y_position) ? $pop_y_position : "" ?>">
                                    </div>
                                </div>

                                <label class="col-form-label text-right col-lg-3">크기(width X height)</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control  border-dark" name="pop_width" id="pop_width" value="<?= isset($pop_width) ? $pop_width : "" ?>">
                                        <span class="input-group-prepend"><span class="input-group-text">X</span></span>
                                        <input type="text" class="form-control  border-dark" name="pop_height" id="pop_height" value="<?= isset($pop_height) ? $pop_height : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="dot"/>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3">스크롤</label>
                                <div class="col-lg-3 pt-2">
                                    <?=$pop_scroll_sel?>
                                </div>

                                <label class="col-form-label text-right col-lg-3">오늘하루창</label>
                                <div class="col-lg-3 pt-2">
                                    <?=$pop_today_sel?>
                                </div>
                            </div>
                            <hr class="dot"/>

                            <div class="form-group row" id="div_img">
                                <label class="col-lg-3 col-form-label text-right  ">이미지</label>
                                <div class="col-lg-9">
                                    <label class="custom-file">
                                        <input type="file" class="custom-file-input" name="pop_file" id="pop_file">
                                        <span class="custom-file-label">Choose file</span>
                                    </label>
                                    <?php
                                    if(isset($pop_file) && !empty($pop_file)) {
                                        if($pop_file) {
                                            ?>
                                            <div class="row mt-1">
                                                <div class="col-lg-6">
                                                    <?= $pop_file ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                            onclick="fn_img_view('<?= $pop_file ?>')">상세보기
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-sm"
                                                            onclick="fn_img_down('<?= $pop_file ?>')">다운로드
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="fn_img_del('<?= $pop_file ?>','<?= $pop_idx ?>')">
                                                        삭제
                                                    </button>
                                                </div>
                                            </div>
                                            <?
                                        }
                                    }
                                    ?>
                                </div>

                                <label class="col-form-label text-right col-lg-3 ">클릭시 이동페이지</label>
                                <div class="col-lg-9 mt-1">
                                    <input type="text" name="pop_link_url" id="pop_link_url" class="form-control" data-popup="tooltip" data-trigger="focus" title="" placeholder="클릭시 이동할 페이지" data-original-title="클릭시 이동할 페이지" value="<?= isset($pop_link_url) ? $pop_link_url : ""; ?>">
                                </div>
                            </div>

                            <div class="form-group row" id="div_con">
                                <label class="col-form-label text-right col-lg-3">내용</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="pop_contents" id="pop_contents" style="width:100%; height:420px;"><?= $pop_contents ?></textarea>
                                </div>
                            </div>
                            <hr class="dot"/>

                        </fieldset>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btn_submit"><?=$btn_txt?> <i class="icon-pencil4 ml-1"></i></button>
                            <button type="button" class="btn btn-warning" id="btn_list">목록</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="cd" name="cd" value="popup"/>
                <input type="hidden" name="edit_action" id="edit_action" value="<?=$this->GP['EDIT_ACTION']?>">
            </form>
        </div>
    </div>
    <!-- /basic layout -->
<?php ob_start();
print("\n"); ?>
    <script>
        var oEditors = [];

        function smartEditorLoad() {
            //EDITOR
            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "pop_contents",
                sSkinURI: "<?=$this->GP['EDITOR_DIR']?>SmartEditor2Skin.html",
                htParams: {
                    bUseToolbar: true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer: true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger: true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
                    fOnBeforeUnload: function () {
                        //alert("완료!");
                    }
                }, //boolean
                fOnAppLoad: function () {
                    //예제 코드
                    //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
                },
                fCreator: "createSEditor2"
            });
        }

        $(document).ready(function () {
            smartEditorLoad();

            <?
                    if($pop_type == "I") {
            ?>
            $('#div_con').hide();
            $('#div_img').show();
            <?
                    }

                    if($pop_type == "T") {
            ?>
            $('#div_con').show();
            $('#div_img').hide();

            <?
                    }
            ?>

            $(":input:radio[name=pop_type]").click(function(){
                var val = $(this).val();

                if(val == "T") {
                    $('#div_con').show();
                    $('#div_img').hide();
                    smartEditorLoad();
                }else{
                    $('#div_con').hide();
                    $('#div_img').show();
                }
            });

            $('#btn_list').click(function () {
                location.href = "popup_list";
            });

            $('#btn_submit').click(function () {
                $('#frmPopup').submit();
                return false;
            });

            $("#frmPopup").submit(function(e) {
                e.preventDefault();
            }).validate({
                errorClass: "validate-error",
                rules: {
                    pop_title: {required: true },
                    pop_type: {required: true },
                    pop_use: {required: true },
                    pop_x_position: {required: true},
                    pop_y_position: {required: true},
                    pop_width: {required: true},
                    pop_height: {required: true}
                },
                messages: {
                    pop_title: { required: "팝업 제목을 입력해주세요." },
                    pop_type: { required: "형식을 선택해주세요." },
                    pop_use: { required: "사용여부를 선택해주세요." },
                    pop_x_position: { required: "위치 LEFT를 입력해주세요."},
                    pop_y_position: { required: "위치 TOP을 입력해주세요."},
                    pop_width: { required: "넓이를 입력해주세요."},
                    pop_height: { required: "높이를 입력해주세요."},
                },
                errorPlacement: function(error, element) {
                    if ($('#' + element.attr('id') + '_error').length > 0) {
                        $('#' + element.attr('id') + '_error').text(error.text());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(e){

                    if($(":input:radio[name=pop_type]:checked").val() == "T") {
                        oEditors.getById["pop_contents"].exec("UPDATE_CONTENTS_FIELD", []);
                        var con = $('#pop_contents').val();
                        if (con == '<p>&nbsp;</p>' || con == "<br>" || con == "") {
                            alertMsg("상세내용을 입력해주세요.");
                            return;
                        }
                    }

                    ajaxProcess ({url:'act_proc', form_id:'frmPopup', fileup:1, func:'commonRst', async : 1, load_bar : 1});
                    return false;
                }
            });
        });

        var fn_img_view = function(photo) {
            funcModalOpen("popupImage", {mode: '', "<?=$csrf['name']?>":"<?=$csrf['hash']?>" , "file_nm" : photo}, 'I', 'POST', 'modal-content');
            return false;
        };

        var fn_img_down = function(photo) {
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
                var frm_data = "<?=$csrf['name']?>=<?=$csrf['hash']?>&mode=DEL_IMG_POPUP&del_photo="+del_photo+"&del_id="+del_id;
                ajaxProcess ({url:'act_proc',data:frm_data, func:'commonRst'});
            }
        };
    </script>
<?php $this->buffer_script = ob_get_contents();
ob_end_clean(); ?>