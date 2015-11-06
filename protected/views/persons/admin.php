<?php
/* @var $this PersonsController */
/* @var $model Persons */


$this->menu=array(
	array('label'=>'Новый', 'url'=>array('create')),
);
/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#persons-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<br>
<h1>&nbsp;Список</h1>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'persons-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'htmlOptions'=>array("style"=>'cursor: pointer;'),
    'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('persons/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'number',
		'cases3.type',
		'second_name',
		'first_name',
		'third_name',
		'birth_date',
		'birth_place',
		/*
		'pension_date',
		'death_date',
		'is_duty_death',
		'rank',
		'post',
		'post_full_name',
		'dismiss',
		'dismiss_date',
		'phone',
		'seniority_com',
		'seniority_cal',
		'seniority_priv',
		'seniority_study',
		'seniority_mia',
		'is_working',
		'is_other_pension',
		'snils',
		*/
		array(
			'class'=>'CButtonColumn',
			//'updateButtonOptions'=>array('style'=>'display:none'),
			'deleteButtonOptions'=>array('style'=>'display:none'),
			'viewButtonOptions'=>array('style'=>'display:none'),
		),
	),
)); ?>
