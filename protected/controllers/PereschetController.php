<?php 

class PereschetController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionRaschet()
	{
	    $date = Calculator::convertDateToISO($_POST['date']);
	    if (!$date) {
	        $date = Calculator::getOne("select now()::date");
	    } //echo " [$date]";
	    
	    $count = 0;
	    $time1 = time();
	    
	    
	    // Находим группу, актуальную на указанную дату
	    $calcGroupID = Calculator::getOne("SELECT id FROM calc_groups WHERE date <= '$date' ORDER BY date DESC LIMIT 1"); 
	    
	    $limit = 1000000;
	    foreach (Calculator::getCol("SELECT id FROM cases WHERE terminated <> 1 LIMIT $limit") as $caseID) {
	        Calculator::recalcPension($caseID, array(
    	        'calcGroupID' => $calcGroupID, 
    	        'basicDocID' => $_POST['basisDocID'], 
    	        'date' => $date, 
    	        ));
	        $count++;
	    }
	    $time2 = time();
	    
	    // Результаты расчета
		$this->render('raschet', array(
		    'count' => $count,
		    'date' => $date,
		    'basisDocID' => $_POST['basisDocID'],
		    'basisDocName' => Calculator::getOne("SELECT name FROM basis_docs WHERE id = {$_POST['basisDocID']}"),
		    'time1' => $time1,
		    'time2' => $time2,
		));
	}

}