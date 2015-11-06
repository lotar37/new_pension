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
//var_dump($model->cases3);
//echo $model->cases3[0]['type'];
//echo $model->cases3->type . "---------------->";
//foreach($model->cases3 as $one){
//	echo $one->type;
//}

		/*$model_wac = new WarActions();
		$c = new WarActionsController($model_wac);
		$dataProvider2 = new CActiveDataProvider('WarActions');
		$c->render('../warActions/index',array(
			'dataProvider'=>$dataProvider2,
		));*/
$type_color = "#800";
$type_textcolor = "yellow";
$type_text = "за выслугу лет";
if(isSet($model->cases3->type)){
switch($model->cases3->type){
	case "ИН":$type_color = "#00f";
		$type_textcolor = "yellow";
		$type_text = "по инвалидности";
	break;
	case "ПК":$type_color = "yellow";
		$type_textcolor = "black";
		$type_text = "по потери кормильца";
	break;
}	
}
?>
<div class='war row' style="display:none;border:1px double white;padding:10px;overflow:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:600px;width:1200px;">
<table><tr><td colspan='5' style='padding-top:3px'><font id='war_save' class='button'>Сохранить</font>&nbsp;<font id='war_close' class='button'>Отмена</font>
<td><font color='white'>Код категории пенсионера по Закону "О ветеранах"</font></td>
</table>
		<div class=' row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1100px;">
<table>
<?php 	/*
$actions = warActions::all();
foreach($actions as $k=>$v){
	if (is_numeric ($v->code))$class = 'war_head';
	else $class = "";
	if(is_numeric($v->code[0]))$num = $v->code[0];
	echo "<tr class='".$class."' num='".$num."' act='' name='".$v->shot_name."'><td>".$v->code."</td><td>".$v->name."</td></tr>";
}*/
	
?>
</table>

</div>
</div>

<div class='adress row' style="border:3px double white;padding:10px;display:none;position:absolute;background:#080;top:350px;left:150px;">
	<table><tr>
		<td style='text-align:right'>почтовый индекс</td>
		<td colspan='5'><input type='text' id='index'  size='1'></td>
		</tr><tr>
		<td style='text-align:right'>район/город</td>
		<td colspan='5'><input type='text' id='city' size='25'></td>
		</tr><tr>
		<td style='text-align:right'>населенный пункт</td>
		<td colspan='5'><input type='text' id='place' size='25'></td>
		</tr><tr>
		<td style='text-align:right'>улица</td>
		<td colspan='5'><input type='text' id='street' size='25'></td>
		</tr><tr>
		<td style='text-align:right'>дом</td>
		<td><input type='text' id='home' size='1'></td>
		<td>кор.</td>
		<td><input type='text' id='distr' size='1'></td>
		<td>кв.</td>
		<td><input type='text' id='flat' size='1'></td>
		</tr><tr>
			<td style='color:#008;text-align:right'>Телефон
		<td colspan='5'><input type='text' size='10'></td>
		</td>
		</tr><tr>
			<td>
		<td colspan='5' style='padding-top:3px'><font id='f_save' class='button'>Сохранить</font>&nbsp;<font id='f_close' class='button'>Отмена</font>
		</td>
		</tr>
		</table>
		


</div>
 
<script>
  $(document).ready(function(){
$( "#f" ).click(function() {
  $( "div.adress" ).show( "fast" );
});
$( "#fwar" ).click(function() {
  $( "div.war" ).show( "fast" );
});
$( "#f_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.adress" ).hide( "fast" );
});
$( "#war_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.war" ).hide( "fast" );
});
$( "#f_save" ).click(function(event) {
	event.stopPropagation();
	addr = $( "#index" ).val() + " " + $( "#city" ).val() + " " + $( "#place" ).val() + " " + $( "#street" ).val() + " " + $( "#home" ).val() + " " + $( "#distr" ).val() + "- " + $( "#flat" ).val();
  $( "#adress" ).val(addr);
  $( "div.adress" ).hide( "slow" );
});
$( "#f_save" ).click(function(event) {
	event.stopPropagation();
	$('warAction')
	addr = $( "#index" ).val() + " " + $( "#city" ).val() + " " + $( "#place" ).val() + " " + $( "#street" ).val() + " " + $( "#home" ).val() + " " + $( "#distr" ).val() + "- " + $( "#flat" ).val();
    $( "#adress" ).val(addr);
    $( "div.adress" ).hide( "slow" );
});
$( "#war_save" ).click(function(event) {
	event.stopPropagation();
	var arr = $('.war tr[act=true]');
	var str = "";
	for(var i=1; i<arr.length; i++){
		str += " " + $(arr[i]).attr("name");
	}
   $( "#waraction_inp" ).val(str.trim());
   $( "div.war" ).hide( "slow" );
	
});
  $(".war tr").mousedown(function () {
		a = $(this).attr("num");
		if($(this).attr("act")){
			if(a<=4)$("tr[num='"+a+"']").attr("act","");
			$("tr[num='"+a+"']").css("color","#000");
			
		}
		else{
			if(a<=4){
				$("tr[num='"+a+"']").attr("act","");
				$("tr[num='"+a+"']").css("color","#088");
			}
			$(this).css("color","#ff0");
			$(this).attr("act",true);
		}
	});	
	var s_war = $( "#waraction_inp" ).val();
	var a_war = s_war.split(" ");
	for(var i=0;i<a_war.length;i++){
		tr = $("tr[name='"+a_war[i]+"']");
		a = $(tr).attr("num");
		if(a<4){
				$("tr[num='"+a+"']").attr("act","");
				$("tr[num='"+a+"']").css("color","#088");
		}
		$(tr).css("color","#ff0");
		$(tr).attr("act",true);
	}
	var type = $("#type").attr("val");
	if(type == "ВЛ"|| type == "ИН")$("#death").css("display","none");
	if(type == "ПК")$("#dismiss").css("display","none");
});
</script>

<?php 


?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">

	<table><tr><td>	
	
	<table><tr id='type' val='<?php echo isSet($model->cases3->type) ? $model->cases3->type : "ВЛ";?>'><td style='background:<?php echo $type_color;?>;color:<?php echo $type_textcolor;?>'>AP-	<?php echo (isSet($model->cases3->number) ? $model->cases3->number : "")."  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$type_text;?></td>
	<td width='50%' style='color:yellow'><font color='black'>=======</font>Изменено: <?php //echo Yii::app()->dateFormatter->format("dd-MM-y",$model->cases3->cor_date);?>
	</td></tr></table>
	
	<table><tr><td>	<font style='color:#000080'>
		<?php echo $form->labelEx($model,'rank'); ?>
	</td>
	<td><font style='color:black'>	
		<?php echo $form->labelEx($model,'second_name'); ?>
	</td>
	<td><font style='color:black'>	
		<?php echo $form->labelEx($model,'first_name'); ?>
	</td>
	<td>	
		<font style='color:black'>
		<?php echo $form->labelEx($model,'third_name'); ?>
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
		<?php echo $form->labelEx($model,'post_full_name'); ?>
	</td><td>	
		<?php echo $form->textField($model,'post_full_name',array('size'=>120,'maxlength'=>100, 'class'=>'text')); ?>
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
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 8, 'maxlength'=>11)
			));

		?>
		<?php echo $form->error($model,'birth_date'); ?>
		
		
	</td><td><nobr>	
		<font style='color:black'><?php echo $form->labelEx($model,'birth_place'); ?></nobr>
	</td><td>	
		<?php echo $form->textField($model,'birth_place',array('size'=>'50')); 
		
		?>
		<?php echo $form->error($model,'birth_place'); ?>
	</td></tr></table>
	</td></tr>
	<tr><td style='text-align:center;'>
	 <?php echo isSet($model->dismiss0->name) ? $model->dismiss0->name : "";?>
	</td></tr>
	<tr id='death'><td>
	
	
		<table ><tr><td><nobr>
		<?php echo $form->labelEx($model,'death_date'); ?>
	</td><td>	
		<?php
			$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'death_date',
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'death_date'); ?>
	</td></tr></table>

	
	</td></tr>
	<tr id='dismiss'><td>
	<table ><tr><td><nobr>	

		<?php echo $form->labelEx($model,'dismiss_date'); ?>
	</td><td>	
		<?php 
$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'dismiss_date',
					'mask' => '99-99-9999',
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'dismiss_date'); ?>
	</td><td><nobr>		
		<?php echo $form->labelEx($model,'dismiss'); ?>
	</td><td>	
		<?php echo $form->textField($model,'dismiss'); ?>
		<?php echo $form->error($model,'dismiss'); ?>
	</td><td><nobr>		
		<?php echo $form->labelEx($model,'pension_date'); ?>
	</td><td>	
		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'pension_date',
					'mask' => '99-99-9999',
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'pension_date'); ?>
	</td></tr></table>
	</td></tr><tr><td>
			<font style='color:white'>ВЫСЛУГА ЛЕТ на пенсию</font>
	</td>
	
	</tr><tr><td>
	</td></tr>
	<tr><td>
			<font style='color:#000080'>Оклады, из которых исчислена пенсия</font>
	</td></tr>
	<tr><td>
		<table style='border:3px solid #008'><tr>
		<td>
			ДО &nbsp;<?php echo $form->textField($model->cases3,'salary_post'); ?>
		</td>
		<td>	
			ОВЗ &nbsp;<?php echo $form->textField($model->cases3,'salary_rank'); ?>
		</td>
		<td>	
			ПНВЛ &nbsp;<?php echo $form->textField($model->cases3,'year_inc_percent'); ?>%
		</td>
		<td align='' style='text-align:right;'>	
			Размер пенсии &nbsp;<?php echo $form->textField($model->cases3,'saved_summa'); ?>%
		</td>
		</tr>
		</table>
	</td></tr>
	<tr><td>
		<table><tr ><td>
		<font style='color:#ffff00'>И</font><font style='color:#000080'>нвалидность</font> ----------
			<font style='color:#800080'>начальная</font>---------
			<font style='color:#000080'>Степень ограничения ТД</font> 
	</td>
		<td style='background:#ddd;color:#008'>Члены семьи на ВВЗ
		</td>
	</tr>
		</table>
	</tr>
	<tr><td>
	<table><tr >
		<td style='text-align:right;border:0px solid red;'>Группа</td>
		<td><input type='text' size='1'></td>
		<td>Причина</td>
		<td><input type='text' size='1'></td>
		<td>срок</td>
		<td>		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date',
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'invalid_date'); ?>
</td>
		<td><nobr>--</td>
		<td>		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date2',
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'invalid_date2'); ?>
</td>
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
		<table><tr><td width='80%'><font style='color:#ffff00'>И</font><font style='color:#000080'>ждевенцы &nbsp;</font>
		</td><td><font style='color:#ffff00'>Р</font><font style='color:#000080'>аботает</font>
		</td><td>
		<?php echo $form->checkBox($model,'is_working',array('style'=>"")); ?>
		<?php echo $form->error($model,'is_working');?>
		</td>
		<td><nobr>
		<font style='color:#ffff00'>2</font><font style='color:#000080'>-я пенсия</font>
		</td><td>
		<?php echo $form->checkBox($model,'is_other_pension');?>
		<?php echo $form->error($model,'is_other_pension'); ?>
		</td>
		<td style='background:#8f0;text-align:center;'><nobr>Л/счет</td>
	
	
	</tr>
	<tr><td id='fwar'>
	
	<font style='color:#ffff00'>В</font><font style='color:#000080'>ойна&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' size='60' name='waraction_inp'  id='waraction_inp'  value='<?php //echo $model->getWarActionShotNames();?>'>
	</td>
	<td><nobr><font style='color:#000080'>Лицо, осу<font style='color:#ffff00'>щ</font>.уход</td>
	<td><input type='checkbox'></td>
	<td><nobr><font style='color:#000080'><font style='color:#ffff00'>У</font>ход</td>
	<td><input type='checkbox'></td>
	<td style='background:#8f0;text-align:center;'><nobr>СНИЛС(ПФР)</td>
	</tr>
<tr><td>
	<font style='color:#ffff00;text-align:center;'>Ч</font><font style='color:#000080'>АЭС(ПОР)</font>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' size='10' name='chaes_inp' value='<?php //echo $model->getChaesShotNames();?>'>
	</td>
	<td><font style='color:#ffff00;'>Н</font><font style='color:#000080'>аграды</td>
	<td></td>
	<td></td>
	<td></td>
	<td style='background:#8f0;text-align:center;'>Паспорт</td>
	</tr>
	
	</table>
	</td></tr>
	
	<tr><td>
	<table><tr >
		<td style='text-align:right;border:0px solid red;'>Разрешение</td>
		<td><input type='text' size='2'></td>
		<td>№</td>
		<td><input type='text' size='10'></td>
		<td>выслано </td>
		<td><input type='text' size='10'></td>
		<td>срок</td>
		<td><input type='text' size='10'></td>
		<td><nobr>--</td>
		<td><input type='text' size='10'></td>
		<td align='' style='text-align:right;color:#008;'>	
			Условие</td><td><input type='text' size='1'>
		</td>
		</tr>
	</table>
	</td>
	</tr>
	<tr><td>
	<table style='background:#8f0;'><tr class='orange_label'>
		<td style='text-align:right;border:0px solid red;'><nobr>Параметры на</td>
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
		<td style='text-align:right;background:#ddd;'>Перерасчет</td>
		<td>с</td>
		<td><input type='text' size='10'></td>
		<td style='text-align:right;background:#ddd;'>Основание</td>
		<td><input type='text' size='1'></td>
		<td><nobr>Сумма пенсии</td>
		<td><input type='text' size='10'></td>
		<td align='' style='text-align:right;color:#008;'>	
			</td><td><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr><td>
	<table><tr >
		<td style='text-align:right;background:#ddd;'>Поступило</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Выплаты</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Распоряжение</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Исчисление</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Справки</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Архив</td>
		<td>&nbsp;</td>
		<td style='text-align:right;background:#ddd;'>Расчет</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	
	</div>


	<div class="row">
		<?php //echo $form->labelEx($model,'death_date'); ?>
		<?php
			/*$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'death_date',
					'mask' => '99-99-9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'death_date'); ?>
	</div>

	<!--div class="row">
		<?php echo $form->labelEx($model,'is_duty_death'); ?>
		<?php echo $form->textField($model,'is_duty_death'); ?>
		<?php echo $form->error($model,'is_duty_death'); */?>
	</div-->


	<div class="row">
	</div>



	<div class="row">
		<?php /*echo $form->labelEx($model,'phone'); ?>
		<?php
			$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'phone',
					'mask' => '7(999)999-99-99',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 15, 'maxlength'=>11)
			));
		?>
		<?php echo $form->error($model,'phone'); ?>
	</div>




	<div class="row">
		<?php echo $form->labelEx($model,'snils'); ?>
		<?php echo $form->textField($model,'snils'); ?>
		<?php echo $form->error($model,'snils'); */?>
	</div>

	<div class="row buttons">
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->