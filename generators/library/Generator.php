<?php
namespace nhockizi\gii\generators\library;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\base\NotSupportedException;

class Generator extends \yii\gii\Generator
{
    public $generateDataTable = false;
    public $generateAsset = false;
    public $tableNs = 'system\assets';
    public $tableJs = 'backend\web\library';

    public function getName() {
        return 'Library Generator';
    }
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['generateDataTable'], 'safe'],
        ]);
    }

    public function getDescription() {
        return '';
    }

    public function requiredTemplates() {
        return [ 'ini_table.php'];
    }

    public function attributeLabels() {
        return array_merge( parent::attributeLabels(),
            [
                'generateDataTable' => 'JS DataTable',
                // 'generateAsset' => 'Generate Asset',
            ] );
    }

    public function generate() {
        $files     = [ ];
        if ( $this->generateAsset ) {
            $files[] = new CodeFile(
                Yii::getAlias( '@' . str_replace( '\\', '/', $this->tableNs ) ) . '/AppAsset.php', $this->render( 'AppAsset.php')
            );
        }
        if ( $this->generateDataTable ) {
            $files[] = new CodeFile(
                Yii::getAlias( '@' . str_replace( '\\', '/', $this->tableJs ) ) . '/ini_table.js', $this->render( 'ini_table.php')
            );
            $files[] = new CodeFile(
                Yii::getAlias( '@' . str_replace( '\\', '/', $this->tableJs ) ) . '/general_table.js', $this->render( 'general_table.php')
            );
        }
        return $files;
    }
}
