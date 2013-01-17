<?php

class RunTestsCommand extends Command
{
	public function actionIndex()
	{
		$dir = realpath(dirname(__FILE__).'/../tests');

		$this->_log('Running PhpUnit tests.. ');
		$command = "cd {$dir}; phpunit unit; ";
		exec($command);
		$this->_log();

		$this->_log('Generating HTML report.. ');
		$command = "cd {$dir}; xsltproc -o ./report/report.html /var/www/.includes/PhpUnitXmlToHtml/phpunit-noframes.xsl ./report/report.xml; ";
		exec($command);
		$this->_log();
	}
}
