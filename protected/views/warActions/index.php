<?php
/* @var $this WarActionsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'War Actions',
);

$this->menu=array(
	array('label'=>'Create WarActions', 'url'=>array('create')),
	array('label'=>'Manage WarActions', 'url'=>array('admin')),
);
?>

<h1>War Actions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider2,
	'itemView'=>'_view',
)); ?>
