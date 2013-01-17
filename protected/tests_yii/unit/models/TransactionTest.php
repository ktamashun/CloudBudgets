<?php

class TransactionTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
		'accounts' => 'Account',
		'transactions' => 'Transaction'
	);


	public function testAmountIsNegativeWhenExpense()
	{
		$transaction = new Transaction();
		$transaction->attributes = $this->transactions['notSaved_1'];
		$transaction->transaction_type_id = Transaction::TYPE_EXPENSE;
		$transaction->amount = 2500.00;
		$transaction->save(false);
		$this->assertEquals(-2500.00, $transaction->amount);

		$transaction->amount = -5000.00;
		$transaction->save(false);
		$this->assertEquals(-5000.00, $transaction->amount);
	}

	public function testAmountIsPositiveWhenIncome()
	{
		$transaction = new Transaction();
		$transaction->attributes = $this->transactions['notSaved_1'];
		$transaction->transaction_type_id = Transaction::TYPE_INCOME;
		$transaction->amount = -3500.00;
		$transaction->save(false);

		$this->assertEquals(3500.00, $transaction->amount);
	}

	public function testAccountsActualBalanceIsUpdated()
	{
		$initital_balance = 10000.00;

		$account = $this->accounts('cashAccount_1');
		$account->initial_balance = $initital_balance;
		$account->save();
		$account_id = $account->id;

		// EXPENSE

		$amount1 = 3450.00;

		$transaction = new Transaction();
		$transaction->attributes = $this->transactions['notSaved_1'];
		$transaction->transaction_type_id = Transaction::TYPE_EXPENSE;
		$transaction->amount = $amount1;
		$transaction->account_id = $account_id;
		$transaction->save(false);

		$this->assertEquals($initital_balance + (-1 * $amount1), Account::model()->findByPk($account_id)->actual_balance, ':' . $account->transactionsSum);

		// INCOME

		$amount2 = 355.46;

		$transaction = new Transaction();
		$transaction->attributes = $this->transactions['notSaved_1'];
		$transaction->transaction_type_id = Transaction::TYPE_INCOME;
		$transaction->amount = $amount2;
		$transaction->account_id = $account_id;
		$transaction->save(false);

		$this->assertEquals($initital_balance + (-1 * $amount1) + $amount2, Account::model()->findByPk($account_id)->actual_balance);
	}

	public function testActualBalanceIsRightForAccount()
	{
		$account = $this->accounts('transactionBalanceAccount_1');
		$account->initial_balance = 10000.00;
		$account->save();

		$transaction1 = new Transaction();
		$transaction1->attributes = array(
			'date' => '2012-04-01',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_EXPENSE,
			'account_id' => $account->id,
			'category_id' => 3,
			'amount' => 2000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction1->save(false);
		$this->assertEquals(8000.00, $transaction1->getBalance($account->user, $account)); // -2000

		$transaction2 = new Transaction();
		$transaction2->attributes = array(
			'date' => '2012-04-02',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_EXPENSE,
			'account_id' => $account->id,
			'category_id' => 3,
			'amount' => 1000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction2->save(false);
		$this->assertEquals(7000.00, $transaction2->getBalance($account->user, $account)); // -1000

		$transaction3 = new Transaction();
		$transaction3->attributes = array(
			'date' => '2012-04-02',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_INCOME,
			'account_id' => $account->id,
			'category_id' => 3,
			'amount' => 5000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction3->save(false);
		$this->assertEquals(7000.00, $transaction2->getBalance($account->user, $account)); // -1000
		$this->assertEquals(12000.00, $transaction3->getBalance($account->user, $account)); // +5000

		$transaction4 = new Transaction();
		$transaction4->attributes = array(
			'date' => '2012-04-01',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_EXPENSE,
			'account_id' => $account->id,
			'category_id' => 3,
			'amount' => 5000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction4->save(false);
		$this->assertEquals(8000.00, $transaction1->getBalance($account->user, $account)); // -2000
		$this->assertEquals(3000.00, $transaction4->getBalance($account->user, $account)); // -5000
		$this->assertEquals(2000.00, $transaction2->getBalance($account->user, $account)); // -1000
		$this->assertEquals(7000.00, $transaction3->getBalance($account->user, $account)); // +5000

		$transaction5 = new Transaction();
		$transaction5->attributes = array(
			'date' => '2012-03-31',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_EXPENSE,
			'account_id' => $account->id,
			'category_id' => 3,
			'amount' => 6000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction5->save(false);
		$this->assertEquals(4000.00, $transaction5->getBalance($account->user, $account)); // -6000
		$this->assertEquals(2000.00, $transaction1->getBalance($account->user, $account)); // -2000
		$this->assertEquals(-3000.00, $transaction4->getBalance($account->user, $account)); // -5000
		$this->assertEquals(-4000.00, $transaction2->getBalance($account->user, $account)); // -1000
		$this->assertEquals(1000.00, $transaction3->getBalance($account->user, $account)); // +5000


		$account2 = $this->accounts('transactionBalanceAccount_2');
		$account2->initial_balance = 20000.00;
		$account2->save();

		$transaction6 = new Transaction();
		$transaction6->attributes = array(
			'date' => '2012-03-30',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_EXPENSE,
			'account_id' => $account2->id,
			'category_id' => 3,
			'amount' => 10000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED
		);
		$transaction6->save(false);
																					// +30000
		$this->assertEquals(20000.00, $transaction6->getBalance($account->user)); 	// -10000
		$this->assertEquals(14000.00, $transaction5->getBalance($account->user)); 	// -6000
		$this->assertEquals(12000.00, $transaction1->getBalance($account->user)); 	// -2000
		$this->assertEquals(7000.00, $transaction4->getBalance($account->user)); 	// -5000
		$this->assertEquals(6000.00, $transaction2->getBalance($account->user)); 	// -1000
		$this->assertEquals(11000.00, $transaction3->getBalance($account->user)); 	// +5000


		// Testing transaction criterias
		$criteria = $account->getTransactionsCriteria();
		$this->assertEquals(5, $criteria['foundRows']);

		$criteria = $account2->getTransactionsCriteria();
		$this->assertEquals(1, $criteria['foundRows']);

		$criteria = $account2->user->getTransactionsCriteria();
		$this->assertEquals(6, $criteria['foundRows']);


		// Testing transaction delete
		$transaction1->delete();
																					// +30000
		$this->assertEquals(20000.00, $transaction6->getBalance($account->user)); 	// -10000
		$this->assertEquals(14000.00, $transaction5->getBalance($account->user)); 	// -6000
		//$this->assertEquals(12000.00, $transaction1->getBalance($account->user)); // -2000
		$this->assertEquals(9000.00, $transaction4->getBalance($account->user)); 	// -5000
		$this->assertEquals(8000.00, $transaction2->getBalance($account->user)); 	// -1000
		$this->assertEquals(13000.00, $transaction3->getBalance($account->user)); 	// +5000


		// Testing transfers
		$transaction7 = new Transaction();
		$transaction7->attributes = array(
			'date' => '2012-03-31',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_TRANSFER,
			'account_id' => $account->id,
			'to_account_id' => $account2->id,
			'category_id' => 3,
			'amount' => 10000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED,
			'description' => 'Test transfer'
		);
		$transaction7->save();
		$transferTransaction = $transaction7->transferTransaction;

		// Account values
		$this->assertEquals(4000.00, $transaction5->getBalance($account->user, $account));		// -6000
		$this->assertEquals(-6000.00, $transaction7->getBalance($account->user, $account)); 	// -10000
		//$this->assertEquals(2000.00, $transaction1->getBalance($account->user, $account)); 	// -2000
		$this->assertEquals(-11000.00, $transaction4->getBalance($account->user, $account)); 	// -5000
		$this->assertEquals(-12000.00, $transaction2->getBalance($account->user, $account)); 	// -1000
		$this->assertEquals(-7000.00, $transaction3->getBalance($account->user, $account)); 	// +5000

		// Account2 values
		$this->assertEquals(10000.00, $transaction6->getBalance($account2->user, $account2)); 			// -10000
		$this->assertEquals(20000.00, $transferTransaction->getBalance($account2->user, $account2)); 	// +10000

		// Dashboard values															// +30000
		$this->assertEquals(20000.00, $transaction6->getBalance($account->user)); 	// -10000
		$this->assertEquals(14000.00, $transaction5->getBalance($account->user)); 	// -6000
		$this->assertEquals(14000.00, $transaction7->getBalance($account->user)); 	// +-10000
		//$this->assertEquals(12000.00, $transaction1->getBalance($account->user)); // -2000
		$this->assertEquals(9000.00, $transaction4->getBalance($account->user)); 	// -5000
		$this->assertEquals(8000.00, $transaction2->getBalance($account->user)); 	// -1000
		$this->assertEquals(13000.00, $transaction3->getBalance($account->user)); 	// +5000
	}
    
    protected function _getTransferTransactionWithAccounts()
    {
		$account1 = $this->accounts('transactionBalanceAccount_1');
		$account2 = $this->accounts('transactionBalanceAccount_2');

		$transaction = new Transaction();
		$transaction->attributes = array(
			'date' => '2012-03-30',
			'dascription' => 'Test transaction',
			'transaction_type_id' => Transaction::TYPE_TRANSFER,
			'account_id' => $account1->id,
			'to_account_id' => $account2->id,
			'category_id' => 3,
			'amount' => 10000.00,
			'transaction_status_id' => Transaction::STATUS_CLEARED,
			'description' => 'Test transfer'
		);
        
        return array($transaction, $account1, $account2);
    }

	public function testTransferNeedDifferentToAccount()
	{
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
        $transaction->to_account_id = $account1->id;
		$this->assertFalse($transaction->validate());

		$transaction->to_account_id = $account2->id;
		$this->assertTrue($transaction->validate());
	}

	public function testTransferTransactionIsCreatedAfterTransferSave()
	{
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
		$transaction->save();

		$this->assertNotNull($transaction->transfer_transaction_id);

		$transferTransaction = Transaction::model()->findByPk($transaction->transfer_transaction_id);
		$this->assertNotNull($transferTransaction);

		$this->assertEquals($transaction->account->user_id, $transferTransaction->account->user_id);
		$this->assertEquals($transaction->transaction_type_id, $transferTransaction->transaction_type_id);
		$this->assertEquals($transaction->to_account_id, $transferTransaction->account_id);
		$this->assertEquals($transaction->category_id, $transferTransaction->category_id);
		$this->assertEquals($transaction->amount, -1 * $transferTransaction->amount);
		$this->assertEquals($transaction->transaction_status_id, $transferTransaction->transaction_status_id);
		$this->assertEquals($transaction->description, $transferTransaction->description);
		$this->assertNull($transferTransaction->transfer_transaction_id);
	}

	public function testTransferBecomesIncome()
	{
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
		$transaction->save();

		// Testing transfer
		$this->assertNotNull($transaction->transfer_transaction_id);

		$transferTransaction = Transaction::model()->findByPk($transaction->transfer_transaction_id);
		$this->assertNotNull($transferTransaction);

		// Testing income
		$transaction->transaction_type_id = Transaction::TYPE_EXPENSE;
		$transaction->save();

		$this->assertNull($transaction->transfer_transaction_id);

		$transferTransaction = Transaction::model()->findByPk($transferTransaction->id);
		$this->assertNull($transferTransaction);

		$transaction = Transaction::model()->findByPk($transaction->id);
		$this->assertNotNull($transaction);

		// Testing transfer again
		$transaction->transaction_type_id = Transaction::TYPE_TRANSFER;
		$transaction->to_account_id = $account2->id;
		$transaction->save();

		$this->assertNotNull($transaction->transfer_transaction_id);

		$transferTransaction = Transaction::model()->findByPk($transaction->transfer_transaction_id);
		$this->assertNotNull($transferTransaction);
	}

	public function testDeletingTransferDeletesTransferTransactionToo()
	{
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
		$transaction->save();
		$transaction_id = $transaction->id;

		// Testing transfer
		$this->assertNotNull($transaction->transfer_transaction_id);

		$transferTransaction = Transaction::model()->findByPk($transaction->transfer_transaction_id);
		$transferTransaction_id = $transferTransaction->id;
		$this->assertNotNull($transferTransaction);

		$transaction->delete();

		$this->assertNull(Transaction::model()->findByPk($transaction_id));
		$this->assertNull(Transaction::model()->findByPk($transferTransaction_id));
	}
    
    public function testGetConnectedTransaction()
    {
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
		$transaction->save();

		// Testing transfer
		$this->assertNotNull($transaction->transfer_transaction_id);

		$transferTransaction = $transaction->getConnectedTransaction();
		$this->assertEquals($transaction->transfer_transaction_id, $transferTransaction->id);
    }
    
    public function testNotTransferTransationsGetConnectedTransactionGivesItself()
    {
        list($transaction, $account1, $account2) = $this->_getTransferTransactionWithAccounts();
        $transaction->to_account_id = null;
        $transaction->transaction_type_id = Transaction::TYPE_EXPENSE;
        $transaction->save();

		// Testing transfer
		$this->assertNull($transaction->transfer_transaction_id);
		$this->assertNull($transaction->to_account_id);

		$transferTransaction = $transaction->getConnectedTransaction();
		$this->assertNull($transferTransaction);
    }
}
