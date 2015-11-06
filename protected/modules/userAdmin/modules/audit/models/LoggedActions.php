<?php

/**
 * This is the model class for table "audit.logged_actions".
 *
 * The followings are the available columns in table 'audit.logged_actions':
 * @property integer $id
 * @property integer $id_session
 * @property string $schema_name
 * @property string $table_name
 * @property string $action_tstamp
 * @property string $action
 * @property string $query
 *
 * The followings are the available model relations:
 * @property LoggedValues[] $loggedValues
 * @property LoggedSessions $idSession
 */
class LoggedActions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audit.audit_1';
// 		return 'audit.logged_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_session, schema_name, table_name, action_tstamp, action', 'required'),
			array('id_session', 'numerical', 'integerOnly'=>true),
			array('schema_name, table_name', 'length', 'max'=>32),
			array('action', 'length', 'max'=>1),
			array('query', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_session, schema_name, table_name, action_tstamp, action, query', 'safe', 'on'=>'search'),
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
			'loggedValues' => array(self::HAS_MANY, 'LoggedValues', 'id_action'),
			'idSession' => array(self::BELONGS_TO, 'LoggedSessions', 'id_session'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
// 			'id' => 'ID',
			'id_session' => 'Id сеанса',
			'user_name' => 'Пользователь',
			'table_comment' => 'Таблица',
			'action1' => 'Событие',
			'bt' => 'Начало сеанса',
			'et' => 'Конец сеанса',
			'at' => 'Время события',
			'pk_name' => 'Ключ',
			'pk_val' => 'Значение ключа',
			'column_comment' => 'Атрибут',
			'old_data' => 'Старое значение',
			'new_data' => 'Новое значение',
		);
		
		/*
		'id_session',
		'user_name',
// 		'begin_time',
		'bt',
// 		'end_time',
		'et',
		'at',
		'table_comment',
// 		'action_tstamp',
		'column_comment',
		'pk_name',
		'pk_val',
		'old_data',
		'new_data',
		'query',
		 */
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

// 		id 	pid 	user_name 	begin_time 	end_time 	id_action 	table_name 	pk_name 	pk_val 	action_tstamp 	action1 	field_name 	old_data 	new_data 	id_session

// 		$criteria->compare('id',$this->id);
		$criteria->compare('id_session',$this->id_session);
// 		$criteria->compare('schema_name',$this->schema_name,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('action_tstamp',$this->action_tstamp,true);
		$criteria->compare('action',$this->action,true);
// 		$criteria->compare('query',$this->query,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	function getBT()
	{
		return $this->dFormat($this->begin_time);
	}
	
	function getET()
	{
		return $this->dFormat($this->end_time);
	}
	
	function getAT()
	{
		return $this->dFormat($this->action_tstamp);
	}
	
	function dFormat($date)
	{
		return $date?date("d/m/Y H:i:s", strtotime($date)):'';
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoggedActions the static model class
	 */
	public static function model($className=__CLASS__)
	{
// 		return parent::model('audit_1');
		return parent::model($className);
	}
}
