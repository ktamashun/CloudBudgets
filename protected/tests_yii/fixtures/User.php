<?php

return array(
	'testUser_1' => array(
        'id' => 1,
		'name' => 'Péter',
		'username' => 'Test',
		'email_address' => 'testUser_1@usoft.eu',
		'password' => UserIdentity::encodePassword('its_a_secret_testUser_1'),
		'original_password' => 'its_a_secret_testUser_1',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37
	),

	'activeUser_1' => array(
        'id' => 2,
		'name' => 'Péter',
		'username' => 'Test',
		'email_address' => 'activeUser_1@usoft.eu',
		'password' => UserIdentity::encodePassword('its_a_secret_activeUser_1'),
		'original_password' => 'its_a_secret_activeUser_1',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_ACTIVE
	),

	'inactiveUser_1' => array(
        'id' => 3,
		'name' => 'Péter',
		'username' => 'Test',
		'email_address' => 'inactiveUser_1@usoft.eu',
		'password' => UserIdentity::encodePassword('its_a_secret_inactiveUser_1'),
		'original_password' => 'its_a_secret_inactiveUser_1',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_INACTIVE
	),

	'transactionsTestUser_1' => array(
        'id' => 4,
		'name' => 'Péter',
		'username' => 'Test',
		'email_address' => 'inactiveUser_1@usoft.eu',
		'password' => UserIdentity::encodePassword('its_a_secret_inactiveUser_1'),
		'original_password' => 'its_a_secret_inactiveUser_1',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_INACTIVE
	),

	'activeUser_2' => array(
        'id' => 5,
		'name' => 'Péter',
		'username' => 'Test',
		'email_address' => 'activeUser_2@usoft.eu',
		'password' => UserIdentity::encodePassword('its_a_secret_activeUser_2'),
		'original_password' => 'its_a_secret_activeUser_2',
		'country_id' => 97,
		'city' => 'Budapest',
		'default_currency_id' => 37,
		'status' => User::STATUS_ACTIVE
	),
);
