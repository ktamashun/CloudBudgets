<?php

class AccountsController extends Controller
{
	public $selectedMenu = 'accounts';


	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate()
	{
		$model = new Account();
		$model->user_id = User::getLoggedInUser()->id;
		$model->currency_id = User::getLoggedInUser()->default_currency_id;
		$model->status = Account::STATUS_ACTIVE;

		if (isset($_POST['Account'])) {
			$model->attributes = $_POST['Account'];
			$model->user_id = User::getLoggedInUser()->id;
			$model->currency_id = User::getLoggedInUser()->default_currency_id;
			$model->status = Account::STATUS_ACTIVE;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('accounts', 'You have successfully created a new ' . $model->accountType->name . ' account named \'' . $model->name . '\'!');
					$this->redirect(array('/accounts/view', 'id' => $model->id));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Account']))
		{
			$model->attributes = $_POST['Account'];
			$model->user_id = User::getLoggedInUser()->id;
			$model->currency_id = User::getLoggedInUser()->default_currency_id;
			$model->status = Account::STATUS_ACTIVE;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('accounts', 'Account successfully modified!');
					$this->redirect(array('/accounts'));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$account = $this->loadModel($id);

		if(isset($_POST['DeleteConfirm']))
		{
			$transaction = $account->dbConnection->beginTransaction();

			try {
				if (1 === (int)$_POST['DeleteConfirm']['deleteMethod']) {
					$account->deleteWithDeletingTransactions();
					$message = "The account '" . $account->name . "' and its transactions have been successfully deleted. ";
				} elseif (2 === (int)$_POST['DeleteConfirm']['deleteMethod']) {
					$moveToAccount = $this->loadModel((int)$_POST['DeleteConfirm']['move_to_account_id']);

					if (null === $moveToAccount) {
						throw new Exception('This account does not exsist.');
					}

					$account->moveTransactionsToAccount($moveToAccount);
					$account->delete();
					$message = "The '" . $account->name . "' account's transactions have been moved to '" . $moveToAccount->name . "' and the account has been successfully deleted. ";
				}

				$this->user->updateAccounts();

				$transaction->commit();

				Yii::app()->user->setFlash('accounts', $message);
				$this->redirect(array('/accounts'));
			} catch (Exception $e) {
				$transaction->rollback();
				throw $e;
			}
		}

		$this->render('delete',array(
			'account' => $account,
		));
	}

	public function actionView($id, $pageNumber = 1)
	{
		$account = $this->loadModel($id);

		$criteriaArray = $account->getTransactionsCriteria();

		$pager = Yii::app()->pager;
		$pager->actPage = (int)$pageNumber;
		$pager->pageUrl = array('accounts/view', 'id' => $id);
		$pager->maxRows = $criteriaArray['foundRows'];

		$criteria = $criteriaArray['criteria'];
		$criteria->limit = $pager->rowsPerPage;
		$criteria->offset = $pager->getLimitStartNumber();
		$transactions = Transaction::model()->findAll($criteria);

		$this->render('view', array('account' => $account, 'transactions' => $transactions, 'pager' => $pager));
	}

	public function loadModel($id)
	{
		$model = Account::model()->findByPk($id);

		if($model === null || !$this->user->hasRightToAccount($model)) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}
}