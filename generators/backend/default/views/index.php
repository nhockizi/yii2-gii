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
use nhockizi\widgets\DataTables;
use yii\helpers\Url;
$this->title = <?= $generator->generateString( Inflector::pluralize( Inflector::camel2words( StringHelper::basename( $generator->modelClass ) ) ) ) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<?='<?= DataTables::widget([
    "columns" => [
        [
            "data" => "name"
        ],
        [
            "title"=>"Tên",
            "data" => "name"
        ],
        [
            "class" => "nhockizi\widgets\ButtonColumn",
            "url" => ["/'.$idName.'/view"],
            "method"=>"post",
            "queryParams" => ["id"],
            "typeView"=>"page",
            "options" => ["data-confirm" => "Are you sure you want to delete this item?", "data-id" => "id"],
            "label" => \'<button class="btn btn-success btn-view"><i class="glyphicon glyphicon-eye-open"></i></button>\',
        ],
        [
            "class" => "nhockizi\widgets\ButtonColumn",
            "url" => ["/'.$idName.'/view"],
            "method"=>"post",
            "queryParams" => ["id"],
            "typeView"=>"page",
            "label" =>\'<button class="btn btn-success btn-view"><i class="glyphicon glyphicon-eye-open"></i></button>\',
        ]
    ],
    "info"=> false,
    "searching"=> false,
    "lengthChange"=> false,
    "processing" => true,
    "serverSide" => true,
    "ajax" => Url::to(["'.$idName.'/datatables"]),
]) ?>'?>
