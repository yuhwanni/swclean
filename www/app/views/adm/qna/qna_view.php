<?php
if (isset($qna_data)) {
    if (is_array($qna_data)) foreach ($qna_data as $k => $v) ${$k} = $v;
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?= $title ?></h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
</div>
<div class="modal-body">
    <form method="get" class="form-horizontal" id="mngAuthForm" name="mngAuthForm">

        <div class="form-body">
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">구분</label>
                <div class="col-md-5 mt-2">
                    <?=($q_type == "K") ? "KOR" : "ENG";?>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">이름</label>
                <div class="col-md-5 mt-2">
                    <?=$q_name?>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">이메일</label>
                <div class="col-md-5 mt-2">
                    <?=$q_email?>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">제목</label>
                <div class="col-md-5 mt-2">
                    <?=$q_subject?>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
                <label class="control-label text-right col-md-2 mt-2">내용</label>
                <div class="col-md-5 mt-2">
                    <?=$q_content?>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">닫기</button>
</div>

<script>
    $(document).ready(function() {


    });
</script>