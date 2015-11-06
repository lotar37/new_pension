<?php
/* @var $this CalcParamsController */
/* @var $model CalcParams */

$this->breadcrumbs=array(
	'Calc Params'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CalcParams', 'url'=>array('index')),
	array('label'=>'Create CalcParams', 'url'=>array('create')),
	array('label'=>'View CalcParams', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CalcParams', 'url'=>array('admin')),
);
?>

<h1>Update CalcParams <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>