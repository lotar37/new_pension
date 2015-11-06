<?php

/**
 * This is the model class for table "chaes".
 *
 * The followings are the available columns in table 'chaes':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $shot_name
 *
 * The followings are the available model relations:
 * @property Persons[] $persons
 */
class Constants extends CModel
{
	public static $menuItems = array(
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				
            );
	/**
	 * @return string the associated database table name
	 */
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chaes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
