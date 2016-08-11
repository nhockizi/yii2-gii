<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
// echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
// echo $form->field($generator, 'viewPath');
// echo $form->field($generator, 'baseControllerClass');
// echo $form->field($generator, 'indexWidgetType')->dropDownList([
//     'grid' => 'GridView',
//     'list' => 'ListView',
// ]);
echo $form->field($generator, 'formType')->dropDownList([
    'page' => 'Page',
    '#modal-1' => 'Modal 1',
    '#modal-2' => 'Modal 2',
    '#modal-3' => 'Modal 3',
]);
// echo $form->field($generator, 'enableI18N')->checkbox();
// echo $form->field($generator, 'enableRole')->checkbox();
// echo $form->field($generator, 'messageCategory');
