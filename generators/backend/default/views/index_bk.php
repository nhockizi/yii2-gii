<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$nameAttribute     = $generator->getNameAttribute();
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
$idName            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '_' );
$Url            = Inflector::camel2id( StringHelper::basename( $generator->controllerName ), '-' );
echo '
<table id="'.$idName.'_table" class="display responsive nowrap" cellspacing="0" width="100%">
</table>
<?php
    $this->registerJs("
        var table = $(\'#'.$idName.'_table\').DataTable( {
            dom: \'Bfrtip\',
            ajax:\'".Url::to([\''.$Url.'/load-data\'])."\',
            serverSide: true,
            columns: [';
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
        echo "\t\t\t\t{ title: '".$name."', data: '".$attribute."' , orderable : false},\n";
        $i++;
    endif;
endforeach;  
echo "\t\t\t],
            select: true,
            buttons: [
                [
                    'text' : 'Create',
                    'action' : function(e,dt,node,config){
                        Create();
                    }
                ],
                [
                    'extend' : 'selectedSingle',
                    'text' : 'Edit',
                    'action' : function(e,dt,node,config){
                        var id = dt.rows( { selected: true } ).data().pluck('id')[0];
                        Edit(id);
                    }
                ],
                [
                    'extend' : 'selected',
                    'text' : 'Delete',
                    'action' : function(e,dt,node,config){
                        var id = dt.rows( { selected: true } ).data().pluck('id')[0];
                        Edit(id);
                    }
                ]
            ],
            'bSort' : false,
            fixedColumns: {
                leftColumns: 1
            },
            processing: true,
            serverSide: true,
            oLanguage: {
                sLengthMenu: 'Hiện _MENU_ mục',
                sSearch: 'Tìm kiếm:',
                oPaginate: {
                    sPrevious: 'Trước',
                    sNext: 'Kế tiếp'
                },
                sEmptyTable: 'Không có dữ liệu',
                sProcessing: 'Đang tải dữ liệu...',
                sZeroRecords: 'Không tìm thấy dữ liệu phù hợp',
                sInfo: 'Hiển thị _START_ đến _END_ của _TOTAL_ mục',
                sInfoEmpty: 'Hiển thị 0 đến 0 của 0 mục',
                sInfoFiltered: '(filtered của _MAX_ tồng số trong mục)',
                sInfoPostFix: '',
                sUrl: ''
            },
        });
    \");
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
";
?>