<style>
.servise_periods td{
	font-size:12px;
	border-bottom:1px dotted black;
	border-left:1px dotted black;
}
.servise_periods td.rights{
	border-right:1px dotted black;
	cursor:pointer;
}
th{
	font-size:14px;
	align:center;
}


</style>
<script>
$(".rights").click(function(){
	var container_id = $(this).parent().parent().parent().parent().prop("id");
	//alert(container_id);
    $.ajax({
		url : '../servicePeriodSave',
		async : true,
		type : 'GET',
		data : {
			  	id:$(this).parent().attr("id"),
				type:"delete",
		    },
		processData : true,
		contentType : 'application/x-www-form-urlencoded',
		dataType : 'json',
        success: function (data) { 
			if(data.status == "ok"){
				loadServicePeriods(container_id);
			}else if(data.status == "delete_error"){
				alert("ошибка удаления данных.");
			}
        }
    });        

});
function loadServicePeriods(klg){
	if(klg.indexOf("new_")>-1)klg = klg.substr(4);
	$("#"+klg).html("");
	$("#"+klg).load("../servicePeriodLoad?person="+$("#person").attr("number")+"&klg="+klg);
	
}
</script>
<?php 
$klg = array("new_calendar_container"=>"1","new_study_container"=>"3","calendar_container"=>"1","study_container"=>"3","new_lp_container"=>"2","lp_container"=>"2");


//echo $klg[$_GET["klg"]]." --- ";
//var_dump($_GET);die();
$model = ServicePeriods::model()->findAllByAttributes(array("person"=>$_GET["person"],"klg"=>$klg[$_GET["klg"]]));
?>
<table class='servise_periods'>
<thead>
<?php 
if($klg[$_GET["klg"]] == 2)echo "<th>ЛП</th>";
?>
<th>Период </th>
<th>Период по</th>
<th>ЛгРайПерД</th>
<th>Лет</th>
<th>Мес</th>
<th>Дн</th>
<th></th>
</thead>
<tr>
<?php
foreach($model as $one){
	$nvl = 1;
	$code = "";
	//echo $one["nvl"];	die();
	if($one["nvl"]>4){
		$klg = Klg::model()->findByPk($one["nvl"]);
		$nvl = $klg["nvl"];
		$code = $klg["code"];
	}
	echo "<tr id='".$one["id"]."'>";
	$a = ServicePeriods::datesCounting($one["begin_time"],$one["end_time"],$nvl);
	if($nvl>1)echo "<td>".$code."</td>";
	echo "<td class='date'>".Yii::app()->dateFormatter->format("dd.MM.y",$one["begin_time"])."</td>";
	echo "<td class='date'>".Yii::app()->dateFormatter->format("dd.MM.y",$one["end_time"])."</td>";
	echo "<td>".$one["name"]."</td>";
	echo "<td>".$a[0]."</td>";
	echo "<td>".$a[1]."</td>";
	echo "<td class=''>".$a[2]."</td>";
	echo "<td class='rights'>X</td>";
	echo "</tr>";
	
}
?>
</table>