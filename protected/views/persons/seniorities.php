

<?php 

$out = array();
if($id){
    $content = Seniorities::model()->findAllByAttributes(array("person"=>$id));
	//var_dump($content);
	if(isset($content))
    foreach($content as $one){
	    if(!isset($out[$one->class]))$out[$one->class] = array();
	    $out[$one->class][$one->type] = $one->value;
    }
}
?>
<SCRIPT>

function countStash(){
    return Number($( "#calendar_y" ).val()) + Number($( "#privilege_y" ).val()) + Number($( "#study_y" ).val()) + Number($( "#mia_y" ).val())	
}
$( "#seniorities_save" ).click(function(event) {
	event.stopPropagation();
	$( "#common_y" ).attr( "value", countStash());
	$("input[name='seniority_common']").attr("value",countStash());
	$("input[name='seniority_calendar']").attr("value",$( "#calendar_y" ).val());
	$("input[name='seniority_study']").attr("value",$( "#study_y" ).val());
	$("input[name='seniority_privilege']").attr("value",$( "#privilege_y" ).val());
	$("input[name='seniority_mia']").attr("value",$( "#mia_y" ).val());
	hotkeysDisabled=false;
	$("#person").attr("seniority","");
	$( "div.seniorities" ).html("");
    $( "div.seniorities" ).hide( "fast" );
});
$( "#seniorities_close" ).click(function(event) {
	event.stopPropagation();
	hotkeysDisabled=false;
	$("#person").attr("seniority","");
	$( "div.seniorities" ).html("");

    $( "div.seniorities" ).hide();
   
});

$("#seniorities_count").click(function(event) {
	event.stopPropagation();
	senioritiesCount();
});
   $("div.seniorities").click(function(event) {
	//event.stopPropagation();
	//alert($( "#calendar_y" ).val() + $( "#privilege_y" ).attr( "value") + $( "#study_y" ).attr( "value") + $( "#mia_y" ).attr( "value") );
  $( "#common_y" ).attr( "value", countStash());
});</SCRIPT>
<table id='seniorities_card'>
<tr>
<td colspan='4' style='padding-top:2px;text-align:center;background:#800;color:#ff0;'>
<?php //echo $model->second_name." ".$model->first_name." ".$model->third_name;?>
</td>
</tr>
<tr>
<td  style='color:#338;'>Расчет выслуги лет на пенсию</td><td>лет</td><td>мес</td><td>дн</td>
</tr><tr>
<td>Календарный срок службы</td>
<td><?php  echo CHtml::textField("calendar_y", isset($out["calendar"]["y"]) ?  $out["calendar"]["y"] : 0, array("size"=>2,"id"=>"calendar_y"));?></td>
<td><?php  echo CHtml::textField("calendar_m", isset($out["calendar"]["m"]) ?  $out["calendar"]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("calendar_d", isset($out["calendar"]["d"]) ?  $out["calendar"]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Срок обучения, зачисляемый в выслугу</td>
<td><?php  echo CHtml::textField("study_y", isset($out["study"]["y"]) ?  $out["study"]["y"] : 0, array("size"=>2,"id"=>"study_y"));?></td>
<td><?php  echo CHtml::textField("study_m", isset($out["study"]["m"]) ?  $out["study"]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("study_d", isset($out["study"]["d"]) ?  $out["study"]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Срок, зачисляемый на льготных условиях</td>
<td><?php  echo CHtml::textField("privilege_y", isset($out["privilege"]["y"]) ?  $out["privilege"]["y"] : 0, array("size"=>2,"id"=>"privilege_y"));?></td>
<td><?php  echo CHtml::textField("privilege_m", isset($out["privilege"]["m"]) ?  $out["privilege"]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("privilege_d", isset($out["privilege"]["d"]) ?  $out["privilege"]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Выслуга лет в МВД</td>
<td><?php  echo CHtml::textField("mia_y", isset($out["mia"]["y"]) ?  $out["mia"]["y"] : 0, array("size"=>2,"id"=>"mia_y"));?></td>
<td><?php  echo CHtml::textField("mia_m", isset($out["mia"]["m"]) ?  $out["mia"]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("mia_d", isset($out["mia"]["d"]) ?  $out["mia"]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Выслуга лет, засчитываемая в ПНВЛ</td>
<td><?php  echo CHtml::textField("_y", isset($out[""]["y"]) ?  $out[""]["y"] : 0, array("size"=>2,"id"=>""));?></td>
<td><?php  echo CHtml::textField("_m", isset($out[""]["m"]) ?  $out[""]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("_d", isset($out[""]["d"]) ?  $out[""]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Количество полных лет выслуги на пенсию</td>
<td><?php  echo CHtml::textField("common_y", isset($out["common"]["y"]) ?  $out["common"]["y"] : 0, array("size"=>2,"id"=>"common_y"));?></td>
<td><?php  echo CHtml::textField("common_m", isset($out["common"]["m"]) ?  $out["common"]["m"] : 0, array("size"=>2));?></td>
<td><?php  echo CHtml::textField("common_d", isset($out["common"]["d"]) ?  $out["common"]["d"] : 0, array("size"=>2));?></td>
</tr><tr>
<td  >Процентная надбавка за выслугу лет</td>
</tr><tr>
<td></td>
</tr>
<tr>
		<td colspan='2' style='padding-top:6px;text-align:right;'><font id='seniorities_save' class='button'>OK</font>&nbsp;<font id='seniorities_close' class='button'>Отмена</font>&nbsp;<font id='seniorities_count' class='button'>Расчет</font>
		</td>
		</tr>
</table>