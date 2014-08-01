<?php

define('DS', DIRECTORY_SEPARATOR);
define('DIR_WWW', __DIR__ . DS);
define('UPLOAD_DIR', __DIR__ . DS . 'files' . DS);
define('UPLOAD_TEMP_DIR', __DIR__ . DS . 'temp' . DS);

date_default_timezone_set('Asia/Tashkent');

// change the following paths if necessary
$yii    = dirname(__FILE__) . '/../framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->run();
