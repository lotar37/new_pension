<?php
/* @var $this WarActionsController */
/* @var $model WarActions */

$this->breadcrumbs=array(
	'War Actions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List WarActions', 'url'=>array('index')),
	array('label'=>'Create WarActions', 'url'=>array('create')),
	array('label'=>'Update WarActions', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WarActions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WarActions', 'url'=>array('admin')),
);
?>

<h1>View WarActions #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'code',
		'shot_name',
	),
)); ?>
