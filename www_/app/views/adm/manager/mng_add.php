<?php
if (isset($adm_data)) {
    if (is_array($adm_data)) foreach ($adm_data as $k => $v) ${$k} = $v;
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?= $title ?></h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
</div>
<div class="modal-body">
    <form method="get" class="form-horizontal" id="mngRegForm" name="mngRegForm">
        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
        <input type="hidden" name="mode" id="mode" value="<?= $mode ?>"/>
        <input type="hidden" name="adm_idx" value="<?= isset($adm_idx) ? $adm_idx : "" ?>"/>
        <input type="hidden" name="old_id" id="old_id" value="<?= isset($adm_id) ? $adm_id : "" ?>"/>

        <div class="form-body">
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">아이디</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_id" id="adm_id" value="<?= isset($adm_id) ? $adm_id : ""; ?>"></div>
                <div class="col-md-5 p-t7">광고주 아이디를 (영문, 숫자 4~16byte, 필수)</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">비밀번호</label>
                <div class="col-md-5">
                    <input type="password" class="form-control border-dark" name="adm_pw" id="adm_pw">
                    <? if (isset($adm_idx)) { ?>
                        <div class="custom-control custom-checkbox mt-1">
                            <input type="checkbox" class="custom-control-input" id="adm_pw_chk" name="adm_pw_chk" value="Y">
                            <label class="custom-control-label" for="adm_pw_chk">비밀번호 변경시 체크</label>
                        </div>
                    <? } ?>
                </div>
                <div class="col-md-5 p-t7">비밀번호를 입력 하세요. (영문, 숫자 4~16byte, 필수)</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">비밀번호</label>
                <div class="col-md-5"><input type="password" class="form-control border-dark" name="adm_pw_ok" id="adm_pw_ok"></div>
                <div class="col-md-5 p-t7">비밀번호를 재입력 하세요. (필수)</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">상태</label>
                <div class="col-md-5">
                    <?= $adm_status_sel ?>
                </div>
                <div class="col-md-5 p-t7">상태를 선택해 주세요</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">이름</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_name" id="adm_name" value="<?= isset($adm_name) ? $adm_name : ""; ?>"></div>
                <div class="col-md-5 p-t7">이름을 입력하세요. (한글, 영문 4~16byte, 필수)</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">연락처</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_tel" id="adm_tel" value="<?= isset($adm_tel) ? $adm_tel : ""; ?>"></div>
                <div class="col-md-5 p-t7">연락처를 입력하세요.</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">이메일</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_email" id="adm_email" value="<?= isset($adm_email) ? $adm_email : ""; ?>"></div>
                <div class="col-md-5 p-t7">이메일을 입력하세요</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">부서</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_department" id="adm_department" value="<?= isset($adm_department) ? $adm_department : ""; ?>"></div>
                <div class="col-md-5 p-t7">부서를 선택해 주세요</div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">직급</label>
                <div class="col-md-5"><input type="text" class="form-control border-dark" name="adm_position" id="adm_position" value="<?= isset($adm_position) ? $adm_position : ""; ?>"></div>
                <div class="col-md-5 p-t7">직급을 선택해 주세요</div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-success" id="btn_submit"><?= $btn_txt ?></button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">취소</button>
</div>

<script>
    $(document).ready(function () {
        //비밀번호 변경여부 체크
        var pwChk = function (obj) {
            if ($("#adm_pw_chk").prop("checked") == true) {
                return true;
            } else {
                return false;
            }
        };

        //아이디 중복체크
        $.validator.addMethod("iddupcheck", function (adm_id) {
            var postURL = "/adm/manager/act_proc";
            var old_id = $('#old_id').val();
            console.log(old_id);
            console.log(adm_id);
            var mode = $('#mode').val();
            if (mode == "MOD_ADM") {
                if (old_id == adm_id) {
                    return true;
                }
            }
            var u_data = "mode=ADM_ID_DUPCHECK&adm_id=" + adm_id + "&<?= $csrf['name']; ?>=<?= $csrf['hash']; ?>";
            var result = "";
            var d = ajaxProcess({
                url: postURL,
                data: u_data,
                'async': 0
            });
            return result = (d.rst == 'S') ? true : false;
        }, jQuery.validator.messages.emaildupcheck);


        //비밀번호 영문숫자조합체크
        $.validator.addMethod("pwcheck", function (value, element) {
            var reg = /^.*(?=.{6,20})(?=.*[0-9])(?=.*[a-zA-Z]).*$/;
            return this.optional(element) || reg.test(value);
        }, jQuery.validator.messages.pwcheck);

        $('#btn_submit').click(function () {
            $('#mngRegForm').submit();
            return false;
        });

        // form check
        $("#mngRegForm").submit(function (e) {
            e.preventDefault();
        }).validate({
            errorClass: "validate-error",
            rules: {
                <? if (!isset($adm_idx)) { ?>
                adm_id: {
                    required: true,
                    iddupcheck: true
                },
                adm_name: {
                    required: true
                },
                adm_pw: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                    pwcheck: true
                },
                adm_pw_ok: {
                    required: true,
                    equalTo: "#adm_pw"
                },
                adm_status: {
                    required: true
                },
                adm_tel: {
                    required: true
                }
                <? } else { ?>
                adm_id: {
                    required: true,
                    iddupcheck: true
                },
                adm_pw: {
                    required: pwChk,
                    minlength: 6,
                    maxlength: 20
                },
                adm_pw_ok: {
                    equalTo: "#adm_pw"
                },
                adm_status: {
                    required: true
                },
                adm_tel: {
                    required: true
                }
                <? } ?>
            },
            messages: {
                <? if (!isset($adm_idx)) { ?>
                adm_id: {
                    required: "아이디를 입력해 주세요",
                    iddupcheck: "이미 등록된 아이디 입니다"
                },
                adm_name: {
                    required: "이름을 입력해 주세요"
                },
                adm_pw: {
                    required: "비밀번호를 입력하세요",
                    minlength: "비밀번호는 {0}자 이상입니다",
                    maxlength: "비밀번호는 {0}자 이하입니다.",
                    pwcheck: "영문(소)과 숫자를 조합하세요."
                },
                adm_pw_ok: {
                    required: "비밀번호를 재입력하세요",
                    equalTo: "비밀번호가 일치하지 않습니다"
                },
                adm_status: {
                    required: "상태를 선택하세요"
                },
                adm_tel: {
                    required: "연락처를 입력하세요"
                }
                <? } else { ?>
                adm_id: {
                    required: "아이디를 입력해 주세요",
                    iddupcheck: "이미 등록된 아이디 입니다"
                },
                adm_pw: {
                    required: "비밀번호를 입력하세요",
                    minlength: "비밀번호는 {0}자 이상입니다",
                    maxlength: "비밀번호는 {0}자 이하입니다."
                },
                adm_pw_ok: {
                    equalTo: "비밀번호는 일치하지 않습니다"
                },
                adm_status: {
                    required: "상태를 선택하세요"
                },
                adm_tel: {
                    required: "연락처를 입력하세요"
                }
                <? } ?>
            },
            errorPlacement: function (error, element) {
                if ($('#' + element.attr('id') + '_error').length > 0) {
                    $('#' + element.attr('id') + '_error').text(error.text());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (e) {
                ajaxProcess({
                    url: 'act_proc',
                    form_id: 'mngRegForm',
                    func: 'commonRst'
                });
                return false;
            }
        });
    });
</script>