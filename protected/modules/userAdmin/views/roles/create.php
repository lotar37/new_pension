<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Роли'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список ролей', 'url'=>array('index')),
	array('label'=>'Управление ролями', 'url'=>array('admin')),
);
?>

<h1>Создание роли</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>