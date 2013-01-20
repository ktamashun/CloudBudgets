<?php

class CategoryTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
        'categories' => 'Category'
	);


	public function testGetOrCreateModelByName()
	{
		$user = User::model()->findByPk($this->users['ktamasTest']['id']);

        $category = Category::getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);

        $category = Category::getOrCreateModelByName('None existent category', $user);
        $this->assertEquals($user->id, $category->user_id);
	}

    public function testGetOrCreateModelByNameWontReturnCategoryWithWrongUser()
    {
		$user = User::model()->findByPk($this->users['kpistaTest']['id']);

        $category = Category::getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);
        $this->assertEquals($user->id, $category->user_id);
        $this->assertNotEquals($this->categories['Food']['id'], $category->id);
    }
}
