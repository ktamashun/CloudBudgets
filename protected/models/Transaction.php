<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property integer $id
 * @property string $created_at
 * @property integer $transaction_type_id
 * @property string $date
 * @property string $description
 * @property integer $account_id
 * @property integer $to_account_id
 * @property integer $transfer_transaction_id
 * @property integer $category_id
 * @property float $amount
 * @property float $account_balance
 * @property integer $transaction_status_id
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Transaction $transferTransaction
 * @property Transaction[] $transactions
 * @property Account $account
 * @property Category $category
 * @property TransactionStatus $transactionStatus
 * @property TransactionType $transactionType
 *
 * The following are methods
 * @method Transaction findByPk() findByPk(int $id) Finds a $transaction by its primary key.
 */
class Transaction extends CActiveRecord
{
	const STATUS_CLEARED = 1;
	const STATUS_PENDING = 2;

	const TYPE_EXPENSE = 1;
	const TYPE_INCOME = 2;
	const TYPE_TRANSFER = 3;

	public $FOUND_ROWS = null;
	public $sumAmount = null;

	protected $_transferTransaction_is_saved = false;
	protected $_old_account_id = null;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transaction the static model class
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_type_id, date, description, account_id, category_id, amount', 'required'),
			array('transaction_type_id, account_id, to_account_id, transfer_transaction_id, category_id, transaction_status_id, deleted', 'numerical', 'integerOnly'=>true),
			array('amount, account_balance', 'numerical'),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, description, created_at, transaction_type_id, account_id, transfer_transaction_id, category_id, amount, account_balance, transaction_status_id, deleted', 'safe', 'on'=>'search'),

			array('account_id', 'compare', 'compareAttribute' => 'to_account_id', 'allowEmpty' => true, 'operator' => '!=', 'message' => "'Transfer to account' must be different from 'Account'!"),
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
			'transferTransaction' => array(self::BELONGS_TO, 'Transaction', 'transfer_transaction_id'),
			'transactions' => array(self::HAS_MANY, 'Transaction', 'transfer_transaction_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'toAccount' => array(self::BELONGS_TO, 'Account', 'to_account_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'transactionStatus' => array(self::BELONGS_TO, 'TransactionStatus', 'transaction_status_id'),
			'transactionType' => array(self::BELONGS_TO, 'TransactionType', 'transaction_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			//'created_at' => 'Created At',
			'date' => 'Date',
			'description' => 'Description',
			'transaction_type_id' => 'Transaction Type',
			'account_id' => 'Account',
			'to_account_id' => 'Transfer to account',
			'transfer_transaction_id' => 'Transfer Transaction',
			'category_id' => 'Category',
			'amount' => 'Amount',
			'account_balance' => 'Account Balance',
			'transaction_status_id' => 'Transaction Status',
			'deleted' => 'Deleted',
		);
	}

	public function beforeSave()
	{
		if ($this->transaction_type_id == self::TYPE_EXPENSE) {
			$this->amount = -1 * abs($this->amount);
			$this->to_account_id = null;
		} else if ($this->transaction_type_id == self::TYPE_INCOME) {
			$this->amount = abs($this->amount);
			$this->to_account_id = null;
		} else if ($this->transaction_type_id == self::TYPE_TRANSFER && $this->to_account_id !== null) {
			$this->amount = -1 * abs($this->amount);
		}

		if ($this->transaction_type_id != self::TYPE_TRANSFER) {
			if (null !== $this->transferTransaction) {
				$this->transferTransaction->delete();
			}

			$this->to_account_id = null;
			$this->transfer_transaction_id = null;
		}

		return parent::beforeSave();
	}

	public function afterSave()
	{
		if ($this->transaction_type_id == self::TYPE_TRANSFER && $this->to_account_id !== null) {
			if (false === $this->_transferTransaction_is_saved) {
                $transferTransaction = $this->getTransferTransaction();
				$transferTransaction->save();

				if (false === $transferTransaction->save()) {
					throw new Exception('Error while saving the transfer transaction! ');
				}

				$this->transfer_transaction_id = $transferTransaction->id;
				$this->_transferTransaction_is_saved = true;
				$this->setIsNewRecord(false);
				$this->save();
			} else {
				$this->_transferTransaction_is_saved = false;
			}
		}

		$this->account->user->updateAccounts();

		return parent::afterSave();
	}

	public function afterDelete()
	{
		if ($this->isTransfer() && $this->transferTransaction !== null) {
			$this->transferTransaction->delete();
		}

		$this->account->user->updateAccounts();

		return parent::afterDelete();
	}

    /**
     * Returns the transfer transaction.
     *
     * @return Transaction
     */
    public function getTransferTransaction()
    {
        if ($this->getIsNewRecord() || null === $this->transferTransaction) {
            $transferTransaction = new Transaction();
        } else {
            $transferTransaction = $this->transferTransaction;
        }

        $transferTransaction->date = $this->date;
        $transferTransaction->description = $this->description;
        $transferTransaction->transaction_type_id = $this->transaction_type_id;
        $transferTransaction->account_id = $this->to_account_id;
        $transferTransaction->to_account_id = null;
        $transferTransaction->transfer_transaction_id = null;
        $transferTransaction->category_id = $this->category_id;
        $transferTransaction->amount = abs($this->amount);
        $transferTransaction->account_balance = 0;
        $transferTransaction->transaction_status_id = $this->transaction_status_id;
        $transferTransaction->deleted = $this->deleted;

        return $transferTransaction;
    }

	public function getBalance($user, $account = null)
	{
		if (null === $account) {
			$criteria = new CDbCriteria();
			$criteria->select = 'SUM(t.amount) AS sumAmount';
			//$criteria->condition = "t.date <= '{$this->date}' AND t.id <= '{$this->id}'";
			$criteria->condition = "((t.date < '{$this->date}') OR (t.date = '{$this->date}' AND t.id <= {$this->id})) AND t.transaction_type_id <> " . self::TYPE_TRANSFER;
			$criteria->with = array(
				'account' => array(
					'select' => false,
					'joinType' => 'INNER JOIN',
					'condition' => 'account.user_id = ' . $user->id,
				)
			);
			//$criteria->group = 'account.user_id';
			$sumRow = Transaction::model()->find($criteria);
			$sumAmount = $user->totalInitialBalance;

			if (null !== $sumRow) {
				$sumAmount += $sumRow->sumAmount;
			}

			return $sumAmount;
		}

		$criteria = new CDbCriteria();
		$criteria->select = 'SUM(t.amount) AS sumAmount';
		$criteria->condition = "((t.date < '{$this->date}') OR (t.date = '{$this->date}' AND t.id <= {$this->id})) AND t.account_id = " . $account->id;
		$sumRow = Transaction::model()->find($criteria);
		$sumAmount = $account->initial_balance;

		if (null !== $sumRow) {
			$sumAmount += $sumRow->sumAmount;
		}

		return $sumAmount;
	}

	public function isTransfer()
	{
		return (int)$this->transaction_type_id === (int)self::TYPE_TRANSFER;
	}

	public function getConnectedTransaction()
	{
		if (null === $this->to_account_id) {
			return Transaction::model()->find('transfer_transaction_id = ' . $this->id);
		}

		return $this->transferTransaction;
	}
}