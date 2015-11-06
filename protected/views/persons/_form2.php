<?php
/* @var $this PersonsController */
/* @var $model Persons */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'second_name'); ?>
		<?php echo $form->textField($model,'second_name'); ?>
		<?php echo $form->error($model,'second_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'third_name'); ?>
		<?php echo $form->textField($model,'third_name'); ?>
		<?php echo $form->error($model,'third_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date'); ?>
		<?php echo $form->error($model,'birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_place'); ?>
		<?php echo $form->textField($model,'birth_place'); ?>
		<?php echo $form->error($model,'birth_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pension_date'); ?>
		<?php echo $form->textField($model,'pension_date'); ?>
		<?php echo $form->error($model,'pension_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'death_date'); ?>
		<?php echo $form->textField($model,'death_date'); ?>
		<?php echo $form->error($model,'death_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_duty_death'); ?>
		<?php echo $form->textField($model,'is_duty_death'); ?>
		<?php echo $form->error($model,'is_duty_death'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rank'); ?>
		<?php echo $form->textField($model,'rank'); ?>
		<?php echo $form->error($model,'rank'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textField($model,'post'); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post_full_name'); ?>
		<?php echo $form->textField($model,'post_full_name'); ?>
		<?php echo $form->error($model,'post_full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dismiss'); ?>
		<?php echo $form->textField($model,'dismiss'); ?>
		<?php echo $form->error($model,'dismiss'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dismiss_date'); ?>
		<?php echo $form->textField($model,'dismiss_date'); ?>
		<?php echo $form->error($model,'dismiss_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_working'); ?>
		<?php echo $form->textField($model,'is_working'); ?>
		<?php echo $form->error($model,'is_working'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invalid_reason'); ?>
		<?php echo $form->textField($model,'invalid_reason'); ?>
		<?php echo $form->error($model,'invalid_reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invalid_group'); ?>
		<?php echo $form->textField($model,'invalid_group'); ?>
		<?php echo $form->error($model,'invalid_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invalid_date'); ?>
		<?php echo $form->textField($model,'invalid_date'); ?>
		<?php echo $form->error($model,'invalid_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invalid_date2'); ?>
		<?php echo $form->textField($model,'invalid_date2'); ?>
		<?php echo $form->error($model,'invalid_date2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invalid_limit'); ?>
		<?php echo $form->textField($model,'invalid_limit'); ?>
		<?php echo $form->error($model,'invalid_limit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_other_pension'); ?>
		<?php echo $form->textField($model,'is_other_pension'); ?>
		<?php echo $form->error($model,'is_other_pension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'snils'); ?>
		<?php echo $form->textField($model,'snils'); ?>
		<?php echo $form->error($model,'snils'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delo'); ?>
		<?php echo $form->textField($model,'delo'); ?>
		<?php echo $form->error($model,'delo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'igdiv'); ?>
		<?php echo $form->checkBox($model,'igdiv'); ?>
		<?php echo $form->error($model,'igdiv'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->