<?php
/* @var $this LoggedActionsController */
/* @var $data LoggedActions */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_session')); ?>:</b>
	<?php echo CHtml::encode($data->id_session); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schema_name')); ?>:</b>
	<?php echo CHtml::encode($data->schema_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('table_name')); ?>:</b>
	<?php echo CHtml::encode($data->table_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_tstamp')); ?>:</b>
	<?php echo CHtml::encode($data->action_tstamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('query')); ?>:</b>
	<?php echo CHtml::encode($data->query); ?>
	<br />


</div>