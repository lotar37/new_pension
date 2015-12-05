<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 20:44
 */
$per = new Persons;
//var_dump(Yii::app()->request->getDataForModel($per));die();
$arr = $per->attributeTypes();
echo json_encode($arr);
