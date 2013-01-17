<?php

class ApplicationController extends Controller
{
	public function actionIndex()
	{
		$this->redirect(array('application/dashboard'));
	}

	public function actionDashboard($pageNumber = 1)
	{
		$this->user->registerTasks();

		$criteriaArray = $this->user->getTransactionsCriteria();

		$pager = Yii::app()->pager;
		$pager->actPage = (int)$pageNumber;
		$pager->pageUrl = array('application/dashboard');
		$pager->maxRows = $criteriaArray['foundRows'];

		$criteria = $criteriaArray['criteria'];
		$criteria->limit = $pager->rowsPerPage;
		$criteria->offset = $pager->getLimitStartNumber();
		$transactions = Transaction::model()->findAll($criteria);

		$this->render('dashboard', array('transactions' => $transactions, 'pager' => $pager));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}