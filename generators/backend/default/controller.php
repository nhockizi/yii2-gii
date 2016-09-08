<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$controllerClass = 'backend/controller/'.StringHelper::basename($generator->controllerName);
$modelClass = StringHelper::basename($generator->modelClass);

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
echo "<?php\n";
?>
namespace backend\controllers;

use Yii;
use system\models\<?=StringHelper::basename($generator->controllerName)?>;
use system\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use system\utilities\table\DataTableFacade;
use system\utilities\table\<?= StringHelper::basename($generator->controllerName) ?>Table;

class <?= StringHelper::basename($generator->controllerName) ?>Controller extends Controller
{
	public function actionAjaxTable() {
		if ( Yii::$app->request->isAjax ):
			$dataTableFacade = new DataTableFacade( new <?= StringHelper::basename($generator->controllerName) ?>Table( Yii::$app->request->post() ) );
			$dataArray       = $dataTableFacade->getData();
			$json            = Json::encode( $dataArray );
			$data            = '{"draw": ' . $dataTableFacade->getDraw() . ',"recordsTotal": ' . $dataTableFacade->getTotalRecord() . ',"recordsFiltered": ' . $dataTableFacade->getTotalFiltered() . ',"data": ' . $json . '}';

			return $data;
        endif;
	}
    public function actionLoadData(){
        if ( Yii::$app->request->isAjax ):
            $action = Yii::$app->request->post('action','');
            $data = Yii::$app->request->post('data','');
            if($action != '' && $data != ''):
                foreach ($data as $key => $value):
                    if($action == 'create'):
                        
                    elseif($action == 'edit'):
                        
                    elseif($action == 'remove'):

                    endif;
                endforeach;
            else:
                $dataTableFacade = new DataTableFacade( new <?= StringHelper::basename($generator->controllerName) ?>Table( Yii::$app->request->get() ) );
                $dataArray       = $dataTableFacade->getData();
                $json            = Json::encode( $dataArray );
                $data            = '{"draw": ' . $dataTableFacade->getDraw() . ',"recordsTotal": ' . $dataTableFacade->getTotalRecord() . ',"recordsFiltered": ' . $dataTableFacade->getTotalFiltered() . ',"data": ' . $json . '}';
                return $data;
            endif;
        endif;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    protected function findModel($id)
    {
        if (($model = <?=StringHelper::basename($generator->controllerName)?>::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
