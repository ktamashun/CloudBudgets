<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */

$pluralizedName = $this->pluralize($this->class2name($this->modelClass));

?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	public $selectedMenu = '<?php echo strtolower($pluralizedName); ?>';


	public function actionIndex()
	{
        $<?php echo strtolower($pluralizedName); ?> = <?php echo $this->modelClass; ?>::model()->findAll();
		$this->render('index', array('<?php echo strtolower($pluralizedName); ?>' => $<?php echo strtolower($pluralizedName); ?>));
	}

	public function actionCreate()
	{
		$model = new <?php echo $this->modelClass; ?>();
		$model->user_id = User::getLoggedInUser()->id;

		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			$model->user_id = User::getLoggedInUser()->id;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('<?php echo strtolower($pluralizedName); ?>', 'You have successfully created a new <?php echo strtolower($this->modelClass); ?>!');
					$this->redirect(array('/<?php echo strtolower($pluralizedName); ?>'));
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

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			$model->user_id = User::getLoggedInUser()->id;

			if ($model->validate()) {
				$transaction = $model->dbConnection->beginTransaction();

				try {
					$model->save();
					$transaction->commit();

					Yii::app()->user->setFlash('<?php echo strtolower($pluralizedName); ?>', '<?php echo $this->modelClass; ?> successfully modified!');
					$this->redirect(array('/<?php echo strtolower($pluralizedName); ?>'));
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
			$message = "The '" . $model->name . "' <?php echo strtolower($this->modelClass); ?> has been successfully deleted. ";

			$transaction->commit();

			Yii::app()->user->setFlash('<?php echo strtolower($pluralizedName); ?>', $message);
			$this->redirect(array('/<?php echo strtolower($pluralizedName); ?>'));
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

	public function loadModel($id)
	{
		$model = <?php echo $this->modelClass; ?>::model()->findByPk($id);

		if($model === null || !$this->user->hasRightTo<?php echo $this->modelClass; ?>($model)) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}
}