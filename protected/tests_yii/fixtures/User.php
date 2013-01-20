<?php

return array(
	'ktamasTest' => array(
        'id' => 1,
		'name' => 'Tamás',
		'username' => 'Kovács',
		'email_address' => 'ktamas@cloudbudgets.com',
		'password' => UserIdentity::encodePassword('kissPista'),
		'original_password' => 'kissPista',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_ACTIVE
	),
    
	'kpistaTest' => array(
        'id' => 2,
		'name' => 'Pista',
		'username' => 'Kiss',
		'email_address' => 'kpista@cloudbudgets.com',
		'password' => UserIdentity::encodePassword('kissPista'),
		'original_password' => 'kissPista',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_ACTIVE
	),
);
