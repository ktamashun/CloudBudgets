<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property string $created_at
 * @property integer $user_id
 * @property integer $account_type_id
 * @property string $name
 * @property integer $currency_id
 * @property double $initial_balance
 * @property double $actual_balance
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property AccountType $accountType
 * @property Currency $currency
 * @property User $user
 * @property Transaction[] $transactions
 */
class Account extends CActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const STATUS_DELETED = 3;

	const TYPE_CASH = 1;
	const TYPE_CHECKING = 2;
	const TYPE_CREDIT_CARD = 3;
	const TYPE_SAVINGS = 4;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, account_type_id, name, currency_id, initial_balance', 'required'),
			array('user_id, account_type_id, currency_id, status', 'numerical', 'integerOnly'=>true),
			array('initial_balance, actual_balance', 'numerical'),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, user_id, account_type_id, name, currency_id, initial_balance, actual_balance, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'accountType' => array(self::BELONGS_TO, 'AccountType', 'account_type_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'transactions' => array(self::HAS_MANY, 'Transaction', 'account_id'),

			'transactionsSum' => array(self::STAT, 'Transaction', 'account_id', 'select' => 'SUM(amount)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_at' => 'Created At',
			'user_id' => 'User',
			'account_type_id' => 'Account Type',
			'name' => 'Account Name',
			'currency_id' => 'Currency',
			'initial_balance' => 'Initial Balance',
			'actual_balance' => 'Actual Balance',
			'status' => 'Status',
		);
	}

	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'status = ' . self::STATUS_ACTIVE
			),
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->actual_balance = $this->initial_balance;
		}

		$this->updateActualBalance();

		return parent::beforeSave();
	}

	public function updateActualBalance()
	{
		$this->actual_balance = $this->initial_balance + $this->transactionsSum;
		return $this;
	}

	/**
	 * Account::getTransactionsCriteria()
	 *
	 * @return CDbCriteria
	 */
	public function getTransactionsCriteria()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'COUNT(t.id) AS FOUND_ROWS';
		$criteria->group = 't.account_id';
		$criteria->condition = 't.account_id = ' . $this->id;
		$criteria->order = 't.date DESC, t.id DESC';
		$countRow = Transaction::model()->find($criteria);
		$foundRows = 0;

		if (null !== $countRow) {
			$foundRows = $countRow->FOUND_ROWS;
		}

		$criteria->select = array('*');
		$criteria->group = '';

		return array('criteria' => $criteria, 'foundRows' => $foundRows);
	}

	/**
	 * Deletes every transaction on this account and deleted the account itself.
	 *
	 * @return void
	 */
	public function deleteWithDeletingTransactions()
	{
		$command = Yii::app()->db->createCommand();
		$command->delete('transaction', 'account_id = :account_id', array('account_id' => $this->id));

		$command = Yii::app()->db->createCommand();
		$command->update(
			'transaction',
			array(
				'transaction_type_id' => Transaction::TYPE_EXPENSE,
				'transfer_transaction_id' => null,
				'to_account_id' => null
			),
			'to_account_id = :old_to_account_id',
			array('old_to_account_id' => $this->id)
		);

		$this->delete();
	}

	/**
	 * Moves every transaction on this account to the given account.
	 *
	 * @param Account $moveToAccount
	 * @return void
	 */
	public function moveTransactionsToAccount(Account $moveToAccount)
	{
		$command = Yii::app()->db->createCommand();
		$command->update(
			'transaction',
			array('account_id' => $moveToAccount->id),
			'account_id = :old_account_id',
			array('old_account_id' => $this->id)
		);

		$command = Yii::app()->db->createCommand();
		$command->update(
			'transaction',
			array('to_account_id' => $moveToAccount->id),
			'to_account_id = :old_to_account_id',
			array('old_to_account_id' => $this->id)
		);
	}

	public function getOrCreateModelByName($name, User $user)
	{
		$account = Account::model()->find('name = :name AND user_id = :user_id', array('name' => $name, 'user_id' => $user->id));

		if (null === $account) {
			$account = new Account();
			$account->user_id = $user->id;
			$account->name = $name;
			$account->initial_balance = 0;
			$account->actual_balance = 0;
			$account->status = self::STATUS_ACTIVE;
			$account->account_type_id = self::TYPE_CHECKING;
			$account->currency_id = $user->default_currency_id;
			$account->save();
		}

		return $account;
	}
}
