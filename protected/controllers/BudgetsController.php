<?php

class BudgetsController extends Controller
{
	public $selectedMenu = 'budgets';


	public function actionIndex()
	{
        $budgets = Budget::model()->forUser($this->user)->active()->findAll();
		$this->render('index', array('budgets' => $budgets));
	}

	public function actionCreate()
	{
		$model = new Budget();
		$model->user_id = $this->user->id;

		if (isset($_POST['Budget'])) {
			$model->attributes = $_POST['Budget'];
			$model->user_id = User::getLoggedInUser()->id;
			$model->from_date = date('Y-m-d');

			// Getting and saving category
			$category = Category::model()->getOrCreateModelByName($_POST['Budget']['category_id'], $this->user);
			$model->category_id = $category->id;
			$model->name = $category->name;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('budgets', 'You have successfully created a new budget!');
					$this->redirect(array('/budgets'));
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

		if(isset($_POST['Budget']))
		{
			$model->attributes = $_POST['Budget'];
			$model->user_id = User::getLoggedInUser()->id;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('budgets', 'Budget successfully modified!');
					$this->redirect(array('/budgets'));
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
		$model = $this->loadModel($id);

		$transaction = $model->dbConnection->beginTransaction();

		try {
			$model->delete();
			$message = "The '" . $model->name . "' budget has been successfully deleted. ";

			$transaction->commit();

			Yii::app()->user->setFlash('budgets', $message);
			$this->redirect(array('/budgets'));
		} catch (Exception $e) {
			$transaction->rollback();
			throw $e;
		}
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view', array('model' => $model));
	}

    /**
     * @param int $id
     * @return Budget
     * @throws CHttpException
     */
    public function loadModel($id)
	{
		$model = Budget::model()->findByPk($id);

		if($model === null || !$this->user->hasRightToBudget($model)) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}
}