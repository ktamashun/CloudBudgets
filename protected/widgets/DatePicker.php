<?php

class DatePicker extends CWidget
{
	public $form = null;
	public $model = null;
	public $attribute = null;
	public $id = null;
	public $class = array();


	public function init()
	{}

	public function run()
	{
		if (null === $this->id) {
			$this->id = mktime() . rand(1, 10000);
		}

		$this->class[] = 'datepicker';
		$this->render('_datePicker');
	}
}
