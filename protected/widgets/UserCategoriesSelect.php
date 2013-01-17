<?php

class UserCategoriesSelect extends CWidget
{
	public $form = null;
	public $model = null;
	public $user = null;
	public $model_name = 'Transaction';
	public $attribute = 'category_id';
	public $class = array();
    public $type = 'autocomplete';


	public function init()
	{}

	public function run()
	{
		if (null === $this->user) {
			$this->user = User::getLoggedInUser();
		}

        if ('autocomplete' === $this->type) {
    		$this->render('_userCategoriesAutoComplete');
        } else {
            $this->render('_userCategoriesSelect');
        }
	}
}
