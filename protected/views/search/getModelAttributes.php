<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 09.11.2015
 * Time: 20:44
 */
$tables = new $_GET["tableName"]();
//$tables = new Persons();
//echo $tables[$_GET["tableName"]];
//var_dump($_GET);die();
$arr  = $tables->attributeLabels();
$arr2 = $tables->attributeTypes();
$result = array();
foreach($arr as $k=>$v){
    $type = isset($arr2[$k])? $arr2[$k] : "string";
    $result[] = array("title"=>$v,"type"=>$type, "field"=>$k);
}
echo json_encode($result);
