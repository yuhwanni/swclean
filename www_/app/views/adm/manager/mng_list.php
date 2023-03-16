<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <form name="frm_sch" id="frm_sch">
                    <input type="hidden" name="excel_file" id="excel_file">

                    <div class="row">

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="">View :</label>
                                <?= $search_view ?>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="">Date:</label>

                                <div class="input-group">
                                    <input type="text" class="form-control date border-dark" name="s_date" id="date_start" value="<?=isset($s_date) ? $s_date : ""?>">
                                    <span class="input-group-prepend"><span class="input-group-text">~</span></span>
                                    <input type="text" class="form-control date border-dark" name="e_date" id="date_end" value="<?=isset($e_date) ? $e_date : ""?>">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div id="date_range_btns" class="mt-4">
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="0" >오늘</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="1" >어제</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="this_month" >이달</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="last_month" >전월</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="reset" >초기화</button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="d-sm-flex">

                        <div class="mr-sm-3">
                            <?=$sc_type_sel?>
                        </div>

                        <div class="form-group-feedback form-group-feedback-left flex-grow-1 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-lg border-dark" value="<?=isset($sc_val) ? $sc_val : "";?>" placeholder="Search" name="sc_val" id="sc_val">
                            <div class="form-control-feedback form-control-feedback-lg">
                                <i class="icon-search4 text-muted"></i>
                            </div>
                        </div>

                        <div class="ml-sm-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100 w-sm-auto">Search <i
                                    class="icon-search4 ml-2"></i></button>
                            <button type="button" class="btn btn-success btn-lg w-100 w-sm-auto btn_excel">Excel <i
                                    class="icon-file-excel ml-2"></i></button>
                            <button type="button" class="btn btn-warning btn-lg w-100 w-sm-auto btn_add" >관리자등록</button>
                        </div>
                    </div>


                </form>
            </div>


        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-xs table-bordered table-hover">
                        <thead>
                        <tr class="badge-dark text-center">
                            <th>No</th>
                            <th>아이디</th>
                            <th>이메일</th>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>상태</th>
                            <th>등록일</th>
                            <th>마지막로그인</th>
                            <th>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        if ($L_list_cnt > 0) {
                            for ($i = 0; $i < $L_list_cnt; $i++) {
                                $adm_idx = $L_list[$i]['adm_idx'];
                                $adm_id = $L_list[$i]['adm_id'];
                                $adm_email = $L_list[$i]['adm_email'];
                                $adm_name = $L_list[$i]['adm_name'];
                                $adm_tel = $L_list[$i]['adm_tel'];
                                $adm_status = $L_list[$i]['adm_status'];
                                $adm_regdate = $L_list[$i]['regdate'];
                                $adm_lastlogin_time = $L_list[$i]['adm_lastlogin_time'];
                                ?>
                                <tr data-idx="<?= $adm_idx ?>" class="text-center">
                                    <td><?= $start_num-- ?></td>
                                    <td><?= $adm_id ?></td>
                                    <td><?= $adm_email ?></td>
                                    <td><?= $adm_name ?></td>
                                    <td><?= $adm_tel ?></td>
                                    <td><?= $this->GP['ADM_STATUS'][$adm_status] ?></td>
                                    <td><?= $adm_regdate ?></td>
                                    <td><?= $adm_lastlogin_time ?></td>
                                    <td>
                                        <? if ($_SESSION['sess_adm']['sess_idx'] == $adm_idx || $_SESSION['sess_adm']['sess_type'] == "M") { ?>
                                            <button type="button" class="btn btn-warning btn-sm btn_adm_mod">수정</button>
                                        <? } ?>
                                        <? if ($_SESSION['sess_adm']['sess_type'] == "M") { ?>
                                            <button type="button" class="btn btn-success btn-sm btn_adm_auth">권한</button>
                                            <button type="button" class="btn btn-danger btn-sm btn_adm_del">삭제</button>
                                        <? } ?>
                                    </td>
                                </tr>
                                <?
                            }
                        } else {
                            echo "<tr><td colspan='14' class='align-middle text-center'>등록된 관리자가 없습니다.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="pagenation_div">
                        <?= $page_link ?>
                    </div>
                </div>


            </div>
        </div>


    </div>
</div>

<script>
    var AdmIdx = "";
    $(document).ready(function () {

        $(document).on('click', '.btn_excel', function () {
            var string = $('#frm_sch').serialize();
            location.href = "?excel_file=adm_list" + "&" + string;
            return false;
        });

        $(document).on('click', '.btn_add', function() {
            let mode = "ADD_ADM";

            funcModalOpen("mng_add", {
                mode: mode, "<?=$csrf['name']?>":"<?=$csrf['hash']?>"
            }, 'D', 'POST', 'modal-content');
            return false;
        });

        $(document).on('click', '.btn_adm_auth', function() {
            let idx = $(this).parents('tr').attr('data-idx');

            funcModalOpen("mng_auth", {
                adm_idx: idx,
                "<?=$csrf['name']?>":"<?=$csrf['hash']?>"
            }, 'D', 'POST', 'modal-content');
            return false;
        });

        $(document).on('click', '.btn_adm_mod', function() {
            let idx = $(this).parents('tr').attr('data-idx');
            let mode = "MOD_ADM";

            funcModalOpen("mng_add", {
                adm_idx: idx,
                mode: mode,
                "<?=$csrf['name']?>":"<?=$csrf['hash']?>"
            }, 'D', 'POST', 'modal-content');
        });

        $(document).on('click', '.btn_adm_del', function() {
            AdmIdx = $(this).parents('tr').attr('data-idx');
            if(AdmIdx == "") return;
            confirmMsg ("삭제 하시겠습니까? 삭제하시면 복구가 어려울 수 있습니다.", "DeletCallback");
        });
    });

    var DeletCallback = function(rst) {
        if(rst) {
            ajaxProcess ({url:'act_proc',data:'mode=DEL_ADM&<?=$csrf['name']?>=<?=$csrf['hash']?>&adm_idx='+AdmIdx, func:'commonRst'});
        }
    }

</script>


