<?php
/* @var $this CalcParamsController */
/* @var $model CalcParams */

$this->breadcrumbs=array(
	'Calc Params'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CalcParams', 'url'=>array('index')),
	array('label'=>'Manage CalcParams', 'url'=>array('admin')),
);
?>

<h1>Create CalcParams</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>