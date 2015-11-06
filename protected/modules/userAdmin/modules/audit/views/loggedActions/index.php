<?php
/* @var $this LoggedActionsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Logged Actions',
);

$this->menu=array(
	array('label'=>'Create LoggedActions', 'url'=>array('create')),
	array('label'=>'Manage LoggedActions', 'url'=>array('admin')),
);
?>

<h1>Logged Actions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
