<?php
    echo '<?php
namespace system\controller;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller {
    public function behaviors()
    {
        return [
            "access" => [
                "class" => AccessControl::className(),
                "rules" => [
                    [
                        "actions" => ["login", "error"],
                        "allow" => true,
                    ],
                    [
                        "actions" => ["logout", "index"],
                        "allow" => true,
                        "roles" => ["@"],
                    ],
                ],
            ],
            "verbs" => [
                "class" => VerbFilter::className(),
                "actions" => [
                    "logout" => ["post"],
                ],
            ],
        ];
    }
}';
?>