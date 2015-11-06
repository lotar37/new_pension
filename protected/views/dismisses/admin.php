<?php
/* @var $this DismissesController */
/* @var $model Dismisses */



$this->menu=array(
	array('label'=>'Новое', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#dismisses-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br>
<h1>&nbsp;Причины увольнения</h1>

<!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dismisses-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('dismisses/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'name',
		'code',
		array(
			'class'=>'CButtonColumn',
			'viewButtonOptions'=>array('style'=>'display:none'),
		),
	),
)); ?>
