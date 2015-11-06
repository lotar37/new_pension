<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		
		$sql = "insert into t1 (f2)values('XZX')";
		$sql = "UPDATE t1 set f2='SDSDSDS' where f1=2";
		$pid = Yii::app()->db->createCommand($sql)->query()->readColumn(0);
		
		
		$this->render('index');
	}
}