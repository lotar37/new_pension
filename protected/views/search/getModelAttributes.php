<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 20:44
 */
$per = new Persons;
//var_dump(Yii::app()->request->getDataForModel($per));die();
$arr = $per->attributeLabels();
$arr2 = $per->attributeTypes();
$result = array();
foreach($arr as $k=>$v){
    $type = isset($arr2[$k])? $arr2[$k] : "string";
    $result[$k] = array("attr"=>$v,"type"=>$type);
}
echo json_encode($result);
