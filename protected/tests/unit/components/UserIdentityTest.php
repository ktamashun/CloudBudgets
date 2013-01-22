<?php

class UserIdentityTest extends CDbTestCase
{
	public $fixtures = array(
		'users' => 'User',
	);


	public function testEncodePassword()
	{
		$password = 'Test password string';
		$encryptedPassword = md5($password);

		$this->assertEquals($encryptedPassword, UserIdentity::encodePassword($password));
	}

	public function testLoginWithCorrectCredentials()
	{
		$userRow = $this->users['ktamasTest'];

		$identity = new UserIdentity($userRow['email_address'], $userRow['original_password']);
		$this->assertTrue($identity->authenticate());
		$this->assertEquals($userRow['id'], $identity->user->id);
	}

	public function testLoginWithIncorrectCorrectCredentials()
	{
		$userRow = $this->users['ktamasTest'];

		$identity = new UserIdentity($userRow['email_address'], 'incorrect_password');
		$this->assertFalse($identity->authenticate(), 'Authentication was successful with incorrect password!');
		$this->assertNull($identity->user);

		$identity = new UserIdentity('incorrect_email_address@usoft.eu', $userRow['original_password']);
		$this->assertFalse($identity->authenticate(), 'Authentication was successful with incorrect email_address!');
		$this->assertNull($identity->user);
	}

	public function testLoginUnsuccessfulWithInactiveUser()
	{
		$userRow = $this->users['ktamasTest'];
        
        $user = User::model()->find($userRow['id']);
        $user->status = User::STATUS_INACTIVE;
        $user->save();

		$identity = new UserIdentity($userRow['email_address'], $userRow['original_password']);
		$this->assertFalse($identity->authenticate(), 'Authentication was successful with inactive user!');
		$this->assertNull($identity->user);
	}
}
