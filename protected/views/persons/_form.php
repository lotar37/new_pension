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
<?php
///// 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/person_form.js',CClientScript::POS_END );
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.maskedinput.js',CClientScript::POS_END );


$dependants = "";	
if(isset($model->seniorities))
	foreach($model->seniorities as $one){
	if($one->type == "y")${"seniority_".$one->class} = $one->value;
}

if(isSet($model->cases3)){
	$d = Dependants::model()->findAllByAttributes(array("case"=>$model->cases3->id));
	if(!is_null($d)){
		foreach($d as $one){
			$p = Persons::model()->findByAttributes(array("id"=>$one->dependant));
			if(!is_null($p))$dependants .= $p->second_name." ".$p->first_name." ".$p->third_name.", ";
		}
	}				
}
?>

<div class='war row type1'></div>

<div class='post row type1'></div>

<div class='chaes row type1'></div>

<div class='dismiss row type1'></div>

<div class='dependants row'  style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:450px;left:550px;"></div>

<div class='pererast row type2'>
<table><tr><td colspan='5' style='padding-top:3px'><font id='pererast_save' class='button'>Сохранить</font>&nbsp;<font id='pererast_close' class='button'>Отмена</font>
<td><font color='white'>Перерасчет</font></td>
</table>
		<div id='pereraschet_div' class='row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:scroll;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1000px;">
</div>
</div>

<div class='seniorities row ' style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:250px;left:150px;height:300px;"></div>


<div class='snils row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:450px;left:550px;">
<table>
<tr>
<td colspan='2' style='padding-top:2px;text-align:center;background:#fff;'>
<?php echo $model->second_name." ".$model->first_name." ".$model->third_name;?>
</td>
</tr>
<tr>
<td style='padding-top:2px;'>CНИЛС</td>
<td><?php echo $form->textField($model,'snils',array("size" => 20)); ?></td>
</tr>
<tr>
		<td colspan='2' style='padding-top:6px;text-align:right;'><font id='snils_save' class='button'>OK</font>&nbsp;<font id='snils_close' class='button'>Отмена</font>
		</td>
		</tr>
</table>
</div>
		
		
<div class='resolution row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:250px;left:150px;height:350px;">

<table>
<tr>
		<td style='padding-top:2px;text-align:center;background:#fff;'>Разрешение на выплату пенсии</td>
		</tr>
	<tr>
		<td style='text-align:right'><nobr>
		Серия <?php echo CHtml::textField("res_ser", isset($model->resolution['ser']) ? $model->resolution['ser'] : "", array("size"=>2) );?>
		№ <?php echo CHtml::textField("res_number",  isset($model->resolution['number']) ? $model->resolution['number'] : "", array("size"=>9) );?>
		</nobr>
		
		Дата высылки
	    <?php 
 			$this->widget('CMaskedTextField', array(
					'id' => 'res_sent_date',
					'name' => 'res_sent_date',
					'mask' => '99.99.9999',
					'value' => isset($model->resolution['sent_date']) ? $model->resolution['sent_date'] : "",
					'htmlOptions' => array('size' => 10, 'maxlength'=>11, )
			));
		?>		
		</td>
		</tr>
		<tr>
		<td style=''><nobr>
		Срок действия 
		с <?php 
 			$this->widget('CMaskedTextField', array(
					'id' => 'res_begin_action_date',
					'name' => 'res_begin_action_date',
					'mask' => '99.99.9999',
					'value' => isset($model->resolution['begin_action_date']) ? $model->resolution['begin_action_date'] : "",
					'htmlOptions' => array('size' => 10, 'maxlength'=>11, )
			));
		
		//echo CHtml::textField("res_begin_action_date",  isset($model->resolution['begin_action_date']) ? $model->resolution['begin_action_date'] : "", array("size"=>9) );?>		
        по<?php 
 			$this->widget('CMaskedTextField', array(
					'id' => 'res_end_action_date',
					'name' => 'res_end_action_date',
					'mask' => '99.99.9999',
					'value' => isset($model->resolution['end_action_date']) ? $model->resolution['end_action_date'] : "",
					'htmlOptions' => array('size' => 10, 'maxlength'=>11, )
			));
		
		//echo CHtml::textField("res_end_action_date",  isset($model->resolution['end_action_date']) ? $model->resolution['end_action_date'] : "", array("size"=>9) );?>
</nobr></td>
		</tr>
		<tr>
		<td style=''><nobr></nobr></td>
		
		</tr>
<tr>
		<td colspan='2' style='padding-top:6px;text-align:right;'><font id='resolution_save' class='button'>OK</font>&nbsp;<font id='resolution_close' class='button'>Отмена</font>
		</td>
		</tr>
</table>
</div>

<div class='sber row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:450px;left:550px;">
	<table>
<tr>
		<td colspan='2' style='padding-top:2px;text-align:center;color:#ff0;'>Лицевой счет пенсионера в Сбербанке</td>
		</tr>
	<tr>
		<td style='text-align:right'>П/дело</td>
		<td><?php echo $model->cases3->number;?></td>
		</tr>
	<tr>
		<td style='text-align:right'>№ ОСБ</td>
		<td><?php echo CHtml::textField("department", isset($model->bankAccount->bank0->department) ? $model->bankAccount->bank0->department : "", array("size"=>6) );?></td>
		</tr>
	<tr>
		<td style='text-align:right'>№ Филиала</td>
		<td><?php echo CHtml::textField("filial", 6 , array("size"=>1));?></td>
		</tr>
	<tr>
		<td style='text-align:right'>№ л/счета</td>
		<td><?php echo CHtml::textField("l_schet", isset($model->bankAccount->number) ? $model->bankAccount->number : "", array("size"=>25) );?></td>
		</tr>
<tr>
		<td colspan='2' style='padding-top:6px;text-align:right;'><font id='sber_save' class='button'>OK</font>&nbsp;<font id='sber_close' class='button'>Отмена</font>
		</td>
		</tr>
		</table>
		
</div>

<div class='doc row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#bbb;top:450px;left:550px;">
	<table>
<tr>
		<td colspan='2' style='padding-top:2px;text-align:center;color:#ff0;'>Документы</td>
		</tr>
	<tr>
		<td >
		<nobr>
		Серия<?php echo CHtml::textField("doc_series", isset($model->identDoc->series) ?  $model->identDoc->series : "", array("size"=>2));?>
		№    <?php echo CHtml::textField("doc_number", isset($model->identDoc->number) ? $model->identDoc->number : "", array("size"=>6));?>
		</nobr>
		
		</td>
	<tr>
		<td >
		<nobr>
		Выдан		<?php echo CHtml::textField("doc_give_org",  isset($model->identDoc->give_org) ? $model->identDoc->give_org : "", array("size"=>20));?>
		</nobr>
		
		</td>
		</tr>
	<tr>
		<td >
		<nobr>
		Дата выдачи  <?php echo CHtml::textField("doc_give_date", isset($model->identDoc->give_date) ? $model->identDoc->give_date : "", array("size"=>6,"id"=>"doc_give_date"));?>
		</nobr>
		
		</td>
		</tr>
	<tr>
		<td >
		<nobr>
		Примечание    <?php echo CHtml::textField("doc_comment", isset($model->identDoc->comment) ? $model->identDoc->comment : "", array("size"=>20));?>
		</nobr>
		
		</td>
		</tr>
<tr>
		<td style='padding-top:6px;text-align:right;'><font id='doc_save' class='button'>OK</font>&nbsp;<font id='doc_close' class='button'>Отмена</font>
		</td>
		</tr>
		</table>
		
</div>

<div class='adress row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#080;top:350px;left:150px;">
	<table><tr>
		<td style='text-align:right'>регион</td>
		<td colspan='5'><?php echo CHtml::dropDownList("region",isset($model->addrs->region) ? $model->addrs->region : "",Regions::all());?></td>
		</tr>
		<tr>		<td style='text-align:right'>почтовый индекс</td>
		<td colspan='5'>
		<input type='text' id='index' name='index'   size='1' value='<?php echo isset($model->addrs->post_index) ? $model->addrs->post_index : "";?>'></td>
		</tr><tr>
		<td style='text-align:right'>район/город</td>
		<td colspan='5'><input type='text' id='city' name='city' size='25'  value='<?php echo isset($model->addrs->town) ? $model->addrs->town : "";?>'></td>
		</tr><tr>
		<td style='text-align:right'>улица</td>
		<td colspan='5'><input type='text' id='street' name='street' size='25' value='<?php echo isset($model->addrs->street) ? $model->addrs->street : "";?>'></td>
		</tr><tr>
		<td style='text-align:right'>дом</td>
		<td><input type='text' id='home' name='home' size='1' value='<?php echo isset($model->addrs->house) ? $model->addrs->house : "";?>'></td>
		<td>кор.</td>
		<td><input type='text' id='body' name='body' size='1' value='<?php echo isset($model->addrs->body) ? $model->addrs->body : "";?>'></td>
		<td>кв.</td>
		<td><input type='text' id='apartment' name='apartment' size='1' value='<?php echo isset($model->addrs->apartment) ? $model->addrs->apartment : "";?>'></td>
		</tr><tr>
			<td style='color:#008;text-align:right'>Телефон</td>
		<td colspan='5'>
		<?php echo $form->textField($model,'phone',array('size'=>10,"id"=>"phone")); ?>
		<!--input type='text' size='10' name='phone' value='<?php //echo isset($model->phone) ? $model->phone : "";?>'-->
		</td>
		
		</tr><tr>
			<td>
		<td colspan='5' style='padding-top:3px'><font id='f_save' class='button'>OK</font>&nbsp;<font id='f_close' class='button'>Отмена</font>
		</td>
		</tr>
		</table>
</div>

<?php
	$loPersonReferences = new PersonReferences( $model->id );
	print $loPersonReferences->printPersonReferencesTable();
	
	$loPersonPayments = new PersonPayments( $model->id );
	print $loPersonPayments->printPersonPaymentsTable();
?>


 <?php
 $_adddir = "";
 if($model->second_name=="-"){
	 $_adddir = "../";
 }
 ?>
<script>

$(document).ready(function(){
	
	<?php
		print $loPersonReferences->printPersonReferencesTableJS( '#ButtonPersonReferences' );
		print $loPersonPayments->printPersonPaymentsTableJS( '#ButtonPersonPayments' );		
	?>
//checkCardType();	

	//closeAllWindow();
});
</script>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">

<?php	
//----------------------------------------------------------------------------------------------/
//----------------------------------------------------------------------------------------------/
//////////////////                                                           ///////////////////
//////////////////                карточка пенсионера                        ///////////////////	
//////////////////                                                           ///////////////////
//----------------------------------------------------------------------------------------------/
//----------------------------------------------------------------------------------------------/

?>	
	
	
	
	
	
	<table id='person' adddir='<?php echo $_adddir;?>' number='<?php echo $model->id;?>' seniority=''><tr><td>	
	
	<table><tr id='type' val='<?php echo isSet($model->cases3->type) ? $model->cases3->type : "ВЛ";?>'>
	<td id='carthead' class='nowrap' style=''>
	<?php echo $form->dropDownList($model,'type',Cases::getTypes(),array("id"=>"_types"));?>
	<?php echo isset($model->cases3->comm0->code) ? $model->cases3->comm0->code : "";?>-	
	<?php echo CHtml::textField("delo", isset($model->cases3->number) ? $model->cases3->number : "", array("size"=>6,"id"=>"pdelo")); ?>	
	<?php echo CHtml::dropDownList('_comm',$model->cases3->comm,Comms::getComms());?>
	<?php echo "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font id='type_text' style=''></font>";?></td>
	<td width='25%' style='color:yellow'><font color='black'>=======</font>Изменено: <?php echo $model->cases3->date." ". $model->id;
	//echo Yii::app()->dateFormatter->format("dd-MM-y",$model->cases3->cor_date);?>
	</td></tr></table>
	
	<table><tr><td>	<font style='color:#000080'>
		<?php echo $form->labelEx($model,'rank'); ?></font>
	</td>
	<td><font style='color:black'>	
		<?php echo $form->labelEx($model,'second_name'); ?></font>
	</td>
	<td><font style='color:black'>	
		<?php echo $form->labelEx($model,'first_name'); ?></font>
	</td>
	<td>	
		<font style='color:black'>
		<?php echo $form->labelEx($model,'third_name'); ?></font>
	</td>
	</tr><tr>
	<td>	
		<?php //echo $form->textField($model,'rank'); ?>
		<?php echo $form->error($model,'rank'); 
		echo $form->dropDownList($model,'rank',Ranks::all());?>
		
	<td>	
		<?php echo $form->textField($model,'second_name'); ?>
		<?php echo $form->error($model,'second_name'); ?>
	</td>
<td>	
		<?php echo $form->textField($model,'first_name'); ?>	
		<?php echo $form->error($model,'first_name'); ?>
	</td>
	<td>	
		<?php echo $form->textField($model,'third_name'); ?>
		<?php echo $form->error($model,'third_name'); ?>
	</td>	</tr></table>
	</td></tr>
	<tr>
	<td>	
	<table><tr><td сlass='black'><nobr><font style='color:black'>	
		<?php echo $form->labelEx($model,'post_full_name'); ?></font></nobr>
	</td><td>	
		<?php echo $form->textField($model,'post_full_name',array('size'=>"90",'class'=>'text',"id"=>"post_full_name")); ?>
		<?php echo $form->error($model,'post_full_name'); ?>
	</td></tr></table>
	

	</td></tr>
	<tr><td>
	<table width=''><tr><td><nobr>
		<font style='color:black'><?php echo $form->labelEx($model,'birth_date'); ?></nobr>
	</td><td>	

		<?php     
					$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'birth_date',
					'id' =>'birth_date',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11),
			));

		?>
		<?php echo $form->error($model,'birth_date'); ?>
		
		
	</td><td  style='color:yellow'><nobr>	<?php echo $model->age;?>
	</td><td><nobr>	
		<font style='color:black'><?php echo $form->labelEx($model,'birth_place'); ?></font></nobr>
	</td><td>	
		<?php echo $form->textField($model,'birth_place',array('size'=>'50')); 
		
		?>
		<?php echo $form->error($model,'birth_place'); ?>
	</td></tr></table>
	</td></tr>
	<tr><td style='text-align:center;' id='dismiss_name'>
	 <?php echo isSet($model->dismiss0->name) ? $model->dismiss0->name : "";?>
	</td></tr>
	<tr id='death'><td>
	
	
		<table ><tr><td><nobr>
		<?php echo $form->labelEx($model,'death_date'); ?></nobr>
	</td><td>	
		<?php //echo $form->textField($model,'death_date'); ?>
		<?php 
			$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'death_date',
					'id' => 'death_date',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'death_date'); ?>
	</td></tr></table>

	
	</td></tr>
	<tr id='dismiss'><td>
	<table ><tr><td><nobr>	

		<?php echo $form->labelEx($model,'dismiss_date'); ?></nobr>
	</td><td>	
		<?php //echo $form->textField($model,'dismiss_date'); ?>
		<?php 
$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'dismiss_date',
					'id' => 'dismiss_date',
					'mask' => '99.99.9999',
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'dismiss_date'); ?>
	</td><td style='text-align:right;' id='fdismiss'><nobr>		
		<?php echo $form->labelEx($model,'dismiss'); ?></nobr>
	</td><td>	
<?php echo CHtml::textField("dismiss", isset($model->dismiss_code) ? $model->dismiss_code : "", array("size"=>6) );?>	
		<?php echo $form->error($model,'dismiss'); ?>
	</td><td style='text-align:right;'><nobr>		
		<?php echo $form->labelEx($model,'pension_date'); ?></nobr>
	</td><td>	
		<?php //echo $form->textField($model,'pension_date'); ?>
		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'pension_date',
					'id' => 'pension_date',
					'mask' => '99.99.9999',
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'pension_date'); ?>
	</td></tr></table>
	
	</td></tr><tr><td>
			<font style='color:white' id='stash' val='<?php echo $model->cases3->include_seniority;?>'><?php echo $model->cases3->include_seniority ?  "ТРУДОВОЙ СТАЖ " : "ВЫСЛУГА ЛЕТ ";?> на пенсию</font>
					<?php echo $form->checkBox($model->cases3,'include_seniority',array("id"=>'include_seniority'));?>

	</td>
	
	</tr>
	
	<tr>
	<td>
	<table class='nowrap' width='30%' ><tr>
	<td  id='fseniorities'>ОБЩАЯ <input type='text' name='seniority_common' size='1' value='<?php echo isSet($seniority_common) ? $seniority_common : "";?>'></td>
	<td style='margin:0em;'>календарная <input type='text' size='1' name='seniority_calendar' value='<?php echo isSet($seniority_calendar) ?$seniority_calendar: "";?>'></td>
	<td>учеба <input type='text' size='1' name='seniority_study' value='<?php echo isSet($seniority_study) ? $seniority_study: "";?>'></td>
	<td>льготная <input type='text' size='1' name='seniority_privilege' value='<?php echo isSet($seniority_privilege) ? $seniority_privilege : "";?>'></td>
	<td>в МВД <input type='text' size='1' name='seniority_mia' value='<?php echo isSet($seniority_mia) ? $seniority_mia: "" ;?>'></td>
	<td style='text-align:right;' width='30%'>
	<nobr>Тарифный разряд 
	<?php echo CHtml::dropDownList("code_tr",$model->cases3->code_tr,$model->trChanges);?>
	<font id='fpost'>Катег.
	<?php echo CHtml::textField("post_inp", $model->getPostShotNames() ,array("id"=>"post_inp","size"=>9));?>
	</font>
	</nobr></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr><td>
			<font style='color:#000080'>Оклады, из которых исчислена пенсия</font>
	</td></tr>
	<tr><td>
		<table width='1100px' style='border:3px solid #008;'><tr>
		<td>
			<nobr>ДО &nbsp;<?php echo $form->textField($model,'salary_post',array('id'=>'salary_post')); ?>
		<?php echo $form->error($model,'salary_post'); ?></nobr>
		</td>
		<td>	
			<nobr>ОВЗ &nbsp;<?php echo $form->textField($model,'salary_rank',array('id'=>'salary_rank')); ?>
		<?php echo $form->error($model,'salary_rank'); ?></nobr>
		</td>
		<td>	
			<nobr>ПНВЛ &nbsp;<?php echo $form->textField($model,'year_inc_percent',array('size'=>'1')); ?>%</nobr>
		</td>
		<td width='40%' style='text-align:right;'>	
			<nobr>Размер пенсии &nbsp;<?php echo $model->cases3->pension_percent; ?>%</nobr>
		</td>
		</tr>
		</table>
	</td></tr>
	<tr>
	<td>
		<table><tr ><td>
	<?php if($dependants){?>
		<font style='color:#000'>Получатель пенсии</font> ----------
	<?php }else{?>
		<font style='color:#ffff00'>И</font><font style='color:#000080'>нвалидность</font> ----------
		<font style='color:#800080'>первичная</font>---------
		<font style='color:#000080'>Степень ограничения ТД</font> 
		<input type='text' value='<?php echo $model->invalid_limit?>' size='1'>
	
	
	<?php }?>
	</td>
		<td style='background:#ddd;color:#008'>Члены семьи на ВВЗ
		</td>
	</tr>
		</table>
	</tr>
	<tr><td>
	<?php if($dependants){?>
	<table><tr >
		<td><input type='text' size='40' value='<?php echo $dependants;?>'></td>
	<?php }else{?>
	<table><tr >
		<td style='text-align:right;border:0px solid red;'>Группа</td>
		<td><?php echo $form->textField($model,'invalid_group',array('size'=>'1')); ?></td>
		<td>Причина</td>
		<td><input type='text' value='<?php echo isSet($model->invalidReason->code) ? $model->invalidReason->code : "";?>' size='1'></td>
		<td>срок</td>
		<td>
		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date',
					'id' => 'invalid_date',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'invalid_date'); ?>
</td>
		<td><nobr>--</nobr></td>
		<td>		
		<?php 
			$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date2',
					'id' => 'invalid_date2',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'invalid_date2'); ?>
</td>
	<?php }?>
		<td align='' style='text-align:right;color:#008;'>	
			------</td>
			<td style='background:#ddd;color:#000'>Выплаты ЧАЭС по суду
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr><td  id='f'>
			<font style='color:#ffff00'>А</font><font style='color:#000080'>дрес&nbsp;</font><input id='adress' class='text' type='text' size='50'>
	</td></tr>
	<tr><td>
		<table><tr><td width='80%' id='fdependants'><font style='color:#ffff00'>И</font><font style='color:#000080'>ждевенцы &nbsp;</font>
		</td><td><font style='color:#ffff00'>Р</font><font style='color:#000080'>аботает</font>
		</td><td>
		<?php echo $form->checkBox($model,'is_working',array('style'=>"")); ?>
		<?php echo $form->error($model,'is_working');?>
		</td>
		<td><nobr>
		<font style='color:#ffff00'>2</font><font style='color:#000080'>-я пенсия</font></nobr>
		</td><td>
		<?php echo $form->checkBox($model,'is_other_pension');?>
		<?php echo $form->error($model,'is_other_pension'); ?>
		</td>
		<td style='background:#8f0;text-align:center;' id='fsber'><nobr>Л/счет</nobr></td>
	
	
	</tr>
	<tr><td id='fwar'>
	
	<font style='color:#ffff00'>В</font><font style='color:#000080'>ойна</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' size='50' name='waraction_inp'  id='waraction_inp'  value='<?php echo $model->getWarActionShotNames();?>'>
	</td>
	<td><nobr><font style='color:#000080'>Лицо, осу<font style='color:#ffff00'>щ</font>.уход</font></nobr></td>
	<td><input type='checkbox'></td>
	<td><nobr><font style='color:#000080'><font style='color:#ffff00'>У</font>ход</font></nobr></td>
	<td><input type='checkbox'></td>
	<td style='background:#8f0;text-align:center;' id='fsnils'><nobr>СНИЛС(ПФР)</nobr></td>
	</tr>
<tr><td id='fchaes'>
	<font style='color:#ffff00;text-align:center;'>Ч</font><font style='color:#000080'>АЭС(ПОР)</font>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' size='15' id='chaes_inp' name='chaes_inp' value='<?php echo $model->getChaesShotNames();?>'>
	</td>
	<td><font style='color:#ffff00;'>Н</font><font style='color:#000080'>аграды</font></td>
	<td></td>
	<td></td>
	<td></td>
	<td style='background:#8f0;text-align:center;' id='fdoc'>Паспорт</td>
	</tr>
	
	</table>
	</td></tr>
	
	<tr><td>
	<table class='input_disable'  id='fresolution'><tr >
		<td style='text-align:right;border:0px solid red;'>Разрешение</td>
		<td><input name='_form_ser_res' type='text' size='2' value='<?php echo isset($model->resolution['ser'])? $model->resolution['ser'] : "";?>'></td>
		<td>№</td>
		<td><input name='_form_res_number' type='text' size='10' value='<?php echo isset($model->resolution['number'])? $model->resolution['number'] : "";?>'></td>
		<td>выслано </td>
		<td><input name='_form_sent_date' type='text' size='10' value='<?php echo isset($model->resolution['sent_date'])? $model->resolution['sent_date'] : "";?>'></td>
		<td>срок</td>
		<td><input name='_form_begin_action_date' type='text' size='10' value='<?php echo isset($model->resolution['begin_action_date'])? $model->resolution['begin_action_date'] : "";?>'></td>
		<td><nobr>--</nobr></td>
		<td><input name='_form_end_action_date' type='text' size='10' value='<?php echo isset($model->resolution['end_action_date'])? $model->resolution['end_action_date'] : "";?>'></td>
		<td align='' style='text-align:right;color:#008;'>	
			Условие</td><td><input type='text' size='1'>
		</td>
		</tr>
	</table>
	</td>
	</tr>
	<tr><td>
	<table style='background:#8f0;'><tr class='orange_label'>
		<td style='text-align:right;border:0px solid red;'><nobr>Параметры на</nobr></td>
		<td><input type='text' size='10'></td>
		<td>мпс: </td>
		<td><input type='text' size='5'></td>
		<td>мрот:</td>
		<td><input type='text' size='5'></td>
		<td>тпс</td>
		<td><input type='text' size='10'></td>
		<td width='40%'>	
			------------
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr><td>
	<table><tr >
		<td style='text-align:right;background:#ddd;' id='pereraschet'>Перерасчет</td>
		<td>с</td>
		<td><input type='text' size='10' value='<?php echo  Yii::app()->dateFormatter->format("dd.MM.y",$model->cases3->calc_date);?>'></td>
		<td style='text-align:right;background:#ddd;'>Основание</td>
		<td><input type='text' size='1'></td>
		<td><nobr>Сумма пенсии</nobr></td>
		<td><?php echo $form->textField($model,'saved_summa', array('id'=>'saved_summa', 'size'=>'11'));?>&nbsp;


</td>		<td align='' style='text-align:right;color:#008;'>	
			</td><td><?php echo CHtml::button($model->isNewRecord ? 'Создать' : 'Сохранить',array("id"=>"save_form")); ?>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr><td>
	<table class='menu_bottom'>
	  <tr>
		<td class='but'>Поступило</td>
		<td>&nbsp;</td>
        <td class='but' id='ButtonPersonPayments'>Выплаты</td>
		<td>&nbsp;</td>
		<td class='but'>Распоряжение</td>
		<td>&nbsp;</td>
		<td class='but' id='isch'>Исчисление <font color='white'>F6</font></td>
		<td>&nbsp;</td>
		<td class='but' id='ButtonPersonReferences'>Справки</td>
		<td>&nbsp;</td>
		<td class='but' id='opa'>Архив</td>
		<td>&nbsp;</td>
		<td class='but' id='raschet'>Расчет <font color='white'>F9</font></td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	
	</div>






	<div class="row buttons">
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->