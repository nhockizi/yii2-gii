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
	echo "<form id='form_".$idName."'>\n";
	echo "\t<div class='row'>\n";
	
	$i = 0;
	foreach ( $generator->getColumnNames() as $key => $attribute ):
		if ( $attribute === 'id' ):
			echo "\t\t";
			echo '<input type="hidden" name="'.$modelNameUpper.'['.$attribute.']" value="<?=$model->'.$attribute.'?>" />'."\n";
		else:
			if (!in_array($attribute, $excludesAttribute, true)):
				echo "\t\t";
				echo '<div class="col-md-4 form-group">'."\n";
				echo "\t\t\t";
				if (substr($attribute,-2) === "id"):
					$label = "select_";
					$data = '<select name="'.$modelNameUpper.'['.$attribute.']" id="'.$label.$attribute.'" class="form-control"></select>'."\n";
				else:
					$label = "txt_";
					$data = '<input type="text" class="form-control" name="'.$modelNameUpper.'['.$attribute.']" value="<?=$model->'.$attribute.'?>" />'."\n";
				endif;
				echo "<label for='".$label.$attribute."'>".$attribute."</label>\n";
				echo "\t\t\t";
				echo $data;
				echo "\t\t";
				echo "</div>\n";
				$i++;
			endif;
		endif;
	endforeach;
	echo "\t\t".'<div class="form-group col-md-12 text-right modal-footer">'."\n";
	echo "\t\t\t".'<a type="button" class="btn btn-default" href="<?=Url::to(["'.$idName.'/index"])?>">Hủy</a>'."\n";
	echo "\t\t\t".'<a type="button" class="btn <?= $model->isNewRecord ? "btn-success" : "btn-info" ?>" onclick-"Save();" id="btn_save" >Hủy</a>'."\n";
	echo "\t\t".'</div>'."\n";
	echo "\t".'</div>'."\n";
	echo "</form>\n";
?>