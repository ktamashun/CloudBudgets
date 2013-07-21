<?php

/**
 * Class CategoryTest
 *
 * @property User[] $users
 * @property Category[] $categories
 */
class CategoryTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
        'categories' => 'Category'
	);


	public function testGetOrCreateModelByName()
	{
		$user = User::model()->findByPk($this->users['ktamas']['id']);

        $category = Category::model()->getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);

        $category = Category::model()->getOrCreateModelByName('None existent category', $user);
        $this->assertEquals($user->id, $category->user_id);
	}

    public function testGetOrCreateModelByNameWontReturnCategoryWithWrongUser()
    {
		$user = User::model()->findByPk($this->users['kpista']['id']);

        $category = Category::model()->getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);
        $this->assertEquals($user->id, $category->user_id);
        $this->assertNotEquals($this->categories['Food']['id'], $category->id);
    }
}
