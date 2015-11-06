<?php
/* @var $this PersonsController */
/* @var $model Persons */

$this->breadcrumbs=array(
	'Persons'=>array('index'),
	$model->id,
);


?>

<h1>View Persons #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'second_name',
		'first_name',
		'third_name',
		'birth_date',
		'birth_place',
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
	),
)); ?>
