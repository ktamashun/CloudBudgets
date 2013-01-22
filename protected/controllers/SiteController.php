<?php

class SiteController extends Controller
{
	public $layout='//layouts/public';


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays the home page.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * This is the action that handles the registration.
	 *
	 * @return void
	 */
	public function actionRegister()
	{
		$user = new User('register');
		$user->country_id = 226;
		$user->default_currency_id = 92;

		if (isset($_POST['User'])) {
			$user->attributes = $_POST['User'];

			if ($user->validate()) {
				$transaction = $user->dbConnection->beginTransaction();

				try {
					$user->save();
					$transaction->commit();

					$user->sendActivationEmail();

					$this->redirect(array('site/page?&view=registerSuccess'));
				} catch (Exception $e) {
					$transaction->rollback();
					throw $e;
				}
			}
		}

		$this->render('register', array('user' => $user));
	}

	public function actionVerifyRegistration($code)
	{
		$user = User::model()->inactive()->find('activation_code LIKE :code', array('code' => $code));

		if (null !== $user) {
			$user->activate();
		}

		$this->render('verifyRegistration', array('success' => (null !== $user)));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('application/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/*
	 * Displays the contact page
	 *
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}*/

	public function actionTest()
	{
		/*$root = new Category;
		$root->name = 'Tree 1';
		$root->saveNode(false);

		$root = new Category;
		$root->name = 'Tree 2';
		$root->saveNode(false);

		$category1 = new Category;
		$category1->name = 'Tree 1.1';
		$category2 = new Category;
		$category2->name = 'Tree 1.2';
		$category3 = new Category;
		$category3->name = 'Tree 1.3';
		$category4 = new Category;
		$category4->name = 'Tree 1.2.1';

		$root = Category::model()->findByPk(1);

		$category1->appendTo($root, false);
		$category2->insertAfter($category1, false);
		$category3->insertBefore($category1, false);

		$category4->appendTo($category2, false);*/

		/*$level=0;
		$categories = Category::model()->findAll(array('condition' => 'root = 1', 'order' => 'lft'));

		foreach($categories as $n=>$category)
		{
		    if($category->level==$level)
		        echo CHtml::closeTag('li')."\n";
		    else if($category->level>$level)
		        echo CHtml::openTag('ul')."\n";
		    else
		    {
		        echo CHtml::closeTag('li')."\n";

		        for($i=$level-$model->level;$i;$i--)
		        {
		            echo CHtml::closeTag('ul')."\n";
		            echo CHtml::closeTag('li')."\n";
		        }
		    }

		    echo CHtml::openTag('li');
		    echo CHtml::encode($category->name);
		    $level=$category->level;
		}

		for($i=$level;$i;$i--)
		{
		    echo CHtml::closeTag('li')."\n";
		    echo CHtml::closeTag('ul')."\n";
		}*/

		$user = new User('register');
		$user->first_name = 'Test user 1';
		$user->country_id = 1;
		$user->save(false);

		$this->render('index');
	}
}