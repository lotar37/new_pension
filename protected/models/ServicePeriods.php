<?php

/**
 * This is the model class for table "service_periods".
 *
 * The followings are the available columns in table 'service_periods':
 * @property integer $id
 * @property integer $person
 * @property string $name
 * @property string $klg
 * @property string $nvl
 * @property string $begin_time
 * @property string $end_time
 */
class ServicePeriods extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_periods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person, name', 'required'),
			array('person', 'numerical', 'integerOnly'=>true),
			array('klg, nvl, begin_time, end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person, name, klg, nvl, begin_time, end_time', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'klg' => 'Klg',
			'nvl' => 'Nvl',
			'begin_time' => 'Begin Time',
			'end_time' => 'End Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('klg',$this->klg,true);
		$criteria->compare('nvl',$this->nvl,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServicePeriods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function datesCounting($date1,$date2,$nvl){
	
		$a_month = array(31,31,28,31,30,31,30,31,31,30,31,30,31);
		$str1 = explode("-",$date1);
		$str2 = explode("-",$date2);
		$date = $str2[2] - $str1[2];
		if($date>-1){
			$month = $str2[1] - $str1[1];
		}else{
			$date += $a_month[$str2[1]-1];
			$month = $str2[1] - $str1[1]-1;
		}
		if($month > -1){
			$year = $str2[0] - $str1[0];
	}else{
		$month +=12; 
		$year = $str2[0] - $str1[0]-1;
	}
	if($nvl>1){		
		$date *= $nvl;
		$month_plus = floor($date/30);
		$date = $date - $month_plus*30;
		
		$month = $month*$nvl + $month_plus;
		$year_plus = floor($month/12);
		$month = $month - $year_plus*12;
		$year = $year*$nvl + $year_plus;
	}
	return array($year, $month, $date);
	}
	public static function PeriodsSumma($person, $type){
		$periods = ServicePeriods::model()->findAllByAttributes(array("person"=>$person,"klg"=>$type));
		$summa = array("d"=>0,"m"=>0,"y"=>0);
		foreach($periods as $one){
			$nvl = 1;
			if($one["nvl"]>3){
				$klg = Klg::model()->findByPk($one["nvl"]);
				$nvl = $klg["nvl"];
			}

			$a = ServicePeriods::datesCounting($one["begin_time"],$one["end_time"],$nvl);
			$summa["y"]  += $a[0];
			$summa["m"] += $a[1];
			$summa["d"]  += $a[2];
		}
		$month_plus = floor($summa["d"]/30);
		$summa["d"] -= $month_plus*30;
		$summa["m"]+=$month_plus;
		$year_plus = floor($summa["m"]/12);
		$summa["m"] -= $year_plus*12;
		$summa["y"] += $year_plus;
		return $summa;
	}
}
