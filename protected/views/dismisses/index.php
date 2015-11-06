<?php
/* @var $this DismissesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dismisses',
);

$this->menu=array(
	array('label'=>'Create Dismisses', 'url'=>array('create')),
	array('label'=>'Manage Dismisses', 'url'=>array('admin')),
);
?>

<h1>Dismisses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
