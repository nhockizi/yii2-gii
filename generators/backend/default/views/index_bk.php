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
        "columns" => [';
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
echo "\t\t],
    \t'fields' => [
";
$i = 0;
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
        echo "\t\t\t[ \n \t\t\t\t'label' => '".$name." :', \n \t\t\t\t'name' => '".$attribute."' \n\t\t\t],\n";
        $i++;
    endif;
endforeach;
echo "\t\t],
        'bSort' => 'false',
        'processing'=> 'true',
        'serverSide' => 'true',
        'select' => 'true',
        'ajax' => Url::to(['".$Url."/load-data']),
        'buttons' => [
            [ 'extend' => 'create', 'editor' => 'editor' ],
            [ 'extend' => 'edit',   'editor' => 'editor' ],
            [ 'extend' => 'remove', 'editor' => 'editor' ]
        ],
        'paging' => 'true',
    ])
?>";
echo '
<table id="'.$idName.'_table" class="display responsive nowrap" cellspacing="0" width="100%">
</table>
<?php
    $this->registerJs("
        var editor;
        editor = new $.fn.dataTable.Editor( {
            ajax:\'".Url::to([\''.$Url.'/load-data\'])."\',
            \'table\': \'#'.$idName.'_table\',
            \'idSrc\': \'id\',
            \'fields\': [';
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
        echo "\t\t\t\t{ \n \t\t\t\t\t'label': '".$name." :', \n \t\t\t\t\t'name': '".$attribute."' \n \t\t\t\t},\n";
        $i++;
    endif;
endforeach;
echo "\t\t\t".']
        } );
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
                { extend: 'create', editor: editor },
                { extend: 'edit',   editor: editor },
                { extend: 'remove', editor: editor }
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
";
?>