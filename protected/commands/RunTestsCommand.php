<?php

class RunTestsCommand extends Command
{
	public function actionIndex()
	{
        $testsDir = realpath(dirname(__FILE__).'/../tests');
        $qaDir = realpath(dirname(__FILE__).'/../qa/phpunit');

		$this->_log('Running PhpUnit tests.. ');
		$command = "cd {$testsDir}; phpunit unit; ";
		exec($command);
		$this->_log();

		$this->_log('Generating HTML report.. ');
		$command = "cd {$qaDir}; xsltproc -o ./report.html /var/www/.includes/PhpUnitXmlToHtml/phpunit-noframes.xsl ./report.xml; ";
		exec($command);
		$this->_log();
	}
}
