<?php

/**
 * This is the model class for table "auth.users".
 *
 * The followings are the available columns in table 'auth.users':
 * @property integer $id
 * @property string $username
 * @property string $title
 * @property string $password
 * @property integer $system
 * @property string $connect_time
 * @property string $create_time
 */
class Users extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auth.users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, title', 'required'),
			array('system', 'numerical', 'integerOnly'=>true),
			array('password, connect_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
// 			array('id, name, password, system, connect_time, create_time', 'safe', 'on'=>'search'),
			array('id, name, title, password, system', 'safe', 'on'=>'search'),
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
			'title' => 'Имя',
			'username' => 'Логин',
			'password' => 'Пароль',
			'system' => 'Системный',
			'connect_time' => 'Время подключения',
			'create_time' => 'Время создания',
			'roles' => 'Привилегии',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('title',$this->title,true);
// 		$criteria->compare('password',$this->password,true);
// 		$criteria->compare('system',$this->system);
// 		$criteria->compare('connect_time',$this->connect_time,true);
// 		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if(strlen($this->password)<32)
		{
			$this->password = md5($this->password);
		}
// 		if(!preg_match('/(^\$)+/', $this->password))
// 		{
// 			$this->password = CPasswordHelper::hashPassword($this->password);
// 		}
		return parent::beforeSave();
	}
	
	public function setRoles($roles)
	{
		$auth=Yii::app()->authManager;
		foreach($this->getRolesList($this->username) as $role=>$v)
		{
			if(!in_array($role, $roles))
			{
				$auth->revoke($role, $this->username);
			}
		}	
		foreach($roles as $role)
		{
			if(!key_exists($role, $this->getRolesList($this->username)))
			{
				$auth->assign($role, $this->username);
			}
		}	
	}
	
	public function getRoles()
	{
		$res = $this->getAllRolesList($this->username);
		return $this->id?implode("\n", $res):'';
	}

	public function getAllRolesList($user=null)
	{
		$roles = Yii::app()->authManager->getAuthItems(null, $user);

		$res = array();
		foreach ($roles as $item)
		{
			$res[$item->name]=$item->description;
		}
		return $res;
	}
	
	public function getRolesList()
	{
		return $this->id?$this->getAllRolesList($this->username):array();
	}

	public function beforeDelete() 
	{
		$res = parent::beforeDelete();
		$auth=Yii::app()->authManager;
		foreach($this->getRolesList($this->username) as $role=>$v)
		{
			$auth->revoke($role, $this->username);
		}
		return $res;
	}
	
	public function isSystem()
	{
		return $this->system==1;
	}
}
?>