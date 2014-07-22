<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once(dirname(__FILE__) . '/../components/helpers.php');
return array(
    'theme'       => 'basic',
    'basePath'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'        => 'Performance',
    'language'    => 'ru',
    /*'preload'     => array('log'),*/

    'aliases'     => array(
        'bootstrap' => 'ext.bootstrap',
    ),

    'import'      => array(
        'application.models.*',
        'application.components.*',
        'bootstrap.behaviors.*',
        'bootstrap.helpers.*',
        'bootstrap.widgets.*'
    ),

    'modules'     => array(
        'gii'=> array(
            'class'          => 'system.gii.GiiModule',
            'password'       => 'random123',
            'ipFilters'      => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),

    ),

    'components'  => array(
        'user'        => array(
            'allowAutoLogin'=> true,
        ),

        'urlManager'  => array(
            'urlFormat'     => 'path',
            'showScriptName'=> false,
            'rules'         => array(
                'task/period/<periodId:\d+>'=>'task/period',
                '<controller:\w+>/<id:\d+>'             => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=> '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'         => '<controller>/<action>',
            ),
        ),

        'db'          => array(
            'connectionString' => 'mysql:host=localhost;dbname=performance_new',
            'emulatePrepare'   => true,
            'username'         => 'performance',
            'password'         => 'perf0rm@nce',
            'charset'          => 'utf8',
        ),

        'errorHandler'=> array(
            'errorAction'=> 'site/error',
        ),

        'log'         => array(
            'class' => 'CLogRouter',
            'routes'=> array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels'=> 'error, warning',
                ),

                /*array(
                    'class'=> 'CWebLogRoute',
                ),*/
            ),
        ),
        'bootstrap'   => array(
            'class' => 'bootstrap.components.BsApi'
        ),
    ),

    'params'      => array(
        //Yii::app()->params['paramName']
        'adminEmail'=> 'homidjonov@gmail.com',
    ),

);