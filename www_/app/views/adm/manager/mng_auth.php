<?php
if (isset($adm_data)) {
    if (is_array($adm_data)) foreach ($adm_data as $k => $v) ${$k} = $v;

    $arr_menu = explode(',', $adm_menu);
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?= $title ?></h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
</div>
<div class="modal-body">
    <form method="get" class="form-horizontal" id="mngAuthForm" name="mngAuthForm">
        <input type="hidden" name="mode" id="mode" value="AUTH_ADM" />
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
        <input type="hidden" name="adm_idx" value="<?= isset($adm_idx) ? $adm_idx : "" ?>" />

        <div class="form-body">
            <div class="form-group row">
                <label class="control-label text-right col-md-2 m-t-10">전체선택</label>
                <div class="col-md-10">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input all_chk" id="chk_all">
                        <label class="custom-control-label" for="chk_all"></label>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <?php
            $n = 0;
            foreach ($this->GP['MENU'] as $k => $v) {
                ?>
                <div class="form-group row">
                    <label class="control-label text-right col-md-2 m-t-10"><?= $v['name'] ?></label>
                    <div class="col-md-10">
                        <?
                        if (isset($v['sub'])) {
                            foreach ($v['sub'] as $k2 => $v2) {

                                $checked = "";
                                if (isset($arr_menu) && isset($v2['auth']) && in_array($v2['auth'], $arr_menu)) {
                                    $checked = "checked";
                                }
                                ?>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="chk_<?=$n?>" name="tl_menu[]" value="<?= isset($v2['auth']) ? $v2['auth'] : "" ?>" <?= $checked ?>>
                                    <label class="custom-control-label" for="chk_<?=$n?>"><?= $v2['name'] ?></label>
                                </div>
                                <?
                                if (isset($v2['sub2'])) {
                                    $m=0;
                                    foreach ($v2['sub2'] as $k3 => $v3) {
                                        $checked = "";
                                        if (isset($arr_menu) && isset($v3['auth']) && in_array($v3['auth'], $arr_menu)) {
                                            $checked = "checked";
                                        }
                                        ?>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="chk_sub_<?=$m?>" name="tl_menu[]" value="<?= isset($v3['auth']) ? $v3['auth'] : "" ?>" <?= $checked ?>>
                                            <label class="custom-control-label" for="chk_sub_<?=$m?>"><?= $v3['name'] ?></label>
                                        </div>
                                        <?
                                        $m++;
                                    }
                                }
                                $n++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <?
            }
            ?>

        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="btn_submit"><?= $btn_txt ?></button>
    <button type="button" class="btn btn-white" data-dismiss="modal">취소</button>
</div>

<script>
    $(document).ready(function() {

        $(document).on('click', '.all_chk', function() {
            let chk = $(this).is(':checked');
            $('input[name="tl_menu[]"]').prop('checked', chk);
            $('.all_chk').prop('checked', chk);
        });

        $('#btn_submit').click(function() {

            if ($('input[name="tl_menu[]"]:checkbox:checked').length == 0) {
                alertMsg('접근 메뉴를 선택하세요');
                return;
            }

            ajaxProcess({
                url: 'act_proc',
                form_id: 'mngAuthForm',
                func: 'commonRst'
            });
            return false;
        });
    });
</script>