<?php
/* @var $this DismissesController */
/* @var $model Dismisses */



$this->menu=array(
	array('label'=>'Вернуться к списку', 'url'=>array('admin')),
);
?>

<h1>Создать</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>