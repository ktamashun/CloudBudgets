<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
                'basePath' => dirname(__FILE__).'/../tests_yii/fixtures'
			),
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=cloudbudgets_test',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => 'hTaccToSQL',
				'charset' => 'utf8',
			),
		),
	)
);
