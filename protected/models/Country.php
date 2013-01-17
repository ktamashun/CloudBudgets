<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property integer $id
 * @property string $iso
 * @property string $name
 * @property string $printable_name
 * @property string $iso3
 * @property integer $numcode
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class Country extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
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
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iso, name, printable_name', 'required'),
			array('numcode', 'numerical', 'integerOnly'=>true),
			array('iso', 'length', 'max'=>2),
			array('name, printable_name', 'length', 'max'=>80),
			array('iso3', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, iso, name, printable_name, iso3, numcode', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iso' => 'Iso',
			'name' => 'Name',
			'printable_name' => 'Printable Name',
			'iso3' => 'Iso3',
			'numcode' => 'Numcode',
		);
	}

	/*
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 *
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('printable_name',$this->printable_name,true);
		$criteria->compare('iso3',$this->iso3,true);
		$criteria->compare('numcode',$this->numcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function findAllAsDropDownListSource()
	{
		$countries = $this->findAll('', array('order' => 'name'));
		$data = array();

		foreach ($countries as $country) {
			$data[(int)$country->id] = $country->name;
		}

		return $data;
	}
}