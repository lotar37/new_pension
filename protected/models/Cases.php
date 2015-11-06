<?php

/**
 * This is the model class for table "cases".
 *
 * The followings are the available columns in table 'cases':
 * @property integer $id
 * @property string $type
 * @property integer $person
 * @property integer $recipient
 * @property integer $comm
 * @property integer $number
 * @property string $date
 * @property integer $status
 * @property double $rate
 * @property integer $need_care
 * @property integer $terminated
 * @property double $salary_post
 * @property double $salary_rank
 * @property integer $year_inc_percent
 * @property double $saved_summa
 *
 * The followings are the available model relations:
 * @property Payments[] $payments
 * @property Persons[] $persons
 * @property Calcs[] $calcs
 * @property Comms $comm0
 * @property Persons $person0
 * @property Persons $recipient0
 * @property CaseStatuses $status0
 */
class Cases extends CActiveRecord
{
	public static $how_many = 40;
	public static $a_types = array("ИН"=>"in","ПК"=>"pk","ВЛ"=>"vl","ВВ"=>"vv","СП"=>"sp","ВЗ"=>"vz");
	public static $a_types_ret = array("in"=>"ИН","pk"=>"ПК","vl"=>"ВЛ","vv"=>"ВВ","sp"=>"СП","vz"=>"ВЗ");
	public static $conditions = array("paystop"=>"","string"=>"","type"=>"","age"=>"","anch"=>"","chaes"=>"","war"=>"","showall"=>"","gender"=>"","terminated"=>"");
	public static $conditionNames = array("paystop"=>"Выплаты остановлены","string"=>"","type"=>"Тип пенсионного дела","age"=>"Возраст","anch"=>"","chaes"=>"ЧАЭС","war"=>"Участник БД","showall"=>"Показать все","gender"=>"Пол",);


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, person, number', 'required'),
			array('person, recipient, comm, number, status, need_care, terminated, year_inc_percent', 'numerical', 'integerOnly'=>true),
			array('rate, salary_post, salary_rank, saved_summa', 'numerical'),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, person, recipient, comm, number, date, status, rate, need_care, terminated, salary_post, salary_rank, year_inc_percent, saved_summa, include_seniority', 'safe', 'on'=>'search'),
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
			'payments' => array(self::HAS_MANY, 'Payments', 'case'),
			'persons' => array(self::MANY_MANY, 'Persons', 'dependants(case, dependant)'),
			'calcs' => array(self::HAS_MANY, 'Calcs', 'case'),
			'comm0' => array(self::BELONGS_TO, 'Comms', 'comm'),
			'person0' => array(self::BELONGS_TO, 'Persons', 'person'),
			'recipient0' => array(self::BELONGS_TO, 'Persons', 'recipient'),
			'status0' => array(self::BELONGS_TO, 'CaseStatuses', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function afterFind()	{
		//$this->date    = Yii::app()->dateFormatter->format("dd.MM.y",$this->date);
	}
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'person' => 'Person',
			'recipient' => 'Recipient',
			'comm' => 'Comm',
			'number' => 'Number',
			'date' => 'Date',
			'status' => 'Status',
			'rate' => 'Rate',
			'need_care' => 'Need Care',
			'terminated' => 'Terminated',
			'salary_post' => 'Salary Post',
			'salary_rank' => 'Salary Rank',
			'year_inc_percent' => 'Year Inc Percent',
			'saved_summa' => 'Saved Summa',
			'include_seniority' => 'include_seniority',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('person',$this->person);
		$criteria->compare('recipient',$this->recipient);
		$criteria->compare('comm',$this->comm);
		$criteria->compare('number',$this->number);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('need_care',$this->need_care);
		$criteria->compare('terminated',$this->terminated);
		$criteria->compare('salary_post',$this->salary_post);
		$criteria->compare('salary_rank',$this->salary_rank);
		$criteria->compare('year_inc_percent',$this->year_inc_percent);
		$criteria->compare('saved_summa',$this->saved_summa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getTypes(){
	    $connection=Yii::app()->db; 
		$sql = "SELECT DISTINCT type FROM cases;";
        $command=$connection->createCommand($sql);
		$modelTrChanges = $command->query();
		if(!isset($modelTrChanges))return null;
		$arr = $modelTrChanges->readAll();
		$arrS = array();
		foreach($arr as $one){
			$arrS[$one['type']] = $one['type'];
		}
		return $arrS;
		
	}
	public static function dbRequest($sql){
	    $connection=Yii::app()->db; 
        $command=$connection->createCommand($sql);
		return $command->query();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cases the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
