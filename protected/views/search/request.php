<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.11.2015
 * Time: 1:50
 */
//var_dump($_GET);
function dbRequest($sql){
    $connection=Yii::app()->db;
    $command=$connection->createCommand($sql);
    return $command->query();
}
$conditions = "";
$from = "public.cases INNER JOIN public.persons ON cases.person = persons.id";
$sql = "SELECT DISTINCT persons.id ,persons.second_name, persons.first_name, persons.third_name, persons.birth_date, cases.number,
cases.type FROM $from WHERE ";
//$sql2 = "SELECT DISTINCT COUNT(distinct persons.id) FROM  $from  WHERE persons.second_name ILIKE '".$a_string[0]."%' $s_namesearch ".$addSearchConditions["type"]." ".$addSearchConditions["age"]." ".$addSearchConditions["terminated"]." ".$addSearchConditions["gender"]." ;";
//$aff = $_GET["d"];

foreach($_GET["d"] as $k=>$one){
 //   if(!$one["val"])continue;
    //if($conditions)$conditions .= " AND ";
    switch($one["type"]){
        case "string" : if($one["val"])$conditions .= ($conditions ? " AND ": "").$one["field"]." ILIKE '%".trim($one["val"])."%' ";
        break;
        case "integer" :
        case "boolean" : if($one["val"])$conditions .= ($conditions ? " AND ": "").$one["field"]." = '".trim($one["val"])."' ";
            break;
        case "date": if($one["begin"] || !$one["end"])$conditions .= ($conditions ? " AND ": "").$one["field"]." > '".date('Y-M-d', CDateTimeParser::parse($one["begin"], "d.M.y"))."' ";

    }

}
//echo $sql.$conditions;
$Result = dbRequest($sql.$conditions." LIMIT 10 OFFSET 1");
//$Result2 = dbRequest($sql2);
//var_dump($Result2->readAll());
$data = $Result->readAll();
//"count"=>$Result2->readAll();
echo json_encode($data);