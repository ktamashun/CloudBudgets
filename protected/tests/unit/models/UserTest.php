<?php

class UserTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
		'accounts' => 'Account',
		'categories' => 'Category',
		'transactions' => 'Transaction'
	);

	/**
	 * UserTest::getNewUser()
	 *
	 * @return User
	 */
	public function getNewUser()
	{
		$user = new User('register');
		$user->attributes = $this->users['ktamasTest'];

		return $user;
	}

	/**
	 * UserTest::getSavedAndReloadedNewUser()
	 *
	 * @return User
	 */
	public function getSavedAndReloadedNewUser()
	{
		$user = $this->getNewUser();
		$user->save(false);

		$user_id = $user->id;

		$user = null;
		return User::model()->findByPk($user_id);
	}

	public function testPasswordEncodedAfterRegister()
	{
		$password = 'Its a secret really..';
		$user = $this->getNewUser();
		$user->password = $password;
		$user->save(false);

		$user_id = $user->id;

		$user = null;
		$user = User::model()->findByPk($user_id);

		$this->assertEquals(UserIdentity::encodePassword($password), $user->password);
	}

	public function testActivationCodeGeneratedAfterRegister()
	{
		$user = $this->getSavedAndReloadedNewUser();
		$this->assertNotEmpty($user->activation_code);
	}

	public function testStatusIsInactiveAfterRegister()
	{
		$user = $this->getSavedAndReloadedNewUser();
		$this->assertEquals(User::STATUS_INACTIVE, $user->status);
	}

	public function testBaseCategoriesCreatedAfterRegister()
	{
		$user = $this->getNewUser('register');
		$user->save(false);

		$user_id = $user->id;

		$user = null;
		$user = User::model()->findByPk($user_id);

		$this->assertNotEmpty($user->categories);
		$this->assertEquals('Food', $user->categories[0]->name);
	}

	public function testSavingUserSeveralTimesWontRecreateBaseCategoriesEachTime()
	{
		$user = $this->getNewUser('register');
		$user->save(false);

		$user_id = $user->id;

		$user = null;
		$user = User::model()->findByPk($user_id);

		$this->assertNotEmpty($user->categories);
		$this->assertEquals('Food', $user->categories[0]->name);
		$firstCount = count($user->categories);

		$user->first_name = "Modified";
		$user->save(false);
		$user->refresh();
		$this->assertEquals($firstCount, count($user->categories));
	}

	public function testStatusIsActiveAfterRegisterVerify()
	{
		$user = $this->getSavedAndReloadedNewUser();
		$user->activate();
		$this->assertEquals(User::STATUS_ACTIVE, $user->status);
	}

	public function testActivationCodeIsNullAfterRegisterVerify()
	{
		$user = $this->getSavedAndReloadedNewUser();
		$user->activate();
		$this->assertNull($user->activation_code);
	}

	public function testActiveScopeReturnsOnlyActiveUser()
	{
		$user = $this->getSavedAndReloadedNewUser();

		$retrivedUser = User::model()->active()->findByPk($user->id);
		$this->assertNull($retrivedUser);

		$user->activate();
		$user->save(false);

		$retrivedUser = User::model()->active()->findByPk($user->id);
		$this->assertNotNull($retrivedUser);
        $this->assertEquals($user->id, $retrivedUser->id);
	}

	public function testInActiveScopeReturnsOnlyInActiveUser()
	{
		$user = $this->getSavedAndReloadedNewUser();

		$retrivedUser = User::model()->inactive()->findByPk($user->id);
		$this->assertNotNull($retrivedUser);
        $this->assertEquals($user->id, $retrivedUser->id);

		$user->activate();
		$user->save(false);

		$retrivedUser = User::model()->inactive()->findByPk($user->id);
		$this->assertNull($retrivedUser);
	}

    public function testGetAccountByType()
    {
		$user = $this->getSavedAndReloadedNewUser();

        foreach ($user->getAccountsByType(Account::TYPE_CASH) as $account) {
            $this->assertEquals(Account::TYPE_CASH, (int)$account->account_type_id);
        }

        foreach ($user->getAccountsByType(Account::TYPE_CHECKING) as $account) {
            $this->assertEquals(Account::TYPE_CHECKING, (int)$account->account_type_id);
        }
    }

    public function testGetAccountsAsDropDownListSource()
    {
		$user = $this->users('ktamasTest');
        $accountsArray = $user->getAccountsAsDropDownListSource();

        foreach ($accountsArray as $accountId => $accountName) {
            $account = Account::model()->findByPk($accountId);

            $this->assertEquals($user->id, $account->user_id);
            $this->assertEquals($accountName, $account->name);
        }
    }

    public function testGetCategoriesAsDropDownListSource()
    {
		$user = $this->users('ktamasTest');
        $categoriesArray = $user->getCategoriessAsDropDownListSource();

        foreach ($categoriesArray as $categoryId => $categoryName) {
            $category = Category::model()->findByPk($categoryId);

            $this->assertEquals($user->id, $category->user_id);
            $this->assertEquals($categoryName, $category->name);
        }
    }

    public function testHasRightToOwnAccount()
    {
		$user = $this->users('ktamasTest');
        $account1 = $this->accounts('cashAccount_1');

        $this->assertEquals($user->id, $account1->user_id);
        $this->assertTrue($user->hasRightToAccount($account1));
    }

    public function testDoesNotHaveRightToOthersAccount()
    {
		$user = $this->users('kpistaTest');
        $account1 = $this->accounts('cashAccount_1');

        $this->assertNotEquals($user->id, $account1->user_id);
        $this->assertFalse($user->hasRightToAccount($account1));
    }

    public function testHasRightToOwnCategory()
    {
		$user = $this->users('ktamasTest');
        $category = $this->categories('All_1');

        $this->assertEquals($user->id, $category->user_id);
        $this->assertTrue($user->hasRightToCategory($category));
    }

    public function testDoesNotHaveRightToOthersCategory()
    {
		$user = $this->users('kpistaTest');
        $category = $this->categories('All_1');

        $this->assertNotEquals($user->id, $category->user_id);
        $this->assertFalse($user->hasRightToCategory($category));
    }

    public function testHasRightToOwnTransaction()
    {
		$user = $this->users('ktamasTest');
        $transaction = $this->transactions('notSaved_1');

        $this->assertEquals($user->id, $transaction->account->user_id);
        $this->assertTrue($user->hasRightToTransaction($transaction));
    }

    public function testDoesNotHaveRightToOthersTransaction()
    {
		$user = $this->users('kpistaTest');
        $transaction = $this->transactions('notSaved_1');

        $this->assertNotEquals($user->id, $transaction->account->user_id);
        $this->assertFalse($user->hasRightToTransaction($transaction));
    }
}
