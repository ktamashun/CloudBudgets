<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
                'basePath' => dirname(__FILE__).'/../tests/fixtures'
			),
			'db'=>require dirname(__FILE__) . '/db_test.php',
		),
	)
);
