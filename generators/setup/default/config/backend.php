<?php
    echo '<?php
$params = array_merge(
    require(__DIR__ . "/../../common/config/params.php"),
    require(__DIR__ . "/../../common/config/params-local.php"),
    require(__DIR__ . "/params.php"),
    require(__DIR__ . "/params-local.php")
);
return [
    "id" => "zi-backend",
    "basePath" => dirname(__DIR__),
    "controllerNamespace" => "backend\controllers",
    "bootstrap" => ["log"],
    "modules" => [],
    "components" => [
        "request" => [
            "csrfParam" => "_csrf-backend",
            "class" => "common\components\RequestAdmin",
            "web"=> "/backend/web",
        ],
        "user" => [
            "identityClass" => "common\models\User",
            "enableAutoLogin" => true,
            "identityCookie" => ["name" => "_identity-backend", "httpOnly" => true],
        ],
        "session" => [
            "name" => "zi-backend",
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
                "<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
                "<controller:\w+-\w+>/<action:\w+>" => "<controller>/<action>",
                "<controller:\w+-\w+>/<action:\w+-\w+>" => "<controller>/<action>",
                "<controller:\w+-\w+>/<action:\w+-\w+-\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+-\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+>/<action:\w+-\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+-\w+>/<action:\w+-\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+-\w+-\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller>" => "<controller>/index",

                "<controller:\w+-\w+>/<action:\w+-\w+-\w+>" => "<controller>/<action>",
                "<controller:\w+-\w+-\w+>/<action:\w+-\w+-\w+>" => "<controller>/<action>",
                "<action:\w+-\w+-\w+-\w+>" =>"<controller>/<action:\w+-\w+-\w+-\w+>",
                "<controller:\w+-\w+>/<action:\w+-\w+-\w+-\w+>" =>"<controller>/<action>",
                "<action:\w+-\w+>" =>"<controller>/<action:\w+-\w+>",
                "<action:\w+-\w+-\w+>" =>"<controller>/<action:\w+-\w+-\w+>",
            ],
        ],
        
    ],
    "params" => $params,
];';
?>