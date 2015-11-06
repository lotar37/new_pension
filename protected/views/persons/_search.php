<?php
/* @var $this PersonsController */
/* @var $model Persons */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'second_name'); ?>
		<?php echo $form->textField($model,'second_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'third_name'); ?>
		<?php echo $form->textField($model,'third_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birth_place'); ?>
		<?php echo $form->textField($model,'birth_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pension_date'); ?>
		<?php echo $form->textField($model,'pension_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'death_date'); ?>
		<?php echo $form->textField($model,'death_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_duty_death'); ?>
		<?php echo $form->textField($model,'is_duty_death'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rank'); ?>
		<?php echo $form->textField($model,'rank'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'post_full_name'); ?>
		<?php echo $form->textField($model,'post_full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dismiss'); ?>
		<?php echo $form->textField($model,'dismiss'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dismiss_date'); ?>
		<?php echo $form->textField($model,'dismiss_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'phone'); ?>
		<?php echo $form->textField($model,'phone'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'is_working'); ?>
		<?php echo $form->textField($model,'is_working'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_other_pension'); ?>
		<?php echo $form->textField($model,'is_other_pension'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'snils'); ?>
		<?php echo $form->textField($model,'snils'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->