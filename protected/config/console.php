<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'CloudBudgets Console Application',

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
		),

		// components
		'components'=>array(
			'db'=>require dirname(__FILE__) . '/db_dev.php',
			'testDb'=>require dirname(__FILE__) . '/db_test.php',
		),
	)
);
