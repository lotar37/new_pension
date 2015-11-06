<?php
/* @var $this PersonsController */
/* @var $data Persons */
?>
		
<br>		
	 <?php echo CHtml::button('Назад на форму редактирования', array('submit' => array('persons/update/'.$data->id))); ?>
     <?php //var_dump($data->cases3);?>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('second_name')); ?>:</b>
	<?php echo CHtml::encode($data->second_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('third_name')); ?>:</b>
	<?php echo CHtml::encode($data->third_name); ?>
	<br />
		<?php 
					$this->widget('CMaskedTextField', array(
					'model' => $data,
					'attribute' => 'birth_date',
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11),
			));

		?>


	<b><?php echo CHtml::encode($data->getAttributeLabel('birth_date')); ?>:</b>
	<?php echo CHtml::encode($data->birth_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birth_place')); ?>:</b>
	<?php echo CHtml::encode($data->birth_place); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pension_date')); ?>:</b>
	<?php echo CHtml::encode($data->pension_date); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('death_date')); ?>:</b>
	<?php echo CHtml::encode($data->death_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_duty_death')); ?>:</b>
	<?php echo CHtml::encode($data->is_duty_death); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rank')); ?>:</b>
	<?php echo CHtml::encode($data->rank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_full_name')); ?>:</b>
	<?php echo CHtml::encode($data->post_full_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dismiss')); ?>:</b>
	<?php echo CHtml::encode($data->dismiss); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dismiss_date')); ?>:</b>
	<?php echo CHtml::encode($data->dismiss_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_working')); ?>:</b>
	<?php echo CHtml::encode($data->is_working); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invalid_reason')); ?>:</b>
	<?php echo CHtml::encode($data->invalid_reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invalid_group')); ?>:</b>
	<?php echo CHtml::encode($data->invalid_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invalid_date')); ?>:</b>
	<?php echo CHtml::encode($data->invalid_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invalid_date2')); ?>:</b>
	<?php echo CHtml::encode($data->invalid_date2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invalid_limit')); ?>:</b>
	<?php echo CHtml::encode($data->invalid_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_other_pension')); ?>:</b>
	<?php echo CHtml::encode($data->is_other_pension); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('snils')); ?>:</b>
	<?php echo CHtml::encode($data->snils); ?>
	<br />


	

</div>