<?php
/* @var $this LoggedActionsController */
/* @var $model LoggedActions */

$this->breadcrumbs=array(
	'Logged Actions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LoggedActions', 'url'=>array('index')),
	array('label'=>'Create LoggedActions', 'url'=>array('create')),
	array('label'=>'Update LoggedActions', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LoggedActions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LoggedActions', 'url'=>array('admin')),
);
?>

<h1>View LoggedActions #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_session',
		'schema_name',
		'table_name',
		'action_tstamp',
		'action',
		'query',
	),
)); ?>
