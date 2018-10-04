<?php

require __DIR__ . '/../vendor/autoload.php';

if (($getenv = getenv('YII_ENV')) !== 'prod'
    && file_exists($file = __DIR__ . '/../.env')) {
    (new \Symfony\Component\Dotenv\Dotenv())->load($file);
}

define('YII_ENV', $getenv ?: 'dev');
define('YII_DEBUG', getenv('YII_DEBUG') ?: YII_ENV == 'dev');

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
