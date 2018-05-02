<?php
// This is the database connection configuration.
$db = array(
    'class' => '\yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=lanparty',
    'username' => (string) 'lanparty',
    'password' => (string) 'lanparty',
    'charset' => 'utf8'
);

if (file_exists(Yii::getAlias('@common/config/database-local.php'))) {
    $db = array_merge($db, require(Yii::getAlias('@common/config/database-local.php')));
}

return $db;