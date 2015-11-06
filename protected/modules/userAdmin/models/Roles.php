<?php

Yii::import('application.modules.userAdmin.models._base.BaseRoles');

class Roles extends BaseRoles
{
	public static function model($className=__CLASS__) 
	{
		return parent::model($className);
	}
	
	public function beforeValidate()
	{
		$this->type = CAuthItem::TYPE_ROLE;
		return true;
	}
	
	public function rules() {
		return array(
				array('name, type', 'required'),
				array('type', 'numerical', 'integerOnly'=>true),
				array('name', 'length', 'max'=>64),
				array('description, bizrule, data', 'safe'),
				array('description, bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
				array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
		);
	}
	public function defaultScope()
	{
		return array
		(
				'condition'=>"type=". CAuthItem::TYPE_ROLE ,
		);
	}
	
}