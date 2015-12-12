<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 17:22
 */
class SearchController extends Controller
{

    public $layout='//layouts/column2';

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','setCookie'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete','getModelAttributes','getModelTypes','request','clientFilters','createFilter','saveFilter','getFilter','deleteFilters'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex()
    {

        $this->render('index',array(
            'dataProvider'=>$_GET,
        ));
    }
    public function actionGetModelAttributes()
    {

        $this->renderPartial('getModelAttributes',array(
            'dataProvider'=>$_GET,
        ));
    }
    public function actionGetModelTypes()
    {

        $this->renderPartial('getModelTypes',array(
            'dataProvider'=>$_GET,
        ));
    }
    public function actionRequest()
    {
        $this->renderPartial('request');
    }
    public function actionClientFilters()
    {

        $this->renderPartial('clientFilters');
    }
    public function actionCreateFilter()
    {

        $this->renderPartial('createFilter');
    }
    public function actionDeleteFilters(){
//        var_dump($_GET['data']);
        $str = "";
        foreach($_GET['data'] as $one){
            $str .= ($str ? " OR " : "")."name = '".$one."'";
        }
        $sql = "DELETE FROM configs WHERE ".$str;
        $Result = $this->dbRequest($sql);
    }
    public function actionSaveFilter(){
        $filter = json_encode($_GET["filter"]);
        $sql = "SELECT  COUNT(*) FROM configs  WHERE  (name ILIKE 'search|".Yii::app()->user->name."%' OR name ILIKE 'search|global%') AND value='".$filter."';";
        $Result = $this->dbRequest($sql);
        $count = 0;
        foreach($Result as $one){
            $count = $one["count"];
        }
        if($count>0){
            echo 0;
        }
        else{
            $prefix = $_GET["prefix"] ?  "global" : Yii::app()->user->name;
            $sql = "INSERT INTO configs (name,value) VALUES ('search|".$prefix."|".$_GET["filter_name"]."','".$filter."')";
            $Result = $this->dbRequest($sql);
            echo 1;

        }
    }
   public function actionGetFilter(){
        $sql = "SELECT  * FROM configs  WHERE  (name ILIKE 'search|".Yii::app()->user->name."|".$_GET["filter_name"]."%' OR name ILIKE 'search|global|".$_GET["filter_name"]."%');";
        $Result = $this->dbRequest($sql);
        $count = 0;
        foreach($Result as $one){
            echo $one["value"];
        }
   }

    private function dbRequest($sql){
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        return $command->query();
    }

}