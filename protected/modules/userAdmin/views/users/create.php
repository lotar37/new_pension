<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список пользователей', 'url'=>array('index')),
	array('label'=>'Управление пользователями', 'url'=>array('admin')),
);
?>

<h1>Создание пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>