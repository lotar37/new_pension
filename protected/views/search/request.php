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
if(count($_GET["tables"])==1) $from = "public.".$_GET["tables"][0];
else $from = " cases INNER JOIN persons ON cases.person = persons.id ";

$fields = "";
$emptyallval = true;
if(isset($_GET["d"]))
foreach($_GET["d"] as $k=>$one){
    if($one["onscreen"])$fields .= ($fields ? ", " : "").$one["table"].".".$one["field"];
    $field = $one["table"].".".$one["field"];
    if($one["val"])$emptyallval = false;
    switch($one["type"]){
        case "string" : if($one["val"])$conditions .= ($conditions ? " AND ": "").$field." ILIKE '%".trim($one["val"])."%' ";
        break;
        case "integer" :if($one["val"])$conditions .= ($conditions ? " AND ": "").$field." = '".trim($one["val"])."' ";
            break;
        case "boolean" : if($one["val"]) $conditions .= ($conditions ? " AND " : "") . $field . " = '1' ";
            break;
        case "date": if($one["begin"] || $one["end"])$conditions .= ($conditions ? " AND ": "").$field." > '".date('Y-M-d', CDateTimeParser::parse($one["begin"], "d.M.y"))."' ";

    }
}
if($emptyallval) $conditions = "true";
$sql = "SELECT DISTINCT ".$fields." FROM ".$from." WHERE ".$conditions." LIMIT 100 OFFSET 1";

//echo $sql;
$Result = dbRequest($sql);
//$Result2 = dbRequest($sql2);
//var_dump($Result2->readAll());
$data = $Result->readAll();
//"count"=>$Result2->readAll();
echo json_encode($data);