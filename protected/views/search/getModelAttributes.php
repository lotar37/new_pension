<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 20:44
 */
$per = new Persons();
$arr = $per->attributeLabels();
echo json_encode($arr);
