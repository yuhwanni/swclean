<div class="row">
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
							<button type="button" class="btn btn-warning btn-lg w-100 w-sm-auto btn_add" >뉴스 등록</button>
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
							<th style="width:180px;">썸네일</th>
							<th>제목</th>
							<th>작성자</th>
							<th>작성일자</th>
							<th style="width:150px;">관리</th>
						</tr>
						</thead>
						<tbody>
						<?
						if ($L_list_cnt > 0) {
							for ($i = 0; $i < $L_list_cnt; $i++) {
								$bd_idx = $L_list[$i]['bd_idx'];
								$bd_thumb = $L_list[$i]['bd_thumb'];
								$bd_subject = $L_list[$i]['bd_subject'];
								$bd_writer = $L_list[$i]['bd_writer'];
								$bd_regdate = $L_list[$i]['bd_regdate'];
								$bd_regdate = date('y/m/d', strtotime($bd_regdate));

								$img_link = $this->func->getImageMainShow(['fld'=>$this->GP['NEWS_IMG_DIR'],'img'=>$bd_thumb]);

								$img_src = "";
								if($img_link == '::NO IMAGE::') {
									$img_src = $img_link;
								} else {
									$img_src =  "<img src='" . $img_link . "' style='max-width:320px;' />";
								}
								?>
								<tr data-idx="<?= $bd_idx ?>" class="text-center">
									<td><?= $start_num-- ?></td>
									<td><?= $img_src ?></td>
									<td><?= $bd_subject ?></td>
									<td><?= $bd_writer ?></td>
									<td><?= $bd_regdate ?></td>
									<td>
										<button type="button" class="btn btn-warning btn-sm btn_mod">수정</button>
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

		$(document).on('click', '.btn_add', function() {
			location.href = "news_mng?type=<?=$bd_type?>&<?=$csrf['name']?>=<?=$csrf['hash']?>";
		});

		$(document).on('click', '.btn_mod', function() {
			let idx = $(this).parents('tr').attr('data-idx');
			let mode = "MOD_NEWS";

			location.href = "news_mng?type=<?=$bd_type?>&bd_idx=" + idx + "&mode=" + mode + "&<?=$csrf['name']?>=<?=$csrf['hash']?>";
		});

		$(document).on('click', '.btn_del', function() {
			Idx = $(this).parents('tr').attr('data-idx');
			if(Idx == "") return;
			confirmMsg ("삭제 하시겠습니까? 삭제하시면 복구가 어려울 수 있습니다.", "DeletCallback");
		});
	});

	var DeletCallback = function(rst) {
		if(rst) {
			ajaxProcess ({url:'act_proc',data:'mode=DEL_NEWS&<?=$csrf['name']?>=<?=$csrf['hash']?>&bd_idx='+Idx, func:'commonRst'});
		}
	}

</script>


