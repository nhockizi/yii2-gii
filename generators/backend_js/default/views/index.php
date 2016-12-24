<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams         = $generator->generateUrlParams();
$nameAttribute     = $generator->getNameAttribute();
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
$idName            = Inflector::camel2id( StringHelper::basename( $generator->modelClass ), '_' );
echo "<?php\n";
?>
use yii\helpers\Url;
$this->title = <?= $generator->generateString( Inflector::pluralize( Inflector::camel2words( StringHelper::basename( $generator->modelClass ) ) ) ) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<table id="table_<?= $idName ?>" class="table table-bordered datatable">
        		<thead>
        			<tr>
        				<th>&nbsp;</th>
        				<?php
        					$i = 0;
        					foreach ( $generator->getColumnNames() as $key => $attribute ):
        						if (!in_array( $attribute, $excludesAttribute, true ) ):
        							if($i == 0):
        								echo "<th>".$attribute. "</th>\n";
        							else:
        								echo "\t\t\t\t<th>".$attribute."</th>\n";
        							endif;
        							$i++;
        						endif;
        					endforeach;
        				?>
        				<th>&nbsp;</th>
        			</tr>
        		</thead>
        	</table>
        </div>
    </div>
</div>
<script src="<?='<?=Yii::$app->request->baseUrl?>'?>/library/general_table.js"></script>
<script src="<?='<?=Yii::$app->request->baseUrl?>'?>/library/ini_table.js"></script>
<script>
    var urls = {
        'table_id':'#table_<?= $idName ?>',
        'index':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/ajax-table"])?>'?>",
        'view':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/view"])?>'?>",
        'create':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/create"])?>'?>",
        'update':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/update"])?>'?>",
        'check':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/modal-delete"])?>'?>",
        'delete':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/delete"])?>'?>",
        'delete_all':"<?='<?=Url::to(["'.str_replace('_','-',$idName).'/delete-all"])?>'?>",
        'btn_more':{
            'create':'<a class="btn btn-green btn-icon" id="btn-add">Thêm<i class="entypo-pencil"></i></a>'
        },
        'search':'#form-search',
        'bSort':true,
        'aaSorting': [1,'desc'],
        'columnDefs': [
            {"targets": 0, "orderable": false}
        ],
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        'info': false,
        'searching': false,
        'lengthChange': false,
        'modal':'<?=$generator->formType?>'
    };
	datatableHandle.init(urls);
    function refreshTable() {
        datatableHandle.refresh();
    }
</script>
