<?php

/**
 * This is the model class for table "bank_accounts".
 *
 * The followings are the available columns in table 'bank_accounts':
 * @property integer $id
 * @property integer $person
 * @property integer $bank
 * @property string $number
 * @property integer $is_actual
 *
 * The followings are the available model relations:
 * @property Payments[] $payments
 * @property Banks $bank0
 * @property Persons $person0
 */
class BankAccounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bank_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person, bank, number', 'required'),
			array('person, bank, is_actual', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person, bank, number, is_actual', 'safe', 'on'=>'search'),
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
			'payments' => array(self::HAS_MANY, 'Payments', 'account'),
			'bank0' => array(self::BELONGS_TO, 'Banks', 'bank'),
			'person0' => array(self::BELONGS_TO, 'Persons', 'person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'person' => 'Person',
			'bank' => 'Bank',
			'number' => 'Number',
			'is_actual' => 'Is Actual',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('bank',$this->bank);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('is_actual',$this->is_actual);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BankAccounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
