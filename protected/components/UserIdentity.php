<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 *
 */
class UserIdentity extends CUserIdentity
{
	public $user = null;


	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()
			->active()
			->find('email_address = :email_address AND password = :password', array('email_address' => $this->username, 'password' => self::encodePassword($this->password)));

		if(null === $user) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			//$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else {
			$this->errorCode=self::ERROR_NONE;
			$this->user = $user;
		}

		return !$this->errorCode;
	}

	/**
	 * Encrypts the password using md5 encryption.
	 *
	 * @param string $password
	 * @return string
	 */
	public static function encodePassword($password)
	{
		return md5($password);
	}

	public function getName()
	{
		return $this->user->name;
	}

	public function getId()
	{
		return $this->user->id;
	}
}