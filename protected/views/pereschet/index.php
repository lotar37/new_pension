<h1>Массовый перерасчет пенсий</h1>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pereschet-form',
	'enableAjaxValidation'=>false,
)); ?>

<table>
<tr>
<td>
Пересчитать на дату:
</td>
<td>
<?php
    
			$this->widget('CMaskedTextField', array(
					'name' => "date",
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
?>
</td>
</tr>
<tr>
<td>
Основание:
</td>
<td>
<?php
$options = Calculator::getAssoc("SELECT id, name FROM basis_docs"); //print_r($options); 
echo CHtml::dropDownList('basisDocID', null, $options);
?>
</td>
</tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::button('Расчет', array('submit' => array('raschet'), 'onclick' => "if (!confirm(\"Вы хотите произвести перерасчет дел?\\n\\n(Процесс может занять некоторое время)\")) return false;")); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->