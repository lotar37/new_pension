<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 09.11.2015
 * Time: 20:44
 */
$per = new Persons();
$arr = $per->attributeLabels();
echo json_encode($arr);
/*
echo "{";

 foreach($arr as $k=>$v){
    echo $k.":'".$v."',";
    //echo "{tableField:'".$k."', label:'".$v."'},";
}
echo "}";
*/