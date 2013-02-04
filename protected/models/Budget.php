<?php

/**
 * This is the model class for table "budget".
 *
 * The followings are the available columns in table 'budget':
 * @property integer $id
 * @property string $created_at
 * @property integer $user_id
 * @property string $from_date
 * @property string $to_date
 * @property string $name
 * @property integer $limit
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Category $category
 */
class Budget extends CActiveRecord
{
	const STATUS_ACTIVE = 1;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Budget the static model class
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
		return 'budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, from_date, name, limit, category_id', 'required'),
			array('user_id, limit, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('to_date', 'safe'),
			array('category_id', 'exist', 'attributeName' => 'id', 'className' => 'Category', 'message' => 'Category does not exists.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, user_id, from_date, to_date, name, limit, active', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'category_id' => 'Category name',
			'from_date' => 'From Date',
			'to_date' => 'To Date',
			'name' => 'Name',
			'limit' => 'Limit',
			'active' => 'Active',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 *
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('limit',$this->limit);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'active = ' . self::STATUS_ACTIVE
			)
		);
	}

	/**
	 * Filters for the given user.
	 *
	 * @param User $user
	 * @return \Budget
	 */
	public function forUser(User $user)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'user_id = ' . (int)$user->id
		));

		return $this;
	}

	/**
	 * Budget::getTransactionsCriteria()
	 *
	 * @return CDbCriteria
	 */
	public function getTransactionsCriteria()
	{
		$criteria = new CDbCriteria();
		$criteria->select = array('*');
		$criteria->condition = 't.category_id = ' . $this->category_id;
		$criteria->order = 't.date DESC, t.id DESC';

		return $criteria;
	}

	public function getTransactionSumForMonth($date = null)
	{
		if ($date === null) {
			$date = date('Y-m-01');
		}

		$time = strtotime($date);
		$year = date('Y', $time);
		$month = date('m', $time);

		$criteria = $this->getTransactionsCriteria();
		$criteria->select = 'SUM(t.amount) AS sumAmount';
		$criteria->group = 't.category_id';
		$criteria->mergeWith(array(
			'condition' => "MONTH(`date`) = '" . $month . "' ANDd YEAR(`date`) = " . $year,
		));

		$row = Transaction::model()->find($criteria);
		var_dump($row); die();
	}

	public function getBalanceForMonth($date = null)
	{
		if ($date === null) {
			$date = date('Y-m-01');
		}

		return $this->transactionSum();
	}
}