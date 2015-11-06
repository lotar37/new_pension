<?php
/* @var $this WarActionsController */
/* @var $model WarActions */


$this->menu=array(
	array('label'=>'Новое', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#war-actions-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<br>
<h1>&nbsp;Военные действия</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'war-actions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('warActions/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'name',
		'code',
		'shot_name',
		array(
			'class'=>'CButtonColumn',
			//'deleteButtonOptions'=>array('style'=>'display:none'),
			'viewButtonOptions'=>array('style'=>'display:none'),
		),
	),
)); ?>
