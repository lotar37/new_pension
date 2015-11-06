<?php
/* @var $this LoggedActionsController */
/* @var $model LoggedActions */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'id_session'); ?>
		<?php echo $form->textField($model,'id_session'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'table_name'); ?>
		<?php echo $form->textField($model,'table_name',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'action_tstamp'); ?>
		<?php echo $form->textField($model,'action_tstamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->