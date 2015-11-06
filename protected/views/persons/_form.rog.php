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


$dependants = "";	
if(isset($model->seniorities))
	foreach($model->seniorities as $one){
	if($one->type == "y")${"seniority_".$one->class} = $one->value;
}

if(isSet($model->cases3)){
	/*switch($model->cases3->type){
	case "ИН":$type_color = "#00f";
		$type_textcolor = "yellow";
		$type_text = "по инвалидности";
	break;
	case "ПК":$type_color = "yellow";
		$type_textcolor = "black";
		$type_text = "по потере кормильца";
	break;
	case "ВЛ":$type_color = "#800";
		$type_textcolor = "black";
		$type_text = "за выслугу лет";
	break;
	case "ВВ":$type_color = "#f50";
		$type_textcolor = "black";
		$type_text = "возмещение вреда здоровью";
	break;
	case "СП":$type_color = "#fff";
		$type_textcolor = "black";
		$type_text = "социальное пособие";
	break;
	default:$type_color = "#0f0";
		$type_textcolor = "black";
		$type_text = "";

	}	*/
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
					'name' => 'res_begin_action_date',
					'mask' => '99.99.9999',
					'value' => isset($model->resolution['begin_action_date']) ? $model->resolution['begin_action_date'] : "",
					'htmlOptions' => array('size' => 10, 'maxlength'=>11, )
			));
		
		//echo CHtml::textField("res_begin_action_date",  isset($model->resolution['begin_action_date']) ? $model->resolution['begin_action_date'] : "", array("size"=>9) );?>		
        по<?php 
 			$this->widget('CMaskedTextField', array(
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
		Дата выдачи  <?php echo CHtml::textField("doc_give_date", isset($model->identDoc->give_date) ? $model->identDoc->give_date : "", array("size"=>6));?>
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
		<td colspan='5'><input type='text' size='10' name='tel' value='<?php echo isset($model->addrs->tel) ? $model->addrs->tel : "";?>'></td>
		
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
function closeAllWindow(exeption){
    arr = new Array("adress","war","post","sber","snils","doc","chaes","resolution","seniorities","pererast","dismiss");
	ext = 0;
    for(var i=0;i<arr.length;i++){
	    if($("div."+arr[i]).is(':visible'))ext  = 1;
	    if(arr[i] != exeption)$("div."+arr[i]).hide();
    } 
		//alert(ext + " - " + (exeption==""));

	if(!ext && (exeption=="")){
	    window.document.location.href='../../persons/persearch';	
	}
}
$(document).ready(function(){
	
	<?php
		print $loPersonReferences->printPersonReferencesTableJS( '#ButtonPersonReferences' );
		print $loPersonPayments->printPersonPaymentsTableJS( '#ButtonPersonPayments' );
	?>
hotkeysDisabled = false;
$('input, textarea').focus(function(){hotkeysDisabled=true;}).blur(function(){hotkeysDisabled=false});

$(document).keypress(function (e) { 
     if(hotkeysDisabled)return true;    
     switch(e.which){
		case 1051:  
			closeAllWindow("sber");  
            $( "div.sber" ).toggle( "fast" );
			break;
		case 1040:
            closeAllWindow("adress");  
            $( "div.adress" ).toggle( "fast" );
			break;
		case 1042:
            closeAllWindow("war");  
            $( "div.war" ).toggle( "fast" );
			break;
		case 1063:
            closeAllWindow("chaes");  
            $( "div.chaes" ).toggle( "fast" );
			break;
 		case 1060:
            closeAllWindow("snils");  
            $( "div.snils" ).toggle( "fast" );
			break;
 		case 1086:
            closeAllWindow("doc");  
            $( "div.doc" ).toggle( "fast" );
			break;
		case  90, 1071: 
	        closeAllWindow("");
			break;
        //default:alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	}
    switch(e.keyCode){
		case 120:  
	        window.open('../../persons/raschet/<?php echo $model->id;?>', "raschet");
			break;
		case 27:  
	        closeAllWindow("");
			break;
	}
            
});
$(".war").load("<?php echo $_adddir;?>../war");
$(".post").load("<?php echo $_adddir;?>../postview");
$(".chaes").load("<?php echo $_adddir;?>../chaes");
$(".seniorities").load("<?php echo $_adddir;?>../seniorities/<?php echo $model->id;?>");
$(".dismiss").load("<?php echo $_adddir;?>../dismiss");
$("#pereraschet_div").load("<?php echo $_adddir;?>../pereraschet/<?php echo $model->id;?>");

$( "#pereraschet" ).click(function(event) {
	event.stopPropagation("pererast");
	$( "div.pererast" ).toggle( "fast" );
});

$( "#fdismiss" ).click(function() {
  closeAllWindow("dismiss");  
  $( "div.dismiss" ).toggle( "fast" );
});
$( "#stash" ).click(function(event) {
	event.stopPropagation();
  $( "div.adress" ).hide( "fast" );
});
$( "#f" ).click(function() {
  closeAllWindow("adress");  
  $( "div.adress" ).toggle( "fast" );
});

$( "#fwar" ).click(function() {
  closeAllWindow("war");  
  $( "div.war" ).toggle( "fast" );
});
$( "#fpost" ).click(function() {
  closeAllWindow("post");  
  $( "div.post" ).toggle( "fast" );
});
$( "#fchaes" ).click(function() {
  closeAllWindow("chaes");  
  $( "div.chaes" ).toggle( "fast" );
});
$( "#fsber" ).click(function() {
  closeAllWindow("sber");  
  $( "div.sber" ).toggle( "fast" );
});
$( "#fsnils" ).click(function() {
  closeAllWindow("snils");  
  $( "div.snils" ).toggle( "fast" );
});
$( "#fdoc" ).click(function() {
  closeAllWindow("doc");  
  $( "div.doc" ).toggle( "fast" );
});
$( "#fresolution" ).click(function() {
  closeAllWindow("resolution");  
  $( "div.resolution" ).toggle( "fast" );
});
$( "#fseniorities" ).click(function() {
  closeAllWindow("seniorities");  
  $( "div.seniorities" ).toggle( "fast" );
});

$( "#pererast_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.pererast" ).hide( "fast" );
});
$( "#pererast_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.pererast" ).hide();
});
$( "#doc_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.doc" ).hide( "fast" );
});
$( "#doc_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.doc" ).hide();
});
$( "#resolution_save" ).click(function(event) {
	event.stopPropagation();
	$("input[name='_form_ser_res']").attr("value",$("input[name='res_ser']").val());
	$("input[name='_form_res_number']").attr("value",$("input[name='res_number']").val());
	$("input[name='_form_sent_date']").attr("value",$("input[name='res_sent_date']").val());
	$("input[name='_form_begin_action_date']").attr("value",$("input[name='res_begin_action_date']").val());
	$("input[name='_form_end_action_date']").attr("value",$("input[name='res_end_action_date']").val());
  $( "div.resolution" ).hide( "fast" );
});
$( "#resolution_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.resolution" ).hide();
});

$( "#snils_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.snils" ).hide( "fast" );
});
$( "#snils_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.snils" ).hide();
});

$( "#sber_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.sber" ).hide( "fast" );
});
$( "#sber_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.sber" ).hide();
});
$( "#f_close" ).click(function(event) {
	event.stopPropagation();
});
$( "#raschet" ).click(function(event) {
	window.open('../../persons/raschet/<?php echo $model->id;?>', "raschet");
});
$( "#isch" ).click(function(event) {
	window.open('../../persons/isch/<?php echo $model->id;?>', "isch");
});
$( "#f_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.adress" ).hide( );
});
$("#pdelo").blur(function(event){
    $.ajax({
		url : '../casesNumberCheck',
		async : true,
		type : 'GET',
		data : {
			  	number:$("#pdelo").val(),
				id:<?php echo $model->id;?>,
		    },
		processData : true,
		contentType : 'application/x-www-form-urlencoded',
		dataType : 'json',
        success: function (data, textStatus) { 
		    if(data == 1)
				if(confirm("Такой номер пенсионного дела уже есть в базе.\n Введите другой номер."))$("#pdelo").focus();
            //$.each(data, function(i, val) {    alert($("#pdelo").val());
            //});
        }
    });        
});

function collectAddrInfo(){
	var index = $( "#index" ).val();
	var city = ($( "#city" ).val() ? " г." + $( "#city" ).val() : "" );
	var street = ( $( "#street" ).val() ?  " ул." + $( "#street" ).val() : "" );
	var home = ($( "#home" ).val() ? "д." + $( "#home" ).val() : "");
	var body = $( "#body" ).val() ?  "кор." + $( "#body" ).val() : "" ;
	var apartment = ($( "#apartment" ).val() ?  "кв." + $( "#apartment" ).val() : "");
	return index + " " + city + " " + street + " " + home + " " + body + " " + apartment;	
}
$( "#f_save" ).click(function(event) {
	event.stopPropagation();
  $( "#adress" ).val(collectAddrInfo());
  $( "div.adress" ).hide( "slow" );
});
function checkCardType(){
	var type = $("#_types").val();
	if(type == "ПК"){
		$("#dismiss").css("display","none");
		$("#death").css("display","");
	}else{
		$("#dismiss").css("display","");
		$("#death").css("display","none");
	}
	switch(type){
	case "ИН":$("#carthead").css("background","#00f");
		$("#carthead").css("color","yellow");
		$("#type_text").text("по инвалидности");
	break;
	case "ПК":$("#carthead").css("background","yellow");;
		$("#carthead").css("color","black");
		$("#type_text").text("по потере кормильца");
	break;
	case "ВЛ":$("#carthead").css("background","#800");
		$("#carthead").css("color","#fff");
		$("#type_text").text("за выслугу лет");
	break;
	case "ВВ":$("#carthead").css("background","#f50");
		$("#carthead").css("color","black");
		$("#type_text").text("возмещение вреда здоровью");
	break;
	case "СП":$("#carthead").css("background","#fff");
		$("#carthead").css("color","black");
		$("#type_text").text("социальное пособие");
	break;
	default:$("#carthead").css("background","#0f0");
		$$("#carthead").css("color","black");
		$("#type_text").text("");
	}	

}
$("#_types").change(function(event) {
    checkCardType();
});
checkCardType();	
/*	var type = $("#type").attr("val");
	if(type != "ПК")$("#death").css("display","none");
	if(type == "ПК")$("#dismiss").css("display","none");*/
    $( "#adress" ).val(collectAddrInfo());
	$(".input_disable input").attr("disabled","disabled");
	//closeAllWindow();
});
</script>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">

	<table><tr><td>	
	
	<table><tr id='type' val='<?php echo isSet($model->cases3->type) ? $model->cases3->type : "ВЛ";?>'>
	<td id='carthead' style=''>
	<?php echo $form->dropDownList($model,'type',Cases::getTypes(),array("id"=>"_types"));?>
	<?php echo isset($model->cases3->comm0->code) ? $model->cases3->comm0->code : "";?>-	
	<?php echo CHtml::textField("delo", isset($model->cases3->number) ? $model->cases3->number : "", array("size"=>6,"id"=>"pdelo")); ?>	
	<?php echo CHtml::dropDownList('_comm',$model->cases3->comm,Comms::getComms());?>
	<?php echo "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font id='type_text'></font>";?></td>
	<td width='25%' style='color:yellow'><font color='black'>=======</font>Изменено: <?php echo $model->cases3->date." ". $model->id;//echo Yii::app()->dateFormatter->format("dd-MM-y",$model->cases3->cor_date);?>
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
		<?php echo $form->textField($model,'post_full_name',array('size'=>120,'class'=>'text')); ?>
		<?php echo $form->error($model,'post_full_name'); ?>
	</td></tr></table>
	

	</td></tr>
	<tr><td>
	<table width=''><tr><td><nobr>
		<font style='color:black'><?php echo $form->labelEx($model,'birth_date'); ?></nobr>
	</td><td>	
		<?php //echo $form->textField($model,'birth_date'); ?>
		<?php 
					$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'birth_date',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11),
			));

		?>
		<?php echo $form->error($model,'birth_date'); ?>
		
		
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
					'mask' => '99.99.9999',
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'pension_date'); ?>
	</td></tr></table>
	</td></tr><tr><td>
			<font style='color:white' id='stash'>ВЫСЛУГА ЛЕТ на пенсию</font>
	</td>
	
	</tr>
	
	<tr>
	<td>
	<table><tr>
	<td  id='fseniorities'>ОБЩАЯ <input type='text' name='seniority_common' size='1' value='<?php echo isSet($seniority_common) ? $seniority_common : "";?>'></td>
	<td>календарная <input type='text' size='1' name='seniority_calendar' value='<?php echo isSet($seniority_calendar) ?$seniority_calendar: "";?>'></td>
	<td>учеба <input type='text' size='1' name='seniority_study' value='<?php echo isSet($seniority_study) ? $seniority_study: "";?>'></td>
	<td>льготная <input type='text' size='1' name='seniority_privilege' value='<?php echo isSet($seniority_privilege) ? $seniority_privilege : "";?>'></td>
	<td>в МВД <input type='text' size='1' name='seniority_mia' value='<?php echo isSet($seniority_mia) ? $seniority_mia: "" ;?>'></td>
	<td style='text-align:right;' width='40%'>
	<nobr>Тарифный разряд 
	<?php echo CHtml::dropDownList("code_tr",$model->cases3->code_tr,$model->trChanges);?>
	<?php //echo $form->textField($model,'post',array('size' => 1)); ?>
		<?php //echo $form->error($model,'post'); ?>
	<font id='fpost'>Катег.
	<?php echo CHtml::textField("post_inp", $model->getPostShotNames() ,array("id"=>"post_inp","size"=>10));?>
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
		<table style='border:3px solid #008'><tr>
		<td>
			ДО &nbsp;<?php echo $form->textField($model,'salary_post',array('id'=>'salary_post')); ?>
		<?php echo $form->error($model,'salary_post'); ?>
		</td>
		<td>	
			ОВЗ &nbsp;<?php echo $form->textField($model,'salary_rank',array('id'=>'salary_rank')); ?>
		<?php echo $form->error($model,'salary_rank'); ?>
		</td>
		<td>	
			ПНВЛ &nbsp;<?php echo $form->textField($model,'year_inc_percent',array('size'=>'1')); ?>%
		</td>
		<td width='40%' style='text-align:right;'>	
			Размер пенсии &nbsp;<?php echo $model->cases3->pension_percent; ?>%
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
<?php //echo $form->textField($model,'invalid_date'); ?>
		<?php 
		$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date',
					'mask' => '99.99.9999',
					//'charMap' => array('.'=>'[\.]' , ','=>'[,]'),
					'htmlOptions' => array('size' => 10, 'maxlength'=>11)
			));
		 ?>
		<?php echo $form->error($model,'invalid_date'); ?>
</td>
		<td><nobr>--</nobr></td>
		<td>		
<?php //echo $form->textField($model,'invalid_date'); ?>
		<?php 
		
		
		
		
		
			$this->widget('CMaskedTextField', array(
					'model' => $model,
					'attribute' => 'invalid_date2',
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
		<table><tr><td width='80%'><font style='color:#ffff00'>И</font><font style='color:#000080'>ждевенцы &nbsp;</font>
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
			</td><td><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
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