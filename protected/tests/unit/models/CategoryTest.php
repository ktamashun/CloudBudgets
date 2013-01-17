<?php

class CategoryTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
        'categories' => 'Category'
	);


	public function testGetOrCreateModelByName()
	{
		$user = new User();
		$user->attributes = $this->users['activeUser_1'];
		$user->save(false);

        $category = Category::getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);

        $category = Category::getOrCreateModelByName('None existent category', $user);
        $this->assertEquals($user->id, $category->user_id);
	}

    public function testGetOrCreateModelByNameWontReturnCategoryWithWrongUser()
    {
		$user = new User();
		$user->attributes = $this->users['activeUser_2'];
		$user->save(false);

        $category = Category::getOrCreateModelByName('Food', $user);
        $this->assertNotNull($category->id);
        $this->assertEquals($user->id, $category->user_id);
        $this->assertNotEquals($this->categories['Food']['id'], $category->id);
    }
}
