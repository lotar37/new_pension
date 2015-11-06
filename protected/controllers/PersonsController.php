<?php

class PersonsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ajaxUpdate','war','postview','chaes','resolution','seniorities','isch', 'raschet','pereraschet', 'dismiss','persearch','loadSearchResult','casesNumberCheck','dependants','loadSearch80',"statement","saveFilter","clientFilters","showNumber","senioritiesCount","servicePeriodSave","servicePeriodLoad","loadServicePeriodSelect"),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
	public function actionDependants($id){
		$model = Persons::model()->findByPk($id);
	    $connection=Yii::app()->db; 
		$sql = "select dependants.dependant from  dependants  where dependants.case='".$model->cases3->number."';";
        $command=$connection->createCommand($sql);
		$Result = $command->query();
		$arr = $Result->readAll();
		$arr_result = array();
		foreach($arr as $one){
		    $arr_result[$one['dependant']] = Persons::model()->findByPk($one['dependant']);
		}
		$this->renderPartial('dependants',array(
			 'data'=>$arr_result,
		));
	 }
	public function actionPereraschet($id)
	{
		$this->renderPartial('pereraschet',array(
			'data'=>$this->loadModel($id),
		));
	}

	public function actionRaschet($id)
	{
		$this->renderPartial('doc_raschet',array(
			'data'=>$this->loadModel($id),
		));
	}
	public function actionIsch($id)
	{
		$this->renderPartial('doc_isch',array(
			'data'=>$this->loadModel($id),
		));
	}
	public function actionLoadSearchResult($str = ""){
		if(isset($_GET["filter_empty"]) && $_GET["filter_empty"] != "")$this->clearFilterCookies();
		$a_string = explode(" ",$_GET["string"]);
		Yii::app()->request->cookies['search'] = new CHttpCookie("search",$_GET["string"]);
		$a = $a_string[0] + 1;
		$addSearchConditions = $this->getSearchCondtions();
		//var_dump($addSearchConditions);
		if($addSearchConditions == "stop")return 0;
	    if($a>1){
		     $a_date = $this->searchNumberTypeData($a_string, $addSearchConditions);
	    }else{
		     $a_date = $this->searchCharTypeData($a_string, $addSearchConditions);
		}
		
		$this->renderPartial('search_result', $a_date);
		
	}
	public function actionPersearch(){
//var_dump($_GET);die();
		//var_dump( Cases::model()->getDbConnection()->getSchema()->getTables());die();

		$a_string = array("");
		if(isset($_GET["string"])){
			$a_string = explode(" ",$_GET["string"]);
			Yii::app()->request->cookies['search'] = new CHttpCookie("search",$_GET["string"]);
		}else if(isset(Yii::app()->request->cookies['search']->value)){
			$a_string = explode(" ",Yii::app()->request->cookies['search']->value);
			unset(Yii::app()->request->cookies['search']);
		}
		$a = $a_string[0] + 1;
		$addSearchConditions = $this->getSearchCondtions();
		if($addSearchConditions == "stop")return 0;
        $addSearchConditions["conditions"]["search"] = implode(" ",$a_string);
		if($addSearchConditions["conditions"]["paystop"]==1){
			
			$arr  = Calculator::getCases_WithOverduePaymentsInNextMonth();
 		    $a_date= array("data"=>$arr,"count"=>array(array("count"=>count($arr))), "conditions"=>$addSearchConditions["conditions"],);

		}else if($a>1){
		     $a_date = $this->searchNumberTypeData($a_string, $addSearchConditions);
	    }else{
		     $a_date = $this->searchCharTypeData($a_string, $addSearchConditions);
		}
		$this->render('search', $a_date);

	}
	private function searchNumberTypeData($a_string, $addSearchConditions){
	    //$connection=Yii::app()->db; 
		$sql  = "SELECT persons.id ,persons.second_name, persons.first_name, persons.third_name, persons.birth_date, cases.number, cases.type FROM public.cases INNER JOIN public.persons ON cases.person = persons.id WHERE cases.number::text ILIKE '".$a_string[0]."%' ".$addSearchConditions["type"]." ".$addSearchConditions["age"]."  ORDER BY   cases.number   LIMIT 30;";
		$sql2 = "SELECT  COUNT(*) FROM public.cases INNER JOIN public.persons ON cases.person = persons.id WHERE cases.number::text ILIKE '".$a_string[0]."%'  ".$addSearchConditions["type"]." ".$addSearchConditions["age"]." ;";
        //$command=$connection->createCommand($sql);
        //$command2=$connection->createCommand($sql2);
		$Result = $this->dbRequest($sql);//$command->query();
		$Result2 = $this->dbRequest($sql2);//$command2->query();
		return array("data"=>$Result->readAll(),"count" => $Result2->readAll(), "conditions"=>$addSearchConditions["conditions"],);
	}
	private function dbRequest($sql){
	    $connection=Yii::app()->db; 
        $command=$connection->createCommand($sql);
		return $command->query();
	}
	private function searchCharTypeData($a_string, $addSearchConditions){
	   // $connection=Yii::app()->db; 
		$s_namesearch = "";
		$from = "public.cases INNER JOIN public.persons ON cases.person = persons.id";
		if($addSearchConditions["war"])$from = " (".$from.")".$addSearchConditions["war"];
		if($addSearchConditions["chaes"])$from = " (".$from.")".$addSearchConditions["chaes"];
		if(isset($a_string[1]))$s_namesearch =  " AND persons.first_name ILIKE '".$a_string[1]."%'";
		$sql = "SELECT DISTINCT persons.id ,persons.second_name, persons.first_name, persons.third_name, persons.birth_date, cases.number, cases.type FROM $from WHERE persons.second_name ILIKE '".$a_string[0]."%' ".$addSearchConditions["type"]." ".$addSearchConditions["age"]." ".$addSearchConditions["terminated"]." ".$addSearchConditions["gender"]." $s_namesearch ORDER BY   persons.second_name   ".$addSearchConditions["limit"].";";
		$sql2 = "SELECT DISTINCT COUNT(distinct persons.id) FROM  $from  WHERE persons.second_name ILIKE '".$a_string[0]."%' $s_namesearch ".$addSearchConditions["type"]." ".$addSearchConditions["age"]." ".$addSearchConditions["terminated"]." ".$addSearchConditions["gender"]." ;";
		$Result = $this->dbRequest($sql);
		$Result2 = $this->dbRequest($sql2);
		//var_dump($Result2->readAll());
		return array("data"=>$Result->readAll(), "count"=>$Result2->readAll(), "conditions"=>$addSearchConditions["conditions"],);
	}
	private function clearFilterCookies(){
		foreach(Cases::$conditions as $k=>$v){
		    unset(Yii::app()->request->cookies[$k]);
		}
	}
	
	private function getSearchCondtions(){
		
		//filter_change - признак того, что действие производится по изменению фильтра, а не по возвращению к прошлому состоянию фильтра из кукиз
		$s_type = "";
		$s_age = "";
		$s_war = "";
		$s_chaes = "";
		$s_terminated = "";
		$show_number = isset(Yii::app()->request->cookies['show_number']->value)  ? Yii::app()->request->cookies['show_number']->value : Cases::$how_many;
		$conditions = Cases::$conditions;

		if(isset($_GET["terminated"]) && $_GET["terminated"] != ""){
			$conditions["terminated"] = $_GET["terminated"];
			Yii::app()->request->cookies['terminated'] = new CHttpCookie("terminated",$_GET["terminated"]);
			$s_terminated = " AND cases.terminated = ".$_GET["terminated"];
		}else if(isset(Yii::app()->request->cookies['terminated']->value) && (!isset($_GET["filter_change"]))){
			$conditions["terminated"] = $_GET["terminated"];
			$s_war = " AND cases.terminated = ".$_GET["terminated"];
			unset(Yii::app()->request->cookies['terminated']);
        }else unset(Yii::app()->request->cookies['terminated']);
		
		if(isset($_GET["war"]) && $_GET["war"] != ""){
			$conditions["war"] = 1;
			Yii::app()->request->cookies['war'] = new CHttpCookie("war",$_GET["war"]);
			$s_war = " INNER JOIN person_war_actions ON persons.id = person_war_actions.person ";
		}else if(isset(Yii::app()->request->cookies['war']->value) && (!isset($_GET["filter_change"]))){
			$conditions["war"] = 1;
			$s_war = " INNER JOIN person_war_actions ON persons.id = person_war_actions.person ";
			unset(Yii::app()->request->cookies['war']);
        }else unset(Yii::app()->request->cookies['war']);
		
		if(isset($_GET["chaes"]) && $_GET["chaes"] != ""){
			$conditions["chaes"] = 1;
			Yii::app()->request->cookies['chaes'] = new CHttpCookie("chaes",$_GET["chaes"]);
			$s_chaes = " INNER JOIN person_chaes ON persons.id = person_chaes.person ";
		}else if(isset(Yii::app()->request->cookies['chaes']->value) && (!isset($_GET["filter_change"]))){
			$conditions["chaes"] = 1;
			$s_chaes = " INNER JOIN person_chaes ON persons.id = person_chaes.person ";
			unset(Yii::app()->request->cookies['chaes']);
        }else unset(Yii::app()->request->cookies['chaes']); 
		
		if(isset($_GET["anch"]) && $_GET["anch"] != ""){
			$conditions["anch"] = $_GET["anch"];
			Yii::app()->request->cookies['anch'] = new CHttpCookie("anch",$_GET["anch"]);
			$limit1 = $show_number*($_GET["anch"]-1);
			$s_limit = "LIMIT $show_number OFFSET $limit1 ";
		//}else if(isset(Yii::app()->request->cookies['anch']->value) && (!isset($_GET["filter_change"]))){
		}else if(isset(Yii::app()->request->cookies['anch']->value)){
			$conditions["anch"]  = Yii::app()->request->cookies['anch']->value;
			$limit1 = $show_number*(Yii::app()->request->cookies['anch']->value-1);
			$s_limit = "LIMIT $show_number OFFSET $limit1 ";
			unset(Yii::app()->request->cookies['anch']);
        }else if(isset($_GET["showall"]) && $_GET["showall"] != ""){
			$s_limit = " ";
			$conditions["showall"] = 1;
			Yii::app()->request->cookies['showall'] = new CHttpCookie("showall",$_GET["showall"]);
		}else if(isset(Yii::app()->request->cookies['showall']->value) && (!isset($_GET["filter_change"]))){
			$s_limit = " ";
			$conditions["showall"] = 1;
			unset(Yii::app()->request->cookies['showall']);
        }else{
			$s_limit = " LIMIT $show_number ";
			unset(Yii::app()->request->cookies['showall']);
			unset(Yii::app()->request->cookies['anch']);
		}
		$_age = "";
		if(isset($_GET["age"]) && $_GET["age"] != ""){
			$conditions["age"] = $_GET["age"];
			Yii::app()->request->cookies['age'] = new CHttpCookie("age",$_GET["age"]);
			$_age = $_GET["age"];
		}else if(isset(Yii::app()->request->cookies['age']->value) && (!isset($_GET["filter_change"]))){
			$_age = Yii::app()->request->cookies['age']->value;
			$conditions["age"] = Yii::app()->request->cookies['age']->value;
			unset(Yii::app()->request->cookies['age']);
        }else unset(Yii::app()->request->cookies['age']);			
		if($_age){
			if($_age == "0-120")$s_age = "";
			else{
				$a_age = explode("-", $_age);
				$a_age[0] +=0;
				$a_age[1] +=0;
				$month = date("n");
				$day   = date("j");
				$year = date("Y");
				$datesql1 = date("Y-m-d",mktime(0,0,0,$month,$day,$year-$a_age[1]));
				$datesql2 = date("Y-m-d",mktime(0,0,0,$month,$day,$year-$a_age[0]));
				if($a_age[1] <= 113)$s_age = "AND (persons.birth_date >='".$datesql1."'  AND persons.birth_date <'".$datesql2."')";
				else $s_age = "AND (persons.birth_date <'".$datesql2."')";
			}
		}
		$_type = "";
		if(isset($_GET["type"]) && $_GET["type"] != ""){
			Yii::app()->request->cookies['type'] = new CHttpCookie("type",$_GET["type"]);
			$_type = $_GET["type"];
			$conditions["type"] = $_GET["type"];

		}else if(isset(Yii::app()->request->cookies['type']->value)  && (!isset($_GET["filter_change"]))){
			$_type = Yii::app()->request->cookies['type']->value;
			$conditions["type"] = Yii::app()->request->cookies['type']->value;
			unset(Yii::app()->request->cookies['type']);
        }else unset(Yii::app()->request->cookies['type']);			
        if($_type){
			$a_type = explode("_", $_type);
		    if(count($a_type)){
				foreach($a_type as $one){
				    $s_type .= ($s_type ? " OR " : "")." cases.type ='".Cases::$a_types_ret[$one]."'";
			    }
			}
			$s_type = "AND (".$s_type.")";
		}


		$_gender =  "";
		$s_gender =  "";
		if(isset($_GET["gender"]) && $_GET["gender"] != ""){
			Yii::app()->request->cookies['gender'] = new CHttpCookie("gender",$_GET["gender"]);
			$_gender = $_GET["gender"];
			$conditions["gender"] = $_GET["gender"];

		}else if(isset(Yii::app()->request->cookies['gender']->value) && (!isset($_GET["filter_change"]))){
			$_gender = Yii::app()->request->cookies['gender']->value;
			$conditions["gender"] = Yii::app()->request->cookies['gender']->value;
			unset(Yii::app()->request->cookies['gender']);
        }			
        if($_gender){
			if($_gender == "female") $s_gender = " AND persons.third_name ILIKE '%а'";
			else $s_gender = " AND persons.third_name NOT ILIKE '%а'";
		}
		if(isset($_GET["string"])){  
		    $conditions["string"] = $_GET["string"];
		    //$a_string = explode(" ",$_GET["string"]);
		    Yii::app()->request->cookies['search'] = new CHttpCookie("search",$_GET["string"]);
		}
		if(isset($_GET["paystop"]) && $_GET["paystop"] != ""){
			$conditions["paystop"] = 1;
			$arr  = Calculator::getCases_WithOverduePaymentsInNextMonth();
			Yii::app()->request->cookies['paystop'] = new CHttpCookie("paystop",$_GET["paystop"]);
 		    $this->renderPartial('search_result', array("data"=>$arr,"count"=>array(array("count"=>count($arr))),"condition"=>$conditions));
			return "stop";
		}else if(isset(Yii::app()->request->cookies['paystop']->value) && (!isset($_GET["filter_change"]))){
			//echo "get->";var_dump($_GET);
			$conditions["paystop"] = 1;
			unset(Yii::app()->request->cookies['paystop']);
			//return "stop";
			
		}else unset(Yii::app()->request->cookies['paystop']);
		//$a = $a_string[0] + 1;
		
		return array("gender"=>$s_gender, "type"=>$s_type, "age"=>$s_age, "limit"=>$s_limit, "war"=>$s_war, "chaes"=>$s_chaes, "terminated"=>$s_terminated, "conditions"=>$conditions);
			
		
	}
	public function actionLoadSearch80(){
		$monthnow = date("n")+$_GET["shift"];
		$year = date("Y")-80;
		$date1 = mktime(0,0,0,$monthnow,1,$year);
		$date2 = mktime(0,0,0,$monthnow+1,1,$year);
		$datesql1 = date("Y",$date1)."-".date("m",$date1)."-01";
		$datesql2 = date("Y",$date2)."-".date("m",$date2)."-01";
	    //$connection=Yii::app()->db; 
		$sql = "SELECT persons.id ,persons.second_name, persons.first_name, persons.third_name, persons.birth_date, cases.number, cases.type FROM public.cases INNER JOIN public.persons ON cases.person = persons.id WHERE  persons.birth_date >='".$datesql1."'  AND persons.birth_date <'".$datesql2."' ORDER BY   persons.birth_date;";
		$sql2 = "SELECT  COUNT(*) FROM cases INNER JOIN persons ON cases.person = persons.id WHERE  persons.birth_date >='".$datesql1."'  AND persons.birth_date <'".$datesql2."';";
		$Result = $this->dbRequest($sql);
		$Result2 = $this->dbRequest($sql2);
		foreach($Result2 as $one){
			$count = $one["count"];
		}
		$this->renderPartial('search80', array("data"=>$Result,"count"=>$count));
		
    }	
	public function actionCasesNumberCheck(){
		$model = Cases::model()->findByAttributes(array("number"=>$_GET["number"]));
		if(!isset($model))echo 0;
		else if($model->person == $_GET["id"])echo 0;
		else echo 1;
	}
	public function actionloadServicePeriodSelect(){
		$this->renderPartial('loadServicePeriodSelect');		
	}
	public function actionServicePeriodSave(){
		$this->renderPartial('servicePeriodSave');
		
	}
	public function actionServicePeriodLoad(){
		$this->renderPartial('servicePeriodLoad');
		
	}
	public function actionSaveFilter(){
		$sql = "SELECT  COUNT(*) FROM configs  WHERE  (name ILIKE 'filter|".Yii::app()->user->name."%' OR name ILIKE 'filter|global%') AND value='".$_GET["filter"]."';";
		$Result = $this->dbRequest($sql);
		$count = 0;
		foreach($Result as $one){
			$count = $one["count"];
		}	
	    if($count>0){
			echo 0;
		}
		else{
			$sql = "INSERT INTO configs (name,value) VALUES ('filter|".$_GET["prefix"]."|".$_GET["filter_name"]."','".$_GET["filter"]."')";
		    $Result = $this->dbRequest($sql);
			echo 1;
			
		}
	}
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Persons']))
		{
			$model->attributes       = $_POST['Persons'];
			$model->salary_post      = $_POST['Persons']['salary_post'];
			$model->year_inc_percent = $_POST['Persons']['year_inc_percent'];
			$model->salary_rank      = $_POST['Persons']['salary_rank'];
			$model->saved_summa      = $_POST['Persons']['saved_summa'];
			$model->type             = $_POST['Persons']['type']; 			
			if(!$model->save())echo "Ошибка сохранения";//$this->redirect(array('persearch'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionCreate()
	{
		$model = new Persons;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Persons']))
		{
			$model->attributes       = $_POST['Persons'];
			$model->salary_post      = $_POST['Persons']['salary_post'];
			$model->year_inc_percent = $_POST['Persons']['year_inc_percent'];
			$model->salary_rank      = $_POST['Persons']['salary_rank'];
			$model->saved_summa      = $_POST['Persons']['saved_summa'];
			$model->type             = $_POST['Persons']['type']; 			
			if($model->save())
				$this->redirect(array('persearch','id'=>$model->id));
		}else{
			$id = $model->createEmptyPerson($model);
            $case = Cases::model()->findByAttributes(array("number" => 0));
            if (count($case) == 0) {
                $case = new Cases;
            }
			$case->number = 0;
			$case->type = "ВЛ";
			$case->person = $id;
		
			//if($case->save())$this->render('update',array('model'=>$model));
            if($case->save())$this->redirect(array('persons/update/'.$id));
		    else{
			    //echo var_dump($case->errors);
			    die();
		    }
		}

		/*$this->render('create',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAjaxUpdate($id)
	{
		$model=$this->loadModel($id);
		//echo $id;
		$model->snils  = isset($_POST['Persons']['saved_summa']) ? $_POST['Persons']['saved_summa'] : 777777777; 		$model->save();

	}
	public function actionShowNumber(){
	    return Yii::app()->request->cookies['show_number'] = new CHttpCookie("show_number",$_GET["show_number"]);
	}
	public function actionDismiss()
	{
        $this->renderPartial("dismiss");
	}
	public function actionClientFilters()
	{
        $this->renderPartial("clientFilters");
	}
	public function actionResolution($id)
	{
	    $model=$this->loadModel($id);
        $this->renderPartial("resolution",array("model"=>$model));
	}
	public function actionSenioritiesCount($id)
	{
	    $model=$this->loadModel($id);
        $this->renderPartial("senioritiesCount",array("model"=>$model));
	}
	public function actionSeniorities($id)
	{
	   //$model=$this->loadModel($id);
        $this->renderPartial("seniorities",array("id"=>$id));
	}
	public function actionWar()
	{
        $this->renderPartial("war");
	}
	public function actionStatement()
	{
        $this->renderPartial("statement", array("data"=>$_GET));
	}
	public function actionChaes()
	{
        $this->renderPartial("chaes");
	}
	public function actionPostview()
	{
        $this->renderPartial("post");
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Persons');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Persons('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];

		$this->render('_admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Persons the loaded model
	 * @throws CHttpException
	 */
	private function ageWordFinder($lastNumber, $teen){
		if($lastNumber == 0 or ($lastNumber >= 5 and $lastNumber <= 9) or   $teen)
		    return " лет";
		else if($lastNumber ==1)
			return " год";
		else if($lastNumber >=2 or $lastNumber <= 4)
			return " года";
	}
	private function getAge($birth_date){
		
		$a_birth = explode(".",$birth_date);
		if(count($a_birth) !== 3)return "-";
		//var_dump($a_birth);die();
		$age = date("Y") - $a_birth[2];
		if((date("n")-$a_birth[1])<0)$age--;
		else if((date("n")-$a_birth[1])==0){
			if((date("j")-$a_birth[0])<=0) $age--;
			//else return $age;
		}//else return $age;
		$s_age = "".$age;
		$teen = false;
		if($s_age[strlen($s_age)-2]==1)$teen = true;
		return $age.$this->ageWordFinder($s_age[strlen($s_age)-1],$teen);
	}
	public function loadModel($id)
	{
		
		$model=Persons::model()->findByPk($id);
        $modelprofile=Cases::model()->find('person=:user_id', array(':user_id'=> $id));
		$model->age = $this->getAge($model->birth_date);
		if(isset($modelprofile)){
            $model->salary_post      =  $model->moneyFormat($modelprofile->salary_post);
            $model->year_inc_percent =  $modelprofile->year_inc_percent;
            $model->salary_rank      =  $model->moneyFormat($modelprofile->salary_rank);
            $model->saved_summa      =  $model->moneyFormat($modelprofile->saved_summa);

            $model->type             =  $modelprofile->type;
            //$model->number             =  $modelprofile->number;
		}
			//разрешения на выплату пенсии
		$modelResolution = Resolutions::model()->find('person=:user_id', array(':user_id'=> $id));
		if(isset($modelResolution)){
			$model->resolution  = array();
			$model->resolution["ser"]               = $modelResolution->ser;
			$model->resolution["number"]            = $modelResolution->number;
			$model->resolution["sent_date"]         = !is_null($modelResolution->sent_date) ? Yii::app()->dateFormatter->format("dd.MM.y",$modelResolution->sent_date) : "";
			$model->resolution["begin_action_date"] = !is_null($modelResolution->begin_action_date) ? Yii::app()->dateFormatter->format("dd.MM.y",$modelResolution->begin_action_date) : "";
			$model->resolution["end_action_date"]   = !is_null($modelResolution->end_action_date) ? Yii::app()->dateFormatter->format("dd.MM.y",$modelResolution->end_action_date) : "";
		}
		/*$modelIdentDocs = IdentDocs::model()->find('person=:user_id', array(':user_id'=> $id));
		if(isset($modelIdentDocs)){
			
		}*/
		$model->trChanges = $this->getRubr();
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function getRubr(){
	    $connection=Yii::app()->db; 
		$sql = "SELECT code, max(summa) FROM (SELECT code, summa, max(date) FROM tr_changes GROUP BY code, summa) AS q GROUP BY code ORDER BY code";
        $command=$connection->createCommand($sql);
		$modelTrChanges = $command->query();
		if(!isset($modelTrChanges))return null;
		$arr = $modelTrChanges->readAll();
		$arrS = array();
		foreach($arr as $one){
			$arrS[$one['code']] = $one['code']." | ".$one['max'];
		}
		if(isset($modelTrChanges))return $arrS;
		
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param Persons $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='persons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
