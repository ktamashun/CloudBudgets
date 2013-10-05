<?php

/**
 * Class UserTest
 *
 * @property array $transactions Returns the fixture transaction array.
 * @property array $accounts Returns the fixture account array.
 * @property array $users Returns the fixture user array.
 * @property array $categories Returns the fixture category array.
 *
 * @method User users() users($name) Returns the fixture user.
 * @method Transaction transactions() transactions($name) Returns the fixture transaction.
 * @method Category categories() categories($name) Returns the fixture category.
 * @method Account accounts() accounts($name) Returns the fixture account.
 * @method Budget budgets() budgets($name) Returns the fixture budget.
 */
class UserTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
		'accounts' => 'Account',
		'categories' => 'Category',
        'transactions' => 'Transaction',
        'budgets' => 'Budget'
	);

	/**
	 * UserTest::getNewUser()
	 *
	 * @return User
	 */
	public function getNewUser()
	{
		$user = new User('register');
		$user->attributes = $this->users['ktamas'];

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

    public function testBaseCategoriesCannotBeSavedIfUserIsNotSaved()
    {
        $this->setExpectedException('Exception');

        $user = new User();
        $user->createBaseCategories();
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
		$user = $this->users('ktamas');
        $accountsArray = $user->getAccountsAsDropDownListSource();

        foreach ($accountsArray as $accountId => $accountName) {
            $account = Account::model()->findByPk($accountId);

            $this->assertEquals($user->id, $account->user_id);
            $this->assertEquals($accountName, $account->name);
        }
    }

    public function testGetCategoriesAsDropDownListSource()
    {
		$user = $this->users('ktamas');
        $categoriesArray = $user->getCategoriessAsDropDownListSource();

        foreach ($categoriesArray as $categoryId => $categoryName) {
            $category = Category::model()->findByPk($categoryId);

            $this->assertEquals($user->id, $category->user_id);
            $this->assertEquals($categoryName, $category->name);
        }
    }

    public function testHasRightToOwnAccount()
    {
		$user = $this->users('ktamas');
        $account1 = $this->accounts('cashAccount_1');

        $this->assertEquals($user->id, $account1->user_id);
        $this->assertTrue($user->hasRightToAccount($account1));
    }

    public function testDoesNotHaveRightToOthersAccount()
    {
		$user = $this->users('kpista');
        $account1 = $this->accounts('cashAccount_1');

        $this->assertNotEquals($user->id, $account1->user_id);
        $this->assertFalse($user->hasRightToAccount($account1));
    }

    public function testHasRightToOwnCategory()
    {
		$user = $this->users('ktamas');
        $category = $this->categories('ktamasRoot');

        $this->assertEquals($user->id, $category->user_id);
        $this->assertTrue($user->hasRightToCategory($category));
    }

    public function testDoesNotHaveRightToOthersCategory()
    {
		$user = $this->users('kpista');
        $category = $this->categories('ktamasRoot');

        $this->assertNotEquals($user->id, $category->user_id);
        $this->assertFalse($user->hasRightToCategory($category));
    }

    public function testHasRightToOwnTransaction()
    {
		$user = $this->users('ktamas');
        $transaction = $this->transactions('notSaved_1');

        $this->assertEquals($user->id, $transaction->account->user_id);
        $this->assertTrue($user->hasRightToTransaction($transaction));
    }

    public function testDoesNotHaveRightToOthersTransaction()
    {
		$user = $this->users('kpista');
        $transaction = $this->transactions('notSaved_1');

        $this->assertNotEquals($user->id, $transaction->account->user_id);
        $this->assertFalse($user->hasRightToTransaction($transaction));
    }

    public function testSendActivationEmail()
    {
        $user = $this->users('ktamas');
        $this->assertFalse($user->sendActivationEmail());
    }

    public function testHasRightToBudget()
    {
        $user = $this->users('ktamas');
        $user2 = $this->users('kpista');
        $budget = $this->budgets('ktamas_Food');

        $this->assertTrue($user->hasRightToBudget($budget));
        $this->assertFalse($user2->hasRightToBudget($budget));
    }

    public function testGetLoggeInUser()
    {
        $user = new User();
        $user->attributes = $this->users['ktamas'];
        $user->save(false);

        $userRow = $this->users['ktamas'];
        $identity = new UserIdentity($userRow['email_address'], $userRow['original_password']);
        $this->assertTrue($identity->authenticate());
        $this->assertNotNull(Yii::app()->user);
        $this->assertEquals($user->id, User::getLoggedInUser()->id);
    }

    public function testDirectoryCreatedAfterRegister()
    {
        $password = 'Its a secret really..';
        $user = $this->getNewUser();
        $user->id = 1000;
        $user->password = $password;

        if (file_exists($user->getUserDirectoryPath())) {
            rmdir($user->getUserDirectoryPath());
        }

        $this->assertFalse(file_exists($user->getUserDirectoryPath()));
        $user->save(false);
        $this->assertTrue(file_exists($user->getUserDirectoryPath()));
    }
}
