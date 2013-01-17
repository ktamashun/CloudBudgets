<?php

class DataImportCommand extends Command
{
	public function actionImportCurrencies()
	{
		$this->_log('Loading currency data.. ');
		$currencies = require_once(Yii::getPathOfAlias('application.data.DataImport.Currency') . '.php');
		$this->_log();

		$this->_log('Truncating currency table.. ');
		Yii::app()->db->createCommand()->truncateTable(Currency::model()->tableName());
		$this->_log();

		$this->_log('Stating currency import..');
		foreach ($currencies as $isoCode => $currencyInfo) {
			$currency = new Currency();
			$currency->iso_code = $isoCode;
			$currency->name = $currencyInfo[0];
			$currency->code = $currencyInfo[1];
			$currency->save();
		}
		$this->_log();
		$this->_log('Currency import has been successfully finished. ');
	}
}
