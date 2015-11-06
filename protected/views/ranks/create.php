<?php
/* @var $this RanksController */
/* @var $model Ranks */



$this->menu=array(
	array('label'=>'Вернуться к списку', 'url'=>array('admin')),
);
?>

<h1>Создать В/З</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>