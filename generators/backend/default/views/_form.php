<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
$modelClass          = new $generator->modelClass();
$safeAttributes = $modelClass->safeAttributes();
$modelName      = Inflector::camel2id( StringHelper::basename( $generator->modelClass ) );
$idName         = Inflector::camel2id( StringHelper::basename( $generator->modelClass ), '_' );
$modelNameUpper = StringHelper::basename( $generator->modelClass );
$excludesAttribute = ['is_delete', 'created_by', 'created_date', 'updated_date', 'updated_by'];
if ( empty( $safeAttributes ) ) {
	$safeAttributes = $modelClass->attributes();
}

echo "<?php\n";
?>
use yii\helpers\Url;
?>
<?php 
	echo '<div class="modal-header">';
	echo "\t".'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'."\n";
	echo "\t".'<h4 class="modal-title"></h4>'."\n";
	echo '</div>'."\n";
	echo "<div class='modal-body'>\n";
	echo "\t<form id='form_".$idName."'>\n";
	echo "\t\t<div class='row'>\n";
	$i = 0;
	foreach ( $generator->getColumnNames() as $key => $attribute ):
		if ( $attribute === 'id' ):
			echo "\t\t\t";
			echo '<input type="hidden" name="'.$modelNameUpper.'['.$attribute.']" value="<?=$model->'.$attribute.'?>" />'."\n";
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
				$label = ($generator->getColumn($attribute)->comment === '')?$attribute:$generator->getColumn($attribute)->comment;
				echo "<label for='".$label.$attribute."'>".$label."</label>\n";
				echo "\t\t\t\t";
				echo $data;
				echo "\t\t\t";
				echo "</div>\n";
				$i++;
			endif;
		endif;
	endforeach;
	echo "\t\t".'</div>'."\n";
	echo "\t</form>\n";
	echo "</div>\n";
	echo '<div class="modal-footer">'."\n";
	echo "\t".'<button class="btn btn-default" data-dismiss="modal" type="button">Hủy</button>'."\n";
	echo "\t".'<button class="btn btn-info" type="button" onclick="Save(<?=($model->isNewRecord)?"0":$model->id?>);"><?=($model->isNewRecord)?"Lưu":"Cập nhật"?></button>'."\n";
	echo '</div>';
?>