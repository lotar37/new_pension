<?php

/**
 * This is the model class for table "persons".
 *
 * The followings are the available columns in table 'persons':
 * @property integer $id
 * @property string $second_name
 * @property string $first_name
 * @property string $third_name
 * @property string $birth_date
 * @property string $birth_place
 * @property string $pension_date
 * @property string $death_date
 * @property integer $is_duty_death
 * @property integer $rank
 * @property string $post_full_name
 * @property integer $dismiss
 * @property string $dismiss_date
 * @property string $phone
 * @property integer $is_working
 * @property integer $invalid_reason
 * @property integer $invalid_group
 * @property string $invalid_date
 * @property string $invalid_date2
 * @property integer $invalid_limit
 * @property integer $is_other_pension
 * @property string $snils
 *
 * The followings are the available model relations:
 * @property IdentDocs $identDocs
 * @property Cases[] $cases
 * @property Cases[] $cases1
 * @property BankAccounts[] $bankAccounts
 * @property Awards[] $awards
 * @property Chaes[] $chaes
 * @property WarActions[] $warActions
 * @property Dismisses $dismiss0
 * @property InvalidReasons $invalidReason
 * @property Posts[] $posts
 * @property Ranks $rank0
 * @property Seniorities[] $seniorities
 * @property Cases[] $cases2
 * @property Cases[] $cases3
 * @property Addrs $addrs
 * @property Resolutions $resolutions

 
  */
class Persons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $salary_post;
	public $salary_rank;
	public $year_inc_percent;
	public $saved_summa;
	public $type;
	public $resolution;
	public $trChanges;
	public $number;
	public $dismiss_code;
	public $rank_name;
	public $age;
	
	public function tableName()
	{
		return 'persons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('second_name, first_name, third_name', 'required'),
			array('is_duty_death, rank, dismiss, is_working, invalid_reason, invalid_group, invalid_limit, is_other_pension, number', 'numerical', 'integerOnly'=>true),
			array('birth_date, birth_place, pension_date, death_date, post_full_name, dismiss_date, phone, invalid_date, invalid_date2, snils, number', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, rank_name, second_name, first_name, third_name,', 'safe', 'on'=>'search'),
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
			'identDocs' => array(self::HAS_ONE, 'IdentDocs', 'person'),
			'awards' => array(self::MANY_MANY, 'Awards', 'person_awards(person, award)'),
			'warActions' => array(self::MANY_MANY, 'WarActions', 'person_war_actions(person, war_action)'),
            'posts' => array(self::MANY_MANY, 'Posts', 'person_posts(person, post)'),
			'chaes' => array(self::MANY_MANY, 'Chaes', 'person_chaes(person, chae)'),
			'cases' => array(self::MANY_MANY, 'Cases', 'dependants(dependant, case)'),
			'cases1' => array(self::MANY_MANY, 'Cases', 'caregiver_docs(giver, case)'),
			'dismiss0' => array(self::BELONGS_TO, 'Dismisses', 'dismiss'),
			'rank0' => array(self::BELONGS_TO, 'Ranks', 'rank'),
			'bankAccounts' => array(self::HAS_MANY, 'BankAccounts', 'person'),
			'cases2' => array(self::HAS_MANY, 'Cases', 'recipient'),
			'cases3' => array(self::HAS_ONE, 'Cases', 'person'),
			'addrs' => array(self::HAS_ONE, 'Addrs', 'person'),
			'invalidReason' => array(self::BELONGS_TO, 'InvalidReasons', 'invalid_reason'),
			'seniorities' => array(self::HAS_MANY, 'Seniorities', 'person'),
			'bankAccount' => array(self::HAS_ONE, 'BankAccounts', 'person'),
			'identDoc' => array(self::HAS_ONE, 'IdentDocs', 'person'),
            'resolutions' => array(self::HAS_ONE, 'Resolutions', 'person'),


			);
	}
		public function attributeTypes(){
		return array(
		'id' => 'integer',
		'second_name' => 'string',
		'first_name' => 'string',
		'third_name' => 'string',
		'birth_date' => 'date',
		'birth_place' => 'string',
		'pension_date' => 'date',
		'death_date' => 'date',
		'is_duty_death' => 'boolean',
		'rank' => 'integer',
		'post_full_name' => 'string',
		'dismiss' => 'integer',
		'dismiss_date' => 'date',
		'phone' => 'string',
		'is_working' => 'boolean',
		'invalid_reason' => 'integer',
		'invalid_group' => 'integer',
		'invalid_date' => 'date',
		'invalid_date2' => 'date',
		'invalid_limit' => 'integer',
		'is_other_pension' => 'boolean',
		'snils' => 'string'
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'second_name' => 'Фамилия',
			'first_name' => 'Имя',
			'third_name' => 'Отчество',
			'birth_date' => 'День рождения',
			'birth_place' => 'Место рождения',
			'pension_date' => 'Пенсия назначена',
			'death_date' => 'Дата смерти',
			'is_duty_death' => 'Смерть при исполнении',
			'rank' => 'В/звание',
			'post_full_name' => 'Должность',
			'dismiss' => 'Причина',
			'dismiss_date' => 'Дата увольнения',
			'phone' => 'Телефон',
			'is_working' => 'Работает',
			'invalid_reason' => 'Invalid Reason',
			'invalid_group' => 'Invalid Group',
			'invalid_date' => 'Invalid Date',
			'invalid_date2' => 'Invalid Date2',
			'invalid_limit' => 'Invalid Limit',
			'is_other_pension' => '2-я пенсия',
			'snils' => 'СНИЛС',
			'salary_post'=> 'salary_post',
			'year_inc_percent'=> 'year_inc_percent',
			'number'=> 'Номер',
			
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
public function searchUnion()
    {
        $criteria = new CDbCriteria;
        
        
        $criteria->with = array('cases3');
        //$criteria->join = 'LEFT JOIN cases  ON persons.id = cases.person';

                            
       // $criteria->order = 'case.number';
        
        $criteria->compare('rank0.name',    $this->rank_name, true);
        $criteria->compare('cases3.number', $this->number, true);
        $criteria->compare('second_name',   $this->second_name, true);
        $criteria->compare('first_name',    $this->first_name, false);
        $criteria->compare('third_name',    $this->third_name, true);
        $criteria->compare('birth_place',   $this->birth_place, true);
        $criteria->compare('birth_date',    $this->birth_date, true);



        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array('defaultOrder' => 'cases3.number asc',
                'attributes'=>array('cases3.number','rank0.name','cases3.type', 'second_name', 'first_name', 'third_name', 'birth_place', 'birth_date'),
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
            ));
	}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('second_name', !empty($this->second_name) ? strtoupper($this->second_name) : array(), true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('third_name',$this->third_name,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('pension_date',$this->pension_date,true);
		$criteria->compare('death_date',$this->death_date,true);
		$criteria->compare('is_duty_death',$this->is_duty_death);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('post_full_name',$this->post_full_name,true);
		$criteria->compare('dismiss',$this->dismiss);
		$criteria->compare('dismiss_date',$this->dismiss_date,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('is_working',$this->is_working);
		$criteria->compare('invalid_reason',$this->invalid_reason);
		$criteria->compare('invalid_group',$this->invalid_group);
		$criteria->compare('invalid_date',$this->invalid_date,true);
		$criteria->compare('invalid_date2',$this->invalid_date2,true);
		$criteria->compare('invalid_limit',$this->invalid_limit);
		$criteria->compare('is_other_pension',$this->is_other_pension);
		$criteria->compare('snils',$this->snils,true);
		$criteria->compare('number',$this->number);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort' => array(
				'defaultOrder' => 'second_name ASC',
				),
        )); 
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Persons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function createEmptyPerson($model){
		//$model = new Order;
		//$AreEmptyPerson = 	Person::model()->findAllByAttributes(array("second_name"=>"-"));
        //if(isset($AreEmptyPerson->id))return $AreEmptyPerson->id;
		$model->second_name ="-";
		$model->first_name="-";
		$model->third_name="-";
		if($model->save())echo "good_safeee";
		else{
			
			 echo var_dump($model->errors);
			 die();
		}
		return $model->id;
	}
	public function beforeSave()
	{
		if(!$this->isNewRecord){
			if(isset($_POST["waraction_inp"])){
			  $arr = explode(" ",$_POST["waraction_inp"]);
			  $curRec = PersonWarActions::model()->findAllByAttributes(array("person"=>$this->id));
			  foreach($curRec as $one){
			  	$one->delete();
			  }
			  foreach($arr as $k=>$v){
				if(!$v)continue;
				$warAct = WarActions::model()->findByAttributes(array("shot_name"=>$v));
				$mod = new PersonWarActions();
				$mod->person = $this->id;
				$mod->war_action = $warAct->id;
				$mod->save();
			  }
			}
			if(isset($_POST["post_inp"])){
			  $arr = explode(" ",$_POST["post_inp"]);
			  $curRec = PersonPosts::model()->findAllByAttributes(array("person"=>$this->id));
			  foreach($curRec as $one){
				$one->delete();
			  }
			  foreach($arr as $k=>$v){
				if(!$v)continue;
				$post = Posts::model()->findByAttributes(array("shot_name"=>$v));
				$mod = new PersonPosts();
				$mod->person = $this->id;
				$mod->post = $post->id;
				$mod->save();
			  }
			}
			if(isset($_POST["chaes_inp"])){	
		       $arr = explode(" ",$_POST["chaes_inp"]);
			   $curRec = PersonChaes::model()->findAllByAttributes(array("person"=>$this->id));
			   foreach($curRec as $one){
				  $one->delete();
			   }
               foreach($arr as $k=>$v){
				if(!$v)continue;
				$chaes = Chaes::model()->findByAttributes(array("shot_name"=>$v));
				$mod = new PersonChaes();
			    $mod->person = $this->id;
				$mod->chae = $chaes->id;
				$mod->save();
			  }
			}
		  
		}
		if(isset($_POST["dismiss"])){
		    $modelDismiss = Dismisses::model()->findByAttributes(array("code"=>$_POST["dismiss"]));
		    if(isset($modelDismiss->id))$this->dismiss = $modelDismiss->id;
		}
		if($this->birth_date)
			$this->birth_date    = date('Y-M-d', CDateTimeParser::parse($this->birth_date, "d.M.y"));
		else $this->birth_date = null;
		if($this->death_date)
			$this->death_date    = date('Y-M-d', CDateTimeParser::parse($this->death_date, "d.M.y"));
		else $this->death_date = null;
		if($this->dismiss_date)
			$this->dismiss_date  = date('Y-M-d', CDateTimeParser::parse($this->dismiss_date, "d.M.y"));
		else $this->dismiss_date = null;
		if($this->pension_date)
			$this->pension_date  = date('Y-M-d', CDateTimeParser::parse($this->pension_date, "d.M.y"));
		else $this->pension_date = null;
		if($this->invalid_date)
			$this->invalid_date  = date('Y-M-d', CDateTimeParser::parse($this->invalid_date, "d.M.y"));
		else $this->invalid_date = null;
		if($this->invalid_date2)
			$this->invalid_date2 = date('Y-M-d', CDateTimeParser::parse($this->invalid_date2, "d.M.y"));
		else $this->invalid_date2 = null;
		
		return parent::beforeSave();
	}
    protected function afterSave() {
		if($this->second_name != "-"){
 	    $arr_seniorities = Seniorities::getSenioritiesClasses();
        if($this->isNewRecord){ 
			/// сохранение военных действий
		    
			
	        if(isset($_POST["waraction_inp"])){
		        $arr = explode(" ",$_POST["waraction_inp"]);
		        foreach($arr as $k=>$v){
			        if(!$v)continue;
			        $warAct = WarActions::model()->findByAttributes(array("shot_name"=>$v));
			        $modelWarActions = new PersonWarActions();
			        $modelWarActions->person = $this->id;
			        $modelWarActions->war_action = $warAct->id;
			        $modelWarActions->save();
		        }
		    }
	        if(isset($_POST["chaes_inp"])){	
		       $arr = explode(" ",$_POST["chaes_inp"]);
               foreach($arr as $k=>$v){
				if(!$v)continue;
				$chaes = Chaes::model()->findByAttributes(array("shot_name"=>$v));
				$mod = new PersonChaes();
			    $mod->person = $this->id;
				$mod->chae = $chaes->id;
				$mod->save();
			}
			}
	        if(isset($_POST["post_inp"])){	
		       $arr = explode(" ",$_POST["post_inp"]);
               foreach($arr as $k=>$v){
				if(!$v)continue;
				$post = Posts::model()->findByAttributes(array("shot_name"=>$v));
				$mod = new PersonPosts();
			    $mod->person = $this->id;
				$mod->post = $post->id;
				$mod->save();
			}
		}
			// сохранение параметров 
            $modelCases = new Cases;
			$modelAddrs = new Addrs;
			$modelDocs  = new IdentDocs;
			$modelResolution = new Resolutions;
			/// сохранение выслуги лет
		    for($i=0;$i<5;$i++){
			     $class = $arr_seniorities[$i];
			    if(isSet($_POST["seniority_".$class])){
				    $value = $_POST["seniority_".$class];
				    $this->newSeniorities($class,$value);
			    }
		    }
         } else {
			 //обновление банковских данных
			$modelBankAccount = BankAccounts::model()->findByAttributes(array("person"=>$this->id));
			if(!isset($modelBankAccount))$modelBankAccount = new BankAccounts;
			$modelBankAccount->person = $this->id;
			$modelBankAccount->number = isset($_POST["l_schet"]) ? $_POST["l_schet"] : "";
			
			//обновление  данных карточки пенсионера
	        $modelCases = Cases::model()->findByAttributes(array("person"=>$this->id));
	        $modelAddrs = Addrs::model()->findByAttributes(array("person"=>$this->id));
			if(!isset($modelAddrs))$modelAddrs = new Addrs;
	        $modelDocs  = IdentDocs::model()->findByAttributes(array("person"=>$this->id));
			if(!isset($modelDocs))$modelDocs = new IdentDocs;
			$modelDocs->person = $this->id;
			$modelResolution = Resolutions::model()->findByAttributes(array("person"=>$this->id));		
			if(!isset($modelResolution))$modelResolution = new Resolutions;
			$modelResolution->person = $this->id;
			$types = array("y","m","d");
		    for($i=0;$i<5;$i++){
			    $class = $arr_seniorities[$i];
				for($j=0;$j<3;$j++){
			        if(isSet($_POST[$class."_".$types[$j]]) && $_POST[$class."_".$types[$j]]>0){
				        $value = $_POST[$class."_".$types[$j]];
				        if($this->checkSeniorities($types[$j],$class))$this->updateSeniorities($types[$j],$class,$value);
				        else $this->newSeniorities($types[$j],$class,$value);
			        }
				}
		    }
	     }
        $modelResolution->person = $this->id;
		$modelResolution->ser    =  isset($_POST["res_ser"]) ? $_POST["res_ser"] : "";
		$modelResolution->number =  isset($_POST["res_number"]) ? $_POST["res_number"] : "";
		$modelResolution->sent_date =  isset($_POST["res_sent_date"])&& $_POST["res_sent_date"] != "" ? date('Y-m-d', CDateTimeParser::parse($_POST["res_sent_date"],"d.M.y")) : NULL;
		$modelResolution->begin_action_date =  isset($_POST["res_begin_action_date"])&& $_POST["res_begin_action_date"] != "" ? date('Y-m-d', CDateTimeParser::parse($_POST["res_begin_action_date"],"d.M.y")) : NULL;
		$modelResolution->end_action_date =  isset($_POST["res_end_action_date"])&& $_POST["res_end_action_date"] != "" ? date('Y-m-d', CDateTimeParser::parse($_POST["res_end_action_date"],"d.M.y")) : NULL;
		$modelResolution->save();
		
         $modelCases->person           = $this->id;
		 $modelCases->type             = $this->type;
         $modelCases->salary_post      = $this->salary_post;
         $modelCases->year_inc_percent = $this->year_inc_percent;
         $modelCases->salary_rank      = $this->salary_rank;
         $modelCases->saved_summa      = $this->saved_summa;
		 $modelCases->number = isset($_POST["delo"]) ? $_POST["delo"] : "";
		 $modelCases->comm   = isset($_POST["_comm"]) ? $_POST["_comm"] : "";
		 $modelCases->code_tr = isset($_POST["code_tr"]) ? $_POST["code_tr"] : null;
		 $modelCases->include_seniority = isset($_POST["Cases"]["include_seniority"]) ? $_POST["Cases"]["include_seniority"] : 0;
         $modelCases->save();
		
		 
		 $modelAddrs->region     = isset($_POST["region"]) ? $_POST["region"] : null;
		 $modelAddrs->person     = $this->id;
		 $modelAddrs->post_index      = isset($_POST["index"]) ? $_POST["index"] : "";
		 $modelAddrs->town       = isset($_POST["city"]) ? $_POST["city"] : "";
		 $modelAddrs->street     = isset($_POST["street"]) ? $_POST["street"] : "";
		 $modelAddrs->house       = isset($_POST["home"]) ? $_POST["home"] : "";
		 $modelAddrs->body       = isset($_POST["body"]) ? $_POST["body"] : "";
 		 $modelAddrs->apartment = isset($_POST["apartment"]) ? $_POST["apartment"] : "";
// 		 $modelAddrs->tel        = isset($_POST["tel"]) ? $_POST["tel"] : "";
 		 $modelAddrs->save();
  ///документы
         $modelDocs->person    = $this->id;
		 $modelDocs->type      = "паспорт";
		 $modelDocs->series    = isset($_POST["doc_series"]) ? $_POST["doc_series"] : "";
		 $modelDocs->number    = isset($_POST["doc_number"]) ? $_POST["doc_number"] : "";
		 $modelDocs->give_org  = isset($_POST["doc_give_org"]) ? $_POST["doc_give_org"] : "";
		 $modelDocs->give_date = isset($_POST["doc_give_date"]) ? $_POST["doc_give_date"] : "";
		 $modelDocs->comment   = isset($_POST["doc_comment"]) ? $_POST["doc_comment"] : "";
 		 $modelDocs->save();
		 

		}
	     parent::afterSave();
    }
	public function moneyFormat($money){
		$s_money = "".$money;
		$arr_money = explode(".", $s_money);
		if(isset($arr_money[1])){
			$dec = $arr_money[1];
			switch(strlen($dec)){
			case 1:$dec .=  "0"; break;
			case 0:$dec .= "00";break;
			}	
			return $arr_money[0].".".$dec;
		}
		else return isset($arr_money[0]) && $arr_money[0] ? $arr_money[0].".00" : "0.00"; 
	}
	private function updateSeniorities($type, $class,$value){
           Seniorities::model()->updateAll(array( 'value'=>$value,),
                                  			'person=:user_id and class=:class and type=:type', array(':user_id'=> $this->id, ":class"=>$class, ":type"=>$type));		
	}
	private function newSeniorities($type,$class,$value){
		$model = new Seniorities();
		$model->person = $this->id;
		$model->class = $class;
		$model->type = $type;
		$model->value = $value;
		$model->save();
	}
	private function checkSeniorities($type,$class){
		return is_null(Seniorities::model()->findByAttributes(array("class"=>$class, "person"=>$this->id, "type"=>$type))) ? false : true;
		
	}

 
	public function afterFind()	{
		
		$modelDismiss = Dismisses::model()->findByAttributes(array("id"=>$this->dismiss));
		$this->dismiss_code = isset($modelDismiss->code) ? $modelDismiss->code : "";
		$this->birth_date    = Yii::app()->dateFormatter->format("dd.MM.y",$this->birth_date);
		$this->dismiss_date  = Yii::app()->dateFormatter->format("dd.MM.y",$this->dismiss_date);
		$this->pension_date  = Yii::app()->dateFormatter->format("dd.MM.y",$this->pension_date);
		if($this->invalid_date)
		$this->invalid_date  = Yii::app()->dateFormatter->format("dd.MM.y",$this->invalid_date);
		if($this->invalid_date2)
		$this->invalid_date2 = Yii::app()->dateFormatter->format("dd.MM.y",$this->invalid_date2);
		if($this->death_date)
		$this->death_date    = Yii::app()->dateFormatter->format("dd.MM.y",$this->death_date);
		return parent::afterFind();
	}
	public function getWarActionShotNames(){
		$str = "";
		foreach($this->warActions as $k=>$v){
			$str .= $v->shot_name." ";
		}		
		return trim($str);
	}
	public function getPostShotNames(){
		$str = "";
		foreach($this->posts as $k=>$v){
			$str .= $v->shot_name." ";
		}		
		return trim($str);
	}
	public function getChaesShotNames(){
		$str = "";
		foreach($this->chaes as $k=>$v){
			$str .= $v->shot_name." ";
		}		
		return trim($str);
	}

}
