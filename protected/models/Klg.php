<?php

/**
 * This is the model class for table "klg".
 *
 * The followings are the available columns in table 'klg':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $short_name
 * @property string $nvl
 * @property string $begin_time
 * @property string $end_time
 * @property string $kobl
 * @property string $help
 * @property string $prvl
 * @property integer $parent
 *
 * The followings are the available model relations:
 * @property Klg $parent0
 * @property Klg[] $klgs
 */
class Klg extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'klg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('short_name, nvl, begin_time, end_time, kobl, help, prvl', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, short_name, nvl, begin_time, end_time, kobl, help, prvl, parent', 'safe', 'on'=>'search'),
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
			'parent0' => array(self::BELONGS_TO, 'Klg', 'parent'),
			'klgs' => array(self::HAS_MANY, 'Klg', 'parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'short_name' => 'Short Name',
			'nvl' => 'Nvl',
			'begin_time' => 'Begin Time',
			'end_time' => 'End Time',
			'kobl' => 'Kobl',
			'help' => 'Help',
			'prvl' => 'Prvl',
			'parent' => 'Parent',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('nvl',$this->nvl,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('kobl',$this->kobl,true);
		$criteria->compare('help',$this->help,true);
		$criteria->compare('prvl',$this->prvl,true);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Klg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
