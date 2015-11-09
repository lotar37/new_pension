<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 20:44
 */
echo "[";
$per = new Persons();
$arr = $per->attributeLabels();
foreach($arr as $k=>$v){
    echo "{'".$k."':'".$v."'},";
}
echo "]";