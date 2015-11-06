<?php

/**
 * This is the model class for table "audit.logged_values".
 *
 * The followings are the available columns in table 'audit.logged_values':
 * @property integer $id_action
 * @property string $field_name
 * @property string $old_data
 * @property string $new_data
 *
 * The followings are the available model relations:
 * @property LoggedActions $idAction
 */
class LoggedValues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audit.logged_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_action', 'required'),
			array('id_action', 'numerical', 'integerOnly'=>true),
			array('field_name', 'length', 'max'=>32),
			array('old_data, new_data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_action, field_name, old_data, new_data', 'safe', 'on'=>'search'),
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
			'idAction' => array(self::BELONGS_TO, 'LoggedActions', 'id_action'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_action' => 'Id Action',
			'field_name' => 'Field Name',
			'old_data' => 'Old Data',
			'new_data' => 'New Data',
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

		$criteria->compare('id_action',$this->id_action);
		$criteria->compare('field_name',$this->field_name,true);
		$criteria->compare('old_data',$this->old_data,true);
		$criteria->compare('new_data',$this->new_data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoggedValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
