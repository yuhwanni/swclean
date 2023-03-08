<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <form name="frm_sch" id="frm_sch">
                    <input type="hidden" name="excel_file" id="excel_file">

                    <!--<div class="row">

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="">View :</label>
                                <?/*= $search_view */?>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="">Date:</label>

                                <div class="input-group">
                                    <input type="text" class="form-control date border-dark" name="s_date" id="date_start" value="<?/*= isset($s_date) ? $s_date : "" */?>">
                                    <span class="input-group-prepend"><span class="input-group-text">~</span></span>
                                    <input type="text" class="form-control date border-dark" name="e_date" id="date_end" value="<?/*= isset($e_date) ? $e_date : "" */?>">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div id="date_range_btns" class="mt-4">
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="0">오늘</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="1">어제</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="this_month">이달</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="last_month">전월</button>
                                    <button type="button" class="btn btn-outline-primary btn-md" data-range="reset">초기화</button>
                                </div>
                            </div>
                        </div>
                    </div>-->


                    <div class="d-sm-flex">

                        <div class="mr-sm-3">
                            <?= $sc_type_sel ?>
                        </div>

                        <div class="form-group-feedback form-group-feedback-left flex-grow-1 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-lg border-dark" value="<?= isset($sc_val) ? $sc_val : ""; ?>" placeholder="Search" name="sc_val" id="sc_val">
                            <div class="form-control-feedback form-control-feedback-lg">
                                <i class="icon-search4 text-muted"></i>
                            </div>
                        </div>

                        <div class="ml-sm-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100 w-sm-auto">Search <i class="icon-search4 ml-2"></i></button>
                            <button type="button" class="btn btn-warning btn-lg w-100 w-sm-auto btn_add">팝업등록</button>
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
                            <th>제목</th>
                            <th>사용유무</th>
                            <th>게시기간</th>
                            <th>크기</th>
                            <th>스크롤</th>
                            <th>수정/삭제</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        if ($L_list_cnt > 0) {
                            for ($i = 0; $i < $L_list_cnt; $i++) {
                                $pop_idx = $L_list[$i]['pop_idx'];
                                $pop_width = $L_list[$i]['pop_width'];
                                $pop_height = $L_list[$i]['pop_height'];
                                $pop_x_position = $L_list[$i]['pop_x_position'];
                                $pop_y_position = $L_list[$i]['pop_y_position'];
                                $pop_title = $L_list[$i]['pop_title'];
                                $pop_use = $L_list[$i]['pop_use'];
                                $pop_start_date = date("Y.m.d", strtotime($L_list[$i]['pop_start_date']));
                                $pop_end_date = date("Y.m.d", strtotime($L_list[$i]['pop_end_date']));
                                $pop_scroll = $L_list[$i]['pop_scroll'];
                                ?>
                                <tr data-idx="<?= $pop_idx ?>" class="text-center">
                                    <td><?= $start_num-- ?></td>
                                    <td><a href="javascript:PopupWindow('<?= $pop_idx; ?>','<?= $pop_width; ?>','<?= $pop_height; ?>', '<?= $pop_x_position; ?>', '<?= $pop_y_position; ?>', '<?= $pop_scroll; ?>');"><?= $pop_title ?></a></td>
                                    <td><?= $pop_use ?></td>
                                    <td><?= $pop_start_date; ?> ~ <?= $pop_end_date; ?></td>
                                    <td><?= $pop_width; ?>(W)×<?= $pop_height; ?>(H)</td>
                                    <td><?= $pop_scroll; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm btn_mod">수정</button>
                                        <button type="button" class="btn btn-danger btn-sm btn_del">삭제</button>
                                    </td>
                                </tr>
                                <?
                            }
                        } else {
                            echo "<tr><td colspan='14' class='align-middle text-center'>등록된 팝업 정보가 없습니다.</td></tr>";
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
    var pop_Idx = "";
    $(document).ready(function () {

        $(document).on('click', '.btn_add', function () {
            location.href = "popup_mng?<?=$csrf['name']?>=<?=$csrf['hash']?>";
        });

        $(document).on('click', '.btn_mod', function () {
            let idx = $(this).parents('tr').attr('data-idx');
            location.href = "popup_mng?mode=MOD_POPUP&pop_idx=" + idx + "<?=$csrf['name']?>=<?=$csrf['hash']?>";
        });

        $(document).on('click', '.btn_del', function () {
            pop_Idx = $(this).parents('tr').attr('data-idx');
            if (pop_Idx == "") return;
            confirmMsg("삭제 하시겠습니까? 삭제하시면 복구가 어려울 수 있습니다.", "DeletCallback");
        });
    });

    var DeletCallback = function (rst) {
        if (rst) {
            ajaxProcess({url: 'act_proc', data: 'mode=DEL_POPUP&<?=$csrf['name']?>=<?=$csrf['hash']?>&pop_Idx=' + pop_Idx, func: 'commonRst'});
        }
    }

    function PopupWindow(pop_no, win_width, win_height, x_pos, y_pos, scroll_bar) {
        var le = x_pos;
        var to = y_pos;
        var wi = parseInt(win_width) + 0;
        var he = parseInt(win_height)  + 0;
        var scrollbars = "no";

        var openurl = "popup_layer?pop_idx=" + pop_no;

        /*console.log(wi);
        console.log(he);*/

        if( scroll_bar == "1") {
            scrollbars = "yes";
            wi += 16;
        }
        window.open(openurl, '','left='+le+',top='+to+',width='+wi+',height='+he+',marginwidth=0,marginheight=0,resizable=1,scrollbars=' + scrollbars);
    }
</script>


