<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.11.2015
 * Time: 1:50
 */
//"var_dump($_GET);

function dbRequest($sql){
    $connection=Yii::app()->db;
    $command=$connection->createCommand($sql);
    return $command->query();
}
$conditions = "";
$arr_rel = array(
    "PersonsCases"=>array("Persons","Cases"),
    "PersonsRanks"=>array("Persons","Ranks"),
    "CasesRanks"=>array("Cases","Ranks"),
    "PersonsCasesRanks"=>array("Persons","Cases","Ranks"),
);
function getKey($tables,$arr_rel){
    foreach($arr_rel as $k=>$v){
         if(!count(array_diff($v,$tables)) && !count(array_diff($tables,$v)))return $k;
    }
}
if(count($_GET["tables"])==1) $from = "public.".$_GET["tables"][0];
else{
    switch(getKey($_GET["tables"],$arr_rel)){
        case "PersonsCases": $from = " persons LEFT JOIN cases ON cases.person = persons.id ";
            break;
        case  "CasesRanks":
        case  "PersonsCasesRanks":
        $from = " persons LEFT JOIN ranks ON ranks.id = persons.rank LEFT JOIN cases ON cases.person = persons.id ";

        break;
        case "PersonsRanks":
            $from = " persons LEFT JOIN ranks ON ranks.id = persons.rank ";
            break;
    }
}




$fields = "";
$emptyallval = true;
if(isset($_GET["d"]))
foreach($_GET["d"] as $k=>$one){
    if($one["onscreen"])$fields .= ($fields ? ", " : "").$one["table"].".".$one["field"];
    $field = $one["table"].".".$one["field"];
    if(isset($one["val"]) && $one["val"])$emptyallval = false;
    if(isset($one["begin"]) && $one["begin"])$emptyallval = false;
    if(isset($one["end"]) && $one["end"])$emptyallval = false;
    switch($one["type"]){
        case "string" : if($one["val"])$conditions .= ($conditions ? " AND ": "").$field." ILIKE '%".trim($one["val"])."%' ";
        break;
        case "integer" :if($one["val"])$conditions .= ($conditions ? " AND ": "").$field." = '".trim($one["val"])."' ";
            break;
        case "boolean" : if($one["val"]) $conditions .= ($conditions ? " AND " : "") . $field . " = '1' ";
            break;
        case "date":
            if($one["begin"])
                $conditions .= ($conditions ? " AND ": "").$field." > '".date('Y-M-d', CDateTimeParser::parse($one["begin"], "d.M.y"))."' ";
            if( $one["end"])
                $conditions .= ($conditions ? " AND ": "").$field." < '".date('Y-M-d', CDateTimeParser::parse($one["end"], "d.M.y"))."' ";

    }
}
if($emptyallval) $conditions = "true";
$sql = "SELECT DISTINCT ".$fields." FROM ".$from." WHERE ".$conditions." LIMIT 100 OFFSET 1";
$count_sql = "SELECT DISTINCT COUNT(*) FROM ".$from." WHERE ".$conditions;
//echo $sql;
$Result = dbRequest($sql);
$Result_count = dbRequest($count_sql);
//var_dump($Result2->readAll());
$data = $Result->readAll();
$data_count = $Result_count->readAll();
$_data = str_replace("null",'" - "',json_encode($data));
$out = array("data"=>$_data,"count"=>$data_count[0]["count"]);
//"count"=>$Result2->readAll();
$csv_output ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Andrey" />
</head>
<body>';
    $csv_output .= "<table border='1'>";
    $csv_output .= $_GET["thead"];

    foreach($data as $one){
        $csv_output .=  "<tr>";
        foreach($one as $field){
            $csv_output .=  "<td>".$field."</td>";
        }
        $csv_output .=  "</tr>";
    }
    $csv_output .=  "</table>";
    $csv_output .='</body></html>';

if($_GET["type"] == "blank") {
    echo $csv_output;
}else if($_GET["type"]=="excel"){
    header('Content-Type: text/x-csv; charset=utf-8');
    header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
    header("Content-Transfer-Encoding: binary ");

    echo $csv_output;
}
else echo str_replace("null",'" - "',json_encode($data));
//echo json_encode($data);