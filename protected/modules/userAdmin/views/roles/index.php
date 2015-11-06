<?php
/* @var $this RolesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Роли',
);

$this->menu=array(
	array('label'=>'Создать роль', 'url'=>array('create')),
	array('label'=>'Управление ролями', 'url'=>array('admin')),
);
?>

<h1>Роли</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
