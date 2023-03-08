<?
if(isset($rst)) {
    if (is_array($rst)) foreach ($rst as $k => $v) ${$k} = $v;}
?>
<div class="modal-header bg-primary text-white">
    <h6 class="modal-title">이미지 상세보기</h6>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <?echo "<img src='" . $this->GP['POPUP_IMG_URL'] . $file_nm . "' />";?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-info" data-dismiss="modal">닫기</button>
</div>
