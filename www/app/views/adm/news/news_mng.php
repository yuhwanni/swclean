<?
$bd_content = "";
if(isset($news_data)) {
	if (is_array($news_data)) foreach ($news_data as $k => $v) ${$k} = $v;

	$bd_content = $this->func->decContentsEdit($bd_content);
}
?>
<div class="row">
	<div class="col-lg-12">

		<!-- Basic layout-->
		<div class="card">
			<form name="frmMem" id="frmMem" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
				<input type="hidden" name="mode" id="mode" value="<?= isset($mode) ? $mode : "" ?>" />
				<input type="hidden" name="bd_type" value="<?= isset($bd_type) ? $bd_type : "" ?>" />
				<input type="hidden" name="bd_idx" value="<?= isset($bd_idx) ? $bd_idx : "" ?>" />
				<input type="hidden" name="bd_thumb_old" value="<?= isset($bd_thumb) ? $bd_thumb : "" ?>">

				<div class="card-body">
					<h5 class="card-title text-success mt-1"><?=$sub_title?></h5>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-right  ">제목</label>
						<div class="col-lg-10">
							<input type="text" class="form-control border-dark" placeholder="제목" name="bd_subject" id="bd_subject" value="<?= isset($bd_subject) ? $bd_subject : "" ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-right  ">작성자</label>
						<div class="col-lg-3">
							<input type="text" class="form-control border-dark" placeholder="작성자" name="bd_writer" id="bd_writer" value="<?= isset($bd_writer) ? $bd_writer : $_SESSION['sess_adm']['sess_name'] ?>">
						</div>

						<label class="col-lg-2 col-form-label text-right  ">작성일자</label>
						<div class="col-lg-3">
							<input type="text" class="form-control border-dark date" placeholder="작성일자" name="bd_regdate" id="bd_regdate" value="<?= isset($bd_regdate) ? $bd_regdate : "" ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-right  ">내용</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="bd_content" id="bd_content" style="width:100%; height:420px;"><?= $bd_content ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-right  ">썸네일</label>
						<div class="col-lg-10">
                            <input type="file" class="" name="bd_thumb" id="bd_thumb">
							<?php
							if (isset($bd_thumb) && !empty($bd_thumb)) {
								?>
								<div class="row mt-1">
									<div class="col-lg-6">
										<?= $bd_thumb ?>
									</div>
									<div class="col-lg-6">
										<button type="button" class="btn btn-secondary btn-sm" onclick="fn_img_view('<?= $bd_thumb ?>')">상세보기
										</button>
										<button type="button" class="btn btn-info btn-sm" onclick="fn_img_down('<?= $bd_thumb ?>')">다운로드
										</button>
										<button type="button" class="btn btn-danger btn-sm" onclick="fn_img_del('<?= $bd_thumb ?>','<?= $bd_idx ?>')">
											삭제
										</button>
									</div>
								</div>
								<?
							}
							?>
						</div>
					</div>
					<div class="hr-line-dashed"></div>

					<div class="text-right mt-3">
						<button type="submit" class="btn btn-primary">저장하기</button>
						<button type="button" class="btn btn-secondary cancel">돌아가기</button>
					</div>
				</div>

				<input type="hidden" id="cd" name="cd" value="news"/>
				<input type="hidden" name="edit_action" id="edit_action" value="<?=$this->GP['EDIT_ACTION']?>">
			</form>
		</div>
	</div>
	<!-- /basic layout -->

</div>
<?php ob_start();
print("\n"); ?>
<script>

	$(document).ready(function () {

		var oEditors = [];
		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditors,
			elPlaceHolder: "bd_content",
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

		$('.cancel').click(function () {
			location.href = "news_list?type=<?=$bd_type?>";
		})

		$("#frmMem").submit(function(e) {
			e.preventDefault();
		}).validate({
			errorClass: "validate-error",
			rules: {
				bd_subject: {required: true },
				bd_regdate: {required: true },
				<? if(!isset($bd_thumb)) {?>
				bd_thumb: { required: true }
				<? } ?>
			},
			messages: {
				bd_subject: { required: "제목을 입력해 주세요"},
				bd_regdate: { required: "작성일자를 선택해 주세요"},
				<? if(!isset($bd_thumb)) {?>
				bd_thumb: { required: "썸네일 이미지를 선택해 주세요"}
				<? } ?>
			},
			errorPlacement: function(error, element) {
				console.log(element.attr("id"));
				if ($('#' + element.attr('id') + '_error').length > 0) {
					$('#' + element.attr('id') + '_error').text(error.text());
				} else {
					error.insertAfter(element);
				}
			},
			submitHandler: function(e){

				oEditors.getById["bd_content"].exec("UPDATE_CONTENTS_FIELD", []);
				var con = $('#bd_content').val();
				if (con == '<p>&nbsp;</p>' || con == "<br>" || con == "") {
					alertMsg("상세내용을 입력해주세요.");
					return;
				}

				ajaxProcess ({url:'act_proc', form_id:'frmMem', fileup:1, func:'commonRst'});
				return false;
			}
		});
	});

	var fn_img_view = function(photo) {
		funcModalOpen("thumbImage", {mode: '', "<?=$csrf['name']?>":"<?=$csrf['hash']?>" , "file_nm" : photo }, 'I', 'POST', 'modal-content');
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
			var frm_data = "<?=$csrf['name']?>=<?=$csrf['hash']?>&mode=NEWS_IMG_DEL&del_photo="+del_photo+"&del_id="+del_id;
			ajaxProcess ({url:'act_proc',data:frm_data, func:'commonRst'});
		}
	};
</script>
<?php $this->buffer_script = ob_get_contents();
ob_end_clean(); ?>