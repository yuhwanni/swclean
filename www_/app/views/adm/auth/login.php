<!-- Login form -->
<form class="login-form" action="?" method="post" name="frm_login" id="frm_login">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <input type="hidden" name="mode" value="LOGIN_ADM" />
    <input type="hidden" id="backurl" name="backurl" value="<?=$backurl?>" />
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="icon-lock icon-2x text-secondary border-secondary-100 border-3 rounded-pill p-3 mb-3 mt-1"></i>
                <h5 class="mb-0">Login to your account</h5>
                <span class="d-block text-muted">픽셀케스트 관리자페이지입니다.</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="text" class="form-control" placeholder="Username" id="adm_id" name="adm_id">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Password" id="adm_pw" name="adm_pw">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline pb-1">
                    <input type="checkbox" class="custom-control-input" id="remember" checked="">
                    <label class="custom-control-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>

        </div>
    </div>
</form>
<!-- /login form -->
<script src="/resource/global_assets/js/plugins/forms/validation/validate.min.js"></script>
<script>
    $(document).ready(function () {
        getLogin();

        $('#frm_login')
            .submit(function (e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    adm_id: { required: true },
                    adm_pw: { required: true },
                },
                messages: {
                    adm_id: { required: '아이디를 입력해 주세요' },
                    adm_pw: { required: '비밀번호를 입력하세요' },
                },
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                errorPlacement: function (error, element) {
                    if ($('#' + element.attr('id') + '_error').length > 0) {
                        $('#' + element.attr('id') + '_error').text(error.text());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (e) {
                    if ($('#remember').prop('checked')) {
                        saveLogin($('#adm_id').val());
                    } else {
                        saveLogin('');
                    }

                    ajaxProcess({
                        url: '/adm/auth/act_proc',
                        func: 'loginRst',
                        form_id: 'frm_login',
                    });
                    chk = 1;
                    return false;
                },
            });
    });

    // 쿠키에서 로그인 정보 가져오기
    function getLogin() {
        // userid 쿠키에서 id 값을 가져온다.
        var id = getCookie('userid');

        // 가져온 쿠키값이 있으면
        if (id != '') {
            $('#adm_id').val(id);
            $('#remember').attr('checked', 'true');
        }
    }

    // 쿠키에 로그인 정보 저장
    function saveLogin(id) {
        if (id != '') {
            setCookie('userid', id, 7);
        } else {
            // userid 쿠키 삭제
            setCookie('userid', id, -1);
        }
    }

    function loginRst(d) {
        var msg = '';
        switch (d.rst) {
            case 'S':
                msg = '로그인에 성공 하였습니다.';
                break;

            case 'E1':
                msg = '아이디 또는 패스워드가 잘못되었습니다';
                break;
        }

        if (msg && d.rst == 'S') {
            msg = d.msg ? d.msg : msg;
            let url = d.url ? d.url : '';

            if (url) {
                alertMsgGo(msg, url);
            } else {
                alertMsgReload(msg);
            }
        } else if (msg) {
            alertMsg(msg);
        }
    }

</script>