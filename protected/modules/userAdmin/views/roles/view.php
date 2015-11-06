<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Роли'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список ролей', 'url'=>array('index')),
	array('label'=>'Создать роль', 'url'=>array('create')),
	array('label'=>'Изменить роль', 'url'=>array('update', 'id'=>$model->name)),
	array('label'=>'Удалить роль', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление ролями', 'url'=>array('admin')),
);
?>

<h1>Роль #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
	),
)); ?>
