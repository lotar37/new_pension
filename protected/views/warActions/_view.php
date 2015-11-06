<?php
/* @var $this WarActionsController */
/* @var $data WarActions */
?>

<div class="view war">
<table><tr><td>
	
	<?php echo CHtml::encode($data->code); ?>
	<br />
</td><td>
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

</td></tr></table>

</div>