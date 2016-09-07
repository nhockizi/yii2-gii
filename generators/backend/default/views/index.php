<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$nameAttribute     = $generator->getNameAttribute();
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
$idName            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '_' );
$Url            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '-' );
echo '<?php
use nhockizi\widgets\DataTables;
use yii\helpers\Url;
$this->title = '.$generator->generateString( Inflector::pluralize( Inflector::camel2words( StringHelper::basename( $generator->controllerName ) ) ) ).';
$this->params["breadcrumbs"][] = $this->title;
?>
<?= 
    DataTables::widget([
        "id" => "'.$idName.'_table",
        "dom" => "Bfrtip",
        "columns" => [
            [
                "data" => "null",
                "defaultContent" => "",
                "className" => "control",
                "orderable" => "false"
            ],
            [
                "data" => "null",
                "defaultContent" => "",
                "className" => "select-checkbox",
                "orderable" => "false"
            ],';
$i = 0;
foreach ( $generator->getColumnNames() as $key => $attribute ):
    if (!in_array( $attribute, $excludesAttribute, true ) ):
        if($i == 0):
            echo "\n";
        endif;
        $check = explode('_', $attribute);
        $name = '';
        foreach ($check as $key_check => $value) {
            if($value != 'id'):
                if($key_check == 0):
                    $name .= ucfirst($value);
                else:
                    $name .= ' '.ucfirst($value);
                endif;
            endif;
        }
        echo "\t\t\t[\n \t\t\t\t'title' => '".$name."',\n \t\t\t\t'data' => '".$attribute."' ,\n \t\t\t\t'orderable' => 'false'\n\t\t\t],\n";
        $i++;
    endif;
endforeach;
echo "\t\t\t[
                'data' => '' ,
                'render' => 'function ( data, type, row ) {
                                return \' <button type=\"button\" onclick=\"Edit(\'+row.id+\');\">Edit</button> <button type=\"button\" onclick=\"Delete(\'+row.id+\');\">Delete</button>\';
                            }',
                'orderable' => 'false'
            ]
        ],\n";
echo "\t\t'bSort' => 'false',
        'select' => 'true',
        'ajax' => Url::to(['".$Url."/load-data']),
        'buttons' => [
            [
                'text' => 'Create',
                'action' => 'function(e,dt,node,config){
                    Create();
                }'
            ],
            [
                'extend' => 'selectedSingle',
                'text' => 'Edit',
                'action' => 'function(e,dt,node,config){
                    var id = dt.rows( { selected: true } ).data().pluck(\"id\")[0];
                    Edit(id);
                }'
            ],
            [
                'extend' => 'selected',
                'text' => 'Delete',
                'action' => 'function(e,dt,node,config){
                    Delete(id);
                }'
            ]
        ],
        'paging' => 'true',
        'info'=> 'false',
        'searching'=> 'false',
        'lengthChange'=> 'false',
        'processing' => 'true',
        'serverSide' => 'true',
    ])
?>
<script type='text/javascript'>
    function Create(){
        alert('create');
    }
    function Edit(id){
        alert(id);
    }
    function Delete(id){
        alert(id);
    }
</script>";
?>