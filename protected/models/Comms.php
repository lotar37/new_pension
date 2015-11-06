<?php

/**
 * This is the model class for table "comms".
 *
 * The followings are the available columns in table 'comms':
 * @property integer $id
 * @property string $name
 * @property string $rubr
 * @property string $code
 * @property string $address
 * @property integer $counter
 * @property integer $bank
 *
 * The followings are the available model relations:
 * @property Banks $bank0
 * @property Cases[] $cases
 */
class Comms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('counter, bank', 'numerical', 'integerOnly'=>true),
			array('rubr, code, address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, rubr, code, address, counter, bank', 'safe', 'on'=>'search'),
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
			'bank0' => array(self::BELONGS_TO, 'Banks', 'bank'),
			'cases' => array(self::HAS_MANY, 'Cases', 'comm'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'rubr' => 'Rubr',
			'code' => 'Code',
			'address' => 'Address',
			'counter' => 'Counter',
			'bank' => 'Bank',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('rubr',$this->rubr,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('counter',$this->counter);
		$criteria->compare('bank',$this->bank);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getComms(){
	    $connection=Yii::app()->db; 
		$sql = "SELECT * FROM comms;";
        $command=$connection->createCommand($sql);
		$modelTrChanges = $command->query();
		if(!isset($modelTrChanges))return null;
		$arr = $modelTrChanges->readAll();
		$arrS = array();
		foreach($arr as $one){
			$arrS[$one['id']] = $one['name'];
		}
		return $arrS;
		
	}
	public static function getName($id)
	{
		$model = self::model()->findByPk($id);
		return $model->name;
	}

}
