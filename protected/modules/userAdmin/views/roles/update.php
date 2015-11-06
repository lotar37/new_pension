<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->name=>array('view','id'=>$model->name),
	'Update',
);

$this->menu=array(
	array('label'=>'Список ролей', 'url'=>array('index')),
	array('label'=>'Создать роль', 'url'=>array('create')),
	array('label'=>'Просмотр роли', 'url'=>array('view', 'id'=>$model->name)),
	array('label'=>'Управление ролями', 'url'=>array('admin')),
);
?>

<h1>Изменение роли <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>