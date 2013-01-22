<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../.includes/Yii/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

// running migrations on test database
$command = 'php5 ' . realpath(dirname(__FILE__).'/../') . '/yiic.php migrate --connectionID=testDb --interactive=0 > ' . dirname(__FILE__).'/../runtime/log/test_migrate.log';
exec($command);

// starting application
require_once($yiit);
Yii::createWebApplication($config);
