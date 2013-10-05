<?php

/**
 * Class CategoryTest
 *
 * @property array $users
 * @property array $categories
 *
 * @method Category categories() categories($name) Returns the fixture category.
 */
class CategoryTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
        'categories' => 'Category'
	);


    public function testRules()
    {
        $categroy = new Category();
        $this->assertFalse($categroy->validate());
    }

    public function testRuleCheckUniqueName()
    {
        $foodCategory = $this->categories('Food');
        $tescoCategory = $this->categories('Tesco');

        $this->assertTrue($foodCategory->validate());

        $foodCategory->name = $tescoCategory->name;
        $this->assertFalse($foodCategory->validate());

        $foodCategory = new Category();
        $foodCategory->attributes = $tescoCategory->attributes;
        $foodCategory->id = null;
        $this->assertFalse($foodCategory->validate());
    }

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

    public function testGetTransactionsListCriteriaArray()
    {
        $user = User::model()->findByPk($this->users['ktamas']['id']);
        $category = Category::model()->getOrCreateModelByName('Food', $user);
        $listArray = $category->getTransactionsListCriteriaArray();

        $this->assertTrue(array_key_exists('criteria', $listArray));
        $this->assertTrue(array_key_exists('foundRows', $listArray));
    }

    public function testGeReportCriteriaArray()
    {
        $user = User::model()->findByPk($this->users['ktamas']['id']);
        $category = Category::model()->getOrCreateModelByName('Food', $user);
        $listArray = $category->getReportCriteriaArray();

        $this->assertTrue(array_key_exists('criteria', $listArray));
        $this->assertTrue(array_key_exists('foundRows', $listArray));
    }
}
