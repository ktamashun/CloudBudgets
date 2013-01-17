<?php

class AccountTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
		'accounts' => 'Account',
		'transactions' => 'Transaction'
	);


	public function testActualBalanceFilledAfterCreate()
	{
		$account = new Account();
		$account->attributes = $this->accounts['unsavedAccount_1'];
		$account->save(false);

		$this->assertNotNull($account->actual_balance);
		$this->assertEquals($account->initial_balance, $account->actual_balance);
	}

	public function testActualBalanceFilledWithInitialBalanceAfterCreate()
	{
		$account = new Account();
		$account->attributes = $this->accounts['unsavedAccount_1'];
		$account->initial_balance = 30000;
		$account->save(false);

		$this->assertNotNull($account->actual_balance);
		$this->assertEquals($account->initial_balance, $account->actual_balance);
	}

	public function testActiveScope()
	{
		$activeAccount = Account::model()->find("name = 'Active 1'");
		$this->assertNotNull($activeAccount);
		$activeAccount = Account::model()->active()->find("name = 'Active 1'");
		$this->assertNotNull($activeAccount);

		$inactiveAccount = Account::model()->find("name = 'Inactive 1'");
		$this->assertNotNull($inactiveAccount);
		$inactiveAccount = Account::model()->active()->find("name = 'Inactive 1'");
		$this->assertNull($inactiveAccount);

		$deletedeAccount = Account::model()->find("name = 'Deleted 1'");
		$this->assertNotNull($deletedeAccount);
		$deletedeAccount = Account::model()->active()->find("name = 'Deleted 1'");
		$this->assertNull($deletedeAccount);
	}
    
    public function testDeleteWithDeletingTransactions()
    {
		$account = $this->accounts('activeAccount_1');
        
        $transactions = $account->transactions;
        $this->assertTrue(count($transactions) > 0);
        $transaction = $transactions[0];
        $this->assertNotNull(Transaction::model()->findByPk($transaction->id));
        
        $account->deleteWithDeletingTransactions();
        $this->assertNull(Transaction::model()->findByPk($transaction->id));
    }
    
    public function testMoveTransactionsToAccount()
    {
		$account1 = $this->accounts('activeAccount_1');
		$account2 = $this->accounts('cashAccount_1');
        
        $transactions = $account1->transactions;
        $this->assertTrue(count($transactions) > 0);
        $transaction = $transactions[0];
        $this->assertNotNull(Transaction::model()->findByPk($transaction->id));
        $this->assertEquals($transaction->account_id, $account1->id);
        
        $account1->moveTransactionsToAccount($account2);
        
        $transaction = Transaction::model()->findByPk($transaction->id);
        $this->assertEquals($transaction->account_id, $account2->id);
    }
    
    public function testGetOrCreateModelByName()
    {
		$accountExists = $this->accounts('cashAccount_1');
        $account = Account::model()->getOrCreateModelByName($accountExists->name, $accountExists->user);
        $this->assertEquals($accountExists->id, $account->id);
        
        $account = Account::model()->getOrCreateModelByName('ImSureItDoesNotExistsAccount', $accountExists->user);
        $this->assertNotNull($account->id);
        $this->assertEquals('ImSureItDoesNotExistsAccount', $account->name);
    }
    
    public function testAttributeLabelsReturnsArray()
    {
		$account = $this->accounts('cashAccount_1');
        $this->assertTrue(is_array($account->attributeLabels()));
    }
}
