<?php
namespace nhockizi\gii\generators\setup;

use Yii;
use yii\gii\CodeFile;
class Generator extends \yii\gii\Generator
{
    public $backend = false;
    public $frontend = false;

    public function getName() {
        return 'Config Generator';
    }
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['backend','frontend'], 'safe'],
        ]);
    }

    public function getDescription() {
        return '';
    }

    public function requiredTemplates() {
        return [ 'config/backend.php'];
    }

    public function attributeLabels() {
        return array_merge( parent::attributeLabels(),
            [
                'backend' => 'Admin',
                'frontend' => 'Site',
            ] );
    }

    public function generate() {
        $files = [];
        $backendUrl = Yii::getAlias( '@backend/web');
        $frontendUrl = Yii::getAlias( '@frontend/web');
        
        if ( $this->backend ) {
            $files[] = new CodeFile(
                Yii::getAlias( '@backend/config/main.php'), $this->render('config/backend.php')
            );
            $files[] = new CodeFile(
                Yii::getAlias( '@system/controller/ControllerAdmin.php'), $this->render('system/ControllerAdmin.php')
            );
            $files[] = new CodeFile(
                Yii::getAlias( '@backend/web/.htaccess'), $this->render('htaccess.php')
            );
        }
        if ( $this->frontend ) {
            $files[] = new CodeFile(
                Yii::getAlias( '@frontend/config/main.php'), $this->render('config/frontend.php')
            );
            $files[] = new CodeFile(
                Yii::getAlias( '@system/controller/ControllerSite.php'), $this->render('system/ControllerSite.php')
            );
            $files[] = new CodeFile(
                Yii::getAlias( '@frontend/web/.htaccess'), $this->render('htaccess.php')
            );
        }
        $files[] = new CodeFile(
            Yii::getAlias( '@common/components/Request.php'), $this->render('common/components/Request.php')
        );
        $files[] = new CodeFile(
            Yii::getAlias( '../../.htaccess'), $this->render('htaccessSite.php')
        );
        return $files;
    }
}
