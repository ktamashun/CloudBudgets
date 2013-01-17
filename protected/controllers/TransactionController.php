<?php

class TransactionController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($transaction_type = null, $account_id = null)
	{
		$model = new Transaction;
		$model->date = date('Y-m-d');
		$model->account_balance = 0;
		$model->transaction_status_id = Transaction::STATUS_CLEARED;
		$model->transaction_type_id = 'Transfer' === $transaction_type ? Transaction::TYPE_TRANSFER : Transaction::TYPE_EXPENSE;
		$model->account_id = null === $account_id ? null : ((int)Account::model()->findByPk($account_id)->user_id === (int)$this->user->id ? $account_id : null);

		if(isset($_POST['Transaction']))
		{
			$model->attributes = $_POST['Transaction'];
			$model->category_id = 0;

			if ($model->validate()) {
				if (!$this->user->hasRightToAccount($model->account)) {
					throw new CHttpException(404, 'The requested page does not exist.');
				}

				$transaction = $model->dbConnection->beginTransaction();

				try {
					// Getting and saving category
					$category = Category::model()->find('user_id = :user_id AND name LIKE :name', array(
						'user_id' => $this->user->id,
						'name' => $_POST['Transaction']['category_id']
					));
					if (null === $category) {
						$category = new Category();
						$category->user_id = $this->user->id;
						$category->name = $_POST['Transaction']['category_id'];
						$category->appendTo($this->user->getRootCategory(), false);
					}
					$model->category_id = $category->id;

					// Saving transaction
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('transaction', 'Transaction saved successfully!');
					$this->redirect(array('transaction/create'));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

	public function actionCreateMultiple()
	{
		$transactions = array();

		for ($i = 0; $i < 10; $i++) {
			$model = new Transaction();
			$model->date = date('Y-m-d');
			$model->account_balance = 0;
			$model->transaction_status_id = Transaction::STATUS_CLEARED;

			$transactions[] = $model;
		}

		$valid = true;
		$firstInValid = null;
		$modelsToSave = array();

		if(isset($_POST['Transaction'])) {
			foreach($transactions as $i => $model) {
				if(!empty($_POST['Transaction'][$i]['description'])) {
					$model->attributes = $_POST['Transaction'][$i];
					$model->category_id = 0;

					$valid = $model->validate() && $valid;

					if ($valid) {
						if (!$this->user->hasRightToAccount($model->account)) {
							throw new CHttpException(404, 'The requested page does not exist.');
						}

						// Getting and saving category
						$category = Category::model()->find('user_id = :user_id AND name LIKE :name', array(
							'user_id' => $this->user->id,
							'name' => $_POST['Transaction'][$i]['category_id']
						));
						if (null === $category) {
							$category = new Category();
							$category->user_id = $this->user->id;
							$category->name = $_POST['Transaction'][$i]['category_id'];
							$category->appendTo($this->user->getRootCategory(), false);
						} else {
							if (!$this->user->hasRightToCategory($category)) {
								throw new CHttpException(404, 'The requested page does not exist.');
							}
						}

						$model->category_id = $category->id;

						$modelsToSave[] = $model;
					} else {
						$firstInValid = null === $firstInValid ? $model : $firstInValid;
					}
				}
			}

			if ($valid && count($modelsToSave) > 0) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					foreach ($modelsToSave as $model) {
						$model->save();
					}

					$transaction->commit();

					Yii::app()->user->setFlash('dashboard', 'Transactions saved successfully!');
					$this->redirect(array('/application/dashboard'));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$this->render('createMultiple', array('transactions' => $transactions, 'firstInValid' => $firstInValid));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Transaction']))
		{
			$model->attributes = $_POST['Transaction'];
			$model->category_id = 0;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					// Getting and saving category
					$category = Category::model()->find('user_id = :user_id AND name LIKE :name', array(
						'user_id' => $this->user->id,
						'name' => $_POST['Transaction']['category_id']
					));
					if (null === $category) {
						$category = new Category();
						$category->user_id = $this->user->id;
						$category->name = $_POST['Transaction']['category_id'];
						$category->appendTo($this->user->getRootCategory(), false);
					}
					$model->category_id = $category->id;

					// Saving transaction
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('transaction', 'Transaction successfully modified!');
					$this->redirect(array('transaction/update', 'id' => $model->id));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$model->amount = abs($model->amount);

		$this->render('update',array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'delete');
		$model->delete();
		$this->redirect($_SERVER["HTTP_REFERER"]);
	}

	public function actionImport()
	{
		/*if(isset($_FILES['importFile']))
		{
			set_time_limit(600);

			$savedFileName = 'protected/data/userFiles/transactionImport.csv';

			$file = CUploadedFile::getInstanceByName('importFile');
			$success = $file->saveAs($savedFileName);

			$contents = file_get_contents($savedFileName);
			$csvRows = str_getcsv($contents, "\n");

			foreach (array_reverse($csvRows) as $csvRow) {
				$csvCols = str_getcsv($csvRow, ';', '"');

				// Getting accounts
				if ($csvCols[2] == 'Transfer') {
					$accountNames = explode(' -> ', $csvCols[4]); //var_dump($accountNames); die();
					$toAccount = Account::model()->getOrCreateModelByName($accountNames[1], $this->user);
				} else {
					$accountNames = array($csvCols[4]);
				}
				$account = Account::model()->getOrCreateModelByName($accountNames[0], $this->user);

				// Getting categories
				$categoryNames = explode(',', $csvCols[5]);
				$category = Category::model()->getOrCreateModelByName($categoryNames[0], $this->user);

				//Creating transaction
				$amount = str_replace(array('+', ' ', ','), '', $csvCols[3]);

				$transaction = new Transaction();
				$transaction->attributes = array(
					'date' => $csvCols[0],
					'description' => $csvCols[1],
					'transaction_type_id' => ('Expense' === $csvCols[2] ? Transaction::TYPE_EXPENSE : Transaction::TYPE_INCOME),
					'account_id' => $account->id,
					'category_id' => $category->id,
					'amount' => $amount,
					'transaction_status_id' => Transaction::STATUS_CLEARED
				);

				if ($csvCols[2] == 'Transfer') {
					$transaction->transaction_type_id = Transaction::TYPE_TRANSFER;
					$transaction->to_account_id = $toAccount->id;
				}

				$transaction->save();
				/*var_dump(array(
					$account->id,
					$toAccount->id,
					$category->id,
					$transaction->id
				));*
			}

			$this->user->updateAccounts();
		}*/

		$this->render('import');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $action = 'update')
	{
		$model = Transaction::model()->findByPk($id);

		if($model === null || !$this->user->hasRightToTransaction($model)) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		if ($model->isTransfer() && null === $model->to_account_id) {
			$this->redirect(array('transaction/' . $action, 'id' => $model->getConnectedTransaction()->id));
		}

		return $model;
	}

	/*
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 *
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}*/
}
