<?php

return array(
	'cashAccount_1' => array(
		'user_id' => 1,
		'account_type_id' => Account::TYPE_CASH,
		'name' => 'Cash 1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'actual_balance' => 0.00,
		'status' => Account::STATUS_ACTIVE
	),

	'activeAccount_1' => array(
		'user_id' => 1,
		'account_type_id' => Account::TYPE_CHECKING,
		'name' => 'Active 1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'actual_balance' => 0.00,
		'status' => Account::STATUS_ACTIVE
	),

	'inactiveAccount_1' => array(
		'user_id' => 1,
		'account_type_id' => Account::TYPE_CASH,
		'name' => 'Inactive 1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'actual_balance' => 0.00,
		'status' => Account::STATUS_INACTIVE
	),

	'deletedAccount_1' => array(
		'user_id' => 1,
		'account_type_id' => Account::TYPE_CASH,
		'name' => 'Deleted 1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'actual_balance' => 0.00,
		'status' => Account::STATUS_DELETED
	),

	'unsavedAccount_1' => array(
		'user_id' => 1,
		'account_type_id' => Account::TYPE_CASH,
		'name' => 'Unsaved 1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'status' => Account::STATUS_ACTIVE
	),

	'transactionBalanceAccount_1' => array(
		'user_id' => 2,
		'account_type_id' => Account::TYPE_CASH,
		'name' => 'transactionBalanceAccount_1',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'status' => Account::STATUS_ACTIVE
	),

	'transactionBalanceAccount_2' => array(
		'user_id' => 2,
		'account_type_id' => Account::TYPE_CHECKING,
		'name' => 'transactionBalanceAccount_2',
		'currency_id' => 37,
		'initial_balance' => 0.00,
		'status' => Account::STATUS_ACTIVE
	),
);
