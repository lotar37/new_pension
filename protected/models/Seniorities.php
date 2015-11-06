<?php

/**
 * This is the model class for table "seniorities".
 *
 * The followings are the available columns in table 'seniorities':
 * @property integer $id
 * @property integer $person
 * @property string $type
 * @property string $class
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property Persons $person0
 */
class Seniorities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seniorities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person, type, class', 'required'),
			array('person, value', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person, type, class, value', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'person' => 'Person',
			'type' => 'Type',
			'class' => 'Class',
			'value' => 'Value',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Seniorities the static model class
	 */
	public static function commonSumma($id){
		$a_class = Seniorities::getSenioritiesClasses();
		$content = Seniorities::model()->findAllByAttributes(array("person"=>$id));
		if(isset($content))
		foreach($content as $one){
			if(!isset($out[$one->class]))$out[$one->class] = array();
			$out[$one->class][$one->type] = $one->value;
		}
		$common = array("d"=>0,"m"=>0,"y"=>0);
		for($i=1;$i<=3;$i++){
			$common["d"] += isset($out[$a_class[$i]]["d"]) ? $out[$a_class[$i]]["d"] : 0;
			$common["m"] += isset($out[$a_class[$i]]["m"]) ? $out[$a_class[$i]]["m"] : 0;
			$common["y"] += isset($out[$a_class[$i]]["y"]) ? $out[$a_class[$i]]["y"] : 0;
		}
		$month_plus = floor($common["d"]/30);
		$common["d"] -= $month_plus*30;
		$common["m"]+=$month_plus;
		$year_plus = floor($common["m"]/12);
		$common["m"] -= $year_plus*12;
		$common["y"] += $year_plus;

		return $common;
	}
	public static function saveSenioities($id,$class,$data){
		$a_class = Seniorities::getSenioritiesClasses();
		$a_types = array("d"=>0,"m"=>0,"y"=>0);
		$a = Seniorities::model()->findAllByAttributes(array("person"=>$id,"class"=>$a_class[$class]));
		foreach($a as $one){
			$a_types[$one["type"]]++;
		}
		foreach($a_types as $k=>$one){
			if($one>0)continue;
			$model = new Seniorities;
			$model->person = $id;
			$model->type = $k;
			$model->class = $a_class[$class];
			$model->save();
		}
		$a = Seniorities::model()->findAllByAttributes(array("person"=>$id,"class"=>$a_class[$class]));
		foreach($a as $one){
			$model_sen = Seniorities::model()->findByPk($one["id"]);
			$model_sen->value = $data[$model_sen["type"]];
			$model_sen->save();
		}
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getSenioritiesClasses(){
		
		return array("common","calendar","privilege","study","mia");
	}
}
