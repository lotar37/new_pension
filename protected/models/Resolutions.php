<?php

/**
 * This is the model class for table "resolutions".
 *
 * The followings are the available columns in table 'resolutions':
 * @property integer $person
 * @property string $ser
 * @property string $number
 * @property string $sent_date
 * @property string $begin_action_date
 * @property string $end_action_date
 *
 * The followings are the available model relations:
 * @property Persons $person0
 * @property ResolutionPayConditions[] $resolutionPayConditions
 */
class Resolutions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resolutions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person', 'required'),
			array('person', 'numerical', 'integerOnly'=>true),
			array('ser, number, sent_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person, ser, number, sent_date, begin_action_date, end_action_date', 'safe', 'on'=>'search'),
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
			'person0' => array(self::BELONGS_TO, 'Persons', 'person'),
			'resolutionPayConditions' => array(self::HAS_MANY, 'ResolutionPayConditions', 'person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'person' => 'Person',
			'ser' => 'Ser',
			'number' => 'Number',
			'sent_date' => 'Sent Date',
			'begin_action_date' => 'Begin Action Date',
			'end_action_date' => 'End Action Date',
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

		$criteria->compare('person',$this->person);
		$criteria->compare('ser',$this->ser,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('sent_date',$this->sent_date,true);
		$criteria->compare('begin_action_date',$this->begin_action_date,true);
		$criteria->compare('end_action_date',$this->end_action_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Resolutions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
