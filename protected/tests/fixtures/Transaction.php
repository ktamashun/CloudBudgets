<?php

return array(
	'notSaved_1' => array(
		'date' => '2012-04-01',
		'description' => 'Test transaction',
		'transaction_type_id' => Transaction::TYPE_EXPENSE,
        'account_id' => 1,
        'to_account_id' => null,
        'transfer_transaction_id' => null,
		'category_id' => 3,
		'amount' => 3200.00,
        'account_balance' => -3200.00,
		'transaction_status_id' => Transaction::STATUS_CLEARED,
        'deleted' => 0
	),
);
