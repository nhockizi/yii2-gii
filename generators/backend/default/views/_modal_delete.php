<?php
	echo '<div class="modal-body">
    <button class="bootbox-close-button close" aria-hidden="true" data-dismiss="modal" type="button" style="margin-top: -10px;">×</button>
    <div class="bootbox-body">Bạn có chắc muốn xóa không?</div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" type="button" data-dismiss="modal" data-bb-handler="cancel">Hủy</button>
    <button class="btn btn-primary" onclick="actionRemoveGeneral(<?= $id?>);return false;" type="button" data-bb-handler="confirm"> Xóa</button>
</div>';
?>
