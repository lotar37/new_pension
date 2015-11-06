<?php
/* @var $this RanksController */
/* @var $model Ranks */



$this->menu=array(
	array('label'=>'Новое', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ranks-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>
<h1>&nbsp;Звания</h1>


<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ranks-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('ranks/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'name',
		'rubr',
		'full_name',
		'print_name',
		array(
			'class'=>'CButtonColumn',
			//'deleteButtonOptions'=>array('style'=>'display:none'),
			'viewButtonOptions'=>array('style'=>'display:none'),
		),
	),
)); ?>
