<?php
    echo '<?php
$params = array_merge(
    require(__DIR__ . "/../../common/config/params.php"),
    require(__DIR__ . "/../../common/config/params-local.php"),
    require(__DIR__ . "/params.php"),
    require(__DIR__ . "/params-local.php")
);
return [
    "id" => "zi-frontend",
    "basePath" => dirname(__DIR__),
    "bootstrap" => ["log"],
    "controllerNamespace" => "frontend\controllers",
    "components" => [
        "request" => [
            "csrfParam" => "_csrf-frontend",
            "class" => "common\components\RequestSite",
            "web"=> "/frontend/web",
            "enableCsrfValidation" => true,
            "enableCookieValidation"=>true
        ],
        "user" => [
            "identityClass" => "common\models\User",
            "enableAutoLogin" => true,
            "identityCookie" => ["name" => "_identity-frontend", "httpOnly" => true],
        ],
        "session" => [
            "name" => "zi-frontend",
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
            "enablePrettyUrl" => true,
            "showScriptName" => false,
            "rules" => [
            ],
        ],
    ],
    "params" => $params,
];';
?>