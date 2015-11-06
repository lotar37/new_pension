<?php

/**
 * This is the model class for table "ident_docs".
 *
 * The followings are the available columns in table 'ident_docs':
 * @property integer $person
 * @property string $type
 * @property string $series
 * @property string $number
 * @property string $give_org
 * @property string $give_date
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property Persons $person0
 */
class IdentDocs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ident_docs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person, type, series, number', 'required'),
			array('person', 'numerical', 'integerOnly'=>true),
			array('give_org, give_date, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person, type, series, number, give_org, give_date, comment', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'person' => 'Person',
			'type' => 'Type',
			'series' => 'Series',
			'number' => 'Number',
			'give_org' => 'Give Org',
			'give_date' => 'Give Date',
			'comment' => 'Comment',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('series',$this->series,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('give_org',$this->give_org,true);
		$criteria->compare('give_date',$this->give_date,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IdentDocs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
