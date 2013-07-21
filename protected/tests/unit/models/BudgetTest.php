<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Tamás
 * Date: 2013.07.18.
 * Time: 21:48
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class BudgetTest
 *
 * @property Transaction[] transactions Returns the fixture transaction array.
 * @property Budget budgets[] Returns the fixture budget array.
 * @method Budget budgets() budgets($name) Returns the fixture budget.
 * @method User users() users($name) Returns the fixture user.
 * @method Category categories() categories($name) Returns the fixture category.
 */
class BudgetTest extends CDbTestCase
{
    public $fixtures = array(
        'users' => 'User',
        'budgets' => 'Budget',
        'categories' => 'Category',
        'transactions' => 'Transaction'
    );


    public function testActiveScopeWorks()
    {
        $food = $this->budgets('ktamas_Food');
        $food_id = $food->id;
        $this->assertEquals(Budget::STATUS_ACTIVE, $food->active);

        $row = Budget::model()->active()->findByPk($food_id);
        $this->assertNotNull($row);
        $this->assertEquals($food_id, $row->id);

        $food->active = Budget::STATUS_INACTIVE;
        $food->save(false);
        $food = null;
        $food = Budget::model()->findByPk($food_id);
        $this->assertEquals(Budget::STATUS_INACTIVE, $food->active);

        $row = null;
        $row = Budget::model()->active()->findByPk($food_id);
        $this->assertNull($row);
    }

    public function testForUserWorksWithBudgetOwner()
    {
        $food = $this->budgets('ktamas_Food');
        $food_id = $food->id;

        $ktamas = $this->users('ktamas');
        $this->assertEquals($ktamas->id, $food->user_id);

        $row = Budget::model()->forUser($ktamas)->findByPk($food_id);
        $this->assertEquals($food->id, $row->id);
    }

    public function testForUserReturnsNullWithNonBudgetOwner()
    {
        $food = $this->budgets('ktamas_Food');
        $food_id = $food->id;

        $kpista = $this->users('kpista');
        $this->assertNotEquals($kpista->id, $food->user_id);

        $row = Budget::model()->forUser($kpista)->findByPk($food_id);
        $this->assertNull($row);
    }

    public function testNegativeLimitIsInvalid()
    {
        $budget = new Budget();
        $budget->attributes = $this->budgets['ktamas_Food'];
        $budget->id = null;
        $budget->limit = -10000;

        $this->assertFalse($budget->validate());

        $budget->limit = 10000;
        $this->assertTrue($budget->validate());
    }

    /**
     * @param Category $category
     * @return Transaction
     */
    protected function _addTransactionToCategory(Category $category)
    {
        Transaction::model()->deleteAll();

        $transaction = new Transaction();
        $transaction->attributes = $this->transactions['notSaved_1'];
        $transaction->date = date('Y-m-d');
        $transaction->category = $category;
        $transaction->category_id = $category->id;
        $transaction->save(false);

        $transaction = Transaction::model()->findByPk($transaction->id);

        return $transaction;
    }

    public function testTransactionSumInBudgetWithDirectCategoryBudget()
    {
        $foodBudget = $this->budgets('ktamas_Food');
        $foodCategory = $this->categories('Food');
        $transaction = $this->_addTransactionToCategory($foodCategory);

        $this->assertNotNull($transaction->id);
        $this->assertEquals($foodCategory->id, $transaction->category_id, 'The category_id of the saved transaction doesn\'t match the given category\'s id.');
        $this->assertEquals($transaction->amount, $foodBudget->getTransactionSumForMonth($transaction->date));
        $this->assertEquals($foodBudget->getTransactionSumForMonth($transaction->date), $foodBudget->getTransactionSumForMonth());
    }

    public function testTransactionSumInBudgetWithParentCategoryBudget()
    {
        $ktamasRootBudget = $this->budgets('ktamas_ktamasRoot');
        $foodCategory = $this->categories('Food');
        $rootCategory = $this->categories('ktamasRoot');
        $transaction = $this->_addTransactionToCategory($foodCategory);

        $this->assertNotNull($transaction->id);
        $this->assertNotEquals($rootCategory->id, $transaction->category_id, 'The category_id of the saved transaction matches the root category\'s id.');
        $this->assertEquals($transaction->amount, $ktamasRootBudget->getTransactionSumForMonth($transaction->date));
    }

    public function testgetBalanceForMonth()
    {
        $foodBudget = $this->budgets('ktamas_Food');
        $foodCategory = $this->categories('Food');
        $transaction = $this->_addTransactionToCategory($foodCategory);

        $this->assertNotNull($transaction->id);
        $this->assertEquals($foodCategory->id, $transaction->category_id, 'The category_id of the saved transaction doesn\'t match the given category\'s id.');
        $this->assertEquals($transaction->amount, $foodBudget->getTransactionSumForMonth($transaction->date));
        $this->assertEquals($foodBudget->limit - abs($transaction->amount), $foodBudget->getBalanceForMonth($transaction->date));
        $this->assertEquals($foodBudget->getBalanceForMonth($transaction->date), $foodBudget->getBalanceForMonth());
    }
}
