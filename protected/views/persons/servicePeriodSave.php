
<?php
$klg = array("new_calendar_container"=>"1","new_study_container"=>"3","calendar_container"=>"1","study_container"=>"3","new_lp_container"=>"2","lp_container"=>"2");

function checkDateCross($begin_date1,$end_date1,$begin_date2,$end_date2,$type){
	$pers = $begin_date1." ".$end_date1." ".$begin_date2." ".$end_date2." ".$type;
	//echo '{"status": "'.$pers.'"}';

	if($type == "cross") {
		$a_begin_1 = explode("-", $begin_date1);
		$a_begin_1 = array($a_begin_1[2], $a_begin_1[1], $a_begin_1[0]);
		$a_end_1 = explode("-", $end_date1);
		$a_end_1 = array($a_end_1[2], $a_end_1[1], $a_end_1[0]);
	}else{
		$a_begin_1 = explode(".",$begin_date1);
		$a_end_1 = explode(".",$end_date1);

	}
	$a_begin_2 = explode(".",$begin_date2);
	$a_end_2 = explode(".",$end_date2);
	$ts_begin1 = mktime(0,0,0,$a_begin_1[1],$a_begin_1[0],$a_begin_1[2]);
	$ts_end1 = mktime(0,0,0,$a_end_1[1],$a_end_1[0],$a_end_1[2]);
	$ts_begin2 = mktime(0,0,0,$a_begin_2[1],$a_begin_2[0],$a_begin_2[2]);
	$ts_end2 = mktime(0,0,0,$a_end_2[1],$a_end_2[0],$a_end_2[2]);
	//echo $begin_date1." ".$end_date1." ".$begin_date2." ".$end_date2." ".date("d.m.Y",$ts_begin1)." ".date("d.m.Y",$ts_end1)." ".date("d.m.Y",$ts_begin2)." ".date("d.m.Y",$ts_end2);
	if($type == "cross") {
		if ($ts_end2 < $ts_begin1 || $ts_end1 < $ts_begin2) return false;
		else return true;
	}elseif($type == "in"){
		if($ts_begin1 < $ts_begin2  && $ts_end2<=$ts_end1)return false;
		else return true;
	}
}
if($_GET["type"] == "delete"){
	$obj =  ServicePeriods::model()->findByPk($_GET["id"]);
	if($obj->delete()){
		echo '{"status": "ok"}';
		$summa = ServicePeriods::PeriodsSumma($obj["person"],$obj["klg"]);
		Seniorities::saveSenioities($obj["person"],$obj["klg"],$summa);
		$commonSumma = Seniorities::commonSumma($obj["person"]);
		Seniorities::saveSenioities($obj["person"],0,$commonSumma);
	}else{
		echo '{"status": "delete_error"}';
		var_dump($obj->errors);
	}
}
if($_GET["type"] == "save"){
	if(!$_GET["name"]){
		echo '{"status": "noname"}';
		die();
	}
	$personModel = Persons::model()->findByPk($_GET["id"]);
	//var_dump($personModel);die();
	$rightDate = isset($personModel->death_date) ? $personModel->death_date : date("d.m.Y");
//echo $rightDate." ".$personModel->birth_date;die();
	if(checkDateCross($personModel->birth_date, $rightDate,$_GET["date1"],$_GET["date2"],"in")){
		echo '{"status": "out_date"}';
		die();
	}

    $a  = ServicePeriods::model()->findAllByAttributes(array("person"=>$_GET["id"]));
	foreach($a as $one){
		if(checkDateCross($one['begin_time'],$one['end_time'],$_GET["date1"],$_GET["date2"],"cross")){
			echo '{"status": "cross_date", "id":"'.$one["id"].'"}';
			die();
		}
	}
	$d1 = explode(".",$_GET["date1"]);
	$d2 = explode(".",$_GET["date2"]);
	$ut1= mktime(0,0,0,$d1[1],$d1[0],$d1[2]);
	$ut2= mktime(0,0,0,$d2[1],$d2[0],$d2[2]);
	$error = false;
	if($ut1 >= $ut2)$error = true;
	if(!$error){
		$model = new ServicePeriods();
		$model->begin_time = $_GET["date1"];
		$model->end_time = $_GET["date2"];
		$model->name = $_GET["name"];
		$model->person = $_GET["id"];
		$model->nvl = $_GET["nvl"];
		$model->klg = $klg[$_GET["klg"]];
		if($model->save()){

			echo '{"status": "ok"}';
			$summa = ServicePeriods::PeriodsSumma($_GET["id"],$klg[$_GET["klg"]]);
			Seniorities::saveSenioities($_GET["id"],$klg[$_GET["klg"]],$summa);
			$commonSumma = Seniorities::commonSumma($_GET["id"]);
			Seniorities::saveSenioities($_GET["id"],0,$commonSumma);
		}else var_dump($model->errors);
	}else{
		echo '{"status": "time_error"}';
	}
}

?>