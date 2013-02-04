<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $created_at
 * @property integer $user_id
 * @property string $name
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Transaction[] $transactions
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name', 'required'), //created_at,
			array('user_id', 'numerical', 'integerOnly'=>true),
            array('name', 'ruleCheckUniqueName', 'unique' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, user_id, name', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'transactions' => array(self::HAS_MANY, 'Transaction', 'category_id'),
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
			'name' => 'Name',
		);
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'NestedSetBehavior' => array(
				'class' => 'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
				'hasManyRoots' => true,
				'leftAttribute' => 'lft',
				'rightAttribute' => 'rgt',
				'levelAttribute' => 'level',
				'rootAttribute' => 'root'
			)
		);
	}

	/**
	 * @param $field
	 * @param $options
	 */
	public function ruleCheckUniqueName($field, $options)
    {
        if ($this->getIsNewRecord()) {
            $category = Category::model()->find('name = :name AND user_id = :user_id', array('name' => $this->name, 'user_id' => $this->user_id));

    		if (null !== $category) {
    			$this->addError('name', 'A category with this name already exists.');
    		}
        }
    }

	/**
	 * @param $name
	 * @param User $user
	 *
	 * @return array|CActiveRecord|Category|mixed|null
	 */
	public function getOrCreateModelByName($name, User $user)
	{
		$category = Category::model()->find('name = :name AND user_id = :user_id', array('name' => $name, 'user_id' => $user->id));

		if (null === $category) {
			$category = new Category();
			$category->user_id = $user->id;
			$category->name = $name;
			$category->appendTo($user->getRootCategory(), false);
		}

		return $category;
	}

	/**
	 * Category::getTransactionsCriteria()
	 *
	 * @return CDbCriteria
	 */
	public function getTransactionsCriteria()
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'COUNT(t.id) AS FOUND_ROWS';
        $criteria->join = 'JOIN category c ON (c.user_id = ' . $this->user_id . ' AND c.id = t.category_id AND c.lft >= ' . $this->lft . ' AND c.rgt <= ' . $this->rgt . ')';
		$criteria->group = 'c.user_id';
		$criteria->order = 't.date DESC, t.id DESC';
		$countRow = Transaction::model()->find($criteria);
		$foundRows = 0;

		if (null !== $countRow) {
			$foundRows = $countRow->FOUND_ROWS;
		}

		$criteria->select = array('*');
		$criteria->group = 't.id';

		return array('criteria' => $criteria, 'foundRows' => $foundRows);
	}

	/**
	 * @param null $dateFrom
	 * @param null $dateTo
	 * @return array
	 */public function getReportCriteria($dateFrom = null, $dateTo = null)
       {
            $criteria = new CDbCriteria();
            $criteria->select = 'SUM(t.value) AS transactionSum';
            $criteria->join = 'JOIN category c ON (c.user_id = ' . $this->user_id . ' AND c.id = t.category_id AND c.lft >= ' . $this->lft . ' AND c.rgt <= ' . $this->rgt . ')';
            $criteria->group = 'c.user_id';
            $criteria->order = 't.date DESC, t.id DESC';
            $countRow = Transaction::model()->find($criteria);
            $foundRows = 0;

            if (null !== $countRow) {
                $foundRows = $countRow->FOUND_ROWS;
            }

            $criteria->select = array('*');
            $criteria->group = 't.id';

            return array('criteria' => $criteria, 'foundRows' => $foundRows);
       }

	/**
	 * Returns the base categories.
	 *
	 * @return array An recursive associative array containing the base categories.
	 */
	public static function getBaseCategories()
	{
		return array(
			'Food' => array(
				'Breakfast',
				'Lunch',
				'Dinner',
				'Grocery'
			),
			'Cloths',
			'Salary' => array(
				'Premium'
			),
			'Travel' => array(
				'Public transportation',
				'Car',
				'Plane',
				'Taxi'
			),
			'Holiday',
			'Gifts',
			'Health' => array(
				'Pharmacy',
				'Doctor',
				'Dentist'
			),
			'Services' => array(
				'Insurance',
				'Financial services'
			),
			'Home' => array(
				'Rent', 'Furniture',
				'Bills' => array(
					'Electricity',
					'Phone',
					'Internet'
				)
			),
			'Shopping',
			'Education',
			'Entertainment' => array(
				'Cinema',
				'Theatre',
				'Concert',
				'Restaurant',
				'Cafe'
			),
			'Personal Care' => array(
				'Hair dresser'
			)
		);
	}
}