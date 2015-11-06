<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	$model->username,
);

$this->menu=array(
	array('label'=>'Список пользователей', 'url'=>array('index')),
	array('label'=>'Создание пользователя', 'url'=>array('create')),
	array('label'=>'Изменение пользователя', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удаление пользователя', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление пользователями', 'url'=>array('admin')),
);
?>

<h1>Пользователь #<?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'title',
// 		'password',
// 		'system',
		'connect_time',
		'create_time',
		array('name'=>'roles', 'value'=>'<span style="white-space:pre">'.$model->roles.'</span>', 'type'=>'raw'),
	),
)); ?>
