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
        "columns" => ['."\n";
if(count($generator->getColumnNames()) > 3){
        echo "\t\t\t".'[
            "data" => "null",
            "defaultContent" => "",
            "className" => "control",
            "orderable" => "false"
        ],'."\n";
}
        echo "\t\t\t".'[
                "data" => "null",
                "defaultContent" => "",
                "className" => "select-checkbox",
                "orderable" => "false"
            ],'."\n";
foreach ( $generator->getColumnNames() as $key => $attribute ):
    if (!in_array( $attribute, $excludesAttribute, true ) ):
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
    endif;
endforeach;
// echo "\t\t\t[
//                 'data' => '' ,
//                 'render' => 'function ( data, type, row ) {
//                                 return \' <button type=\"button\" onclick=\"Edit(\'+row.id+\');\">Edit</button> <button type=\"button\" onclick=\"Delete(\'+row.id+\');\">Delete</button>\';
//                             }',
//                 'orderable' => 'false'
//             ]
//         ],\n";
echo "\t\t],\n\t\t'bSort' => 'false',
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
                    var id = dt.rows( { selected: true } ).data().pluck(\"id\")[0];
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
        $.ajax({
            url: '<?= Url::to(['".$Url."/create']) ?>',
            success: function(result){
                $('#modal-1 .modal-content').html(result);
                $('#modal-1').modal();
            }
        });
    }
    function Edit(id){
        $.ajax({
            url: '<?= Url::to(['".$Url."/edit']) ?>',
            data:{'id':id},
            type:'post',
            success: function(result){
                $('#modal-1 .modal-content').html(result);
                $('#modal-1').modal();
            }
        });
    }
    function Save(id){
        var formData = new FormData(document.querySelector('#form_".$idName."'));
        $.ajax(
            {
                url: '<?= Url::to(['".$Url."/save']) ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false
            }
        ).success(function (result) {
            RefreshTable();
            $('#modal-1').modal('hide');
        });
    }
    function Delete(id){
        $.ajax({
            url: '<?= Url::to(['".$Url."/check']) ?>',
            data : {'id':id},
            type:'POST',
            success : function(result) {
                $('#modal-1 .modal-content').html(result);
                $('#modal-1').modal();
            }
        })
    }
    function actionRemoveGeneral(id){
        $.ajax({
            url: '<?= Url::to(['".$Url."/delete']) ?>',
            data : {'id':id},
            type: 'POST',
            success : function(result) {
                RefreshTable();
                $('#modal-1').modal('hide');

           }
        })
    }
    function RefreshTable(){
        $('#school_table').DataTable().ajax.reload( null, false );
    }
</script>";
?>