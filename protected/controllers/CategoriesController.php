<?php

class CategoriesController extends Controller
{
	public function actionIndex()
	{
		$categories = Category::model()->findAll(array(
            'condition' =>
                'root = ' . User::getLoggedInUser()->getRootCategory()->id
                . ' AND id <> root',
            'order' => 'lft, name'
        ));

		$this->render('index', array(
            'categories' => $categories
        ));
	}

	public function actionView($id, $pageNumber = 1)
	{
        $category = $this->loadModel($id);

		$criteriaArray = $category->getTransactionsListCriteriaArray();

		$pager = Yii::app()->pager;
		$pager->actPage = (int)$pageNumber;
		$pager->pageUrl = array('categories/view', 'id' => $id);
		$pager->maxRows = $criteriaArray['foundRows'];

		$criteria = $criteriaArray['criteria'];
		$criteria->limit = $pager->rowsPerPage;
		$criteria->offset = $pager->getLimitStartNumber();
		$transactions = Transaction::model()->findAll($criteria);

		$this->render('view', array('category' => $category, 'transactions' => $transactions, 'pager' => $pager));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Category']))
		{
			$model->attributes = $_POST['Category'];
			$model->user_id = User::getLoggedInUser()->id;

            $root = Category::model()->find('id = :id AND user_id = :user_id', array(
                'id' => $_POST['ParentCategory']['id'],
                'user_id' => $model->user_id
            ));

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
				    $parent = $model->getParent();

                    if ($parent->id !== $root->id) {
                        $model->moveAsLast($root, false);
                    } else {
    					$model->saveNode();
                    }

					$transaction->commit();

					Yii::app()->user->setFlash('categories', 'Category successfully modified!');
					$this->redirect(array('/categories'));
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

	public function actionCreate()
	{
		$model = new Category();

		if(isset($_POST['Category']))
		{
			$model->attributes = $_POST['Category'];
            $model->user_id = User::getLoggedInUser()->id;

            $root = Category::model()->find('id = :id AND user_id = :user_id', array(
                'id' => $_POST['ParentCategory']['id'],
                'user_id' => $model->user_id
            ));

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
				    $model->saveNode();
                    $model->moveAsLast($root, false);
					$transaction->commit();

					Yii::app()->user->setFlash('categories', 'Category successfully created!');
					$this->redirect(array('/categories'));
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

	public function actionDelete()
	{
		$this->render('delete');
	}

    /**
     * @param $id
     * @return Category
     * @throws CHttpException
     */
    public function loadModel($id)
	{
		$model = Category::model()->findByPk($id);

		if($model === null || !$this->user->hasRightToCategory($model)) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
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