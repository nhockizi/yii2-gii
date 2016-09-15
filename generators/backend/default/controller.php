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
    public function actionLoadData(){
        if ( Yii::$app->request->isAjax ):
            $dataTableFacade = new DataTableFacade( new <?= StringHelper::basename($generator->controllerName) ?>Table( Yii::$app->request->get() ) );
            $dataArray       = $dataTableFacade->getData();
            $json            = Json::encode( $dataArray );
            $data            = '{"draw": ' . $dataTableFacade->getDraw() . ',"recordsTotal": ' . $dataTableFacade->getTotalRecord() . ',"recordsFiltered": ' . $dataTableFacade->getTotalFiltered() . ',"data": ' . $json . '}';
            return $data;
        endif;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCreate()
    {
        $model = new <?=StringHelper::basename($generator->controllerName)?>();
        return $this->renderPartial('_form', [
                'model' => $model,
            ]);
    }
    public function actionView()
    {
        if ( Yii::$app->request->isAjax ):
            $id = Yii::$app->request->post( 'id', '' );
            $model = $this->findModel($id);
            return $this->renderPartial('_view', [
                    'model' => $model,
                ]);
        endif;
    }
    public function actionEdit()
    {
        if ( Yii::$app->request->isAjax ):
            $id = Yii::$app->request->post( 'id', '' );
            $model = $this->findModel($id);
            return $this->renderPartial('_form', [
                    'model' => $model,
                ]);
        endif;
    }
    public function actionSave() {
        if ( Yii::$app->request->isAjax ):
            $request = Yii::$app->request;
            $id          = $request->post('<?=StringHelper::basename($generator->controllerName)?>')['id'];
            $model       = $id !== '' ? $this->findModel( $id ) : new <?=StringHelper::basename($generator->controllerName)?>();
            if ( $model->load( $request->post() ) ) {
                $model->save( false );
            }
        endif;
    }
    public function actionCheck(){
        if(Yii::$app->request->isAjax):
            $id = $_POST['id'];
            return $this->renderPartial("/general/_form_delete",['id' => $id]);
        endif;
    }
    public function actionDelete(){
        if(Yii::$app->request->isAjax):
            $id = $_POST['id'];
            <?=StringHelper::basename($generator->controllerName)?>::updateALl(array( 'is_delete' => 0 ), ' id in ('.$id.')' );
        endif;
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
