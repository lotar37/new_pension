<?php
/* @var $this DismissesController */
/* @var $model Dismisses */

$this->breadcrumbs=array(
	'Dismisses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Dismisses', 'url'=>array('index')),
	array('label'=>'Create Dismisses', 'url'=>array('create')),
	array('label'=>'Update Dismisses', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Dismisses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dismisses', 'url'=>array('admin')),
);
?>

<h1>View Dismisses #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'code',
	),
)); ?>
