<?php
// Returns external configuration array specified by filename
//  or empty array if file not exists
function getExternal($filename)
{
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.$filename;
    return file_exists($filename) ? include $filename : array();
}

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// Define a path alias for the Bootstrap extension as it's used internally.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'defaultController' => 'photo',
	'name'=>'Photo Folio',
	'theme'=>'bootstrap',

	// preloading 'log' component
	'preload'=>array('log'),
	
	// set aliases for xupload extension
	'aliases'=>array(
		'xupload' => 'ext.xupload',
	),

    'modules'=>array(
        // Fire up the admin module
        'admin',
        // uncomment the following to enable the Gii tool
        /*'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'pass',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array( 'bootstrap.gii' ),
        ),*/
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'admin.models.Option',
		'application.extensions.yiidebugtb.*',
	),

	// application components
	'components'=>array(
        'clientScript'=>array(
            'packages'=>array(
                'og-grid'=>array(
                    'baseUrl'=>'og-grid',
                    'js'=>array('js/modernizr.custom.js', 'js/grid.js'),
                    'css'=>array('css/default.css', 'css/component.css'),
                    'depends'=>array('jquery'),
                ),
            ),
        ),
        'messages' => array(
            'class' => 'CPhpMessageSource',
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'authManager' => array(
			'class'        => 'CDbAuthManager',
			'connectionID' => 'db',
		),
		'bootstrap' => array(
			'class'=>'bootstrap.components.Bootstrap',
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
                '<lang:\w{2}>/page/<page:[-\w\d]+>' => 'photo/page',
                '<lang:\w{2}>/gallery/<gall:\d+>' => 'photo/gallery',
                '<lang:\w{2}>/gallery/all' => 'photo/gallery',
                '<lang:\w{2}>/<action:\w+>' => 'photo/<action>',
                // TODO: think about to remove this line
                '<action:^(?!gii)(?!admin)\w+>' => 'photo/<action>',

                'admin/<action:(login|logout|index|options|newpass)>'=>'/admin/default/<action>',
				'admin/<controller>'=>'/admin/<controller>/index',
                // TODO: remove unnecessary lines later
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
            'class'=>'ext.demoMode.DemoModeDbConnection', // Supports demo-mode db cdn
			'connectionString'   => 'sqlite:'.realpath(dirname(__FILE__).'/../data/photo.db'),
            'initSQLs' => array(
                'PRAGMA foreign_keys = ON', // Enables SQLite foreign key support
            ),
            'queryCachingDuration' => 5*60, // 5 minutes
            'schemaCachingDuration' => 1*60*60, // 1 hour
			//'enableProfiling'    => true,
			//'enableParamLogging' => true,
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'photo/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				/*array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),*/
				/*array(
					'class'   => 'CProfileLogRoute',
					'levels'  => 'profile',
					'enabled' => true,
		        ),*/
				/*array(
					'class'      => 'CWebLogRoute',
					'categories' => 'application',
					'levels'     => 'error, warning, trace, profile, info',
		        ),*/
		        /*array(
					'class'  => 'XWebDebugRouter',
					'config' => 'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels' => 'error, warning, trace, profile, info',
		        ),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'langs' => array('en', 'ru', 'lv'),
	),
);