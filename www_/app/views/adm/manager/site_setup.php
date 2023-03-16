<?php
if (isset($site_data)) {
    if (is_array($site_data)) foreach ($site_data as $k => $v) ${$k} = $v;
}
?>
<div class="row">
    <div class="col-lg-12">

        <!-- Basic layout-->
        <div class="card">
            <form name="frmSite" id="frmSite" method="POST" >
                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>
                <input type="hidden" name="mode" id="mode" value="MOD_SITE"/>
                <input type="hidden" name="id" value="<?= isset($id) ? $id : "" ?>"/>

                <div class="card-body">
                    <h5 class="card-title text-success mt-1">사이트 정보</h5>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">도메인</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="도메인" name="domain" id="domain" value="<?= isset($domain) ? $domain : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">회사명</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="회사명" name="saup_company" id="saup_company" value="<?= isset($saup_company) ? $saup_company : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">대표자</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="대표자" name="saup_ceo" id="saup_ceo" value="<?= isset($saup_ceo) ? $saup_ceo : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">사업자 등록번호</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="사업자 등록번호" name="saup_num" id="saup_num" value="<?= isset($saup_num) ? $saup_num : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">부가통신 허가번호</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="부가통신 허가번호" name="admin_bu_num" id="admin_bu_num" value="<?= isset($admin_bu_num) ? $admin_bu_num : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">통신판매 허가번호</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="통신판매 허가번호" name="admin_tong_num" id="admin_tong_num" value="<?= isset($admin_tong_num) ? $admin_tong_num : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">우편번호</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="우편번호" name="saup_zip1" id="saup_zip1" value="<?= isset($saup_zip1) ? $saup_zip1 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">사업장 주소</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="사업장 주소" name="saup_adr" id="saup_adr" value="<?= isset($saup_adr) ? $saup_adr : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">업태</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="종목" name="saup_uptae" id="saup_uptae" value="<?= isset($saup_uptae) ? $saup_uptae : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">종목</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="업태" name="saup_jong" id="saup_jong" value="<?= isset($saup_jong) ? $saup_jong : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">대표전화</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="대표전화" name="site_tel" id="site_tel" value="<?= isset($site_tel) ? $site_tel : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">FAX</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="FAX" name="site_fax" id="site_fax" value="<?= isset($site_fax) ? $site_fax : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">대표이메일</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="대표이메일" name="site_email" id="site_email" value="<?= isset($site_email) ? $site_email : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <h5 class="card-title text-success mt-1">담당자 정보</h5>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">담당자</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="담당자" name="damdang" id="damdang" value="<?= isset($damdang) ? $damdang : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">담당자 연락처</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="담당자 연락처" name="damdang_tel" id="damdang_tel" value="<?= isset($damdang_tel) ? $damdang_tel : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">담당자 휴대폰</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="담당자 휴대폰" name="damdang_htel" id="damdang_htel" value="<?= isset($damdang_htel) ? $damdang_htel : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">담당자 이메일</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="담당자 이메일" name="damdang_email" id="damdang_email" value="<?= isset($damdang_email) ? $damdang_email : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>



                    <h5 class="card-title text-success mt-1">은행정보 - 경매</h5>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 1</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 1" name="admin_bank1" id="admin_bank1" value="<?= isset($admin_bank1) ? $admin_bank1 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 2</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 2" name="admin_bank2" id="admin_bank2" value="<?= isset($admin_bank2) ? $admin_bank2 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 3</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 3" name="admin_bank3" id="admin_bank3" value="<?= isset($admin_bank3) ? $admin_bank3 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 4</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 4" name="admin_bank4" id="admin_bank4" value="<?= isset($admin_bank4) ? $admin_bank4 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 5</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 5" name="admin_bank5" id="admin_bank5" value="<?= isset($admin_bank5) ? $admin_bank5 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                    <h5 class="card-title text-success mt-1">은행정보 - 오프라인 경매</h5>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 1</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 1" name="oadmin_bank1" id="oadmin_bank1" value="<?= isset($oadmin_bank1) ? $oadmin_bank1 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 2</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 2" name="oadmin_bank2" id="oadmin_bank2" value="<?= isset($oadmin_bank2) ? $oadmin_bank2 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 3</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 3" name="oadmin_bank3" id="oadmin_bank3" value="<?= isset($oadmin_bank3) ? $oadmin_bank3 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 4</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 4" name="oadmin_bank4" id="oadmin_bank4" value="<?= isset($oadmin_bank4) ? $oadmin_bank4 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 5</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 5" name="oadmin_bank5" id="oadmin_bank5" value="<?= isset($oadmin_bank5) ? $oadmin_bank5 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <h5 class="card-title text-success mt-1">은행정보 - 쇼핑몰</h5>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 1</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 1" name="sadmin_bank1" id="sadmin_bank1" value="<?= isset($sadmin_bank1) ? $sadmin_bank1 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 2</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 2" name="sadmin_bank2" id="sadmin_bank2" value="<?= isset($sadmin_bank2) ? $sadmin_bank2 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 3</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 3" name="sadmin_bank3" id="sadmin_bank3" value="<?= isset($sadmin_bank3) ? $sadmin_bank3 : "" ?>">
                        </div>

                        <label class="col-lg-2 col-form-label text-right  ">은행 4</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 4" name="sadmin_bank4" id="sadmin_bank4" value="<?= isset($sadmin_bank4) ? $sadmin_bank4 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label text-right  ">은행 5</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control border-dark" placeholder="은행 5" name="sadmin_bank5" id="sadmin_bank5" value="<?= isset($sadmin_bank5) ? $sadmin_bank5 : "" ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="text-left">
                        <button type="submit" class="btn btn-primary">저장하기</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /basic layout -->

</div>
<script>

    $(document).ready(function () {

        $("#frmSite").submit(function (e) {
            e.preventDefault();
        }).validate({
            errorClass: "validate-error",
            rules: {
                saup_company: {required: true}
            },
            messages: {
                saup_company: {required: "회사명을 입력해 주세요"}
            },
            errorPlacement: function (error, element) {
                console.log(element.attr("id"));
                if ($('#' + element.attr('id') + '_error').length > 0) {
                    $('#' + element.attr('id') + '_error').text(error.text());
                } else if (element.attr("id").indexOf("gm_target") !== -1 || element.attr("id").indexOf("gm_target") !== -1) {
                    //error.insertAfter(element.parent().parent().find(".errmsg"));
                    element.parent().parent().find(".errmsg").text(error.text());
                } else if (element.attr("id") == "gm_join_s" || element.attr("id") == "gm_join_e" || element.attr("id") == "gm_time_s" || element.attr("id") == "gm_time_e") {
                    element.parent().parent().find(".errmsg").text(error.text());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (e) {
                ajaxProcess({url: 'act_proc', form_id: 'frmSite', func: 'commonRst'});
                return false;
            }
        });
    });
</script>