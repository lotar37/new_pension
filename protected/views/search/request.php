<?php
/**
 * Created by PhpStorm.
 * User: Àíäðåé
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
if(count($_GET["tables"])==1) $from = "public.".$_GET["tables"][0];
else $from = "public.cases INNER JOIN public.Ðersons ON cases.person = persons.id";

$fields = "";

if(isset($_GET["d"]))
foreach($_GET["d"] as $k=>$one){
    $fields .= ($fields ? ", " : "").$one["table"].".".$one["field"];
    switch($one["type"]){
        case "string" : if($one["val"])$conditions .= ($conditions ? " AND ": "").$one["field"]." ILIKE '%".trim($one["val"])."%' ";
        break;
        case "integer" :if($one["val"])$conditions .= ($conditions ? " AND ": "").$one["field"]." = '".trim($one["val"])."' ";
            break;
        case "boolean" : if($one["val"]) $conditions .= ($conditions ? " AND " : "") . $one["field"] . " = '1' ";
            break;
        case "date": if($one["begin"] || $one["end"])$conditions .= ($conditions ? " AND ": "").$one["field"]." > '".date('Y-M-d', CDateTimeParser::parse($one["begin"], "d.M.y"))."' ";

    }
}
//$sql = "SELECT DISTINCT persons.id ,persons.second_name, persons.first_name, persons.third_name, persons.birth_date, cases.number,cases.type FROM $from WHERE ";
$sql = "SELECT DISTINCT ".$fields." FROM $from WHERE ".$conditions." LIMIT 10 OFFSET 1";

//echo $sql.$conditions;
$Result = dbRequest($sql);
//$Result2 = dbRequest($sql2);
//var_dump($Result2->readAll());
$data = $Result->readAll();
//"count"=>$Result2->readAll();
echo json_encode($data);