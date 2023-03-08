qna_list<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <form name="frm_sch" id="frm_sch">

                    <div class="row">
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
                            <button type="submit" class="btn btn-primary btn-lg w-100 w-sm-auto">Search <i class="icon-search4 ml-2"></i></button>
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
                            <th>구분</th>
                            <th>이름</th>
                            <th>이메일</th>
                            <th>제목</th>
                            <th>등록일자</th>
                            <th style="width:150px;">관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        if ($L_list_cnt > 0) {
                            for ($i = 0; $i < $L_list_cnt; $i++) {
                                $q_idx = $L_list[$i]['q_idx'];
                                $q_type = $L_list[$i]['q_type'];
                                $q_name = $L_list[$i]['q_name'];
                                $q_email = $L_list[$i]['q_email'];
                                $q_subject = $L_list[$i]['q_subject'];
                                $q_content = $L_list[$i]['q_content'];
                                $q_regdate = $L_list[$i]['q_regdate'];
                                $q_regdate = date('y/m/d', strtotime($q_regdate));
                                ?>
                                <tr data-idx="<?= $q_idx ?>" class="text-center">
                                    <td><?= $start_num-- ?></td>
                                    <td><?= ($q_type == "K") ? "KOR" : "ENG" ?></td>
                                    <td><?= $q_name ?></td>
                                    <td><?= $q_email ?></td>
                                    <td><?= $q_subject ?></td>
                                    <td><?= $q_regdate ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm btn_view">보기</button>
                                        <button type="button" class="btn btn-danger btn-sm btn_del">삭제</button>
                                    </td>
                                </tr>
                                <?
                            }
                        } else {
                            echo "<tr><td colspan='14' class='align-middle text-center'>등록된 내역이 없습니다.</td></tr>";
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
    var Idx = "";
    $(document).ready(function () {


        $(document).on('click', '.btn_view', function() {
            let idx = $(this).parents('tr').attr('data-idx');
            let mode = "QNA_VIEW";

            funcModalOpen("qna_view", {
                mode: mode, "<?=$csrf['name']?>":"<?=$csrf['hash']?>", q_idx : idx
            }, 'D', 'POST', 'modal-content');
        });

        $(document).on('click', '.btn_del', function() {
            Idx = $(this).parents('tr').attr('data-idx');
            if(Idx == "") return;
            confirmMsg ("삭제 하시겠습니까? 삭제하시면 복구가 어려울 수 있습니다.", "DeletCallback");
        });
    });

    var DeletCallback = function(rst) {
        if(rst) {
            ajaxProcess ({url:'act_proc',data:'mode=DEL_QNA&<?=$csrf['name']?>=<?=$csrf['hash']?>&q_idx='+Idx, func:'commonRst'});
        }
    }

</script>


