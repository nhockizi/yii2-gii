<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
echo "<?php\n";
?>

namespace backend\controllers;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
use system\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use system\utilities\table\DataTableFacade;
use system\utilities\table\<?= $modelClass ?>Table;

class <?= $controllerClass ?> extends Controller
{
	public function actionAjaxTable() {
		if ( Yii::$app->request->isAjax ):
			$dataTableFacade = new DataTableFacade( new <?= $modelClass ?>Table( Yii::$app->request->post() ) );
			$dataArray       = $dataTableFacade->getData();
			$json            = json_encode( $dataArray );
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
        $model = new <?= $modelClass ?>();
<?php if($generator->formType == 'page'): ?>
        return $this->render('form', [
                'model' => $model,
            ]);
    }
<?php else:?>
        return $this->renderPartial('_form', [
                'model' => $model,
            ]);
    }
<?php
    endif;
    if($generator->formType == 'page'):
?>
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        return $this->render('form', [
                'model' => $model,
            ]);
    }
<?php else: ?>
    public function actionUpdate()
    {
        if ( Yii::$app->request->isAjax ):
            <?= $actionParams ?> = Yii::$app->request->post( 'id', '' );
            $model = $this->findModel(<?= $actionParams ?>);
            return $this->renderPartial('_form', [
                    'model' => $model,
                ]);
        endif;
    }
<?php endif; 
    if($generator->formType == 'page'):
?>
    public function actionView(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        return $this->render('view', [
                'model' => $model,
            ]);
    }
<?php else: ?>
    public function actionView()
    {
        if ( Yii::$app->request->isAjax ):
            <?= $actionParams ?> = Yii::$app->request->post( 'id', '' );
            $model = $this->findModel(<?= $actionParams ?>);
            return $this->renderPartial('_view', [
                    'model' => $model,
                ]);
        endif;
    }
<?php endif; ?>
	public function actionSave() {
		if ( Yii::$app->request->isAjax ):
			$id          = Yii::$app->request->post( 'id', '' );
			$model       = $id !== '' ? $this->findModel( $id ) : new <?= $modelClass ?>();

			if ( $model->load( Yii::$app->request->post() ) ) {
				$model->save( false );
			}
		endif;
	}

	public function actionModalDelete() {
		if ( Yii::$app->request->isAjax ):
			$id    = Yii::$app->request->post( 'id' );

			return $this->renderPartial( '_modal_delete', [ 'id' => $id ] );
		endif;
	}

    public function actionDelete(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
		$model->is_delete = 1;
		$model->updateAttributes(['is_delete']);

        return $this->redirect(['index']);
    }
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
