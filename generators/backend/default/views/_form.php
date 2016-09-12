<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$nameAttribute     = $generator->getNameAttribute();
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
$idName            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '_' );
$Url            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '-' );
$modelNameUpper = StringHelper::basename( $generator->controllerName );
$excludesAttribute = ['is_delete', 'created_by', 'created_date', 'updated_date', 'updated_by'];
echo '<?php
use nhockizi\widgets\DataTables;
use yii\helpers\Url;
$this->title = '.$generator->generateString( Inflector::pluralize( Inflector::camel2words( StringHelper::basename( $generator->controllerName ) ) ) ).';
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title">
		<?= ($model->isNewRecord)?"Create ":"Update "?>'.StringHelper::basename( $generator->controllerName).'
	</h4>
</div>
<div class="modal-body">
	<form id="form_'.$idName.'">
		<div class="row">'."\n";
foreach ( $generator->getColumnNames() as $key => $attribute ):
	if ( $attribute === 'id' ):
		echo "\t\t\t".'<input type="hidden" name="'.$modelNameUpper.'['.$attribute.']" value="<?=$model->'.$attribute.'?>" />'."\n";
	else:
		if (!in_array($attribute, $excludesAttribute, true)):
			echo "\t\t\t";
			echo '<div class="col-md-4 form-group">'."\n";
			echo "\t\t\t\t";
			if (substr($attribute,-2) === "id"):
				$label = "select_";
				$data = '<select name="'.$modelNameUpper.'['.$attribute.']" id="'.$label.$attribute.'" class="form-control"></select>'."\n";
			else:
				$label = "txt_";
				$data = '<input type="text" class="form-control" name="'.$modelNameUpper.'['.$attribute.']" value="<?=$model->'.$attribute.'?>" />'."\n";
			endif;
			echo "<label for='".$label.$attribute."'>".$attribute."</label>\n\t\t\t\t".$data."\t\t\t</div>\n";
		endif;
	endif;
endforeach;
	echo "\t\t".'</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-default" data-dismiss="modal" type="button">Hủy</button>
	<button class="btn btn-info" type="button" onclick="Save(<?=($model->isNewRecord)?"0":$model->id?>);"><?=($model->isNewRecord)?"Lưu":"Cập nhật"?></button>
</div>';
?>