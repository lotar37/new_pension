<?php
/* @var $this LoggedActionsController */
/* @var $model LoggedActions */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#logged-actions-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>АУДИТ</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'logged-actions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_session',
		'user_name',
// 		'begin_time',
		'bt',
// 		'end_time',
		'et',
		'at',
		'table_comment',
// 		'action_tstamp',
		'pk_name',
		'pk_val',
		'column_comment',
		'old_data',
		'new_data',
// 		'query',
// 		array(
// 			'class'=>'CButtonColumn',
// 		),
	),
)); 

// id 	pid 	user_name 	begin_time 	end_time 	id_action 	
// table_name 	pk_name 	pk_val 	action_tstamp 	action1 	
// field_name 	old_data 	new_data 	id_session
?>
