<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $created_at
 * @property string $name
 * @property string $username
 * @property string $email_address
 * @property string $password
 * @property integer $country_id
 * @property string $city
 * @property integer $default_currency_id
 * @property integer $status
 * @property string $activation_code
 *
 * The followings are the available model relations:
 * @property Account[] $accounts
 * @property Category[] $categories
 * @property Country $country
 * @property UserLogin[] $userLogins
 */
class User extends CActiveRecord
{
	/**
	 *
	 */
	const STATUS_INACTIVE = 0;
	/**
	 *
	 */
	const STATUS_ACTIVE = 1;

	/**
	 * @var null
	 */
	public $password2 = null;
	/**
	 * @var null
	 */
	public $verifyCode = null;

	/**
	 * @var null
	 */
	protected static $_loggedInUser = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, username, email_address, password, country_id, city, default_currency_id', 'required'),
			array('country_id, default_currency_id, status', 'numerical', 'integerOnly'=>true),
			array('name, email_address', 'length', 'max'=>255),
			array('username, password, activation_code', 'length', 'max'=>50),
			array('password', 'length', 'min'=>6),
			array('city', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, name, username, email_address, password, country_id, city, default_currency_id, status, activation_code', 'safe', 'on'=>'search'),

			array('email_address', 'unique', 'className' => 'User'),
			array('password', 'compare', 'compareAttribute' => 'password2', 'on' => 'register'),
			array('password2,verifyCode', 'required', 'on' => 'register'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on' => 'register')
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
			'accounts' => array(self::HAS_MANY, 'Account', 'user_id'),
			'categories' => array(self::HAS_MANY, 'Category', 'user_id', 'condition' => 'root <> id', 'order' => 'lft'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'defaultCurrency' => array(self::BELONGS_TO, 'Currency', 'default_currency_id'),
			'userLogins' => array(self::HAS_MANY, 'UserLogin', 'user_id'),

			'transactions' => array(
				self::HAS_MANY,
				'Transaction',
				array('id' => 'account_id'),
				'through' => 'accounts',
				'joinType' => 'INNER JOIN',
				'order' => '`transactions`.`date` DESC, `transactions`.`id` DESC'
			),

			'totalBalance' => array(self::STAT, 'Account', 'user_id', 'select' => 'SUM(actual_balance)'),
			'totalInitialBalance' => array(self::STAT, 'Account', 'user_id', 'select' => 'SUM(initial_balance)'),
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
			'name' => 'First name',
			'username' => 'Last name',
			'email_address' => 'Email Address',
			'password' => 'Password',
			'password2' => 'Retype password',
			'country_id' => 'Country',
			'city' => 'City',
			'default_currency_id' => 'Default Currency',
			'status' => 'Status',
			'activation_code' => 'Activation Code',
			'verifyCode'=>'Verification Code',
		);
	}

	/**
	 * @return bool
	 */
	public function beforeSave()
	{
		if ($this->getScenario() === 'register' && $this->isNewRecord) {
			$this->status = self::STATUS_INACTIVE;
			$this->activation_code = $this->generateActivationCode();
			$this->password = UserIdentity::encodePassword($this->password);
		}

		return parent::beforeSave();
	}

	/**
	 *
	 */
	public function afterSave()
	{
		if ($this->getScenario() === 'register') {
			$this->registerTasks();
		}

		return parent::afterSave();
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'status = ' . self::STATUS_ACTIVE,
			),

			'inactive' => array(
				'condition' => 'status = ' . self::STATUS_INACTIVE,
			),
		);
	}

	/**
	 * @return string
	 */
	public function generateActivationCode()
	{
		$code = md5('ltsuActivate_' . $this->email_address . '_' . mktime());
		return $code;
	}

	/**
	 * @return bool
	 */
	public function sendActivationEmail()
	{
		return false;
	}

    /**
	 * Runs some task after registration.
	 *
	 * Creates a user directory.
	 * Creates the base categories for the user.
     *
     * @return bool True if successful.
     */
    public function registerTasks()
	{
		$this->createDirectory();
		$this->createBaseCategories();

		return true;
	}

	/**
	 * Created the base categories for the user.
	 *
	 * @throws Exception If the user is not saved yet.
	 */
	public function createBaseCategories()
	{
		if (null === $this->id) {
			throw new Exception('The user must be saved before it can have categories!');
		}

		$baseCategories = Category::getBaseCategories();
		$rootCategory = $this->getRootCategory();

		if (null === $rootCategory) {
			$rootCategory = new Category();
			$rootCategory->name = 'All';
			$rootCategory->user_id = $this->id;
			$rootCategory->saveNode(false);
		}

		$this->_insertCategoriesFromRecursiveArray($rootCategory, $baseCategories);
	}

	/**
	 * Adds the provided categories to the user.
	 *
	 * @param Category $parentCategory
	 * @param array $categories
	 */
	protected function _insertCategoriesFromRecursiveArray(Category $parentCategory, $categories)
	{
		foreach ($categories as $key => $value) {
			if (is_array($value)) {
				$newCategory = new Category();
				$newCategory->name = $key;
				$newCategory->user_id = $this->id;
				$newCategory->appendTo($parentCategory, false);

				$this->_insertCategoriesFromRecursiveArray($newCategory, $value);
			} else {
				$newCategory = new Category();
				$newCategory->name = $value;
				$newCategory->user_id = $this->id;
				$newCategory->appendTo($parentCategory, false);
			}
		}
	}

	/**
	 *
	 */
	public function createDirectory()
	{
		$dirId = str_pad($this->id, 10, "0", STR_PAD_LEFT);
		$dirs = array(
			substr($dirId, 0, 2),
			substr($dirId, 2, 2),
			substr($dirId, 4, 2),
			substr($dirId, 6, 2),
			substr($dirId, 8, 2)
		);

		$userDirectoriesPath = YiiBase::getPathOfAlias('application.assets.userDirectories');
		$currentDirPath = $userDirectoriesPath;

		foreach ($dirs as $dir) {
			$currentDirPath = $currentDirPath . DIRECTORY_SEPARATOR . $dir;
			if (!file_exists($currentDirPath)) {
				mkdir($currentDirPath);
			}
		}
	}

	/**
	 * @return bool
	 */
	public function activate()
	{
		$this->status = self::STATUS_ACTIVE;
		$this->activation_code = null;
		$this->save();

		return true;
	}

	/**
	 * @return array|CActiveRecord|mixed|null
	 */
	public static function getLoggedInUser()
	{
        if (null === self::$_loggedInUser) {
            self::$_loggedInUser = self::model()->findByPk(Yii::app()->user->id);
        }

		return self::$_loggedInUser;
	}

	/**
	 * @param $accountType
	 *
	 * @return mixed
	 */public function getAccountsByType($accountType)
	{
		return $this->accounts(array('condition' => 'status = ' . Account::STATUS_ACTIVE . ' AND account_type_id = ' . (int)$accountType));
	}

	/**
	 * @return array
	 */public function getAccountsAsDropDownListSource()
	{
		$accounts = $this->accounts(array('condition' => 'status = ' . Account::STATUS_ACTIVE));
		$data = array();

		foreach ($accounts as $account) {
			$data[(int)$account->id] = $account->name;
		}

		return $data;
	}

	/**
	 * @return array
	 */public function getCategoriessAsDropDownListSource()
	{
		$data = array();

		$level=0;
		$categories = $this->categories; //Category::model()->findAll(array('condition' => 'root = 1', 'order' => 'lft'));

		foreach($categories as $n=>$category) {
		    $preText = '';
		    $level=$category->level - 1;

		    for ($i = 0; $i < $level; $i++) {
		    	$preText .= '';
		    }

			$data[(int)$category->id] = $preText . $category->name;
		}

		return $data;
	}

	/**
	 * @param Account $account
	 * @return bool
	 */public function hasRightToAccount(Account $account)
	{
		return $account->user_id === $this->id;
	}

	/**
	 * @param Category $category
	 * @return bool
	 */public function hasRightToCategory(Category $category)
	{
		return $category->user_id === $this->id;
	}

	/**
	 * @param Transaction $transaction
	 * @return bool
	 */public function hasRightToTransaction(Transaction $transaction)
	{
		return $transaction->account->user_id === $this->id;
	}

	/*public function hasRightToBudget(Budget $budget)
	{
		return $budget->user_id === $this->id;
	}*/

	/**
	 * User::getTransactionsCriteria()
	 *
	 * @return CDbCriteria
	 */
	public function getTransactionsCriteria()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'COUNT(t.id) AS FOUND_ROWS';
		$criteria->order = 't.date DESC, t.id DESC';
		$criteria->with = array(
			'account' => array(
				'select' => false,
				'joinType' => 'INNER JOIN',
				'condition' => 'account.user_id = ' . $this->id,
			)
		);
		$criteria->condition = '(t.transaction_type_id <> ' . Transaction::TYPE_TRANSFER . ' OR t.to_account_id IS NOT NULL)';
		$criteria->group = 'account.user_id';
		$countRow = Transaction::model()->find($criteria);
		$foundRows = 0;

		if (null !== $countRow) {
			$foundRows = $countRow->FOUND_ROWS;
		}

		$criteria->select = array('*');
		$criteria->group = '';
		$criteria->order = 't.date DESC, t.id DESC';

		return array('criteria' => $criteria, 'foundRows' => $foundRows);
	}

	/**
	 * User::getRootCategory()
	 *
	 * @return Category
	 */
	public function getRootCategory()
	{
		return Category::model()->find('root = id AND user_id = :user_id', array('user_id' => $this->id));
	}

	/**
	 *
	 */
    public function updateAccounts()
	{
		foreach ($this->accounts as $account) {
			$account->save();
		}
	}
}