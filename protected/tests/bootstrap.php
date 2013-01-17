<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../.includes/Yii/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
//require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);

/*
	<selenium>
		<browser name="Internet Explorer" browser="*iexplore" />
		<browser name="Firefox" browser="*firefox" />
	</selenium>



		<log type="coverage-clover" target="/tmp/coverage.xml"/>
		<log type="coverage-php" target="/tmp/coverage.serialized"/>
		<log type="coverage-text" target="php://stdout" showUncoveredFiles="false"/>
		<log type="json" target="/tmp/logfile.json"/>
		<log type="tap" target="/tmp/logfile.tap"/>
		<log type="junit" target="/tmp/logfile.xml" logIncompleteSkipped="false"/>
		<log type="testdox-html" target="/tmp/testdox.html"/>
		<log type="testdox-text" target="/tmp/testdox.txt"/>

xsltproc -o ./report/junit-logfile.html /var/www/.includes/phpunit-noframes.xsl ./report/junit-logfile.xml

*/