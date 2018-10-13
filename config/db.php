<?php

if (($url = getenv('DATABASE_URL')) !== false) {
    // Configuración para Heroku:
    $config = parse_url($url);
    $host = $config['host'];
    $port = $config['port'];
    $dbname = substr($config['path'], 1);
    $username = $config['user'];
    $password = $config['pass'];
    $extra = [
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
        'on afterOpen' => function ($event) {
            // $event->sender refers to the DB connection
            $event->sender->createCommand("SET intervalstyle = 'iso_8601'")->execute();
        },
    ];
} else {
    // Configuración para entorno local:
    $host = 'localhost';
    $port = '5432';
    $dbname = 'torrentlibre';
    $username = 'torrentlibre';
    $password = 'torrentlibre';
    $extra = [];
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host=$host;port=$port;dbname=$dbname",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
] + $extra;
