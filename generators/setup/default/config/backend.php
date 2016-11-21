<?php
    echo '<?php
$params = array_merge(
    require(__DIR__ . "/../../common/config/params.php"),
    require(__DIR__ . "/../../common/config/params-local.php"),
    require(__DIR__ . "/params.php"),
    require(__DIR__ . "/params-local.php")
);
return [
    "id" => "app-backend",
    "basePath" => dirname(__DIR__),
    "controllerNamespace" => "backend\controllers",
    "bootstrap" => ["log"],
    "modules" => [],
    "components" => [
        "request" => [
            "csrfParam" => "_csrf-backend",
            "class" => "common\components\Request",
            "web"=> "/backend/web",
            "adminUrl" => "/admin"
        ],
        "user" => [
            "identityClass" => "common\models\User",
            "enableAutoLogin" => true,
            "identityCookie" => ["name" => "_identity-backend", "httpOnly" => true],
        ],
        "session" => [
            "name" => "app-backend",
        ],
        "log" => [
            "traceLevel" => YII_DEBUG ? 3 : 0,
            "targets" => [
                [
                    "class" => "yii\log\FileTarget",
                    "levels" => ["error", "warning"],
                ],
            ],
        ],
        "errorHandler" => [
            "errorAction" => "site/error",
        ],
        "urlManager" => [
            "class" => "yii\web\UrlManager",
            "enablePrettyUrl" => true,
            "showScriptName" => false,
            "rules" => [
                "<module>/<action:\w+>" => "<module>/default/<action>",
                "<module>/<action:\w+>/<id:\d+>" => "<module>/default/<action>",
            ],
        ],
        
    ],
    "params" => $params,
];';
?>