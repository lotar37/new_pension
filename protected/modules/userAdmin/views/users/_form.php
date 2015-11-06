<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<!-- 	<p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<?php echo $form->errorSummary($model); ?>
<div style="float: left">
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'system'); ?>
		<?php echo $form->checkBox($model,'system'); ?>
		<?php echo $form->error($model,'system'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('onClick'=>'$("#Users_roles option").prop("selected","true");return(true);')); ?>
	</div>
</div>
<div  style="float: right">
	<div class="row" style="float: right">
		<?php echo $form->labelEx($model,'roles'); ?>
<? 
// $roles = explode("\n", $model->getRoles()); 
	$roles = $model->getRolesList();
	$roles2 = array_diff($model->getAllRolesList(), $model->getRolesList());
	

// $roles[]='+' ;
?>
		<?php // echo $form->checkBoxList($model,'roles', $roles, array('labelOptions'=>array('style'=>'display:inline'),)); ?>
		<?php echo $form->listBox($model,'roles', $roles, array('multiple'=>'multiple', 'style'=>'min-width:100%'));?>
		<?php echo $form->error($model,'roles'); ?>
		<div class="row buttons">
			<?php echo CHtml::Button('Добавить', array('onClick'=>'$("#mydialog").dialog("open");')); ?>
			<?php echo CHtml::Button('Удалить', array('onClick'=>'$("#Users_roles option:selected").detach().appendTo($("#qf"));')); ?>
		</div> 
	</div>
</div>



<?php $this->endWidget(); ?>

</div><!-- form -->

<?
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'mydialog',
                    'options' => array(
                        'title' => 'Роли',
                        'autoOpen' => false,
                        'modal' => true,
                        'resizable'=> true
                    ),
                ));
                $qForm = new rolesForm;
  
                $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'quick-form',
                            'enableClientValidation' => false,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'action' => array('users/view/id/'.$model->id),
                        ));
                ?>
      
                    <?php echo $form->errorSummary($qForm); ?>
              
                        <?php // echo $form->labelEx($qForm,'name'); ?>
		<?php echo $form->dropDownList($model,'roles', $roles2, array('multiple'=>multiple,'id'=>'qf')); ?>
                        <?php echo $form->error($qForm,'name'); ?>
      
                        <?php // echo CHtml::submitButton('Отправить'); ?>
                  
		<?php echo CHtml::Button('Ок', array('onClick'=>'$("#qf option:selected").detach().appendTo($("#Users_roles"));$("#mydialog").dialog("close");')); ?>
                        <?php
                $this->endWidget();
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                ?>