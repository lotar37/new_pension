<?php

/**
 * This is the model class for table "calc_params".
 *
 * The followings are the available columns in table 'calc_params':
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CalcGroups[] $calcGroups
 */
class CalcParams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calc_params';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, name', 'required'),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, name, description', 'safe', 'on'=>'search'),
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
			'calcGroups' => array(self::MANY_MANY, 'CalcGroups', 'calc_group_items(param, group)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'description' => 'Description',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getYearArray(){
		
		return array("2015"=>"","2014"=>"","2013"=>"","2012"=>"","2011"=>"");
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CalcParams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getParamsYearArray(){
		$models = self::model()->findAll();
		
		$a_year = self::getYearArray();
		$a_ret  = array();
		
		foreach($models as $one){
			$model = self::model()->findByPk($one->id);
			$a_ret[$one->id]["year"] = $a_year;
			$a_ret[$one->id]["name"] = $one->description."(".$one->name.")";
			foreach($model->calcGroups as $two){
				$year = Yii::app()->dateFormatter->format("y",$two->date);
				if(isset($a_ret[$one->id]["year"][$year])){
					$a_ret[$one->id]["year"][$year] = array("val" =>CalcGroupItems::getValue($two->id, $one->id),"two"=>$two->id);
				}
			}
		}
		return $a_ret;
	}
	public static function all()
	{
		$models = self::model()->findAll();
		return $models;
	}
	
}
